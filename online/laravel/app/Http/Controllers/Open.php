<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\SmsEditor;
use App\EmailEditor;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Mail;

class Open extends Controller
{

    public function __construct()
    {

        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
        $config = DB::select('select * from configs LIMIT 1');
        
        $this->fromEmail = $config[0]->bank_email;

        $this->bank_fax = $config[0]->bank_fax;

        $this->bankName = $config[0]->bank_name;

        $this->bankPhone = $config[0]->bank_phone;

        $this->bank_support_person = $config[0]->bank_support_person;

        $this->logo = $config[0]->logo;
        $this->bank_url = $config[0]->bank_url;
        $this->bank_email = $config[0]->bank_email;

        $this->fromNumber = $config[0]->sms_phone;

        //$this->bank_url = $config[0]->bank_url;

        $this->accountSid = $config[0]->sms_sid;

        $this->authToken = $config[0]->sms_token;

        $this->env = 'live';
        if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $this->env = 'local';
        }
    }

    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    public function store_page_logs($page, $user_id)
    {

        $date = Carbon::now();
        $date->timezone = 'Africa/Lagos';
        $ip = $this->getIp();
        $login_time = $date->toRfc850String();
        //DB::insert('insert into page_logs (userid,ip, stamp,page) values (?,?, ?,?)', [$user_id,$ip,$login_time,$page]);
    }

    public function OnlineOpenAccount(Request $request)
    {
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";

        /** fetching form options **/
        $data['enableForms'] = DB::table('reg_form_settings')->first();

        $data['currencies'] = (DB::select('SELECT * FROM currencies'));
        $data['type'] = (DB::select('SELECT * FROM account_type'));
        $data['branch'] = (DB::select('SELECT * FROM bank_details'));

        $data['totalForms'] = DB::select('SELECT (form_4+form_5+form_6+form_7+form_8+form_9+form_10+form_11+form_12+form_13+form_14+form_15) as result FROM reg_form_settings LIMIT 1');
        $data['totalForm'] = $data['totalForms'][0]->result + 3;
        return view('open/open-account', $data);
    }

    public function PostOnlineOpenAccount(Request $request)
    {
        // dd($request);
        $random = rand(1111,9999);
        // dd($random);
        $pathUpload = str_replace(DB::table('configs')->where('id','1')->first()->client_folder.'/laravel',"admin/uploads",base_path());
        $messagedata = DB::select('SELECT email FROM email_editor WHERE name ="Verification code to verify email"');
//        dd($messagedata);

        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";

        $data['totalForm'] = 0;
        $data['enableForms'] = DB::table('reg_form_settings')->first();
        $data['currencies'] = (DB::select('SELECT * FROM currencies'));
        $data['type'] = (DB::select('SELECT * FROM account_type'));
        $data['branch'] = (DB::select('SELECT * FROM bank_details'));

        $data2 = $request->input();
//        dd($data2);
        $data['formjson'] = json_encode($data2);//show posted data

        if ($data2['submit'] == 'Recover') {
            $data2['recover'] = DB::select('select jsonform from reg_account_holder_details where id= ?', [$data2['continueregister']]);

            flash('Your info was recovered')->success();
            $data['recover'] = json_decode($data2['recover'][0]->jsonform);
            //$data['keys']= array_keys($data['recover']);
            return view('open/open-account', $data);
        } else if ($data2['submit'] == 'Save') {
            if (isset($data2['email'])) {
                DB::insert('insert into reg_account_holder_details (jsonform) values (?)', [$data['formjson']]);
                $idsalvado = DB::select('select id as resultado from reg_account_holder_details where jsonform = ? ', [$data['formjson']]);

                $messagedata = DB::select('SELECT email FROM email_editor WHERE name ="Your incomplete registration"');

                $str = $messagedata[0]->email;

                $words = ["[first_name]", "[bankName]", "[idsalvado]"];
                $change   = [$data2['name'], $data2['branch'], $idsalvado];

                $newPhrase = str_replace($words, $change, $str);

                $subject = "Your incomplete registration was saved for " . $data['bankName'];

                $logo_link = "https://" . $this->bank_url . "/admin/uploads/" . $this->logo;
                $message = '<img src=' . $logo_link . ' alt="banking" style="display: block;
                margin-left: auto;
                margin-right: auto;
                width: 15%;">';
                $message .= '<p><b> Your incomplete registration form is saved with number :' . $idsalvado[0]->resultado . '</b></p>';
                $message .= '<p>
                '.$newPhrase.'</p>';

                $body = '<html><head><meta charset="gb18030"></head><body>';
                $body .= $message;
                $body .= "</body></html>";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                $headers .= 'From: ' . $this->bankName . ' <' . $this->bank_email . '>' . "\r\n";

              Mail::send([], [], function ($message) use ($data2, $subject, $body) {
    $message->to($data2['email'])
            ->subject($subject)
            ->setBody($body, 'text/html'); // use 'text/plain' if not HTML
});
                flash('Check your inbox and spam folders, your info was saved')->success();
                return redirect()->intended('login');
            } else {
                flash('You need to provide at least an email')->error();
                $data['recover'] = json_decode($data['formjson']);
                return view('open/open-account', $data);
            }
        } else if ($data2['submit'] == 'Submit') {
            if (isset($data2['title']) and isset($data2['birth']) and isset($data2['name']) and isset($data2['lastname']) and isset($data2['country2']) and isset($data2['panid']) and isset($data2['zipcode']) and isset($data2['address']) and isset($data2['tel']) and isset($data2['city']) and isset($data2['email']) and isset($data2['mothername']) and isset($data2['country2'])
                and isset($data2['currency']) and isset($data2['branch']) and isset($data2['type'])
                and filter_var($data2['email'], FILTER_VALIDATE_EMAIL)) {
                $autoactive = DB::select('SELECT auto_activate as resultado FROM `reg_form_settings` LIMIT 1 ', ['']);

                $nuevos = DB::select('SELECT (max(user_id)+7) as user,(max(customer_id)+17) as id FROM `ba_account_holders`', ['']);
                if($nuevos[0]->user == ""){
                    $nuevos[0]->user    = rand(11111,99999);
                }
                if($nuevos[0]->id == ""){
                    $nuevos[0]->id    = rand(11111,99999);
                }
                // dd($autoactive); 
                // $account_no = ($nuevos[0]->user) + 27; 
                
                $account_check = DB::table('ba_account_holders')
                    ->where('cust_mail', $data2['email'])
                    ->where(function($q) {
                        $q->where('df', '!=', 'yes')->orWhereNull('df');
                    })
                    ->first();
                
                if ($account_check) {
    // Email is already registered, flash the error message and redirect to login
    flash('This email is already registered.')->error();;
    return redirect()->intended('login');
}

                $account_settings = DB::select('SELECT `account_start_value`,`account_end_value` FROM `reg_form_settings` ',['']);
                
                $account_no = rand($account_settings[0]->account_start_value, $account_settings[0]->account_end_value);
            
                // dd($autoactive[0]->resultado);    
                
                $bank = DB::select('SELECT id from `bank_details` where branch_name = "'.$data2['branch'].'"');
                $bankId = $bank[0]->id;
                $message_otp=rand(1111,9999);
                $mail_otp=rand(1111,9999);

                if ($autoactive[0]->resultado == 0) {
                    // If AutoActive 0
                    
                    // flash('Your information will be reviewed')->success();
                    // flash('A Customer Service representative will be in touch with you shortly, Thank you for using "bankname"')->success();
                    flash('A Customer Service representative will be in touch with you shortly, Thank you for using '.$data['bankName'])->warning();
                    $profile = $request->file('passportPhoto');
            		if(!empty($profile) && !empty($profile_path = $profile->getRealPath()) && !empty($profile_name = $profile->getClientOriginalName())) {
            			$profile_ext = $profile->getClientOriginalExtension();
        		      	$profile_type = $profile->getMimeType();
        		      	$profile_name = md5(time()).$profile_name;
                        $profile->move($pathUpload,$profile_name);
            		}else{
            		    $profile_name = "";
            		}

            		$passportId = $request->file('passportId');
            		if(!empty($passportId) && !empty($profile_path = $passportId->getRealPath()) && !empty($passportIdName = $passportId->getClientOriginalName())) {
            			$profile_ext = $passportId->getClientOriginalExtension();
        		      	$profile_type = $passportId->getMimeType();
        		      	$passportIdName = md5(time()).$passportIdName;
                        $passportId->move($pathUpload,$passportIdName);
            		}else{
            		    $passportIdName = "";
            		}
                    $amRow = DB::table('ba_am')->first();
                    if($amRow){ $amVal = $amRow->id; }else{ $amVal = ""; }
                    $user= DB::statement('insert into ba_account_holders ( account_status,user_id,customer_id,cust_password,title,dob,cust_name,sur_name,cust_country,idnumber,post_code,cust_address,cust_countrycode,cust_phone,cust_mail,mother_maiden,cust_city,cust_state,qid,ans,qid2,ans2,mail_otp,message_otp,cust_photo,cust_natioanl_id,am) values ("0","' . $nuevos[0]->user . '","' . $nuevos[0]->id . '","' .$random . '","' . $data2['title'] . '","' . $data2['birth'] . '","' . $data2['name'] . '","' . $data2['lastname'] . '","' . $data2['country2'] . '","' . $data2['panid'] . '","' . $data2['zipcode'] . '","' . $data2['address'] . '","' . $data2['countrycode'] . '","' . $data2['tel'] . '","' . $data2['email'] . '","' . $data2['mothername'] . '","' . $data2['city'] . '","' . $data2['state'] . '","'.$data2['security_ques1'].'","'.$data2['answer1'].'","'.$data2['security_ques2'].'","'.$data2['answer2'].'","'.$mail_otp.'","'.$message_otp.'","'.$profile_name.'","'.$passportIdName.'","'.$amVal.'")');
                    $c_n = DB::table('currencies')->where('currency', $data2['currency'])->value('currency_name');
                    $account = DB::statement('insert into ba_user_accounts ( user_id,account_no,bank,account_title,account_type,account_currency,currency_name )values ("' . $nuevos[0]->user . '","' . $account_no . '","'.$bankId.'","'.$data2['name'].'","'.$data2['type'].'","'.$data2['currency'].'","'.$c_n.'")');


                    $regHtml = $this->getRegistrationEmailHtml($data2['name'], $data2['lastname'], $data2['type'], $nuevos[0]->user, $nuevos[0]->id, $random);
                    $subject2 = "Bank Account Credentials - " . $this->bankName;

                    DB::table('ba_account_holders')->where('user_id',$nuevos[0]->user)->update([
                        'message_otp'=>$message_otp,
                        'mail_otp'=>$mail_otp,
                    ]);
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipient =  $request['countrycode'].$request['tel'];
                    $msg = 'Your Verification code: '.$message_otp;

                    try {
                        $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg] );
                    } catch (\Throwable $th) {}

                    // Send Account Credentials email
                    Mail::send([], [], function ($message) use ($data2, $subject2, $regHtml) {
                        $message->to($data2['email'])
                                ->subject($subject2)
                                ->setBody($regHtml, 'text/html');
                    });

                    // Send Verification Code email
                    $verifHtml = $this->getVerificationEmailHtml($data2['name'], $mail_otp);
                    $subjectVerif = "Verification Code - " . $this->bankName;
                    Mail::send([], [], function ($message) use ($data2, $subjectVerif, $verifHtml) {
                        $message->to($data2['email'])
                                ->subject($subjectVerif)
                                ->setBody($verifHtml, 'text/html');
                    });
                     
                  
                }
                else {
                    // flash('Please check your entered email '.$data2['email'].' and Phone number '.$request['countrycode'].$request['tel'].' for verification codes to complete Account opening Process')->success();

                    $profile = $request->file('passportPhoto');
            		if(!empty($profile) && !empty($profile_path = $profile->getRealPath()) && !empty($profile_name = $profile->getClientOriginalName())) {
            			$profile_ext = $profile->getClientOriginalExtension();
        		      	$profile_type = $profile->getMimeType();
        		      	$profile_name = md5(time()).$profile_name;
                        $profile->move($pathUpload,$profile_name);
            		}else{
            		    $profile_name = "";
            		}

            		$passportId = $request->file('passportId');
            		if(!empty($passportId) && !empty($profile_path = $passportId->getRealPath()) && !empty($passportIdName = $passportId->getClientOriginalName())) {
            			$profile_ext = $passportId->getClientOriginalExtension();
        		      	$profile_type = $passportId->getMimeType();
        		      	$passportIdName = md5(time()).$passportIdName;
                        $passportId->move($pathUpload,$passportIdName);
            		}else{
            		    $passportIdName = "";
            		}
                    $amRow = DB::table('ba_am')->first();
                    if($amRow){ $amVal = $amRow->id; }else{ $amVal = ""; }
                    $user= DB::statement('insert into ba_account_holders ( account_status,user_id,customer_id,cust_password,title,dob,cust_name,sur_name,cust_country,idnumber,post_code,cust_address,cust_countrycode,cust_phone,cust_mail,mother_maiden,cust_city,cust_state,qid,ans,qid2,ans2,mail_otp,message_otp,cust_photo,cust_natioanl_id,am) values ("0","' . $nuevos[0]->user . '","' . $nuevos[0]->id . '","' .$random . '","' . $data2['title'] . '","' . $data2['birth'] . '","' . $data2['name'] . '","' . $data2['lastname'] . '","' . $data2['country2'] . '","' . $data2['panid'] . '","' . $data2['zipcode'] . '","' . $data2['address'] . '","' . $data2['countrycode'] . '","' . $data2['tel'] . '","' . $data2['email'] . '","' . $data2['mothername'] . '","' . $data2['city'] . '","' . $data2['state'] . '","'.$data2['security_ques1'].'","'.$data2['answer1'].'","'.$data2['security_ques2'].'","'.$data2['answer2'].'","'.$mail_otp.'","'.$message_otp.'","'.$profile_name.'","'.$passportIdName.'","'.$amVal.'")');
//                    dd($user);
                    $c_n = DB::table('currencies')->where('currency', $data2['currency'])->value('currency_name');
                    $account = DB::statement('insert into ba_user_accounts ( user_id,account_no,bank,account_title,account_type,account_currency,currency_name )values ("' . $nuevos[0]->user . '","' . $account_no . '","'.$bankId.'","'.$data2['name'].'","'.$data2['type'].'","'.$data2['currency'].'","'.$c_n.'")');
//                    dd($account);
                    $regHtml = $this->getRegistrationEmailHtml($data2['name'], $data2['lastname'], $data2['type'], $nuevos[0]->user, $nuevos[0]->id, $random);
                    $subject2 = "Bank Account Credentials - " . $this->bankName;

                    DB::table('ba_account_holders')->where('user_id',$nuevos[0]->user)->update([
                        'message_otp'=>$message_otp,
                        'mail_otp'=>$mail_otp,
                    ]);
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipient =  $request['countrycode'].$request['tel'];
                    $msg = 'Your Verification code: '.$message_otp;

                    try {
                        $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg] );
                    } catch (\Throwable $th) {}

                    flash('Please check your entered email '.$data2['email'].' and Phone number '.$request['countrycode'].$request['tel'].' for verification codes to complete Account opening Process')->warning();

                    // Send Account Credentials email
                    Mail::send([], [], function ($message) use ($data2, $subject2, $regHtml) {
                        $message->to($data2['email'])
                                ->subject($subject2)
                                ->setBody($regHtml, 'text/html');
                    });

                    // Send Verification Code email
                    $verifHtml = $this->getVerificationEmailHtml($data2['name'], $mail_otp);
                    $subjectVerif = "Verification Code - " . $this->bankName;
                    Mail::send([], [], function ($message) use ($data2, $subjectVerif, $verifHtml) {
                        $message->to($data2['email'])
                                ->subject($subjectVerif)
                                ->setBody($verifHtml, 'text/html');
                    });


                }

//                dd($nuevos[0]->user);
//                $message_otp=rand(1111,9999);
//                $mail_otp=rand(1111,9999);
//                DB::table('ba_account_holders')->where('user_id',$nuevos[0]->user)->update([
//                    'message_otp'=>$message_otp,
//                    'mail_otp'=>$mail_otp,
//                ]);
//                $client = new Client($this->accountSid, $this->authToken);
//                $recipient =  $request['countrycode'].$request['tel'];
//                $msg = 'Your Verification code: '.$message_otp;
//                    $client->messages->create($recipient,
//                        ['from' => $this->fromNumber, 'body' => $msg] );
//
//
//
//                $subject = "verification code for " . $data['bankName'];
//
//                $logo_link = "https://" . $this->bank_url . "/admin/uploads/" . $this->logo;
//                $message = '<img src=' . $logo_link . ' alt="banking" style="display: block;
//                    margin-left: auto;
//                    margin-right: auto;
//                    width: 15%;">';
//
//                $message .= '<p><b>Dear ' . $data2['name'] . '</b></p> Your verification code is :' . $mail_otp . '';
////                $message .= '<p>
////                   '.$newPhrase.'</p>';
//
//                $body = "<html><head></head><body>";
//                $body .= $message;
//                $body .= "</body></html>";
//
//                $headers = "MIME-Version: 1.0" . "\r\n";
//                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//
//                $headers .= 'From: ' . $this->bankName . ' <' . $this->bank_email . '>' . "\r\n";
//
//                mail($data2['email'], $subject, $body, $headers);



                $user_id=$nuevos[0]->user;
                Session::put('user_id',$user_id);
                Session::put('branch',$data2['branch']);
                Session::put('type',$data2['type']);
                Session::put('account_no',$account_no);
                 if ($autoactive[0]->resultado == 0) {
                    # code...
                    // flash('A Customer Service representative will be in touch with you shortly, Thank you for using '.$data['bankName'])->success();
                    return view('my-account/inactive-account-activation',$data);
                }

                return redirect()->intended('verifyaccount') /*redirect()->intended('login')*/ ;
            } else {
                flash('You need to fill all the mandatory fields')->error();
                $data['recover'] = json_decode($data['formjson']);
                return view('open/open-account', $data);
            }
        } else {
            flash('Error ocurred, try again')->error();
            return redirect()->intended('login');
        }
    }

    public function verifyaccount(Request $request)
    {
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";
        $data['otp'] = 'hidden';
        //$data['echo2'] = $data['logo'];
        $user_id = \Illuminate\Support\Facades\Session::get('user_id');
        // dd($user_id);
        return view('my-account.verifyaccount', ['user_id'=>$user_id]);
    }

    public function change(Request $request){

        $data['select'] = DB::table('ba_account_holders')->where('user_id',$request->user_id)->first();

        $message_otp=rand(1111,9999);
        $mail_otp=rand(1111,9999);

        // $userId = \Illuminate\Support\Facades\Session::get('user_id');
        $userId = $request->user_id;
        $test = DB::table('ba_account_holders')->where('user_id',$userId)->update([
            'cust_mail'=>$request->firstappemail,
            'cust_countrycode'=>$request->countrycode,
            'cust_phone'=>$request->tel,
            'mail_otp' => $mail_otp,
            'message_otp' => $message_otp
        ]);
        // dd($request);
        flash('Please check your entered email '.$request->firstappemail.' and Phone number '.$request['countrycode'].$request['tel'].' for verification codes to complete Account opening Process')->success();

        $client = new Client($this->accountSid, $this->authToken);
        $recipient =  $request->countrycode.$request->tel;
        $msg = 'Your Verification code: '.$message_otp;
                    $client->messages->create($recipient,
                        ['from' => $this->fromNumber, 'body' => $msg] );



        $subject = "verification code for " . $this->bankName;

        $logo_link = "https://" . $this->bank_url . "/admin/uploads/" . $this->logo;
        $message = '<img src=' . $logo_link . ' alt="banking" style="display: block;
                    margin-left: auto;
                    margin-right: auto;
                    width: 15%;">';

        $message .= 'Your verification code is :' . $mail_otp . '';
//                $message .= '<p>
//                   '.$newPhrase.'</p>';

        $body = "<html><head></head><body>";
        $body .= $message;
        $body .= "</body></html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: ' . $this->bankName . ' <' . $this->bank_email . '>' . "\r\n";

       Mail::send([], [], function ($message) use ($request, $subject, $body) {
    $message->to($request->firstappemail)
            ->subject($subject)
            ->setBody($body, 'text/html'); // Use 'text/plain' if plain text
});

        return redirect()->intended('verifyaccount') /*redirect()->intended('login')*/ ;
    }

    public function RetrieveAccountPin(Request $request)
    {
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";
        $data['otp'] = 'hidden';
        //$data['echo2'] = $data['logo'];

        return view('open/retrieve-account-pin', $data);
    }

    public function PostRetrieveAccountPin(Request $request)
    {
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";
        $data['otp'] = 'show';

        $data2 = $request->input();
        //$data['echo2'] = json_encode($data2);//show posted data
        $data['user'] = $data2['user'];
        //$data['pin1'] = $data2['pin1'];
        //$data['pin2'] = $data2['pin2'];

        if (isset($data2['otp'])) {
            $data['select'] = DB::select('select * from ba_account_holders where user_id = ? LIMIT 1', [$data2['user']]);
            if ($data2['otp'] == $data['select'][0]->otp) {
                if (isset($data2['pin2']) and $data2['pin1'] == $data2['pin2']) {
                    DB::update("UPDATE ba_account_holders SET cust_password = ? WHERE user_id = ?", [$data2['pin1'], $data2['user']]);
                    flash('Contact Information has been Verified')->success();
                    return redirect()->intended('login');
                } else {
                    $data['otprequired'] = $data['select'][0]->otp;
                    $data['otp'] = 'show2';
                    flash('Enter your new pin')->success();
                    return view('open/retrieve-account-pin', $data);
                }
            } else {
                flash('Wrong OTP, try again')->error();
                return redirect()->intended('login');
            }
        } else {
            if (isset($data2['user'])) {//$data2['pin1'] == $data2['pin2'] and
                $data['select'] = DB::select('select * from ba_account_holders where user_id = ? LIMIT 1', [$data2['user']]);
                //flash($data['check'])->success();
                if (isset($data['select'][0]->cust_mail)) {
                    $data['emailuser'] = $data['select'][0]->cust_mail;
                    //aqui enviaria el mail de otp o llamas a la función que de alguna manera se reconozca arriba
                    $digits = 4;
                    $data['otprequired'] = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                    DB::update("UPDATE ba_account_holders SET otp = ? WHERE user_id = ?", [$data['otprequired'], $data2['user']]);

                    $messagedata = DB::select('SELECT email FROM email_editor WHERE name ="Account Opening Approval Notice"');

                    $subject = "Your OTP code is " . $data['otprequired'] . " for " . $data['bankName'];

                    $logo_link = "https://" . $this->bank_url . "/admin/uploads/" . $this->logo;
                    $message = '<img src=' . $logo_link . ' alt="banking" style="display: block;
                    margin-left: auto;
                    margin-right: auto;
                    width: 15%;">';
                    $message .= '<p><b>Dear ' . $data['select'][0]->cust_name . '</b></p> Your OTP code is :' . $data['otprequired'];
                    $message .= '<p>
                    '.$messagedata[0]->email.'</p>';

                    $body = "<html><head></head><body>";
                    $body .= $message;
                    $body .= "</body></html>";

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    $headers .= 'From: ' . $this->bankName . ' <' . $this->bank_email . '>' . "\r\n";

                  Mail::send([], [], function ($message) use ($data, $subject, $body) {
    $message->to($data['emailuser'])
            ->subject($subject)
            ->setBody($body, 'text/html'); // Or 'text/plain'
});

                    flash('Check your inbox and spam folders')->success();
                    return view('open/retrieve-account-pin', $data);
                } else {
                    flash('User not found')->error();
                    return redirect()->intended('retrieve-account-pin');
                }
            } else {
                flash('Wrong Information Provided')->error();
                return redirect()->intended('retrieve-account-pin');
            }
        }
    }

    public function verifyaccountstatus(Request $request)
    {
        // dd($request);
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";
        $data['otp'] = 'show';

        $data2 = $request->input();
        
        if (isset($data2['mailotp'])) {
        


            $autoactive = DB::select('SELECT auto_activate as resultado FROM `reg_form_settings` LIMIT 1 ', ['']);
            if($autoactive[0]->resultado == 0){
                DB::table('ba_account_holders')->where('user_id',Session::get('user_id'))->update([
                    'account_status'=>0
                ]);
            }else{

                DB::table('ba_account_holders')->where('user_id',Session::get('user_id'))->update([
                    'account_status'=>1
                ]);
            }
            
            $data['select'] = DB::table('ba_account_holders')->where('user_id',Session::get('user_id'))->first();
            $user_password = $data['select']->cust_password;
            
            
          
            if ($data2['mailotp'] == $data['select']->mail_otp) {
                
                DB::table('ba_account_holders')->where('user_id',Session::get('user_id'))->update([
                   'verification'=>1
                ]);

                $nuevos = DB::select('SELECT (max(user_id)+7) as user,(max(customer_id)+17) as id FROM `ba_account_holders`', ['']);
                    if($nuevos[0]->user == ""){
                        $nuevos[0]->user    = rand(11111,99999);
                    }
                    if($nuevos[0]->id == ""){
                        $nuevos[0]->id    = rand(11111,99999);
                    }
                $smsdata = DB::select('SELECT sms FROM sms_editor WHERE name ="Account Opening Approval"');

                $smstext = $smsdata[0]->sms;

                $smswords = ["[first_name]","[last_name]","[bank_name]","[user_id]","[customer_id]","[password]","[account_type]","[account_no]","[password]"];
                $smschange = [$data['select']->cust_name,$data['select']->sur_name,$this->bankName,$data['select']->user_id,$data['select']->customer_id,$user_password,Session::get('type'),Session::get('account_no'),'1111'];
                $smsphrase = str_replace($smswords,$smschange,$smstext);


                $messagedata = DB::select('SELECT email FROM email_editor WHERE name ="Account Opening Approval Notice"');

                $str = $messagedata[0]->email;


                $words = ["[first_name]", "[last_name]", "[bank_name]","[branch_name]", "[first_name]", "[user_id]", "[password]", "[customer_id]", "[account_no]", "[account_type]", " [bank_name]","[branch_name]","[bank_support_person]", "[bank_name]", "[bank_phone]", "[bank_fax]"];
                $change   = [$data['select']->cust_name,$data['select']->sur_name,$this->bankName, Session::get('branch'),$data['select']->cust_name, $data['select']->user_id,$user_password,$data['select']->customer_id,Session::get('account_no'),Session::get('type'),$this->bankName,Session::get('branch'),$this->bank_support_person,Session::get('branch'), $this->bankPhone,$this->bank_fax];

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

                $newPhrase = '<p>' . wordwrap($newPhrase, 100, "<br />\n") . '</p>';

                $body = "<html><head></head><body>";
                $body .= $newPhrase;
                $body .= "</body></html>";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                $headers .= 'From: ' . $this->bankName . ' <' . $this->bank_email . '>' . "\r\n";

               Mail::send([], [], function ($message) use ($data, $subject, $body) {
    $message->to($data['select']->cust_mail)
            ->subject($subject)
            ->setBody($body, 'text/html'); // Use 'text/plain' if plain text
});
                


                flash('Contact Information has been Verified')->success();
                               
                return redirect()->intended('login');

            }
            else {
                    
                flash('Wrong OTP, try again')->error();
                return redirect()->intended('login');
            }
        }
    }

    public function RetrieveAccountUserid(Request $request)
    {
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";
        $data['otp'] = 'hidden';
        //$data['echo2'] = $data['logo'];

        return view('open/retrieve-account-user-id', $data);
    }

    public function PostRetrieveAccountUserid(Request $request)
    {
        $data = array();
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bankBase'] = "/online";
        $data['otp'] = 'hidden';

        $data2 = $request->input();
        //$data['echo2'] = json_encode($data2);//show posted data
        $email = $data2['email'];
        $data['select'] = DB::select('select * from ba_account_holders where cust_mail = ? LIMIT 1', [$email]);
        if (isset($data['select'][0]->cust_mail)) {
            $data['qid2'] = $data['select'][0]->qid2;
            $data['email'] = $email;
            $data['otp'] = 'show';

            if (isset($data2['qid2']) and $data2['qid2'] == $data['select'][0]->ans2) {
                $subject = "Your Account ID is " . $data['select'][0]->user_id . " for " . $data['bankName'];

                $logo_link = "https://" . $this->bank_url . "/admin/uploads/" . $this->logo;
                $message = '<img src=' . $logo_link . ' alt="banking" style="display: block;
                margin-left: auto;
                margin-right: auto;
                width: 15%;">';
                $message .= '<p><b>Dear ' . $data['select'][0]->cust_name . "</b></p> Your Account ID is " . $data['select'][0]->user_id;
                $message .= '<p>
                Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:' . $this->bank_email . '>' . $this->bank_email . '</a>
                If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:' . $this->bank_email . '>' . $this->bank_email . '</a></p>';

                $body = "<html><head></head><body>";
                $body .= $message;
                $body .= "</body></html>";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                $headers .= 'From: ' . $this->bankName . ' <' . $this->bank_email . '>' . "\r\n";

              Mail::send([], [], function ($message) use ($data, $subject, $body) {
    $message->to($data['select'][0]->cust_mail)
            ->subject($subject)
            ->setBody($body, 'text/html'); // Change to 'text/plain' if needed
});

                flash('Your account id was sent to your email, check your spam folder as well')->success();
                return redirect()->intended('login');
            } else {
                if (isset($data2['qid2'])) {
                    flash('Wrong Information Provided')->error();
                    return redirect()->intended('login');
                } else {
                    flash('One more step')->success();
                    return view('open/retrieve-account-user-id', $data);
                }
            }
        } else {
            flash('That email is not registered')->error();
            return view('open/retrieve-account-user-id', $data);
        }

    }
    /*
     public function NewAccountSteps(Request $request) {
         $data = array();
         $data['main'] = 'cheque';
         $data['page'] = 'request-cheque-book';
         $data['bankName'] = $this->bankName;
         $data['logo'] = $this->logo;
         $data['question'] = 'cheque';

         $user_id = $request->session()->get('user_id');

         $notifaction=  new Controller();
         $notifaction->user_notifactions($user_id);
         $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
          $this->store_page_logs('request-cheque-book',$request->session()->get('user_id'));
         return view('open/newaccount-steps', $data);
     }
     public function RegisterNewInternetAccount(Request $request) {
         $data = array();
         $data['main'] = 'cheque';
         $data['page'] = 'request-cheque-book';
         $data['bankName'] = $this->bankName;
         $data['logo'] = $this->logo;
         $data['question'] = 'cheque';

         $user_id = $request->session()->get('user_id');

         $notifaction=  new Controller();
         $notifaction->user_notifactions($user_id);
         $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
          $this->store_page_logs('request-cheque-book',$request->session()->get('user_id'));
         return view('open/register-new-internet-account', $data);
     }


     public function stopCheque(Request $request) {
         $data = array();
         $data['main'] = 'cheque';
         $data['page'] = 'stop-cheque';
         $data['bankName'] = $this->bankName;
         $data['logo'] = $this->logo;

         $user_id = $request->session()->get('user_id');

         $notifaction=  new Controller();
         $notifaction->user_notifactions($user_id);
         $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
          $this->store_page_logs('stop-cheque-book',$request->session()->get('user_id'));

         return view('stop-cheque', $data);
     }

     public function insertStopCheque(Request $request) {
         $data = $request->input();

         $user_id = $request->session()->get('user_id');

         $data['user_id'] = $user_id;

         unset($data['_token']);

         $query = '';
         foreach($data as $col => $value) {
             if($query == '') {
                 $query = "$col = '$value'";
             }
             else {
                 $query .= ", $col = '$value'";
             }
         }

         DB::insert("insert into ba_stop_cheque set $query");

         flash('Stop Cheque Requested Successfully')->success();
         return redirect()->intended('stop-cheque-success');
     }

     public function stopChequeSuccess(Request $request) {
         $data = array();
         $data['main'] = 'cheque';
         $data['page'] = 'stop-cheque';
         $data['bankName'] = $this->bankName;
         $data['logo'] = $this->logo;

         $user_id = $request->session()->get('user_id');
         return view('stop-cheque-success', $data);
     }
     */

    public function getRegistrationEmailHtml($first_name, $last_name, $account_type, $user_id, $customer_id, $password) {
        $bank_url = $this->bank_url;
        $bank_name = $this->bankName;
        $logo = $this->logo;

        return '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bank Account Details</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; -webkit-font-smoothing: antialiased;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 30px 15px;">
    <tr>
      <td align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
          <tr>
            <td style="background-color: #ffffff; padding: 30px; text-align: center; border-bottom: 2px solid #f0f2f5;">
              <img src="https://' . $bank_url . '/admin/uploads/' . $logo . '" alt="' . $bank_name . '" style="max-width: 170px; height: auto; display: block; margin: 0 auto;">
            </td>
          </tr>
          <tr>
            <td style="padding: 35px 30px; color: #1f2937;">
              <h2 style="margin: 0 0 15px 0; color: #111827; font-size: 22px; font-weight: 700; text-align: center;">Welcome to ' . htmlspecialchars($bank_name) . '</h2>
              <p style="margin: 0 0 20px 0; font-size: 15px; line-height: 1.6; color: #4b5563;">
                Dear <strong>' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</strong>,
              </p>
              <p style="margin: 0 0 25px 0; font-size: 15px; line-height: 1.6; color: #4b5563;">
                We are pleased to inform you that your application for a new bank account has been successfully received. Below are your account login credentials:
              </p>
              
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border-radius: 10px; padding: 20px; border: 1px solid #e2e8f0; margin-bottom: 30px;">
                <tr>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #64748b; font-weight: 600; width: 40%;">Account Name</td>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #0f172a; font-weight: 600; text-align: right;">' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</td>
                </tr>
                <tr>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #64748b; font-weight: 600;">Account Type</td>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #0f172a; font-weight: 600; text-align: right;">' . htmlspecialchars($account_type) . '</td>
                </tr>
                <tr>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #64748b; font-weight: 600;">User ID</td>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #0f172a; font-weight: 700; text-align: right; font-family: monospace; font-size: 15px;">' . htmlspecialchars($user_id) . '</td>
                </tr>
                <tr>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #64748b; font-weight: 600;">Customer ID</td>
                  <td style="padding: 10px 0; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #0f172a; font-weight: 700; text-align: right; font-family: monospace; font-size: 15px;">' . htmlspecialchars($customer_id) . '</td>
                </tr>
                <tr>
                  <td style="padding: 10px 0; font-size: 14px; color: #64748b; font-weight: 600;">Access PIN / Password</td>
                  <td style="padding: 10px 0; font-size: 14px; color: #0284c7; font-weight: 700; text-align: right; font-family: monospace; font-size: 15px;">' . htmlspecialchars($password) . '</td>
                </tr>
              </table>

              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 25px;">
                <tr>
                  <td align="center">
                    <a href="https://' . $bank_url . '/login" target="_blank" style="background-color: #0284c7; color: #ffffff; display: inline-block; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px;">Login to Online Banking</a>
                  </td>
                </tr>
              </table>

              <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #6b7280; text-align: center;">
                For security reasons, please keep your login credentials confidential and do not share them with anyone.
              </p>
            </td>
          </tr>
          <tr>
            <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
              <p style="margin: 0 0 5px 0; font-size: 13px; color: #64748b;">
                Thank you for choosing <strong>' . htmlspecialchars($bank_name) . '</strong>.
              </p>
              <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                &copy; ' . date('Y') . ' ' . htmlspecialchars($bank_name) . '. All rights reserved.
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
    }

    public function getVerificationEmailHtml($name, $otp) {
        $bank_url = $this->bank_url;
        $bank_name = $this->bankName;
        $logo = $this->logo;

        return '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verification Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 30px 15px;">
    <tr>
      <td align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
          <tr>
            <td style="background-color: #ffffff; padding: 30px; text-align: center; border-bottom: 2px solid #f0f2f5;">
              <img src="https://' . $bank_url . '/admin/uploads/' . $logo . '" alt="' . $bank_name . '" style="max-width: 170px; height: auto; display: block; margin: 0 auto;">
            </td>
          </tr>
          <tr>
            <td style="padding: 35px 30px; color: #1f2937; text-align: center;">
              <h2 style="margin: 0 0 15px 0; color: #111827; font-size: 22px; font-weight: 700;">Account Verification</h2>
              <p style="margin: 0 0 20px 0; font-size: 15px; line-height: 1.6; color: #4b5563;">
                Dear <strong>' . htmlspecialchars($name) . '</strong>,
              </p>
              <p style="margin: 0 0 25px 0; font-size: 15px; line-height: 1.6; color: #4b5563;">
                Please use the verification code below to complete your account setup:
              </p>
              
              <div style="background-color: #f8fafc; border: 2px dashed #0284c7; border-radius: 10px; padding: 18px 30px; display: inline-block; margin-bottom: 25px;">
                <span style="font-size: 32px; font-weight: 800; letter-spacing: 6px; color: #0284c7; font-family: monospace;">' . htmlspecialchars($otp) . '</span>
              </div>

              <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #6b7280;">
                If you did not request this code, please ignore this email.
              </p>
            </td>
          </tr>
          <tr>
            <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
              <p style="margin: 0 0 5px 0; font-size: 13px; color: #64748b;">
                Thank you for choosing <strong>' . htmlspecialchars($bank_name) . '</strong>.
              </p>
              <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                &copy; ' . date('Y') . ' ' . htmlspecialchars($bank_name) . '. All rights reserved.
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
    }
}
