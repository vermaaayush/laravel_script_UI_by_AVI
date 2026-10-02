<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
Use \Carbon\Carbon;
use Mail;
use App\BaAccountHolders;
use App\Ba_beneficiary;
use App\SmsEditor;
use App\EmailEditor;
use Illuminate\Support\Str;
use App\BaUserAccounts;


class Customer extends Controller
{
	public function __construct() {
	    $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
        $this->module = 'customer';
        

        $config = DB::select('select bank_email, bank_name, sms_token, sms_sid, sms_phone from configs where 1');
         $this->fromEmail = $config[0]->bank_email;

         $this->bankName = $config[0]->bank_name;

        $this->fromNumber = $config[0]->sms_phone;

        $this->accountSid = $config[0]->sms_sid;

        $this->authToken = $config[0]->sms_token;
      
        $this->env = 'live';
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $this->env = 'local';
        }
	}

    public function index() {
    	$branches = DB::select('select * from bank_details');
        $security_questions = DB::select('select * from ba_securityquestions');
        $ams = DB::select('select * from ba_am');
    	return view('add-customer', ['branches'=>$branches, 'security_questions'=>$security_questions, 'ams' => $ams, 'module' => $this->module]);
    }

     public function insertCustomer(Request $request) {
    	$allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp');
    	$destinationPath = 'uploads';

    	$fullname = $request->input('fullname');
        $fullnamearr = explode(" ", $fullname);
        $cust_name = '';
        $middle_name = '';
        $sur_name = '';
        
        if(isset($fullnamearr[0]) && !empty($fullnamearr[0])){
            $cust_name = $fullnamearr[0];
        }
        if(isset($fullnamearr[1]) && !empty($fullnamearr[1])){
            $middle_name = $fullnamearr[1];
        }
        if(isset($fullnamearr[2]) && !empty($fullnamearr[2])){
            $sur_name = $fullnamearr[2];
        }
        
        $idnumber = $request->input('idnumber');
        $dob = $request->input('dob');
        $mother_maiden = $request->input('mother_maiden');
        $cust_mail = $request->input('email');
        $cust_city = $request->input('city');
        $cust_state = $request->input('state');
        $cust_address = $request->input('address');
        $cust_country = $request->input('country');
        $post_code = $request->input('zip');
       
        $cust_countrycode = $request->input('code');
        $cust_phone = $request->input('phone');
        $qid = $request->input('security_ques1');
        $ans = $request->input('answer1');
        $qid2 = $request->input('security_ques2');
        $ans2 = $request->input('answer2');
        $am = $request->input('am');

    	if(!empty($fullname) && !empty($dob) && !empty($mother_maiden) && !empty($cust_mail) && !empty($cust_address) && !empty($cust_city) && !empty($cust_state) && !empty($cust_country) && !empty($post_code)  && !empty($cust_countrycode) && !empty($cust_phone) && !empty($qid) && !empty($ans) && !empty($qid2) && !empty($ans2)) {
    		$profile = $request->file('profile');
    		if(!empty($profile) && !empty($profile_path = $profile->getRealPath()) && !empty($profile_name = $profile->getClientOriginalName())) {
    			$profile_ext = $profile->getClientOriginalExtension();
		      	$profile_type = $profile->getMimeType();

		      	if(!in_array($profile_type, $allowed_types)) {
		      		flash('Please upload allowed file type in Profile Picture')->error();
    				return redirect()->intended('add-customer');
		      	}
    		}

    		$national_id = $request->file('national_id');
    		if(!empty($national_id) && !empty($national_id_path = $national_id->getRealPath()) && !empty($national_id_name = $national_id->getClientOriginalName())) {
    			$national_id_ext = $national_id->getClientOriginalExtension();
		      	$national_id_type = $national_id->getMimeType();

		      	if(!in_array($national_id_type, $allowed_types)) {
		      		flash('Please upload allowed file type in Valid Government issued Identification')->error();
    				return redirect()->intended('add-customer');
		      	}
    		}

            $verification_document = $request->file('verification_document');
            if(!empty($verification_document) && !empty($national_id_path = $verification_document->getRealPath()) && !empty($verification_document_name = $verification_document->getClientOriginalName())) {
                $verification_document_ext = $verification_document->getClientOriginalExtension();
                $verification_document_type = $verification_document->getMimeType();

                if(!in_array($national_id_type, $allowed_types)) {
                    flash('Please upload allowed file type in Data Verification')->error();
                    return redirect()->intended('add-customer');
                }
            }

            if(!empty($profile_name)) {
                $profile_name = md5(time()).$profile_name;
                $profile->move($destinationPath,$profile_name);
            }
            else {
                $profile_name = '';
            }

            if(!empty($national_id_name)) {
                $national_id_name = md5(time()).$national_id_name;
                $national_id->move($destinationPath,$national_id_name);
            }
            else {
                $national_id_name = '';
            }

            if(!empty($verification_document_name)) {
                $verification_document_name = md5(time()).$verification_document_name;
                $verification_document->move($destinationPath,$verification_document_name);
            }
            else {
                $verification_document_name = '';
            }
            
                $max_amount = $request->input('max_amount');
                
             if(isset($max_amount)) {
                $max_amount = $request->input('max_amount');
                
            }else{
                $max_amount = "0";
            }

            $user_id = time();
            $customer_id = $this->getCustomerID();
            $cust_password = $this->getCustomerPassword();

    		DB::insert('insert into ba_account_holders (cust_name,middle_name,sur_name,idnumber,dob,mother_maiden,cust_mail,cust_city,cust_state,cust_address,cust_country,post_code,max_amount,cust_countrycode,cust_phone,qid,ans,qid2,ans2,am,cust_photo,cust_natioanl_id,verification_document,user_id,customer_id,cust_password,account_status,verification) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$cust_name,$middle_name,$sur_name,$idnumber,$dob,$mother_maiden,$cust_mail,$cust_city,$cust_state,$cust_address,$cust_country,$post_code,$max_amount,$cust_countrycode,$cust_phone,$qid,$ans,$qid2,$ans2,$am,$profile_name,$national_id_name,$verification_document_name,$user_id,$customer_id,$cust_password,0,1]);
    		$cus = DB::table('ba_account_holders')->orderby('id', 'desc')->first();
    		
    // 		$config = DB::select('select * from configs WHERE id = ?',[1]);
    // 		$EmailEditor = EmailEditor::where('type', 'account_opening_approval')->first();
    //         $verification_email = $EmailEditor->verification;
    //         $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$cus->id]);
    //         $SmsEditor = SmsEditor::where('type', 'account_opening_approval')->first(); 
    //         $verification = $SmsEditor->verification;
    //         $sms = $SmsEditor->sms;
    //         $null = '';
    //         $myString = $sms;
    //           //  sms replacing
    //         $final_sms = str_replace('[first_name]', $customer[0]->cust_name, $sms);
    //         $final_sms = str_replace('[bank_name]',$config[0]->bank_name, $final_sms);
    //         $final_sms = str_replace('[user_id]', $customer[0]->user_id, $final_sms);
    //         $final_sms = str_replace('[customer_id]', $customer[0]->customer_id, $final_sms);
    //         $final_sms = str_replace('[last_name]', $customer[0]->sur_name, $final_sms);
    //         $final_sms = str_replace('[password]', $cust_password, $final_sms);
           
    //         if(isset($myString)) { 
    //             $contains = Str::contains($myString, ['[address]','[phone]' ]);
    //             if($contains) {
                
    //             $final_sms = str_replace('[address]', $customer[0]->cust_address, $final_sms);
    //             $phone = $customer[0]->cust_countrycode . " " . $customer[0]->cust_phone;
    //             $final_sms = str_replace('[phone]', $phone, $final_sms);
               
    //             }
    //         }
            
    //         if( $this->env == 'live' && $customer[0]->cust_countrycode && $customer[0]->cust_phone) {
    //             $client = new Client($this->accountSid, $this->authToken);
    //             $recipients_arr = array($customer[0]->cust_countrycode . " " . $customer[0]->cust_phone);
                
    //             $msg = $final_sms;
    //             //email and sms sending
    //             if ($verification == 1) {
    //                 foreach($recipients_arr as $recipient) {
                    
    //                 $client->messages->create($recipient, 
    //                 ['from' => $this->fromNumber, 'body' => $msg] );
    //                 }
    //             }
    //         }
            
    // 		if($verification_email == 1) {
    //             $phone = $customer[0]->cust_countrycode . " " . $customer[0]->cust_phone;
    //             $data = array('user'=>$customer[0]->cust_name,'last_name'=>$customer[0]->sur_name,'phone'=>$phone,
    //             'address'=>$customer[0]->cust_address,'user_id'=>$user_id,
    //             'mail'=>$customer[0]->cust_mail,'password'=>$customer[0]->cust_password, 'customer_id'=>$customer[0]->customer_id,
    //             'user_id'=>$customer[0]->user_id,
    //             'bank_name'=>$config[0]->bank_name,
    //             'bank_support_person'=>$config[0]->bank_support_person,
    //             'bank_phone'=>$config[0]->bank_phone,'bank_fax'=>$config[0]->bank_fax );   
                
    //             $this->dynamic_email_without_token($data, $EmailEditor->email, $EmailEditor->name,$customer[0]->cust_mail, $config[0]->bank_email);
    //         }
    		
    		
    		flash('Customer added successfully!')->success();
    		return redirect()->intended('view-customers');
    	}
        else {
        	flash('Please fill all the required fields')->error();
    		return redirect()->intended('add-customer');
        }
    }

    public function getCustomerID() {
        return $customerID = $this->getRandom(7);
    }

    public function getCustomerPassword() {
        return $customerID = $this->getRandom(5);
    }

    public function getRandom($digits) {
        if($digits == 7) {
            $rand = rand(1000000, 9999999);
            $check = $this->checkCustomerID($rand);

            if($check) {
                return $rand;
            }
            else {
                getRandom(7);
            }
        }
        elseif($digits == 5) {
            $rand = rand(10000, 99999);

            $check = $this->checkCustomerPassword($rand);

            if($check) {
                return $rand;
            }
            else {
                getRandom(5);
            }
        }
    }  

    public function checkCustomerID($rand) {
        $customers = DB::select('select count(*) as cnt from ba_account_holders WHERE customer_id = ?', [$rand]);
        if($customers[0]->cnt == 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function checkCustomerPassword($rand) {
        $customers = DB::select('select count(*) as cnt from ba_account_holders WHERE cust_password = ?', [$rand]);
        if($customers[0]->cnt == 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function viewCustomers() {
    	$customers = DB::select('select * from ba_account_holders where df = "no" order by id desc');
    	return view('view-customers', ['customers'=>$customers, 'module' => $this->module]);
    }

    public function editCustomer(Request $request, $id) {
    	$customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        $ams = DB::select('select * from ba_am');
    	return view('edit-customer', ['customer'=>$customer, 'ams' => $ams, 'module' => $this->module]);
    }

    public function viewCustomer(Request $request, $id) {
        $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        $am = array();
        if($customer[0]->am != '') {
            $am = DB::select('select * from ba_am WHERE id = ?',[$customer[0]->am]);
        }
        return view('view-customer', ['customer'=>$customer, 'am' => $am, 'module' => $this->module]);
    }

    public function updateCustomer(Request $request) {
        $allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp');
        $destinationPath = 'uploads';

        $id = $request->input('id');
        $fullname = $request->input('fullname');
        $fullnamearr = explode(" ", $fullname);
        $cust_name = '';
        $middle_name = '';
        $sur_name = '';
        if(isset($fullnamearr[0]) && !empty($fullnamearr[0])){
            $cust_name = $fullnamearr[0];
        }
        if(isset($fullnamearr[1]) && !empty($fullnamearr[1])){
            $middle_name = $fullnamearr[1];
        }
        if(isset($fullnamearr[2]) && !empty($fullnamearr[2])){
            $sur_name = $fullnamearr[2];
        }
        $customer_id = $request->input('customer_id');
        $cust_password = $request->input('password');
        $cust_mail = $request->input('email');
        $cust_phone = $request->input('phone');
        $btc_fund = $request->input('btc_fund');
        $usdt_fund = $request->input('usdt_fund');
        $eth_fund = $request->input('eth_fund');
        $dob = $request->input('dob');
        $cust_address = $request->input('address');
        $cust_country = $request->input('country');
        $am = $request->input('am');
         $max_amount = $request->input('max_amount');
        $trans_status = $request->input('trans_status'); 
        $no_transfer_msg = $request->input('no_transfer_msg');
        $profile_name = '';

        if(!empty($id) && !empty($customer_id) && !empty($cust_password)   && !empty($cust_mail) && !empty($cust_phone) && !empty($dob) && !empty($cust_address)) {
            $customers = DB::select('select count(*) as cnt from ba_account_holders WHERE customer_id = ? && id != ?',[$customer_id,$id]);
        
            if($customers[0]->cnt != 0) {
                flash('Invalid Login ID')->error();
                return redirect()->intended('edit-customer/' . $id);
            }

            $profile = $request->file('profile');
            if(!empty($profile) && !empty($profile_path = $profile->getRealPath()) && !empty($profile_name = $profile->getClientOriginalName())) {
                $profile_ext = $profile->getClientOriginalExtension();
                $profile_type = $profile->getMimeType();

                if(!in_array($profile_type, $allowed_types)) {
                    flash('Please upload allowed file type in Profile Picture')->error();
                    return redirect()->intended('add-customer');
                }

                $profile_name = md5(microtime()).'.'.$profile_ext;
                $profile->move($destinationPath,$profile_name);
            }

            if(!empty($profile_name)) {
                DB::update('update ba_account_holders SET cust_name = ?, middle_name = ?, sur_name = ?, customer_id = ?, cust_password = ?, cust_mail = ?, cust_phone = ?, transfer_control = ?, status_message = ?, dob = ?, cust_address = ?, cust_country = ?, max_amount = ?, am = ?, ans = ?, ans2 = ?, cust_photo = ?, btc_fund = ?, eth_fund = ?, usdt_fund = ? WHERE id = ?',[$cust_name,$middle_name,$sur_name,$customer_id,$cust_password,$cust_mail,$cust_phone,$trans_status,$no_transfer_msg,$dob,$cust_address,$cust_country,$max_amount,$am,$request->input('ans1'),$request->input('ans2'),$profile_name,$btc_fund,$eth_fund,$usdt_fund,$id]);
            }
            else {
                DB::update('update ba_account_holders SET cust_name = ?, middle_name = ?, sur_name = ?, customer_id = ?, cust_password = ?, cust_mail = ?, cust_phone = ?, transfer_control = ?, status_message = ?, dob = ?, cust_address = ?, cust_country = ?,max_amount = ?, am = ?,ans = ?,ans2 = ?, btc_fund = ?, eth_fund = ?, usdt_fund = ? WHERE id = ?',[$cust_name,$middle_name,$sur_name,$customer_id,$cust_password,$cust_mail,$cust_phone,$trans_status,$no_transfer_msg,$dob,$cust_address,$cust_country,$max_amount,$am,$request->input('ans1'),$request->input('ans2'),$btc_fund,$eth_fund,$usdt_fund,$id]);
            }
            flash('Customer updated successfully!')->success();
            return redirect()->intended('view-customers');
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('edit-customer/' . $id);
        }
    }

    public function deleteCustomer(Request $request, $id) {
         
        $checks = BaAccountHolders::where('id', $id)->first();
        if ($checks) {
            $final = $checks->user_id;
            DB::table('ba_user_accounts')->where('user_id',$final)->update(['access' => '3']);
            
            $new_email = $checks->cust_mail;
            if (!empty($new_email) && strpos($new_email, '_deleted_') === false) {
                $new_email = $new_email . '_deleted_' . time();
            }

            DB::table('ba_account_holders')->where('id',$id)->update([
                'df' => 'yes',
                'cust_mail' => $new_email
            ]);
        }

        flash('Customer deleted successfully')->success();
        return redirect()->intended('view-customers');
    }

    public function approveAccess(Request $request, $id) {
        
        $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        
        if($customer[0]->user_id == '' || $customer[0]->customer_id == '' || $customer[0]->cust_password == '') {
            $user_id = time();
            $customer_id = $this->getCustomerID();
           
            DB::update('update ba_account_holders set user_id = ?, customer_id = ?, cust_password = ? WHERE id = ?',[$user_id, $customer_id, $cust_password, $id]);
            
            $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        }
         $cust_password = $customer[0]->cust_password;
            
        $user_id = $customer[0]->user_id;
        $cutsomer_account_info = DB::select('select * from ba_user_accounts WHERE user_id = ?',[$user_id]);
       
            //load configuations
        $config = DB::select('select * from configs WHERE id = ?',[1]);
            //email data
        $EmailEditor = EmailEditor::where('type', 'account_opening_approval')->first();
        
        $verification_email = $EmailEditor->verification;
            /*sms data*/
        $SmsEditor = SmsEditor::where('type', 'account_opening_approval')->first(); 
        $verification = $SmsEditor->verification;
        $sms = $SmsEditor->sms;
        $null = '';
        $myString = $sms;
          //  sms replacing
        $final_sms = str_replace('[first_name]', $customer[0]->cust_name, $sms);
        $final_sms = str_replace('[bank_name]',$config[0]->bank_name, $final_sms);
        $final_sms = str_replace('[user_id]', $customer[0]->user_id, $final_sms);
        $final_sms = str_replace('[customer_id]', $customer[0]->customer_id, $final_sms);
        $final_sms = str_replace('[last_name]', $customer[0]->sur_name, $final_sms);
        $final_sms = str_replace('[password]', $cust_password, $final_sms);
       
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            
            $final_sms = str_replace('[address]', $customer[0]->cust_address, $final_sms);
            $phone = $customer[0]->cust_countrycode . " " . $customer[0]->cust_phone;
            $final_sms = str_replace('[phone]', $phone, $final_sms);
           
            }
        }
        
        if(isset($cutsomer_account_info[0]->account_no)){
            
            $cutsomer_account_info = $cutsomer_account_info[0]->account_no;
            $accounts_type = BaUserAccounts::where('user_id', $user_id)->where('account_no', $cutsomer_account_info)->first();
            $final_sms = str_replace('[account_no]', $cutsomer_account_info, $final_sms);
            $cutsomer_account_type = $accounts_type->account_type;
            $final_sms = str_replace('[account_type]', $cutsomer_account_type, $final_sms);
           }
            
           
           
        if(isset($cutsomer_account_info[0]->account_no)){ 
          
           }
           
        
        if( $this->env == 'live' && $customer[0]->cust_countrycode && $customer[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($customer[0]->cust_countrycode . " " . $customer[0]->cust_phone);
            
            $msg = $final_sms;
            //email and sms sending
            
            try {
              //code...
                if ($verification == 1) {
                    foreach($recipients_arr as $recipient) {
                        $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg] );
                    }
                }    
             } 
            catch (\Throwable $th) {
                 /* flash("Phone number is not valid or Twilio can't send a message to this phone number")->error();
                 return redirect('/view-customers'); */
            }
            
             /*
            if ($verification == 1) {
                foreach($recipients_arr as $recipient) {
                
                $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg] );
                
                    
            }
            }
            
            */
            if($verification_email == 1) {
                $phone = $customer[0]->cust_countrycode . " " . $customer[0]->cust_phone;
                $data = array('user'=>$customer[0]->cust_name,'last_name'=>$customer[0]->sur_name,'phone'=>$phone,
                'address'=>$customer[0]->cust_address,'user_id'=>$user_id,
                'mail'=>$customer[0]->cust_mail,'password'=>$customer[0]->cust_password, 'customer_id'=>$customer[0]->customer_id,
                'user_id'=>$customer[0]->user_id,
                'bank_name'=>$config[0]->bank_name,
                'bank_support_person'=>$config[0]->bank_support_person,
                'bank_phone'=>$config[0]->bank_phone,'bank_fax'=>$config[0]->bank_fax );   
                
                $this->dynamic_email_without_token($data, $EmailEditor->email, $EmailEditor->name,$customer[0]->cust_mail, $config[0]->bank_email);
            }
        
        }
        
        $customer = DB::update('update ba_account_holders set account_status = 1 WHERE id = ?',[$id]);
        
        flash('Customer approved successfully')->success();
        return redirect()->intended('view-customers');
        }
        

     public function dynamic_email_without_token($data, $message, $subject, $to_email, $from_email) {
            $config = DB::select('select * from configs WHERE id = ?',[1]);
            
            if(isset($data['user_id'])){
                $user_id = $data['user_id'];
            }  
            $cutsomer_account_info = DB::select('select * from ba_user_accounts WHERE user_id = ?',[$user_id]);
            
            if(isset($cutsomer_account_info[0]->account_no)){
                $act_num = $cutsomer_account_info[0]->account_no;
                $message = str_replace('[account_no]',  $act_num, $message);
            }
            if(isset($cutsomer_account_info[0]->account_type)){
                $account_type = $cutsomer_account_info[0]->account_type;
                $message = str_replace('[account_type]',  $account_type, $message);
            }
            
            if(isset($data['user'])){
                $customername = $data['user'];
            }
            if(isset($data['last_name'])){
                $last_name = $data['last_name'];
            }
            
                      if (!empty($customername)) {
    $message = str_replace('[first_name]', $customername, $message);
}

if (!empty($last_name)) {
    $message = str_replace('[last_name]', $last_name, $message);
} else {
    // remove the placeholder completely if last name is missing
    $message = str_replace('[last_name]', '', $message);
}
            
            if(isset($data['password'])){
                $message = str_replace('[password]', $data['password'], $message);
            }
            
            if(isset($data['customer_id'])){
                $message = str_replace('[customer_id]',$data['customer_id'],$message);
            }
            if(isset($data['address'])){
                $message = str_replace('[address]',$data['address'],$message);
            }
            if(isset($data['user_id'])){
                $message = str_replace('[user_id]',$data['user_id'],$message);
            }
             if(isset($data['phone'])){
                $message = str_replace('[phone]',$data['phone'],$message);
            }
            
            if(isset($data['account_no'])){
                $message = str_replace('[account_no]',$data['account_no'], $message);
            }
            if(isset($data['bank_name'])){
                $message = str_replace('[bank_name]',$data['bank_name'],$message);
            }
            if(isset($data['bank_support_person'])){
                $message = str_replace('[bank_support_person]',$data['bank_support_person'], $message);
            }
            if(isset($data['bank_fax'])){
                $message = str_replace('[bank_fax]',$data['bank_fax'],$message);
            }
            if(isset($data['bank_phone'])){
                $message = str_replace('[bank_phone]',$data['bank_phone'],$message);
            }
            
            $logo_link ="https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
            $finals_message = '<span class="imeg">' .'<img src='.$logo_link.' alt="banking" style="display:block;margin-left:780px;width:14%;" />' .'</span>';
            
            $finals_message .= '<p style="position: relative;top: 136px;">' . $message . '</p>';  
            
            $finals_message .= '<p>
            Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
            If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
            
            $body = "<html><head></head><body>";
            $body .= $finals_message ; 
            $body .= "</body></html>";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            
            $headers[] = 'From: ' . $this->bankName . ' <'.$from_email.'>';
            
            Mail::send([], [], function ($message) use ($to_email, $subject, $body) {
    $message->to($to_email)
            ->subject($subject)
            ->setBody($body, 'text/html');
});

    }

    public function denyAccess(Request $request, $final) {
        
         $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$final]);

         $config = DB::select('select * from configs WHERE id = ?',[1]);
          //  email data
         $EmailEditor = EmailEditor::where('type', 'registration_denied')->first();
         $verification_email = $EmailEditor->verification;
            // sms data
         $SmsEditor = SmsEditor::where('type', 'registration_denied')->first(); 
         $verification = $SmsEditor->verification;
         $sms = $SmsEditor->sms;
         $phone = $customer[0]->cust_countrycode . " " . $customer[0]->cust_phone;
            // sms replacing
        $final_sms = str_replace('[first_name]', $customer[0]->cust_name, $sms);
        
        $myString = $sms;
       
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[user_id]','[address]','[phone]' ]);
              if($contains) {
                   $final_sms = str_replace('[user_id]', $customer[0]->user_id, $final_sms);
                   $final_sms = str_replace('[address]', $customer[0]->cust_address, $final_sms);
                   $final_sms = str_replace('[phone]', $phone, $final_sms);
              }
        }
        
        // email and sms sending
        if( $this->env == 'live' && $customer[0]->cust_countrycode && $customer[0]->cust_phone) {
        $client = new Client($this->accountSid, $this->authToken);
        $recipients_arr = array($customer[0]->cust_countrycode . " " . $customer[0]->cust_phone);
        
        $msg = $final_sms;
        
        if ($verification == 1) {
            foreach($recipients_arr as $recipient) {
            
            $client->messages->create($recipient, 
            ['from' => $this->fromNumber, 'body' => $msg] );
            }
        }
        if($verification_email == 1) {
        
            $data = array('user'=>$customer[0]->cust_name,'user_id'=>$customer[0]->user_id,
            'phone'=>$phone,'mail'=>$customer[0]->cust_mail,'address'=>$customer[0]->cust_address);   
            
            $this->dynamic_email_without_token($data, $EmailEditor->email, $EmailEditor->email,$customer[0]->cust_mail, $config[0]->bank_email);
        }
        
        }
        
        //tables that contains user_id will del
        $ba_beneficiary = DB::delete('delete from ba_beneficiary WHERE beneficiary_added_by_user_id = ?',[$final]);
        $ba_cards = DB::delete('delete from ba_cards WHERE user_id = ?',[$final]);
        $ba_check_book = DB::delete('delete from ba_check_book WHERE user_id = ?',[$final]);
        $ba_limits = DB::delete('delete from ba_limits WHERE user_id = ?',[$final]);
        $ba_loans = DB::delete('delete from ba_loans WHERE user_id = ?',[$final]);
        $ba_options = DB::delete('delete from ba_options WHERE user_id = ?',[$final]);
        $ba_queries = DB::delete('delete from ba_queries WHERE user_id = ?',[$final]);
        $ba_stop_cheque = DB::delete('delete from ba_stop_cheque WHERE user_id = ?',[$final]);
        $ba_token = DB::delete('delete from ba_token WHERE user_id = ?',[$final]);
        $ba_transactions = DB::delete('delete from ba_transactions WHERE user_id = ?',[$final]);
        $ba_user_accounts = DB::delete('delete from ba_user_accounts WHERE user_id = ?',[$final]);
        $ivr_acccount_msg = DB::delete('delete from ivr_acccount_msg WHERE user_id = ?',[$final]);
        $ivr_tokens = DB::delete('delete from ivr_tokens WHERE user_id = ?',[$final]);
        $msg = DB::delete('delete from msg WHERE user_id = ?',[$final]);
        $user_withdrawls = DB::delete('delete from ba_token WHERE user_id = ?',[$final]);
        $ba_token = DB::delete('delete from ba_token WHERE user_id = ?',[$final]);
        $ba_token = DB::delete('delete from ba_token WHERE user_id = ?',[$final]);
        $customer = DB::delete('delete from ba_account_holders WHERE id = ?',[$final]);
        
        flash('Customer denied successfully')->success();
        return redirect()->intended('view-customers');
    }

    public function suspendAccess(Request $request, $id) {
        $customer = DB::update('update ba_account_holders SET account_status = 2 WHERE id = ?',[$id]);
        flash('Customer suspended successfully')->success();
        return redirect()->intended('view-customers');
    }
    public function blockaccess(Request $request, $id) {
        $customer = DB::update('update ba_account_holders SET account_status = 3 WHERE id = ?',[$id]);
        flash('Customer Blocked successfully')->success();
        return redirect()->intended('view-customers');
    }
     public function temporaryaccess(Request $request, $id) {
        $customer = DB::update('update ba_account_holders SET account_status = 4 WHERE id = ?',[$id]);
        flash('Customer Temporary Restricted successfully')->success();
        return redirect()->intended('view-customers');
    }

    public function activateAccess(Request $request, $id) {
        $customer = DB::update('update ba_account_holders SET account_status = 1 WHERE id = ?',[$id]);
        flash('Customer activated successfully')->success();
        return redirect()->intended('view-customers');
    }

    public function addAccount(Request $request, $id) {
        $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        $branches = DB::select('select * from bank_details');
        $acc_types = DB::select('select * from account_type');
        $currencies = DB::select('select * from currencies');
        
        $user_account = DB::table('ba_user_accounts')->where('user_id', $customer[0]->user_id ?? '')->first();
        $customer_currency = $user_account->account_currency ?? '';
        $customer_acc_type = $user_account->account_type ?? '';

        return view('add-account', [
            'customer' => $customer, 
            'branches' => $branches, 
            'acc_types' => $acc_types, 
            'currencies' => $currencies, 
            'customer_currency' => $customer_currency,
            'customer_acc_type' => $customer_acc_type,
            'module' => $this->module
        ]);
    }

    public function insertAccount(Request $request) {
        $request->validate([
            'account_no' => 'required|unique:ba_user_accounts|max:255',
        ]);
      
      
        $xx = $request->input('account_currency');
        $c_n = DB::table('currencies')->where('currency', $xx)->value('currency_name');

      

        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $account_no = $request->input('account_no');
        $account_no = $request->input('account_no');
        $account_title = $request->input('account_title');
        $bank = $request->input('branch');
        $account_type = $request->input('acc_type');
        $account_currency = $request->input('account_currency');
        $currency_name= $c_n;
        $available_balance = $request->input('available_balance');
        $available_balance = preg_replace('/[^0-9\.]/ui','',$available_balance);
        $ledge_balance = $request->input('ledge_balance');
        $ledge_balance = preg_replace('/[^0-9\.]/ui','',$ledge_balance);
        
        // if(!empty($user_id) && !empty($account_no) && !empty($account_title) && !empty($bank) && !empty($account_type) && !empty($available_balance)) {
        if(!empty($user_id) && !empty($account_no) && !empty($account_title) && !empty($bank) && !empty($account_type) && $available_balance != "") {

            
            DB::insert('insert into ba_user_accounts (user_id,account_no,bank,account_title,account_type,account_currency,currency_name,available_balance,ledge_balance) values(?,?,?,?,?,?,?,?,?)',[$user_id,$account_no,$bank,$account_title,$account_type,$account_currency,$currency_name,$available_balance,$ledge_balance]);
            flash('Account added successfully!')->success();
            return redirect()->intended('view-accounts/' . $id);

        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('add-account/' . $id);
        }
    }

    public function viewAccounts(Request $request, $id) {
        $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        $accounts = DB::select('select ba_user_accounts.*,bank_details.branch_name from ba_user_accounts INNER JOIN bank_details ON ba_user_accounts.bank=bank_details.id WHERE user_id = ?',[$customer[0]->user_id]);
        return view('view-accounts', ['customer'=>$customer, 'accounts' => $accounts, 'module' => $this->module]);
    }

    public function editAccount(Request $request, $id) {
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        $branches = DB::select('select * from bank_details');
        $acc_types = DB::select('select * from account_type');
        $currencies = DB::select('select * from currencies');
        return view('edit-account', ['customer'=>$customer, 'account' => $account, 'branches' => $branches, 'acc_types' => $acc_types, 'currencies' => $currencies, 'module' => $this->module]);
    }

    public function updateAccount(Request $request) {
        $customer_id = $request->input('customer_id');
        $id = $request->input('id');
        $account_no = $request->input('account_no');
        $account_title = $request->input('account_title');
        $bank = $request->input('branch');
        $account_type = $request->input('acc_type');
        $account_currency = $request->input('account_currency');
        $available_balance = $request->input('available_balance');
        $ledge_balance = $request->input('ledge_balance');

        if(!empty($id) && !empty($account_no) && !empty($account_title) && !empty($bank) && !empty($account_type) && !empty($available_balance)) {
            DB::update('update ba_user_accounts SET account_no = ?, bank = ?, account_title = ?, account_type = ?, account_currency = ?, available_balance = ?, ledge_balance = ? WHERE id = ?',[$account_no,$bank,$account_title,$account_type,$account_currency,$available_balance,$ledge_balance,$id]);
            flash('Account updated successfully!')->success();
            return redirect()->intended('view-accounts/' . $customer_id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('edit-account/' . $id);
        }
    }

    public function viewAccount(Request $request, $id) {
        $account = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts INNER JOIN bank_details ON ba_user_accounts.bank=bank_details.id WHERE ba_user_accounts.id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        return view('view-account', ['customer'=>$customer, 'account' => $account, 'module' => $this->module]);
    }

    public function deleteAccount(Request $request, $id, $customer_id) {
        $account = DB::delete('delete from ba_user_accounts WHERE id = ?',[$id]);
        flash('Account deleted successfully')->success();
        return redirect()->intended('view-accounts/' . $customer_id);
    }

    public function suspendAccount(Request $request, $id, $customer_id) {
        $customer = DB::update('update ba_user_accounts SET access = 3 WHERE id = ?',[$id]);
        flash('Account suspended successfully')->success();
        return redirect()->intended('view-accounts/' . $customer_id);
    }
    public function block_single_account(Request $request, $id, $customer_id) {
        $customer = DB::update('update ba_user_accounts SET access = 2 WHERE id = ?',[$id]);
        flash('Account Blocked successfully')->success();
        return redirect()->intended('view-accounts/' . $customer_id);
    }
    public function temporarysingle_suspendAccount(Request $request, $id, $customer_id) {
        $customer = DB::update('update ba_user_accounts SET access = 4 WHERE id = ?',[$id]);
        flash('Account Temporary Suspended successfully')->success();
        return redirect()->intended('view-accounts/' . $customer_id);
    }

    public function activateAccount(Request $request, $id, $customer_id) {
        $customer = DB::update('update ba_user_accounts SET access = 1 WHERE id = ?',[$id]);
        flash('Account activated successfully')->success();
        return redirect()->intended('view-accounts/' . $customer_id);
    }

    public function showAccount(Request $request, $id, $customer_id) {
        $customer = DB::update('update ba_user_accounts SET hidden = 0 WHERE id = ?',[$id]);
        flash('Account show successfully')->success();
        return redirect()->intended('view-accounts/' . $customer_id);
    }

    public function hideAccount(Request $request, $id, $customer_id) {
        $customer = DB::update('update ba_user_accounts SET hidden = 1 WHERE id = ?',[$id]);
        flash('Account hide successfully')->success();
        return redirect()->intended('view-accounts/' . $customer_id);
    }

    public function addDeposit(Request $request, $id) {
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        return view('add-deposit', ['account' => $account, 'customer' => $customer, 'module' => $this->module]);
    }

    public function insertDeposit(Request $request) {
        // dd($request);
        $id = $request->input('id');
        $act_number = $request->input('act_number');
        $tran_date = $request->input('tran_date');
        $tran_time = $request->input('tran_time');
        $reason = $request->input('reason');
        $depositor_name = $request->input('depositor_name');
        $type = 'credited';
        $balance = $request->input('balance');
        $balance = (float)preg_replace('/[^0-9\.]/ui','',$balance);
        $amount = $request->input('amount');
        $amount = (float)preg_replace('/[^0-9\.]/ui','',$amount);
        $balance_type = $request->input('balance_type');
        $statement = $request->input('statement');
        if(!$statement) {
            $statement = 0;
        }
        $tran_id = md5(time());
        $datetime = date("Y-m-d", strtotime($tran_date)) . " " . $tran_time;

        if(!empty($tran_date) && !empty($tran_time) && !empty($act_number) && !empty($reason) && !empty($depositor_name) && $amount!="" && !empty($balance_type) && !empty($tran_id)) {
            $account = DB::select('select * from ba_user_accounts where id = ?', [$id]);

            DB::insert('insert into ba_transactions SET user_id = ?, act_number = ?, depositor = ?, reason = ?, type = ?, balance = ?, amount = ?, tran_id = ?, statement = ?, balance_type = ?, datetime = ?',[$account[0]->user_id, $act_number,$depositor_name,$reason,$type,$balance,$amount,$tran_id,$statement,$balance_type,$datetime]);
            if($balance_type == 'available_balance') {
                DB::update('update ba_user_accounts set available_balance = ? WHERE id = ?',[$balance, $id]);
            }
            else {
                DB::update('update ba_user_accounts set ledge_balance = ? WHERE id = ?',[$balance, $id]);
            } 
            $customer   = DB::table('ba_account_holders')->where('user_id',$account[0]->user_id)->first();
            $branchQ     = DB::table('bank_details')->where('id',$account[0]->bank)->first();
            $branch = "";
            if($branchQ){
                $branch = $branchQ->branch_name;
            }
            $account = DB::select('select * from ba_user_accounts where id = ?', [$id]);
            $data['date']   = date("Y-m-d", strtotime($tran_date));
            $data['time']   = $tran_time;
            $data['name']   = $customer->cust_name.' '.$customer->middle_name.' '.$customer->sur_name;
            $data['subject']   = "Deposit";
            $data['type']   = "Deposit";
            $data['to']   = $customer->cust_mail;
            $data['acno']   = $account[0]->account_no;
            $data['branch']   = $branch;
            $data['desc']   = $reason;
            $data['amount']   = number_format($amount,2).' '.$account[0]->account_currency;
            $data['current_balance']   = number_format($account[0]->available_balance,2).' '.$account[0]->account_currency;
            $data['ledger_balance']   = number_format($account[0]->ledge_balance,2).' '.$account[0]->account_currency;
            
            if($this->env == 'live' && $customer->cust_countrycode && $customer->cust_phone) {
                
                $msg = 'Dear '.$data["name"].', We wish to inform you that a '.$data["type"].' transaction occurred on your account with us. The details of this transaction are shown below: Ac. Number:'.$data["acno"].', Amount:'.$data["amount"].', Current Balance:'.$data['current_balance'].', Ledger Balance:'.$data['ledger_balance'].'.';
                
                $client = new Client($this->accountSid, $this->authToken);
                
                $recipients_arr = array($customer->cust_countrycode . " " . $customer->cust_phone);
            
            try {
                
                foreach($recipients_arr as $recipient) {
                    $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg]);
                    
                    
                    
                }
                } 
                catch (\Throwable $th) {
       /* flash("Phone number is not valid or Twilio can't send a message to this phone number")->error();
       return redirect('/view-customers'); */
  }
                
                $this->sendTransactionEMail($data);
            }
            
            flash('Deposit added successfully!')->success();
            return redirect()->intended('view-deposits/' . $id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('add-deposit/' . $id);
        }
    }
    
    
    public function statement_loop(Request $request)
    {
      //echo $request->id.'||'.$request->name.'||'. $request->account_no .'||'. $request->from_date .'||'. $request->to_date .'||'. $request->loop_no ;
        $id = $request->id;
        $act_number = $request->account_no;
        $min_amount = $request->min_amount;
        $max_amount = $request->max_amount;
       
        $n=$request->loop_no;
        
        for ($i = 1; $i <= $n; $i++) 
        
        {
    

        $x=$request->from_date;
        $y=$request->to_date;
        $from_time = strtotime($x);
        $to_time = strtotime($y);
        $random_time = mt_rand($from_time, $to_time);
        $f_date = date('Y-m-d', $random_time);
        
        
        $start = strtotime("1:00:00");
        $end = strtotime("24:00:00");
        $f_time = date("H:i:s", mt_rand($start, $end));
        
        
        $url = "https://randomuser.me/api/";
        $json = file_get_contents($url);
        $data = json_decode($json);
        $depositor_name = $data->results[0]->name->first . " " . $data->results[0]->name->last;
        
        
        
        $statement=1;
        
        $balance_type = 'Available Balance';
        
        //$reason= $depositor_name;
        
        $tran_id = md5(time());
        
        $datetime = date("Y-m-d", strtotime($f_date)) . " " . $f_time;
        
        $a1='credited';
        $a2='debited';
        $array = array($a1, $a2);
        $random_value = $array[array_rand($array)];
        $type = $random_value;
        
        
        if($random_value=='credited')
        {
            $amount = mt_rand($min_amount, $max_amount);
            $balance= $request->available_balance + $amount;
            
              $lines = array(
                "CASH TRANSFER B/O BOW",
                "CASH DEPOSIT B/O BOW",
                "CASH DEPOSIT SELF",
               "APPROVE INWARD TRF - B/O BOWTRANS TOM IFO JENNY R",
               "APPROVE INWARD TRF - SWIFT INFLO B/O BOWTRANS TOM INFO PAUL KERHEEM",
               "FX PURCHASE (SPOT) VIA INTERNET BANKING - KERHEEM, PAUL - @249.62 @1.595016",
               "C.O.T B/O BOW"
             );

             $randomIndex = array_rand($lines);
             $reason = $lines[$randomIndex];
                          
            
        }
        else
        {
            $amount = mt_rand($min_amount, $max_amount);
            $balance= $request->available_balance - $amount;
            
            
              $lines = array(
                  "CASH TRANSFER B/O BOW",
                  "WITHDRAWAL ATM/POS B/O BOW",
                  "CASH TRANSFER B/O BOW",
                  "CASH WITHDRAWAL B/O BOW",
                  "APPROVE OUTWARD TRF - B/O BOWTRANS TOM IFO",
                  "APPROVE OUTWARD TRF - SWIFT INFLO B/O BOWTRANS TOM INFO",
                  "FX PURCHASE (SPOT) VIA INTERNET BANKING - KERHEEM, PAUL - @249.62 @1.595016",
                  "C.O.T B/O BOW"
             );

             $randomIndex = array_rand($lines);
             $reason = $lines[$randomIndex];
        }
  
        $account = DB::select('select * from ba_user_accounts where id = ?', [$id]);
        DB::insert('insert into ba_transactions SET user_id = ?, act_number = ?, depositor = ?, reason = ?, type = ?, balance = ?, amount = ?, tran_id = ?, statement = ?, balance_type = ?, datetime = ?',[$account[0]->user_id, $act_number,$depositor_name,$reason,$type,$balance,$amount,$tran_id,$statement,$balance_type,$datetime]);
        DB::update('update ba_user_accounts set available_balance = ? WHERE id = ?',[$balance, $id]);

        
        }
        
        
       
        return view('statement_f_success');
        
        
        
        
    }
    
    public function statement_f_success()
    {
        return "saddasdd";
    }
    
    
    
    
    
    
    public function sendTransactionEMail($data){
        $config = DB::select('select * from configs WHERE id = ?',[1]);
        $logo_link ="https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
        $dateVal = !empty($data['date']) ? $data['date'] : date("Y-m-d");
        $timeVal = !empty($data['time']) ? $data['time'] : date("H:i");

        $timestamp = strtotime($dateVal . ' ' . $timeVal);
        if (!$timestamp) {
            $timestamp = strtotime($dateVal);
        }
        if (!$timestamp) {
            $timestamp = time();
        }

        $formatted_datetime = date("d-M-Y H:i", $timestamp);
        $formatted_time = date("H:i", $timestamp);

        $message    = '<p style="text-align:right;">' .'<img src='.$logo_link.' alt="banking" style="width:14%;" />' .'</p>';
        $message .= '<p style="text-align:right; width : 100%;">'.$formatted_datetime.'</p>';
        $message .= '<p style="width : 100%;">Dear <b>'.$data["name"].'</b></p>';
        $message .= '<p style="width : 100%;">We wish to inform you that a '.$data["type"].' transaction occurred on your account with us. The details of this transaction are shown below:</p><br>';
        $message .= '<p style="width : 100%;"><b><u>Transaction Notification</u></b></p><br><br>';
        $message .= '<table>';
            $message .= '<tr>';
                $message .= '<td>Account Number</td>';
                $message .= '<td>: '.$data["acno"].'</td>';
            $message .= '</tr>';
            $message .= '<tr>';
                $message .= '<td>Transaction Location</td>';
                $message .= '<td>: '.$data["branch"].'</td>';
            $message .= '</tr>';
            $message .= '<tr>';
                $message .= '<td>Description</td>';
                $message .= '<td>: '.$data["desc"].'</td>';
            $message .= '</tr>';
            $message .= '<tr>';
                $message .= '<td>Amount</td>';
                $message .= '<td>: '.$data["amount"].'</td>';
            $message .= '</tr>';
            $message .= '<tr>';
                $message .= '<td>Date and Time</td>';
                $message .= '<td>: '.$formatted_datetime.'</td>';
            $message .= '</tr>';
            $message .= '<tr>';
                $message .= '<td>Document Number</td>';
                $message .= '<td>: </td>';
            $message .= '</tr>';
        $message .= '</table>';
        $message .= '<p style="width : 100%;">The balances on this account as at '.$formatted_time.' are as follows</p><br><br>';
        $message .= '<table>';
            $message .= '<tr>';
                $message .= '<td>Current Balance</td>';
                $message .= '<td>: '.$data["current_balance"].'</td>';
            $message .= '</tr>';
            $message .= '<tr>';
                $message .= '<td>Ledger Balance</td>';
                $message .= '<td>: '.$data["ledger_balance"].'</td>';
            $message .= '</tr>';
        $message .= '</table>';
        
        $message .= '<p style="width : 100%;">Thank you for choosing '.$config[0]->bank_name.'</p><br><br>';
        $message .= '<p>
            Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
            If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
        $body = '<html><head><style>font-face {font-family: "Trebuchet MS";src: url("https://'.$config[0]->bank_url.'/admin/exasset/trebuc.ttf");}body {font-family: "Trebuchet MS"; }</style></head><body>';
        $body .= $message ; 
        $body .= "</body></html>";
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: ' . $this->bankName . ' <'.$config[0]->bank_email.'>';
       Mail::send([], [], function ($message) use ($data, $body) {
    $message->to($data['to'])
            ->subject($data['subject'])
            ->setBody($body, 'text/html');
});    
    }

    public function viewDeposits(Request $request, $id) {
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        $deposits = DB::select('select * from ba_transactions WHERE act_number = ? && type = ?',[$account[0]->account_no, 'credited']);
        return view('view-deposits', ['account' => $account, 'customer' => $customer, 'deposits' => $deposits, 'module' => $this->module]);
    }

    public function editDeposit(Request $request, $id) {
        $deposit = DB::select('select * from ba_transactions WHERE id = ?',[$id]);
        $account = DB::select('select * from ba_user_accounts WHERE account_no = ?',[$deposit[0]->act_number]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        return view('edit-deposit', ['deposit' => $deposit, 'account' => $account, 'customer' => $customer, 'module' => $this->module]);
    }

    public function updateDeposit(Request $request) {
        $id = $request->input('id');
        $account_id = $request->input('account_id');
        $tran_date = $request->input('tran_date');
        $tran_time = $request->input('tran_time');
        $reason = $request->input('reason');
        $depositor_name = $request->input('depositor_name');
        $balance = $request->input('balance');
        $amount = $request->input('amount');
        $old_balance_type = $request->input('old_balance_type');
        $old_amount = $request->input('old_amount');
        $balance_type = $request->input('balance_type');
        $statement = $request->input('statement');
        if(!$statement) {
            $statement = 0;
        }
        $datetime = date("Y-m-d", strtotime($tran_date)) . " " . $tran_time;
        if(!empty($tran_date) && !empty($tran_time) && !empty($reason) && !empty($depositor_name) && !empty($amount) && !empty($balance_type) && !empty($datetime)) {
            DB::update('update ba_transactions SET depositor = ?, reason = ?, balance = ?, amount = ?, datetime = ?, balance_type = ?, statement = ? where id = ?',[$depositor_name,$reason,$balance,$amount,$datetime,$balance_type,$statement,$id]);
            if($old_balance_type == 'available_balance') {
                DB::update('update ba_user_accounts set available_balance = available_balance - ' . $old_amount . ' WHERE id = ?',[$account_id]);
            }
            else {
                DB::update('update ba_user_accounts set ledge_balance = ledge_balance - ' . $old_amount . ' WHERE id = ?',[$account_id]);
            }

            if($balance_type == 'available_balance') {
                DB::update('update ba_user_accounts set available_balance = ? WHERE id = ?',[$balance, $account_id]);
            }
            else {
                DB::update('update ba_user_accounts set ledge_balance = ? WHERE id = ?',[$balance, $account_id]);
            }
            
            flash('Deposit updated successfully!')->success();
            return redirect()->intended('view-deposits/' . $account_id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('edit-deposit/' . $id);
        }
    }

    public function deleteDeposit(Request $request, $id, $account_id) {
        $deposit = DB::select('select amount, balance_type from ba_transactions WHERE id = ?',[$id]);
        if($deposit[0]->balance_type == 'available_balance') {
            DB::update('update ba_user_accounts SET available_balance = available_balance - ? WHERE id = ?',[$deposit[0]->amount,$account_id]);
        }
        else {
            DB::update('update ba_user_accounts SET ledge_balance = ledge_balance - ? WHERE id = ?',[$deposit[0]->amount,$account_id]);
        }
        $deposit = DB::delete('delete from ba_transactions WHERE id = ?',[$id]);
        flash('Deposit deleted successfully')->success();
        return redirect()->intended('view-deposits/' . $account_id);
    }

    public function addWithdrawal(Request $request, $id) {
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        return view('add-withdrawal', ['account' => $account, 'customer' => $customer, 'module' => $this->module]);
    }

    public function insertWithdrawal(Request $request) {
        $id = $request->input('id');
        $act_number = $request->input('act_number');
        $tran_date = $request->input('tran_date');
        $tran_time = $request->input('tran_time');
        $reason = $request->input('reason');
        $withdrawal_name = $request->input('withdrawal_name');
        $type = 'debited';
        $balance = $request->input('balance');
        $balance = (float)preg_replace('/[^0-9\.]/ui','',$balance);
        $amount = $request->input('amount');
        $amount = (float)preg_replace('/[^0-9\.]/ui','',$amount);
        $balance_type = $request->input('balance_type');
        $statement = $request->input('statement');
        if(!$statement) {
            $statement = 0;
        }
        $tran_id = md5(time());
        $datetime = date("Y-m-d", strtotime($tran_date)) . " " . $tran_time;
        if(!empty($tran_date) && !empty($tran_time) && !empty($act_number) && !empty($reason) && !empty($withdrawal_name) && $amount!="" && !empty($balance_type) && !empty($tran_id)) {
            $account = DB::select('select * from ba_user_accounts where id = ?', [$id]);

            DB::insert('insert into ba_transactions SET user_id = ?, act_number = ?, depositor = ?, reason = ?, type = ?, balance = ?, amount = ?, tran_id = ?, statement = ?, balance_type = ?, datetime = ?',[$account[0]->user_id, $act_number,$withdrawal_name,$reason,$type,$balance,$amount,$tran_id,$statement,$balance_type,$datetime]);
            if($balance_type == 'available_balance') {
                DB::update('update ba_user_accounts set available_balance = ? WHERE id = ?',[$balance, $id]);
            }
            else {
                DB::update('update ba_user_accounts set ledge_balance = ? WHERE id = ?',[$balance, $id]);
            } 
            
            $customer   = DB::table('ba_account_holders')->where('user_id',$account[0]->user_id)->first();
            $branchQ     = DB::table('bank_details')->where('id',$account[0]->bank)->first();
            $branch = "";
            if($branchQ){
                $branch = $branchQ->branch_name;
            }
            $account = DB::select('select * from ba_user_accounts where id = ?', [$id]);
            $data['date']   = date("Y-m-d", strtotime($tran_date));
            $data['time']   = $tran_time;
            $data['name']   = $customer->cust_name.' '.$customer->middle_name.' '.$customer->sur_name;
            $data['subject']   = "Withdraw";
            $data['type']   = "Withdraw";
            $data['to']   = $customer->cust_mail;
            $data['acno']   = $account[0]->account_no;
            $data['branch']   = $branch;
            $data['desc']   = $reason;
            $data['amount']   = number_format($amount,2).' '.$account[0]->account_currency;
            $data['current_balance']   = number_format($account[0]->available_balance).' '.$account[0]->account_currency;
            $data['ledger_balance']   = number_format($account[0]->ledge_balance).' '.$account[0]->account_currency;
            
            if($this->env == 'live' && $customer->cust_countrycode && $customer->cust_phone) {
                $msg = 'Dear '.$data["name"].', We wish to inform you that a '.$data["type"].' transaction occurred on your account with us. The details of this transaction are shown below: Ac. Number:'.$data["acno"].', Amount:'.$data["amount"].', Current Balance:'.$data['current_balance'].', Ledger Balance:'.$data['ledger_balance'].'.';
                $client = new Client($this->accountSid, $this->authToken);
                $recipients_arr = array($customer->cust_countrycode . " " . $customer->cust_phone);
                
                
                
                try {
                
                foreach($recipients_arr as $recipient) {
                    $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg]);
                }
                
                }
                
                catch (\Throwable $th) {
       /* flash("Phone number is not valid or Twilio can't send a message to this phone number")->error();
       return redirect('/view-customers'); */
  }
                
                $this->sendTransactionEMail($data);
            }
            flash('Withdrawal added successfully!')->success();
            return redirect()->intended('view-withdrawals/' . $id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('add-withdrawal/' . $id);
        }
    }

    public function viewWithdrawals(Request $request, $id) {
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        $withdrawals = DB::select('select * from ba_transactions WHERE act_number = ? && type = ?',[$account[0]->account_no, 'debited']);
        return view('view-withdrawals', ['account' => $account, 'customer' => $customer, 'withdrawals' => $withdrawals, 'module' => $this->module]);
    }

    public function editWithdrawal(Request $request, $id) {
        $withdrawal = DB::select('select * from ba_transactions WHERE id = ?',[$id]);
        $account = DB::select('select * from ba_user_accounts WHERE account_no = ?',[$withdrawal[0]->act_number]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        return view('edit-withdrawal', ['withdrawal' => $withdrawal, 'account' => $account, 'customer' => $customer, 'module' => $this->module]);
    }

    public function updateWithdrawal(Request $request) {
        $id = $request->input('id');
        $account_id = $request->input('account_id');
        $tran_date = $request->input('tran_date');
        $tran_time = $request->input('tran_time');
        $reason = $request->input('reason');
        $withdrawal_name = $request->input('withdrawal_name');
        $balance = $request->input('balance');
        $amount = $request->input('amount');
        $old_balance_type = $request->input('old_balance_type');
        $old_amount = $request->input('old_amount');
        $balance_type = $request->input('balance_type');
        $statement = $request->input('statement');
        if(!$statement) {
            $statement = 0;
        }
        $datetime = date("Y-m-d", strtotime($tran_date)) . " " . $tran_time;

        if(!empty($tran_date) && !empty($tran_time) && !empty($reason) && !empty($withdrawal_name) && !empty($amount) && !empty($balance_type) && !empty($datetime)) {
            DB::update('update ba_transactions SET depositor = ?, reason = ?, balance = ?, amount = ?, datetime = ?, balance_type = ?, statement = ? where id = ?',[$withdrawal_name,$reason,$balance,$amount,$datetime,$balance_type,$statement,$id]);
            if($old_balance_type == 'available_balance') {
                DB::update('update ba_user_accounts set available_balance = available_balance + ' . $old_amount . ' WHERE id = ?',[$account_id]);
            }
            else {
                DB::update('update ba_user_accounts set ledge_balance = ledge_balance + ' . $old_amount . ' WHERE id = ?',[$account_id]);
            }

            if($balance_type == 'available_balance') {
                DB::update('update ba_user_accounts set available_balance = ? WHERE id = ?',[$balance, $account_id]);
            }
            else {
                DB::update('update ba_user_accounts set ledge_balance = ? WHERE id = ?',[$balance, $account_id]);
            }
            
            flash('Withdrawal updated successfully!')->success();
            return redirect()->intended('view-withdrawals/' . $account_id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('edit-withdrawal/' . $id);
        }
    }

    public function deleteWithdrawal(Request $request, $id, $account_id) {
        $withdrawal = DB::select('select amount, balance_type from ba_transactions WHERE id = ?',[$id]);
        if($withdrawal[0]->balance_type == 'available_balance') {
            DB::update('update ba_user_accounts SET available_balance = available_balance + ? WHERE id = ?',[$withdrawal[0]->amount,$account_id]);
        }
        else {
            DB::update('update ba_user_accounts SET ledge_balance = ledge_balance + ? WHERE id = ?',[$withdrawal[0]->amount,$account_id]);
        }
        $deposit = DB::delete('delete from ba_transactions WHERE id = ?',[$id]);
        flash('Withdrawal deleted successfully')->success();
        return redirect()->intended('view-withdrawals/' . $account_id);
    }

    public function addCard(Request $request, $id) {
        $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        $accounts = DB::select('select * from ba_user_accounts WHERE user_id = ?',[$customer[0]->user_id]);
        return view('add-card', ['customer'=>$customer, 'accounts' => $accounts, 'module' => $this->module]);
    }

    public function insertCard(Request $request) {
        
        $customer_id = $request->input('customer_id');
        $user_id = $request->input('customer_user_id');
        $cust_act_number = $request->input('act_number');
        $card_type = $request->input('card_type');
        $card_service_type = $request->input('card_service_type');
        $card_number = $request->input('card_number');
        $card_pin = $request->input('card_pin');
        $exp_date = $request->input('exp_date');
        $cvv = $request->input('cvv');

        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
          //sms data
         $SmsEditor = SmsEditor::where('type', 'accout_card_added')->first();
          //email data
         $EmailEditor = EmailEditor::where('type', 'accout_card_added')->first();
         $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
         $verification_email = $EmailEditor->verification;
         $config = DB::select('select * from configs WHERE id = ?',[1]);

         $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        
         $sms = $SmsEditor->sms;
         $myString = $sms;
         
        $final_sms = str_replace('[first_name]', $customername, $sms);
       
        $final_sms = str_replace('[card_number]', $card_number, $final_sms);
       
        $final_sms = str_replace('[card_type]',$card_type , $final_sms);

        $final_sms = str_replace('[card_service_type]', $card_service_type, $final_sms);

        $final_sms = str_replace('[card_pin]', $card_pin, $final_sms);

        $final_sms = str_replace('[exp_date]', $exp_date, $final_sms);

        $final_sms = str_replace('[cvv]', $cvv, $final_sms);
            
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            
            $final_sms = str_replace('[address]', $customer[0]->cust_address, $final_sms);
           
            $final_sms = str_replace('[phone]', $phone, $final_sms);
            }
        }
            
            $verification = $SmsEditor->verification;
            
        if(!empty($customer_id) && !empty($user_id) && !empty($cust_act_number) && !empty($card_type) && !empty($card_service_type) && !empty($card_number) && !empty($card_pin) && !empty($exp_date) && !empty($cvv)) {
            DB::insert('insert into ba_cards (cust_act_number,user_id,card_number,card_type,card_service_type,card_pin,exp_date,cvv,status) values(?,?,?,?,?,?,?,?,?)',[$cust_act_number,$user_id,$card_number,$card_type,$card_service_type,$card_pin,$exp_date,$cvv,1]);

      
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
              $msg = $final_sms;
            
           if ($verification == 1) {
                foreach($recipients_arr as $recipient) {
                $client->messages->create($recipient, 
                ['from' => $this->fromNumber, 'body' => $msg] );
            }
           }

       if($verification_email == 1){ 
           
        $data = array('user'=>$user, 'card' =>$request->all(),'phone'=>$phone,'address'=>$user[0]->cust_address);   
        $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
       
       }

        }

            flash('Card added successfully!')->success();
            return redirect()->intended('view-cards/' . $customer_id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('add-card/' . $customer_id);
        }
    }
         public function dynamic_email($data, $message, $subject, $to_email, $from_email){
              $config = DB::select('select * from configs WHERE id = ?',[1]);
            
            if(isset($data['user'])){
                 $customername = $data['user'][0]->cust_name.' '.$data['user'][0]->middle_name.' '.$data['user'][0]->sur_name;
            }  
            
            if($customername!=''){
                $message = str_replace('[first_name]', $customername, $message);
            }
            if(isset($data['address'])){
                $message = str_replace('[address]',$data['address'],$message);
            }
            if(isset($data['phone'])){
                $message = str_replace('[phone]',$data['phone'],$message);
            }

            if(isset($data['card']['card_number'])){
            $message = str_replace('[card_number]', $data['card']['card_number'], $message);
            }
            if(isset($data['card']['card_type_hid'])){
            $message = str_replace('[card_type_hid]', $data['card']['card_type_hid'], $message);
            }
            if(isset($data['card']['card_service_type_hid'])){
            $message = str_replace('[card_service_type_hid]', $data['card']['card_service_type_hid'], $message);
            }

            if(isset($data['card']['card_type'])){
            $message = str_replace('[card_type]',$data['card']['card_type'] , $message);
             }
            if(isset($data['card']['card_service_type'])){
            $message = str_replace('[card_service_type]',$data['card']['card_service_type'] , $message);
             }
             if(isset($data['card']['card_pin'])){
            $message = str_replace('[card_pin]',$data['card']['card_pin'] , $message);
             }
              if(isset($data['card']['exp_date'])){
            $message = str_replace('[exp_date]',$data['card']['exp_date'] , $message);
             }
            if(isset($data['card']['cvv'])){
            $message = str_replace('[cvv]',$data['card']['cvv'] , $message);
           
             }
            $logo_link ="https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
            $finals_message = '<span class="imeg">' .'<img src='.$logo_link.' alt="banking" style="display:block;margin-left:780px;width:14%;" />' .'</span>';
            
            $finals_message .= '<p style="position: relative;top: 136px;">' . $message . '</p>';  
            $finals_message .= '<p>
            Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
            If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
            
            $body = "<html><head></head><body>";
            $body .= $finals_message ; 
            $body .= "</body></html>";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            
            $headers[] = 'From: ' . $this->bankName . ' <'.$from_email.'>';
            
          Mail::send([], [], function ($message) use ($to_email, $subject, $body) {
    $message->to($to_email)
            ->subject($subject)
            ->setBody($body, 'text/html');
});
      
    }
    public function viewCards(Request $request, $id) {
        $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        $cards = DB::select('select * from ba_cards WHERE user_id = ?',[$customer[0]->user_id]);
        return view('view-cards', ['customer'=>$customer, 'cards' => $cards, 'module' => $this->module]);
    }

    public function viewCard(Request $request, $id) {
        $card = DB::select('select * from ba_cards WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$card[0]->user_id]);
        return view('view-card', ['card' => $card, 'customer' => $customer, 'module' => $this->module]);
    }

    public function editCard(Request $request, $id) {
        $card = DB::select('select * from ba_cards WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$card[0]->user_id]);
        $accounts = DB::select('select * from ba_user_accounts WHERE user_id = ?',[$card[0]->user_id]);
        return view('edit-card', ['card' => $card, 'customer' => $customer, 'accounts' => $accounts, 'module' => $this->module]);
    }

    public function updateCard(Request $request) {
        $id = $request->input('id');
        $customer_id = $request->input('customer_id');
        $customer_user_id = $request->input('customer_user_id');
        $cust_act_number = $request->input('act_number');
        $card_type = $request->input('card_type');
        $card_service_type = $request->input('card_service_type');
        $card_number = $request->input('card_number');
        $card_pin = $request->input('card_pin');
        $exp_date = $request->input('exp_date');
        $cvv = $request->input('cvv');

        if(!empty($cust_act_number) && !empty($card_type) && !empty($card_service_type) && !empty($card_number) && !empty($card_pin) && !empty($exp_date) && !empty($cvv)) {
            DB::update('update ba_cards SET cust_act_number = ?, card_number = ?, card_type = ?, card_service_type = ?, card_pin = ?, exp_date = ?, cvv = ? WHERE id = ?',[$cust_act_number,$card_number,$card_type,$card_service_type,$card_pin,$exp_date,$cvv,$id]);

            flash('Card updated successfully!')->success();
            return redirect()->intended('view-cards/' . $customer_id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('edit-card/' . $id);
        }
    }

    public function approveCard(Request $request, $id) {
        $card = DB::select('select * from ba_cards WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$card[0]->user_id]);
        $accounts = DB::select('select * from ba_user_accounts WHERE user_id = ?',[$card[0]->user_id]);
        return view('approve-card', ['card' => $card, 'customer' => $customer, 'accounts' => $accounts, 'module' => $this->module]);
    }

    public function updateApproveCard(Request $request) {
        $id = $request->input('id');
        $customer_id = $request->input('customer_id');
        $customer_user_id = $request->input('customer_user_id');
        $card_number = $request->input('card_number');
        $card_pin = $request->input('card_pin');
        $exp_date = $request->input('exp_date');
        $cvv = $request->input('cvv');
        
        $card_type_hid = $request->input('card_type_hid');
        $card_service_type_hid = $request->input('card_service_type_hid');
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$customer_user_id]);
        //sms and email data
        $SmsEditor = SmsEditor::where('type', 'accout_card_approved')->first();
        $EmailEditor = EmailEditor::where('type', 'accout_card_approved')->first();
        
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        
        $sms = $SmsEditor->sms;
        $myString = $sms;
        $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
        //replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        
        $final_sms = str_replace('[card_number]', $card_number, $final_sms);
        
        $final_sms = str_replace('[card_type_hid]',$card_type_hid , $final_sms);
        
        $final_sms = str_replace('[card_service_type_hid]', $card_service_type_hid, $final_sms);
        
        $final_sms = str_replace('[card_pin]', $card_pin, $final_sms);
        $final_sms = str_replace('[exp_date]', $exp_date, $final_sms);
        $final_sms = str_replace('[cvv]', $cvv, $final_sms);
        
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            
            $final_sms = str_replace('[address]', $user[0]->cust_address, $final_sms);
           
            $final_sms = str_replace('[phone]', $phone, $final_sms);
            }
        }
        //verification
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        
        if(!empty($card_number) && !empty($card_pin) && !empty($exp_date) && !empty($cvv)) {
        DB::update('update ba_cards SET card_number = ?, card_pin = ?, exp_date = ?, cvv = ?, status = 1 WHERE id = ?',[$card_number,$card_pin,$exp_date,$cvv,$id]);
            //sms and emal sending
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);

            $msg = $final_sms;
            if ($verification == 1) {
                foreach($recipients_arr as $recipient) {
                $client->messages->create($recipient, 
                ['from' => $this->fromNumber, 'body' => $msg] );
                }
            }
            if($verification_email == 1){
                
                 $data = array('user'=>$user, 'card' =>$request->all(), 'address'=>$user[0]->cust_address,'phone'=>$phone);   
                  
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
             }
        
        }
        
        flash('Card approved successfully!')->success();
        return redirect()->intended('view-cards/' . $customer_id);
        }
        else {
        flash('Please fill all the required fields')->error();
        return redirect()->intended('edit-card/' . $id);
        }
        }

    public function deleteCard(Request $request, $id, $customer_id) {
        $account = DB::delete('delete from ba_cards WHERE id = ?',[$id]);
        flash('Card deleted successfully')->success();
        return redirect()->intended('view-cards/' . $customer_id);
    }

    public function viewTransactions(Request $request, $id) {
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        $transactions = DB::select("select A.*, (select B.act_number from ba_transactions B WHERE B.tran_id=A.tran_id && type = ? && depositor = '') as beneficiary from ba_transactions A WHERE A.act_number = ? ORDER BY A.datetime DESC",['credited', $account[0]->account_no]);
        return view('view-transactions', ['account' => $account, 'customer' => $customer, 'transactions' => $transactions, 'module' => $this->module]);
    }
    
    public function statement_maker() {
       

        $users = DB::table('ba_account_holders')->where('account_status',1)->get();
        return view('statement_maker',compact('users'));
       
    }
    

    
    public function statement_form(Request $request) {
       
        //$user = DB::table('ba_account_holders')->where('user_id',$request->user_id)->get();
        $account = DB::table('ba_user_accounts')->where('user_id',$request->user_id)->get();
        
        return view('statement_form',compact('account'));
      
        
       
    }
    

    public function allLocalTransfers(Request $request, $id) {
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        $transfers = DB::select("select A.*, B.act_number as beneficiary_act_number, C.account_title as beneficiary, D.branch_name as beneficiary_bank, E.account_currency from ba_transactions A INNER JOIN ba_transactions B ON B.tran_id=A.tran_id INNER JOIN ba_user_accounts C ON C.account_no=B.act_number INNER JOIN bank_details D ON D.id=C.bank INNER JOIN ba_user_accounts E ON E.account_no=A.act_number WHERE A.act_number = ? && A.type = ? && A.depositor = '' && B.depositor = '' && B.type = ? && A.international = ? ORDER BY A.datetime DESC",[$account[0]->account_no, 'debited', 'credited', 0]);
        return view('all-local-transfers', ['account' => $account, 'customer' => $customer, 'transfers' => $transfers, 'module' => $this->module]);
    }

    public function markTransferComplete(Request $request, $tran_id) {
        $transaction = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = '' && status = ?", [$tran_id, 'debited', 0]);
        $transaction2 = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = '' && status = ?", [$tran_id, 'credited', 0]);

        if(isset($transaction[0]->id) && isset($transaction2[0]->id)) {
            $account = DB::select("select id, available_balance from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);
            $account2 = DB::select("select available_balance from ba_user_accounts where account_no = ?",[$transaction2[0]->act_number]);

            $available_balance = $account[0]->available_balance - $transaction[0]->amount;
            DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance, $transaction[0]->act_number]);
            DB::update("update ba_transactions SET balance = ?, status = ? where id = ?",[$available_balance, 1, $transaction[0]->id]);

            $available_balance2 = $account2[0]->available_balance + $transaction2[0]->amount;
            DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance2, $transaction2[0]->act_number]);
            DB::update("update ba_transactions SET balance = ?, status = ? where id = ?",[$available_balance2, 1, $transaction2[0]->id]);
            flash('Transfer Marked Complete successfully')->success();
            return redirect()->intended('all-local-transfers/' . $account[0]->id);
        }
        else {
            return redirect()->intended('dashboard');
        }
    }

    public function editTransfer(Request $request, $tran_id) {
        $transfer = DB::select("select A.*, B.act_number as beneficiary_act_number, C.account_title as beneficiary, D.branch_name as beneficiary_bank, E.account_currency from ba_transactions A INNER JOIN ba_transactions B ON B.tran_id=A.tran_id INNER JOIN ba_user_accounts C ON C.account_no=B.act_number INNER JOIN bank_details D ON D.id=C.bank INNER JOIN ba_user_accounts E ON E.account_no=A.act_number WHERE A.tran_id = ? && A.type = ? && A.depositor = '' && B.depositor = '' && B.type = ? ORDER BY A.datetime DESC",[$tran_id, 'debited', 'credited']);
        $account = DB::select('select * from ba_user_accounts WHERE account_no = ?',[$transfer[0]->act_number]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        return view('edit-transfer', ['account' => $account, 'customer' => $customer, 'transfer' => $transfer, 'module' => $this->module]);
    }

    public function updateTransfer(Request $request) {
        $tran_id = $request->input('tran_id');
        $account_id = $request->input('account_id');
        $tran_date = $request->input('tran_date');
        $tran_time = $request->input('tran_time');
        $datetime = date("Y-m-d", strtotime($tran_date)) . " " . $tran_time;
        $reason = $request->input('reason');
        $amount = $request->input('amount');
        $balance = $request->input('balance');

        if(!empty($tran_id) && !empty($tran_date) && !empty($tran_time) && !empty($reason) && !empty($amount) && !empty($balance)) {
            DB::update("update ba_transactions set balance = ?, amount = ?, reason = ?, datetime = ? where tran_id = ? && type = ?", [$balance, $amount, $reason, $datetime, $tran_id, 'debited']);

            $transaction = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'debited']);
            $account = DB::select("select * from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);

            $transaction2 = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'credited']);
            $account2 = DB::select("select * from ba_user_accounts where account_no = ?",[$transaction2[0]->act_number]);
            $available_balance2 = ($account2[0]->available_balance - $transaction2[0]->amount) + $amount;

            DB::update("update ba_transactions set balance = ?, amount = ?, datetime = ? where tran_id = ? && type = ?", [$available_balance2, $amount, $datetime, $tran_id, 'credited']);

            DB::update("update ba_user_accounts set available_balance = ? where account_no = ?", [$balance, $account[0]->account_no]);
            DB::update("update ba_user_accounts set available_balance = ? where account_no = ?", [$available_balance2, $account2[0]->account_no]);
            
            flash('Transfer updated successfully!')->success();
            return redirect()->intended('all-local-transfers/' . $account_id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('edit-transfer/' . $tran_id);
        }
    }

    public function deleteTransfer(Request $request, $tran_id) {
        $transaction = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'debited']);
        $transaction2 = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'credited']);

        if(isset($transaction[0]->id) && isset($transaction2[0]->id)) {
            if($transaction[0]->status == 1 && $transaction2[0]->status == 1) {
                $account = DB::select("select id, available_balance from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);
                $account2 = DB::select("select available_balance from ba_user_accounts where account_no = ?",[$transaction2[0]->act_number]);

                $available_balance = $account[0]->available_balance + $transaction[0]->amount;
                DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance, $transaction[0]->act_number]);

                $available_balance2 = $account2[0]->available_balance - $transaction2[0]->amount;
                DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance2, $transaction2[0]->act_number]);

                DB::delete("delete from ba_transactions WHERE tran_id = ?", [$tran_id]);
                flash('Transfer deleted successfully')->success();
                return redirect()->intended('all-local-transfers/' . $account[0]->id);
            }
            elseif($transaction[0]->status == 0 && $transaction2[0]->status == 0) {
                $account = DB::select("select id, available_balance from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);
                DB::delete("delete from ba_transactions WHERE tran_id = ?", [$tran_id]);
                flash('Transfer deleted successfully')->success();
                return redirect()->intended('all-local-transfers/' . $account[0]->id);
            }
            else {
                return redirect()->intended('dashboard');
            }
        }
        else {
            return redirect()->intended('dashboard');
        }
    }

    public function allInternationalTransfers(Request $request, $id) {
        // echo md5(time());
        
        $account = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        $transfers = DB::select("select A.*, (SELECT B.act_number FROM ba_transactions B WHERE B.tran_id=A.tran_id && B.type = ? && B.international = ?) as beneficiary, E.account_currency from ba_transactions A INNER JOIN ba_user_accounts E ON E.account_no=A.act_number WHERE A.act_number = ? && A.type = ? && A.depositor = '' && A.international = ? ORDER BY A.datetime DESC",['credited', 1, $account[0]->account_no, 'debited', 1]);
        return view('all-international-transfers', ['account' => $account, 'customer' => $customer, 'transfers' => $transfers, 'module' => $this->module]);
    }

    public function markInternationalTransferComplete(Request $request, $tran_id) {
        $transaction = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = '' && status = ?", [$tran_id, 'debited', 0]);
        $transaction2 = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = '' && status = ?", [$tran_id, 'credited', 0]);
        $transaction3 = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = '' && status = ?", [$tran_id, 'charges', 0]);

        if(isset($transaction[0]->id) && isset($transaction2[0]->id) && isset($transaction[0]->id)) {
            $account = DB::select("select id, available_balance from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);

            $available_balance = $account[0]->available_balance - $transaction[0]->amount;
            DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance, $transaction[0]->act_number]);
            DB::update("update ba_transactions SET balance = ?, status = ? where id = ?",[$available_balance, 1, $transaction[0]->id]);

            $available_balance = $available_balance - $transaction3[0]->amount;
            DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance, $transaction3[0]->act_number]);
            DB::update("update ba_transactions SET balance = ?, status = ? where id = ?",[$available_balance, 1, $transaction3[0]->id]);

            DB::update("update ba_transactions SET balance = ?, status = ? where id = ?",[$transaction[0]->amount, 1, $transaction2[0]->id]);
            flash('Transfer Marked Complete successfully')->success();
            return redirect()->intended('all-international-transfers/' . $account[0]->id);
        }
        else {
            return redirect()->intended('dashboard');
        }
    }

    public function deleteInternationalTransfer(Request $request, $tran_id) {
        $transaction = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'debited']);
        $transaction2 = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'credited']);
        $transaction3 = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'charges']);

        if(isset($transaction[0]->id) && isset($transaction2[0]->id) && isset($transaction3[0]->id)) {
            if($transaction[0]->status == 1 && $transaction2[0]->status == 1 && $transaction3[0]->status == 1) {
                $account = DB::select("select id, available_balance from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);
                $account2 = DB::select("select available_balance from ba_user_accounts where account_no = ?",[$transaction2[0]->act_number]);

                $available_balance = $account[0]->available_balance + $transaction[0]->amount;
                DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance, $transaction[0]->act_number]);

                $available_balance3 = $available_balance + $transaction3[0]->amount;
                DB::update("update ba_user_accounts SET available_balance = ? where account_no = ?",[$available_balance3, $transaction3[0]->act_number]);

                DB::delete("delete from ba_transactions WHERE tran_id = ?", [$tran_id]);
                flash('Transfer deleted successfully')->success();
                return redirect()->intended('all-international-transfers/' . $account[0]->id);
            }
            elseif($transaction[0]->status == 0 && $transaction2[0]->status == 0 && $transaction3[0]->status == 0) {
                $account = DB::select("select id from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);
                DB::delete("delete from ba_transactions WHERE tran_id = ?", [$tran_id]);
                flash('Transfer deleted successfully')->success();
                return redirect()->intended('all-international-transfers/' . $account[0]->id);
            }
            else {
                return redirect()->intended('dashboard');
            }
        }
        else {
            return redirect()->intended('dashboard');
        }
    }

    public function editInternationalTransfer(Request $request, $tran_id) {
        $transfer = DB::select("select A.*, (SELECT B.act_number FROM ba_transactions B WHERE B.tran_id=A.tran_id && B.type = ? && B.international = ?) as beneficiary, (SELECT C.amount FROM ba_transactions C WHERE C.tran_id=A.tran_id && C.type = ? && C.international = ?) as charges, E.account_currency from ba_transactions A INNER JOIN ba_user_accounts E ON E.account_no=A.act_number WHERE A.tran_id = ? && A.type = ? && A.depositor = '' && A.international = ? ORDER BY A.datetime DESC",['credited', 1, 'charges', 1, $tran_id, 'debited', 1]);
        // $transfers = DB::select("select A.*, (SELECT B.act_number FROM ba_transactions B WHERE B.tran_id=A.tran_id && B.type = ? && B.international = ?) as beneficiary, E.account_currency from ba_transactions A INNER JOIN ba_user_accounts E ON E.account_no=A.act_number WHERE A.act_number = ? && A.type = ? && A.depositor = '' && A.international = ? ORDER BY A.datetime DESC",['credited', 1, $account[0]->account_no, 'debited', 1]);
        $account = DB::select('select * from ba_user_accounts WHERE account_no = ?',[$transfer[0]->act_number]);
        $customer = DB::select('select * from ba_account_holders WHERE user_id = ?',[$account[0]->user_id]);
        return view('edit-international-transfer', ['account' => $account, 'customer' => $customer, 'transfer' => $transfer, 'module' => $this->module]);
    }

    public function updateInternationalTransfer(Request $request) {
        $tran_id = $request->input('tran_id');
        $account_id = $request->input('account_id');
        $tran_date = $request->input('tran_date');
        $tran_time = $request->input('tran_time');
        $datetime = date("Y-m-d", strtotime($tran_date)) . " " . $tran_time;
        $reason = $request->input('reason');
        $amount = $request->input('amount');
        $charges = $request->input('charges');
        $before_charges_balance = $request->input('before_charges_balance');
        $balance = $request->input('balance');

        if(!empty($tran_id) && !empty($tran_date) && !empty($tran_time) && !empty($reason) && !empty($amount) && !empty($charges) && !empty($before_charges_balance) && !empty($balance)) {
            DB::update("update ba_transactions set balance = ?, amount = ?, reason = ?, datetime = ? where tran_id = ? && type = ?", [$before_charges_balance, $amount, $reason, $datetime, $tran_id, 'debited']);
            DB::update("update ba_transactions set balance = ?, amount = ?, datetime = ? where tran_id = ? && type = ?", [$balance, $charges, $datetime, $tran_id, 'charges']);
            DB::update("update ba_transactions set balance = ?, amount = ?, datetime = ? where tran_id = ? && type = ?", [$amount, $amount, $datetime, $tran_id, 'credited']);

            $transaction = DB::select("select * from ba_transactions WHERE tran_id = ? && type = ? && depositor = ''", [$tran_id, 'debited']);
            $account = DB::select("select * from ba_user_accounts where account_no = ?",[$transaction[0]->act_number]);

            DB::update("update ba_user_accounts set available_balance = ? where account_no = ?", [$balance, $account[0]->account_no]);
            
            flash('Transfer updated successfully!')->success();
            return redirect()->intended('all-international-transfers/' . $account_id);
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('edit-transfer/' . $tran_id);
        }
    }

    public function addAccountManager() {
        $data = array();
        $data['module'] = $this->module;

        return view('add-account-manager', $data);
    }

    public function insertAccountManager(Request $request) {
        $allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp');
        $destinationPath = 'uploads';

        $name = $request->input('fullname');
        $email = $request->input('email');
        $countrycode = $request->input('code');
        $phone = $request->input('phone');

        if(!empty($name) && !empty($email) && !empty($countrycode) && !empty($phone)) {
            $photo = $request->file('photo');
            if(!empty($photo) && !empty($photo_path = $photo->getRealPath()) && !empty($photo_name = $photo->getClientOriginalName())) {
                $photo_ext = $photo->getClientOriginalExtension();
                $photo_type = $photo->getMimeType();

                if(!in_array($photo_type, $allowed_types)) {
                    flash('Please upload allowed file type in Photo')->error();
                    return redirect()->intended('add-account-manager');
                }

                $photo_name = 'data:image/' . $photo_type . ';base64,' . base64_encode(file_get_contents($photo->getRealPath()));
            }

            // if(!empty($photo_name)) {
            //     $photo_name = md5(time()).$photo_name;
            //     $photo->move($destinationPath,$photo_name);
            // }
            // else {
            //     $photo_name = '';
            // }

            DB::insert('insert into ba_am set name = ?, email = ?, countrycode = ?, phone = ?, photo = ?', [$name, $email, $countrycode, $phone, $photo_name]);
            flash('Account Manager added successfully!')->success();
            return redirect()->intended('view-account-managers');
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('add-account-manager');
        }
    }

    public function viewAccountManagers() {
        $ams = DB::select('select * from ba_am');
        return view('view-account-managers', ['ams'=>$ams, 'module' => $this->module]);
    }

    public function editAccountManager($id) {
        $data = array();
        $data['module'] = $this->module;
        $data['am'] = DB::select('select * from ba_am where id = ?', [$id]);

        return view('edit-account-manager', $data);
    }

    public function updateAccountManager(Request $request) {
        $allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp');
        $destinationPath = 'uploads';

        $name = $request->input('fullname');
        $email = $request->input('email');
        $countrycode = $request->input('code');
        $phone = $request->input('phone');
        $id = $request->input('editid');
        $current_photo = $request->input('current_photo');

        if(!empty($name) && !empty($email) && !empty($countrycode) && !empty($phone) && !empty($id)) {
            $photo = $request->file('photo');
            if(!empty($photo) && !empty($photo_path = $photo->getRealPath()) && !empty($photo_name = $photo->getClientOriginalName())) {
                $photo_ext = $photo->getClientOriginalExtension();
                $photo_type = $photo->getMimeType();

                if(!in_array($photo_type, $allowed_types)) {
                    flash('Please upload allowed file type in Photo')->error();
                    return redirect()->intended('view-account-managers');
                }

                $photo_name = 'data:image/' . $photo_type . ';base64,' . base64_encode(file_get_contents($photo->getRealPath()));
            }

            // if(!empty($photo_name)) {
            //     $photo_name = md5(time()).$photo_name;
            //     $photo->move($destinationPath,$photo_name);
            // }
            // else {
            //     $photo_name = $current_photo;
            // }

            if(empty($photo_name)) {
                $photo_name = $current_photo;
            }

            DB::insert('update ba_am set name = ?, email = ?, countrycode = ?, phone = ?, photo = ? where id = ?', [$name, $email, $countrycode, $phone, $photo_name, $id]);
            flash('Account Manager updated successfully!')->success();
            return redirect()->intended('view-account-managers');
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('view-account-managers');
        }
    }

    public function deleteAccountManager($id) {
        $check = DB::select('select * from ba_account_holders where am = ?', [$id]);

        if(isset($check[0])) {
            flash('Cannot delete Account Manager as linked with Account')->error();
            return redirect()->intended('view-account-managers');
        }
        else {
            DB::delete('delete from ba_am where id = ?', [$id]);

            flash('Account Manager deleted successfully!')->success();
            return redirect()->intended('view-account-managers');
        }
    }

    public function viewLoans($id) {
        $data = array();
        $data['account'] = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $data['customer'] = DB::select('select * from ba_account_holders WHERE user_id = ?',[$data['account'][0]->user_id]);
        $data['loans'] = DB::select('select * from ba_loans where user_id = ? && account_no = ?', [$data['account'][0]->user_id, $data['account'][0]->account_no]);
        $data['module'] = $this->module;
        return view('view-loans', $data);
    }

    public function approveLoan($id) {
        $data = array();
        $data['loan'] = DB::select('select * from ba_loans where id = ?', [$id]);
        $data['account'] = DB::select('select * from ba_user_accounts WHERE account_no = ?',[$data['loan'][0]->account_no]);
        $data['customer'] = DB::select('select * from ba_account_holders WHERE user_id = ?',[$data['account'][0]->user_id]);
        $data['module'] = $this->module;
        return view('approve-loan', $data);
    }

    public function updateApproveLoan(Request $request) {
        
        $user_id = $request->input('user_id');
        $account_id = $request->input('account_id');
        $id = $request->input('id');
        $loan_emi = $request->input('loan_emi');
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        
        $SmsEditor = SmsEditor::where('type', 'loan_approved')->first();
        $EmailEditor = EmailEditor::where('type', 'loan_approved')->first();
        $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        
        $sms = $SmsEditor->sms;
        $email = $EmailEditor->email;
        
        $myString = $sms;
        
        $final_sms = str_replace('[first_name]', $customername, $sms);
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            
            $final_sms = str_replace('[address]', $user[0]->cust_address, $final_sms);
            $final_sms = str_replace('[phone]', $phone, $final_sms);
            }
        }
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;

        DB::update('update ba_loans set loan_emi = ?, status = ? where id = ?', [$loan_emi, 1, $id]);
            //sms and email send
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
           
            $msg = $final_sms.$loan_emi;
            $email_msg = $final_email.$loan_emi;
            if ($verification == 1) {
                foreach($recipients_arr as $recipient) {
                $client->messages->create($recipient, 
                ['from' => $this->fromNumber, 'body' => $msg] );
            }
        }

          if($verification_email == 1){
                    
                $data = array('user'=>$user, 'card' =>$request->all(),'phone'=>$phone, 'address'=>$user[0]->cust_address);   
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
               
               }
        }

        flash('Loan Approved successfully!')->success();
        return redirect()->intended('view-loans/' . $account_id);
    }

    public function viewLimits($id) {
        $data = array();
        $data['account'] = DB::select('select * from ba_user_accounts WHERE id = ?',[$id]);
        $data['customer'] = DB::select('select * from ba_account_holders WHERE user_id = ?',[$data['account'][0]->user_id]);
        $data['limits'] = DB::select('select ba_limits.*, ba_user_accounts.account_currency from ba_limits inner join ba_user_accounts on ba_limits.account_no=ba_user_accounts.account_no where ba_limits.user_id = ? && ba_limits.account_no = ? order by ba_limits.id desc', [$data['account'][0]->user_id, $data['account'][0]->account_no]);
        $data['module'] = $this->module;
        return view('view-limits', $data);
    }

    public function approveLimit(Request $request, $id) {
        
        DB::update('update ba_limits set status = ? where id = ?', [1, $id]);
        $limit = DB::select('select * from ba_limits where id = ?', [$id]);
        $account = DB::select('select * from ba_user_accounts where account_no = ?', [$limit[0]->account_no]);
        $account_id = $account[0]->id;
        $user_id = $limit[0]->user_id;
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            //sms data
        $SmsEditor = SmsEditor::where('type', 'limit_approved')->first();
           // email data
        $EmailEditor = EmailEditor::where('type', 'limit_approved')->first();
         $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
          $sms = $SmsEditor->sms;
        $myString = $sms;
       
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            
            $final_sms = str_replace('[address]', $user[0]->cust_address, $final_sms);
            $final_sms = str_replace('[phone]', $phone, $final_sms);
            }
        }
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        
        
        
        $final_sms = str_replace('[first_name]', $customername, $sms);
        
        $verification = $SmsEditor->verification;
        
        $email = $EmailEditor->email;
        
        $verification_email = $EmailEditor->verification;
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
             
            $msg = $final_sms;
            if ($verification == 1) {
                foreach($recipients_arr as $recipient) {
                $client->messages->create($recipient, 
                ['from' => $this->fromNumber, 'body' => $msg] );
                }
            }
            
            if($verification_email == 1){
            
                $data = array('user'=>$user, 'card' =>$request->all(),'phone'=>$phone,'address'=>$user[0]->cust_address);   
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
            
            }
        }
        
        flash('Limit Approved successfully!')->success();
        return redirect()->intended('view-limits/' . $account_id);
        }

    public function denyLimit(Request $request, $id) {
        
        DB::update('update ba_limits set status = ? where id = ?', [2, $id]);
        
        $limit = DB::select('select * from ba_limits where id = ?', [$id]);
        $account = DB::select('select * from ba_user_accounts where account_no = ?', [$limit[0]->account_no]);
        $account_id = $account[0]->id;
        $user_id = $limit[0]->user_id;
       
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
        //sms data
        $SmsEditor = SmsEditor::where('type', 'limit_denied')->first();
        //email data
        $EmailEditor = EmailEditor::where('type', 'limit_denied')->first();
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        
        $sms = $SmsEditor->sms;
        //replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $myString = $sms;
         if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            $final_sms = str_replace('[address]', $user[0]->cust_address, $final_sms);
            $final_sms = str_replace('[phone]', $phone, $final_sms);
            }
        }
        
        $verification = $SmsEditor->verification;
        
        $email = $EmailEditor->email;
        
      //  $final_email = str_replace('[first_name]', $customername, $email);
        
        $verification_email = $EmailEditor->verification;
        //email and sms send
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
             
            $msg = $final_sms;
            if ($verification == 1) {
                foreach($recipients_arr as $recipient) {
                $client->messages->create($recipient, 
                ['from' => $this->fromNumber, 'body' => $msg] );
                }
            }
            
            if($verification_email == 1){ 
            
            $data = array('user'=>$user,'phone'=>$phone,'address'=>$user[0]->cust_address);   
            $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
            
            }
        }
        
        flash('Limit Denied successfully!')->success();
        return redirect()->intended('view-limits/' . $account_id);
        }

    public function editLimit($id) {
        $data = array();
        $data['limit'] = DB::select('select * from ba_limits where id = ?', [$id]);
        $data['account'] = DB::select('select * from ba_user_accounts WHERE account_no = ?',[$data['limit'][0]->account_no]);
        $data['customer'] = DB::select('select * from ba_account_holders WHERE user_id = ?',[$data['account'][0]->user_id]);
        $data['module'] = $this->module;
        return view('edit-limit', $data);
    }

    public function updateLimit(Request $request) {
        $user_id = $request->input('user_id');
        $account_id = $request->input('account_id');
        $id = $request->input('id');
        $limit_amount = $request->input('limit_amount'); 
        
        DB::update('update ba_limits set limit_amount = ?, status = ? where id = ?', [$limit_amount, 1, $id]);
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
        
        //sms data
        $SmsEditor = SmsEditor::where('type', 'limit_update_approved')->first();
        //email data
        $EmailEditor = EmailEditor::where('type', 'limit_update_approved')->first();
        
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        
        $sms = $SmsEditor->sms;
        //replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $myString = $sms;
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
                $final_sms = str_replace('[address]', $customer[0]->cust_address, $final_sms);
                $final_sms = str_replace('[phone]', $phone, $final_sms);
            }
        }
        $verification = $SmsEditor->verification;
        $email = $EmailEditor->email;
        
        $verification_email = $EmailEditor->verification;
        //sms and email sending
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
        $client = new Client($this->accountSid, $this->authToken);
        $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
         
        $msg = $final_sms;
        if ($verification == 1) {
            foreach($recipients_arr as $recipient) {
            $client->messages->create($recipient, 
            ['from' => $this->fromNumber, 'body' => $msg] );
            }
        }
        
        if($verification_email == 1){ 
        
            $data = array('user'=>$user, 'card' =>$request->all(),'phone'=>$phone,'address'=>$user[0]->cust_address);   
            $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
        
        }
        
        }
        
        flash('Limit Updated and Approved successfully!')->success();
        return redirect()->intended('view-limits/' . $account_id);
        }
    
    public function formSettings() {
    $branches = DB::select('select * from bank_details');
    $security_questions = DB::select('select * from ba_securityquestions');
    $ams = DB::select('select * from ba_am');

    /** fetching form data **/
    $enableForms = DB::table('reg_form_settings')->first();

    return view('form-settings', ['branches'=>$branches, 'security_questions'=>$security_questions, 'ams' => $ams, 'module' => $this->module, 'enableForms' => $enableForms]);
  }

  public function updateFormSettings(Request $request) {
    if ($request->has('formfour')) {
      $formfour = true;
    } else {
      $formfour = false;
    }

    if ($request->has('formfive')) {
      $formfive = true;
    } else {
      $formfive = false;
    }

    if ($request->has('formsix')) {
      $formsix = true;
    } else {
      $formsix = false;
    }

    if ($request->has('formseven')) {
      $formseven = true;
    } else {
      $formseven = false;
    }

    if ($request->has('formeight')) {
      $formeight = true;
    } else {
      $formeight = false;
    }

    if ($request->has('formnine')) {
      $formnine = true;
    } else {
      $formnine = false;
    }

    if ($request->has('formten')) {
      $formten = true;
    } else {
      $formten = false;
    }

    if ($request->has('formeleven')) {
      $formeleven = true;
    } else {
      $formeleven = false;
    }

    if ($request->has('formtwelve')) {
      $formtwelve = true;
    } else {
      $formtwelve = false;
    }

    if ($request->has('formthirteen')) {
      $formthirteen = true;
    } else {
      $formthirteen = false;
    }

    if ($request->has('formfourteen')) {
      $formfourteen = true;
    } else {
      $formfourteen = false;
    }

    if ($request->has('formfifteen')) {
      $formfifteen = true;
    } else {
      $formfifteen = false;
    }
    
    if ($request->has('auto_activate')) {
      $auto_activate = true;
    } else {
      $auto_activate = false;
    }


    DB::update('update reg_form_settings set auto_activate = ?,account_start_value = ?, account_end_value = ?, form_4 = ?, form_5 = ?, form_6 = ?, form_7 = ?, form_8 = ?, form_9 = ?, form_10 = ?, form_11 = ?, form_12 = ?, form_13 = ?, form_14 = ?, form_15 = ? where id = 1', [$auto_activate, $request->account_start_value, $request->account_end_value, $formfour, $formfive, $formsix, $formseven, $formeight, $formnine, $formten, $formeleven, $formtwelve, $formthirteen, $formfourteen, $formfifteen, 1]);
    
    flash('Settings Updated successfully!')->success();

    return redirect()->intended('form-settings');
  }
  
  /** internet banking form settings **/
  public function ibFormSettings() {
    $branches = DB::select('select * from bank_details');
    $security_questions = DB::select('select * from ba_securityquestions');
    $ams = DB::select('select * from ba_am');


    /** fetching form data **/
    $enableIbForms = DB::table('reg_ib_form_settings')->first();

    return view('ib-form-settings', ['branches'=>$branches, 'security_questions'=>$security_questions, 'ams' => $ams, 'module' => $this->module, 'enableIbForms' => $enableIbForms]);
  }

  public function ibUpdateFormSettings(Request $request) {
    if ($request->has('formone')) {
      $formone = true;
    } else {
      $formone = false;
    }

    if ($request->has('formtwo')) {
      $formtwo = true;
    } else {
      $formtwo = false;
    }


    DB::update('update reg_ib_form_settings set form_1 = ?, form_2 = ? where id = 1', [$formone, $formtwo, 1]);

    flash('Settings Updated successfully!')->success();

    return redirect()->intended('ib-form-settings');
  }
  
    // public function limitRequests() {
    //     $limits = DB::table('ba_limits')->orderby('id','desc')->limit(200)->get();
    //     return view('limit-requests', ['list' => $account_type]);
    // }
    
    public function bankAccountTypes() {
        $account_type = DB::select('select * from account_type');
        return view('account_type', ['list' => $account_type]);
    }
    
    public function bankAccountTypesSave(Request $rec) {
        DB::table('account_type')->insert(['type_name' => $rec->name]);
        flash('Account Type Added')->success();
        return redirect()->intended('bankaccount-types');
    }
    
    public function bankAccountTypesUpdate(Request $rec) {
        DB::table('account_type')->where('id',$rec->id)->update(['type_name' => $rec->name]);
        flash('Account Type Updated')->success();
        return redirect()->intended('bankaccount-types');
    }
    
    public function bankAccountTypesDelete($id) {
        DB::table('account_type')->where('id',$id)->delete();
        flash('Account Type Deleted')->success();
        return redirect()->intended('bankaccount-types');
    }
    
    public function securityQuestions() {
        $security_questions = DB::select('select * from ba_securityquestions');
        return view('security-questions', ['security_questions' => $security_questions]);
    }

    public function securityQuestionsSave(Request $rec) {
        DB::table('ba_securityquestions')->insert(['question' => $rec->question]);
        flash('Security Question Added')->success();
        return redirect()->intended('security-questions');
    }
    
    public function securityQuestionsUpdate(Request $rec) {
        DB::table('ba_securityquestions')->where('id',$rec->id)->update(['question' => $rec->question]);
        flash('Security Question Updated')->success();
        return redirect()->intended('security-questions');
    }
    
    public function securityQuestionsDelete($id) {
        DB::table('ba_securityquestions')->where('id',$id)->delete();
        flash('Security Question Deleted')->success();
        return redirect()->intended('security-questions');
    }
    
    
    public function userActivities() {
        $users = [];
        $disUsers = DB::table('ba_user_activities')->select('customer')->distinct();
        if($disUsers->count() > 0){
            foreach($disUsers->get() as $user){
                array_push($users,$user->customer); 
            }
        }else{
            array_push($users,0); 
        }
        $activities = DB::table('ba_user_activities')->limit(200)->orderby('id','desc')->get();
        $customers = DB::table('ba_account_holders')->where('df','no')->whereIn('id',$users)->orderby('cust_name')->get();
        return view('customer-activities', ['activities' => $activities,'customers' => $customers,'customer' => '']);
    }
    
    public function userActivitiesFilter(Request $request) {
        $users = [];
        $disUsers = DB::table('ba_user_activities')->select('customer')->distinct();
        if($disUsers->count() > 0){
            foreach($disUsers->get() as $user){
                array_push($users,$user->customer); 
            }
        }else{
            array_push($users,0); 
        }
        $customers = DB::table('ba_account_holders')->where('df','no')->whereIn('id',$users)->orderby('cust_name')->get();
        if($request->customer != ""){
            $activities = DB::table('ba_user_activities')->where('customer',$request->customer)->limit(200)->orderby('id','desc')->get();
        }else{
            $activities = DB::table('ba_user_activities')->limit(200)->orderby('id','desc')->get();
        }
        return view('customer-activities', ['activities' => $activities,'customers' => $customers,'customer' => $request->customer]);
    }
}
