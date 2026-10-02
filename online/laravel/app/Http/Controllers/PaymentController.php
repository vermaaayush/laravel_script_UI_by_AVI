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


class PaymentController extends Controller
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
    
    public function paymentPayForm(Request $request){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://blockchain.info/tobtc?currency=USD&value=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dollerRate = curl_exec($ch);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_setting");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        
        $data['main'] = 'payments';
        $data['page'] = 'payment-pending';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['list']   = DB::table('ba_payments')->where('user',$request->session()->get('id'))->where('pd','0')->get();
        $data['dollerRate'] = $dollerRate;
        $data['coderanita'] = $coderanita;
        return view('payment-collection.pay',$data);
    }
    
    public function paymentPending(Request $request) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://blockchain.info/tobtc?currency=USD&value=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dollerRate = curl_exec($ch);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_setting");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        
        $data['main'] = 'payments';
        $data['page'] = 'payment-pending';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['list']   = DB::table('ba_payments')->where('user',$request->session()->get('id'))->where('paid','0')->orderby('id','desc')->get();
        $data['dollerRate'] = $dollerRate;
        $data['coderanita'] = $coderanita;
        return view('payment-collection.pending',$data);
    }
    
    public function paymentPart(Request $request) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://blockchain.info/tobtc?currency=USD&value=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dollerRate = curl_exec($ch);
        curl_close($ch);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_setting");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        
        $data['main'] = 'payments';
        $data['page'] = 'payment-part';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['list']   = DB::table('ba_payments')->where('paid','>','0')->where('user',$request->session()->get('id'))->orderby('id','asc')->get();
        $data['dollerRate'] = $dollerRate;
        $data['coderanita'] = $coderanita;
        return view('payment-collection.part',$data);
    }
    
    public function paymentFull(Request $request) {
        $data['main'] = 'payments';
        $data['page'] = 'payment-part';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['list']   = DB::table('ba_payments')->where('pd','1')->where('user',$request->session()->get('id'))->orderby('id','asc')->limit(200)->get();
        return view('payment-collection.full',$data);
    }
    
    public function paymentPay(Request $request) {
        $hash = "";
        if($request->remarks_bitcoin){
            $hash = $request->remarks_bitcoin;
        }
        $bank_account = "";
        if($request->bank_account){
            $bank_account = $request->bank_account;
        }
        $depo_referance = "";
        if($request->depo_referance){
            $depo_referance = $request->depo_referance;
        }
        
        $destinationPath = 'uploads';
        $fBitcoin = $request->file('fBitcoin');
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
        
        $data = [
            'user'      => $request->session()->get('id'),
            'payment'   => $request->payid,
            'method'    => $request->paymentMethod,
            'amount'    => $request->paymentAmount,
            'btc'       => $request->btcToSend,
            'comission'     => $request->comission,
            'rate'          => $request->btcrate,
            'hash'          => $hash,
            'file'          => $BUpload_name,
            'bank_account'  => $bank_account,
            'depo_referance'  => $depo_referance,
            'cat'           => date('Y-m-d H:i:s')
        ];
        $payId = DB::table('ba_payments_pay')->insertGetId($data);
        
        if($request->paymentMethod == 'bitcoin'){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/invoice_payment");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,"bank=".$this->bankName."&inv_id=".$request->payid."&pay_id=".$payId."&amount=".$request->paymentAmount."&conmission=".$request->comission."&bitrate=".$request->btcrate."&file=".$BUpload_name."&url=".URL::to('/'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
        
        UserActivity::saveUserActivity($request->session()->get('id'),'Invoice Payment');
        flash('Invoice Payment request has been successfully sent for processing.')->success();
        return redirect()->intended('pay-invoice');
        // if($request->type == "new"){
        //     return redirect()->intended('payment-pending');
        // }else if($request->type == "part"){
        //     return redirect()->intended('payment-part');
        // }
    }
        
    public function changePaymentInvoice($id,$amount){
        DB::table('ba_payments_pay')->where('id',$id)->update(['amount' => $amount]);
    }    
    
    public function approvePaymentInvoice($id){
        DB::table('ba_payments_pay')->where('id',$id)->update(['status' => "1"]);
        $payment = DB::table('ba_payments_pay')->where('id',$id)->first();
        $invoice = DB::table('ba_payments')->where('id',$payment->payment)->first();
        $customer = DB::table('ba_account_holders')->where('id',$payment->user)->first();
        DB::table('ba_payments')->where('id',$payment->payment)->update(['paid' => $invoice->paid + $payment->amount]);
        if($invoice->price <= $invoice->paid + $payment->amount ){
            DB::table('ba_payments')->where('id',$payment->payment)->update(['pd' => '1']);
        }
        $msg = "Hello ".$customer->cust_name." ".$customer->middle_name." ".$customer->sur_name." your payment request for ".$invoice->currency." ".$payment->amount." has been approved.";
        Mail::raw($msg, function($message) use ($customer)
        {
            $message->from($this->fromEmail);

            $message->subject('Invoice Payment Approved');

            $message->to($customer->cust_mail);
        });
    }
    
    public function rejectPaymentInvoice($id){
        DB::table('ba_payments_pay')->where('id',$id)->update(['status' => "2"]);
        $payment = DB::table('ba_payments_pay')->where('id',$id)->first();
        $invoice = DB::table('ba_payments')->where('id',$payment->payment)->first();
        $customer = DB::table('ba_account_holders')->where('id',$payment->user)->first();
        $msg = "Hello ".$customer->cust_name." ".$customer->middle_name." ".$customer->sur_name." your payment request for ".$invoice->currency." ".$payment->amount." has been rejected.";
        Mail::raw($msg, function($message) use ($customer)
        {
            $message->from($this->fromEmail);

            $message->subject('Invoice Payment Rejected');

            $message->to($customer->cust_mail);
        });
    }
}