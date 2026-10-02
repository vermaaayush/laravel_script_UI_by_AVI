<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\Ivr_Msg;
use App\BaTransactions;
use App\BaAccountHolders;
use App\User_Withdrawl;
use App\BaUserAccounts;
use App\Http\Controllers\PayKassaAPI;
use App\SmsEditor;
use App\EmailEditor;
use URL;

use Illuminate\Support\Facades\Auth;
use App\Helpers\Utility;

class WithdrawalAdminContrlr extends Controller
{
    
     public function __construct() {
       $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
        $config = DB::select('select bank_name,logo, bank_email, sms_token, sms_sid, sms_phone from configs where 1');
        
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
    
	
    public function view_withdrawls(Request $request) {
        $withdrawls = DB::table('ba_user_withdrawal2')->where('approved','0')->orderby('id','asc')->get();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_setting");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://blockchain.info/tobtc?currency=USD&value=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dollerRate = curl_exec($ch);
        curl_close($ch);
        
        $bitConinId = json_decode($coderanita)->bitwallet;
        
        return view('withdraw.new-withdraws',compact('withdrawls','dollerRate','bitConinId'));
    }
    
    public function approved_withdrawls(Request $request) {
        $withdrawls = DB::table('ba_user_withdrawal2')->where('approved','2')->orderby('id','asc')->limit(150)->get();
        return view('withdraw.approved-withdraws',compact('withdrawls'));
    }
    
    public function rejected_withdrawls(Request $request) {
        $withdrawls = DB::table('ba_user_withdrawal2')->where('approved','3')->orderby('id','asc')->limit(150)->get();
        return view('withdraw.rejected-withdraws',compact('withdrawls'));
    }
    
    public function awaiting_withdrawls(Request $request) {
        $withdrawls = DB::table('ba_user_withdrawal2')->where('approved','1')->orderby('id','asc')->limit(150)->get();
        return view('withdraw.awaiting-withdraws',compact('withdrawls'));
    }
    
    public function withdrawl_approve(Request $request){
        $id         = $request->id;
        $dollerRate = $request->btcRate;
        DB::table('ba_user_withdrawal2')->where('id',$id)->update(['approved' => '1','bitamount' => $dollerRate]);
        $with = DB::table('ba_user_withdrawal2')->where('id',$id)->first();
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/withdraw");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"bank=".$this->bankName."&with_id=".$id."&amount=".$with->amount."&comission=".$with->comission."&withtype=".$with->withtype."&url=".URL::to('/')."&withdate=".$with->date_of_with."&withid=".$with->withid."&bitrate=".$dollerRate."&hash=".$request->hash);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        
        flash('Withdraw Approved')->success();
    	return redirect()->intended('user-withdrawal');
    } 
    
    public function withdrawl_reject($id){
        DB::table('ba_user_withdrawal2')->where('id',$id)->update(['approved' => '3']);
        $with = DB::table('ba_user_withdrawal2')->where('id',$id)->first();
        $customer = DB::table('ba_account_holders')->where('user_id',$with->user)->first();
        $account = DB::table('ba_user_accounts')->where('id',$with->account)->first();
        $msg = "Hello ".$customer->cust_name." ".$customer->middle_name." ".$customer->sur_name." your withdraw request for ".$account->account_currency." ".$with->amount." made on ".date('d F, Y',strtotime($with->date_of_with))." has been rejected.";
        Mail::raw($msg, function($message) use ($customer)
        {
            $message->from($this->fromEmail);

            $message->subject('Withdraw Request Rejected');

            $message->to($customer->cust_mail);
        });
        flash('Withdraw Rejected')->success();
    	return redirect()->intended('user-withdrawal');
    } 
    
    public function withdrawl_reject_code($id){
        DB::table('ba_user_withdrawal2')->where('id',$id)->update(['approved' => '3']);
        $with = DB::table('ba_user_withdrawal2')->where('id',$id)->first();
        $customer = DB::table('ba_account_holders')->where('user_id',$with->user)->first();
        $account = DB::table('ba_user_accounts')->where('id',$with->account)->first();
        $currency = $account->account_currency;
        $data = date('d F, Y',strtotime($with->date_of_with));
        $amount = $with->amount;
        $account_no = $account->account_no;
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$with->user]);
        
        $EmailEditor = EmailEditor::where('type', 'withdraw_rejected')->first();
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $email = $EmailEditor->email;
        $name = $EmailEditor->name;
        $config = DB::select('select * from configs WHERE id = ?',[1]);
        $logo_link = "https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
        $final_email ='<img src='.$logo_link.' alt="banking
        " style="display:block;margin-left:78
        0px;width:14%;" />';
        //replacing strings
        $final_email .= str_replace('[first_name]', $customername, $email);
        $final_email = str_replace('[account_currency]', $currency, $final_email);
        $final_email = str_replace('[amount]', $amount, $final_email);
        $final_email = str_replace('[account_no]', $account_no, $final_email);
        $final_email = str_replace('[date]', $data, $final_email);
        // verify email and send
        $final_email .= '<p>
        Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
        If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
        
        $subject = $name;
        $body = "<html><head></head><body>";
        $body .= $final_email;
        $body .= "</body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $this->bankName . ' <'. $this->fromEmail .'>' . "\r\n";
       Mail::send([], [], function ($message) use ($user, $subject, $body) {
    $message->to($user[0]->cust_mail)
            ->subject($subject)
            ->setBody($body, 'text/html');
});
    } 
    
    public function withdrawl_update_code($id,$amount){
        DB::table('ba_user_withdrawal2')->where('id',$id)->update(['amount' => $amount]);
    }
    
    public function withdrawl_approve_code($id,$amount){
        DB::table('ba_user_withdrawal2')->where('id',$id)->update(['approved' => '2']);
        $with = DB::table('ba_user_withdrawal2')->where('id',$id)->first();
        $customer = DB::table('ba_account_holders')->where('user_id',$with->user)->first();
        $account = DB::table('ba_user_accounts')->where('id',$with->account)->first();
        
        DB::table('ba_user_accounts')->where('id',$account->id)->update(['available_balance' => $account->available_balance - $with->amount]);
        //DB::table('ba_user_accounts')->where('id',$account->id)->update(['available_balance' => $account->available_balance - $amount]);
        
        $currency = $account->account_currency;
        $data = date('d F, Y',strtotime($with->date_of_with));
        $amount = $with->amount;
        $account_no = $account->account_no;
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$with->user]);
        $ins = [
            'user_id'       => $customer->user_id,
            'act_number'    => $account->account_no,
            'type'          => 'debited',
            'balance'       => $account->available_balance - $amount,
            'status'        => "1",
            'amount'        => $amount,
            'tran_id'       => md5(time()),
            'reason'        => "Withdrawal",
            'balance_type'  => 'available_balance',
            'datetime'      => date("Y-m-d H:i:s")
        ];
        DB::table('ba_transactions')->insert($ins);
       
        //email data
        $EmailEditor = EmailEditor::where('type', 'withdraw_approved')->first();
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $email = $EmailEditor->email;
        $name = $EmailEditor->name;
        $config = DB::select('select * from configs WHERE id = ?',[1]);
        $logo_link = "https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
        $final_email ='<img src='.$logo_link.' alt="banking
        " style="display:block;margin-left:78
        0px;width:14%;" />';
        //replacing strings
        $final_email .= str_replace('[first_name]', $customername, $email);
        $final_email = str_replace('[account_currency]', $currency, $final_email);
        $final_email = str_replace('[amount]', $amount, $final_email);
        $final_email = str_replace('[account_no]', $account_no, $final_email);
        $final_email = str_replace('[date]', $data, $final_email);
        // verify email and send
        $final_email .= '<p>
        Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
        If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
        
        $subject = $name;
        $body = "<html><head></head><body>";
        $body .= $final_email;
        $body .= "</body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $this->bankName . ' <'. $this->fromEmail .'>' . "\r\n";
        Mail::send([], [], function ($message) use ($user, $subject, $body) {
    $message->to($user[0]->cust_mail)
            ->subject($subject)
            ->setBody($body, 'text/html');
});
    } 
    
    
    public function search_withdrawls(Request $request){
		
	 if($request->ajax())
     {
     
		  $pay_id	= $request->pay_id;
		
		     $user_withdrawls = User_Withdrawl::where('id', $pay_id)->get();
		    
				 $output = '';
      	 		 $total_row = '';
  				 $total_row = $user_withdrawls->count();
  				  if ($user_withdrawls[0]->pay_method == 1) {
  				  	
  				  	if ($total_row > 0) {
			      
				foreach ($user_withdrawls as $user_withdrawl) {
				 
      				  $output .= '
			        <tr> 
						 <td>'.$user_withdrawl->amount.'</td>
						 <td>'.'Paypal'.'</td>
						 <td>'.$user_withdrawl->transfer_percentage.'</td>  
						  <td> <a class="btn btn-primary btn-sm" 
				          	 	href="'.url('/process-withdrwl/'.$user_withdrawl->id).'"<i class="fa fa-external-link-square">
				          	 	</i> Mark as Complete
			          	 	</a>
			          	 </td>       
			          	
			        </tr> ';
			        
      			}
  				 	
  				 }
  				
			      }else{

			      	 $output = '
				       <tr>
				        <td align="center" colspan="5">No Data Found</td>
				       </tr>
				       ';
			      
			    } 		    
			      return response()->json(['data' => $output]);
            }
	
        }

 public function search_withdrawls_bit(Request $request){
		
	 if($request->ajax())
     {
     
		  $pay_id	= $request->pay_id;
		
		  $user_withdrawls = User_Withdrawl::where('id', $pay_id)->get();
		    
				 $output = '';
      	 		 $total_row = '';
  				 $total_row = $user_withdrawls->count();

			if ($user_withdrawls[0]->pay_method == 0) {
  				  	
  				  	if ($total_row > 0) {
			      
				foreach ($user_withdrawls as $user_withdrawl) {
				 
      				  $output .= '
			        <tr> 
						 <td>'.$user_withdrawl->amount.'</td>
						 <td>'.'Bitcoin'.'</td>
						 <td>'.$user_withdrawl->transfer_percentage.'</td>  
						  <td> <a class="btn btn-primary btn-sm" 
				          	 	href="'.url('/process-withdrwl/'.$user_withdrawl->id).'"<i class="fa fa-external-link-square">
				          	 	</i> Mark as Complete
			          	 	</a>
			          	 </td>       
			          	
			        </tr> ';
			        
      			}
  				 	
  				 }

			      }else{

			      	 $output = '
				       <tr>
				        <td align="center" colspan="5">No Data Found</td>
				       </tr>
				       ';
			      
			    } 		    
			      return response()->json(['data' => $output]);
            }
	
        }

        public function process_withdrawal($id){

        	 	$User_Withdrawl = User_Withdrawl::find($id);

             $amount = $User_Withdrawl->amount;
             $transfer_percentage = $User_Withdrawl->transfer_percentage;
             $grand = $amount + $transfer_percentage;

             $user_id = $User_Withdrawl->user_id;
		     $account_no = $User_Withdrawl->account_no;

 					$super = User_Withdrawl::where('id', $id)
 					->where('user_id',$user_id)
 					->where('account_no', $account_no)->get();

 			/*btc*/		if ($User_Withdrawl->pay_method==0) {
 			
        				$paykassa_api_id = '7603';
			    $paykassa_api_password = 'ptfxeh3XTAq2flS';
			    $paykassa_merchant_id = '7777';

			    $amount = $super[0]->amount;
			      $system = "bitcoin";
				    $currency = 'BTC';
				   $wallet = '16dpyAQ2wLtJkQ3bhs1HjEmPC1cjqNuBEb';
			

				    $comment = 'Payment withdrawl';
				    $paid_commission = '';
				    $tag = '';
				    $real_fee = true; 
				    $priority = "high"; 

							    $paykassa = new PayKassaAPI(
							        $paykassa_api_id,       
							        $paykassa_api_password 	
			    				);

					    			  $system_id = [
				        "advcash" => 4, 
				        "perfectmoney" => 2, 
				        "berty" => 7,  
				        "bitcoin" => 11,     
				        "ethereum" => 12, 
				        "litecoin" => 14, 
				        "dogecoin" => 15,    
				        "dash" => 16,   
				        "bitcoincash" => 18,     
				        "zcash" => 19, 
				        "ripple" => 22,     
				        "tron" => 27,  
				        "stellar" => 28, 
				    ];

								   $res = $paykassa->api_payment(
				        $paykassa_merchant_id,  
				        
				        $system_id[$system],    
				        
				        $wallet,               
				        
				        (float)$amount,         
				        
				        $currency,              
				        
				        $comment,               
				        
				        $paid_commission,      
				        
				        $tag,                   
				        
				        $real_fee,              
				        
				        $priority               
				        
				    );
				    
							if ($res['error'] == 1) {       
			        
			        echo '<pre>';
			        print_r($res);
			        exit;
			        
			         flash($res['message'])->error();
		 return redirect()->intended('user-withdrawal');
			    } else {

			        echo '<pre>';
			        print_r($res);
			        exit;
			        $shop_id = $res['data']['shop_id'];                         
			        
			        $transaction = $res['data']['transaction'];                 
			        $txid = $res['data']['txid'];                               
			        
			        $amount = $res['data']['amount'];                           
			        
			        $amount_pay = $res['data']['amount_pay'];                   
			       
			        $system = $res['data']['system'];                           
			        
			        $currency = $res['data']['currency'];                       
			        
			        $number = $res['data']['number'];                           
			        
			        $comission_percent = $res['data']['shop_comission_percent'];
			        
			        $comission_amount = $res['data']['shop_comission_amount'];  
			        
			        $paid_commission = $res['data']['paid_commission'];         
			        
			    }

        	}
        	/*bit c end*/
             
               	$BaUserAccounts = BaUserAccounts::where('user_id', $user_id)->where('account_no',$account_no)->get();
             
               	 if($BaUserAccounts[0]->available_balance < $grand) {

		            flash('There is no sufficient amount for this transaction')->error();
		            return redirect()->intended('user-withdrawal');
		        }

				$acct_id = $BaUserAccounts[0]->id ; 

		        $debit = $BaUserAccounts[0]->available_balance - $grand ; 

		          BaUserAccounts::where('id', $acct_id)
		          ->where('user_id', $user_id)
		          ->where('account_no',$account_no)
		                ->update([
		               
		                'available_balance' => $debit

                    ]);

		         $tran_id = md5(time());

        $datetime = date("Y-m-d H:i:s");
     
        $token = rand(100000, 999999);
        $step2 = '';
        $step3 = '';
        $step4 = '';

        $options = DB::select('select * from ba_options where user_id = ?', [$user_id]);
      
        if(isset($options[0])) {
            if($options[0]->step2 == 1) {
                $step2 = rand(100000, 999999);
            }

            if($options[0]->step3 == 1) {
                $step3 = rand(100000, 999999);
            }

            if($options[0]->step4 == 1) {
                $step4 = rand(100000, 999999);
            }
        }

          		 $BaTransactions = new BaTransactions;
               
            $BaTransactions->user_id = $user_id;
            $BaTransactions->act_number = $account_no;
            $BaTransactions->type = 'debited';
            $BaTransactions->balance = $debit;
            $BaTransactions->status = '1';
            $BaTransactions->amount = $amount;
            $BaTransactions->tran_id = $tran_id;
            $BaTransactions->step2 = $step2;
            $BaTransactions->step3 = $step3;
            $BaTransactions->step4 = $step4;
            $BaTransactions->reason = 'Cash Withdrawal';
            $BaTransactions->statement = '0';
            $BaTransactions->international = '0';
            $BaTransactions->balance_type = 'available_balance';
            $BaTransactions->datetime = $datetime;

            $BaTransactions->save();

             User_Withdrawl::where('id', $id)
		          ->where('user_id', $user_id)
		          ->where('account_no',$account_no)
		                ->update([
		               
		                'verification' => '1'
                    ]);
		 
         flash('Transaction done Successfully')->success();
		 return redirect()->intended('user-withdrawal');

    }
    
    public function process_decline($id){
        
        $User_Withdrawl = User_Withdrawl::find($id);
        $user_id = $User_Withdrawl->user_id;
        
        $account_no = $User_Withdrawl->account_no;
        
        User_Withdrawl::where('id', $id)
        ->where('user_id', $user_id)
        ->where('account_no',$account_no)
        ->update([
        
        'verification' => '2'
        ]);
        
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        $SmsEditor = SmsEditor::where('type', 'withdrawal_declined')->first();
        $EmailEditor = EmailEditor::where('type', 'withdrawal_declined')->first();
        
        $customername = $user[0]->cust_name.' '.$user[0]->middle_name.' '.$user[0]->sur_name;
        $phone = $customer[0]->cust_countrycode . " " . $customer[0]->cust_phone;
         
        $sms = $SmsEditor->sms;
        $email = $EmailEditor->email;
        $myEmail = $email;
        $name = $EmailEditor->name;
        $config = DB::select('select * from configs WHERE id = ?',[1]);
        $logo_link ="https://".$config[0]->bank_url."/admin/uploads/".$config[0]->logo;
        $final_email ='<img src='.$logo_link.' alt="banking" style="display:block;margin-left:780px;width:14%;" />';
        
        $final_sms = str_replace('[first_name]', $customername, $sms);
        $myString = $sms;
        if(isset($myString)) { 
            $contains = Str::contains($myString, ['[address]','[phone]' ]);
            if($contains) {
            
            $final_sms = str_replace('[address]', $user[0]->cust_address, $final_sms);
           
            $final_sms = str_replace('[phone]', $phone, $final_sms);
            } 
        }
        $final_email .= str_replace('[first_name]', $customername, $email);
        if(isset($myEmail)) {
            $contain = Str::contains($myEmail, ['[address]','[phone]' ]);
            if($contain) {
            
            $final_email .= str_replace('[address]', $user[0]->cust_address, $final_email);
           
            $final_email .= str_replace('[phone]', $phone, $final_email);
            }
        }
        
        $verification = $SmsEditor->verification;
        $verification_email = $EmailEditor->verification;
        
        if( $this->env == 'live' && $user[0]->cust_countrycode && $user[0]->cust_phone) {
            $client = new Client($this->accountSid, $this->authToken);
            $recipients_arr = array($user[0]->cust_countrycode . " " . $user[0]->cust_phone);
            /* $msg = 'Your Withdrawal has been declined';*/
            if($verification == 1){
        
            foreach($recipients_arr as $recipient) {
                $client->messages->create($recipient, 
                ['from' => $this->fromNumber, 'body' => $final_sms] );
        }
        }
        
        if($verification_email == 1) {
        
        $final_email .= '<p>
        Our notification service sent this mail to you using the information you supplied to us when your account was opened. If you wish to limit the notification mails you receive or change the email address(es) in use, please contact  <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a>
        If this notification was received by any other persons other than the intended recipient , please send a mail to: <a href=mailto:'.$config[0]->bank_email.'>'.$config[0]->bank_email.'</a></p>';
        
        $subject = $name;
        $message = $final_email;

        $body = "<html><head></head><body>";
        $body .= $message;
        $body .= "</body></html>";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $this->bankName . ' <'. $this->fromEmail .'>' . "\r\n";
        
Mail::send([], [], function ($message) use ($user, $subject, $body) {
    $message->to($user[0]->cust_mail)
            ->subject($subject)
            ->setBody($body, 'text/html');
});
        }
        
        }
        flash('Declined done Successfully')->success();
        return redirect()->intended('user-withdrawal');
        }

    public function withdraw_methods(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_withdraw_methods");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
        $withdraw_methods = json_decode($coderanita);
        return view('withdraw.withdraw-methods',compact('withdraw_methods'));
    }   
    
    public function withdraw_methods_save(Request $request){
        $data = [
            'name'  => $request->all()['type'],
            'title' => $request->all()['lable']
        ];
        DB::table('ba_withdraw_methods')->insert($data);
        flash('Withdraw Method added successfully!')->success();
    	return redirect()->intended('withdraw-methods');
    }
    
    public function withdraw_methods_update(Request $request){
        $data = [
            'name'  => $request->all()['type'],
            'title' => $request->all()['lable']
        ];
        DB::table('ba_withdraw_methods')->where('id',$request->id)->update($data);
        flash('Withdraw Method updated successfully!')->success();
    	return redirect()->intended('withdraw-methods');
    }
    
    public function withdraw_methods_status($id,$status){
        if($status == "0"){
            DB::table('ba_withdraw_method_endi')->insert(['mid' => $id]);
        }else{
            DB::table('ba_withdraw_method_endi')->where('mid',$id)->delete();
        }
        flash('Withdraw Method status has been Changed')->success();
    	return redirect()->intended('withdraw-methods');
    }
    
    public function withdraw_methods_delete($id){
        DB::table('ba_withdraw_methods')->where('id',$id)->delete();
        flash('Withdraw Method status has been Deleted')->success();
    	return redirect()->intended('withdraw-methods');
    }
}
