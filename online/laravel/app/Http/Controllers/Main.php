<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Session;
use Mail;
use Twilio\Rest\Client;
Use \Carbon\Carbon;
use App\SmsEditor;
use App\EmailEditor;
// use App\Listing;
use Illuminate\Http\Request;
use App\UserActivity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use URL;

class Main extends Controller {

    public function __construct() {
        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);

         $config = DB::select('select bank_email,bank_fax, bank_support_person,bank_phone,bank_name, logo, sms_token, sms_sid,bank_url, sms_phone, sms_token from configs where 1');

        
        $this->bankName = $config[0]->bank_name;

       $this->logo = $config[0]->logo;

        $this->bankPhone = $config[0]->bank_phone;
        $this->fromNumber = $config[0]->sms_phone;
        $this->bank_support_person = $config[0]->bank_support_person;
        $this->bank_fax = $config[0]->bank_fax;
        
        $this->accountSid = $config[0]->sms_sid;

        $this->authToken = $config[0]->sms_token;

        $this->bank_url = $config[0]->bank_url;

         $this->fromEmail = $config[0]->bank_email;


        $this->env = 'live';
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $this->env = 'local';
        }

         // timezone

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
        
        $config = DB::table('configs')->where('id','1')->first();
        if(config('app.env') !== 'local') {
	    if($config->licence_key != "" || $config->licence_key != NULL){
    	    $domain = str_replace("http://","",str_replace("https://","",str_replace("/".$config->client_folder,"",URL::to('/'))));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/check_purchase_key_with_domain");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,"key=".$config->licence_key."&domain=".$domain);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $coderanita = curl_exec($ch);
            curl_close($ch);
            if(json_decode($coderanita)->status == "500"){
                if(\Request::route()->getName() != "no-key"){
                    redirect()->route('no-key')->send();
                }
    	    }
	    }else{
            if(\Request::route()->getName() != "no-key"){
                redirect()->route('no-key')->send();
            }
	    }
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
    
    public function noKey(){
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bank_url'] = $this->bank_url;
        return view('no-purchase-key',$data);
    }
    
    public function store_page_logs($page,$user_id){
      $date = Carbon::now();
     $ip =$this->getIp();
     $login_time = $date->toRfc850String();
      DB::insert('insert into page_logs (userid,ip, stamp,page) values (?,?, ?,?)', [$user_id,$ip,$login_time,$page]);
    
    }

    public function index(Request $request) {
        //echo date_default_timezone_get();exit;
        // print_r(UserActivity::saveUserActivity("",""));
        // exit;
    	$data = array();
    	$data['main'] = 'dashboard';
    	$data['page'] = '';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bank_url'] = $this->bank_url;


        $user_id = $request->session()->get('user_id');
        $data['summary'] = DB::select('select available_balance, account_currency, (select count(*) as cnt from ba_transactions where ba_transactions.user_id = ? and ba_transactions.status = 0 and ba_transactions.type = ?) as pending from ba_user_accounts where ba_user_accounts.user_id = ? order by ba_user_accounts.id asc limit 1', [$user_id, 'debited', $user_id]);

        $data['transactions'] = DB::select('select * from ba_transactions where user_id = ? and status = 1 and type = ?', [$user_id, 'debited']);
        foreach($data['transactions'] as &$transaction) {
            $account = DB::select('select account_currency from ba_user_accounts where account_no = ?', [$transaction->act_number]);
            $transactions2 = DB::select('select * from ba_transactions where user_id = ? and status = 1 and tran_id = ? and id != ? and type = ?', [$user_id, $transaction->tran_id, $transaction->id, 'credited']);
            $transaction->other_transactions = $transactions2;
            $transaction->account_currency = $account[0]->account_currency;
        }
        //$data['transactions'] = DB::select('', [$user_id, 'debited']);
        //$notifaction=  new Controller();
        //$notifaction->user_notifactions($user_id);

        $account = DB::table('ba_user_accounts')->where('user_id', $user_id)->orderBy('id', 'asc')->first();
        $all_accounts = DB::table('ba_user_accounts')->where('user_id', $user_id)->orderBy('id', 'asc')->get();
        $data['all_accounts'] = $all_accounts;

        $totalBalance = 0;
        foreach($all_accounts as $acc) {
            $totalBalance += (float)($acc->available_balance ?? 0);
        }
        $data['total_balance'] = $totalBalance;

        if($account){
            $data['balance']    = $account->available_balance;
            $data['currency']   = $account->account_currency ?: 'USD';
            $data['acno']       = "•••• ".substr($account->account_no, -4);
            $data['full_acno']  = $account->account_no;
            $data['actype']     = $account->account_type ?: 'Commercial Checking';
        }else{
            $data['balance']    = 0.00;
            $data['currency']   = "USD";
            $data['acno']       = "N/A";
            $data['full_acno']  = "";
            $data['actype']     = "Commercial Checking";
        }

        $user_info = DB::select('select * from ba_account_holders where user_id =?',[$request->session()->get('user_id')]);
        $uInfo = !empty($user_info) ? $user_info[0] : null;
        $data['cust_name'] = $uInfo ? trim(($uInfo->cust_name ?? '').' '.($uInfo->middle_name ?? '').' '.($uInfo->sur_name ?? '')) : 'Valued Client';
        $data['dob'] = $uInfo->dob ?? '';
        $data['email'] = $uInfo->cust_mail ?? '';
        $data['cust_phone'] = $uInfo->cust_phone ?? '';
        $data['cust_phone_country_code'] = $uInfo->cust_countrycode ?? '';
        $data['address'] = $uInfo->cust_address ?? '';
        $data['postcode'] = $uInfo->post_code ?? '';
        $data['country'] = $uInfo->cust_country ?? '';
        $data['loan'] = DB::table('ba_loans')->orderby('id','desc')->where('user_id',$request->session()->get('user_id'))->first();
        $data['deposits'] = DB::table('ba_user_deposit')->where('user',$request->session()->get('user_id'))->orderby('id','desc')->limit(3)->get();
        
        // Dynamic transactions and metrics from ba_transactions
        $allUserTx = DB::table('ba_transactions')->where('user_id', $user_id)->get();
        $inflowSum = 0;
        $inflowCount = 0;
        $outflowSum = 0;
        $outflowCount = 0;
        foreach($allUserTx as $tx) {
            $amt = (float)($tx->amount ?? 0);
            $type = strtolower($tx->type ?? '');
            if($type == 'credited' || $type == 'credit') {
                $inflowSum += $amt;
                $inflowCount++;
            } elseif($type == 'debited' || $type == 'debit' || $type == 'charges' || $type == 'charge') {
                $outflowSum += $amt;
                $outflowCount++;
            }
        }
        $data['total_inflow']   = $inflowSum;
        $data['inflow_count']   = $inflowCount;
        $data['total_outflow']  = $outflowSum;
        $data['outflow_count']  = $outflowCount;
        
        $data['transactions'] = DB::table('ba_transactions')->where('user_id', $user_id)->orderby('datetime','desc')->limit(10)->get();
        $data['cards'] = DB::table('ba_cards')->where('user_id', $user_id)->get();
        
        $data['pay_colle'] = DB::table('ba_payments')->where('user',$request->session()->get('id'))->orderby('id','desc')->limit(6)->get();
        $invoices = DB::table('ba_payments')->where('user',$request->session()->get('id'))->get();
        $paymentDue = 0;
        foreach($invoices as $inv){
            $paymentDue += ($inv->price ?? 0) - ($inv->paid ?? 0);
        }
        $data['pay_due']    = $paymentDue;
        
        $data['btc_fund'] = $uInfo->btc_fund ?? '0.00';
        $data['eth_fund'] = $uInfo->eth_fund ?? '0.00';
        $data['usdt_fund'] = $uInfo->usdt_fund ?? '0.00';
      
        return view('index', $data);
    }
    
     public function portfolio(Request $request) {
        //echo date_default_timezone_get();exit;
        // print_r(UserActivity::saveUserActivity("",""));
        // exit;
    	$data = array();
    	$data['main'] = 'dashboard';
    	$data['page'] = '';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bank_url'] = $this->bank_url;


        $user_id = $request->session()->get('user_id');
        $data['summary'] = DB::select('select available_balance, account_currency, (select count(*) as cnt from ba_transactions where ba_transactions.user_id = ? and ba_transactions.status = 0 and ba_transactions.type = ?) as pending from ba_user_accounts where ba_user_accounts.user_id = ? order by ba_user_accounts.id asc limit 1', [$user_id, 'debited', $user_id]);

        $data['transactions'] = DB::select('select * from ba_transactions where user_id = ? and status = 1 and type = ?', [$user_id, 'debited']);
        foreach($data['transactions'] as &$transaction) {
            $account = DB::select('select account_currency from ba_user_accounts where account_no = ?', [$transaction->act_number]);
            $transactions2 = DB::select('select * from ba_transactions where user_id = ? and status = 1 and tran_id = ? and id != ? and type = ?', [$user_id, $transaction->tran_id, $transaction->id, 'credited']);
            $transaction->other_transactions = $transactions2;
            $transaction->account_currency = $account[0]->account_currency;
        }
        //$data['transactions'] = DB::select('', [$user_id, 'debited']);
        //$notifaction=  new Controller();
        //$notifaction->user_notifactions($user_id);

        $account = DB::table('ba_user_accounts')->where('user_id',$user_id)->inRandomOrder()->limit(1)->first();
        if($account){
            $data['balance']    = $account->available_balance;
            $data['currency']   = $account->account_currency;
            $data['acno']       = "xxxxxxx".substr($account->account_no,-4);
            $data['actype']     = $account->account_type;
        }else{
            $data['balance'] = 0.00;
            $data['currency'] = "USD";
            $data['acno']       = "N/A";
            $data['actype']     = "";
        }

        $user_info = DB::select('select * from ba_account_holders where user_id =?',[$request->session()->get('user_id')]);
        $uInfo = !empty($user_info) ? $user_info[0] : null;
        $data['cust_name'] = $uInfo ? trim(($uInfo->cust_name ?? '').' '.($uInfo->middle_name ?? '').' '.($uInfo->sur_name ?? '')) : 'Valued Client';
        $data['dob'] = $uInfo->dob ?? '';
        $data['email'] = $uInfo->cust_mail ?? '';
        $data['cust_phone'] = $uInfo->cust_phone ?? '';
        $data['cust_phone_country_code'] = $uInfo->cust_countrycode ?? '';
        $data['address'] = $uInfo->cust_address ?? '';
        $data['postcode'] = $uInfo->post_code ?? '';
        $data['country'] = $uInfo->cust_country ?? '';
        $data['loan'] = DB::table('ba_loans')->orderby('id','desc')->where('user_id',$request->session()->get('user_id'))->first();
        $data['deposits'] = DB::table('ba_user_deposit')->where('user',$request->session()->get('user_id'))->orderby('id','desc')->limit(3)->get();
        $data['transactions'] = DB::table('ba_transactions')->where('user_id',$request->session()->get('user_id'))->orderby('id','desc')->limit(6)->get();
        $data['pay_colle'] = DB::table('ba_payments')->where('user',$request->session()->get('id'))->orderby('id','desc')->limit(6)->get();
        $invoices = DB::table('ba_payments')->where('user',$request->session()->get('id'))->get();
        $paymentDue = 0;
        foreach($invoices as $inv){
            $paymentDue += ($inv->price ?? 0) - ($inv->paid ?? 0);
        }
        $data['pay_due']    = $paymentDue;
        
        $data['btc_fund'] = $uInfo->btc_fund ?? '0.00';
        $data['eth_fund'] = $uInfo->eth_fund ?? '0.00';
        $data['usdt_fund'] = $uInfo->usdt_fund ?? '0.00';
      
        return view('portfolio', $data);
    }

    public function login() 
        {
           $data = array();
           $data['bankName'] = $this->bankName;
           $data['logo'] = $this->logo;
           $data['bank_url'] = $this->bank_url;
          
        if (session('captcha_verified')) 
        {
          return view('login', $data);       
           
        } else 
        {
          return view('captcha', $data); 
        }  
        
        
    }
    
    public function captcha() 
    {
          session(['captcha_verified' => true]);
          return redirect()->intended('login');
        
    }


    public function loginUser(Request $request) {
        $user_id = $request->input('user_id');
        $password = $request->input('password');
        $config = DB::table('configs')->where('id','1')->first();

        if(!empty($user_id) && !empty($password)) {
            $check = DB::select('select * from ba_account_holders where user_id = ? and cust_password = ? and df = ?',[$user_id, $password,'no']);
            if(isset($check[0])) {
                if($check[0]->account_status == 1  && $check[0]->verification == 1) {
                    $request->session()->put('id', $check[0]->id);
                    $request->session()->put('cust_name', $check[0]->cust_name);
                    $request->session()->put('middle_name', $check[0]->middle_name);
                    $request->session()->put('sur_name', $check[0]->sur_name);
                    $request->session()->put('user_id', $check[0]->user_id);
                    $request->session()->put('cust_id', $check[0]->customer_id);
                    $request->session()->put('cust_mail', $check[0]->cust_mail);
                    $request->session()->put('cust_photo', $check[0]->cust_photo);
                    $request->session()->put('bank_url', $this->bank_url);
                    $request->session()->put('time_msg', $this->time_msg);

                    return redirect()->intended('secret-question');
                }
                elseif ($check[0]->verification == 0){
                    $account_holder = DB::table('ba_account_holders')->where('user_id',$request->input('user_id'))->first();
                    $data2['name'] = $account_holder->cust_name ." ". $account_holder->sur_name;
                    $data2['email'] = $account_holder->cust_mail;
                    $user_id = $account_holder->user_id;
                    
                    $mail_otp = $account_holder->mail_otp;
                    $message_otp = $account_holder->message_otp;

                    
                    $data['bankName'] = $this->bankName;
                    
                    // Sms
                    
                    $client = new Client($this->accountSid, $this->authToken);
                    
                    $recipient =  $account_holder->cust_countrycode.$account_holder->cust_phone;
                    
                    $msg = 'Your Verification code: '.$message_otp;
                    
                     try {
                          //code...
                        $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg] );
                        
                        
                      } catch (\Throwable $th) {
                         //$config = DB::table('configs')->where('id','1')->first();
                         //flash("Phone number is not valid or Twilio can't send a message to this phone number, Please contact customer support at ".$config->admin_support_phone.' or email us at '.$config->bank_email)->error();
                         //return redirect()->back();
                         
                      }
                    
                    // Sms End
                        
                    $subject = "Verification code for " . $data['bankName'];

                    $logo_link = "https://" . $this->bank_url . "/admin/uploads/" . $this->logo;
                    $message = '<img src=' . $logo_link . ' alt="banking" style="display: block;
                    margin-left: auto;
                    margin-right: auto;
                    width: 15%;">';
                    
                    $message .= '<p><b>Dear ' . $data2['name'] . '</b></p>'.'<br> Your verification code is :' . $mail_otp . '';


                    $body = "<html><head></head><body>";
                    $body .= $message;
                    $body .= "</body></html>";

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    $headers .= 'From: ' . $this->bankName . ' <' . $this->fromEmail . '>' . "\r\n";

                  Mail::send([], [], function ($message) use ($data2, $subject, $body) {
    $message->to($data2['email'])
            ->subject($subject)
            ->setBody($body, 'text/html');
});
                    flash('Please check your entered email '.$data2['email'])->warning();
                    
                    return view('my-account.unregister_account', ['user_id'=>$user_id]);

                }
                elseif($check[0]->account_status == 0) {
                    flash('We cant login you into this user Profile at this time, as this profile is still pending KYC Verification and is yet to be activated, Please contact our account officer to expediate the process, you can also contact customer support at '.$config->admin_support_phone.' or email us at '.$config->bank_email)->error();
                    return redirect()->intended('login');
                }
                elseif($check[0]->account_status == 2) {
                    flash('We cant login you into this user Profile at this time, as this profile is still pending KYC Verification and is yet to be activated, Please contact our account officer to expediate the process, you can also contact customer support at '.$config->admin_support_phone.' or email us at '.$config->bank_email)->error();
                    return redirect()->intended('login');
                }
                elseif($check[0]->account_status == 3) {
                    flash('We cant login you into this user Profile at this time, as this profile is still pending KYC Verification and is yet to be activated, Please contact our account officer to expediate the process, you can also contact customer support at '.$config->admin_support_phone.' or email us at '.$config->bank_email)->error();
                    return redirect()->intended('login');
                }
                elseif($check[0]->account_status == 4) {
                    flash('We cant login you into this user Profile at this time, as this profile is still pending KYC Verification and is yet to be activated, Please contact our account officer to expediate the process, you can also contact customer support at '.$config->admin_support_phone.' or email us at '.$config->bank_email)->error();
                    return redirect()->intended('login');
                }
            }
            else {
                flash('Please check your credentials')->error();
                return redirect()->intended('login');
            }
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('login');
        }
    }
    
    public function verifyunregisteraccount(Request $request)
    {
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";
        $data['otp'] = 'show';
        $data['user_id'] = $request->user_id;
        $data2 = $request->input();
        
        if (isset($data2['mailotp'])) {
        


            $autoactive = DB::select('SELECT auto_activate as resultado FROM `reg_form_settings` LIMIT 1 ', ['']);
            if($autoactive[0]->resultado == 0){
                DB::table('ba_account_holders')->where('user_id',$data['user_id'])->update([
                    'account_status'=>0
                ]);
            }else{

                DB::table('ba_account_holders')->where('user_id',$data['user_id'])->update([
                    'account_status'=>1
                ]);
            }
            
            $data['select'] = DB::table('ba_account_holders')->where('user_id',$data['user_id'])->first();
            $user_password = $data['select']->cust_password;
            $data['id'] = $data['select']->id;
                
            if ($data2['mailotp'] == $data['select']->mail_otp) {
               
                
                DB::table('ba_account_holders')->where('user_id',$data['user_id'])->update([
                   'verification'=>1
                ]);

                $nuevos = DB::select('SELECT (max(user_id)+7) as user,(max(customer_id)+17) as id FROM `ba_account_holders`', ['']);
                    if($nuevos[0]->user == ""){
                        $nuevos[0]->user    = rand(11111,99999);
                    }
                    if($nuevos[0]->id == ""){
                        $nuevos[0]->id    = rand(11111,99999);
                    }
                $smsdata = DB::select('SELECT sms FROM sms_editor WHERE name ="Account Opening Approval For Login Unregister user"');

                $smstext = $smsdata[0]->sms;
             
                
                $smswords = ["[first_name]","[last_name]","[bank_name]","[user_id]","[customer_id]","[password]","[account_type]","[password]"];
                $smschange = [$data['select']->cust_name,$data['select']->sur_name,$this->bankName,$data['select']->user_id,$data['select']->customer_id,$user_password,'Approved','1111'];
                $smsphrase = str_replace($smswords,$smschange,$smstext);


                $messagedata = DB::select('SELECT email FROM email_editor WHERE name ="Account Opening Approval Notice For Login Unregister user"');

                $str = $messagedata[0]->email;


                $words = ["[first_name]", "[last_name]", "[bank_name]","[branch_name]", "[first_name]", "[user_id]", "[password]", "[customer_id]", "[account_type]", " [bank_name]","[branch_name]","[bank_support_person]", "[bank_name]", "[bank_phone]", "[bank_fax]"];
                $change   = [$data['select']->cust_name,$data['select']->sur_name,$this->bankName, Session::get('branch'),$data['select']->cust_name, $data['select']->user_id,$user_password,$data['select']->customer_id,'Approved',$this->bankName,Session::get('branch'),$this->bank_support_person,Session::get('branch'), $this->bankPhone,$this->bank_fax];

                $newPhrase = str_replace($words, $change, $str);

                $client = new Client($this->accountSid, $this->authToken);
                $recipient =  $data['select']->cust_countrycode.$data['select']->cust_phone;
                $msg = $smsphrase;
                
                
               
                    
                    try {
                          //code...
                       $client->messages->create($recipient,
                    ['from' => $this->fromNumber, 'body' => $msg] );
                        
                      } catch (\Throwable $th) {
                        
                         
                      }       

                $subject = "Your new account for " . $this->bankName;

                $logo_link = "https://" . $this->bank_url . "/admin/uploads/" . $this->logo;
                $message = '<img src=' . $logo_link . ' alt="banking" style="display: block;
                    margin-left: auto;
                    margin-right: auto;
                    width: 15%;">';

                $message .= '<p>
                    '.$newPhrase.'</p>';

                $body = "<html><head></head><body>";
                $body .= $message;
                $body .= "</body></html>";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                $headers .= 'From: ' . $this->bankName . ' <' . $this->fromEmail . '>' . "\r\n";

             Mail::send([], [], function ($message) use ($data, $subject, $body) {
    $message->to($data['select']->cust_mail)
            ->subject($subject)
            ->setBody($body, 'text/html');
});
                // echo $data['id'] ;
                // exit();
                // $customer = DB::table('ba_account_holders')->where('id',$data['id'])->update([
                //     'verification'=>1
                // ]);


                flash('Contact Information has been Verified')->success();
                               
                return redirect()->intended('login');

            }
            else {
                    
                flash('Wrong OTP, try again')->error();
                return redirect()->intended('login');
            }
        }
    }


    public function secretQuestion(Request $request) {
    	$id = $request->session()->get('id');
		$question_no = rand(1, 2);

		if($question_no == 1) {
			$query = DB::select('select qid from ba_account_holders where id = ?',[$id]);
			$question = $query[0]->qid;
		}
		elseif($question_no == 2) {
			$query = DB::select('select qid2 from ba_account_holders where id = ?',[$id]);
			$question = $query[0]->qid2;
		}

        return view('secret-question', ['question_no' => $question_no, 'question' => $question, 'bankName' => $this->bankName, 'logo' => $this->logo]);
    }

    public function validateSecretQuestion(Request $request) {

        $date = Carbon::now();
        $id = $request->session()->get('id');
        $user_id = $request->session()->get('user_id');
        $question_no = $request->input('question_no');
        $answer = $request->input('answer');
        $customer = DB::select('select * from ba_account_holders WHERE id = ?',[$id]);
        $password =  $customer[0]->cust_password;

        $cutsomer_account_info = DB::select('select * from ba_user_accounts WHERE user_id = ?',[$user_id]);

        if(!empty($question_no) && !empty($answer)) {
        	if($question_no == 1) {
        		$check = DB::select('select * from ba_account_holders where id = ? and ans = ?',[$id, $answer]);
        	}
        	elseif($question_no == 2) {
        		$check = DB::select('select * from ba_account_holders where id = ? and ans2 = ?',[$id, $answer]);
        	}

            if(isset($check[0])) {

            // email on login
            $request->session()->put('secret_question', true);

            $cust_name = $request->session()->get('cust_name');
            $cust_email = $request->session()->get('cust_mail');

            $config = DB::select('select bank_email from configs where 1');
            $fromEmail = $config[0]->bank_email;
            $date_now = $date->toRfc850String();
            //email data
            $EmailEditor = EmailEditor::where('type', 'login_alert')->first();
            $verification_email = $EmailEditor->verification;

            //sending email
            if($verification_email == 1) {

            
             $data = array('user'=>$cust_name,'user_id'=> $user_id, 'mail'=>$cust_email, 'date'=>$date_now, 'customer_id'=>$user_id,'password'=>$password);
             $this->dynamic_email_without_token($data, $EmailEditor->email,$EmailEditor->name,  $cust_email, $fromEmail);
            }

         //sms

            $SmsEditor = SmsEditor::where('type', 'login_alert')->first();

            $date_now = date("Y-m-d H:i:s T");
            $customername = $customer[0]->cust_name.' '.$customer[0]->middle_name.' '.$customer[0]->sur_name;

            $customer_id = $customer[0]->customer_id;

              $sms = $SmsEditor->sms;
            //sms replacing
            $final_sms = str_replace('[date]', $date_now, $sms);
            $final_sms = str_replace('[first_name]', $customername, $final_sms);
            $final_sms = str_replace('[customer_id]', $customer_id, $final_sms);
            $final_sms = str_replace('[password]',$password, $final_sms);
             if(isset($cutsomer_account_info[0]->account_no)){
                    $cutsomer_account_info = $cutsomer_account_info[0]->account_no;
                      $final_sms = str_replace('[account_no]', $cutsomer_account_info, $final_sms);
                }
            $verification = $SmsEditor->verification;
            //sending sms
            try {
                //code...
                if($verification == 1){
                if($this->env == 'live') {

                $message = $final_sms;

                $client = new Client($this->accountSid, $this->authToken);
                $client->messages->create($customer[0]->cust_countrycode . " " . $customer[0]->cust_phone,
                ['from' => $this->fromNumber, 'body' => $message] );
                
                }
               }
            } catch (\Throwable $th) {
               // $config = DB::table('configs')->where('id','1')->first();
                //flash("Phone number is not valid or Twilio can't send a message to this phone number, Please contact customer support at ".$config->admin_support_phone.' or email us at '.$config->bank_email)->error();
               // return redirect()->intended('login');
            }
        //   if($verification == 1){
        //         if($this->env == 'live') {

        //         $message = $final_sms;

        //         $client = new Client($this->accountSid, $this->authToken);
        //         $client->messages->create($customer[0]->cust_countrycode . " " . $customer[0]->cust_phone,
        //         ['from' => $this->fromNumber, 'body' => $message] );
                
        //         }
        //   }

            //session check
            $last_session = DB::select('select * from sessions where userid = ?',[$request->session()->get('user_id')]);
            $ip =$this->getIp();
            $login_time = $date->toRfc850String();
            if($last_session){

            $update = DB::table('sessions')
            ->where('userid', $request->session()->get('user_id'))
            ->update(['stamp' =>$login_time ,'ip'=>$ip]);

            }
            else{
            DB::insert('insert into sessions (userid,ip, stamp) values (?,?, ?)', [$request->session()->get('user_id'),$ip,$login_time]);
            }
             $request->session()->put('login_ip', $ip);
             $request->session()->put('login_time', $login_time);

            $notifaction=  new Controller();
            $notifaction->user_notifactions($id);
             $this->store_page_logs('home',$request->session()->get('user_id'));
             
             
                DB::table('ba_account_holders')->where('user_id',$request->session()->get('user_id'))->update(['login_time' => date('Y-m-d H:i:s')]);   
                
                
                
                UserActivity::saveUserActivity($request->session()->get('id'),'Login');
                return redirect()->intended('/');
                

            }
            else {
                flash('Wrong Answer for Secret Question')->error();
                return redirect()->intended('login');
            }
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('login');
        }
    }
    public function dynamic_email_without_token($data, $message, $subject, $to_email, $from_email){

        $config = DB::select('select * from configs WHERE id = ?',[1]);

        if(isset($data['date'])){
        $message = str_replace('[date]',$data['date'], $message);

        }
        if(isset($data['user_id'])){
        $user_id = $data['user_id'];
        }
        if(isset($data['user'])){
        $customername = $data['user'];

        }
        $cutsomer_account_info = DB::select('select * from ba_user_accounts WHERE user_id = ?',[$user_id]);

        if(isset($cutsomer_account_info[0]->account_no)){
        $act_num = $cutsomer_account_info[0]->account_no;
        $message = str_replace('[account_no]',  $act_num, $message);
        }

        if($customername!=''){
        $message = str_replace('[first_name]', $customername, $message);
        }
        if(isset($data['date'])){
        $message = str_replace('[customer_id]',$data['customer_id'], $message);

        }
        if(isset($data['password'])){
        $message = str_replace('[password]',$data['password'], $message);

        }

        $logo_link ="https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
        $finals_message  = '<span class="imeg">' .'<img src='.$logo_link.' alt="banking" style="width:14%;display: block;padding-left: 650px;" />' .'</span>';

        $finals_message .= '<p style="position: relative;top: 136px;">' . $message . '</p>';

        $finals_message .= '<p>
        Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
        If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
        //email body
        $body = "<html><head></head><body>";
        $body .= $finals_message ;
        $body .= "</body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: ' . $this->bankName . ' <'. $from_email .'>' . "\r\n";

       Mail::send([], [], function ($message) use ($to_email, $subject, $body) {
    $message->to($to_email)
            ->subject($subject)
            ->setBody($body, 'text/html');
});


        }

 	public function logoutUser(Request $request) {
 	    $logout_time = DB::table('configs')->where('id','1')->first()->logout_time + 1;
 	    DB::table('ba_account_holders')->where('user_id',$request->session()->get('user_id'))->update(['login_time' => date('Y-m-d H:i:s',strtotime('-'.$logout_time.' minutes'))]);        
 	    UserActivity::saveUserActivity($request->session()->get('id'),'Logout');
        $request->session()->forget('id');
        $request->session()->forget('cust_name');
        $request->session()->forget('middle_name');
        $request->session()->forget('sur_name');
        $request->session()->forget('user_id');
        $request->session()->forget('cust_mail');
        $request->session()->forget('secret_question');
        
        
        
        flash('Logout Successfull')->success();
        return redirect()->intended('login');
    }
    
    
    
    
       public function usdt_generate_wallet(Request $request)
    {
        // Define your API Key
        $apiKey = 't-68701ca29274db8a4e30348f-ce52d402affd4437a05438ae'; // Replace with your actual Tatum API Key

        // Generate Mnemonic (Master Key for the Wallet)
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'x-api-key' => $apiKey
        ])->get('https://api.tatum.io/v3/tron/wallet');

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate wallet.'
            ]);
        }

        $data = $response->json();

        // Check if mnemonic and xpub are present
        if (isset($data['mnemonic']) && isset($data['xpub'])) {
            $mnemonic = $data['mnemonic'];
            $xpub = $data['xpub'];

            // Generate Private Key from Mnemonic
            $privateKeyResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-api-key' => $apiKey
            ])->post('https://api.tatum.io/v3/tron/wallet/priv', [
                'mnemonic' => $mnemonic,
                'index' => 1
            ]);

            if ($privateKeyResponse->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate private key.'
                ]);
            }

            $privateKey = $privateKeyResponse->json()['key'] ?? 'Error: Unable to generate private key.';

            // Generate Tron Address from XPUB
            $addressResponse = Http::withHeaders([
                'accept' => 'application/json',
                'x-api-key' => $apiKey
            ])->get("https://api.tatum.io/v3/tron/address/{$xpub}/1");

            if ($addressResponse->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate Tron address.'
                ]);
            }

            $address = $addressResponse->json()['address'] ?? 'Error: Unable to generate address.';

            // Use the `address` returned by the API instead of `pay_address`
            $payAddress = $address; // Now using the correct `address` field
            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($payAddress);

            Log::info('Generated Pay Address: ' . $payAddress);

            // Insert the wallet record in DB (Only once)
            DB::table('wallets')->insert([
                'user_id' => $request->user_id,
                'currency' => $request->currency,
                'address' => $payAddress,
                'qr' => $qrCodeUrl,
                'mnemonic' => $mnemonic,  // Add mnemonic phrase to the DB
                'private_key' => $privateKey,  // Add private key to the DB
                'created_at' => now(),  // Adds timestamp
                'updated_at' => now()   // Adds timestamp
            ]);

            // Set currency display name
            $currencyName = $request->currency === 'usdttrc20' ? 'USDT' : $request->currency;
            
            
            
                                    try {
                $subject = 'BLC Fund USDT TRC20 Deposit Wallet'; // Define the email subject
                $email = $request->session()->get('cust_mail'); // Get the user's email from the session
                if ($email) {
                    
                    $name = $request->session()->get('cust_name'); // Get the user's name
                    

                 $body = view('emails.wallet_creation', [
    'subject' => $subject,
    'name' => $name,
    'email' => $email,
     'currency' => 'usdt',
    'address'  => $payAddress,
    'qr'       => $qrCodeUrl, // Save QR Code URL
])->render();

// Prepare headers for HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: ' . $this->bankName . ' <' . $this->fromEmail . '>' . "\r\n";  // Adjust 'From' header

// Send email using PHP's mail() function
Mail::send([], [], function ($message) use ($email, $subject, $body) {
    $message->to($email)
            ->subject($subject)
            ->setBody($body, 'text/html');
});


                 
                } else {
                    // Handle case if user is not found
                    Log::error("User not found for wallet ID: ");
                }

            } catch (\Exception $e) {
                // Log the error along with the file and line number
                Log::error('Error sending email: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

                // Continue with the remaining code
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'currency' => $currencyName, // Include the currency
                    'address' => $payAddress, // Include the address
                    'qr' => $qrCodeUrl, // Include QR code URL
                    'mnemonic' => $mnemonic, // Include mnemonic
                    'private_key' => $privateKey, // Include private key
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to generate wallet details.'
        ]);
    }

    
    
    
    
public function generateWallet(Request $request)
{
    $order_id = 'RGDBP-' . strtoupper(uniqid());
    $pay_currency = $request->currency;
    $order_description = $request->currency;

    // Prepare the payload for the NowPayments API
    $data = [
        'price_amount' => 25, // You can dynamically set this if needed
        'price_currency' => 'usd',
        'pay_currency' => $pay_currency, // Set the dynamic currency
        'ipn_callback_url' => 'https://ibank.firstallianzgroup.com/online/test-ipn', // Your IPN callback route
        'order_id' => $order_id, // Dynamic random order ID
        'order_description' => $order_description, // Modified order description
        'is_fixed_rate' => true,
        'is_fee_paid_by_user' => false,
    ];

    // Make the POST request to NowPayments API
    $response = Http::withHeaders([
        'x-api-key' => 'JPFWKZC-FJB4X50-KBHD0H8-3CFJ79D', // Replace with your actual API key
        'Content-Type' => 'application/json',
    ])->post('https://api.nowpayments.io/v1/payment', $data);

    // Check for a successful response
    if ($response->successful()) {
        $payAddress = $response->json()['pay_address'];
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($payAddress);

        Log::info('Generated Pay Address: ' . $payAddress);


DB::table('all_wallets')->insert([
    'user_id' => $request->user_id,
    'currency' => $request->currency,
    'address' => $payAddress,
    'qr' => $qrCodeUrl,
    'created_at' => now(),  // Assuming you want to set the created_at timestamp
    'updated_at' => now()   // Assuming you want to set the updated_at timestamp
]);



        // Check if a wallet already exists for the user and currency
        $wallet = DB::table('wallets')
            ->where('user_id', $request->user_id)
            ->where('currency', $request->currency)
            ->first();

        if ($wallet) {
            // Update the existing wallet
            DB::table('wallets')
                ->where('id', $wallet->id)
                ->update([
                    'address' => $payAddress,
                    'qr' => $qrCodeUrl,
                    'updated_at' => now()
                ]);
        } else {
            // Insert a new wallet if none exists
            DB::table('wallets')->insert([
                'user_id'  => $request->user_id,
                'currency' => $request->currency,
                'address'  => $payAddress,
                'qr'       => $qrCodeUrl, // Save QR Code URL
                'created_at' => now(), // Adds timestamp
                'updated_at' => now()
            ]);
        }

        // Set currency display name
        $currencyName = $request->currency === 'usdttrc20' ? 'USDT' : $request->currency;

        return response()->json([
            'success' => true,
            'data' => [
                'currency' => $currencyName, // Include the currency
                'address' => $payAddress, // Include the address
                'qr' => $qrCodeUrl, // Include QR code URL
            ],
        ]);
    } else {
        // Handle the error case
        return response()->json([
            'success' => false,
            'message' => 'Failed to create payment on NowPayments',
        ], $response->status());
    }
}
 
 public function regenerateWallet(Request $request)
    {

        $order_id = 'RGDBP-' . strtoupper(uniqid());
        $pay_currency = $request->currency;
        $order_description = $request->currency;
        // Prepare the payload for the NowPayments API

        $data = [
            'price_amount' => 25, // You can dynamically set this if needed
            'price_currency' => 'usd',
            'pay_currency' => $pay_currency, // Set the dynamic currency
            'ipn_callback_url' => 'https://ibank.firstallianzgroup.com/online/nowpayment/ipn-callback', // Your IPN callback route
            'order_id' => $order_id, // Dynamic random order ID
            'order_description' => $order_description, // Modified order description
            'is_fixed_rate' => true,
            'is_fee_paid_by_user' => false,
        ];

        // Make the POST request to NowPayments API using Laravel's Http Client
        $response = Http::withHeaders([
            'x-api-key' => 'JPFWKZC-FJB4X50-KBHD0H8-3CFJ79D', // Replace with your actual API key
            'Content-Type' => 'application/json',
        ])->post('https://api.nowpayments.io/v1/payment', $data);

        // Check for a successful response
        if ($response->successful()) {

            $payAddress = $response->json()['pay_address'];

            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($payAddress);

            Log::info('Generated Pay Address: ' . $payAddress);

          DB::table('wallets')->insert([
    'user_id'  => $request->user_id,
    'currency' => $request->currency,
    'address'  => $payAddress,
    'qr'       => $qrCodeUrl,
    'created_at' => now(), // Adds timestamp
    'updated_at' => now()
]);


            return response()->json([
                'success' => true,
                'data' => $response->json(),
            ]);
        } else {
            // Handle the error case here
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment on NowPayments',
            ], $response->status());
        }
    }   
    
    
    
    public function btcGenerateWallet(Request $request)
    {
        $api_key = env('BLOCKONOMICS_API_KEY', 'MIbDHPaDSIXPF5sGfpR2VCWNs0AFh6aMezIwjinmGg0');
        $url = 'https://www.blockonomics.co/api/new_address';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'match_callback' => 'https://ibank.firstallianzgroup.com/ipn_callback?secret=bD7hJf8394rT'
        ]));

        $headers = [
            "Authorization: Bearer " . $api_key,
            "Content-Type: application/json",
            "Accept: application/json"
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $contents = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        $responseObj = json_decode($contents);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status == 200) {

            $payAddress = $responseObj->address; // Get the address from the response

            // Generate QR Code URL
            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($payAddress);

            // Log the generated address
            Log::info('Generated Pay Address: ' . $payAddress);

            // Save to the Wallet model
           DB::table('wallets')->insert([
    'user_id'  => $request->user_id,
    'currency' => 'btc',
    'address'  => $payAddress,
    'qr'       => $qrCodeUrl, // Save QR Code URL
    'created_at' => now(), // Add timestamp
    'updated_at' => now()
]);


try {
    $subject = 'BLC Fund BTC (Bitcoin) Deposit Wallet'; // Define the email subject
    $email = $request->session()->get('cust_mail'); // Get the user's email from the session
    if ($email) {
        
        $name = $request->session()->get('cust_name'); // Get the user's name
      

        // HTML Email Body
        $body = view('emails.wallet_creation', [
            'subject' => $subject,
            'name' => $name,
            'email' => $email,
            'currency' => 'btc',
            'address'  => $payAddress,
            'qr'       => $qrCodeUrl, // QR Code URL
        ])->render();

        // Prepare headers for HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $this->bankName . ' <' . $this->fromEmail . '>' . "\r\n";  // Adjust 'From' header

        // Send email using PHP's mail() function
        Mail::send([], [], function ($message) use ($email, $subject, $body) {
            $message->to($email)
                    ->subject($subject)
                    ->setBody($body, 'text/html');
        });

    } else {
        // Handle case if user is not found
        Log::error("User not found for wallet ID: ");
    }

} catch (\Exception $e) {
    // Log the error along with the file and line number
    Log::error('Error sending email: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

    // Continue with the remaining code
}



            return response()->json([
                'success' => true,
                'data' => [
                    'pay_address' => $payAddress,
                    'qr_code_url' => $qrCodeUrl,
                ],
            ], 200);

        } else {
            Log::error('Blockonomics BTC Wallet Generation Error: HTTP ' . $status . ' - Response: ' . $contents);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate BTC address from Blockonomics',
                'details' => json_decode($contents)
            ], $status);
        }

    }
    
    
    
    
    
    
    
    public function ipn_callback(Request $request)
    {
        // Log the incoming request data
        Log::info('IPN Callback triggered.');
        Log::info('IPN Request Data: ', $request->all());

        // Retrieve the necessary fields from the request
        $txid = $request->input('txid');
        $value = $request->input('value');
        $status = $request->input('status');
        $addr = $request->input('addr');

        // Find the wallet by the address
        $wallet = DB::table('wallets')->where('address', $addr)->first();


        if (!$wallet) {
            Log::error('Wallet not found for address: ' . $addr);
            return response()->json(['success' => false, 'message' => 'Wallet not found'], 404);
        }

        $response = Http::get('https://www.blockonomics.co/api/price?currency=USD');

        if ($response->successful()) {
            $btcPrice = $response->json()['price']; // Return the price in USD
        } else {
            Log::error('Error fetching BTC price: ' . $response->body());
            $btcPrice = '';
        }

        // If status is 2, perform the transaction
        if ($status == 2) {
            // Create the transaction
             Log::info($value);
            $amountInBtc = $value / 100000000; // Assuming value is in Satoshis
             Log::info($amountInBtc);
            $amountInBtcAfterDeduction = $amountInBtc * (1 - 0.04);  // Deduct 4%
  Log::info($amountInBtcAfterDeduction);
          
          DB::table('transactions')->insert([
    'user_id' => $wallet->user_id,
    'subject' => 'Funds Deposit',
    'status' => 'Credit',
    'amount' => $amountInBtc * $btcPrice, // Assuming value is in Satoshis
    'currency' => 'BTC', // Or whatever currency you're dealing with
    'tr_id' => $txid,
    'sent_from' => $addr,
    'sent_to' => '',
    'created_at' => now(), // Adds timestamp
    'updated_at' => now()  // Adds timestamp
]);


       $user = DB::table('ba_account_holders')
    ->where('user_id', $wallet->user_id)
    ->first();
    
    DB::table('ba_account_holders')
        ->where('user_id', $wallet->user_id)
        ->increment('btc_fund', $amountInBtc);


            Log::info('Transaction successfully recorded for user_id: ' . $wallet->user_id);

            try {
                $subject = 'Deposit Confirmation: Amount Successfully Credited'; // Define the email subject

                if ($user) {
                    $email = $user->cust_mail; // Get the user's email
                    $name = $user->cust_name; // Get the user's name
                    $amount = $value / 100000000; // Assuming this is the amount you want to include in the email

                    $priceAmount1 = number_format( $amountInBtcAfterDeduction * $btcPrice); // Assuming you have a variable for the USD amount

                    // $additionalEmails = ['mfundo.mabasox@gmail.com', 'anthonyparker55667@gmail.com'];

                    // Send the email
                 $body = view('emails.btc_deposite', [
    'subject' => $subject,
    'name' => $name,
    'email' => $email,
    'currency_amounts' => $amountInBtcAfterDeduction,
    'usd_amount' => $priceAmount1,
])->render();

// Prepare headers for HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: ' . $this->bankName . ' <' . $this->fromEmail . '>' . "\r\n";  // Adjust 'From' header

// Send email using PHP's mail() function
Mail::send([], [], function ($message) use ($email, $subject, $body) {
    $message->to($email)
            ->subject($subject)
            ->setBody($body, 'text/html');
});


                    $manualText = "New deposit in Bloconomics from user {$name}.\n" .
                        "Currency: BTC\n" .
                        "USD Amount: {$priceAmount1}\n";
                        // "Currency Amount: {$amount}"; // Custom message

                    // foreach ($additionalEmails as $additionalEmail) {
                    //     Mail::raw($manualText, function ($message) use ($additionalEmail) {
                    //         $message->to($additionalEmail)
                    //             ->subject('New Deposit Notification');
                    //     });
                    // }

                } else {
                    // Handle case if user is not found
                    Log::error("User not found for wallet ID: " . $wallet->user_id);
                }

            } catch (\Exception $e) {
                // Log the error along with the file and line number
                Log::error('Error sending email: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

                // Continue with the remaining code
            }

// Remaining code to execute after the email attempt

        } else {
            Log::info('Transaction status is not valid for processing: ' . $status);
        }

        return response()->json(['success' => true, 'message' => 'IPN processed successfully']);
    }

    
    
    
    
    
    public function logIPNData(Request $request)
    {
        Log::info('Now Payment IPN Callback triggered.');
        Log::info('IPN Request Data: ', $request->all());

        $orderId = $request->input('orderId');
        $payAddress = $request->input('payAddress');
        $payAmount = $request->input('payAmount');
        $priceAmount = $request->input('priceAmount');
        $payCurrency = $request->input('payCurrency');
        $paymentId = $request->input('paymentId');
        $paymentStatus = $request->input('paymentStatus');
        Log::info('XX1');
        $wallet = DB::table('wallets')->where('address', $payAddress)->first();
        Log::info('XX2');
        if (!$wallet) {

            // return response()->json(['success' => false, 'message' => 'Wallet not found'], 404);

            Log::info('WALLET NOT FOUND');
        }

        Log::info('XX');
        DB::table('transactions')->insert([
    'user_id' => $wallet->user_id,
    'subject' => 'Funds Deposit',
    'status' => 'Credit',
    'amount' => $payAmount, // Assuming value is in Satoshis
    'currency' => $payCurrency, // Currency you're dealing with
    'tr_id' => $paymentId,
    'sent_from' => $payAddress,
    'sent_to' => '',
    'created_at' => now(), // Add created timestamp
    'updated_at' => now()  // Add updated timestamp
]);


        Log::info('YY');

       $user = DB::table('users')->where('user_id', $wallet->user_id)->first();

        if ($payCurrency == 'eth') {
            $user->eth_fund += $payAmount; // Assuming amountInBtc is in ETH
        } elseif ($payCurrency == 'usdttrc20') {
            $user->usdt_fund += $payAmount; // Assuming amountInBtc is in USDT
        }

        $user->save();
        Log::info('ZZ');

        Log::info('Transaction successfully recorded for user_id: ' . $wallet->user_id);

        try {
            $subject = 'Deposit Confirmation: Amount Successfully Credited'; // Define the email subject

            if ($user) {
                $email = $user->email; // Get the user's email
                $name = $user->name; // Get the user's name
                $amount = $payAmount; // Assuming this is the amount you want to include in the email
                $payCurrency1 = strtoupper($payCurrency); // Assuming you're getting the currency from the request
                $priceAmount1 = $priceAmount; // Assuming you have a variable for the USD amount

                // $additionalEmails = ['mfundo.mabasox@gmail.com', 'anthonyparker55667@gmail.com'];

                // Send the email
                // Mail::send('emails.deposite', [
                //     'subject' => $subject,
                //     'name' => $name,
                //     'email' => $email,
                //     'currency' => $payCurrency1,
                //     'currency_amounts' => $payAmount,
                //     'usd_amount' => $priceAmount,

                //     // Pass the currency amounts array to the email template
                // ], function ($message) use ($email, $subject) {
                //     $message->to($email)->subject($subject);
                // });
                
                
                $body = view('emails.deposite', [
    'subject' => $subject,
    'name' => $name,
    'email' => $email,
    'amount' => $amount,
    'sent_from' => $fromWallet,
    'sent_to' => $toAddress,
    'transaction_id' => $transactionId,
    'currency' => $wallet->currency,
])->render();

// Prepare headers for HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: ' . $this->bankName . ' <' . $this->fromEmail . '>' . "\r\n";  // Adjust 'From' header

// Send email using PHP's mail() function
Mail::send([], [], function ($message) use ($email, $subject, $body) {
    $message->to($email)
            ->subject($subject)
            ->setBody($body, 'text/html'); // Use 'text/plain' for plain text emails
});







                // $deductedAmount = $priceAmount1 - ($priceAmount1 * 0.03);
                // $manualText = "New deposit in NowPayment from user {$name}.\n" .
                //     "Currency: {$payCurrency1}\n" .
                //     "USD Amount: {$deductedAmount}\n" ;
                //     // "Currency Amount: {$amount}"; // Custom message

                // foreach ($additionalEmails as $additionalEmail) {
                //     Mail::raw($manualText, function ($message) use ($additionalEmail) {
                //         $message->to($additionalEmail)
                //             ->subject('New Deposit Notification');
                //     });
                // }

            } else {
                // Handle case if user is not found
                Log::error("User not found for wallet ID: " . $wallet->user_id);
            }

        } catch (\Exception $e) {
            // Log the error along with the file and line number
            Log::error('Error sending email: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

            // Continue with the remaining code
        }

        return response()->json(['success' => true, 'message' => 'IPN processed successfully']);

    }
    















 public function send_funds($user_id, Request $request)
    {

        //return $user_id;

        $amount = $request->input('amount');
        $amount = str_replace(',', '', $amount);

// Optionally, you can convert it to a numeric value if needed
        $amount = (float) $amount;
      
        $fromWallet = $request->input('fromWallet');
        $toAddress = $request->input('toAddress');
        $transactionId = 'TX' . time() . mt_rand(1000, 9999);
        
        // Fetch wallet data using Query Builder
$wallet = DB::table('wallets')->where('address', $fromWallet)->first();

// Fetch user data using Query Builder
$user = DB::table('ba_account_holders')->where('user_id', $user_id)->first();


        // Check wallet currency and update corresponding balance
        if ($wallet->currency == 'btc') {
            
             try {
    // Fetch the current BTC price in USD
    $response = Http::get('https://www.blockonomics.co/api/price?currency=USD');
    
    if ($response->successful()) {
        $btcPriceInUsd = $response->json()['price']; // Get the price of 1 BTC in USD

       

        // Convert USD to BTC
        $btcAmount =  $amount / $btcPriceInUsd;
        
        
       
        $formattedBtcAmount = number_format($btcAmount, 8);

        // return $formattedBtcAmount;
    } else {
        // Handle failure
        Log::error('Error fetching BTC price: ' . $response->body());
        echo "Failed to fetch BTC price.";
    }
} catch (Exception $e) {
    // Handle exceptions
    Log::error('Exception occurred while converting USD to BTC: ' . $e->getMessage());
    echo "An error occurred. Please try again later.";
}

        DB::table('ba_account_holders')
        ->where('user_id', $user_id)
        ->decrement('btc_fund', $request->input('btcEquivalent'));
        
        } elseif ($wallet->currency == 'eth') {
           
            DB::table('ba_account_holders')
        ->where('user_id', $user_id)
        ->decrement('eth_fund', $amount);
        
        } elseif ($wallet->currency == 'usdttrc20') {
           
            DB::table('ba_account_holders')
        ->where('user_id', $user_id)
        ->decrement('usdt_fund', $amount);
        
        }

        
        DB::table('transactions')->insert([
    'user_id' => $user_id,
    'subject' => 'Fund Transfer',
    'currency' => $wallet->currency,
    'amount' => $amount,
    'status' => 'Pending',
    'tr_id' => $transactionId,
    'sent_from' => $fromWallet,
    'sent_to' => $toAddress,
    'created_at' => now(), // Adds created timestamp
    'updated_at' => now()  // Adds updated timestamp
]);


        $data = [
            'amount' => $amount,
            'user_id' => $user_id,
            'sent_from' => $fromWallet,
            'sent_to' => $toAddress,
            'transaction_id' => $transactionId,
            'currency' => $wallet->currency,
            'btcEquivalent' => $request->input('btcEquivalent'),

        ];

        session(['transfer_success_data' => $data]);

        $subject = 'Funds Transfer Confirmation: Amount Successfully Debited';

        $email = $user->cust_mail; // Get the user's email
        $name = $user->cust_name; // Get the user's name

// Render the Blade view into a variable
$body = view('emails.sending', [
    'subject' => $subject,
    'name' => $name,
    'email' => $email,
    'amount' => $amount,
    'sent_from' => $fromWallet,
    'sent_to' => $toAddress,
    'transaction_id' => $transactionId,
    'currency' => $wallet->currency,
])->render();

// Prepare headers for HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: ' . $this->bankName . ' <' . $this->fromEmail . '>' . "\r\n";  // Adjust 'From' header

// Send email using PHP's mail() function
Mail::send([], [], function ($message) use ($email, $subject, $body) {
    $message->to($email)
            ->subject($subject)
            ->setBody($body, 'text/html'); // use 'text/plain' for plain text emails
});


        return redirect('success_transfer_confirm');

    }    
    
    
    
    
    
    
    public function all_crypto_history(Request $request) {
    	$data = array();
    	$data['main'] = 'account';
    	$data['page'] = 'accounts-summary';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
        $data['bank_url'] = $this->bank_url;
        
        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
        $this->store_page_logs('account-summery',$request->session()->get('user_id'));
        $data['_user'] = DB::table('ba_account_holders')->where('user_id',$user_id)->first();
        return view('all_crypto_history', $data);
    }
    
    
    
    public function all_send_req(Request $request) {
    	$data = array();
    	$data['main'] = 'account';
    	$data['page'] = 'accounts-summary';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
        $data['bank_url'] = $this->bank_url;
        
        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
        $this->store_page_logs('account-summery',$request->session()->get('user_id'));
        $data['_user'] = DB::table('ba_account_holders')->where('user_id',$user_id)->first();
        return view('all_send_req', $data);
    }
    
    
      public function martketplace(Request $request) {
    	$data = array();
    	$data['main'] = 'account';
    	$data['page'] = 'accounts-summary';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
        $data['bank_url'] = $this->bank_url;
        
        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
        $this->store_page_logs('account-summery',$request->session()->get('user_id'));
        $data['_user'] = DB::table('ba_account_holders')->where('user_id',$user_id)->first();
        return view('martketplace', $data);
    }
    
    
      public function news(Request $request) {
    	$data = array();
    	$data['main'] = 'account';
    	$data['page'] = 'accounts-summary';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        
        $data['bank_url'] = $this->bank_url;
        
        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
        $this->store_page_logs('account-summery',$request->session()->get('user_id'));
        $data['_user'] = DB::table('ba_account_holders')->where('user_id',$user_id)->first();
        return view('news', $data);
    }
    

}




