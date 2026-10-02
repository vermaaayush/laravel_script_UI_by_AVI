<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Config;
use App\Ivr_message;
use App\Ivr_Support_number;

class SupportManagement extends Controller
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

	 public function support_management_view() {
	 	
        $support_numbers = Ivr_Support_number::first()->get();
      	
    	return view('telephone_banking.support_management', compact('support_numbers'));
    }

    public function addNumbers() {
       
        return view('telephone_banking.add_number');
       
    }
    
    public function editnumberz( $id) {

        $sup_numbs = DB::select('select * from ivr_support_numbers WHERE id = ?',[$id]);
        
        return view('telephone_banking.edit_numbs',['sup_numbs'=>$sup_numbs]);
    }
    public function updateSupportNumb(Request $request) {
        
         request()->validate([
            'support_number' => 'required',
            'ext_number' => 'required'
          
        ]);

        $id = $request->input('id');
       
        $support_number = $request->input('support_number');

        $ext_number = $request->input('ext_number');
       
          $customer = DB::update('update ivr_support_numbers set support_number = ?, ext_number = ? WHERE id = ?',[$support_number,$ext_number,$id]);
       
            flash('Data updated successfully');
             return redirect()->intended('support-management');
        
    }
     public function ivr_message(Request $request) {
       
          request()->validate([
            'transfer_message_1' => 'required',
            'transfer_message_2' => 'required',
            'transfer_message_3' => 'required'
          
        ]);

         
        $allow_transfer_message_1 = (isset($_POST['allow_transfer_message_1']) == '1' ? '1' : '0');

        $allow_transfer_message_2 = (isset($_POST['allow_transfer_message_2']) == '1' ? '1' : '0');

        $allow_transfer_message_3 = (isset($_POST['allow_transfer_message_3']) == '1' ? '1' : '0');
        
        $id = $request->id;
 
        $transfer_message_1 = $request->transfer_message_1;
        $transfer_message_2 = $request->transfer_message_2;
        $transfer_message_3 = $request->transfer_message_3;
        $allow_transfer_message_1 = $allow_transfer_message_1;
        $allow_transfer_message_2 = $allow_transfer_message_2;
        $allow_transfer_message_3 = $allow_transfer_message_3; 
       
        $query = Ivr_message::where('id',$id)->update(['transfer_message_1'=>$transfer_message_1 ,
            'transfer_message_2'=>$transfer_message_2 , 'transfer_message_3'=>$transfer_message_3 , 
            'allow_transfer_message_1'=>$allow_transfer_message_1 , 'allow_transfer_message_2'=>$allow_transfer_message_2 , 'allow_transfer_message_3'=>$allow_transfer_message_3 ]);

            flash('Config updated successfully!')->success();
        return redirect()->intended('system-config');
     
    }

     public function addNewnumber(Request $request) {
       
        $support_number = $request->input('support_number');
        $ext_number = $request->input('ext_number');
        
        if(!empty($support_number) && !empty($ext_number) ) {
           
            DB::insert('insert into ivr_support_numbers set support_number = ?, ext_number = ?', [$support_number, $ext_number]);
            flash('New Number added successfully!')->success();
            return redirect()->intended('support-management');
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('add-numbers');
        }
    }
      public function deletenumber(Request $request, $id) {

        $customer = DB::delete('delete from ivr_support_numbers WHERE id = ?',[$id]);
        flash('Number deleted successfully')->success();
        return redirect()->intended('support-management');
    }
 

   
}
