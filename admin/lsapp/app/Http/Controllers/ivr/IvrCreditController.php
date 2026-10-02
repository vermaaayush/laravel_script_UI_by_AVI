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


class IvrCreditController extends Controller
{
	
	public function credit_process($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		
		$BaCards = BaCards::where('user_id',$userID)->whereRaw('RIGHT(card_number, 6) = '.$selectedOption)->get();
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
	
		if($BaCards->count()){
			
			if($BaCards[0]['status']==2){
				$response->say($LanguageController->index($language,'Welcome_user17'), ['voice' => 'alice','language' => $language]);				
			}elseif($BaCards[0]['status']==1){
				$response->say($LanguageController->index($language,'Welcome_user16'), ['voice' => 'alice','language' => $language]);
			}elseif($BaCards[0]['status']==0){
				$response->say($LanguageController->index($language,'Welcome_user15'), ['voice' => 'alice','language' => $language]);				
			}elseif($BaCards[0]['status']==3){
				$response->say($LanguageController->index($language,'Welcome_user18'), ['voice' => 'alice','language' => $language]);				
			}
			$response->redirect('admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
			
		}
		else{
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/credit-process/'.$language.'/'.$userID, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'credit_process07'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
	
		}

		return response((string)$response,200)->header('Content-Type','text/xml');
		
				
	}
}
