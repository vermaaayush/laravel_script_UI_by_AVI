<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use DB;
use Mail;
use Twilio\Rest\Client;
Use \Carbon\Carbon;
// use App\Listing;
use Illuminate\Http\Request;
use App\SmsEditor;
use App\EmailEditor;
use App\UserActivity;
class profile extends Controller
{
    
     public function __construct() {
        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
       
         $config = DB::select('select bank_email, bank_name, logo, sms_token, sms_sid,bank_url, sms_phone, sms_token from configs where 1');

         
        $this->bankName = $config[0]->bank_name;
        
        $this->fromEmail = $config[0]->bank_email;
        
        $this->fromNumber = $config[0]->sms_phone;

       $this->logo = $config[0]->logo;

        $this->fromNumber = $config[0]->sms_phone;

        $this->accountSid = $config[0]->sms_sid;

        $this->authToken = $config[0]->sms_token;
        
        $this->bank_url = $config[0]->bank_url;
        
        $this->bank_email = $config[0]->bank_email;
        

        $this->env = 'live';
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $this->env = 'local';
        }
        
         // timezone
        
       date_default_timezone_set('Africa/Lagos');
        
        // 24-hour format of an hour without leading zeros (0 through 23)
        $Hour = date('G');
        
        if ( $Hour >= 5 && $Hour <= 11 ) {
        $time_msg= "Good Morning";
        
        } else if ( $Hour >= 12 && $Hour <= 18 ) {
        $time_msg= "Good Afternoon";
        } else if ( $Hour >= 19 || $Hour <= 4 ) {
        $time_msg= "Good Evening";
        }
        $this->time_msg =$time_msg;
        
    }
    public function getIp(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false){
                    return $ip;
                }
            }
        }
    }
}
 public function store_page_logs($page,$user_id){
      $date = Carbon::now();
     $ip =$this->getIp();
     $login_time = $date->toRfc850String();
      DB::insert('insert into page_logs (userid,ip, stamp,page) values (?,?, ?,?)', [$user_id,$ip,$login_time,$page]);
             
 }
 public function editProfile(Request $request) {
     
        $data = array();
        $data['type']   = 'edit';
        $data['main'] = 'profile';
        $data['page'] = 'viewProfile';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bank_url'] = $this->bank_url;
        $data['customer'] = DB::select('select * from ba_account_holders where user_id =?
    ',[$request->session()->get('user_id')]);
    
    
    
      return view('editProfile', $data);
 }
 
 public function updateProfile(Request $request){
     
    $data = [
        'type'              => 'update',
        'bankName'          => $this->bankName,
        'page'              => "viewProfile",
        'main'              => "profile",
        'logo'              => $this->logo,
        'bank_url'          => $this->bank_url,
        'cust_name'         => $request->cust_name,
        'idnumber'          => $request->idnumber,
        'cust_dob'          => $request->cust_dob,
        'mother_maiden'     => $request->mother_maiden,
        'cust_mail'         => $request->cust_mail,
        'cust_address'      => $request->cust_address,
        'cust_city'         => $request->cust_city,
        'cust_state'        => $request->cust_state,
        'cust_country'      => $request->cust_country,
        'post_code'         => $request->post_code,
        'max_amount'        => $request->max_amount,
        'cust_phone'        => $request->cust_phone,
        'cust_countrycode'  => $request->cust_countrycode,
    ];
    
    if($request->redType == 'new'){
        $SmsEditor = SmsEditor::where('type', 'profile_update')->first();
         $EmailEditor = EmailEditor::where('type', 'profile_update')->first();
          $verification_email = $EmailEditor->verification;
        if($SmsEditor->verification == 1 || $verification_email == 1){
            $token = rand(100000, 999999);
            $user_id = $request->session()->get('user_id');
            $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
            $sms = $SmsEditor->sms;
            $final_sms = str_replace('[first_name]', $customername, $sms);
            $verification = $SmsEditor->verification;
             DB::insert('insert into ba_token set user_id = ?, token = ?', [$user_id, $token]);
            if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
                $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                /*$msg = 'Please enter this verification code to verify' . $token;*/
                $msg = $final_sms . $token;
               
              if ($verification == 1) {
                   
                    foreach($recipients_arr as $recipient) {
                        $client->messages->create($recipient, 
                        ['from' => $this->fromNumber, 'body' => $msg] );
                    }
                }
                  
                      if($verification_email == 1) {
            
           $dataemail = array('user'=>$user,'card' =>$request->all() ,'token' =>$token );   
         
        $this->dynamic_email($dataemail, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
           
            }
                
            }
            return view('editProfile', $data);  
        }else{
            $cust_name = '';
            $middle_name = '';
            $sur_name = '';
            $fullnamearr = explode(" ", $request->cust_name);
            if(isset($fullnamearr[0]) && !empty($fullnamearr[0])){
                $cust_name = $fullnamearr[0];
            }
            if(isset($fullnamearr[1]) && !empty($fullnamearr[1])){
                $middle_name = $fullnamearr[1];
            }
            if(isset($fullnamearr[2]) && !empty($fullnamearr[2])){
                $sur_name = $fullnamearr[2];
            }
            $data = [
                'cust_name'         => $cust_name,
                'middle_name'       => $middle_name,
                'sur_name'          => $sur_name,
                'idnumber'          => $request->idnumber,
                'dob'               => date('Y-m-d',strtotime($request->cust_dob)),
                'mother_maiden'     => $request->mother_maiden,
                'cust_mail'         => $request->cust_mail,
                'cust_address'      => $request->cust_address,
                'cust_city'         => $request->cust_city,
                'cust_state'        => $request->cust_state,
                'cust_country'      => $request->cust_country,
                'post_code'         => $request->post_code,
                'max_amount'        => $request->max_amount,
                'cust_phone'        => $request->cust_phone
            ];
            DB::table('ba_account_holders')->where('user_id',$request->session()->get('user_id'))->update($data);
            
            UserActivity::saveUserActivity($request->session()->get('id'),'Update Profile');
            flash('Profile Successfully Updated')->success();
            //return redirect()->intended('editProfile');
            return view('editProfile', $data);
        }
    }else{
        $row = DB::table('ba_token')->where('user_id',$request->session()->get('user_id'))->where('status','0')->where('token',$request->otp);
        if($row->count() > 0){
            DB::table('ba_token')->where('id',$row->first()->id)->update(['status' => '1']);
            $cust_name = '';
            $middle_name = '';
            $sur_name = '';
            $fullnamearr = explode(" ", $request->cust_name);
            if(isset($fullnamearr[0]) && !empty($fullnamearr[0])){
                $cust_name = $fullnamearr[0];
            }
            if(isset($fullnamearr[1]) && !empty($fullnamearr[1])){
                $middle_name = $fullnamearr[1];
            }
            if(isset($fullnamearr[2]) && !empty($fullnamearr[2])){
                $sur_name = $fullnamearr[2];
            }
            
            $data = [
                'cust_name'         => $cust_name,
                'middle_name'       => $middle_name,
                'sur_name'          => $sur_name,
                'idnumber'          => $request->idnumber,
                'dob'               => date('Y-m-d',strtotime($request->cust_dob)),
                'mother_maiden'     => $request->mother_maiden,
                'cust_mail'         => $request->cust_mail,
                'cust_address'      => $request->cust_address,
                'cust_city'         => $request->cust_city,
                'cust_state'        => $request->cust_state,
                'cust_country'      => $request->cust_country,
                'post_code'         => $request->post_code,
                'max_amount'        => $request->max_amount,
                'cust_phone'        => $request->cust_phone
            ];
            DB::table('ba_account_holders')->where('user_id',$request->session()->get('user_id'))->update($data);
            UserActivity::saveUserActivity($request->session()->get('id'),'Update Profile');
            flash('Profile Successfully Updated')->success();
            return redirect()->intended('editProfile');
        }else{
            flash('Please enter valid code.')->error();
            return view('editProfile', $data);       
        }
    }
 }
 
    public function viewProfile(Request $request) {
        $data = array();
        $data['main'] = 'profile';
        $data['page'] = 'viewProfile';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bank_url'] = $this->bank_url;
        $user_info = DB::select('select * from ba_account_holders where user_id =?
    ',[$request->session()->get('user_id')]);
    
        $data['cust_name'] = $user_info[0]->cust_name;
        $data['dob'] = $user_info[0]->dob;
        $data['email'] = $user_info[0]->cust_mail;
         $data['cust_phone'] = $user_info[0]->cust_phone;
         $data['cust_phone_country_code'] = $user_info[0]->cust_countrycode;
         $data['address'] = $user_info[0]->cust_address;
         $data['postcode'] = $user_info[0]->post_code;
         $data['mother_maiden'] = $user_info[0]->mother_maiden;
         $data['user_id'] = $user_info[0]->user_id;
         $data['customer_id'] = $user_info[0]->customer_id;
         $data['q1'] = $user_info[0]->qid;
         $data['q2'] = $user_info[0]->qid2;
         $data['max_amount'] = $user_info[0]->max_amount;
         $data['country'] = $user_info[0]->cust_country;
         $data['photo'] = $user_info[0]->cust_photo;
         $data['join'] = $user_info[0]->joining;
         $manger_info = DB::select('select * from ba_am where id =?
    ',[$user_info[0]->am]);
    $data['manager'] =$manger_info;
    //store_page_logs ('view_profile',$user_info[0]->user_id);
        return view('viewProfile', $data);
    }
       public function dynamic_email($data, $message, $subject, $to_email, $from_email){
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
            ->setBody($body, 'text/html'); // Use 'text/plain' if not HTML
});
    }
   /* public function generateOTPForprofileUpdate(Request $request) {
        $user_id = $request->session()->get('user_id');

        $token = rand(100000, 999999);

        DB::insert('insert into ba_token set user_id = ?, token = ?', [$user_id, $token]);

        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            
             $SmsEditor = SmsEditor::where('type', 'profile_update')->first();
              $EmailEditor = EmailEditor::where('type', 'profile_update')->first();
             $verification_email = $EmailEditor->verification;
            
           // dd($SmsEditor);
              $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
               $sms = $SmsEditor->sms;
            
            $final_sms = str_replace('[first_name]', $customername, $sms);

            $verification = $SmsEditor->verification;

        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
           // $msg = 'You have initiated a Profile Update for which OTP is: ' . $token;
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

        echo json_encode(array('success' => true));
    }*/
}
