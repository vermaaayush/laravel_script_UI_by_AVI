<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Ivr_Msg;
use App\BaTransactions;
use App\BaAccountHolders;
use App\User_Withdrawl;
use App\BaUserAccounts;
use App\Http\Controllers\PayKassaAPI;
use App\SmsEditor;


use Illuminate\Support\Facades\Auth;
use App\Helpers\Utility;

class DepositController extends Controller
{
    
     public function __construct() {
        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
        $config = DB::select('select bank_name,logo, bank_email, sms_token, sms_sid, sms_phone from configs where 1');
        
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
    
    public function deposit_methods(Request $request) {
        $deposit_methods = DB::table('ba_deposit_methods')->get();
        return view('deposit.deposit_methods',compact('deposit_methods'));
    }
    
    public function deposit_new(Request $request) {
        $deposit_new = DB::table('ba_user_deposit')->where('approved','0')->get();
        return view('deposit.deposit_new',compact('deposit_new'));
    }
    
    public function deposit_approved(Request $request) {
        $deposit_approved = DB::table('ba_user_deposit')->where('approved','1')->orderby('id','desc')->limit(200)->get();
        return view('deposit.deposit_approved',compact('deposit_approved'));
    }
    
    public function deposit_rejected(Request $request) {
        $deposit_rejected = DB::table('ba_user_deposit')->where('approved','2')->orderby('id','desc')->limit(200)->get();
        return view('deposit.deposit_rejected',compact('deposit_rejected'));
    }
    
    public function deposit_reject($id){
        DB::table('ba_user_deposit')->where('id',$id)->update(['approved' => '2']);
        
        $deposit = DB::table('ba_user_deposit')->where('id',$id)->first();
        $customer = DB::table('ba_account_holders')->where('user_id',$deposit->user)->first();
        $account = DB::table('ba_user_accounts')->where('id',$deposit->account)->first();
        $msg = "Hello ".$customer->cust_name." ".$customer->middle_name." ".$customer->sur_name." your deposit request for ".$account->account_currency." ".$deposit->amount." made on ".date('d F, Y',strtotime($deposit->created_at))." has been rejected.";
        Mail::raw($msg, function($message) use ($customer)
        {
            $message->from($this->fromEmail);

            $message->subject('Deposit Request Rejected');

            $message->to($customer->cust_mail);
        });
        
        flash('Deposit Rejected')->success();
    	return redirect()->intended('deposit-new');
    }  
    
    public function deposit_approve($id){
        DB::table('ba_user_deposit')->where('id',$id)->update(['approved' => '1']);
        
        
        $deposit = DB::table('ba_user_deposit')->where('id',$id)->first();
        $customer = DB::table('ba_account_holders')->where('user_id',$deposit->user)->first();
        $account = DB::table('ba_user_accounts')->where('id',$deposit->account)->first();
        DB::table('ba_user_accounts')->where('id',$account->id)->update(['available_balance' => $account->available_balance + $deposit->amount]);
        $ins = [
            'user_id'       => $customer->user_id,
            'act_number'    => $account->account_no,
            'type'          => 'credited',
            'balance'       => $account->available_balance,
            'status'        => "1",
            'amount'        => $deposit->amount,
            'tran_id'       => md5(time()),
            'reason'        => "Deposit",
            'balance_type'  => 'available_balance',
            'datetime'      => date("Y-m-d H:i:s")
        ];
        DB::table('ba_transactions')->insert($ins);
        
        
        $msg = "Hello ".$customer->cust_name." ".$customer->middle_name." ".$customer->sur_name." your deposit request for ".$account->account_currency." ".$deposit->amount." made on ".date('d F, Y',strtotime($deposit->created_at))." has been approved.";
        Mail::raw($msg, function($message) use ($customer)
        {
            $message->from($this->fromEmail);

            $message->subject('Deposit Request Approved');

            $message->to($customer->cust_mail);
        });
        
        flash('Deposit Approved')->success();
    	return redirect()->intended('deposit-new');
    }  
    
    public function deposit_methods_save(Request $request){
        $data = [
            'name' => $request->all()['type']
        ];
        DB::table('ba_deposit_methods')->insert($data);
        flash('Deposit Method added successfully!')->success();
    	return redirect()->intended('deposit-methods');
    }
    
    public function deposit_method_delete($id){
        DB::table('ba_deposit_methods')->where('id',$id)->delete();
        flash('Deposit Method delete successfully!')->success();
    	return redirect()->intended('deposit-methods');
    }
    
    public function deposit_method_status($id,$status){
        DB::table('ba_deposit_methods')->where('id',$id)->update(['status' => $status]);
        flash('Deposit Method status has been Changed')->success();
    	return redirect()->intended('deposit-methods');
    }
    
    public function deposit_methods_instruction(Request $request){
        DB::table('ba_deposit_methods')->where('id',$request->id)->update(['description' => $request->instr]);
        flash('Deposit Method Instruction updated successfully!')->success();
    	return redirect()->intended('deposit-methods');
    }
}