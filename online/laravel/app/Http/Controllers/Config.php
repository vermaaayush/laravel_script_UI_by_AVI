<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\SmsEditor;
use App\EmailEditor;
use Illuminate\Support\Str;
use App\UserActivity;

class Config extends Controller {

    public function __construct() {
        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
          $config = DB::select('select bank_email, sms_token, sms_sid, sms_phone,bank_name,logo, bank_url from configs where 1');
         
         $this->fromEmail = $config[0]->bank_email;

        $this->bankName = $config[0]->bank_name;

        $this->logo = $config[0]->logo;
        
        $this->bank_url = $config[0]->bank_url;

        $this->fromNumber = $config[0]->sms_phone;

        $this->accountSid = $config[0]->sms_sid;

        $this->authToken = $config[0]->sms_token;

        $this->env = 'live';
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $this->env = 'local';
        }
    }

    public function resetSecret(Request $request) {
        $data = array();
        $data['main'] = 'config';
        $data['page'] = 'reset-secret';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bank_url']=$this->bank_url;

        $user_id = $request->session()->get('user_id');
        $data['customer'] = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        return view('reset-secret', $data);
    }

    public function updateSecret(Request $request) {
        $user_id = $request->session()->get('user_id');
        $data = $request->input();

        DB::insert("update ba_account_holders set ans = ?, ans2 = ? where user_id = ?", [$data['ans'], $data['ans2'], $user_id]);

        $data = array();
        $data['main'] = 'config';
        $data['page'] = 'reset-secret';
        $data['msg'] = 'Question and Answer Reset Successfully';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
        UserActivity::saveUserActivity($request->session()->get('id'),'Change Security Questions Answer');
        return view('notification', $data);
    }

    public function passwordUpdate(Request $request) {
        $data = array();
        $data['main'] = 'config';
        $data['page'] = 'password-update';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['customer'] = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        return view('password-update', $data);
    }

    public function validateUserID(Request $request) {
        $user_id = $request->session()->get('user_id');

        if ($user_id == $request->input('user_id')) {
            echo json_encode(array('success' => true, 'valid' => true));
        }
        else {
            echo json_encode(array('success' => true, 'valid' => false));
        }
    }

    public function generateOTPForPasswordUpdate(Request $request) {
        
        $user_id = $request->session()->get('user_id');
        
        $token = rand(100000, 999999);
        
        DB::insert('insert into ba_token set user_id = ?, token = ?', [$user_id, $token]);
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        //sms and email data
        $SmsEditor = SmsEditor::where('type', 'pin_update_otp')->first();
        $EmailEditor = EmailEditor::where('type', 'pin_update_otp')->first();
       
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        
            //sms replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        
        
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
            //verify send sms and email
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
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
        
        echo json_encode(array('success' => true));
        }
    
     

    public function validateOTPForPasswordUpdate(Request $request) {
        $user_id = $request->session()->get('user_id');
        
        $data = $request->input();
        $otp = $data['otp'];
        $pin = $data['pin'];
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        
        //sms and email data
        $SmsEditor = SmsEditor::where('type', 'password_updated')->first();
        $EmailEditor = EmailEditor::where('type', 'password_updated')->first();
        $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
        $verification_email = $EmailEditor->verification;
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        //string replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $myString = $sms;
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            
            $final_sms = str_replace('[address]', $user[0]->cust_address, $final_sms);
            
            $final_sms = str_replace('[phone]', $phone, $final_sms);
            }
        }
        //verification and validating 
        $verification = $SmsEditor->verification;
        $validate = DB::select('select * from ba_token where user_id = ? and token = ? and status = ?', [$user_id, $otp, 0]);
        if(isset($validate[0])) {
        DB::update("update ba_token set status = 1 where id = ?", [$validate[0]->id]);
        DB::update('update ba_account_holders set cust_password = ? where user_id = ?', [$pin, $user_id]);
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        
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
        
        if($verification_email == 1) {
        
            $data = array('user'=>$user,'card' =>$request->all() ,'phone'=>$phone, $user[0]->cust_address);   
            
            $this->dynamic_email_without_token($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
        }
        
        }
            UserActivity::saveUserActivity($request->session()->get('id'),'Account Pin Change');
            echo json_encode(array('success' => true));
        }
        else {
            echo json_encode(array('success' => true, 'valid' => false));
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
        
        if(isset($data['card']['card_number'])){
        $message = str_replace('[card_number]', $data['card']['card_number'], $message);
        }
        
        if(isset($data['card']['card_type'])){
        $message = str_replace('[card_type]',$data['card']['card_type'] , $message);
        }
        if(isset($data['address'])){
        $message = str_replace('[address]',$data['address'],$message);
        }
        
        if(isset($data['phone'])){
        $message = str_replace('[phone]',$data['phone'],$message);
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
        
        if(isset($data['token'])){
        $token = $data['token'];
        }
        
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
    public function dynamic_email_without_token($data, $message, $subject, $to_email, $from_email){
        
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
    
    public function transactionAlertActivation(Request $request) {
        $data = array();
        $data['main'] = 'config';
        $data['page'] = 'transaction-alert-activation';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $data['option'] = DB::select('select * from ba_options where user_id = ?', [$user_id]);
        return view('transaction-alert-activation', $data);
    }

    public function updateTransactionAlert(Request $request) {
        $user_id = $request->session()->get('user_id');

        $data = $request->input();
        $email_notification = 0;
        $sms_notification = 0;
        
        if(isset($data['email_notification'])) {
            $email_notification = 1;
        }

        if(isset($data['sms_notification'])) {
            $sms_notification = 1;
        }

        $validate = DB::select('select * from ba_options where user_id = ?', [$user_id]);
        if(isset($validate[0])) {
            DB::update('update ba_options set step2_send_via_email = ?, step3_send_via_email = ?, step4_send_via_email = ?, step2_send_via_sms = ?, step3_send_via_sms = ?, step4_send_via_sms = ? where user_id = ?', [$email_notification, $email_notification, $email_notification, $sms_notification, $sms_notification, $sms_notification, $user_id]);
        }
        else {
            DB::insert('insert into ba_options set step2 = ?, step3 = ?, step4 = ?, step2_send_via_email = ?, step3_send_via_email = ?, step4_send_via_email = ?, step2_send_via_sms = ?, step3_send_via_sms = ?, step4_send_via_sms = ?, user_id = ?', [0, 0, 0, $email_notification, $email_notification, $email_notification, $sms_notification, $sms_notification, $sms_notification, $user_id]);
        }

        $data = array();
        $data['main'] = 'config';
        $data['page'] = 'transaction-alert-activation';
        $data['msg'] = 'Transaction Alert Updated Successfully';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        UserActivity::saveUserActivity($request->session()->get('id'),'Transaction Alert Update');
        return view('notification', $data);
    }

    public function updateVerification(Request $request) {
        $data = array();
        $data['main'] = 'config';
        $data['page'] = 'update-verification';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $data['customer'] = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        return view('update-verification', $data);
    }

    public function updateVerificationDB(Request $request) {
        $allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf');
        $user_id = $request->session()->get('user_id');

        $data = array();

        $photo = $request->file('photo');
        if(!empty($photo) && !empty($photo_path = $photo->getRealPath()) && !empty($photo_name = $photo->getClientOriginalName())) {
            $photo_ext = $photo->getClientOriginalExtension();
            $photo_type = $photo->getMimeType();

            if(!in_array($photo_type, $allowed_types)) {
                flash('Please upload allowed file type in photo')->error();
                return redirect()->intended('update-verification');
            }

            $data['cust_photo'] = 'data:image/' . $photo_type . ';base64,' . base64_encode(file_get_contents($photo->getRealPath()));
        }

        $national_id = $request->file('national_id');
        if(!empty($national_id) && !empty($national_id_path = $national_id->getRealPath()) && !empty($national_id_name = $national_id->getClientOriginalName())) {
            $national_id_ext = $national_id->getClientOriginalExtension();
            $national_id_type = $national_id->getMimeType();

            if(!in_array($national_id_type, $allowed_types)) {
                flash('Please upload allowed file type in national id')->error();
                return redirect()->intended('update-verification');
            }

            $data['cust_natioanl_id'] = 'data:image/' . $national_id_type . ';base64,' . base64_encode(file_get_contents($national_id->getRealPath()));
        }

        $verification_document = $request->file('verification_document');
        if(!empty($verification_document) && !empty($verification_document_path = $verification_document->getRealPath()) && !empty($verification_document_name = $verification_document->getClientOriginalName())) {
            $verification_document_ext = $verification_document->getClientOriginalExtension();
            $verification_document_type = $verification_document->getMimeType();

            if(!in_array($verification_document_type, $allowed_types)) {
                flash('Please upload allowed file type in verification document')->error();
                return redirect()->intended('update-verification');
            }

            $data['verification_document'] = 'data:image/' . $verification_document_type . ';base64,' . base64_encode(file_get_contents($verification_document->getRealPath()));
        }

        $query = '';
        foreach($data as $col => $value) {
            if($query == '') {
                $query = "$col = '$value'";
            }
            else {
                $query .= ", $col = '$value'";
            }
        }
        
        if($query != '') {
            DB::update("update ba_account_holders set $query where user_id = ?", [$user_id]);

            $data = array();
            $data['main'] = 'config';
            $data['page'] = 'update-verification';
            $data['msg'] = 'Verification Updated Successfully';
            $data['bankName'] = $this->bankName;
            $data['logo'] = $this->logo;
            UserActivity::saveUserActivity($request->session()->get('id'),'Update Verification / Signature');
            return view('notification', $data);
        }
        else {
            flash('Something went wrong')->error();
            return redirect()->intended('update-verification');
        }
    }
}
