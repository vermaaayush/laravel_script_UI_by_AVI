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
use App\Http\Controllers\ivr\IvrLanguageController;


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
        $ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
         
        $language       = $Settings[0]['ivr_lang'];
        $default_bank = $Settings[0]['bank_name'];
        $languages      = explode(',',$language);
        
        $ivrBankData = DB::table('ivr_bank_name')->first();

        if ($ivrBankData)
        {
             $gatherCustomerID = $response->gather(['action' => $ivr_url.'/handle_customer_id', 'method' => 'GET']);
             $gatherCustomerID->say('Please enter your customer ID, followed by the pound key.', ['voice' => 'Polly.Danielle-Neural', 'language' => 'en-US']);
            
        }
        else{
  
          

         $enabledLanguages = DB::table('language_control')
         ->where('status', 1)
         ->whereIn('language', ['English', 'Spanish', 'German', 'Italian'])
         ->pluck('language');



$response->say(
    'Welcome to our automated telephone banking system at ' . $default_bank . '. ' .
    'We have made banking easy through our accurate telephone support system, ' .
    'making banking by phone more convenient than ever. ' .
    'You can now access your accounts to check your balance, ' .
    'or your most recent transaction history.',
    [
        'voice' => 'Polly.Danielle-Neural',
        'language' => 'en-US'
    ]
);








       $gather = $response->gather([
    'action' => $ivr_url.'/handle-language-input',
    'method' => 'GET',
    'numDigits' => 1,
    'timeout' => 7
]);


         foreach ($enabledLanguages as $lang) {
    if ($lang == 'English') {
        $gather->say('If you will like to continue this call in english please press 1', ['voice' => 'Polly.Danielle-Neural', 'language' => 'en-US']);
    }
    if ($lang == 'Spanish') {
        $gather->say('Si desea hablar en español, presione 2', ['voice' => 'Polly.Lupe', 'language' => 'es-US']);
    }
    if ($lang == 'German') {
        $gather->say('Wenn Sie auf DEUTSCH sprechen möchten, drücken Sie 3', ['voice' => 'Polly.Vicki', 'language' => 'de-DE']);
    }
    if ($lang == 'Italian') {
        $gather->say('Se vuoi parlare in ITALIANO, premi 4', ['voice' => 'Polly.Carla', 'language' => 'it-IT']);
    }
}

        
        }
        
        $response->say("Sorry, I didn't get your response", ['voice' => 'Polly.Danielle-Neural', 'language' => 'en-US']);
        
        return response((string)$response,200)->header('Content-Type','text/xml');
        
    }

    public function handle_customer_id(Request $request){
        
        
        $Settings       = Config::get();
        $ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
         
        $language       = $Settings[0]['ivr_lang'];
        $default_bank = $Settings[0]['bank_name'];
        $languages      = explode(',',$language);

    
        $response = new VoiceResponse();

        $LanguageController = new IvrLanguageController();
        $input              = $request->all();

        $enteredCustomerID = $input['Digits'] ?? null;

        $xxt = DB::table('ba_account_holders')->where('customer_id', $enteredCustomerID)->first();

        // Reject deleted customers (soft-deleted rows are flagged with df = 'yes')
        if ($xxt && $xxt->df == 'yes') {
            $response->say('Invalid customer ID', ['voice' => 'Polly.Danielle-Neural','language' => 'en-US']);
            $response->hangup();
            return response((string)$response,200)->header('Content-Type','text/xml');
        }

        if ($xxt) {
        $ivrBankData = DB::table('ivr_bank_name')->where('customer_id', $enteredCustomerID)->first();      
        
        if ($ivrBankData) {
            $customerBankName = $ivrBankData->bank_name;
        } else {
            $customerBankName = $default_bank;
        }
        
        session(['enteredCustomerID' => $enteredCustomerID]);
        
        $enabledLanguages = DB::table('language_control')
         ->where('status', 1)
         ->whereIn('language', ['English', 'Spanish', 'German', 'Italian'])
         ->pluck('language');



$response->say(
    'Welcome to our automated telephone banking system at ' . $default_bank . '. ' .
    'We have made banking easy through our accurate telephone support system, ' .
    'making banking by phone more convenient than ever. ' .
    'You can now access your accounts to check your balance, ' .
    'or your most recent transaction history.',
    [
        'voice' => 'Polly.Danielle-Neural',
        'language' => 'en-US'
    ]
);






$gather = $response->gather([
    'action' => $ivr_url.'/handle-language-input',
    'method' => 'GET',
    'numDigits' => 1,
    'timeout' => 2
]);

         foreach ($enabledLanguages as $lang) {
    if ($lang == 'English') {
        $gather->say('If you will like to continue this call in english please press 1', ['voice' => 'Polly.Danielle-Neural', 'language' => 'en-US']);
    }
    if ($lang == 'Spanish') {
        $gather->say('Si desea hablar en español, presione 2', ['voice' => 'Polly.Lupe', 'language' => 'es-US']);
    }
    if ($lang == 'German') {
        $gather->say('Wenn Sie auf DEUTSCH sprechen möchten, drücken Sie 3', ['voice' => 'Polly.Vicki', 'language' => 'de-DE']);
    }
    if ($lang == 'Italian') {
        $gather->say('Se vuoi parlare in ITALIANO, premi 4', ['voice' => 'Polly.Carla', 'language' => 'it-IT']);
    }
}
        
        } else {
      
            $gather = $response->gather(['action' => $ivr_url.'/handle_customer_id', 'method' => 'GET','finishOnKey'=>'#']);
            $gather->say('Invalid customer ID', ['voice' => 'Polly.Danielle-Neural','language' => 'en-US']);
            $gather->say('Please re-enter customer ID', ['voice' => 'Polly.Danielle-Neural','language' => 'en-US']);
            $response->say($LanguageController->index('en','dontGetResponse'), ['voice' => 'Polly.Danielle-Neural','language' => 'en-US']);    

        }
        
        return response((string)$response,200)->header('Content-Type','text/xml');
        
 }
    
    public function handle_language_input(Request $request){
        
        $response           = new VoiceResponse();  
        $LanguageController = new IvrLanguageController();
        $input              = $request->all();  

        $access_onoff = DB::select('select * from configs');
    

        $ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;

       $selectedOption = $input['Digits'] ?? null;

       
            
        if($selectedOption == 1){ $language = 'en-US'; }
        else if($selectedOption == 2){ $language = 'es-ES'; }
        else if($selectedOption == 3){ $language = 'de-DE'; }
        else if($selectedOption == 4){ $language = 'it-IT'; }

        else{ $language = 'en-US'; }
                
        for ($i=1; $i<=3; $i++) {


            if($access_onoff[0]->access_token_status==1)
            {
                $gather = $response->gather(['action' => $ivr_url.'/access_token/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
                $gather->say('Please enter your Access Token', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            
                $response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);

            }
            else
            {
                $gather = $response->gather(['action' => $ivr_url.'/handle-input/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
                
                 $gather->say('To continue, please select from the following options.',
    ['voice' => 'Polly.Danielle-Neural', 'language' => $language]
);

                
                $gather->say($LanguageController->index($language,'handle1'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $gather->say($LanguageController->index($language,'handle2'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $gather->say($LanguageController->index($language, 'handlex3'), ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
                $gather->say($LanguageController->index($language, 'handlex4'), ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
                
                $response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'Polly.Danielle-Neural','language' => $language]); 

            }
            
            
        }
        $response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $response->hangup();
        
        return response((string)$response,200)->header('Content-Type','text/xml');
    
    }


    public function access_token($language,Request $request){
        
        $response           = new VoiceResponse();  
        $LanguageController = new IvrLanguageController();
        $input              = $request->all();  
        $selectedOption = $input['Digits'] ?? null;
        $a_token =  $selectedOption;
        $Access_token      = DB::table('access_token')->where('token', $a_token);
        $token_status= DB::table('access_token')->where('token', $a_token)->get();
        $ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;


        
        
        if($Access_token->exists()){    
            
            if($token_status[0]->status==1)
            {
            for ($i=1; $i<=3; $i++) {
            
                $gather = $response->gather(['action' => $ivr_url.'/handle-input/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
                $gather->say($LanguageController->index($language,'handle1'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $gather->say($LanguageController->index($language,'handle2'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'Polly.Danielle-Neural','language' => $language]); 
            }
            $response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->hangup();
            }
            else
            {
                
                
                    $gather = $response->gather(['action' => $ivr_url.'/access_token/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
                    $gather->say($token_status[0]->msg, ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                    
                        
            }
        }else{      
            for ($i=1; $i<=3; $i++) {
                
            $gather = $response->gather(['action' => $ivr_url.'/access_token/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
            $gather->say('The Access token is invalid', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $gather->say('Please re-enter your Access Token', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'Polly.Danielle-Neural','language' => $language]); 
            }
            $response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);         
        }
        return response((string)$response,200)->header('Content-Type','text/xml');
    }
    
    public function handle_input($language,Request $request){
        \Log::info('Entered Customer ID: hello dear');
        $response           = new VoiceResponse();  
        $LanguageController = new IvrLanguageController();
        $Settings            = Config::get();
        $input              = $request->all();  
        $selectedOption = $input['Digits'] ?? null;
        $ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
        if($selectedOption == 1){
$enteredCustomerID = session('enteredCustomerID');
\Log::info('Entered Customer ID: ' . $enteredCustomerID);
if ($enteredCustomerID) {
     $response->redirect($ivr_url.'/customerID-login/'.$language, ['method' => 'GET']);
            return response((string)$response,200)->header('Content-Type','text/xml');

} else {
    for ($i = 1; $i <= 3; $i++) {
        $gather = $response->gather(['action' => $ivr_url.'/customerID-login/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
        $gather->say($LanguageController->index($language,'handle3'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    }

    $response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    $response->hangup();
}

        }elseif($selectedOption == 2){

                $response->say($LanguageController->index($language,'handle4'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);         
                $gather = $response->gather(['action' => $ivr_url.'/handle-input-mapped/'.$language, 'method' => 'GET','finishOnKey'=>'#','numDigits'=>4]);
                $gather->say($LanguageController->index($language,'handle5').$Settings[0]['bank_name'], ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $gather->say($LanguageController->index($language,'handle6'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                
                if($Settings[0]['admin_support_phone']!=''){
                                                
                    $response->say($LanguageController->index($language,'handle7'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                    $response->say($LanguageController->index($language,'handle8'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                    $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                    $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);     
                    $response->dial($Settings[0]['admin_support_phone']);
                }else{
                    $response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                }
                $response->hangup();
            
        }elseif($selectedOption == 3){
    // New Account / Products & Services menu
    $response->say($LanguageController->index($language, 'main3_intro'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    $gather = $response->gather(['action' => $ivr_url.'/handle-products/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
    $gather->say($LanguageController->index($language, 'main3_opt1'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    $gather->say($LanguageController->index($language, 'main3_opt2'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    $gather->say($LanguageController->index($language, 'main3_opt0'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    return response((string)$response,200)->header('Content-Type','text/xml');

}elseif($selectedOption == 4){
    // Loan & Cargo Deposit Menu
    $response->say($LanguageController->index($language, 'main4_intro'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    $gather = $response->gather(['action' => $ivr_url.'/handle-loans/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
    $gather->say($LanguageController->index($language, 'main4_opt1'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    $gather->say($LanguageController->index($language, 'main4_opt2'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    $gather->say($LanguageController->index($language, 'main4_opt0'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    return response((string)$response,200)->header('Content-Type','text/xml');
}
else{
                    
                $this->handle_not_get_response($language,$response);    
        }
        
        return response((string)$response,200)->header('Content-Type','text/xml');
    
    }
  
  
  public function handle_products($language, Request $request)
{
    $response           = new \Twilio\TwiML\VoiceResponse();  
    $LanguageController = new IvrLanguageController();
    $input              = $request->all();  
    $selectedOption     = $input['Digits'] ?? null;
    $ivrs               = \App\Config::get();
    $ivr_url            = $ivrs[0]->ivr_url;

    // Main products & services submenu
    if ($selectedOption == 1) {
        // Product information submenu
        $response->say($LanguageController->index($language, 'main3_sub_intro'), ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
        $gather = $response->gather(['action' => $ivr_url.'/handle-product-info/'.$language, 'method' => 'GET', 'finishOnKey' => '#']);
        $gather->say($LanguageController->index($language, 'main3_sub_opt1'), ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
        $gather->say($LanguageController->index($language, 'main3_sub_opt2'), ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
        $gather->say($LanguageController->index($language, 'main3_sub_opt3'), ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
        $gather->say($LanguageController->index($language, 'main3_sub_opt0'), ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
    } 
    elseif ($selectedOption == 2) {
        // Connect to customer service
        $response->say('Please hold while we connect your call to customer service.', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $Settings = \App\Config::get();
        if ($Settings[0]['admin_support_phone'] != '') {
            $response->dial($Settings[0]['admin_support_phone']);
        }
        $response->say('Thank you for speaking with us. You are now being returned to the main menu.', ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
        $response->redirect($ivr_url.'/handle-language-input');
    } 
    elseif ($selectedOption == 0) {
        // Return to main menu
        $response->say('Please hold while we take you back to the main menu.', ['voice' => 'Polly.Danielle-Neural', 'language' => $language]);
        $response->redirect($ivr_url.'/handle-language-input', ['method' => 'GET']);

    } 
    else {
        $response->say('Invalid input. Please try again.', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $response->redirect($ivr_url.'/handle-input/'.$language);
    }

    return response((string)$response,200)->header('Content-Type','text/xml');
}


public function handle_product_info($language, Request $request)
{
    $response           = new \Twilio\TwiML\VoiceResponse();  
    $LanguageController = new IvrLanguageController();
    $input              = $request->all();  
    $selectedOption     = $input['Digits'] ?? null;
    $ivrs               = \App\Config::get();
    $ivr_url            = $ivrs[0]->ivr_url;

    switch ($selectedOption) {
        case 1:
            // Savings Info
            $response->say($LanguageController->index($language, 'main3_savings'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            break;
        case 2:
            // Loans Info
            $response->say($LanguageController->index($language, 'main3_loans'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            break;
        case 3:
            // Investments Info
            $response->say($LanguageController->index($language, 'main3_investments'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            break;
        case 0:
            // Return to Products menu
           $response->redirect($ivr_url.'/handle-language-input', ['method' => 'GET']);

            break;
        default:
            $response->say('Invalid input. Please try again.', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->redirect($ivr_url.'/handle-products/'.$language);
            break;
    }

    return response((string)$response,200)->header('Content-Type','text/xml');
}


public function handle_loans($language, Request $request)
{
    $response           = new \Twilio\TwiML\VoiceResponse();  
    $LanguageController = new IvrLanguageController();
    $input              = $request->all();  
    $selectedOption     = $input['Digits'] ?? null;
    $ivrs               = \App\Config::get();
    $ivr_url            = $ivrs[0]->ivr_url;

    if ($selectedOption == 1) {
        // Loan & repayment info
        $response->say($LanguageController->index($language, 'main4_loans'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $gather = $response->gather(['action' => $ivr_url.'/handle-loan-repayment/'.$language, 'method' => 'GET', 'finishOnKey'=>'#']);
        $gather->say($LanguageController->index($language, 'main4_loans_opt1'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $gather->say($LanguageController->index($language, 'main4_loans_opt2'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $gather->say($LanguageController->index($language, 'main4_loans_opt0'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
    } 
   elseif ($selectedOption == 2) {
    // Cargo deposit menu
    $response->say(
        $LanguageController->index($language, 'main4_cargo'),
        ['voice' => 'Polly.Danielle-Neural', 'language' => $language]
    );

    // Wait for user input (press 0 to return)
    $gather = $response->gather([
        'action' => $ivr_url.'/handle-loans/'.$language,
        'method' => 'GET',
        'numDigits' => 1,
        'timeout' => 6
    ]);

    $gather->say('To return to the previous menu, press 0.', [
        'voice' => 'Polly.Danielle-Neural',
        'language' => $language
    ]);

    return response((string)$response,200)->header('Content-Type','text/xml');
}

    elseif ($selectedOption == 0) {
       $response->redirect($ivr_url.'/handle-language-input', ['method' => 'GET']);

    } 
    else {
        $response->say('Invalid input. Please try again.', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $response->redirect($ivr_url.'/handle-input/'.$language);
    }

    return response((string)$response,200)->header('Content-Type','text/xml');
}


public function handle_loan_repayment($language, Request $request)
{
    $response           = new \Twilio\TwiML\VoiceResponse();  
    $LanguageController = new IvrLanguageController();
    $input              = $request->all();  
    $selectedOption     = $input['Digits'] ?? null;
    $ivrs               = \App\Config::get();
    $ivr_url            = $ivrs[0]->ivr_url;

    switch ($selectedOption) {
        case 1:
            $response->say($LanguageController->index($language, 'main4_balance'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            break;
        case 2:
            $response->say($LanguageController->index($language, 'main4_repayment'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            break;
        case 0:
          $response->redirect($ivr_url.'/handle-language-input', ['method' => 'GET']);

            break;
        default:
            $response->say('Invalid input. Please try again.', ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->redirect($ivr_url.'/handle-loans/'.$language);
            break;
    }

    return response((string)$response,200)->header('Content-Type','text/xml');
}

  
  
        
    public function handle_input_mapped($language,Request $request){
        
        $response           = new VoiceResponse();  
        $LanguageController = new IvrLanguageController();
        $input              = $request->all();  
        $selectedOption = $input['Digits'] ?? null;
        $SupportNumbers     = Ivr_Support_number::where('ext_number',$selectedOption)->get();
         $ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;

        
        if($SupportNumbers->count()){
    
            $response->say($LanguageController->index($language,'handle8'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);         
            $response->dial($SupportNumbers[0]['support_number']);
            $response->hangup();                
        }else{
            
            $response->say($LanguageController->index($language,'handle_map'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            for ($i=1; $i<=2; $i++) {
                
                $gather = $response->gather(['action' => $ivr_url.'/handle-input-mapped-1/'.$language, 'method' => 'GET','finishOnKey'=>'#']);
                $gather->say($LanguageController->index($language,'handle_map2'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $response->say($LanguageController->index($language,'dontGetResponse'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            }
            $response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'Polly.Danielle-Neural','language' => $language]); 
            $response->hangup();    
        }
        return response((string)$response,200)->header('Content-Type','text/xml');
        
    }
    
    public function handle_input_mapped_1($language,Request $request){
        
        $response           = new VoiceResponse();  
        $LanguageController = new IvrLanguageController();
        $input              = $request->all();  
        $selectedOption = $input['Digits'] ?? null;
        $SupportNumbers     = Ivr_Support_number::where('ext_number',$selectedOption)->get();
        $Settings           = Config::get();

        
        if($SupportNumbers->count()){
    
            $response->say($LanguageController->index($language,'handle8'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);         
            $response->dial($SupportNumbers[0]['support_number']);
            $response->hangup();                
        }else{
            
            if($Settings[0]['admin_support_phone']!=''){
                                                
                $response->say($LanguageController->index($language,'handle7'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $response->say($LanguageController->index($language,'handle8'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
                $response->say($LanguageController->index($language,'handle9'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);         
                $response->dial($Settings[0]['admin_support_phone']);
            }else{
                $response->say($LanguageController->index($language,'ExceedLimit'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
            }
            $response->hangup();
        }
        return response((string)$response,200)->header('Content-Type','text/xml');
        
    }
    
    public function handle_not_get_response($language,$response){
        
        $LanguageController = new IvrLanguageController();
        $ivrs       = Config::get();
        $ivr_url = $ivrs[0]->ivr_url;
        
        $gather = $response->gather(['action' => $ivr_url.'/handle-input', 'method' => 'GET','finishOnKey'=>'#']);
        $gather->say($LanguageController->index($language,'invalidInput'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $gather->say($LanguageController->index($language,'handle1'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        $gather->say($LanguageController->index($language,'handle2'), ['voice' => 'Polly.Danielle-Neural','language' => $language]);
        return response((string)$response,200)->header('Content-Type','text/xml');
        
    }
 
    public function ivr_status(Request $request){
        
        $input              = $request->all();
        
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
        

        CallLog::where('callerid',$input['CallSid'])->update($dataArray);
        
        echo 'done'; exit;
    }
        
    public function ivr_fail(Request $request){
        
        $response           = new VoiceResponse();  
        $response->say('Sorry for any inconvenience, system temporarily down for maintenance reason please try again after some time. Thank you', ['voice' => 'Polly.Danielle-Neural','language' =>'en-US']);
        return response((string)$response,200)->header('Content-Type','text/xml');
        
    }
        
}