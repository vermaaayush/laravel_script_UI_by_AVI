<?php

namespace App\Http\Controllers;
use DB;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;
use PDF;
Use \Carbon\Carbon;
use Twilio\Rest\Client;
use App\SmsEditor;
use Session;

class Account extends Controller {

    public function __construct() {
      
       
         $config = DB::select('select bank_email, bank_name, logo, sms_token, sms_sid,bank_url, sms_phone, sms_token from configs where 1');
         
         $this->fromEmail = $config[0]->bank_email;

        $this->bankName = $config[0]->bank_name;

        $this->logo = $config[0]->logo;
        
        $this->bank_url= $config[0]->bank_url;

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
    
    public function accountsSummary(Request $request) {
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
        return view('accounts-summary', $data);
    }

    public function accountQuicklook(Request $request, $id) {
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'accounts-summary';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $data['account'] = DB::select('select ba_user_accounts.* from ba_user_accounts where user_id = ? and id = ?', [$user_id, $id]);
        $data['transactions'] = DB::select('select * from ba_transactions where act_number = ? order by datetime desc limit 10', [$data['account'][0]->account_no]);
        $this->store_page_logs('account-quick-look',$request->session()->get('user_id'));
        return view('account-quicklook', $data);
    }

    public function accountStatement(Request $request) {
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'account-statement';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
         $this->store_page_logs('account-statment',$request->session()->get('user_id'));
        return view('account-statement', $data);
    }

    public function getAccountStatement(Request $request) {
        // return Excel::download(new UsersExport, 'users.xlsx');
        // return Excel::download(new TransactionsExport, 'transactions.xlsx');
        
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'account-statement';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
       
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['start'] = $request->input('start');
        $data['end'] = $request->input('end');
        $data['account_id'] = $request->input('account');
        $data['type'] = $request->input('type');

        $data['account'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where ba_user_accounts.user_id = ? and ba_user_accounts.id = ?', [$user_id, $data['account_id']]);

        if($data['type'] == 'view') {
            $data['transactions'] = DB::select('select * from ba_transactions where act_number = ? and UNIX_TIMESTAMP(datetime) between ? and ? order by datetime desc', [$data['account'][0]->account_no, strtotime($data['start'] . "00:00:00"), strtotime($data['end'] . "23:59:00")]);
             $this->store_page_logs('get-account-statement',$request->session()->get('user_id'));
            return view('get-account-statement', $data);
        }
        elseif($data['type'] == 'excel') {
            // return (new TransactionsExport($data['account'][0]->account_no, strtotime($data['start'] . "00:00:00"), strtotime($data['end'] . "23:59:00")))->download('transactions.xlsx');

            $transactions = DB::table('ba_transactions')
           ->select('datetime', 'type', 'tran_id', 'reason', 'amount', 'balance')
           ->where('act_number', $data['account'][0]->account_no)
           ->whereBetween(DB::raw('unix_timestamp(datetime)'), [strtotime($data['start'] . "00:00:00"), strtotime($data['end'] . "00:00:00")])->orderBy('datetime', 'desc')->get();
           $transactions = $transactions->toArray();
           $customer = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            return Excel::download(new TransactionsExport($this->bankName,$transactions, $customer, $data['account'], $data['account'][0]->account_no, strtotime($data['start'] . "00:00:00"), strtotime($data['end'] . "23:59:00")), 'transactions.xlsx');
        }
        elseif($data['type'] == 'pdf') {
            $transactions = DB::table('ba_transactions')
           ->select('datetime', 'type', 'tran_id', 'reason', 'amount', 'balance')
           ->where('act_number', $data['account'][0]->account_no)
           ->whereBetween(DB::raw('unix_timestamp(datetime)'), [strtotime($data['start'] . "00:00:00"), strtotime($data['end'] . "00:00:00")])->orderBy('id', 'desc')->get();
            $transactions = $transactions->toArray();
            $customer = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
            

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('transactions-export-pdf', ['bank_name' => $this->bankName,'logo' => 'https://'.Session::get('bank_url').'/admin/uploads/'.$this->logo,'transactions' => $transactions, 'customer' => $customer, 'account' => $data['account'], 'account_no' => $data['account'][0]->account_no, 'start' => strtotime($data['start']), 'end' => strtotime($data['end'])]);
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            // If you want to store the generated pdf to the server then you can use the store function
            // $pdf->save(storage_path().'_filename.pdf');
            return $pdf->download('transactions.pdf');
        }
    }

    public function accountManager(Request $request) {
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'account-manager';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['am'] = DB::select('select ba_am.* from ba_account_holders inner join ba_am on ba_account_holders.am=ba_am.id where user_id = ?', [$user_id]);
         $this->store_page_logs('account-manager',$request->session()->get('user_id'));
        return view('account-manager', $data);
    }
    
    public function additionalAccounts(Request $request){
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'additional-accounts';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $branches = DB::select('select * from bank_details');
        $security_questions = DB::select('select * from ba_securityquestions');
        $ams = DB::select('select * from ba_am');
        
        $data['security_questions'] = $security_questions;
        $data['ams'] = $ams;

        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        return view('additional-accounts', $data);
    }
    
    public function additionalAccountsSendPin(Request $request){
        $post = $request->all();
        $phone = array($post['code'].' '.$post['phone']); 
        $email = $post['email'];
        $smsToken = rand(100000, 999999);
        $emailToken = rand(100000, 999999);
        
        $client = new Client($this->accountSid, $this->authToken);
        $smsMsg = 'Please enter this verification code to verify phone : ' . $smsToken;
        $emailMsg = 'Please enter this verification code to verify email : ' . $emailToken;
        
        foreach($phone as $recipient) {
            $client->messages->create($recipient, ['from' => $this->fromNumber, 'body' => $smsMsg] );
        }
        
        Mail::raw($emailMsg, function($message) use ($email)
        {
            $message->from($this->fromEmail, 'Banking');

            $message->subject('Email Verification');

            $message->to($email);
        });
        
        echo json_encode(['otpPhone' => $smsToken,'otpEmail' => $emailToken]);
    }
    
    public function additionalAccountsSave(Request $request){
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
        $dob = date('Y-m-d',strtotime($request->input('dob')));
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
        $max_amount = $request->input('max_amount');
        
        $user_id = time();
        $customer_id = $this->getCustomerID();
        $cust_password = $this->getCustomerPassword();
        DB::insert('insert into ba_account_holders (cust_name,middle_name,sur_name,idnumber,dob,mother_maiden,cust_mail,cust_city,cust_state,cust_address,cust_country,post_code,max_amount,cust_countrycode,cust_phone,qid,ans,qid2,ans2,am,cust_photo,cust_natioanl_id,verification_document,user_id,customer_id,cust_password) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$cust_name,$middle_name,$sur_name,$idnumber,$dob,$mother_maiden,$cust_mail,$cust_city,$cust_state,$cust_address,$cust_country,$post_code,$max_amount,$cust_countrycode,$cust_phone,$qid,$ans,$qid2,$ans2,$am,"","","",$user_id,$customer_id,$cust_password]);
        
        flash('Account Successfully Created')->success();
        return redirect()->intended('additional-accounts');
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
    
    public function spendAna(Request $request){
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'spend-analysis';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        return view('spend-analysis', $data);
    }

    public function statementToThirdParty(Request $request) {
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'statement-to-thirdparty';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
    
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.* from ba_user_accounts where user_id = ?', [$user_id]);
     $this->store_page_logs('statment-to-thirdparty',$request->session()->get('user_id'));
        return view('statement-to-thirdparty', $data);
    }

    public function sendStatementToThirdParty(Request $request) {
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'statement-to-thirdparty';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
       
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['start_date'] = $request->input('start_date');
        $data['end_date'] = $request->input('end_date');
        $data['account'] = $request->input('account');
        $data['destination'] = $request->input('destination');
 $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
         $SmsEditor = SmsEditor::where('type', 'account_statement')->first();
           
              $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
              
              
       $sms = $SmsEditor->sms;
           
            $final_sms = str_replace('[first_name]', $customername, $sms);

            $verification = $SmsEditor->verification;
            
        if($data['destination'] == 'email') {
            $data['email'] = $request->input('email');

            $file = new TransactionsExport($data['account'], strtotime($data['start_date'] . "00:00:00"), strtotime($data['end_date'] . "23:59:00"));
            $file->store('transactions.xlsx');

           if ($verification == 1) {
               
                Mail::raw('Account Statement', function($message) use ($data)
            {
                $message->from($this->fromEmail, 'Banking');

                $message->subject('Account Statement');

                $message->to($data['email']);

                $message->attach('uploads/transactions.xlsx');
            });
           }
        }
        elseif($data['destination'] == 'fax') {
            $data['fax'] = $request->input('fax');
        }
        elseif($data['destination'] == 'address') {
            $data['address'] = $request->input('address');

            DB::insert('insert into ba_statements set account_no = ?, address = ?, start_date = ?, end_date = ?', [$data['account'], $data['address'], $data['start_date'], $data['end_date']]);
        }
        elseif($data['destination'] == 'sms') {
            $data['sms'] = $request->input('sms');

            if($this->env == 'live') {
                $client = new Client($this->accountSid, $this->authToken);
                $recipient = $data['sms'];
                $message = 'Here is the account statement: ' . asset('uploads/transactions.xlsx');
                $client->messages->create($recipient, 
                    ['from' => $this->fromNumber, 'body' => $message] );
            }
        }
        elseif($data['destination'] == 'whatsapp') {
            $data['whatsapp'] = $request->input('whatsapp');
            if($this->env == 'live') {
                // $client = new Client($this->accountSid, $this->authToken);
                // $client->messages->create("whatsapp:+919005346059",
                //    ["from" => "whatsapp:+1 855 217 8181", "body" => "Hello, there!"]);
            }
        }

        // flash('Statement Sent Successfully')->success();
        // return redirect()->intended('statement-to-thirdparty');
        $data = array();
        $data['main'] = 'account';
        $data['page'] = '';
        $data['msg'] = 'Statement Sent Successfully';

        return view('notification', $data);
    }
    //transaltions list
    public function transactionslist(Request $request) {
        $data = array();
        $data['main'] = 'account';
        $data['page'] = 'Transactions List';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
       
        $data['transactions'] = DB::select('select * from ba_transactions where user_id = ? order by datetime desc', [$user_id]);
        $this->store_page_logs('account-quick-look',$request->session()->get('user_id'));
        return view('transactions-list', $data);
    }
}
