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
use Session ;
use App\Ba_User_Accounts;
use App\User_Withdrawl;
use App\UserActivity;


class WithdrawlController extends Controller
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

   
   public function user_withdrl(Request $request) {
        $data = array();
        $data['main'] = 'user-whitdrawal';
        $data['page'] = 'user_withdrawl';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $user_id = $request->session()->get('user_id');
        $amount = BaAccountHolders::where('user_id',$user_id)->first();
        $users = Ba_User_Accounts::where('user_id',$user_id)->where('access',1)->get();
        $withMethod = DB::table('ba_withdraw_methods')->where('status','1')->get();
        $withdraws = DB::table('ba_user_withdrawal2')->where('user',$user_id)->orderby('id','desc')->limit(50)->get();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_withdraw_methods");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        return view('client.user_withdrawl',$data,compact('users','amount','withMethod','withdraws','coderanita'));
    }
     
    public function store_withdrawl(Request $request) {
        $user_id = $request->session()->get('user_id');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_setting");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        
        $data = [
            'user'          => $user_id,
            'amount'        => $request->amount,
            'withtype'      => $request->pay_method,
            'account'       => $request->account_no,
            'date_of_with'  => date('Y-m-d'),
            'comission'     => json_decode($coderanita)->wcomission,
            'withid'        => $request->wallet_id
        ];
        DB::table('ba_user_withdrawal2')->insert($data);
        
        $msg = "New Withdraw Request Please Check.";
        Mail::raw($msg, function($message)
        {
            $message->from($this->fromEmail);

            $message->subject('Withdraw Request');

            $message->to($this->fromEmail);
        });
        UserActivity::saveUserActivity($request->session()->get('id'),'Withdrawal');
        flash('Withdraw request has been successfully sent for processing.')->success();
        return redirect()->intended('user-whitdrawal');
    }
    
    
     public function view_withdrawls(Request $request) {

      $data = array();
        $data['main'] = 'view-all-withdrawls';
        $data['page'] = 'view-all-withdrawls';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
   
        $user_id = $request->session()->get('user_id');

         $users = User_Withdrawl::where('user_id',$user_id)->latest()->get();
         $withdraws = DB::table('ba_user_withdrawal2')->where('user',$user_id)->orderby('id','desc')->limit(50)->get();
        
        return view('client.user-all-withdrawls',$data,compact('users','withdraws'));
       
        
    }
    


}