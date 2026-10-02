<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Mail;
use App\Ivr_Msg;
use App\BaAccountHolders;
use App\Ivr_token;
use App\SmsEditor;


class SmsController extends Controller
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

	 public function sms_editor() {
        
    	return view('telephone_banking.sms_editor');
    }

     public function sms_restriction() {

         $SmsEditor =  SmsEditor::get();
        return view('telephone_banking.sms_restriction', compact('SmsEditor'));

    }
     public function search_strings(Request $request){
		
	 if($request->ajax())
     {
     
		  $type	= $request->type;
	 
	 
		     $SmsEditor = SmsEditor::where('type', $type)->first();
		       $magic_str = $SmsEditor->magic_str;
            
             return response()->json(['data' => $magic_str]);
              
		}
	
         
     }
    public function sms_restr(Request $request) {
     
        foreach ($request->type as $key => $val) {

             SmsEditor::where('type', $key)
                        ->update([

                        'verification' => $val,
                        
                    ]);

        }
        
       flash('Restrictions has been added succesfully')->success();
     return redirect()->intended('sms-restriction');

    }
    
    
    public function add_sms(Request $request){

             request()->validate([
            'type' => 'required',
            'sms' => 'required',
            'name' => 'required',
        ]);

          $SmsEditor = new SmsEditor;
               
            $SmsEditor->name = $request->name;
            $SmsEditor->sms = $request->sms;
            $SmsEditor->type = $request->type;
               
            $SmsEditor->save();

           flash('Sms has been saved succesfully')->success();
         return redirect()->intended('sms-list');

    }

     public function view_sms() {

        $sms = SmsEditor::latest()->get();
        return view('telephone_banking.view_sms', compact('sms'));
    }

      public function edit_sms($id){
       
          $SmsEditor = SmsEditor::find($id);
         
        return view('telephone_banking.edit_sms',compact('SmsEditor'));
        
    }
    public function update_sms(Request $request){
        //dd($request->all());
        request()->validate([
           'type' => 'required',
            'sms' => 'required',
            'name' => 'required'

        ]);

        $id = $request->id;

            $name = $request->name;
            $type = $request->type;
            $sms = $request->sms;

              SmsEditor::where('id', $id)
                        ->update([
                         'name' => $name,
                        'type' => $type,
                        'sms' => $sms,
                    ]);

              
         flash('Sms has been updated succesfully')->success();
         return redirect()->intended('sms-list');
        
    }

    /* public function del_sms($id){
        
             $del = SmsEditor::find($id);
            
         $del->delete();
         flash('Sms has been deleted succesfully')->success();
         return redirect()->back();
         
    }*/
    
    

   
}
