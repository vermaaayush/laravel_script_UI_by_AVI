<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Config;
use App\Ivr_message;
use App\Ivr_Support_number;
use App\Http\Controllers\PayKassaAPI;

class Withdraw extends Controller
{
	public function __construct() {
	    $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
        $this->module = 'customer';
        $config = DB::select('select bank_email, sms_token, sms_sid, sms_phone from configs where 1');
         $this->fromEmail = $config[0]->bank_email;
         

        $this->fromNumber = $config[0]->sms_phone;

        $this->accountSid = $config[0]->sms_sid;

        $this->authToken = $config[0]->sms_token;

        $this->env = 'live';
        if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
            $this->env = 'local';
        }
	}

	public function bitcoinProcess(){
	    
	    
	$paykassa_api_id = '7603';
    $paykassa_api_password = 'ptfxeh3XTAq2flS';
    $paykassa_merchant_id = '7777';

    $amount = 0.25;
    $system = "bitcoin";
    $currency = 'BTC';
    $wallet = '3D2oetdNuZUqQHPJmcMDDHYoqkyNVsFk9r';
    $comment = 'comment';
    $paid_commission = '';
    $tag = '';
    $real_fee = true; // supported - BTC, LTC, DOGE, DASH, BSV, BCH, ZEC, ETH
    $priority = "high"; // low - slowly, medium - medium, high - quickly

    $paykassa = new PayKassaAPI(
        $paykassa_api_id,       // ID api
        $paykassa_api_password 	// password api
    );


    $system_id = [
        "advcash" => 4, // supported currencies RUB, USD    
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

    $res = $paykassa->api_payment(
        $paykassa_merchant_id,  // required parameter merchant id from which you want to make a withdrawal
        $system_id[$system],    // mandatory parameter, the id of the payment method
        $wallet,                // mandatory parameter, the number of wallet which sent the money
        (float)$amount,         // required parameter the payment amount, how much to send
        $currency,              // mandatory parameter, the currency of payment
        $comment,               // mandatory parameter, review the payment, you can pass a null
        $paid_commission,       // an optional parameter that who pays the fee for transfer, shop or client
        $tag,                   // optional, the tag for payment, you can pass empty
        $real_fee,              // deprecated parameter, always set to true
        $priority               // optional parameter(default is medium), is used to set
                                // priority inclusion in the unit along with a $real_fee === true
    );

    if ($res['error']) {        // $res['error'] - true if the error
        echo $res['message'];   // $res['message'] - the text of the error message
        //actions in case of an error
    } else {
        //actions in case of success
        $shop_id = $res['data']['shop_id'];                         // merchant id that you originally made payment, example 122
        $transaction = $res['data']['transaction'];                 // transaction number of the payment, example 130236
        $txid = $res['data']['txid'];                               // txid 70d6dc6841782c6efd8deac4b44d9cc3338fda7af38043dd47d7cbad7e84d5dd
        $amount = $res['data']['amount'];                           // the amount of the payment, how much was written off from the balance of the merchant 0.42
        $amount_pay = $res['data']['amount_pay'];                   // the amount of the payment, as it is the user, example: 0.41
        $system = $res['data']['system'];                           // the system of payment, which was made the payment, example: Bitcoin
        $currency = $res['data']['currency'];                       // the payment currency, for example: BTC
        $number = $res['data']['number'];                           // the address where you sent the funds
        $comission_percent = $res['data']['shop_comission_percent'];// the transfer fee percentage, example: 1.5
        $comission_amount = $res['data']['shop_comission_amount'];  // the transfer fee amount, example: 1.00
        $paid_commission = $res['data']['paid_commission'];         // who paid for the Commission, for example: shop
    }
	    
	   
	    
	    
	    
	    
	}
   
}
