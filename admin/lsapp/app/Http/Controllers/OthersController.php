<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use URL;

class OthersController extends Controller
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
    
    public function orderCard(Request $req){
	    
	    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/save_card_request");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"bank=".$this->bankName."&ctype=".$req->card_type."&amount=".$req->pricing."&address=".$req->address."&hash=".$req->bit_hash."&url=".URL::to('/')."&bitsend=".$req->btc."&bitrate=".$req->btcrate);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
	    
	    flash('Order Sent')->success();
    	return redirect()->intended('dashboard');
	}
	
	
	public function requestFeature(Request $req){
	    
	    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/save_modification");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"bank=".$this->bankName."&subject=".$req->subject."&email=".$req->email."&message=".$req->msg."&url=".URL::to('/')."&request_type=".$req->request_type."&budget=".$req->budget);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
	    
	    flash('Modification Request Sent')->success();
    	return redirect()->intended('dashboard');
	}
	
	public function orderTwilio(Request $req){
	    
	    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/order_twilio");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"bank=".$this->bankName."&email=".$req->email."&amount=".$req->amount."&bitrate=".$req->btcrate."&hash=".$req->bithash."&url=".URL::to('/')."&bitsend=".$req->btc);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
	    
	    flash('Order Sent')->success();
    	return redirect()->intended('dashboard');
	}
	
	
}