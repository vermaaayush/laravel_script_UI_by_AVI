<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\UserActivity;

class Cheque extends Controller {

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
    public function requestChequeBook(Request $request) {
        $data = array();
        $data['main'] = 'cheque';
        $data['page'] = 'request-cheque-book';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $data['accounts'] = DB::select('select ba_user_accounts.*, bank_details.branch_name from ba_user_accounts inner join bank_details on ba_user_accounts.bank=bank_details.id where user_id = ?', [$user_id]);
         $this->store_page_logs('request-cheque-book',$request->session()->get('user_id'));
        return view('request-cheque-book', $data);
    }

    public function insertChequeBookRequest(Request $request) {
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

        DB::insert("insert into ba_check_book set $query");
        UserActivity::saveUserActivity($request->session()->get('id'),'Cheque Book Request');
        flash('Cheque Book Requested Successfully')->success();
        return redirect()->intended('request-cheque-book');
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
        UserActivity::saveUserActivity($request->session()->get('id'),'Cheque Book Stop Request');
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
}
