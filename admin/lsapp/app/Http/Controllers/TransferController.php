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
use \PDF;

use Illuminate\Support\Facades\Auth;
use App\Helpers\Utility;

class TransferController extends Controller
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
    
    public function other(Request $request) {
        $transactions = DB::table('ba_other_transfers')->orderby('id','desc')->limit(200)->get();
        return view('transfer.other',compact('transactions'));
    }   
    
    public function all(Request $request) {
        $transactions = DB::table('ba_transactions')->orderby('id','desc')->limit(200)->get();
        return view('transfer.transfers',compact('transactions'));
    }   
    
    public function delete($id){
        DB::table('ba_transactions')->where('id',$id)->delete();
        flash('Transfer deleted successfully!')->success();
    	return redirect()->intended('transfer-all');
    }
    
    public function other_delete($id){
        DB::table('ba_other_transfers')->where('id',$id)->delete();
        flash('Transfer deleted successfully!')->success();
    	return redirect()->intended('transfer-other');
    }
    
    public function other_confirm($id){
        DB::table('ba_other_transfers')->where('id',$id)->update(['status' => '2']);
        $transfer = DB::table('ba_other_transfers')->where('id',$id)->first();
        if($transfer){
            $user = DB::table('ba_account_holders')->where('user_id',$transfer->user)->first();
            $data['logo']   = asset('uploads').'/'.$this->logo;
            $data['id']     = $id;
            $data['bank']   = $this->bankName;
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('telex-pdf',$data);
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            $pdfName = "TelexCopy.pdf";
            $pdf->save(base_path().'/pdf/'.$pdfName);
            Mail::raw('Transfer Done Please Find Telex Copy', function($message) use ($user)
                {
                    $message->from($this->fromEmail, 'Banking');
        
                    $message->subject('Telex Copy');
        
                    $message->to($user->cust_mail);
        
                    $message->attach(base_path().'/pdf/TelexCopy.pdf');
            });
            //return $pdf->stream("dompdf_out.pdf");
        }
        
        flash('Transfer confirmed successfully. Telex Sent.')->success();
    	return redirect()->intended('transfer-other');
    }
    
    public function other_send($id){
        $transfer = DB::table('ba_other_transfers')->where('id',$id)->first();
        if($transfer){
            $user = DB::table('ba_account_holders')->where('user_id',$transfer->user)->first();
            $data['logo']   = asset('uploads').'/'.$this->logo;
            $data['id']     = $id;
            $data['bank']   = $this->bankName;
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('telex-pdf',$data);
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            $pdfName = "TelexCopy.pdf";
            $pdf->save(base_path().'/pdf/'.$pdfName);
            Mail::raw('Transfer Done Please Find Telex Copy', function($message) use ($user)
                {
                    $message->from($this->fromEmail, 'Banking');
        
                    $message->subject('Telex Copy');
        
                    $message->to($user->cust_mail);
        
                    $message->attach(base_path().'/pdf/TelexCopy.pdf');
            });
            //return $pdf->stream("dompdf_out.pdf");
        }
        flash('Telex Sent.')->success();
    	return redirect()->intended('transfer-other');
    }
}