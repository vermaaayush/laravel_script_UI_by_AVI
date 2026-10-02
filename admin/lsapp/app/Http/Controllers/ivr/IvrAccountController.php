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
use App\Ivr_suspend;
use App\ivr_purchase_numbers;
use App\Ivr_Support_number;
use App\CallLog;
use App\BaAccountHolders;
use App\BaUserAccounts;
use App\Ivr_Msg;
use App\BaTransactions;
use App\Http\Controllers\ivr\IvrLanguageController;


class IvrAccountController extends Controller
{	
			
	public function account_balance_login($language,$userID,Request $request){
	
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		$AccountDetails     = BaUserAccounts::where('user_id',$userID)->where('account_no',$selectedOption)->get();	
	
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;

		if($AccountDetails->count()){
			
			$AccountHolder  = BaAccountHolders::where('user_id',$userID)->get();
		    $Ivr_suspend  = Ivr_suspend::where('user_id',$userID)->get();
          
            
			
			$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
          
            if ($AccountHolder[0]['overdraft']==1) {

				$response->say($LanguageController->index($language,'overdraft'), ['voice' => 'alice','language' => $language]);	
			}
          
			$response->say($name, ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'accout_balance_login3')." ".$AccountDetails[0]['account_type'], ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'accout_balance_login4')." ".number_format($AccountDetails[0]['available_balance'])." ".$AccountDetails[0]['currency_name'], ['voice' => 'alice','language' => $language]);
			if($AccountDetails[0]['access']==3)
			{
			    if($Ivr_suspend->count())
			    {
			       	$response->say($LanguageController->index($language,'accout_status_suspend2')." ".$Ivr_suspend[0]['message'], ['voice' => 'alice','language' => $language]);
			    }
			    else
			    {
			        $response->say($LanguageController->index($language,'accout_status_suspend1'), ['voice' => 'alice','language' => $language]);
			    }       
			    
			}
			
			
			
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/account-balance-repeat/'.$language.'/'.$userID.'/'.$selectedOption, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
					
		}else{
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/account-balance-login/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login6'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'accout_balance_login7'), ['voice' => 'alice','language' => $language]);	
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		
		return response((string)$response,200)->header('Content-Type','text/xml');	
	}
	
	public function account_balance_repeat($language,$userID,$accountNum,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
		if($selectedOption == '*'){
			$AccountDetails     = BaUserAccounts::where('user_id',$userID)->where('account_no',$accountNum)->get();	
			if($AccountDetails->count()){
				
				$AccountHolder  = BaAccountHolders::where('user_id',$userID)->get();
				$name = $AccountHolder[0]['cust_name'].' '.$AccountHolder[0]['middle_name'].' '.$AccountHolder[0]['sur_name'];
              
                  if ($AccountHolder[0]['overdraft']==1) {

				       $response->say($LanguageController->index($language,'overdraft'), ['voice' => 'alice','language' => $language]);	
			      }
				$response->say($name, ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'accout_balance_login3').$AccountDetails[0]['account_type'], ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'accout_balance_login4')." ".number_format($AccountDetails[0]['available_balance'],2,'.',',')." ".$AccountDetails[0]['currency_name'], ['voice' => 'alice','language' => $language]);
				for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => $ivr_url.'/account-balance-repeat/'.$language.'/'.$userID.'/'.$accountNum, 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();			
			}
		}elseif($selectedOption == 1){
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}else{
			$response->say($LanguageController->index($language,'accout_balance_login8'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}
		
		return response((string)$response,200)->header('Content-Type','text/xml');	
	}
			
	public function t_details($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		$AccountDetails     = BaUserAccounts::where('user_id',$userID)->where('account_no',$selectedOption)->get();	
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
		if($AccountDetails->count()){

			$TransactionDetails = BaTransactions::where('user_id',$userID)->where('act_number',$selectedOption)->orderBy('id','DESC')->take(5)->get();	
			$response->say($LanguageController->index($language,'accout_balance_login1'), ['voice' => 'alice','language' => $language]);
			foreach($TransactionDetails as $transaction){
				
				$response->say(number_format($transaction['amount'],2,'.',',')." ".$AccountDetails[0]['currency_name'].' was '.$transaction['type'], ['voice' => 'alice','language' => $language]);
			}
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/t_details1/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();		
		}else{
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/t_details/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login6'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'accout_balance_login7'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
				
	}
  
  public function t_benefi($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		$AccountDetails     = BaUserAccounts::where('user_id',$userID)->where('account_no',$selectedOption)->get();	
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
		if($AccountDetails->count()){

			$TransactionDetails = BaTransactions::where('user_id',$userID)->where('act_number',$selectedOption)->orderBy('id','DESC')->take(5)->get();	
			$response->say($LanguageController->index($language,'accout_balance_login1'), ['voice' => 'alice','language' => $language]);
			foreach($TransactionDetails as $transaction){
				
				$response->say(number_format($transaction['amount'],2,'.',',')." ".$AccountDetails[0]['currency_name'].' was '.$transaction['type'], ['voice' => 'alice','language' => $language]);
			}
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/t_details1/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login2'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();		
		}else{
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/t_details/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'accout_balance_login6'), ['voice' => 'alice','language' => $language]);
				$gather->say($LanguageController->index($language,'accout_balance_login7'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
				
	}
	
	public function t_details1($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url; 
		
		if($selectedOption==1){		
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/t_details/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'Welcome_user3'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'Welcome_user2'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		elseif($selectedOption=="*"){
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}else{
			$response->say($LanguageController->index($language,'accout_balance_login8'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}
		
		return response((string)$response,200)->header('Content-Type','text/xml');
				
	}
}
