<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Ba_beneficiary;
use App\Ivr_token;
use App\SmsEditor;
use App\EmailEditor;
use Illuminate\Support\Str;
use App\UserActivity;
use Illuminate\Support\Carbon;


class Transfer extends Controller {

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
    
    public function ownAccountTransfer(Request $request) {
    	$data = array();
    	$data['main'] = 'transfer';
    	$data['page'] = 'own-account-transfer';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $data['accounts'] = DB::select('select * from ba_user_accounts where user_id = ? and access = 1', [$user_id]);
        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        return view('own-account-transfer', $data);
    }

    public function getAccountsToTransfer(Request $request) {
        $user_id = $request->session()->get('user_id');
        $transferFrom = $request->input('transferFrom');

        $account = DB::select('select * from ba_user_accounts where user_id = ? and account_no = ?', [$user_id, $transferFrom]);

        $accounts = DB::select('select * from ba_user_accounts where user_id = ? and account_currency = ? and account_no != ? and access = 1', [$user_id, $account[0]->account_currency, $transferFrom]);
        echo json_encode($accounts);
        exit;
    }

    public function initiateOwnAccountTransfer(Request $request) {
        $user_id = $request->session()->get('user_id');
        
        $data = $request->input();
        
        $tran_id = Str::upper(Str::random(4)) . ' ' . random_int(1000000, 9999999);
        $datetime = date("Y-m-d H:i:s");
        $token = rand(100000, 999999);
        $step2 = '';
        $step3 = '';
        $step4 = '';
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        //sms and email data
        $SmsEditor = SmsEditor::where('type', 'transfer_otp')->first();
        $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
        
        $verification_email = $EmailEditor->verification;
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        //sms replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        
        $verification = $SmsEditor->verification;
        $options = DB::select('select * from ba_options where user_id = ?', [$user_id]);
        if(isset($options[0])) {
            if($options[0]->step2 == 1) {
                $step2 = rand(100000, 999999);
            }
            
            if($options[0]->step3 == 1) {
                $step3 = rand(100000, 999999);
            }
            
            if($options[0]->step4 == 1) {
                $step4 = rand(100000, 999999);
            }
        }
        $data['amount'] = str_replace(",", "", $data['amount']);
        $transfer_from_account = DB::select('select * from ba_user_accounts where user_id = ? && account_no = ?', [$user_id, $data['transfer_from']]);
        if($transfer_from_account[0]->available_balance < $data['amount']) {
            flash('Amount not available in the account')->error();
            return redirect()->intended('own-account-transfer');
        }
        
        $accLimit = DB::table('ba_limits')->where('user_id',$user_id)->where('account_no',$data['transfer_from'])->where('status','1')->orderby('id','desc')->first();
        if($accLimit){
            $totalInMonth = DB::table('ba_transactions')->whereBetween('datetime',[date('Y-m-1'),date('Y-m-t')])->where('type','debited')->where('user_id',$user_id)->where('act_number',$data['transfer_from'])->get()->sum("amount");
            if($totalInMonth && ($totalInMonth + $data['amount']) >= $accLimit->limit_amount){
                flash('Your Monthly Transfer limit is completed')->error();
                return redirect()->intended('own-account-transfer');
            }    
        }
        
        $transfer_to_account = DB::select('select * from ba_user_accounts where user_id = ? && account_no = ?', [$user_id, $data['transfer_to']]);
        
        DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, token = ?, step2 = ?, step3 = ?, step4 = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $data['transfer_from'], 'debited', $transfer_from_account[0]->available_balance, 0, $data['amount'], $tran_id, $token, $step2, $step3, $step4, $data['description'], 0, 0, 'available_balance', $datetime]);
        
        DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $data['transfer_to'], 'credited', $transfer_to_account[0]->available_balance, 0, $data['amount'], $tran_id, $data['description'], 0, 0, 'available_balance', $datetime]);
        
        $traInsert = [
            'f'         => $data['transfer_from'],
            't'         => $data['transfer_to'],
            'amount'    => $data['amount'],
            'ttype'     => "Own Account Transfer",
            'currency'  => $transfer_from_account[0]->account_currency,
            'descr'     => $data['description'],
            'cat'       => date('Y-m-d H:i:s')
        ];
        DB::table('ba_transfers_temp')->insert($traInsert);
        
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
        $client = new Client($this->accountSid, $this->authToken);
        $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
        
        //verify and send sms and email
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
            UserActivity::saveUserActivity($request->session()->get('id'),'Own Account Transfer');
        return redirect()->intended('same-bank-transfer-otp/' . $tran_id . '/1');
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
        
        $token = isset($data['token']) ? $data['token'] : '';
        $logo_link = "https://" . $config[0]->bank_url . "/admin/uploads/" . $config[0]->logo;
        $token_html = !empty($token) ? '<p style="margin-top: 20px; font-size: 16px; font-weight: 700; color: #0284c7; background-color: #f0f9ff; padding: 12px 18px; border-radius: 8px; border: 1px dashed #0284c7; text-align: center;">Verification Token: ' . htmlspecialchars($token) . '</p>' : '';
        
        $body = '<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 30px 15px;">
    <tr>
      <td align="center">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;">
          <tr>
            <td style="background-color: #ffffff; padding: 30px; text-align: center; border-bottom: 2px solid #f0f2f5;">
              <img src="' . $logo_link . '" alt="' . htmlspecialchars($config[0]->bank_name) . '" style="max-width: 170px; height: auto; display: block; margin: 0 auto;">
            </td>
          </tr>
          <tr>
            <td style="padding: 35px 30px; color: #1f2937; font-size: 15px; line-height: 1.6;">
              ' . $message . '
              ' . $token_html . '
            </td>
          </tr>
          <tr>
            <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
              <p style="margin: 0 0 5px 0; font-size: 13px; color: #64748b;">
                Thank you for choosing <strong>' . htmlspecialchars($config[0]->bank_name) . '</strong>.
              </p>
              <p style="margin: 0; font-size: 12px; color: #94a3b8;">
                &copy; ' . date('Y') . ' ' . htmlspecialchars($config[0]->bank_name) . '. All rights reserved.
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        
        $headers[] = 'From: ' . $this->bankName . ' <'.$from_email.'>';
        
       Mail::send([], [], function ($message) use ($to_email, $subject, $body) {
    $message->to($to_email)
            ->subject($subject)
            ->setBody($body, 'text/html'); // or 'text/plain' if it's not HTML
});
        
        }
    public function successOwnAccountTransfer(Request $request) {
        $user_id = $request->session()->get('user_id');

        $data = $request->input();

        $tran_id = $data['tran_id'];
        $otp = $data['otp'];

        $check = DB::select('select * from ba_transactions where tran_id = ? and token = ? and status = ? and type = ?', [$tran_id, $otp, 0, 'debited']);

        if(isset($check[0])) {
            $transactions = DB::select('select * from ba_transactions where tran_id = ? and status = ?', [$tran_id, 0]);
            foreach($transactions as $tran) {
                $account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);
                if($tran->type == 'debited') {
                    $balance = $account[0]->available_balance - $tran->amount;
                }
                elseif($tran->type == 'credited') {
                    $balance = $account[0]->available_balance + $tran->amount;
                }
                DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
                DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
            }
            echo json_encode(array('success' => true, 'error' => false, 'msg' => 'OTP verified successfully'));
            exit;
        }
        else {
            echo json_encode(array('success' => true, 'error' => true, 'msg' => 'You have entered the wrong OTP'));
            exit;
        }
    }

    public function transferToSameBank(Request $request) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'transfer-to-same-bank';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select * from ba_user_accounts where user_id = ? and access = 1', [$user_id]);
        $Ba_beneficiary = Ba_beneficiary::where('bank_type', 1)->where('beneficiary_added_by_user_id', $user_id)->where('verification', 1)->get();
      
        return view('transfer-to-same-bank', $data,compact('Ba_beneficiary'));
    }

    public function initiateSameBankTransfer(Request $request) {
        $user_id = $request->session()->get('user_id');
        
        $data = $request->input();
        
        $tran_id = Str::upper(Str::random(4)) . ' ' . random_int(1000000, 9999999);
        $datetime = date("Y-m-d H:i:s");
        $token = rand(100000, 999999);
        $step2 = '';
        $step3 = '';
        $step4 = '';
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        //sms and email data
        $SmsEditor = SmsEditor::where('type', 'transfer_otp')->first();
        $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
        
        $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
        
        $verification_email = $EmailEditor->verification;
        
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        //sms replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        
        $options = DB::select('select * from ba_options where user_id = ?', [$user_id]);
        if(isset($options[0])) {
        if($options[0]->step2 == 1) {
        $step2 = rand(100000, 999999);
        }
        
        if($options[0]->step3 == 1) {
        $step3 = rand(100000, 999999);
        }
        
        if($options[0]->step4 == 1) {
        $step4 = rand(100000, 999999);
        }
        }
        $data['amount'] = str_replace(",", "", $data['amount']);
        $transfer_from_account = DB::select('select * from ba_user_accounts where user_id = ? && account_no = ?', [$user_id, $data['transfer_from']]);
        if($transfer_from_account[0]->available_balance < $data['amount']) {
        // echo json_encode(array('success' => true, 'error' => true, 'msg' => 'Amount not available in the account'));
        // exit;
        
        flash('Amount not available in the account')->error();
        return redirect()->intended('transfer-to-same-bank');
        }
        
        $transfer_to_account = DB::select('select * from ba_user_accounts where account_no = ?', [$data['beneficiary_account']]);
        if(!isset($transfer_to_account[0])) {
        // echo json_encode(array('success' => true, 'error' => true, 'msg' => 'Beneficiary Account Number does not exists'));
        // exit;
        
        flash('Beneficiary Account Number does not exists')->error();
        return redirect()->intended('transfer-to-same-bank');
        }
        else {
        $transfer_to_user = DB::select('select * from ba_account_holders where user_id = ?', [$transfer_to_account[0]->user_id]);
        
        if($transfer_to_user[0]->account_status == 2) {
        flash('Beneficiary User is suspended')->error();
        return redirect()->intended('transfer-to-same-bank');
        }
        
        if($transfer_to_user[0]->account_status == 0) {
        flash('Beneficiary User isn\'t approved yet.')->error();
        return redirect()->intended('transfer-to-same-bank');
        }
        
        if($transfer_to_account[0]->access == 3) {
        // echo json_encode(array('success' => true, 'error' => true, 'msg' => 'Beneficiary Account is suspended'));
        // exit;
        
        flash('Beneficiary Account is suspended')->error();
        return redirect()->intended('transfer-to-same-bank');
        }
        
        if($transfer_to_account[0]->account_currency != $transfer_from_account[0]->account_currency) {
        // echo json_encode(array('success' => true, 'error' => true, 'msg' => 'Beneficiary Account currency does not match Debit Account Currency'));
        // exit;
        
        flash('Beneficiary Account Currency does not match Debit Account Currency')->error();
        return redirect()->intended('transfer-to-same-bank');
        }
        }
        
        $accLimit = DB::table('ba_limits')->where('user_id',$user_id)->where('account_no',$data['transfer_from'])->where('status','1')->orderby('id','desc')->first();
        if($accLimit){
            $totalInMonth = DB::table('ba_transactions')->whereBetween('datetime',[date('Y-m-1'),date('Y-m-t')])->where('type','debited')->where('user_id',$user_id)->where('act_number',$data['transfer_from'])->get()->sum("amount");
            if($totalInMonth && ($totalInMonth + $data['amount']) >= $accLimit->limit_amount){
                flash('Your Monthly Transfer limit is completed')->error();
                return redirect()->intended('transfer-to-same-bank');
            }    
        }
        
        DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, token = ?, step2 = ?, step3 = ?, step4 = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $data['transfer_from'], 'debited', $transfer_from_account[0]->available_balance, 0, $data['amount'], $tran_id, $token, $step2, $step3, $step4, $data['description'], 0, 0, 'available_balance', $datetime]);
        
        DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $data['beneficiary_account'], 'credited', $transfer_to_account[0]->available_balance, 0, $data['amount'], $tran_id, $data['description'], 0, 0, 'available_balance', $datetime]);
        
        
        $traInsert = [
            'f'         => $data['transfer_from'],
            't'         => $data['beneficiary_account'],
            'amount'    => $data['amount'],
            'ttype'     => "Same Bank Transfer",
            'currency'  => $transfer_from_account[0]->account_currency,
            'descr'     => $data['description'],
            'cat'       => date('Y-m-d H:i:s')
        ];
        DB::table('ba_transfers_temp')->insert($traInsert);
        
        /* if(isset($data['save_beneficiary']) && $data['save_beneficiary'] == 1) {
        $beneficiary_check = DB::select('select * from ba_beneficiary where beneficiary_account = ? and beneficiary_added_by_user_id = ?', [$data['beneficiary_account'], $user_id]);
        
        if(!isset($beneficiary_check[0])) {
        DB::insert('insert into ba_beneficiary set beneficiary_added_by_user_id = ?, beneficiary_name = ?, beneficiary_account = ?, international = ?', [$user_id, $data['beneficiary_name'], $data['beneficiary_account'], 0]);
        }
        }*/
        
        /* $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);*/
        
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
        $client = new Client($this->accountSid, $this->authToken);
        $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
        //sending sms and email
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
        UserActivity::saveUserActivity($request->session()->get('id'),'Same Bank Transfer');  
        return redirect()->intended('same-bank-transfer-otp/' . $tran_id . '/1');
        }

    public function sameBankTransferOTP(Request $request, $tran_id, $step) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'transfer-to-same-bank';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $data['transactions'] = DB::select('select * from ba_transactions where tran_id = ?', [$tran_id]);
        $data['step'] = $step;
        $data['tran_id'] = $tran_id;
        return view('same-bank-transfer-otp', $data);
    }

    public function successSameBankTransfer(Request $request) {
        
        $user_id = $request->session()->get('user_id');
        $data = $request->input();
        $tran_id = $data['tran_id'];
        $step = $data['step'];
        $otp = $data['otp'];
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        //sms and email data
        $SmsEditor = SmsEditor::where('type', 'transfer_otp  ')->first();
        
        $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
        
        $verification_email = $EmailEditor->verification;
        
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        
        $final_sms = str_replace('[first_name]', $customername, $sms);
        
        $verification = $SmsEditor->verification;
        
        if($step == 1) {
        $check = DB::select('select * from ba_transactions where tran_id = ? and token = ? and status = ? and type = ?', [$tran_id, $otp, 0, 'debited']);
        }
        else {
        $field = 'step' . $step;
        $check = DB::select('select * from ba_transactions where tran_id = ? and ' . $field . ' = ? and status = ? and type = ?', [$tran_id, $otp, 0, 'debited']);
        }
        
        if(isset($check[0])) {
        if($step < 4) {
        $next_step = $step + 1;
        $field = 'step' . $next_step;
        
        if($check[0]->$field != '') {
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
        $client = new Client($this->accountSid, $this->authToken);
        $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
        /*$msg = 'You have initiated a transfer online for which OTP is: ' . $check[0]->$field;*/
        $msg = $final_sms . $check[0]->$field;
        
        if ($verification == 1) {
            foreach($recipients_arr as $recipient) {
            $client->messages->create($recipient, 
            ['from' => $this->fromNumber, 'body' => $msg] );
            }
        }
        if($verification_email == 1) {
        
            $data = array('user'=>$user, 'card' =>$request->all(), 'token'=>$check[0]->$field );   
            
            $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
        }
        
        }
        
        DB::update('update ba_transactions set step_no = ? where tran_id = ? and status = ? and type = ?', [$next_step, $tran_id, 0, 'debited']);
        return redirect()->intended('same-bank-transfer-otp/' . $tran_id . '/' . $next_step);
        }
        else {
            return redirect()->intended('finalise-same-bank-transfer/' . $tran_id);
        }
        }
        else {
            return redirect()->intended('finalise-same-bank-transfer/' . $tran_id);
        }
        }
        else {
        // echo json_encode(array('success' => true, 'error' => true, 'msg' => 'You have entered the wrong OTP'));
        // exit;
        
        flash('You have entered the wrong OTP')->error();
            return redirect()->intended('transfer-to-same-bank');
        }
        }

    public function finaliseSameBankTransfer(Request $request, $tran_id) {
        $transactions = DB::select('select * from ba_transactions where tran_id = ? and status = ?', [$tran_id, 0]);

        $remark = DB::select('select * from ba_other_transfers where tra = ? ',[ $tran_id]);

        foreach($transactions as $tran) {
        $account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);
        //if type is debited
        if($tran->type == 'debited') {
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$account[0]->user_id]);
        $SmsEditor = SmsEditor::where('type', 'transfer_debited')->first();
        $EmailEditor = EmailEditor::where('type', 'transfer_debited')->first();
        
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        $act_number = $tran->act_number;
        $amount = $tran->amount;
        $account_currency = $account[0]->account_currency;
        //sms replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $final_sms = str_replace('[act_number]', $act_number, $final_sms);
        $final_sms = str_replace('[amount]', $amount, $final_sms);
        $final_sms = str_replace('[account_currency]', $account_currency, $final_sms);
        //verification data
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        $balance = $account[0]->available_balance - $tran->amount;
        $type= 'Debit';
        $description = $tran->reason;
        //sms and email sending and verifying
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
        
        $msg = $final_sms ;
        if ($verification == 1) {
            foreach($recipients_arr as $recipient) {
            $client->messages->create($recipient, 
            ['from' => $this->fromNumber, 'body' => $msg] );
        }
        }
        if($verification_email == 1) {
            
            $data = array('user'=>$user, 'act_number' =>$tran->act_number, 'amount'=>$tran->amount , 'balance'=>$balance, 'type'=>$type,'remark'=>$description,'account_currency'=>$account[0]->account_currency);  
            
            $this->dynamic_email_for_amount($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
        }
        
        }
        }
        elseif($tran->type == 'credited') {
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$account[0]->user_id]);
        
        //sms and email data
        
        $SmsEditor = SmsEditor::where('type', 'transfer_credited')->first();
        $EmailEditor = EmailEditor::where('type', 'transfer_credited')->first();
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        $act_number = $tran->act_number;
        $amount = $tran->amount;
      
        $account_currency = $account[0]->account_currency;
        //sms replacing
        
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $final_sms = str_replace('[act_number]', $act_number, $final_sms);
        $final_sms = str_replace('[amount]', $amount, $final_sms);
        $final_sms = str_replace('[account_currency]', $account_currency, $final_sms);
        
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        $balance = $account[0]->available_balance + $tran->amount;
        $type= 'Credit';
       $description = $tran->reason;
            //email and sms sending
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
            
            $data = array('user'=>$user, 'act_number' =>$tran->act_number, 'amount'=>$tran->amount , 'balance'=>$balance,'type'=>$type,'remark'=>$description,'account_currency'=>$account[0]->account_currency);  
            
            $this->dynamic_email_for_amount($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
         }
          }
         }
            DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
            DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
        }
        
        return redirect()->intended('success_same');
        
        }
     
    public function dynamic_email_for_amount($data, $message, $subject, $to_email, $from_email){
        $config = DB::select('select * from configs WHERE id = ?',[1]);
        $currentDateTime = Carbon::now();
        
        if(isset($data['user'])){
        $customername = $data['user'][0]->cust_name.' '.$data['user'][0]->middle_name.' '.$data['user'][0]->sur_name;
        }  
        
        $body = "<html><head></head><body>";

        $logo_link = "https://" . $config[0]->bank_url . "/admin/uploads/" . $config[0]->logo;
        $body .= '<img src="' . $logo_link . '" alt="banking" style="display:block;margin:auto;width:14%;" />';
        $body .= '<h1><br> Dear, ' . $customername . ' <br></h1>';
        $body .= '<p><br> This is Summary of Transaction that has occurred on your account. <br></p>';
        $body .= '<table border="10" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">';
        
       

        if ($currentDateTime != '') {
            $body .= '<tr style="background-color:#2b2a2a;color:white"><th style=" padding: 4px; width: 30%;">Date and Time</th>';
            $body .= '<td style=" padding: 4px;">' . $currentDateTime->format('d-M-Y H:i') . '</td></tr>';
        }

        if($data['act_number']!= ''){
            $body .= '<tr style="background-color:#635f5f;color:white"><th style=" padding: 4px; width: 30%;">Account Number</th>';
            $body .= '<td style=" padding: 4px;">' . $data['act_number'] . '</td></tr>';
        }

        if($data['remark']!= ''){
            $body .= '<tr style="background-color:#2b2a2a;color:white"><th style=" padding: 4px; width: 30%;">Description</th>';
            $body .= '<td style=" padding: 4px;">' . $data['remark'] . '</td></tr>';
        }


        if($data['amount']!= ''){
            $body .= '<tr style="background-color:#635f5f;color:white"><th style=" padding: 4px; width: 30%;">Amount</th>';
            $body .= '<td style=" padding: 4px;">' . $data['account_currency'].''.$data['amount'] . '</td></tr>';
        }
        
        if($data['type']!= ''){
        $body .= '<tr style="background-color:#2b2a2a;color:white"><th style=" padding: 4px; width: 30%;">Credit/Debit</th>';
        $body .= '<td style=" padding: 4px;">' . $data['type'] . '</td></tr>';
        }

        if($data['balance']!= ''){
            $body .= '<tr style="background-color:red;color:white"><th style=" padding: 4px; width: 30%;">Balance</th>';
            $body .= '<td style=" padding: 4px;">' . $data['balance'] . '</td></tr>';
        }

        $body .= '</table>';
       
        
        $body .= '<p>Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href="mailto:' . $config[0]->bank_email . '">' . $config[0]->bank_email . '</a>';
        $body .= 'If this notification was received by any other persons other than the intended recipient, please send a mail to: <a href="mailto:' . $config[0]->bank_email . '">' . $config[0]->bank_email . '</a></p>';
        $body .= "</body></html>";


        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: ' . $this->bankName . ' <' . $from_email . '>';

       Mail::send([], [], function ($message) use ($to_email, $subject, $body) {
    $message->to($to_email)
            ->subject($subject)
            ->setBody($body, 'text/html'); // Use 'text/plain' if not sending HTML
});
        }

        

    public function transferToOtherBank(Request $request) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'transfer-to-other-bank';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select * from ba_user_accounts where user_id = ? and access = 1', [$user_id]);
        $data['beneficiaries'] = DB::select('select * from ba_beneficiary where beneficiary_added_by_user_id = ?', [$user_id]);
        $data['currencies'] = DB::select('select * from currencies');
        $data['user_id']=$user_id;
        $Ba_benes = Ba_beneficiary::where('bank_type',0)
        ->where('beneficiary_added_by_user_id', $user_id)->get();
        
        $t_control = DB::table('ba_account_holders')->where('user_id', $user_id)->first();
        return view('transfer-to-other-bank', $data, compact('Ba_benes'));
    }

    public function initiateOtherBankTransfer(Request $request) {
        $checkValues =  request()->validate([
            "transfer_from"=>'required',
            "amount"=>'required',
            "beneficiary"=>'required',
            "debit_from"=>'required',
            
            ]);
            
        // dd($checkValues);
        session(['TransferToOtherBank' => '0']);
        $user_id = $request->session()->get('user_id');
        $data = $request->input();
        $tran_id = Str::upper(Str::random(4)) . ' ' . random_int(1000000, 9999999);
        $datetime = date("Y-m-d H:i:s");
        $token = rand(100000, 999999);
        $step2 = '';
        $step3 = '';
        $step4 = '';
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        //sms and email data
        $SmsEditor = SmsEditor::where('type', 'transfer_otp')->first();
        $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
       
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $sms = $SmsEditor->sms;
        //sms replacing
        $final_sms = str_replace('[first_name]', $customername, $sms);
        //check verification
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        
        $options = DB::select('select * from ba_options where user_id = ?', [$user_id]);
        if(isset($options[0])) {
        if($options[0]->step2 == 1) {
        $step2 = rand(100000, 999999);
        }
        
        if($options[0]->step3 == 1) {
        $step3 = rand(100000, 999999);
        }
        
        if($options[0]->step4 == 1) {
        $step4 = rand(100000, 999999);
        }
        }
        $data['amount'] = str_replace(",", "", $data['amount']);
        $transfer_from_account = DB::select('select * from ba_user_accounts where user_id = ? && account_no = ?', [$user_id, $data['transfer_from']]);
        if($transfer_from_account[0]->available_balance < $data['amount']) {
         
        flash('Amount not available in the account')->error();
        return redirect()->intended('transfer-to-other-bank');
        }
        
        $charges = (0.045 / 100) * $data['amount'];
        
        $debit_from_account = DB::select('select * from ba_user_accounts where user_id = ? && account_no = ?', [$user_id, $data['debit_from']]);
        if($debit_from_account[0]->available_balance < $charges) {
         
        flash('Amount not available in the account for charges')->error();
        return redirect()->intended('transfer-to-other-bank');
        }
        
        // $transfer_to_account = DB::select('select * from ba_user_accounts where account_no = ?', [$data['beneficiary_account']]);
        // if(!isset($transfer_to_account[0])) {
        //     echo json_encode(array('success' => true, 'error' => true, 'msg' => 'Beneficiary Account Number does not exists'));
        //     exit;
        // }
        
        $accLimit = DB::table('ba_limits')->where('user_id',$user_id)->where('account_no',$data['transfer_from'])->where('status','1')->orderby('id','desc')->first();
        if($accLimit){
            $totalInMonth = DB::table('ba_transactions')->whereBetween('datetime',[date('Y-m-1'),date('Y-m-t')])->where('type','debited')->where('user_id',$user_id)->where('act_number',$data['transfer_from'])->get()->sum("amount");
            if($totalInMonth && ($totalInMonth + $data['amount']) >= $accLimit->limit_amount){
                flash('Your Monthly Transfer limit is completed')->error();
                return redirect()->intended('transfer-to-other-bank');
            }    
        }
        
        DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, token = ?, step2 = ?, step3 = ?, step4 = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $data['transfer_from'], 'debited', $transfer_from_account[0]->available_balance, 0, $data['amount'], $tran_id, $token, $step2, $step3, $step4, 0, 1, 'available_balance', $datetime]);
        
        DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $data['receiver_noniban'], 'credited', 0, 0, $data['amount'], $tran_id, 0, 1, 'available_balance', $datetime]);
        
        DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $data['debit_from'], 'charges', $debit_from_account[0]->available_balance, 0, $charges, $tran_id, 0, 1, 'available_balance', $datetime]);
        
        $traInsert = [
            'f'         => $data['transfer_from'],
            't'         => $data['receiver_noniban'],
            'amount'    => $data['amount'],
            'ttype'     => "Other Bank Transfer",
            'currency'  => $transfer_from_account[0]->account_currency,
            'descr'     => "",
            'cat'       => date('Y-m-d H:i:s')
        ];
        DB::table('ba_transfers_temp')->insert($traInsert);
        
        $traInsert = [
            'user'      => $user_id,
            'account'   => $transfer_from_account[0]->id,
            'amount'    => $data['amount'],
            'benefe'    => $data['beneficiary'],
            'currency'  => $transfer_from_account[0]->account_currency,
            'amount'    => $data['amount'],
            'tra'       => $tran_id,
            'cat'       => date('Y-m-d H:i:s'),
            'remark'       => $data['remark']
        ];
        DB::table('ba_other_transfers')->insert($traInsert);
        
        /* if(isset($data['save_beneficiary']) && $data['save_beneficiary'] == 1) {
        $beneficiary_check = DB::select('select * from ba_beneficiary where beneficiary_account = ? and beneficiary_added_by_user_id = ?', [$data['receiver_noniban'], $user_id]);
        
        if(!isset($beneficiary_check[0])) {
        DB::insert('insert into ba_beneficiary set beneficiary_added_by_user_id = ?, beneficiary_name = ?, beneficiary_address = ?, beneficiary_sort_code = ?, beneficiary_swift = ?, beneficiary_iban = ?, beneficiary_account = ?, beneficiary_bank_name = ?, beneficiary_bank_address = ?, beneficiary_country = ?, international = ?', [$user_id, $data['receiver_name'], $data['receiver_address'], $data['receiver_route'], $data['receiver_swift'], $data['receiver_iban'], $data['receiver_noniban'], $data['receiver_bank'], $data['receiver_bank_address'], $data['receiver_bank_country'], 1]);
        }
        }*/
        
                //sms and email sending
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
        UserActivity::saveUserActivity($request->session()->get('id'),'Other Bank Transfer');  
        return redirect()->intended('other-bank-transfer-otp/' . $tran_id . '/1');
        }

    public function otherBankTransferOTP(Request $request, $tran_id, $step) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'transfer-to-other-bank';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $data['transactions'] = DB::select('select * from ba_transactions where tran_id = ?', [$tran_id]);
        $data['step'] = $step;
        $data['tran_id'] = $tran_id;
        return view('other-bank-transfer-otp', $data);
    }

    public function otherBankTransforOTPIVR(Request $request, $tran_id, $step) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'transfer-to-other-bank';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $data['transactions'] = DB::select('select * from ba_transactions where tran_id = ?', [$tran_id]);

        $data['tran_id'] = $tran_id;
        $data['step'] = $step;
        
         $tokenData = Ivr_token::where('user_id',$user_id)->get();
         $data['token'] = $tokenData;
        
        return view('other-bank-transfer-otp-new', $data);
    }


    public function resumeInternationalTransfer(Request $request, $tran_id) {
        $user_id = $request->session()->get('user_id');
        $transaction = DB::select('select * from ba_transactions where tran_id = ? and status = 0 and type = ?', [$tran_id, 'debited']);
        
        $token = rand(100000, 999999);
        DB::table('ba_transactions')->where('tran_id',$tran_id)->update(['token' => $token]);
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        $SmsEditor = SmsEditor::where('type', 'transfer_otp')->first();
        $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
        $sms = $SmsEditor->sms;
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
            $msg = $final_sms . $token;
            if ($verification == 1) {
        		foreach($recipients_arr as $recipient){
        			$client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg]);
                }
        	}  
            if($verification_email == 1) {
                $data = array('user'=>$user, 'card' => false, 'token' => $token);   
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
            }
        }
        
        if(isset($transaction[0]) && $transaction[0]->step_no == 0) {
            return redirect()->intended('other-bank-transfer-otp/' . $tran_id . '/1');
        }
        else {
            return redirect()->intended('other-bank-transfer-otp/' . $tran_id . '/' . $transaction[0]->step_no);
        }
    }

    public function resumeLocalTransfer(Request $request, $tran_id) {
        $token = rand(100000, 999999);
        $user_id = $request->session()->get('user_id');
        $transaction = DB::select('select * from ba_transactions where tran_id = ? and status = 0 and type = ?', [$tran_id, 'debited']);
        DB::table('ba_transactions')->where('tran_id',$tran_id)->update(['token' => $token]);
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        $SmsEditor = SmsEditor::where('type', 'transfer_otp')->first();
        $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
        $sms = $SmsEditor->sms;
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
            $msg = $final_sms . $token;
            if ($verification == 1) {
        		foreach($recipients_arr as $recipient){
        			$client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $msg]);
                }
        	}  
            if($verification_email == 1) {
                $data = array('user'=>$user, 'card' => false, 'token' => $token);   
                $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
            }
        }
        
        if(isset($transaction[0]) && $transaction[0]->step_no == 0) {
            return redirect()->intended('same-bank-transfer-otp/' . $tran_id . '/1');
        }
        else {
            return redirect()->intended('same-bank-transfer-otp/' . $tran_id . '/' . $transaction[0]->step_no);
        }
    }

    public function successOtherBankTransfer(Request $request) {
        
        $user_id = $request->session()->get('user_id');
        $data = $request->input();
        $tran_id = $data['tran_id'];
        $step = $data['step'];
        $otp = $data['otp'];
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);

        // Check if transfer is disabled for this user
        $transfer_control = DB::table('ba_account_holders')->where('user_id', $user_id)->first();
        if($transfer_control && $transfer_control->transfer_control == 1) {
            $transfer_status = DB::table('transfer_suspend_msg')->where('user_id', $user_id)->first();
            if(empty($transfer_status)) {
                $blocked_heading = 'Transfer Failed';
                $blocked_msg = 'This user profile is currently disabled from accessing this facility, Please visit your nearest branch to enable this facility in your profile, and allow you effect transfer to other banks';
            } else {
                $blocked_heading = !empty($transfer_status->heading) ? $transfer_status->heading : 'Transfer Failed';
                $blocked_msg = $transfer_status->message;
            }
            return redirect()->intended('transfer-to-other-bank')
                ->with('transfer_blocked_message', $blocked_msg)
                ->with('transfer_blocked_heading', $blocked_heading);
        }

        if($step == 1) {
            $check = DB::select('select * from ba_transactions where tran_id = ? and token = ? and status = ? and type = ?', [$tran_id, $otp, 0, 'debited']);
        }
        elseif($step == 2 or $step == 3) {
            $field = 'step' . $step;
            $check = DB::select('select * from ba_transactions where tran_id = ? and ' . $field . ' = ? and status = ? and type = ?', [$tran_id, $otp, 0, 'debited']);}
        else{
            if($step == 4){
            $check = Ivr_token::where('user_id',$user_id)->where('code_1', $otp)->get();
            }
            if($step == 5){
                $check = Ivr_token::where('user_id',$user_id)->where('code_2', $otp)->get();
            }
            if($step == 6){
                $check = Ivr_token::where('user_id',$user_id)->where('code_3', $otp)->get();
            }
        }
        
        if(isset($check[0])) 
        {
            if($step < 7) 
            {
                 $next_step = $step + 1;
                 $field = 'step' . $next_step;
                 if( $next_step==2 or $next_step == 3)
                 {
                    if($check[0]->$field != '')
                    {
                        //sms and email data
                        if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                            
                            $SmsEditor = SmsEditor::where('type', 'transfer_otp')->first();
                            $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
                            $final_sms = str_replace('[first_name]', $customername, $SmsEditor->sms);
                            $msg = $final_sms . $check[0]->$field;
                            if ($SmsEditor->verification == 1) {
                                    $client = new Client($this->accountSid, $this->authToken);
                                    $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                                    foreach($recipients_arr as $recipient) {
                                    $client->messages->create($recipient, 
                                    ['from' => $this->fromNumber, 'body' => $msg] );
                                }
                            }
                            $EmailEditor = EmailEditor::where('type', 'transfer_otp')->first();
                            $verification_email = $EmailEditor->verification;
                            if($verification_email == 1) {
                               $data = array('user'=>$user, 'card' =>$request->all(), 'token'=>$token );   
                               $this->dynamic_email($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
                            }
                        }
                     DB::update('update ba_transactions set step_no = ? where tran_id = ? and status = ? and type = ?', [$next_step, $tran_id, 0, 'debited']);
                     return redirect()->intended('other-bank-transfer-otp/' . $tran_id . '/' . $next_step);
                 } 
                 else{
                    $tokenData = Ivr_token::where('user_id',$user_id)->get();
                    if($tokenData->count()){
                        if($tokenData[0]['allow_code_1']==1){
                            
                             return redirect()->intended('successOtherBank/' . $tran_id . '/4');
                        }elseif($tokenData[0]['allow_code_2']==1){
                            
                             return redirect()->intended('successOtherBank/' . $tran_id . '/5');
                        }elseif($tokenData[0]['allow_code_3']==1){
                            
                             return redirect()->intended('successOtherBank/' . $tran_id . '/6');
                        }else{
                            DB::table('ba_other_transfers')->where('tra',$tran_id)->update(['status' => '1']);
                             return redirect()->intended('finalise-other-bank-transfer/' . $tran_id);
                        }
                    }else{
                        DB::table('ba_other_transfers')->where('tra',$tran_id)->update(['status' => '1']);
                        return redirect()->intended('finalise-other-bank-transfer/' . $tran_id); 
                    }  
                }
            }    
                 elseif( $next_step==5 or $next_step == 6){
            
                    $tokenData = Ivr_token::where('user_id',$user_id)->get();
                    if($tokenData->count()){
                        if($tokenData[0]['allow_code_2']==1 and $next_step==5){
                            
                            return redirect()->intended('successOtherBank/' . $tran_id . '/5');
                        }
                        elseif($tokenData[0]['allow_code_3']==1 and $next_step==6){
                            
                             return redirect()->intended('successOtherBank/' . $tran_id . '/6');
                        }else{
                            DB::table('ba_other_transfers')->where('tra',$tran_id)->update(['status' => '1']);
                            return redirect()->intended('finalise-other-bank-transfer/' . $tran_id); 
                        }
                    }else{
                        DB::table('ba_other_transfers')->where('tra',$tran_id)->update(['status' => '1']);
                        return redirect()->intended('finalise-other-bank-transfer/' . $tran_id); 
                    }  
                }
                else{
                    DB::table('ba_other_transfers')->where('tra',$tran_id)->update(['status' => '1']);
                    return redirect()->intended('finalise-other-bank-transfer/' . $tran_id); 
                    
                } 
          
            }
            else{
                flash('You have entered wrong OTP')->error();
                return redirect()->intended('transfer-to-other-bank');
            }
        }
        else{
            
            flash('You have entered wrong OTP')->error();
            return redirect()->intended('transfer-to-other-bank');
        }
    }
    public function finaliseOtherBankTransfer(Request $request, $tran_id) {
        
        $transactions = DB::select('select * from ba_transactions where tran_id = ? and status = ?', [$tran_id, 0]);

        $remark = DB::select('select * from ba_other_transfers where tra = ? ',[ $tran_id]);
       
        foreach($transactions as $tran) {
            if($tran->type == 'debited') {
                $account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);
                $user = DB::select('select * from ba_account_holders where user_id = ?', [$account[0]->user_id]);
                $act_number = $tran->act_number;
                $amount  = $tran->amount;
                $account_currency  = $account[0]->account_currency;
                $balance = $account[0]->available_balance - $tran->amount; 
                $type= 'Debit';
                $description = $remark[0]->remark;
                //sms and email sending
                if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                    $SmsEditor = SmsEditor::where('type', 'transfer_debited')->first();
                    $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
                    $final_sms = str_replace('[first_name]', $customername, $SmsEditor->sms);
                    $final_sms = str_replace('[act_number]', $act_number, $final_sms);
                    $final_sms = str_replace('[amount]', $amount, $final_sms);
                    $final_sms = str_replace('[account_currency]', $account_currency, $final_sms);
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                    $msg = $final_sms ;
                    if ( $SmsEditor->verification == 1) {
                        foreach($recipients_arr as $recipient) {
                            $client->messages->create($recipient, 
                            ['from' => $this->fromNumber, 'body' => $msg] );
                         }
                    }
                    $EmailEditor = EmailEditor::where('type', 'transfer_debited')->first();
                    if($EmailEditor->verification == 1) {
                        $data = array('user'=>$user, 'act_number' =>$tran->act_number, 'amount'=>$tran->amount, 'balance'=>$balance ,'type'=>$type,'remark'=>$description,'account_currency'=>$account[0]->account_currency);  
                        $this->dynamic_email_for_amount($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
                    }
        
                }
                
                DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
                DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
            }
            elseif($tran->type == 'credited') {
                $balance = $tran->amount;
                DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
            }
            //if type charges
            elseif($tran->type == 'charges') {
                
                $account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);
                $user = DB::select('select * from ba_account_holders where user_id = ?', [$account[0]->user_id]);
                $act_number = $tran->act_number;
                $amount  = $tran->amount;
                $account_currency  = $account[0]->account_currency;
                $balance = $account[0]->available_balance - $tran->amount;
                $type= 'Debit';
                $description = $remark[0]->remark;
                //sms and email sending
                if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                    
                    $SmsEditor = SmsEditor::where('type', 'charges_debited')->first();
                    $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
                        //sms replacing
                    $final_sms = str_replace('[first_name]', $customername, $SmsEditor->sms);
                    $final_sms = str_replace('[act_number]', $act_number, $final_sms);
                    $final_sms = str_replace('[amount]', $amount, $final_sms);
                    $final_sms = str_replace('[account_currency]', $account_currency, $final_sms);
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                    $msg = $final_sms;
                    if ($SmsEditor->verification == 1) {
                        foreach($recipients_arr as $recipient) {
                            $client->messages->create($recipient, 
                            ['from' => $this->fromNumber, 'body' => $msg] );
                        }
                    }
                    $EmailEditor = EmailEditor::where('type', 'charges_debited')->first();
                    if($EmailEditor->verification == 1) {
                        $data = array('user'=>$user, 'act_number' =>$tran->act_number, 'amount'=>$tran->amount , 'balance'=>$balance,'type'=>$type,'remark'=>$description,'account_currency'=>$account[0]->account_currency);  
                        $this->dynamic_email_for_amount($data, $EmailEditor->email, $EmailEditor->name, $user[0]->cust_mail, $this->fromEmail);
                    }
                }
                DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
                DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
            }
            
        }
        
        return redirect()->intended('success');
        
}

    public function manageBeneficiaries(Request $request) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'manage-beneficiaries';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        // Redirect transfer to other bank
        // if ($request->session()->get('TransferToOtherBank') == 1) {
        //     # code...
        //     return redirect('/transfer-to-other-bank');
        // }
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['same_bank_beneficiaries'] = DB::select('select * from ba_beneficiary where beneficiary_added_by_user_id = ? && international = 0', [$user_id]);
        $data['other_bank_beneficiaries'] = DB::select('select * from ba_beneficiary where beneficiary_added_by_user_id = ? && international = 1', [$user_id]);
        

         $Ba_beneficiary = Ba_beneficiary::where('beneficiary_added_by_user_id', $user_id)->get();
        
        return view('manage-beneficiaries', $data , compact('Ba_beneficiary'));
    }

    public function deleteBeneficiary(Request $request, $id) {
        DB::delete('delete from ba_beneficiary where id = ?', [$id]);

        flash('Beneficiary Deleted Successfully')->success();
        return redirect()->intended('manage-beneficiaries');
    }

    public function resumePendingTransfer(Request $request) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = 'resume-pending-transfer';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['transactions'] = DB::select('select * from ba_transactions where user_id = ? and status = 0 and type = ?', [$user_id, 'debited']);
        foreach($data['transactions'] as &$transaction) {
            $transactions2 = DB::select('select * from ba_transactions where user_id = ? and status = 0 and tran_id = ? and id != ? and type = ?', [$user_id, $transaction->tran_id, $transaction->id, 'credited']);
            $transaction->other_transactions = $transactions2;
            //print_r($transactions2);exit;
        }
        return view('resume-pending-transfer', $data);
    }

    public function success(Request $request) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = '';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $user_id = $request->session()->get('user_id');

        $transaction_summary = DB::select('SELECT * FROM `ba_transactions` WHERE `user_id` = ? ORDER BY ID DESC LIMIT 1,1',[$user_id]);
        
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
            
        // return view('success', $data);
        // return view('success', $data)->with('transaction_summary',$transaction_summary);
        $request->session()->put('data', $data);
        $request->session()->put('transaction_summary', $transaction_summary);
        return view('process_loading', $data)->with('transaction_summary',$transaction_summary);
    }
    

     public function done(Request $request) {
           $data = session('data');
           $transaction_summary = session('transaction_summary');
           return view('success', $data)->with('transaction_summary',$transaction_summary);
     }  
    
    public function print_summary(Request $request) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = '';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $user_id = $request->session()->get('user_id');

        $transaction_summary = DB::select('SELECT * FROM `ba_transactions` WHERE `user_id` = ? ORDER BY ID DESC LIMIT 1,1',[$user_id]);
        
        $account = DB::table('ba_user_accounts')->where('user_id',$user_id)->first();
        
       
         
        if($account){
            $data['balance']    = $account->available_balance;
            $data['currency']   = $account->account_currency;
            $data['acno']       = "xxxxxxx".substr($account->account_no,-4);
            $data['actype']     = $account->account_type;
            $data['actype']     = $account->account_type;
            $data['u_id']     = $request->session()->get('user_id');
        }else{
            $data['balance'] = 0.00;
            $data['currency'] = "USD";
            $data['acno']       = "N/A";
            $data['actype']     = "";
        }
            
        // return view('success', $data);
        return view('summary_pdf', $data)->with('transaction_summary',$transaction_summary);
    }
    
    
    public function success_same(Request $request) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = '';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        return view('success_same', $data);
    }
    public function successOtherBank(Request $request,$tran_id,$step) {
        $data = array();
        $data['main'] = 'transfer';
        $data['page'] = '';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['tran_id'] = $tran_id;
        $data['step'] = $step;

        $user_id = $request->session()->get('user_id');
        return view('successProceed', $data);
    }
}
