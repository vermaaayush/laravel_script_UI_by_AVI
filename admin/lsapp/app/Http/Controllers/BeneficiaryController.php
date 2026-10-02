<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Ivr_Msg;
use App\Ba_beneficiary;
use App\BaAccountHolders;

class BeneficiaryController extends Controller
{
	
	
	public function __construct() {
	    $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
        $this->module = 'support';
        
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
	
     public function view_beneficary() {
       
         $Ba_beneficiary = Ba_beneficiary::with('users')->get();
       
        return view('telephone_banking.ivr_beneficary_management',compact('Ba_beneficiary'));
    }
    
    public function add_beneficary() {
        
        $users = BaAccountHolders::get();
        
        return view('telephone_banking.ivr_add_beneficary',compact('users'));
    }
     public function store_beneficary(Request $request) {
    
       	 request()->validate([
            'beneficiary_added_by_user_id' => 'required',
            'beneficiary_name' => 'required',
            'beneficiary_address' => 'required',
            'beneficiary_sort_code' => 'required',
            'beneficiary_swift' => 'required',
            'beneficiary_iban' => 'required',
            'beneficiary_account' => 'required',
            'beneficiary_bank_name' => 'required',
            'beneficiary_bank_address' => 'required',
            'beneficiary_country' => 'required'

        ]);
       
            
              $Ba_beneficiary = new Ba_beneficiary;
               
            $Ba_beneficiary->beneficiary_added_by_user_id = $request->beneficiary_added_by_user_id;
            $Ba_beneficiary->beneficiary_name = $request->beneficiary_name;
            $Ba_beneficiary->beneficiary_address = $request->beneficiary_address;
            $Ba_beneficiary->beneficiary_sort_code = $request->beneficiary_sort_code;
            $Ba_beneficiary->beneficiary_swift = $request->beneficiary_swift;
            $Ba_beneficiary->beneficiary_iban = $request->beneficiary_iban;
            $Ba_beneficiary->beneficiary_account = $request->beneficiary_account;
            $Ba_beneficiary->beneficiary_bank_name = $request->beneficiary_bank_name;
            $Ba_beneficiary->beneficiary_bank_address = $request->beneficiary_bank_address;
            $Ba_beneficiary->beneficiary_country = $request->beneficiary_country;
            $Ba_beneficiary->verification = 1;

            $Ba_beneficiary->save();

           flash('Beneficiary has been saved succesfully')->success();
         return redirect()->intended('view-beneficiary');
       
      
       
    }
    
    public function edit_Beneficiary($id){
       
       	  $Ba_beneficiary = Ba_beneficiary::find($id);
       	  $users = BaAccountHolders::get();
       	
        return view('telephone_banking.ivr_edit_beneficary',compact('Ba_beneficiary','users'));
	    
    }
      public function update_beneficary(Request $request){
       	//dd($request->all());
       	request()->validate([
            'beneficiary_added_by_user_id' => 'required',
            'beneficiary_name' => 'required',
            'beneficiary_address' => 'required',
            'beneficiary_sort_code' => 'required',
            'beneficiary_swift' => 'required',
            'beneficiary_iban' => 'required',
            'beneficiary_account' => 'required',
            'beneficiary_bank_name' => 'required',
            'beneficiary_bank_address' => 'required',
            'beneficiary_country' => 'required'

        ]);

       	$id = $request->id;

         $beneficiary_added_by_user_id = $request->beneficiary_added_by_user_id;
        // dd($beneficiary_added_by_user_id);
			$beneficiary_name = $request->beneficiary_name;
			$beneficiary_address = $request->beneficiary_address;
			$beneficiary_sort_code = $request->beneficiary_sort_code;
			$beneficiary_swift = $request->beneficiary_swift;
			$beneficiary_iban = $request->beneficiary_iban;
			$beneficiary_account = $request->beneficiary_account;
			$beneficiary_bank_name = $request->beneficiary_bank_name;
			$beneficiary_bank_address = $request->beneficiary_bank_address;
			$beneficiary_country = $request->beneficiary_country;

			  DB::table('ba_beneficiary')->where('id', $id)
		                ->update([
		                'beneficiary_added_by_user_id' => $beneficiary_added_by_user_id,
		                'beneficiary_name' => $beneficiary_name,
		                'beneficiary_address' => $beneficiary_address,
		                'beneficiary_sort_code' => $beneficiary_sort_code,
		                'beneficiary_swift' => $beneficiary_swift,
		                'beneficiary_iban' => $beneficiary_iban,
		                'beneficiary_account' => $beneficiary_account,
		                'beneficiary_bank_name' => $beneficiary_bank_name,
		                'beneficiary_bank_address' => $beneficiary_bank_address,
		                'beneficiary_country' => $beneficiary_country,
                    ]);

			  
         flash('Beneficiary has been updated succesfully')->success();
         return redirect()->intended('view-beneficiary');
	    
    }
    
    public function del_beneficary($id){
       
	    	 $del = Ba_beneficiary::find($id);
	     $del->delete();
	     flash('Beneficiary has been deleted succesfully')->success();
         return redirect()->back();
	     
    }

   
}
