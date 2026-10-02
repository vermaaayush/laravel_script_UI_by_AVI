<?php

namespace App\Http\Controllers\ivr;

use App\Http\Controllers\Controller;
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
use App\Ivr_Msg;
use App\BaTransactions;
use App\BaCards;
use App\Http\Controllers\ivr\IvrLanguageController;


class IvrLoginController extends Controller
{	
			
			 
	public function customerID_login($language,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		 $enteredCustomerID = session('enteredCustomerID');

    if ($enteredCustomerID) {
        // Customer ID is available in the session, no need to prompt for input
        $selectedOption = $enteredCustomerID;


    } else {
        // Customer ID is not available in the session, get it from user input
        $selectedOption = $input['Digits'] ?? null;
      \Log::info('Entered Customer ID: ' . $selectedOption);
    }

		$AccountHolder      = BaAccountHolders::where('customer_id',$selectedOption)->get();
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		if($AccountHolder->count()){		
			for ($i=1; $i<=3; $i++) {
			
				$gather = $response->gather(['action' => $ivr_url.'/userID-login/'.$language.'/'.$selectedOption, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'customer_id_login1'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'customer_id_login2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
		}else{		
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => $ivr_url.'/customerID-login/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'customer_id_login3'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'customer_id_login4'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);			
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
	}
		
	public function userID_login($language,$customerID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;
		$AccountHolder      = BaAccountHolders::where('customer_id',$customerID)->where('user_id',$selectedOption)->get();
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
		if($AccountHolder->count()){			
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => $ivr_url.'/pin-login/'.$language.'/'.$customerID.'/'.$selectedOption, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'user_id_login1'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'user_id_login2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
		}else{		
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => $ivr_url.'/userID-login/'.$language.'/'.$customerID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'user_id_login4'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'user_id_login5'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);	
			$response->hangup();		
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
	}
	
	public function pin_login($language,$customerID,$userID, Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;
		$AccountHolder      = BaAccountHolders::where('customer_id',$customerID)->where('user_id',$userID)->where('cust_password',$selectedOption)->get();
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
		if($AccountHolder->count()){
			if($AccountHolder[0]['account_status']==2){
				
				$response->say($LanguageController->index($language,'pin_login1'), ['voice' => 'alice','language' => $language]);	
				$response->hangup();
		
			}else{
				$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
				
				$response->say($LanguageController->index($language,'pin_login2').$name, ['voice' => 'alice','language' => $language]);	
				$ivrMessages = Ivr_Msg::where('user_id',$userID)->where('status',0)->get();
				$messageCount = $ivrMessages->count();	
				for ($i=1; $i<=3; $i++) {		
					$gather = $response->gather(['action' => $ivr_url.'/welcome-user/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'pin_login12').$messageCount.$LanguageController->index($language,'pin_login13'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login3'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login4'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login5'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login6'), ['voice' => 'alice','language' => $language]);
					$gather->say($LanguageController->index($language,'pin_login7'), ['voice' => 'alice','language' => $language]);
                    $gather->say($LanguageController->index($language,'pin_login9'), ['voice' => 'alice','language' => $language]);
					if($messageCount>0){
						$gather->say($LanguageController->index($language,'pin_login8'), ['voice' => 'alice','language' => $language]);
					}				
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
			}
		}else{		
			for ($i=1; $i<=3; $i++) {
				
				$gather = $response->gather(['action' => $ivr_url.'/pin-login/'.$language.'/'.$customerID.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'pin_login11'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'pin_login10'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);	
			$response->hangup();		
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
	}
	
	public function welcome_user($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
	//	$selectedOption     = 6;
		$selectedOption     = $input['Digits'] ?? null;
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		if($selectedOption == 1){
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/account-balance-login/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user3'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'Welcome_user2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
				
		}elseif($selectedOption == 2){
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/transfer-type/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user4'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'Welcome_user5'), ['voice' => 'alice','language' => $language]);	
				$gather->say($LanguageController->index($language,'Welcome_user51'), ['voice' => 'alice','language' => $language]);			
				$gather->say($LanguageController->index($language,'Welcome_user6'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
		}
		elseif($selectedOption == 3){
			
			$ivrMessages = Ivr_Msg::where('user_id',$userID)->where('status',0)->get();
			for ($i=1; $i<=3; $i++) {
				$messgei = 1;
				$gather = $response->gather(['action' => $ivr_url.'/welcome-user-3/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
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
		elseif($selectedOption == 4){
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/t_details/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user3'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'Welcome_user2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
		}
        elseif($selectedOption == 7){
          
            $bene = DB::table('ba_beneficiary')->where('beneficiary_added_by_user_id',$userID)->limit(5)->get();
             \Log::info('Entered Customer ID: ' . $bene);
        if($bene->count()){

			
		
			foreach($bene as $ben){
				 $formattedAccountNumber = implode(' ', str_split($ben->beneficiary_account));
				$response->say(' Beneficiary name ' . $ben->beneficiary_name . ' with ' . $ben->beneficiary_name . ' bank and account number ' . $formattedAccountNumber, ['voice' => 'alice', 'language' => $language]);

			}
			
			  $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}else{
			
			$response->say($LanguageController->index($language,'no_benefi'), ['voice' => 'alice','language' => $language]);	
			 $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
				
			
		}
		elseif($selectedOption == 5){
			
			$AccountHolder  = BaAccountHolders::where('user_id',$userID)->get();
			if($AccountHolder[0]['account_status']==2){
				$response->say($LanguageController->index($language,'Welcome_user17'), ['voice' => 'alice','language' => $language]);				
			}elseif($AccountHolder[0]['account_status']==1){
				$response->say($LanguageController->index($language,'Welcome_user16'), ['voice' => 'alice','language' => $language]);
			}elseif($AccountHolder[0]['account_status']==0){
				$response->say($LanguageController->index($language,'Welcome_user15'), ['voice' => 'alice','language' => $language]);				
			}
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);		
		}
		elseif($selectedOption == 6){
			$BaCards = BaCards::where('user_id',$userID)->get();
			if($BaCards->count()){
				for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => $ivr_url.'/credit-process/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'credit_process03'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();	
			}else{
				
				$response->say($LanguageController->index($language,'credit_process3'), ['voice' => 'alice','language' => $language]);
				$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
				
			}
		}
		else{
			$response->say($LanguageController->index($language,'Welcome_user12'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
			
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
	}
	
	public function welcome_user_2($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$AccountHolder      = BaAccountHolders::where('user_id',$userID)->get();
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
		if($AccountHolder->count()){
			if($AccountHolder[0]['account_status']==2){
				
				$response->say($LanguageController->index($language,'pin_login1'), ['voice' => 'alice','language' => $language]);	
				$response->hangup();
		
			}else{
				$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
				
				$response->say($LanguageController->index($language,'pin_login2').$name, ['voice' => 'alice','language' => $language]);	
				$ivrMessages = Ivr_Msg::where('user_id',$userID)->where('status',0)->get();
				$messageCount = $ivrMessages->count();	
				for ($i=1; $i<=3; $i++) {		
					$gather = $response->gather(['action' => $ivr_url.'/welcome-user/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
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
		}
		
		return response((string)$response,200)->header('Content-Type','text/xml');		
	}
	
	public function welcome_user3($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		
		if($selectedOption=="*"){
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
	
		}else{
			$ivrMessages        = Ivr_Msg::where('user_id',$userID)->update(['status'=>1]);		
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
				
	}
	
}
