<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Mail;
use App\Ivr_Msg;
use App\BaAccountHolders;
use App\Ivr_token;
use App\EmailEditor;


class EmailController extends Controller
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

	 public function email_editor() {
        
    	return view('telephone_banking.email_editor');
    }

     public function email_restriction() {

         $EmailEditor =  EmailEditor::get();
        return view('telephone_banking.email_restriction', compact('EmailEditor'));

    }
    public function email_restrtion(Request $request) {
     
        foreach ($request->type as $key => $val) {

             EmailEditor::where('type', $key)
                        ->update([

                        'verification' => $val,
                        
                    ]);

        }
        
       flash('Restrictions has been added succesfully')->success();
     return redirect()->intended('email-restriction');

    }
    
    public function search_strings_email(Request $request){
		
	 if($request->ajax())
     {
     
		  $type	= $request->type;
	 
		     $EmailEditor = EmailEditor::where('type', $type)->first();
		       $magic_str = $EmailEditor->magic_str;
            
             return response()->json(['data' => $magic_str]);
              
		}
	
         
     }
    
    public function add_email(Request $request){

             request()->validate([
            'type' => 'required',
            'email' => 'required',
            'name' => 'required',
        ]);

          $EmailEditor = new EmailEditor;
               
            $EmailEditor->name = $request->name;
            $EmailEditor->email = $request->email;
            $EmailEditor->type = $request->type;
               
            $EmailEditor->save();

           flash('Email has been saved succesfully')->success();
         return redirect()->intended('email-list');

    }

     public function view_email() {

        $email = EmailEditor::latest()->get();
        return view('telephone_banking.view_email', compact('email'));
    }

      public function edit_email($id){
      
          $EmailEditor = EmailEditor::find($id);
         
        return view('telephone_banking.edit_email',compact('EmailEditor'));
        
    }
    public function update_email(Request $request){
        //dd($request->all());
        request()->validate([
           'type' => 'required',
            'email' => 'required',
            'name' => 'required'

        ]);

        $id = $request->id;

            $name = $request->name;
            $type = $request->type;
            $email = $request->email;

              EmailEditor::where('id', $id)
                        ->update([
                         'name' => $name,
                        'type' => $type,
                        'email' => $email,
                    ]);

              
         flash('Email has been updated succesfully')->success();
         return redirect()->intended('email-list');
        
    }

    
    
    

   
}
