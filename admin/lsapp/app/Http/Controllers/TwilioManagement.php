<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Config;
use App\Ivr_message;
use App\ivr_purchase_numbers;
use App\Ivr_Support_number;

class TwilioManagement extends Controller
{
	
 
public function view_number(){

    
		$numbers = ivr_purchase_numbers::get();
		
		return view('telephone_banking.twilio_numbers',compact('numbers'));	
		
}

public function puchase_form(){

    return view('telephone_banking.view_purchase_form');
}

public function search_form(Request $request){
	
	 if($request->ajax())
     {

      if($request->countryCode != '' && $request->phonetype != '')
      {	


      		$countryCode	= $request->countryCode;
      		$phonetype	= $request->phonetype;

			$Settings = Config::get();
			$sid    = $Settings[0]['twilio_sid'];
			$token  = $Settings[0]['twilio_token'];
			$twilio = new Client($sid, $token);
			
	
			if (!empty($sid) && !empty($token)) {
					if($phonetype=='simple'){

			$available_phone_number = $twilio->availablePhoneNumbers($countryCode)->local->read([], 20);
			                                        											
			 
			}else{
													 
			$available_phone_number = $twilio->availablePhoneNumbers($countryCode)
			                   ->tollFree
			                   ->read([], 20);	
			   
			}
			
				 $output = '';
      	 		 $total_row = '';
			foreach ($available_phone_number as $record) {
				
      				 $output .= '
			        <tr>
						 <td>'.$record->phoneNumber.'</td>         
			          	 <td> <a class="btn btn-primary" 
				          	 	href="'.url('/twilio-purchase/'.$record->phoneNumber).'"<i class="fa fa-external-link-square">
				          	 	</i> Purchase Number
			          	 	</a>
			          	 </td>
			        </tr> ';
			        
       
      			}
			
			return response()->json(['data' => $output]);
		}else{
				 flash('Twilio Token and Sid is invalid')->error();
			}

      }
     
     }
	
}

public function purchase_number($phoneNumber){
	
	$Settings = Config::get();
	$sid    = $Settings[0]['twilio_sid'];
	$token  = $Settings[0]['twilio_token'];
	$twilio = new Client($sid, $token);
	$url = $Settings[0]['ivr_url'].'/ivr/';
	$statusurl = $Settings[0]['ivr_url'].'/ivr-status/' ;
	$failurl = $Settings[0]['ivr_url'].'/ivr-fail/';


	if  (!empty($sid) && !empty($token))  {
		$incoming_phone_number = $twilio->incomingPhoneNumbers
                                ->create(["phoneNumber" => $phoneNumber,"voiceUrl" => $url,"statusCallback"=>$statusurl,"statusCallbackMethod"=>'GET',"voiceFallbackMethod"=>'GET',"voiceFallbackUrl"=>$failurl
								]);
								
	$RegDetails = ivr_purchase_numbers::create(

		['phone_number' => $phoneNumber,

		'url' => $url, 

		'sid' => $incoming_phone_number->sid,
		]);	
		flash('Number has been added succesfully!')->success();		
		return redirect()->route('twilio-number');
	}else{
		flash('Twilio token and Sid is invalid')->error();		
		return redirect()->route('twilio-number');
	}
		
			
				

}

 public function delete_number($id){
	
	$numbers = ivr_purchase_numbers::where('id', $id)->get();
	$delsid = $numbers[0]['sid'];
		
	$Settings = Config::get();
	$sid    = $Settings[0]['twilio_sid'];
	$token  = $Settings[0]['twilio_token'];
	$twilio = new Client($sid, $token);
	
	if  (!empty($sid) && !empty($token)) {
	/*	$TwilioDel = $twilio->incomingPhoneNumbers($delsid)
       ->delete();*/
	    
	 
	 $delNumber = ivr_purchase_numbers::find($id);
	 $delNumber->delete();
	
		 flash('Number has been deleted succesfully')->success();
		 return redirect()->intended('twilio-number');
     	
	}else{
		flash('Twilio token and Sid is invalid')->error();		
		return redirect()->route('twilio-number');
	}

}

   
}
