<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Ivr_Msg;
use App\Transfer_suspend;
use App\Ivr_suspend;
use App\BaAccountHolders;
use App\Ivr_token;
use App\Ivr_bank_name;


class Telephonebanking extends Controller
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
	
	 public function view_call_log() {
	 	
    	$call_logs = DB::table('ivr_call_log')->latest()->orderBy('id', 'DESC')->Paginate(8);
    	
    	return view('telephone_banking.view_call_logs', ['call_logs'=>$call_logs]);
    }
     public function ivr_message() {
        
         $Ivr_Msg = Ivr_Msg::latest()->get();
        
        
        return view('telephone_banking.ivr_message_management',compact('Ivr_Msg'));
    }
    
    public function ivr_suspend_msg() {
 
        
        $Ivr_Msg = Ivr_suspend::latest()->get();
        
        return view('telephone_banking.ivr_suspended_msg',compact('Ivr_Msg'));
    }
    
    
    public function transfer_suspend_msg() {
 
        
        $Ivr_Msg = Transfer_suspend::latest()->get();
        
        return view('telephone_banking.transfer_suspend_msg',compact('Ivr_Msg'));
    }
    
    public function overdraft() {
 
        
        $Ivr_Msg = DB::table('ba_account_holders')->where('overdraft',1)->get();

        
        return view('telephone_banking.overdraft',compact('Ivr_Msg'));
    }
  
    public function add_overdraft() {
        
       
        $users = DB::table('ba_account_holders')->where('overdraft','0')->get();
        return view('telephone_banking.add_overdraft',compact('users'));
    }
  
  public function add_overdraft_now(Request $request) {
       
        request()->validate([
            'user_id' => 'required',
         
        ]);
       
        DB::table('ba_account_holders')->where('user_id', $request->user_id)->update(['overdraft' => 1]);
    
         flash('User is added in Overdraft')->success();
         return redirect()->intended('overdraft');

        
       
    }
  
       public function dlt_overdraft($id){
       
     DB::table('ba_account_holders')->where('id', $id)->update(['overdraft' => 0]);
    
         flash('User removed from Overdraft')->success();
        return redirect()->intended('overdraft');
        
     
    }
    
    
    
    public function access_token() {
 
        
        $Ivr_Msg = DB::table('access_token')->get();
        
        return view('telephone_banking.access_token',compact('Ivr_Msg'));
        
        
    }


    public function language_control() {
 
        
        $Ivr_Msg = DB::table('language_control')->get();
        
        return view('telephone_banking.language_control',compact('Ivr_Msg'));
        
        
    }
    
    

    public function add_ivr_message() {
        
        $users = DB::table('ba_account_holders')->get();
        $users = DB::table('ba_account_holders')->where('df','no')->get();
        return view('telephone_banking.ivr_add_message',compact('users'));
    }
    
    public function add_suspend_status() {
        
        $users = DB::table('ba_account_holders')->get();
        $users = DB::table('ba_account_holders')->where('df','no')->get();
        return view('telephone_banking.ivr_add_sus_status',compact('users'));
    }
    
    public function add_access_token() {
        
       
        return view('telephone_banking.add_access_token');
    }
    
    

    
    public function edit_access_token( $id) {

        $a_token = DB::select('select * from access_token WHERE id = ?',[$id]);
        
        return view('telephone_banking.edit_access_token',['a_token'=>$a_token]);
    }
    
     public function add_transfer_status() {
        
        $users = DB::table('ba_account_holders')->get();
        $users = DB::table('ba_account_holders')->where('transfer_control','1')->get();
        return view('telephone_banking.translate_add_status',compact('users'));
    }
    


     public function add_sus_status(Request $request) {
       
        request()->validate([
            'user_id' => 'required',
            'message' => 'required'
           
        ]);
        if (Ivr_suspend::where('user_id', '=', $request->user_id)->exists()) {
                 flash('This user is already exists ')->error();
                 return redirect()->intended('view-suspend-msg');
        }else{
             
                 $Ivr_suspend = new Ivr_suspend;
               
             
                $Ivr_suspend->message = $request->message;
                $Ivr_suspend->user_id = $request->user_id;
                $Ivr_suspend->save();
                
                DB::table('default_status')
              ->where('id', 1)
              ->update(['msg' => $request->message]);
      
         flash('Suspend Status has been inserted succesfully')->success();
         return redirect()->intended('view-suspend-msg');

        }
       
    }
    
    
    
    public function add_trasfer_status(Request $request) {
       
        request()->validate([
            'user_id' => 'required',
            'message' => 'required',
            'heading' => 'required'
           
        ]);
        if (Transfer_suspend::where('user_id', '=', $request->user_id)->exists()) {
                 flash('This user is already exists ')->error();
                 return redirect()->intended('transfer-suspend-msg');
        }else{
             $Transfer_suspend = new Transfer_suspend;
               
             
                $Transfer_suspend->heading = $request->heading;
                $Transfer_suspend->message = $request->message;
                $Transfer_suspend->user_id = $request->user_id;
                $Transfer_suspend->save();
                
                DB::table('default_status')
              ->where('id', 2)
              ->update(['msg' => $request->message]);
      
      
         flash('Transfer Suspend Status has been inserted succesfully')->success();
         return redirect()->intended('transfer-suspend-msg');

        }
       
    }
    
    
    
    public function add_ivr_msg(Request $request) {
       
        request()->validate([
            'user_id' => 'required',
            'message' => 'required'
           
        ]);
        if (Ivr_Msg::where('user_id', '=', $request->user_id)->exists()) {
                 flash('This user is already exists ')->error();
                 return redirect()->intended('view-ivr-message');
        }else{
             $Ivr_Msg = new Ivr_Msg;
               
                $Ivr_Msg->status =  '0';
                 $Ivr_Msg->message = $request->message;
                $Ivr_Msg->user_id = $request->user_id;
                $Ivr_Msg->save();
      
         flash('Message has been inserted succesfully')->success();
         return redirect()->intended('view-ivr-message');

        }
       
    }
    
    public function add_new_token(Request $request) {
       

                $a_token['token'] = $request->token;
                DB::table('access_token')->insert($a_token);
      
         flash('Token has been inserted succesfully')->success();
         return redirect()->intended('access-token');

       
       
    }    
    
     public function update_access_token(Request $request) {
        
       
     
        
        DB::table('access_token')->where('id', $request->id)->update(array('token' => $request->token,'status' => $request->status,'msg' => $request->msg)); 
      
        flash('Token has been updated succesfully')->success();
        return redirect()->intended('access-token');
    }
    

  public function bank_name() {
       
        $Ivr_bank_name = Ivr_bank_name::with('users')->get();
        
        return view('telephone_banking.bank_name',compact('Ivr_bank_name'));
    }

   public function add_bank_name() {
        
        $users = BaAccountHolders::get();
        $users = DB::table('ba_account_holders')->where('df','no')->get();
        return view('telephone_banking.add_bank_name',compact('users'));
    } 

     public function store_bank_name(Request $request) {
    
           DB::table('ivr_bank_name')->insert([
        'customer_id' => $request->input('customer_id'),
        'bank_name' => $request->input('bank_name'),
   
    ]);

           flash('Bank name has been saved succesfully')->success();
           return redirect()->intended('bank_name');

       
            
       
    }

     public function delete_bank_name($id){

     $deltoken = Ivr_bank_name::find($id);
     $deltoken->delete();
    
         flash('Bank name has been deleted succesfully')->success();
         return redirect()->intended('bank_name');
        
     
    }

 public function view_tokens() {
       
         $Ivr_token = Ivr_token::with('users')->get();
        
        return view('telephone_banking.ivr_tokens',compact('Ivr_token'));
    }

    public function add_tokens() {
        
        $users = BaAccountHolders::get();
        $users = DB::table('ba_account_holders')->where('df','no')->get();
        return view('telephone_banking.ivr_add_tokens',compact('users'));
    }

     public function store_token(Request $request) {
    
         request()->validate([
            'user_id' => 'required',
            'code_1' => 'required',
           
            'code_name_1' => 'required',
           
        ]);
            
             if (Ivr_token::where('user_id', '=', $request->user_id)->exists()) {
                 flash('This user is already exists ')->error();
                 return redirect()->intended('add-tokens');
        }else{
            $allow_code_1 = (isset($_POST['allow_code_1']) == '1' ? '1' : '0');
            $allow_code_2 = (isset($_POST['allow_code_2']) == '1' ? '1' : '0');
            $allow_code_3 = (isset($_POST['allow_code_3']) == '1' ? '1' : '0');

        $Ivr_token = new Ivr_token;
               
            $Ivr_token->user_id = $request->user_id;
            $Ivr_token->code_1 = $request->code_1;
            $Ivr_token->code_name_1 = $request->code_name_1;
            $Ivr_token->code_2 = $request->code_2;
            $Ivr_token->code_name_2 = $request->code_name_2;
            $Ivr_token->code_3 = $request->code_3;
            $Ivr_token->code_name_3 = $request->code_name_3;
            $Ivr_token->allow_code_1 = $allow_code_1;
            $Ivr_token->allow_code_2 = $allow_code_2;
            $Ivr_token->allow_code_3 = $allow_code_3;

         $Ivr_token->save();

           flash('tokens has been saved succesfully')->success();
         return redirect()->intended('view-token');

        }
            
       
    }
     public function edit_tokens($id){
       
          $Ivr_token = Ivr_token::find($id);
          $users = BaAccountHolders::get();
            $users = DB::table('ba_account_holders')->where('df','no')->get();
        return view('telephone_banking.ivr_edit_tokens',compact('Ivr_token','users'));
    } 

    public function update_tokens(Request $request){
        
         request()->validate([
           
            'code_1' => 'required',
           
            'code_name_1' => 'required',
           
        ]);

         $allow_code_1 = (isset($_POST['allow_code_1']) == '1' ? '1' : '0');
         $allow_code_2 = (isset($_POST['allow_code_2']) == '1' ? '1' : '0');
         $allow_code_3 = (isset($_POST['allow_code_3']) == '1' ? '1' : '0');
       
    $id = $request->id;

           /* $user_id = $request->user_id;*/
            $code_1 = $request->code_1;
            $code_name_1 = $request->code_name_1;
            
            $code_2 = $request->code_2;
            $code_name_2 = $request->code_name_2;
          
            $code_3 = $request->code_3;
            $code_name_3 = $request->code_name_3;
            $allow_code_1 = $allow_code_1;
            $allow_code_2 = $allow_code_2;
            $allow_code_3 = $allow_code_3;
            

             Ivr_token::where('id', $id)
                        ->update([
                        
                        'code_1' => $code_1,
                        'code_name_1' => $code_name_1,
                        'code_2' => $code_2,
                        'code_name_2' => $code_name_2,
                        'code_3' => $code_3,
                        'code_name_3' => $code_name_3,
                        'allow_code_1' => $allow_code_1,
                        'allow_code_2' => $allow_code_2,
                        'allow_code_3' => $allow_code_3,
                       
                    ]);

              
         flash('Codes has been updated succesfully')->success();
         return redirect()->intended('view-token');
        
    }
    

    public function del_tokens($id){

     $deltoken = Ivr_token::find($id);
     $deltoken->delete();
    
         flash('Code has been deleted succesfully')->success();
         return redirect()->intended('view-token');
        
     
    }

    public function del_ivr_msg($id){
       
     $delmsg = Ivr_Msg::find($id);
     $delmsg->delete();
    
         flash('Message has been deleted succesfully')->success();
         return redirect()->route('ivr-message');
        
     
    }
    
     public function del_sus_status($id){
       
     $delmsg = Ivr_suspend::find($id);
     $delmsg->delete();
    
         flash('Message has been deleted succesfully')->success();
         return redirect()->route('ivr_suspend_msg');
        
     
    }
    
     public function del_tra_status($id){
       
     $delmsg = Transfer_suspend::find($id);
     $delmsg->delete();
    
         flash('Status has been deleted succesfully')->success();
         return redirect()->route('transfer_suspend_msg');
        
     
    }
    
    
     public function delete_access_token($id){
       
     DB::table('access_token')->where('id', $id)->delete();
    
         flash('Status has been deleted succesfully')->success();
         return redirect()->route('access-token');
        
     
    }
    
    
    public function access_token_onoff(Request $request){
       
     DB::table('configs')->update(array('access_token_status' => $request->status)); 
      
        flash('Updated succesfully')->success();
        return redirect()->intended('access-token');
        
     
    }
  
     
     public function language_control_update(Request $request){
       
       foreach ($request->ids as $id) {
        DB::table('language_control')
            ->where('id', $id)
            ->update(['status' => $request->input('status_' . $id)]);
    }

    flash('Updated successfully')->success();
    return redirect()->intended('language_control');
        
     
    }


     public function suspend_status_position(Request $request){
       
     DB::table('configs')->update(array('trans_status_position' => $request->trsf_position)); 
      
        flash('Updated succesfully')->success();
        return redirect()->intended('transfer-suspend-msg');
        
     
    }
    
    

   
}
