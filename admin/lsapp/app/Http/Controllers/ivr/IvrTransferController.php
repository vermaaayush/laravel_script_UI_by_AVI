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
use App\Transfer_suspend;
use App\BaUserAccounts;
use App\Ba_beneficiary;
use App\Ivr_Msg;
use App\BaTransactions;
use App\Http\Controllers\ivr\IvrLanguageController;
use App\Ivr_token;


class IvrTransferController extends Controller
{
	
	 public function __construct() {
	     
	     
	     
	    $config = DB::select('select bank_email,bank_name, logo, sms_token, sms_sid, sms_phone from configs where 1');
	    
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
    
	
	public function transfer_type($language,$userID,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;	
        
        $User_T_status    = BaAccountHolders::where('user_id',$userID)->get();
        
        $transfer_status    = Transfer_suspend::where('user_id',$userID)->get();

        $config_x = DB::select('select * from configs');
          
	    if($config_x[0]->trans_status_position=='before') 
        {
            if($User_T_status[0]['transfer_control']==1)
		     {	
                if($transfer_status->count())
			    {
                  $response->say($LanguageController->index($language,'accout_status_suspend2')." ".$transfer_status[0]['message'], ['voice' => 'alice','language' => $language]);
                //   $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
                  $response->hangup();
                   return response((string)$response,200)->header('Content-Type','text/xml');
                  
                   
			    }
			    else
			    {
			      $response->say($LanguageController->index($language,'accout_status_suspend3'), ['voice' => 'alice','language' => $language]);
                //   $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
                  $response->hangup();
                   return response((string)$response,200)->header('Content-Type','text/xml');
			    }   
		     }
        }
		    
		
	
	
		    
		  if($selectedOption==1 or $selectedOption==2 or $selectedOption==3){  
		      	
		    
			$accounts = BaUserAccounts::where('user_id',$userID)->where('access',1)->get();
			for ($i=1; $i<=3; $i++) {
					
				if($accounts->count()){
					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process/'.$language.'/'.$userID.'/'.$selectedOption, 'method' => 'GET','finishOnKey'=>'#']);
					$response->say($LanguageController->index($language,'transfer_type1'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_link_acc1').$accounts->count(), ['voice' => 'alice','language' => $language]);
					$j=1;	
					foreach($accounts as $account){		
						
						$gather->say($LanguageController->index($language,'transfer_link_acc2').$account['account_no'], ['voice' => 'alice','language' => $language]);
						$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
						$j++;				
					}
				}else{
					$response->say($LanguageController->index($language,'transfer_type1'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
				}
			}
		
		
		}
		elseif($selectedOption=='*'){
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}else{
			$response->say($LanguageController->index($language,'Welcome_user12'), ['voice' => 'alice','language' => $language]);
			$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
		}	
	    return response((string)$response,200)->header('Content-Type','text/xml');	
		}
		
		

	
	public function transfer_acc_process($language,$userID,$type,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();
		
		$selectedOption     = $input['Digits'] ?? null;	
		//$selectedOption     = 1;	
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		if($type==1 or $type==2){
			
			$accounts = BaUserAccounts::where('user_id',$userID)->where('access',1)->get();
			$i=1;	
			foreach($accounts as $account){
				if($i==$selectedOption)	{				
					$fromAccountNumber = $account['account_no'];	
					$i++;				
				}
			}
			
			$Ba_benes                   = Ba_beneficiary::where('verification',1)->where('beneficiary_added_by_user_id', $userID)->get();
			
			for ($i=1; $i<=3; $i++) {			
				
				if($Ba_benes->count()){
    					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_1/'.$language.'/'.$userID.'/'.$type.'/'.$fromAccountNumber, 'method' => 'GET','finishOnKey'=>'#']);
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_link_accb').$accounts->count(), ['voice' => 'alice','language' => $language]);
    					$j=1;	
    					sleep(1);
    					foreach($Ba_benes as $account){		
    						 $accountDigits = str_split($account['beneficiary_account']);
                             $formattedAccount = implode(' ', $accountDigits);
    						$gather->say($LanguageController->index($language,'transfer_link_accb1').$formattedAccount.' with the name of '.$account['beneficiary_name'], ['voice' => 'alice','language' => $language]);
    						$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
    						sleep(1);
    						$j++;				
    					}
    				}else{
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
    					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
    				}

				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			
			
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			
		}
		elseif($type==3){
			
			$accounts = BaUserAccounts::where('user_id',$userID)->where('access',1)->get();
			$i=1;	
			foreach($accounts as $account){
				if($i==$selectedOption)	{				
					$fromAccountNumber = $account['account_no'];	
					$fromAccountCurr   = $account['currency_name'];				
				}
				$i++;
			}
			
			$accountsTo = BaUserAccounts::where('user_id',$userID)->where('account_currency',$fromAccountCurr)->where('account_no','!=',$fromAccountNumber)->where('access',1)->get();
			
	
				if($accountsTo->count()){
					$response->say($LanguageController->index($language,'transfer_type1'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_link_acc1').$accountsTo->count(), ['voice' => 'alice','language' => $language]);
						
					for ($i=1; $i<=3; $i++) {
						
						$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_2/'.$language.'/'.$userID.'/'.$type.'/'.$fromAccountNumber, 'method' => 'GET','finishOnKey'=>'#']);
						$j=1;
						foreach($accountsTo as $accountto){	
							
							
							$gather->say($LanguageController->index($language,'transfer_link_acc5').$accountto['account_no'], ['voice' => 'alice','language' => $language]);
							$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
							$j++;				
						}
						$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
					}
					$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
					$response->hangup();					
				}else{
					$response->say($LanguageController->index($language,'transfer_type1'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
				}
			
			}
		return response((string)$response,200)->header('Content-Type','text/xml');	
			
	}
	
	public function transfer_acc_process_1($language,$userID,$type,$accountid,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		//$selectedOption     = '123456789';
		
		
		$Ba_benes                   = Ba_beneficiary::where('verification',1)->where('beneficiary_added_by_user_id', $userID)->get();
		$k=1;	
		foreach($Ba_benes as $benes){
			if($k==$selectedOption)	{				
				$beniAccountNumber = $benes['beneficiary_account'];	
				$k++;				
			}
		}
		
		
		if($type==1){
		$transfer_from_account      = BaUserAccounts::where('user_id',$userID)->where('account_no',$accountid)->get();
		$transfer_to_account        = BaUserAccounts::where('account_no',$beniAccountNumber)->get();
		$transfer_to_user           = BaAccountHolders::where('user_id',$transfer_to_account[0]['user_id'])->get();
		
			
		if($transfer_to_account->count()){
			
			if($transfer_to_user[0]['account_status'] == 2) {

				$response->say($LanguageController->index($language,'transfer_link_acc7'), ['voice' => 'alice','language' => $language]);
				for ($i=1; $i<=3; $i++) {	
				    
				    if($Ba_benes->count()){
    					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_1/'.$language.'/'.$userID.'/'.$type.'/'.$accountid, 'method' => 'GET','finishOnKey'=>'#']);
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_link_accb').$accounts->count(), ['voice' => 'alice','language' => $language]);
    					$j=1;	
    					foreach($Ba_benes as $account){		
    						
    						$gather->say($LanguageController->index($language,'transfer_link_accb1').$account['beneficiary_account'], ['voice' => 'alice','language' => $language]);
    						$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
    						$j++;				
    					}
    				}else{
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
    					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
    				}
				    
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
            }
			elseif($transfer_to_user[0]['account_status'] == 0) {

				$response->say($LanguageController->index($language,'transfer_link_acc8'), ['voice' => 'alice','language' => $language]);
				for ($i=1; $i<=3; $i++) {			
				    if($Ba_benes->count()){
    					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_1/'.$language.'/'.$userID.'/'.$type.'/'.$accountid, 'method' => 'GET','finishOnKey'=>'#']);
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_link_accb').$accounts->count(), ['voice' => 'alice','language' => $language]);
    					$j=1;	
    					foreach($Ba_benes as $account){		
    						
    						$gather->say($LanguageController->index($language,'transfer_link_accb1').$account['beneficiary_account'], ['voice' => 'alice','language' => $language]);
    						$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
    						$j++;				
    					}
    				}else{
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
    					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
    				}
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
            }

           elseif($transfer_to_user[0]['access'] == 3) {

				$response->say($LanguageController->index($language,'transfer_link_acc7'), ['voice' => 'alice','language' => $language]);
				for ($i=1; $i<=3; $i++) {			
					 if($Ba_benes->count()){
    					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_1/'.$language.'/'.$userID.'/'.$type.'/'.$accountid, 'method' => 'GET','finishOnKey'=>'#']);
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_link_accb').$accounts->count(), ['voice' => 'alice','language' => $language]);
    					$j=1;	
    					foreach($Ba_benes as $account){		
    						
    						$gather->say($LanguageController->index($language,'transfer_link_accb1').$account['beneficiary_account'], ['voice' => 'alice','language' => $language]);
    						$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
    						$j++;				
    					}
    				}else{
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
    					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
    				}
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
            }

            elseif($transfer_from_account[0]['account_currency'] != $transfer_to_account[0]['account_currency']) {

				$response->say($LanguageController->index($language,'transfer_link_acc9'), ['voice' => 'alice','language' => $language]);
				for ($i=1; $i<=3; $i++) {			
					if($Ba_benes->count()){
    					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_1/'.$language.'/'.$userID.'/'.$type.'/'.$accountid, 'method' => 'GET','finishOnKey'=>'#']);
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_link_accb').$accounts->count(), ['voice' => 'alice','language' => $language]);
    					$j=1;	
    					foreach($Ba_benes as $account){		
    						
    						$gather->say($LanguageController->index($language,'transfer_link_accb1').$account['beneficiary_account'], ['voice' => 'alice','language' => $language]);
    						$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
    						$j++;				
    					}
    				}else{
    					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
    					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
    					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
    				}
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
            }else{
			
			
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_5/'.$language.'/'.$userID.'/'.$type.'/'.$accountid.'/'.$beniAccountNumber, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'transfer_token5'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
			}
			
			
		}else{
			
			$response->say($LanguageController->index($language,'transfer_link_acc6'), ['voice' => 'alice','language' => $language]);
			for ($i=1; $i<=3; $i++) {			
				if($Ba_benes->count()){
					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_1/'.$language.'/'.$userID.'/'.$type.'/'.$accountid, 'method' => 'GET','finishOnKey'=>'#']);
					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_link_accb').$accounts->count(), ['voice' => 'alice','language' => $language]);
					$j=1;	
					foreach($Ba_benes as $account){		
						
						$gather->say($LanguageController->index($language,'transfer_link_accb1').$account['beneficiary_account'], ['voice' => 'alice','language' => $language]);
						$gather->say($LanguageController->index($language,'transfer_link_acc3').$j, ['voice' => 'alice','language' => $language]);
						$j++;				
					}
				}else{
					$response->say($LanguageController->index($language,'transfer_typeb'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_type2'), ['voice' => 'alice','language' => $language]);	
					$response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);	
				}
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
		}
		}else{	
		
		
			for ($i=1; $i<=3; $i++) {			
			$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_4/'.$language.'/'.$userID.'/'.$type.'/'.$accountid.'/'.$beniAccountNumber, 'method' => 'GET','finishOnKey'=>'#']);
			$gather->say($LanguageController->index($language,'transfer_token5'), ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();
		
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
		
	}
	
	public function transfer_acc_process_4($language,$userID,$type,$accountid,$toaccountid,Request $request){	

		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		$amount    			= $selectedOption;

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;

		$accounts   = BaUserAccounts::where('user_id',$userID)->where('access',1)->where('account_no',$accountid)->get();
		
		if($accounts[0]['available_balance'] > $selectedOption){
			$response->say($LanguageController->index($language,'transfer_link_acc12'), ['voice' => 'alice','language' => $language]);
				
				for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_6/'.$language.'/'.$userID.'/'.$type.'/'.$accountid.'/'.$toaccountid.'/'.$amount, 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'transfer_link_acc13'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
		
		}else{
			
			$response->say($LanguageController->index($language,'transfer_token4'), ['voice' => 'alice','language' => $language]);	
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_4/'.$language.'/'.$userID.'/'.$type.'/'.$accountid.'/'.$toaccountid, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'transfer_token5'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();	
			
		}
		return response((string)$response,200)->header('Content-Type','text/xml');
		
}
	
	public function transfer_acc_process_6($language,$userID,$type,$Fromaccountid,$Toaccountid,$amount,Request $request){	

		$response 		          = new VoiceResponse();	
		$LanguageController       = new IvrLanguageController();
		$input 			          = $request->all();	
		$selectedOption           = $input['Digits'] ?? null;
		$debitedAccountNumber     = $Fromaccountid;
      
      
         $User_T_status    = BaAccountHolders::where('user_id',$userID)->get();
        
        $transfer_status    = Transfer_suspend::where('user_id',$userID)->get();

        $config_x = DB::select('select * from configs');
          
	    if($config_x[0]->trans_status_position=='after') 
        {
            if($User_T_status[0]['transfer_control']==1)
		     {	
                if($transfer_status->count())
			    {
                  $response->say($LanguageController->index($language,'accout_status_suspend2')." ".$transfer_status[0]['message'], ['voice' => 'alice','language' => $language]);
                  $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
                  return response((string)$response,200)->header('Content-Type','text/xml');
                   
			    }
			    else
			    {
			      $response->say($LanguageController->index($language,'accout_status_suspend3'), ['voice' => 'alice','language' => $language]);
                  $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
                   return response((string)$response,200)->header('Content-Type','text/xml');
			    }   
		     }
			 
        }
		
		if($selectedOption==1){

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;	
		
		$charges = (0.002 / 100) * $amount;
		
		$accounts   = BaUserAccounts::where('user_id',$userID)->where('access',1)->where('account_no',$debitedAccountNumber)->get();
          
        
		
		
		if($accounts->count()){
		
			if($accounts[0]['available_balance'] > $charges){
			    
		    $Ba_benes = Ba_beneficiary::where('beneficiary_account',$Toaccountid)->where('beneficiary_added_by_user_id', $userID)->get();
			    
			$x_accountDigits = str_split($Toaccountid);
			$x_account_no = implode(' ', $x_accountDigits);
			$response->say('Your Beneficiary Account Number is '.$x_account_no.' Beneficiary  Name is '. $Ba_benes[0]['beneficiary_name'].' Beneficiary  Bank name is '.$Ba_benes[0]['beneficiary_bank_name'].' Your Added Amount is '
			.number_format($amount).' ', ['voice' => 'alice','language' => $language]);
				
				$tran_id = $this->transfer_insertion($userID,$Fromaccountid,$Toaccountid,$amount,$type,$debitedAccountNumber);
				
				$tokenData = Ivr_token::where('user_id',$userID)->get();
				
				if($tokenData->count()){
					
					if($tokenData[0]['allow_code_1']==1){
						
						for ($i=1; $i<=3; $i++) {			
							$gather = $response->gather(['action' => $ivr_url.'/transfer_token_1/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
							$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_1'], ['voice' => 'alice','language' => $language]);	
							$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
						}
						$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
						$response->hangup();
						
						
					}else{
						
						
						
						$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
						$this->transfer_update($tran_id,$type);
						//$response->hangup();
                      $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
						
					}
					
					
				}else{
					
					
					$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
					$this->transfer_update($tran_id,$type);	
					// $response->hangup();
                    $response->redirect('/admin/welcome-user-2/'.$language.'/'.$userID, ['method' => 'GET']);
					
				}
	
			
			}else{
				
				$response->say($LanguageController->index($language,'transfer_token4'), ['voice' => 'alice','language' => $language]);	
				for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_4/'.$language.'/'.$userID.'/'.$type.'/'.$Fromaccountid.'/'.$Toaccountid.'/'.$amount, 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'transfer_token5'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();	
				
			}
		}else{
	
				for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_4/'.$language.'/'.$userID.'/'.$type.'/'.$Fromaccountid.'/'.$Toaccountid.'/'.$amount, 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'transfer_token6'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();	
			
			
		}
		}else{
		    	for ($i=1; $i<=3; $i++) {			
					$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_4/'.$language.'/'.$userID.'/'.$type.'/'.$Fromaccountid.'/'.$Toaccountid.'/'.$amount, 'method' => 'GET','finishOnKey'=>'#']);
					$gather->say($LanguageController->index($language,'transfer_token6'), ['voice' => 'alice','language' => $language]);
					$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
				}
				$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
				$response->hangup();
		    
		}
		
		return response((string)$response,200)->header('Content-Type','text/xml');
		
}
	
	
	public function transfer_acc_process_5($language,$userID,$type,$Fromaccountid,$Toaccountid,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = '10';	
		$amount    			= $selectedOption;	

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		
		$accounts           = BaUserAccounts::where('user_id',$userID)->where('access',1)->where('account_no',$Fromaccountid)->get();


		
	
		if($accounts[0]['available_balance'] > $selectedOption){
		
			$tran_id = $this->transfer_insertion($userID,$Fromaccountid,$Toaccountid,$amount,$type,'');
			
			
			$tokenData = Ivr_token::where('user_id',$userID)->get();
			
			if($tokenData->count()){
				
				if($tokenData[0]['allow_code_1']==1){
					
					for ($i=1; $i<=3; $i++) {			
						$gather = $response->gather(['action' => $ivr_url.'/transfer_token_1/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
						$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_1'], ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
					}
					$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
					$response->hangup();
					
					
				}else{
					
					
					
					$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
					$this->transfer_update_2($tran_id,$type);
					$response->hangup();
					
				}
				
				
			}else{
				
			
				$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
				$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
				$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
					$this->transfer_update($tran_id,$type);		
				$response->hangup();
				
			}
		}else{
			
			$response->say($LanguageController->index($language,'transfer_token4'), ['voice' => 'alice','language' => $language]);	
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_5/'.$language.'/'.$userID.'/'.$type.'/'.$Fromaccountid.'/'.$Toaccountid, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'transfer_token5'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();		
		}
			
		return response((string)$response,200)->header('Content-Type','text/xml');
		
	}
	
	
	public function transfer_acc_process_2($language,$userID,$type,$accountid,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		$accounts   = BaUserAccounts::where('user_id',$userID)->where('access',1)->where('account_no',$accountid)->get();
		
		$accountsTo = BaUserAccounts::where('user_id',$userID)->where('account_currency',$accounts[0]['account_currency'])->where('account_no','!=',$accountid)->where('access',1)->get();
			$i=1;	
			foreach($accountsTo as $accountto){
				if($i==$selectedOption)	{				
					$toAccountNumber = $accountto['account_no'];	
					$i++;				
				}
			}		
		
		for ($i=1; $i<=3; $i++) {			
			$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_3/'.$language.'/'.$userID.'/'.$type.'/'.$accountid.'/'.$toAccountNumber, 'method' => 'GET','finishOnKey'=>'#']);
			$gather->say($LanguageController->index($language,'transfer_token5'), ['voice' => 'alice','language' => $language]);
			$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
		}
		$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
		$response->hangup();
			
		return response((string)$response,200)->header('Content-Type','text/xml');
		
	}
	
	public function transfer_acc_process_3($language,$userID,$type,$Fromaccountid,$Toaccountid,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;	
		$amount				= $selectedOption;

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		$accounts   = BaUserAccounts::where('user_id',$userID)->where('access',1)->where('account_no',$Fromaccountid)->get();
		
		if($accounts[0]['available_balance'] > $selectedOption){
			
			
			$tran_id = $this->transfer_insertion($userID,$Fromaccountid,$Toaccountid,$amount,$type,'');
			
			
			$tokenData = Ivr_token::where('user_id',$userID)->get();
			
			if($tokenData->count()){
				
				if($tokenData[0]['allow_code_1']==1){
					
					for ($i=1; $i<=3; $i++) {			
						$gather = $response->gather(['action' => $ivr_url.'/transfer_token_1/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
						$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_1'], ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
					}
					$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
					$response->hangup();
					
					
				}else{
					
					
					
					$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
					$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
					$this->transfer_update($tran_id,$type);
					$response->hangup();
					
				}
				
				
			}else{
				
					
				$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
				$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
				$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
				$this->transfer_update($tran_id,$type);	
				$response->hangup();
				
			}

		}else{
			
			$response->say($LanguageController->index($language,'transfer_token4'), ['voice' => 'alice','language' => $language]);	
			for ($i=1; $i<=3; $i++) {			
				$gather = $response->gather(['action' => $ivr_url.'/transfer_acc_process_3/'.$language.'/'.$userID.'/'.$type.'/'.$Fromaccountid.'/'.$Toaccountid, 'method' => 'GET','finishOnKey'=>'#']);
				$gather->say($LanguageController->index($language,'transfer_token5'), ['voice' => 'alice','language' => $language]);
				$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
			}
			$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
			$response->hangup();		
		}
			
		return response((string)$response,200)->header('Content-Type','text/xml');
		
	}
	

	public function transfer_token_1($language,$userID,$type,$tran_id,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();
		//$selectedOption     = '1234';	
		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;

		$selectedOption     = $input['Digits'] ?? null;
		
		$tokenData = Ivr_token::where('user_id',$userID)->get();
			
			if($tokenData->count()){
				
				if($tokenData[0]['code_1'] == $selectedOption){
				
					if($tokenData[0]['allow_code_2']==1){
					
						for ($i=1; $i<=3; $i++) {			
							$gather = $response->gather(['action' => $ivr_url.'/transfer_token_2/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
							$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_2'], ['voice' => 'alice','language' => $language]);	
							$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
						}
						$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
						$response->hangup();
					
					
					}else{
						
					
						
						$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
							$this->transfer_update($tran_id,$type);
						$response->hangup();
						
					}
				}else{
					$response->say($LanguageController->index($language,'transfer_link_acc11').$tokenData[0]['code_name_1'], ['voice' => 'alice','language' => $language]);	
					
					for ($i=1; $i<=3; $i++) {			
						$gather = $response->gather(['action' => $ivr_url.'/transfer_token_1/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
						$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_1'], ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
					}
					$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
					$response->hangup();
					
				}
					
			}
			return response((string)$response,200)->header('Content-Type','text/xml');	
		}
		
	public function transfer_token_2($language,$userID,$type,$tran_id,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		$selectedOption     = $input['Digits'] ?? null;

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		$tokenData = Ivr_token::where('user_id',$userID)->get();
			
			if($tokenData->count()){
				
				if($tokenData[0]['code_2'] == $selectedOption){
				
					if($tokenData[0]['allow_code_3']==1){
					
						for ($i=1; $i<=3; $i++) {			
							$gather = $response->gather(['action' => $ivr_url.'/transfer_token_3/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
							$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_3'], ['voice' => 'alice','language' => $language]);	
							$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
						}
						$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
						$response->hangup();
					
					}else{
						
						
						
						$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
						$this->transfer_update($tran_id,$type);
						$response->hangup();
						
					}
				}else{
					$response->say($LanguageController->index($language,'transfer_link_acc11').$tokenData[0]['code_name_2'], ['voice' => 'alice','language' => $language]);	
					
					for ($i=1; $i<=3; $i++) {			
						$gather = $response->gather(['action' => $ivr_url.'/transfer_token_2/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
						$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_2'], ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
					}
					$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
					$response->hangup();
					
				}
					
			}
			return response((string)$response,200)->header('Content-Type','text/xml');	
	}
		
	public function transfer_token_3($language,$userID,$type,$tran_id,Request $request){
		
		$response 		    = new VoiceResponse();	
		$LanguageController = new IvrLanguageController();
		$input 			    = $request->all();	
		//$selectedOption     = '1234';	
		$selectedOption     = $input['Digits'] ?? null;

		$ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
		
		$tokenData = Ivr_token::where('user_id',$userID)->get();
			
			if($tokenData->count()){
				
				if($tokenData[0]['code_3'] == $selectedOption){
						
						$this->transfer_update($tran_id,$type);
						
						$response->say($LanguageController->index($language,'transfer_credit3'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit4'), ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'transfer_credit6'), ['voice' => 'alice','language' => $language]);	
							$this->transfer_update($tran_id,$type);
						$response->hangup();

				}else{
					$response->say($LanguageController->index($language,'transfer_link_acc11').$tokenData[0]['code_name_3'], ['voice' => 'alice','language' => $language]);	
					
					for ($i=1; $i<=3; $i++) {			
						$gather = $response->gather(['action' => $ivr_url.'/transfer_token_3/'.$language.'/'.$userID.'/'.$type.'/'.$tran_id, 'method' => 'GET','finishOnKey'=>'#']);
						$gather->say($LanguageController->index($language,'transfer_link_acc10').$tokenData[0]['code_name_3'], ['voice' => 'alice','language' => $language]);	
						$response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'alice','language' => $language]);	
					}
					$response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'alice','language' => $language]);
					$response->hangup();
					
				}
					
			}
			return response((string)$response,200)->header('Content-Type','text/xml');
		
		}
		
			
	public function transfer_insertion($userID,$Fromaccountid,$Toaccountid,$amount,$type,$debitedAccount){
		
		$user_id = 	$userID;
		$tran_id = md5(time());
        $datetime = date("Y-m-d H:i:s");
        $token = rand(100000, 999999);
        $step2 = '';
        $step3 = '';
        $step4 = '';
		
		if($type==3){
		
		$accountsFrom   = BaUserAccounts::where('user_id',$user_id)->where('access',1)->where('account_no',$Fromaccountid)->get();
			//$balanceFrom    = $accountsFrom[0]->available_balance - $amount;	
			DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, token = ?, step2 = ?, step3 = ?, step4 = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $Fromaccountid, 'debited', $accountsFrom[0]['available_balance'], 0, $amount, $tran_id, $token, $step2, $step3, $step4, 'Via Call', 0, 0, 'available_balance', $datetime]);
			
			
			$accountsTo     = BaUserAccounts::where('user_id',$user_id)->where('access',1)->where('account_no',$Toaccountid)->get();
			//$balanceTo      = $accountsTo[0]->available_balance + $amount;
       		DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?',
       		[$user_id, $Toaccountid, 'credited', $accountsTo[0]['available_balance'], 0, $amount, $tran_id, 'Via Call', 0, 0, 'available_balance', $datetime]);
			
		}elseif($type==1){
			
			$accountsFrom   = BaUserAccounts::where('user_id',$user_id)->where('access',1)->where('account_no',$Fromaccountid)->get();
			//$balanceFrom    = $accountsFrom[0]->available_balance - $amount;	
			DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, token = ?, step2 = ?, step3 = ?, step4 = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $Fromaccountid, 'debited', $accountsFrom[0]['available_balance'], 0, $amount, $tran_id, $token, $step2, $step3, $step4, 'Via Call', 0, 0, 'available_balance', $datetime]);
			
			
			$accountsTo     = BaUserAccounts::where('account_no',$Toaccountid)->get();
			//$balanceTo      = $accountsTo[0]->available_balance + $amount;
       		DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $Toaccountid, 'credited', $accountsTo[0]['available_balance'], 0, $amount, $tran_id, 'Via Call', 0, 0, 'available_balance', $datetime]);
			
		}
		
		else{
			
			$accountsFrom   = BaUserAccounts::where('user_id',$user_id)->where('access',1)->where('account_no',$Fromaccountid)->get();
			//$balanceFrom    = $accountsFrom[0]->available_balance - $amount;	
			DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, token = ?, step2 = ?, step3 = ?, step4 = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?',
			[$user_id, $Fromaccountid, 'debited', $accountsFrom[0]['available_balance'], 0, $amount, $tran_id, $token, $step2, $step3, $step4, 'Via Call', 0, 0, 'available_balance', $datetime]);
			
			
			$accountsTo     = BaUserAccounts::where('account_no',$debitedAccount)->get();
			//$balanceTo      = $accountsTo[0]->available_balance + $amount;
				$charges = (0.002 / 100) * $amount;
       		DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, reason = ?, statement = ?, international = ?, balance_type = ?, datetime = ?',
       		[$user_id, $debitedAccount, 'charges', $accountsTo[0]['available_balance'], 0, $charges, $tran_id, 'Via Call', 0, 0, 'available_balance', $datetime]);
			
		 DB::insert('insert into ba_transactions set user_id = ?, act_number = ?, type = ?, balance = ?, status = ?, amount = ?, tran_id = ?, statement = ?, international = ?, balance_type = ?, datetime = ?', [$user_id, $Toaccountid, 'credited', 0, 0, $amount, $tran_id, 0, 1, 'available_balance', $datetime]);
				
			
		}
			
			return $tran_id;
			
		
	}
	
	public function transfer_update($tran_id,$type){
		
		if($type==3){
		$transactions = DB::select('select * from ba_transactions where tran_id = ? and status = ?', [$tran_id, 0]);
		foreach($transactions as $tran) {
			$account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);
			if($tran->type == 'debited') {
				$balance = $account[0]->available_balance - $tran->amount;
			}
			elseif($tran->type == 'credited') {
				$balance = $account[0]->available_balance + $tran->amount;
			}
			DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
			DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
		}
		}elseif($type==1){
			$transactions = DB::select('select * from ba_transactions where tran_id = ? and status = ?', [$tran_id, 0]);
		foreach($transactions as $tran) {
            $account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);

            $user = DB::select('select * from ba_account_holders where user_id = ?', [$account[0]->user_id]);

            if($tran->type == 'debited') {
                $balance = $account[0]->available_balance - $tran->amount;

                if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                    $msg = 'Your Account ' . $tran->act_number . ' has been debited for amount ' . $tran->amount . ' ' . $account[0]->account_currency;
                    try {

						foreach($recipients_arr as $recipient) {
							$client->messages->create($recipient, 
							['from' => $this->fromNumber, 'body' => $msg] );
						}
					  
					  
					} catch (\Throwable $th) {
					  
					   
					}

                    Mail::raw($msg, function($message) use ($user)
                    {
                        $message->from($this->fromEmail, 'Banking');

                        $message->subject('Amount Debited');

                        $message->to($user[0]->cust_mail);
                    });
                }
            }
            elseif($tran->type == 'credited') {
                $balance = $account[0]->available_balance + $tran->amount;

                if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                    $msg = 'Your Account ' . $tran->act_number . ' has been credited with amount ' . $tran->amount . ' ' . $account[0]->account_currency;
                    try {

						foreach($recipients_arr as $recipient) {
							$client->messages->create($recipient, 
							['from' => $this->fromNumber, 'body' => $msg] );
						}
					  
					  
					} catch (\Throwable $th) {
					  
					   
					}

                    Mail::raw($msg, function($message) use ($user)
                    {
                        $message->from($this->fromEmail, 'Banking');

                        $message->subject('Amount Credited');

                        $message->to($user[0]->cust_mail);
                    });
                }
            }
            DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
            DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
        }
			
			
		}
		elseif($type==2){
			 $transactions = DB::select('select * from ba_transactions where tran_id = ? and status = ?', [$tran_id, 0]);
        foreach($transactions as $tran) {
            if($tran->type == 'debited') {
                $account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);
                $user = DB::select('select * from ba_account_holders where user_id = ?', [$account[0]->user_id]);
                $balance = $account[0]->available_balance - $tran->amount;

                if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                    $msg = 'Your Account ' . $tran->act_number . ' has been debited for amount ' . $tran->amount . ' ' . $account[0]->account_currency;
                    try {

						foreach($recipients_arr as $recipient) {
							$client->messages->create($recipient, 
							['from' => $this->fromNumber, 'body' => $msg] );
						}
					  
					  
					} catch (\Throwable $th) {
					  
					   
					}

                    Mail::raw($msg, function($message) use ($user)
                    {
                        $message->from($this->fromEmail, 'Banking');

                        $message->subject('Amount Debited');

                        $message->to($user[0]->cust_mail);
                    });
                }

                DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
                DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
            }
            elseif($tran->type == 'credited') {
                $balance = $tran->amount;
                DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
            }
            elseif($tran->type == 'charges') {
                $account = DB::select('select * from ba_user_accounts where account_no = ?', [$tran->act_number]);
                $balance = $account[0]->available_balance - $tran->amount;

                if($this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
                    $msg = 'Your Account ' . $tran->act_number . ' has been debited for amount (charges for transfer)' . $tran->amount . ' ' . $account[0]->account_currency;
                  
					
					try {

						foreach($recipients_arr as $recipient) {
							$client->messages->create($recipient, 
							['from' => $this->fromNumber, 'body' => $msg] );
						}
					  
					  
					} catch (\Throwable $th) {
					  
					   
					}
					
					
					



                    Mail::raw($msg, function($message) use ($user)
                    {
                        $message->from($this->fromEmail, 'Banking');

                        $message->subject('Amount Debited');

                        $message->to($user[0]->cust_mail);
                    });
                }

                DB::update('update ba_transactions set status = ?, balance = ? where id = ?', [1, $balance, $tran->id]);
                DB::update('update ba_user_accounts set available_balance = ? where id = ?', [$balance, $account[0]->id]);
            }
            
        }
			
			}
	}	
	
}
