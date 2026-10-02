<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
Use \Carbon\Carbon;
use App\SmsEditor;
use App\EmailEditor;
use Illuminate\Support\Str;
use App\UserActivity;

class Loan extends Controller {

    public function __construct() {
        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
         $config = DB::select('select bank_email, sms_token, sms_sid, sms_phone,bank_name,logo  from configs where 1');
        
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
      $date->timezone = 'Africa/Lagos';
     $ip =$this->getIp();
     $login_time = $date->toRfc850String();
      DB::insert('insert into page_logs (userid,ip, stamp,page) values (?,?, ?,?)', [$user_id,$ip,$login_time,$page]);
             
 }

    public function requestLoan(Request $request) {
        $data = array();
        $data['main'] = 'loan';
        $data['page'] = 'request-loan';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $this->store_page_logs('request-loan',$request->session()->get('user_id'));
        return view('request-loan', $data);
    }

    public function requestLoanForm(Request $request) {
        $data = array();
        $data['main'] = 'loan';
        $data['page'] = 'request-loan';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select * from ba_user_accounts where user_id = ? and access = 1', [$user_id]);
        $this->store_page_logs('request-loan-form',$request->session()->get('user_id'));
        return view('request-loan-form', $data);
    }

    public function insertLoanRequest(Request $request) {
        $allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp');

        $data = $request->input();

        $user_id = $request->session()->get('user_id');

        $data['user_id'] = $user_id;

        unset($data['_token']);
        unset($data['info_correct']);
        unset($data['next']);
        unset($data['photo']);
        unset($data['signature']);
        unset($data['salary_slip']);

        $photo = $request->file('photo');
        if(!empty($photo) && !empty($photo_path = $photo->getRealPath()) && !empty($photo_name = $photo->getClientOriginalName())) {
            $photo_ext = $photo->getClientOriginalExtension();
            $photo_type = $photo->getMimeType();

            if(!in_array($photo_type, $allowed_types)) { flash('Please upload
            allowed file type in Photo')->error(); return
            redirect()->intended('request-loan-form'); }

            $data['photo'] = 'data:image/' . $photo_type . ';base64,' . base64_encode(file_get_contents($photo->getRealPath()));
        }

        $signature = $request->file('signature');
        if(!empty($signature) && !empty($signature_path = $signature->getRealPath()) && !empty($signature_name = $signature->getClientOriginalName())) {
            $signature_ext = $signature->getClientOriginalExtension();
            $signature_type = $signature->getMimeType();

            if(!in_array($signature_type, $allowed_types)) { flash('Please
            upload allowed file type in Signature')->error(); return
            redirect()->intended('request-loan-form'); }

            $data['signature'] = 'data:image/' . $signature_type . ';base64,' . base64_encode(file_get_contents($signature->getRealPath()));
        }

        $salary_slip = $request->file('salary_slip');
        if(!empty($salary_slip) && !empty($salary_slip_path = $salary_slip->getRealPath()) && !empty($salary_slip_name = $salary_slip->getClientOriginalName())) {
            $salary_slip_ext = $salary_slip->getClientOriginalExtension();
            $salary_slip_type = $salary_slip->getMimeType();

            if(!in_array($salary_slip_type, $allowed_types)) { flash('Please
            upload allowed file type in salary slip')->error(); return
            redirect()->intended('request-loan-form'); }

            $data['salary_slip'] = 'data:image/' . $salary_slip_type . ';base64,' . base64_encode(file_get_contents($salary_slip->getRealPath()));
        }

        $data['loan_amount'] = str_replace(",", "", $data['loan_amount']);
        $query = '';
        foreach($data as $col => $value) {
            if($query == '') {
                $query = "$col = '$value'";
            }
            else {
                $query .= ", $col = '$value'";
            }
        }

        DB::insert("insert into ba_loans set $query");

        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        
        $SmsEditor = SmsEditor::where('type', 'loan_approved')->first();
        
        $EmailEditor = EmailEditor::where('type', 'loan_approved')->first();
        
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
         
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;

        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
           // $msg = 'You have successfully requested a loan. We will soon provide you an update for the same.';
          
             $msg = $final_sms;
            
            if ($verification == 1) {
                foreach($recipients_arr as $recipient) {
                $client->messages->create($recipient, 
                ['from' => $this->fromNumber, 'body' => $msg] );
            }
            }

             if($verification_email == 1) {
            
                $data = array('user'=>$user, 'card' =>$request->all());   
                
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
            }
           /* Mail::raw($msg, function($message) use ($user)
            {
                $message->from($this->fromEmail, 'Banking');

                $message->subject('Loan Request');

                $message->to($user[0]->cust_mail);
            });*/
        }

        $data = array();
        $data['main'] = 'loan';
        $data['page'] = 'request-loan';
        $data['msg'] = 'Loan Requested Successfully';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        UserActivity::saveUserActivity($request->session()->get('id'),'New Loan Request');
        return view('notification', $data);
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
            
        $finals_message .= '<p style="position: relative;top: 136px;">' . $message .'</p>';  
             
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
    public function loanSummary(Request $request) {
    	$data = array();
    	$data['main'] = 'loan';
    	$data['page'] = 'loan-summary';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');

        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['loans'] = DB::select('select ba_loans.*, ba_user_accounts.account_currency from ba_loans inner join ba_user_accounts on ba_loans.account_no=ba_user_accounts.account_no where ba_loans.user_id = ? order by ba_loans.id desc', [$user_id]);
        $this->store_page_logs('loan-summery',$request->session()->get('user_id'));
        return view('loan-summary', $data);
    }
}
