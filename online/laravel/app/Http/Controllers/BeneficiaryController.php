<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Ivr_Msg;
use App\Ba_beneficiary;
use App\BaAccountHolders;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Utility;
use Session;
use App\SmsEditor;
use App\EmailEditor;
use App\UserActivity;

class BeneficiaryController extends Controller
{
   public function __construct() {
        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
      
       $config = DB::select('select bank_email, sms_token, sms_sid, sms_phone,bank_name,logo from configs where 1');
       
         $this->fromEmail = $config[0]->bank_email;

        $this->bankName = $config[0]->bank_name;

        $this->logo = $config[0]->logo;

        $this->fromNumber = $config[0]->sms_phone;

        $this->accountSid = $config[0]->sms_sid;

        $this->authToken = $config[0]->sms_token;

        $this->env = 'live';
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $this->env = 'local';
        }
    }

   
   public function add_beneficary(Request $request) {
       
    $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'add_beneficiary';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
   
    $users = BaAccountHolders::get();
        return view('client.add_beneficiary',$data,compact('users'));
    }

     
     public function store_beneficary(Request $request) {
        //  dd($request);
         $user_id = $request->session()->get('user_id');
         //check bank type
         if($request->bank_type == 1){
             
             $beneficiary_account = $request->beneficiary_account;
             
             $transfer_to_account = DB::select('select * from ba_user_accounts where account_no = ? and user_id', [$beneficiary_account]);
              
        if(!isset($transfer_to_account[0])) {

            flash('Beneficiary Account Number does not exists')->error();
            return redirect()->intended('add-beneficiaries');
        }else{
             request()->validate([
           
            'beneficiary_account' => 'required|min:6',

        ]);
          if (Ba_beneficiary::where('beneficiary_account', '=',$request->beneficiary_account)->where('beneficiary_added_by_user_id',$user_id)->exists()) {
                 flash('This beneficiary account already exist in your profile')->error();
                 return redirect()->back();
        }

             else{
                 
            $token = rand(100000, 999999);
            $Ba_beneficiary = new Ba_beneficiary;
            $Ba_beneficiary->beneficiary_added_by_user_id = $user_id;
            $Ba_beneficiary->beneficiary_account = $request->beneficiary_account;
            $Ba_beneficiary->bank_type = $request->bank_type;
            $Ba_beneficiary->verification = '0';
            $Ba_beneficiary->verification_code = $token;
            
            $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            //email and sms data
            $SmsEditor = SmsEditor::where('type', 'beneficary_verification_code')->first();
            $EmailEditor = EmailEditor::where('type', 'beneficary_verification_code')->first();
            
            $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
            $sms = $SmsEditor->sms;
            //replacing for magical strings
            $final_sms = str_replace('[first_name]', $customername, $sms);
            
            $verification = $SmsEditor->verification;
            $verification_email = $EmailEditor->verification;
             
            $Ba_beneficiary->save();
            $value = $Ba_beneficiary->id;
              //verify and send
            if( $this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                $client = new Client($this->accountSid, $this->authToken);
                $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                
                $msg = $final_sms . $token;
               if ($verification == 1) {
                    foreach($recipients_arr as $recipient) {
                    $client->messages->create($recipient, 
                    ['from' => $this->fromNumber, 'body' => $msg] );
                 }
                }
                  if($verification_email == 1) {
                
                    $data = array('user'=>$user, 'card' =>$request->all(), 'token'=>$token );   
             
                    $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
                }
          
        }
           // dd($value);
                UserActivity::saveUserActivity($request->session()->get('id'),'Create Beneficary');
         return redirect()->intended('success_beneficiary/'.$value);
    
             }
        }
            
        }else{
            request()->validate([
           
            'beneficiary_name' => 'required',
            'beneficiary_address' => 'required',
             
            'beneficiary_account' => 'required|min:6',
            'beneficiary_bank_name' => 'required',
            'beneficiary_bank_address' => 'required',
            'beneficiary_country' => 'required',
            'bank_type' => 'required'

        ]);
         
             if (Ba_beneficiary::where('beneficiary_account', '=',$request->beneficiary_account)->where('beneficiary_added_by_user_id',$user_id)->exists()) {
                 flash('This beneficiary account already exist in your profile')->error();
                 return redirect()->back();
        }

             else{
            $token = rand(100000, 999999);
            $user_id = $request->session()->get('user_id');
            
            $Ba_beneficiary = new Ba_beneficiary;
            $Ba_beneficiary->beneficiary_added_by_user_id = $user_id;
            $Ba_beneficiary->beneficiary_name = $request->beneficiary_name;
            $Ba_beneficiary->beneficiary_address = $request->beneficiary_address;
            $Ba_beneficiary->beneficiary_sort_code = $request->beneficiary_sort_code;
            $Ba_beneficiary->beneficiary_swift = $request->beneficiary_swift;
            $Ba_beneficiary->beneficiary_iban = $request->beneficiary_iban;
            $Ba_beneficiary->beneficiary_account = $request->beneficiary_account;
            $Ba_beneficiary->beneficiary_bank_name = $request->beneficiary_bank_name;
            $Ba_beneficiary->beneficiary_bank_address = $request->beneficiary_bank_address;
            $Ba_beneficiary->beneficiary_country = $request->beneficiary_country;
            
            $Ba_beneficiary->bank_type = $request->bank_type;
            $Ba_beneficiary->verification = '0';
            $Ba_beneficiary->verification_code = $token;
            
            $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
                //sms data
            $SmsEditor = SmsEditor::where('type', 'beneficary_verification_code')->first();
             
            $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
            $sms = $SmsEditor->sms;
                //email data
            $EmailEditor = EmailEditor::where('type', 'beneficary_verification_code')->first();
            $verification_email = $EmailEditor->verification;
            $final_sms = str_replace('[first_name]', $customername, $sms);
            
            $verification = $SmsEditor->verification;
            
            $Ba_beneficiary->save();
            $value = $Ba_beneficiary->id;
              // check verification for both sms and email
            if( $this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                $client = new Client($this->accountSid, $this->authToken);
                $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                 
                $msg = $final_sms . $token;
               if ($verification == 1) {
                    foreach($recipients_arr as $recipient) {
                    $client->messages->create($recipient, 
                    ['from' => $this->fromNumber, 'body' => $msg] );
                    }
                }
     
              if($verification_email == 1) {
                       
                $data = array('user'=>$user, 'card' =>$request->all(), 'token'=>$token );   
             
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
                }
          
        }
            if (request()->headers->get('referer') == 'email-verification/{id}') {
                 # code...
            session(['TransferToOtherBank' => '1']);
            }
                UserActivity::saveUserActivity($request->session()->get('id'),'Create Beneficary');
          return redirect()->intended('success_beneficiary_other/'.$value);
    
             }
        }
                
    }
    
    public function dynamic_email($data, $message, $subject, $to_email, $from_email){
        //email function and replacing
        $config = DB::select('select * from configs WHERE id = ?',[1]);
        
        if(isset($data['user'])){
        $customername = $data['user'][0]->cust_name.' '.$data['user'][0]->middle_name.' '.$data['user'][0]->sur_name;
        }  
        
        if($customername!=''){
        $message = str_replace('[first_name]', $customername, $message);
        }
        
        if(isset($data['card']['card_number'])){
        $message = str_replace('[card_number]', $data['card']['card_number'], $message);
        }
       
        $token = $data['token'];
        
        $logo_link ="https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
        $finals_message = '<span class="imeg">' .'<img src='.$logo_link.' alt="banking" style="display:block;margin-left:780px;width:14%;" />' .'</span>';
        
        $finals_message .= '<p style="position: relative;top: 136px;">' . $message . ''.$token . '</p>';  
        
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
    
    public function edit_Beneficiary($id){
        
          $Ba_beneficiary = Ba_beneficiary::find($id);
           $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'manage-beneficiaries';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
         
        return view('client.edit_beneficiary',$data, compact('Ba_beneficiary'));
        
    }
     public function edit_Beneficiary_same($id){
       
          $Ba_beneficiary = Ba_beneficiary::find($id);
           $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'manage-beneficiaries';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
         
        return view('client.edit_beneficiary_same',$data, compact('Ba_beneficiary'));
        
    }
    

 public function update_beneficary_same(Request $request){
        //dd($request->all());
       
        request()->validate([
        
           'beneficiary_account' => 'required|min:6',
        
        ]);
        
        $id = $request->id;
        
        $beneficiary_account = $request->beneficiary_account;
        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        
        DB::table('ba_beneficiary')->where('id', $id)
        ->update([
        
            'beneficiary_account' => $beneficiary_account,
        
        ]);
        
        
        flash('Beneficiary has been updated succesfully')->success();
        return redirect()->intended('manage-beneficiaries');
        
    }

      public function update_beneficary(Request $request){
        
        request()->validate([
            'beneficiary_name' => 'required',
            'beneficiary_address' => 'required',
            'beneficiary_account' => 'required|min:6',
            'beneficiary_bank_name' => 'required',
            'beneficiary_bank_address' => 'required',
            'beneficiary_country' => 'required',

        ]);

        $id = $request->id;

            $beneficiary_name = $request->beneficiary_name;
            $beneficiary_address = $request->beneficiary_address;
            $beneficiary_sort_code = $request->beneficiary_sort_code;
            $beneficiary_swift = $request->beneficiary_swift;
            $beneficiary_iban = $request->beneficiary_iban;
            $beneficiary_account = $request->beneficiary_account;
            $beneficiary_bank_name = $request->beneficiary_bank_name;
            $beneficiary_bank_address = $request->beneficiary_bank_address;
            $beneficiary_country = $request->beneficiary_country;
            //$bank_type = $request->bank_type;
            $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);

              DB::table('ba_beneficiary')->where('id', $id)
                        ->update([
                      
                        'beneficiary_name' => $beneficiary_name,
                        'beneficiary_address' => $beneficiary_address,
                        'beneficiary_sort_code' => $beneficiary_sort_code,
                        'beneficiary_swift' => $beneficiary_swift,
                        'beneficiary_iban' => $beneficiary_iban,
                        'beneficiary_account' => $beneficiary_account,
                        'beneficiary_bank_name' => $beneficiary_bank_name,
                        'beneficiary_bank_address' => $beneficiary_bank_address,
                        'beneficiary_country' => $beneficiary_country,
                       
                    ]);
        UserActivity::saveUserActivity($request->session()->get('id'),'Update Beneficary');
         flash('Beneficiary has been updated succesfully')->success();
         return redirect()->intended('manage-beneficiaries');
        
    }
    
    public function del_beneficary($id){
        
         $del = Ba_beneficiary::find($id);
         $del->delete();
         flash('Beneficiary has been deleted succesfully')->success();
         return redirect()->back();
         
    }
    public function success_beneficiary($id){
            
    $Ba_beneficiary = Ba_beneficiary::find($id);

        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'manage-beneficiaries';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
    return view('client.success_beneficiary',$data,compact('Ba_beneficiary'));
         
    }
     public function success_beneficiary_other($id){
           
    $Ba_beneficiary = Ba_beneficiary::find($id);
     
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'manage-beneficiaries';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
    return view('client.success_beneficiary_other',$data,compact('Ba_beneficiary'));
         
    }
    public function email_verification($id){
            
    $Ba_beneficiary = Ba_beneficiary::find($id);
   
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'manage-beneficiaries';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
    return view('client.email_verification',$data,compact('Ba_beneficiary'));
         
    }
    public function code_verification(Request $request){
        
         request()->validate([
          
            'verification_code' => 'required',
        ]);

            if(Ba_beneficiary::where('verification_code' ,'=', $request->verification_code )->exists())

            {

                $id = $request->id;
                   
                Ba_beneficiary::where('id', $id)
                        ->update([
                        'verification' => '1',
                    ]);
                
                flash('Verification code matches ')->success();
                return redirect()->intended('manage-beneficiaries');
           
            }
            else{
               
                flash('Verification code does not matches')->error();
                return redirect()->intended('manage-beneficiaries');
                
            }   
         
    }

}