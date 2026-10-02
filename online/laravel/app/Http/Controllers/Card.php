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

class Card extends Controller {

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
    public function requestCard(Request $request) {
        $data = array();
        $data['main'] = 'card';
        $data['page'] = 'request-card';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
         $this->store_page_logs('request-card',$request->session()->get('user_id'));
        return view('request-card', $data);
    }

    public function insertCardRequest(Request $request) {
        
        $data = $request->input();
        $user_id = $request->session()->get('user_id');
        $data['user_id'] = $user_id;
        $data['date'] = date("Y-m-d H:i:s");
        unset($data['_token']);
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            //sms and email data
        $SmsEditor = SmsEditor::where('type', 'card_request_success')->first();
        $EmailEditor = EmailEditor::where('type', 'card_request_success')->first();
        $phone = $user[0]->cust_countrycode . " " . $user[0]->cust_phone;
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        
        $sms = $SmsEditor->sms;
        
        $verification_email = $EmailEditor->verification;
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $myString = $sms;
        //check and replace
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[user_id]','[address]','[phone]' ]);
              if($contains) {
                   $final_sms = str_replace('[user_id]', $user_id, $final_sms);
                   $final_sms = str_replace('[address]', $user[0]->cust_address, $final_sms);
                   $final_sms = str_replace('[phone]', $phone, $final_sms);
                }
        }
        
        $verification = $SmsEditor->verification;
        $query = '';
        foreach($data as $col => $value) {
            if($query == '') {
                $query = "$col = '$value'";
            }
        else {
            $query .= ", $col = '$value'";
            }
        }
        
        DB::insert("insert into ba_cards set $query");
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            //sending sms and email with 
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
            
           

                $data = array('user'=>$user, 'card' =>$request->all(),'address'=>$user[0]->cust_address, 'phone'=>$phone,'user_id'=>$user[0]->user_id);   
                
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
            }
        
        }
        
        UserActivity::saveUserActivity($request->session()->get('id'),'New Card Request');
        flash('Card Requested Successfully')->success();
        return redirect()->intended('request-card');
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
            
        if(isset($data['user_id'])){
                $message = str_replace('[user_id]',$data['user_id'],$message);
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
    public function viewCards(Request $request) {
    	$data = array();
    	$data['main'] = 'card';
    	$data['page'] = 'view-cards';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
       
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['cards'] = DB::select('select * from ba_cards where user_id = ? order by date desc', [$user_id]);
         $this->store_page_logs('view-card',$request->session()->get('user_id'));
        return view('view-cards', $data);
    }

    public function suspendCard(Request $request, $id) {
        DB::update('update ba_cards set status = 2 where id = ?', [$id]);

        flash('Card Suspended Successfully')->success();
        return redirect()->intended('view-cards');
    }

    public function blockCard(Request $request, $id) {
        DB::update('update ba_cards set status = 3 where id = ?', [$id]);

        flash('Card Blocked Successfully')->success();
        return redirect()->intended('view-cards');
    }

    public function updateCardPin(Request $request) {
        $data = array();
        $data['main'] = 'card';
        $data['page'] = 'update-card-pin';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select * from ba_user_accounts where user_id = ? and access = 1', [$user_id]);
        
         $this->store_page_logs('update-card-pin',$request->session()->get('user_id'));
        return view('update-card-pin', $data);
    }

    public function getCardsToUpdatePin(Request $request) {
        $user_id = $request->session()->get('user_id');

        $account_no = $request->input('account_no');

        $cards = DB::select('select * from ba_cards where cust_act_number = ? and user_id = ? and status = 1', [$account_no, $user_id]);

        echo json_encode($cards);
    }

    public function updateCardPinDB(Request $request) {
        $data = $request->input();

        $user_id = $request->session()->get('user_id');

        $account = $data['account'];
        $card = $data['card'];
        $old_pin = $data['old_pin'];
        $new_pin = $data['new_pin'];
        $confirm_new_pin = $data['confirm_new_pin'];

        if($new_pin == $confirm_new_pin) {
            $card_det = DB::select('select * from ba_cards where id = ? and user_id = ?', [$card, $user_id]);
            if($card_det[0]->card_pin == $old_pin) {
                DB::update("update ba_cards set card_pin = ? where id = ?", [$new_pin, $card]);
                UserActivity::saveUserActivity($request->session()->get('id'),'Card Pin Update');
                flash('Card Pin Updated Successfully')->success();
                return redirect()->intended('update-card-pin');
            }
            else {
                flash('Incorrect Old Pin')->error();
                return redirect()->intended('update-card-pin');
            }
        }
        else {
            flash('New Pin and Confirm New Pin does not match')->error();
            return redirect()->intended('update-card-pin');
        }
    }
}
