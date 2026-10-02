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
use App\EmailEditor;
use URL;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Utility;

class PaymentController extends Controller
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
    
    public function paymentNew(){
        $customers = DB::select('select id, cust_name, middle_name, sur_name from ba_account_holders where df = "no" order by cust_name, middle_name, sur_name');
        return view('payments.new',['customers' => $customers]);
    }
    
    public function invPaymentMethods(){
        $payment_methods = DB::table('ba_payment_methods')->get();
        return view('payments.methods',['payment_methods' => $payment_methods]);
    }
    
    public function invPaymentMethodsSave(Request $request){
        DB::table('ba_payment_methods')->where('id',$request->id)->update(['description' => $request->instr]);
        flash('Payment Method Instruction updated successfully!')->success();
    	return redirect()->intended('inv-payment-methods');
    }
    
    public function invoices(){
        $invs = DB::table('ba_payments')->orderby('pd','asc')->get();
        return view('payments.pending',['list' => $invs]);
    }
    
    public function pendingPayments(){
        $invs = DB::table('ba_payments_pay')->where('status','0')->where('method','bank')->get();
        return view('payments.paypending',['list' => $invs]);
    }
    
    public function pendingPaymentsStatus($id,$status){
        if($status == "1"){
            $pay = DB::table('ba_payments_pay')->where('id',$id)->first(); 
            $inv = DB::table('ba_payments')->where('id',$pay->payment)->first();    
            $customer = DB::table('ba_account_holders')->where('id',$pay->user)->first();
            DB::table('ba_payments')->where('id',$pay->payment)->update(['paid' => $inv->paid + $pay->amount]);    
            if($inv->price < $inv->paid + $pay->amount){
                DB::table('ba_payments')->where('id',$pay->payment)->update(['pd' => '1']);        
            }
            
            $msg = "Hello ".$customer->cust_name." ".$customer->middle_name." ".$customer->sur_name." your payment request for ".$inv->currency." ".$pay->amount." has been approved.";
            Mail::raw($msg, function($message) use ($customer)
            {
                $message->from($this->fromEmail);
    
                $message->subject('Invoice Payment Approved');
    
                $message->to($customer->cust_mail);
            });
        }else{
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
        DB::table('ba_payments_pay')->where('id',$id)->update(['status' => $status]);
        flash('Status Has been changed')->success();
        return redirect()->intended('pending-payments');
    }
    
    public function paymentSave(Request $rec){
        $data = [
            'user'      => $rec->customer,
            'dt'        => date('Y-m-d',strtotime($rec->date)),
            'name'      => $rec->inv,
            'price'     => $rec->amount,
            'currency'  => $rec->currency,
            'paid'      => '0.00',
            'descr'     => $rec->descr,
            'pay_option'    => $rec->payment_option,
            'cat'       => date('Y-m-d H:i:s')
        ];
        $invoice = DB::table('ba_payments')->insertGetId($data);
        $this->dynamic_email_without_token($invoice);
        flash('Invoice Added')->success();
    	return redirect()->intended('payment-new');
    }
    
    public function dynamic_email_without_token($invoice) {
        $config = DB::select('select * from configs WHERE id = ?',[1]);
        
        $invoice = DB::table('ba_payments')->where('id',$invoice)->first();
        $customer = DB::table('ba_account_holders')->where('id',$invoice->user)->first();
        
        $logo_link ="https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
        $finals_message = '<span class="imeg">' .'<img src='.$logo_link.' alt="banking" style="display:block;margin-left:780px;width:14%;" />' .'</span>';
        
        $finals_message .= '<p style="position: relative;top: 136px;">Dear ' . $customer->cust_name . '<br><br>Please be informed that a payment and collection invoice has been created at '.date('l d-F-y',strtotime($invoice->cat)).'.<br>Do login to your internet banking profile to review and effect payment, If you are having any issues contact your account officer immediately.<br><br><b>Invoice Title:</b> '.$invoice->name.'<br><b>Invoiced Amount:</b> '.$invoice->currency.' '.$invoice->price.'<br><b>Customer ID:</b> '.$customer->user_id.'<br><b>Issued Date:</b> '.date('d/m/Y',strtotime($invoice->dt)).' </p><br>';  
        
        $finals_message .= '<p>
        Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
        If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
        
        $body = "<html><head></head><body>";
        $body .= $finals_message ; 
        $body .= "</body></html>";
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        
        $headers[] = 'From: ' . $this->bankName . ' <'.$this->fromEmail.'>';
        
      Mail::send([], [], function ($message) use ($customer, $body) {
    $message->to($customer->cust_mail)
            ->subject("New Invoice")
            ->setBody($body, 'text/html');
});

    }
}