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
use App\PayKassaSCI;
use URL;
use App\UserActivity;


class DepositController extends Controller
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
    
    public function user_deposit(Request $request) {
        $data = array();
        $data['main'] = 'user-deposit';
        $data['page'] = 'user-deposit';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $user_id = $request->session()->get('user_id');
        $users = Ba_User_Accounts::where('user_id',$user_id)->where('access',1)->get();
        $methods = DB::table('ba_deposit_methods')->where('status','1')->get();
        $deposits = DB::table('ba_user_deposit')->where('user',$user_id)->orderby('id','desc')->limit(50)->get();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_setting");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://blockchain.info/tobtc?currency=USD&value=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dollerRate = curl_exec($ch);
        curl_close($ch);
        
        return view('user_deposit_list',$data,compact('users','methods','deposits','coderanita','dollerRate'));
    }
    
    public function user_deposit_save(Request $request) {
        $destinationPath = 'uploads';
        $fUpload = $request->file('fUpload');
        $fBitcoin = $request->file('fBitcoin');
        if(!empty($fUpload) && !empty($path = $fUpload->getRealPath()) && !empty($fUpload_name = $fUpload->getClientOriginalName())) {
            $ext = $fUpload->getClientOriginalExtension();
		    $type = $fUpload->getMimeType();
		    $fUpload_name = md5(time()).$fUpload_name;
            $fUpload->move($destinationPath,$fUpload_name);
        }else{
            $fUpload_name = "";
        }
        if($fUpload_name != ""){
            $fUpload_name = asset('uploads').'/'.$fUpload_name;
        }
        
        if(!empty($fBitcoin) && !empty($path = $fBitcoin->getRealPath()) && !empty($BUpload_name = $fBitcoin->getClientOriginalName())) {
            $ext = $fBitcoin->getClientOriginalExtension();
		    $type = $fBitcoin->getMimeType();
		    $BUpload_name = md5(time()).$BUpload_name;
            $fBitcoin->move($destinationPath,$BUpload_name);
        }else{
            $BUpload_name = "";
        }
        if($BUpload_name != ""){
            $BUpload_name = asset('uploads').'/'.$BUpload_name;
        }
        
        if($request->dep_method == "Cash Deposit"){
            $data = [
                'user'              => $request->session()->get('user_id'),
                'amount'            => $request->amount,
                'deptype'           => $request->dep_method,
                'account'           => $request->account_no,
                'bank_account'      => $request->bank_account,
                'date_of_deposit'   => date('Y-m-d',strtotime($request->date_of_depo)),
                'depo_referance'    => $request->depo_referance,
                'bit_remarks'       => "",
                'file'              => $fUpload_name,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $depoId = DB::table('ba_user_deposit')->insertGetId($data);
        }
        
        if($request->dep_method == "Bitcoin"){
            $remarksBitCoin = "";
            if($request->remarks_bitcoin != ""){
                $remarksBitCoin = $request->remarks_bitcoin;
            }
            $data = [
                'user'              => $request->session()->get('user_id'),
                'amount'            => $request->priceBitcoin,
                'deptype'           => $request->dep_method,
                'account'           => $request->account_no,
                'bank_account'      => "",
                'date_of_deposit'   => date('Y-m-d',strtotime($request->date_of_depo)),
                'depo_referance'    => "",
                'bit_remarks'       => $remarksBitCoin,
                'file'              => $BUpload_name,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $depoId = DB::table('ba_user_deposit')->insertGetId($data);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/deposit");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,"bank=".$this->bankName."&deposit_id=".$depoId."&amount=".$request->priceBitcoin."&btc_val=".$request->BTCRate."&comission=".$request->commissionAmt."&deptype=".$request->dep_method."&file=".$BUpload_name."&depo_date=".date('Y-m-d',strtotime($request->date_of_depo))."&remarks=".$remarksBitCoin."&url=".URL::to('/'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
        
        $msg = "New Deposit Request Please Check.";
        Mail::raw($msg, function($message)
        {
            $message->from($this->fromEmail);

            $message->subject('Deposit Request');

            $message->to($this->fromEmail);
        });
        UserActivity::saveUserActivity($request->session()->get('id'),'Deposit');
        flash('Deposit Funding request has been successfully sent for processing.')->success();
        return redirect()->intended('user-deposit');
    }
    
    public function approveDeposit($id){
        DB::table('ba_user_deposit')->where('id',$id)->update(['approved' => "1"]);
        $deposit = DB::table('ba_user_deposit')->where('id',$id)->first();
        $customer = DB::table('ba_account_holders')->where('user_id',$deposit->user)->first();
        $account = DB::table('ba_user_accounts')->where('id',$deposit->account)->first();
        
        $msg = "Hello ".$customer->cust_name." ".$customer->middle_name." ".$customer->sur_name." your deposit request for ".$account->account_currency." ".$deposit->amount." made on ".date('d F, Y',strtotime($deposit->created_at))." has been approved.";
        Mail::raw($msg, function($message) use ($customer)
        {
            $message->from($this->fromEmail);

            $message->subject('Deposit Request Approved');

            $message->to($customer->cust_mail);
        });
        DB::table('ba_user_accounts')->where('id',$account->id)->update(['available_balance' => $account->available_balance + $deposit->amount]);
        $ins = [
            'user_id'       => $customer->user_id,
            'act_number'    => $account->account_no,
            'type'          => 'credited',
            'balance'       => $account->available_balance + $deposit->amount,
            'status'        => "1",
            'amount'        => $deposit->amount,
            'tran_id'       => md5(time()),
            'reason'        => "Deposit",
            'balance_type'  => 'available_balance',
            'datetime'      => date("Y-m-d H:i:s")
        ];
        DB::table('ba_transactions')->insert($ins);
    }
    
    public function rejectDeposit($id){
        DB::table('ba_user_deposit')->where('id',$id)->update(['approved' => "2"]);
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
    }
    
    public function updateDeposit($id,$amount){
        DB::table('ba_user_deposit')->where('id',$id)->update(['amount' => $amount]);
    }
    
    public function payPayKassa(Request $request){
        $paykassa_merchant_password = 'Z4BHeobXsbBt645';
        $paykassa_merchant_id = '7777';
    
        $amount = '0.0001';
        $system = 'bitcoin';
        $currency = 'BTC';
        $order_id = 'shop_377';
        $comment = 'comment';
    
        
        $paykassa = new PayKassaSCI(
            $paykassa_merchant_id,       // the ID of the merchant
            $paykassa_merchant_password  // merchant password
        );
        $system_id = [
            "perfectmoney" => 2, // supported currencies USD    
            "berty" => 7, // supported currencies RUB, USD    
            "bitcoin" => 11, // supported currencies BTC    
            "ethereum" => 12, // supported currencies ETH    
            "litecoin" => 14, // supported currencies LTC    
            "dogecoin" => 15, // supported currencies DOGE    
            "dash" => 16, // supported currencies DASH    
            "bitcoincash" => 18, // supported currencies BCH    
            "zcash" => 19, // supported currencies ZEC    
            "ripple" => 22, // supported currencies XRP    
            "tron" => 27, // supported currencies TRX    
            "stellar" => 28, // supported currencies XLM    
        ];
    
        $res = $paykassa->sci_create_order(
            $amount,    // required parameter the payment amount example: 1.0433
            $currency,  // mandatory parameter, currency, example: BTC
            $order_id,  // mandatory parameter, the unique numeric identifier of the payment in your system, example: 150800
            $comment,   // mandatory parameter, text commentary of payment example: service Order #150800
            $system_id[$system] // mandatory parameter, specifying it You bypassing the merchant forwards the payment system, for example: 12 - Ethereum
        );
        
        ?>
        <form action="<?php echo $res["data"]["url"]; ?>" method="POST">
            <button>To pay</button>
        </form>
        <?php
    }
}