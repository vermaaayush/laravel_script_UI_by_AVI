<?php

namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use Mail;
use App\Config;
use App\Ivr_message;
use App\ivr_purchase_numbers;
use App\Ivr_Support_number;
use App\CallLog;
use App\BaAccountHolders;
use App\BaUserAccounts;
use App\Ivr_Support_number;
use App\Ivr_Msg;
use App\BaTransactions;
use App\Http\Controllers\IvrLanguageController;


class IvrController extends Controller
{
		
	public function index(Request $request){
		
		$response = new VoiceResponse();	
		$input = $request->all();
			
		$dataArray['callerid']     = $input['CallSid'];
		$dataArray['accountid']    = $input['AccountSid'];
		$dataArray['callfrom']     = $input['From'];
		$dataArray['callto']       = $input['To'];
		$dataArray['callstatus']   = $input['CallStatus'];
		$dataArray['apiversion']   = $input['ApiVersion'];
		$dataArray['direction']    = $input['Direction'];
		$dataArray['fromcity']     = $input['FromCity'];
		$dataArray['fromstate']    = $input['FromState'];
		$dataArray['fromzip']      = $input['FromZip'];
		$dataArray['fromcountry']  = $input['FromCountry'];
		$dataArray['tocity']       = $input['ToCity'];
		$dataArray['tostate']      = $input['ToState'];
		$dataArray['tozip']        = $input['ToZip'];
		$dataArray['tocountry']    = $input['ToCountry'];
		
		CallLog::create($dataArray);
		
		$Settings       = Config::get();
	    $language       = $Settings[0]['ivr_lang'];
		$languages      = explode(',',$language);
		
		
		$response->say('Welcome to '.$Settings[0]['bank_name'], ['voice' => 'alice','language' => 'en-AU']);
		for ($i=1; $i<=3; $i++) {
			
			$gather = $response->gather(['action' => '/handle-language-input', 'method' => 'GET']);
			
			foreach($languages as $lang){
				
				if($lang=='ENGLISH'){
								
					$gather->say('If you want to talk in English,  Press 1', ['voice' => 'alice','language' => 'en-AU']);					
					
				}
				if($lang=='ARABIC'){
					
					$gather->say('iidha kunt turid altahaduth biallughat alearabiat , aidghata 2', ['voice' => 'alice','language' => 'ar']);
					
				}
				if($lang=='SPANISH'){
					
					$gather->say('Si desea hablar en español, presione 3', ['voice' => 'alice','language' => 'es']);
					
				}
				if($lang=='PORTUGUESE'){
					
					$gather->say('Se você quiser falar em PORTUGUÊS, pressione 4', ['voice' => 'alice','language' => 'pt']);
					
				}
				if($lang=='JAPANESE'){
					
					$gather->say('Nihongo de hanashitai baai wa, 5 o oshite kudasai', ['voice' => 'alice','language' => 'ja-JP']);
					
				}
				if($lang=='GERMAN'){
					
					$gather->say('Wenn Sie auf DEUTSCH sprechen möchten, drücken Sie  6', ['voice' => 'alice','language' => 'de-DE']);
					
				}
				if($lang=='FRENCH'){
					
					$gather->say('Si vous voulez parler en FRANÇAIS, appuyez sur 7', ['voice' => 'alice','language' => 'fr-FR']);
					
				}						
			}
		}
		
		$response->say("Sorry, I didn't get your response");
		
		echo $response;
		
	}
	
	public function handle_language_input(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	

		$selectedOption    = $input['Digits'];
		if($selectedOption == 1){ $language = 'en-AU'; }
		else if($selectedOption == 2){ $language = 'ar'; }
		else if($selectedOption == 3){ $language = 'es'; }
		else if($selectedOption == 4){ $language = 'pt'; }
		else if($selectedOption == 5){ $language = 'ja-JP'; }
		else if($selectedOption == 6){ $language = 'de-DE'; }
		else if($selectedOption == 7){ $language = 'fr-FR'; }
		else{ $language = 'en-AU'; }
		Session::put('language', $language);
				
		for ($i=1; $i<=3; $i++) {
			
			$gather = $response->gather(['action' => '/handle-input', 'method' => 'GET','finishOnKey'=>'#']);
			$gather->say($LanguageController->index($language,'handle1'), ['voice' => 'alice','language' => $language]);
			$gather->say($LanguageController->index($language,'handle2'), ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
		}
		$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
		$response->hangup();
		
		echo $response;
	
	}
	
	public function handle_input(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$Settings            = Config::get();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];
		$language           = Session::get('language');

		if($selectedOption == 1){
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => '/customerID-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'handle3'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
		}elseif($selectedOption == 2){

				$response->say($LanguageController->index($language,'handle4'), ['voice' => 'alice','language' => $language]);			
				$gather = $response->gather(['action' => '/handle-input-mapped', 'method' => 'GET','finishOnKey'=>'#','numDigits'=>4]);
				$gather->say($LanguageController->index($language,'handle5').$Settings[0]['bank_name'], ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'handle6'), ['voice' => 'alice','language' => $language]);
				
				if($Settings[0]['admin_support_phone']!=''){
												
					$response->say($LanguageController->index($language,'handle7'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'handle8'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);
					$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');	
					$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');		
					$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);		
					$response->dial($Settings[0]['admin_support_phone']);
				}else{
					$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				}
				$response->hangup();
			
		}else{
					
				$this->handle_not_get_response($response);	
		}
		
		echo $response;
		exit;
	
	}
	   	
		
	public function customerID_login(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];
		$AccountHolder      = BaAccountHolders::where('customer_id',$selectedOption)->get();
		
		if(count($AccountHolder)>0){
			Session::put('customerID', $selectedOption);		
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => '/userID-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'customer_id_login1'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'customer_id_login2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
		}else{		
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => '/customerID-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'customer_id_login3'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'customer_id_login4'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);			
		}
		echo $response;
		exit;
	}
	
	
   	public function handle_input_mapped($language,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];
		$SupportNumbers     = Ivr_Support_number::where('ext_number',$selectedOption)->get();
		
		if(count($SupportNumbers)>0){
	
			$response->say($LanguageController->index($language,'handle8'), ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);
			$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');	
			$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');	
			$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);			
			$response->dial('+'.$SupportNumbers[0]['support_number']);
			$response->hangup();				
		}else{
			
			$response->say($LanguageController->index($language,'handle_map'), ['voice' => 'alice','language' => $language]);
			for ($i=1; $i<=2; $i++) {
				
				$gather = $response->gather(['action' => '/handle-input-mapped-1', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'handle_map2'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);	
			$response->hangup();	
		}
		echo $response;
		exit;
		
	}
	
	public function handle_input_mapped_1($language,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];
		$SupportNumbers     = Ivr_Support_number::where('ext_number',$selectedOption)->get();
		$Settings           = Config::get();
		
		if(count($SupportNumbers)>0){
	
			$response->say($LanguageController->index($language,'handle8'), ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);
			$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');	
			$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');	
			$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);			
			$response->dial('+'.$SupportNumbers[0]['support_number']);
			$response->hangup();				
		}else{
			
			if($Settings[0]['admin_support_phone']!=''){
												
				$response->say($LanguageController->index($language,'handle7'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'handle8'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);
				$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');	
				$response->play('https://dubaiallier.ae/tele/ivr/includes/pp.wav');	
				$response->say($LanguageController->index($language,'handle9'), ['voice' => 'alice','language' => $language]);			
				$response->dial($Settings[0]['admin_support_phone']);
			}else{
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			}
			$response->hangup();
		}
		echo $response;
		exit;
		
	}
	
	public function userID_login(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];
		$customerID         = Session::get('customerID');
		$AccountHolder      = BaAccountHolders::where('customer_id',$customerID)->where('user_id',$selectedOption)->get();
		
		if(count($AccountHolder)>0){
			Session::put('userID', $selectedOption);			
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => '/pin-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'user_id_login1'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'user_id_login2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
		}else{		
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => '/userID-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'user_id_login4'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'user_id_login5'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);	
			$response->hangup();		
		}
		echo $response;
		exit;
	}
	
	public function pin_login(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];
		$customerID         = Session::get('customerID');
		$userID         	= Session::get('userID');
		$AccountHolder      = BaAccountHolders::where('customer_id',$customerID)->where('user_id',$userID)->where('cust_password',$selectedOption)->get();
		
		if(count($AccountHolder)>0){
			Session::put('pin', $selectedOption);Session::put('user_id', $AccountHolder[0]['id']);	
			
			if($AccountHolder[0]['account_status']==2){
				
				$response->say($LanguageController->index($language,'pin_login1'), ['voice' => 'alice','language' => $language]);	
				$response->hangup();
		
			}else{
				$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
				
				$response->say($LanguageController->index($language,'pin_login2').$name, ['voice' => 'alice','language' => $language]);	
				$ivrMessages = Ivr_Msg::where('user_id',Session::get('user_id'))->where('status',0)->get();
				$messageCount = $ivrMessages->count();	
				for ($i=1; $i<=3; $i++) {		
					$gather = $response->gather(['action' => '/welcome-user', 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'pin_login12').$messageCount.$LanguageController->index($language,'pin_login13'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login3'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login4'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login5'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login6'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login7'), ['voice' => 'alice','language' => $language]);
					if($messageCount>0){
						$gather->say($LanguageController->index($language,'pin_login8'), ['voice' => 'alice','language' => $language]);
					}				
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
			}
		}else{		
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => '/pin-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'pin_login11'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'pin_login10'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);	
			$response->hangup();		
		}
		echo $response;
		exit;
	}
	
	public function welcome_user(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];
		
		if($selectedOption == 1){
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/account-balance-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user3'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'Welcome_user2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
				
		}elseif($selectedOption == 2){
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/transfer-type', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user4'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'Welcome_user5'), ['voice' => 'alice','language' => $language]);	
				$gather->say($LanguageController->index($language,'Welcome_user6'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
		}
		elseif($selectedOption == 3){
			
			$ivrMessages = Ivr_Msg::where('user_id',Session::get('user_id'))->where('status',0)->get();
			for ($i=1; $i<=3; $i++) {
				$messgei = 1;
				$gather = $response->gather(['action' => '/welcome-user3', 'method' => 'GET','finishOnKey'=>'#']);
				foreach($ivrMessages as $message){
					$gather->say($LanguageController->index($language,'Welcome_user14').$messgei.' '.$message['message'], ['voice' => 'alice','language' => $language]);
					$messgei++;
				}
						
				$gather->say($LanguageController->index($language,'Welcome_user10'), ['voice' => 'alice','language' => $language]);	
				$gather->say($LanguageController->index($language,'Welcome_user11'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
			}	
		}
		elseif($selectedOption == 4){
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/t_details', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user3'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'Welcome_user2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
		}
		elseif($selectedOption == 5){
			
			$AccountHolder  = BaAccountHolders::where('id',Session::get('user_id'))->get();
			if($AccountHolder[0]['account_status']==2){
				$response->say($LanguageController->index($language,'Welcome_user17'), ['voice' => 'alice','language' => $language]);				
			}elseif($AccountHolder[0]['account_status']==1){
				$response->say($LanguageController->index($language,'Welcome_user16'), ['voice' => 'alice','language' => $language]);
			}else($AccountHolder[0]['account_status']==0){
				$response->say($LanguageController->index($language,'Welcome_user15'), ['voice' => 'alice','language' => $language]);				
			}
			$response->hangup();		
		}
		elseif($selectedOption == 6){
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/credit-process', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user7'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'Welcome_user8'), ['voice' => 'alice','language' => $language]);	
				$gather->say($LanguageController->index($language,'Welcome_user9'), ['voice' => 'alice','language' => $language]);	
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();			
		}
		else{
			$response->say($LanguageController->index($language,'Welcome_user12'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/welcome-user-2');
			
		}
		echo $response;
		exit;
	}
	public function account_balance_login(Request $request){
	
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];	
		Session::put('account_no', $selectedOption);
		$AccountDetails     = BaUserAccounts::where('user_id',Session::get('user_id'))->where('account_no',$selectedOption)->get();	
		if($AccountDetails->count()){
			
			$AccountHolder  = BaAccountHolders::where('id',Session::get('user_id'))->get();
			$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
			$response->say($name, ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'accout_balance_login3').$AccountDetails[0]['account_type'], ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'accout_balance_login4').number_format($AccountDetails[0]['available_balance'],2,'.',',')." ".$AccountDetails[0]['account_currency'], ['voice' => 'alice','language' => $language]);
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/account-balance-repeat', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
					
		}else{
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/account-balance-login', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login6'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'accout_balance_login7'), ['voice' => 'alice','language' => $language]);	
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		

		echo $response;
		exit;	
	}
	public function account_balance_repeat(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];	
		if($selectedOption == '*'){
			$AccountDetails     = BaUserAccounts::where('user_id',Session::get('user_id'))->where('account_no',Session::get('account_no'))->get();	
			if($AccountDetails->count()){
				
				$AccountHolder  = BaAccountHolders::where('id',Session::get('user_id'))->get();
				$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
				$response->say($name, ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'accout_balance_login3').$AccountDetails[0]['account_type'], ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'accout_balance_login4').number_format($AccountDetails[0]['available_balance'],2,'.',',')." ".$AccountDetails[0]['account_currency'], ['voice' => 'alice','language' => $language]);
				for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => '/account-balance-repeat', 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
				
				
			}
		}elseif($selectedOption == 1){
			$response->redirect('/welcome-user-2');
		}else{
			$response->say($LanguageController->index($language,'accout_balance_login8'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/welcome-user-2');
		}
		
		echo $response;
		exit;	
	}
	public function transfer_type(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];			
	}
	public function welcome_user3(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];	
		
		if($selectedOption=="*"){
			$response->redirect('/welcome-user-2');
	
		}else{
			$ivrMessages        = Ivr_Msg::where('user_id',Session::get('user_id'))->update(['status'=>1]);		
			$response->redirect('/welcome-user-2');
		}
		echo $response;
		exit;
				
	}
	public function t_details(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];	
		Session::put('account_no_transaction', $selectedOption);
		$AccountDetails     = BaUserAccounts::where('user_id',Session::get('user_id'))->where('account_no',$selectedOption)->get();	
		if($AccountDetails->count()){

			$TransactionDetails = BaTransactions::where('user_id',Session::get('user_id'))->where('act_number',$selectedOption)->orderBy('id','DESC')->take(5)->get();	
			$response->say($LanguageController->index($language,'accout_balance_login1'), ['voice' => 'alice','language' => $language]);
			foreach($TransactionDetails as $transaction){
				
				$response->say(number_format($transaction['amount'],2,'.',',')." ".$AccountDetails[0]['account_currency'].' was '.$transaction['type'], ['voice' => 'alice','language' => $language]);
			}
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/t_details1', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();		
		}else{
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/t_details', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login6'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'accout_balance_login7'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		echo $response;
		exit;
				
	}
	
	public function t_details1(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];	
		
		if($selectedOption==1){		
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/t_details', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user3'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'Welcome_user2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		elseif($selectedOption=="*"){
			$response->redirect('/welcome-user-2');
		}else{
			$response->say($LanguageController->index($language,'accout_balance_login8'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/welcome-user-2');
		}
		
		echo $response;
		exit;
				
	}
	
	public function credit_process(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'];	
		
		if($selectedOption==1){
				
			Session::put('account_no', $selectedOption);
			$AccountDetails     = BaUserAccounts::where('user_id',Session::get('user_id'))->where('account_no',$selectedOption)->get();	
			if($AccountDetails->count()){
				
				$AccountHolder  = BaAccountHolders::where('id',Session::get('user_id'))->get();
				$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
				$response->say($name, ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'accout_balance_login3').$AccountDetails[0]['account_type'], ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'accout_balance_login4').number_format($AccountDetails[0]['available_balance'],2,'.',',')." ".$AccountDetails[0]['account_currency'], ['voice' => 'alice','language' => $language]);
				for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => '/account-balance-repeat', 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
						
			}
		}elseif($selectedOption==2){
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/credit-process-1', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'credit_process5'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}elseif($selectedOption==3){
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => '/credit-process-5', 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'credit_process6'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}else{
			
			$response->say($LanguageController->index($language,'Welcome_user12'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/welcome-user-2');
			
		}
		
		echo $response;
		exit;
		
				
	}
	public function welcome_user_2(Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$language           = Session::get('language');
		$input 			    = $request->all();	
		$messageCount = 2;
		
		for ($i=1; $i<=3; $i++) {		
			$gather = $response->gather(['action' => '/welcome-user', 'method' => 'GET','finishOnKey'=>'#']);
			$gather->say($LanguageController->index($language,'pin_login12').$messageCount.$LanguageController->index($language,'pin_login13'), ['voice' => 'alice','language' => $language]);
			$gather->say($LanguageController->index($language,'pin_login3'), ['voice' => 'alice','language' => $language]);
			$gather->say($LanguageController->index($language,'pin_login4'), ['voice' => 'alice','language' => $language]);
			$gather->say($LanguageController->index($language,'pin_login5'), ['voice' => 'alice','language' => $language]);
			$gather->say($LanguageController->index($language,'pin_login6'), ['voice' => 'alice','language' => $language]);
			$gather->say($LanguageController->index($language,'pin_login7'), ['voice' => 'alice','language' => $language]);
			if($messageCount>0){
				$gather->say($LanguageController->index($language,'pin_login8'), ['voice' => 'alice','language' => $language]);
			}				
		}
		$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
		$response->hangup();
		
		echo $response;
		exit;		
	}
	
	public function handle_not_get_response($response){
		
		
		$language           = Session::get('language');
		$gather = $response->gather(['action' => '/handle-input', 'method' => 'GET','finishOnKey'=>'#']);
		$gather->say($LanguageController->index($language,'invalidInput'), ['voice' => 'alice','language' => $language]);
		$gather->say($LanguageController->index($language,'handle1'), ['voice' => 'alice','language' => $language]);
		$gather->say($LanguageController->index($language,'handle2'), ['voice' => 'alice','language' => $language]);
		echo $response;
		exit;
		
	}
   
}
