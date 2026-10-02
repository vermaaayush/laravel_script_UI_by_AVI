<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use URL;

class Login extends Controller
{
    
    public function __construct() {
	    $config = DB::table('configs')->where('id','1')->first();
	    if($config->licence_key != "" || $config->licence_key != NULL){
    	    $domain = str_replace("http://","",str_replace("https://","",str_replace("/admin","",URL::to('/'))));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/check_purchase_key_with_domain");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,"key=".$config->licence_key."&domain=".$domain);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $coderanita = curl_exec($ch);
            curl_close($ch);
            if(json_decode($coderanita)->status == "500"){
    	        flash('Purchase Key is not valid.')->error();
                redirect()->route('purchase-key')->send();
    	    }
	    }else{
	        flash('Purchase Key is not valid.')->error();
            redirect()->route('purchase-key')->send();
	    }
	}
    
    function index() {
    	return view('login');
    }

    public function loginUser(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        $users = DB::select('select * from admin where username = ? && password = ?',[$username,$password]);

        if(isset($users[0]->id)) {
        	$request->session()->put('user_id', $users[0]->id);
        	$request->session()->put('name', $users[0]->username);
        	$request->session()->put('username', $users[0]->username);

        	return redirect()->intended('dashboard');
        }
        else {
            flash('Plese check your credentials')->error();
        	return redirect()->intended('login');
        }
    }

    public function logoutUser(Request $request) {
    	$request->session()->forget('user_id');
    	$request->session()->forget('name');
    	$request->session()->forget('username');

    	flash('Logout Successfull')->success();
    	return redirect()->intended('login');
    }
    
    
}
