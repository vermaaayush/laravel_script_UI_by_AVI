<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use URL;
use Illuminate\Support\Facades\Http;


class Dashboard extends Controller
{
	public function __construct() {
	    $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
	    
	    $config = DB::table('configs')->where('id','1')->first();
        if(config('app.env') !== 'local') {
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
	}
	
	public function savePurchaseKey(Request $rec){
	    $domain = str_replace("http://","",str_replace("https://","",str_replace("/admin","",URL::to('/'))));
	    
	    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/check_purchase_key_with_domain");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"key=".$rec->key."&domain=".$domain);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $coderanita = curl_exec($ch);
        curl_close($ch);
	    
	    if(json_decode($coderanita)->status == "200"){
	        DB::table('configs')->where('id','1')->update(['licence_key' => $rec->key]);
	        return redirect()->intended('login');
	    }else{
	        flash('Purchase Key is not valid.')->error();
            return redirect()->intended('purchase-key')->withInput();
	    }
	}
	
	public function addPurchaseKey(){
	    return view('purchase-key');
	}
	
	public function protection_one(Request $request) {
       
        $pin = $request->input('pin');
       
        
        
        $pass = DB::select('select * from extra_passwords where id = 1');

        if($pin==$pass[0]->password) {
            
        

            return redirect()->intended('clear-table');
        }
        else {
            flash('Plese check your password')->error();
            return redirect()->intended('dashboard');
        }
       
    }
    
    
    	public function protection_two(Request $request) {
       
        $pin = $request->input('pin');
       
        
        
        $pass = DB::select('select * from extra_passwords where id = 2');

        if($pin==$pass[0]->password) {
            
        

            return redirect()->intended('sms-editor');
        }
        else {
            flash('Plese check your password')->error();
            return redirect()->intended('dashboard');
        }
       
    }

    public function index() {
        $logout_time = DB::table('configs')->where('id','1')->first()->logout_time;
    	$customers = DB::select('select count(*) as cnt from ba_account_holders where df = "no"');
    	$accounts = DB::select('select count(*) as cnt from ba_user_accounts where access = "1"');
    	//$transactions = DB::select('select A.*, ba_account_holders.cust_name, ba_account_holders.middle_name, ba_account_holders.sur_name, ba_account_holders.cust_photo, (SELECT B.act_number FROM ba_transactions B WHERE B.tran_id=A.tran_id && B.type = "debited") as from_account, (SELECT C.act_number FROM ba_transactions C WHERE C.tran_id=A.tran_id && C.type = "credited") as to_account from ba_transactions A inner join ba_user_accounts on A.act_number=ba_user_accounts.account_no inner join ba_account_holders on ba_user_accounts.user_id=ba_account_holders.user_id order by A.datetime DESC LIMIT 20');
    	$userActivities = DB::table('ba_user_activities')->orderby('id','desc')->limit(20)->get();
        $loanRequest = DB::table('ba_loans')->orderby('id','desc')->limit(5)->get();
        $cardRequest = DB::table('ba_cards')->orderby('id','desc')->limit(5)->get();
        $deposit = DB::table('ba_user_deposit')->where('approved','0')->limit(5)->get();
        $withdraw = DB::table('ba_user_withdrawal2')->where('approved','0')->limit(5)->get();
        $feedback = DB::table('ba_feedback')->orderby('id','desc')->limit(5)->get();
        $transfers = DB::table('ba_transfers_temp')->orderby('id','desc')->limit(5)->get();
    	$getAcHoldersList = DB::table('ba_account_holders')->get();
    	$usersOnline = 0;
    	foreach($getAcHoldersList as $AcHolder){ if(strtotime('-'.$logout_time.' minutes') < strtotime($AcHolder->login_time)){ $usersOnline++; } }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://bank.coderanita.com/api/get_card_pricing");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $card_pricing = curl_exec($ch);
        curl_close($ch);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://blockchain.info/tobtc?currency=USD&value=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $dollerRate = curl_exec($ch);
        curl_close($ch);
        
    	$data = array(
    		'customersCount'    => $customers[0]->cnt,
    		'accountsCount'     => $accounts[0]->cnt,
    		'userActivities'    => $userActivities,
    		'usersOnline'   => $usersOnline,
    		'loans'         => $loanRequest,
    		'cards'         => $cardRequest,
    		'deposit'       => $deposit,
    		'withdraw'      => $withdraw,
    		'cardpricing'   => $card_pricing,
    		'dollerRate'    => $dollerRate,
    		'feedback'      => $feedback,
    		'transfers'     => $transfers
    	);
    	return view('dashboard', ['data' => $data]);
    }

    public function activityLog(Request $request) {
        $customers = DB::select('select * from ba_account_holders WHERE 1 order by datetime DESC LIMIT 50');
        $accounts = DB::select('select * from ba_user_accounts WHERE 1 order by timestamp DESC LIMIT 50');
        $cards = DB::select('select * from ba_cards WHERE 1 order by date DESC LIMIT 50');
        $transactions = DB::select('select * from ba_transactions WHERE 1 order by datetime DESC LIMIT 50');

        $data = array();
        foreach($customers as $customer) {
            $data[] = array(
                'id' => $customer->id,
                'time' => date("H:i", strtotime($customer->datetime)),
                'date' => date("M d, Y", strtotime($customer->datetime)),
                'activity' => 'Customer Added',
                'description' => $customer->cust_name . " " . $customer->middle_name . " " . $customer->sur_name,
                'datetime' => $customer->datetime
            );
        }

        foreach($accounts as $account) {
            $data[] = array(
                'id' => $account->id,
                'time' => date("H:i", strtotime($account->timestamp)),
                'date' => date("M d, Y", strtotime($account->timestamp)),
                'activity' => 'Account Added',
                'description' => 'Account Number: ' . $account->account_no,
                'datetime' => $account->timestamp
            );
        }

        foreach($cards as $card) {
            $data[] = array(
                'id' => $card->id,
                'time' => date("H:i", strtotime($card->date)),
                'date' => date("M d, Y", strtotime($card->date)),
                'activity' => 'Card Added',
                'description' => 'Card Number: ' . $card->card_number . ' in Account Number: ' . $card->cust_act_number,
                'datetime' => $card->date
            );
        }

        foreach($transactions as $transaction) {
            $data[] = array(
                'id' => $transaction->id,
                'time' => date("H:i", strtotime($transaction->datetime)),
                'date' => date("M d, Y", strtotime($transaction->datetime)),
                'activity' => ucwords($transaction->type),
                'description' => $transaction->reason . " Account Number: " . $transaction->act_number,
                'datetime' => $transaction->datetime
            );
        }

        usort($data, 'self::date_compare');
        $data = array_slice($data, 0, 20);

        return view('activity-log', ['data' => $data]);
    }

    public function date_compare($a, $b) {
        $t1 = strtotime($a['datetime']);
        $t2 = strtotime($b['datetime']);
        return $t2 - $t1;
    }  

    public function systemConfig(Request $request) {
        //echo $_SERVER['DOCUMENT_ROOT'];exit;
        //echo date_default_timezone_get();exit;
        $timezones = DB::select('select * from timezones');
        $config = DB::select('select * from configs WHERE 1');
          $ivr_message = DB::select('select * from ivr_management');
          
        return view('system-config', ['timezones' => $timezones,
        'ivr_message' => $ivr_message,'config' => $config]);
    } 
    
    
    public function updateModuleConfig(Request $request) {
        if($request->transfer){ $transfer = '1'; }else{ $transfer = '0'; } 
        if($request->cheque){ $cheque = '1'; }else{ $cheque = '0'; } 
        if($request->cards){ $cards = '1'; }else{ $cards = '0'; } 
        if($request->loans){ $loans = '1'; }else{ $loans = '0'; } 
        if($request->payment_collection){ $payment_collection = '1'; }else{ $payment_collection = '0'; } 
        if($request->account_limit){ $account_limit = '1'; }else{ $account_limit = '0'; } 
        if($request->withdraw){ $withdraw = '1'; }else{ $withdraw = '0'; } 
        if($request->feedback){ $feedback = '1'; }else{ $feedback = '0'; } 
        if($request->system_config){ $system_config = '1'; }else{ $system_config = '0'; } 
        if($request->transaction){ $transaction = '1'; }else{ $transaction = '0'; } 
        if($request->deposit){ $deposit = '1'; }else{ $deposit = '0'; } 
        
        $data = [
            'transfer'              => $transfer,
            'cheque'                => $cheque,
            'cards'                 => $cards,
            'loans'                 => $loans,
            'payment_collection'    => $payment_collection,
            'account_limit'         => $account_limit,
            'withdraw'              => $withdraw,
            'feedback'              => $feedback,
            'system_config'         => $system_config,
            'transaction'           => $transaction,
            'deposit'               => $deposit
        ];
        DB::table('ba_enable_disable_module')->where('id','1')->update($data);
        
        flash('Config updated successfully!')->success();
        return redirect()->intended('system-config');
    }
    
    
    public function updateConfig(Request $request) {
        $allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp');
        $destinationPath = 'uploads';

        $query = "";
       
        foreach($request->input() as $key => $input) {
            if($key == '_token' || $key == 'type') {
                continue;
            }
            
            $$key = $input;
            if($query == "") {
                $query = "$key = '$input'";
            }
            else {
                $query .= ", $key = '$input'";
            }
        }

        if($request->input('type') == 1) {
            if(empty($request->input('client_side'))) {
                if(!empty($query)) {
                    $query .= ", client_side = 0";
                }
                else {
                    $query = "client_side = 0";
                }
            }
        }

        if($request->input('type') == 2) {
            if(empty($request->input('user_management'))) {
                if(!empty($query)) {
                    $query .= ", user_management = 0";
                }
                else {
                    $query = "user_management = 0";
                }
            }

            if(empty($request->input('account'))) {
                if(!empty($query)) {
                    $query .= ", account = 0";
                }
                else {
                    $query = "account = 0";
                }
            }

            if(empty($request->input('account_limit'))) {
                if(!empty($query)) {
                    $query .= ", account_limit = 0";
                }
                else {
                    $query = "account_limit = 0";
                }
            }

            if(empty($request->input('branches'))) {
                if(!empty($query)) {
                    $query .= ", branches = 0";
                }
                else {
                    $query = "branches = 0";
                }
            }

            if(empty($request->input('support_message'))) {
                if(!empty($query)) {
                    $query .= ", support_message = 0";
                }
                else {
                    $query = "support_message = 0";
                }
            }

            if(empty($request->input('telephone_banking'))) {
                if(!empty($query)) {
                    $query .= ", telephone_banking = 0";
                }
                else {
                    $query = "telephone_banking = 0";
                }
            }
        }

        if($request->input('type') == 3) {
            if(empty($request->input('email_action'))) {
                if(!empty($query)) {
                    $query .= ", email_action = 0";
                }
                else {
                    $query = "email_action = 0";
                }
            }

            if(empty($request->input('sms_action'))) {
                if(!empty($query)) {
                    $query .= ", sms_action = 0";
                }
                else {
                    $query = "sms_action = 0";
                }
            }
        }

        DB::update("update configs set " . $query . " where 1");

        $logo = $request->file('logo');
        if(!empty($logo) && !empty($logo_path = $logo->getRealPath()) && !empty($logo_name = $logo->getClientOriginalName())) {
            $logo_ext = $logo->getClientOriginalExtension();
            $logo_type = $logo->getMimeType();

            if(!in_array($logo_type, $allowed_types)) {
                flash('Please upload allowed file type in Logo')->error();
                return redirect()->intended('system-config');
            }
        }  

       
        if(!empty($logo_name)) {
            $logo_name = md5(time()).$logo_name;
            $logo->move($destinationPath,$logo_name);

            DB::update('update configs SET logo = ? where 1',[$logo_name]);
        }

        flash('Config updated successfully!')->success();
        return redirect()->intended('system-config');
    } 
    public function updatelang(Request $request){
       // dd('Allah');
         if( $request->input('ivr_lang')) {
                 $ivr_lang = $request->input('ivr_lang');
                 $ivr_lang = implode(",",$ivr_lang);
                
                 $data = $ivr_lang;
                // DB::update("update configs set " . $query . " where 1");
                 DB::update('update configs SET ivr_lang = ? where 1',[$data]);
                  flash('Config updated successfully!')->success();
                   return redirect()->intended('system-config');
                
            }
    }

    public function updatePassword(Request $request) {
        $pass = $request->input('pass');
        $new_pass = $request->input('new_pass');
        $confirm_pass = $request->input('confirm_pass');

        if(!empty($pass) && !empty($new_pass) && !empty($confirm_pass)) {
            $admin = DB::select('select password from admin');
            if($admin[0]->password === $pass) {
                if($new_pass === $confirm_pass) {
                    DB::update("update admin set password = ?",[$new_pass]);

                    flash('Password updated successfully!')->success();
                    return redirect()->intended('system-config');
                }
                else {
                    flash('New Password and Confirm Password does not match')->error();
                    return redirect()->intended('system-config');
                }
            }
            else {
                flash('Current Password does not match')->error();
                return redirect()->intended('system-config');
            }
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('system-config');
        }
    } 

    public function resetDefaultConfig(Request $request) {
        DB::update("UPDATE configs SET bank_name = 'Name', bank_address = 'Address', bank_phone = '0000000000',admin_support_phone ='123456789', bank_email = 'bank@email.com', timezone = 1, logo = 'default_logo.png', sms_token = NULL, sms_sid = NULL, sms_phone = NULL, email_token = NULL, email_sid = NULL, email_phone = NULL, client_side_color = 'Purple', admin_side_color = 'Purple', client_side_lang = 'ENGLISH', client_side = 1, user_management = 1, account = 1, account_limit = 1, branches = 1, support_message = 1, telephone_banking = 1, email_action = 1, sms_action = 1");

        DB::delete('delete from ba_account_holders WHERE 1');
        DB::delete('delete from ba_user_accounts WHERE 1');
        DB::delete('delete from ba_transactions WHERE 1');
        DB::delete('delete from ba_cards WHERE 1');

        flash('Reset Successful')->success();
        return redirect()->intended('system-config');
    } 
    
    /* Clear Table */
    public function clearTable(){
        $tables_in_db = DB::select('SHOW TABLES');
        
        return view('clearTable',['tables_in_db'=>$tables_in_db]);
    }
    public function clear(Request $request){
        
        $table = $request->table_name;
        // DB::raw('TRUNCATE  TABLE ?',[$table]);
        $a= DB::table($table)->truncate();
        flash($table.' is Now Emptied.')->error();
        return redirect()->intended('clear-table');
        
    }
    
    /* Backup Settings */

    /* Clear Table */
    public function getBackup(){
        $tables_in_db = DB::select('SHOW TABLES');
        return view('backup',['tables_in_db'=>$tables_in_db]);
    }
  
  
     public function add_currency(){
    
        return view('add_currency');
    }
  
  public function  add_now_currency(Request $request){
    
        DB::table('currencies')->insert([
        'currency' => $request->c_icon,
        'currency_name' => $request->c_name,
       
      ]);
    
        return redirect('/currency_manage');
    }
  

  
    public function edit_currency($id){
      
      
       $currencies = DB::table('currencies')->where('id', $id)->get(); 
    
 
       return view('edit_currency',['currencies'=>$currencies]);
    }

    public function update_currency(Request $request){
      
      $id= $request->id;
       $updateData = [
        'currency' => $request->c_icon,
        'currency_name' => $request->c_name,
    
        ];

     DB::table('currencies')->where('id', $id)->update($updateData);
    
 
       return redirect('/currency_manage');
    }
  
  
    public function view_currency(){
      $currencies = DB::table('currencies')->get();
 
       return view('currency_manage',['currencies'=>$currencies]);
    }
  
    public function currency_manage(){
      $currencies = DB::table('currencies')->get();
 
       return view('currency_manage',['currencies'=>$currencies]);
    }
    
    public function cloudflare_control(){
      
 
       return view('cloudflare_control');
    }
    
  
    public function delete_currency($id){
       DB::table('currencies')->where('id', $id)->delete();
 
        return redirect('/currency_manage');
    }
  
  
  



public function crypto_deposit()
    {
       
       
     $datas = DB::table('transactions')
            ->where('subject', 'Funds Deposit')
            ->orderByDesc('created_at')
            ->get();

        return view('crypto_deposit', compact('datas'));
        
      
    }
    
    
  
   public function trs_history()
    {
       
  
     $datas = DB::table('transactions')
            ->orderBy('created_at', 'desc')
            ->get();


    
        return view('trs_history', compact('datas'));
        
      
    }
  
  
      public function all_send_tranx()
    {
       
  
      $datas = DB::table('transactions')
            ->where('subject', 'Fund Transfer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('all_send_tranx', compact('datas'));
        
      
    }
    
    
      
      public function usdt_wallet_info()
    {
       
  
      $datas = DB::table('wallets')
            ->where('currency', 'usdttrc20')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('usdt_wallet_info', compact('datas'));
        
      
    }
    
    public function wallet_finder(Request $request)
    {
        $address = $request->address;
       $wallet = DB::table('wallets')
            ->where('address', $address)
            ->first();

        if ($wallet) {
            
            
            $data = [
                'currency' => $wallet->currency,
                'user_id' => $wallet->user_id,
                'created_at' => $wallet->created_at,
                'address' => $address,
               
            ];
        
              
        }
        else
        {
           $allWallet = DB::table('all_wallets')
               ->where('address', $address)
               ->first();

            
            if ($allWallet) {
               
                $data = [
                    'currency' => $allWallet->currency,
                    'user_id' => $allWallet->user_id,
                    'created_at' => $allWallet->created_at,
                    'address' => $address,
                   
                ];
            


            } else {
                // If not found in both tables, return not found response
                return response()->json([
                    
                    'message' => 'Address not found in either table.'
                ]);
            }
        }

        $u_info = DB::table('ba_account_holders')->where('user_id', $data['user_id'])->first();

// Get transactions related to the address
$transactions = DB::table('transactions')
                  ->where('sent_from', $address)
                  ->orderBy('created_at', 'desc')
                  ->get();

    

        return view('wallet_finder', compact('data','u_info','transactions'));
        



    }
    
    
    public function send_req_manger(Request $request, $id)
    {
        $config = DB::table('configs')->where('id','1')->first();
        // return $request->action;
       $tranx = DB::table('transactions')->find($id);
$user = DB::table('ba_account_holders')->where('user_id', $tranx->user_id)->first();


        if ($request->action == 'approve') {
            if ($request->hash_id) {
                
               DB::table('transactions')
    ->where('id', $tranx->id)
    ->update([
        'tr_id' => $request->hash_id,
        'status' => 'Debit',
    ]);


                

                $subject = 'Funds Transfer Confirmation: Amount Successfully Debited';

                $email = $user->cust_mail; // Get the user's email
                $name = $user->cust_name; // Get the user's name
        
              
              $body = view('emails.sending', [
    'subject' => $subject,
    'name' => $name,
    'email' => $email,
    'amount' => $tranx->amount,
    'sent_from' => $tranx->sent_from,
    'sent_to' => $tranx->sent_to,
    'transaction_id' => $tranx->tr_id, // Assuming 'tr_id' is the field in the transaction table
    'currency' => $tranx->currency,
])->render();

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: ' .   $config->bank_name . ' <' .  $config->bank_email . '>' . "\r\n";  // Adjust 'From' header

// Send email using PHP's mail() function
Mail::send([], [], function ($message) use ($email, $subject, $body) {
    $message->to($email)
            ->subject($subject)
            ->setBody($body, 'text/html');
});

                return redirect('all_send_tranx');
            }   
            
            
        }
        else
        {
            DB::table('transactions')
    ->where('id', $tranx->id)
    ->update(['status' => 'Reject']);


            if ($tranx->currency == 'btc') {

                try {
                    // Fetch the BTC to USD price
                    $response = Http::get('https://www.blockonomics.co/api/price?currency=USD');
                
                    if ($response->successful()) {
                        $btcPrice = $response->json()['price']; // Price in USD for 1 BTC
                    } else {
                        throw new \Exception('Failed to fetch BTC price.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error fetching BTC price: ' . $e->getMessage());
                    $btcPrice = 0; // Default to 0 if API call fails
                }

$usdAmount = $tranx->amount;

if ($tranx->currency == 'btc') {
    $btcEquivalent = $usdAmount / $btcPrice;
    DB::table('ba_account_holders')
        ->where('user_id', $user->user_id)
        ->increment('btc_fund', $btcEquivalent); // Add BTC equivalent to user's balance
} elseif ($tranx->currency == 'eth') {
    DB::table('ba_account_holders')
        ->where('user_id', $user->user_id)
        ->increment('eth_fund', $tranx->amount); // Add ETH amount to user's balance
} elseif ($tranx->currency == 'usdttrc20') {
    DB::table('ba_account_holders')
        ->where('user_id', $user->user_id)
        ->increment('usdt_fund', $tranx->amount); // Add USDT amount to user's balance
}


            return redirect('all_send_tranx');


            //now price wapas kerna h and email kerna h 
        }
  
       
        
      
    }
    
    
    }
  
    
  
   
    public function backup(Request $request){
        // dd($request);
        $mysqlHostName = '127.0.0.1';
        $mysqlUserName = 'aaxqchat_DB1';
        $mysqlPassword = 'aaxqchat_DB1';
        $DbName = 'aaxqchat_DB1';
        $backup_name = 'database_backup_on_' . date('Y-m-d H:i:s') . '.sql';
        $tables = $request->table_name; 
        
        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();
        
        $output = '';
        foreach($tables as $table)
        {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            
            $statement->execute();
            $show_table_result = $statement->fetchAll();
            
            foreach($show_table_result as $show_table_row)
            {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();
            
            for($count=0; $count<$total_row; $count++)
            {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }
        
        $file_handle = fopen($backup_name, 'w+');
        
        fwrite($file_handle, $output);
        fclose($file_handle);
        $type = 'File Transfer';
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backup_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
           header('Pragma: public');
           header('Content-Length: ' . filesize($backup_name));
        ob_clean();
        flush();
        readfile($backup_name);
        unlink($backup_name);   
           
        // flash('Backup Completed.')->success();
        // return redirect()->intended('get-backup')
        //     ->withHeaders([
        //         'Content-Type'=> $type,
        //         'Content-Type'=> 'application/octet-stream',
        //         'Content-Type' => 'attachment; filename=' . basename($backup_name),
        //         'Content-Transfer-Encoding' => 'binary',
        //         'Cache-Control' => 'must-revalidate',
        //         'Pragma' => 'public',
        //         'Content-Length' => filesize($backup_name)
                
        //         ]);
        
    }
    
    /* Backup Settings */
    
    
    
    public function generateWallet(Request $request)
{
    $order_id = 'RGDBP-' . strtoupper(uniqid());
    $pay_currency = $request->currency;
    $order_description = $request->currency;

    // Prepare the payload for the NowPayments API
    $data = [
        'price_amount' => 25, // You can dynamically set this if needed
        'price_currency' => 'usd',
        'pay_currency' => $pay_currency, // Set the dynamic currency
        'ipn_callback_url' => 'https://ibank.firstallianzgroup.com/online/test-ipn', // Your IPN callback route
        'order_id' => $order_id, // Dynamic random order ID
        'order_description' => $order_description, // Modified order description
        'is_fixed_rate' => true,
        'is_fee_paid_by_user' => false,
    ];

    // Make the POST request to NowPayments API
    $response = Http::withHeaders([
        'x-api-key' => 'JPFWKZC-FJB4X50-KBHD0H8-3CFJ79D', // Replace with your actual API key
        'Content-Type' => 'application/json',
    ])->post('https://api.nowpayments.io/v1/payment', $data);

    // Check for a successful response
    if ($response->successful()) {
        $payAddress = $response->json()['pay_address'];
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($payAddress);

        Log::info('Generated Pay Address: ' . $payAddress);


DB::table('all_wallets')->insert([
    'user_id' => $request->user_id,
    'currency' => $request->currency,
    'address' => $payAddress,
    'qr' => $qrCodeUrl,
    'created_at' => now(),  // Assuming you want to set the created_at timestamp
    'updated_at' => now()   // Assuming you want to set the updated_at timestamp
]);



        // Check if a wallet already exists for the user and currency
        $wallet = DB::table('wallets')
            ->where('user_id', $request->user_id)
            ->where('currency', $request->currency)
            ->first();

        if ($wallet) {
            // Update the existing wallet
            DB::table('wallets')
                ->where('id', $wallet->id)
                ->update([
                    'address' => $payAddress,
                    'qr' => $qrCodeUrl,
                    'updated_at' => now()
                ]);
        } else {
            // Insert a new wallet if none exists
            DB::table('wallets')->insert([
                'user_id'  => $request->user_id,
                'currency' => $request->currency,
                'address'  => $payAddress,
                'qr'       => $qrCodeUrl, // Save QR Code URL
                'created_at' => now(), // Adds timestamp
                'updated_at' => now()
            ]);
        }

        // Set currency display name
        $currencyName = $request->currency === 'usdttrc20' ? 'USDT' : $request->currency;

        return response()->json([
            'success' => true,
            'data' => [
                'currency' => $currencyName, // Include the currency
                'address' => $payAddress, // Include the address
                'qr' => $qrCodeUrl, // Include QR code URL
            ],
        ]);
    } else {
        // Handle the error case
        return response()->json([
            'success' => false,
            'message' => 'Failed to create payment on NowPayments',
        ], $response->status());
    }
}

  public function btcGenerateWallet(Request $request)
    {

        $api_key = env('BLOCKONOMICS_API_KEY', 'MIbDHPaDSIXPF5sGfpR2VCWNs0AFh6aMezIwjinmGg0');
        $url = 'https://www.blockonomics.co/api/new_address';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $headers = [
            "Authorization: Bearer " . $api_key,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $contents = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }

        $responseObj = json_decode($contents);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status == 200) {

            $payAddress = $responseObj->address; // Get the address from the response

            // Generate QR Code URL
            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($payAddress);

            // Log the generated address
            Log::info('Generated Pay Address: ' . $payAddress);

            // Save to the Wallet model
           DB::table('wallets')->insert([
    'user_id'  => $request->user_id,
    'currency' => 'btc',
    'address'  => $payAddress,
    'qr'       => $qrCodeUrl, // Save QR Code URL
    'created_at' => now(), // Add timestamp
    'updated_at' => now()
]);


            return response()->json([
                'success' => true,
                'data' => [
                    'pay_address' => $payAddress,
                    'qr_code_url' => $qrCodeUrl,
                ],
            ], 200);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate BTC address from Blockonomics',
            ], $status);
        }

    }
    
    
    
    



public function regenerateWallet(Request $request)
    {

        $order_id = 'RGDBP-' . strtoupper(uniqid());
        $pay_currency = $request->currency;
        $order_description = $request->currency;
        // Prepare the payload for the NowPayments API

        $data = [
            'price_amount' => 25, // You can dynamically set this if needed
            'price_currency' => 'usd',
            'pay_currency' => $pay_currency, // Set the dynamic currency
            'ipn_callback_url' => 'https://ibank.firstallianzgroup.com/online/nowpayment/ipn-callback', // Your IPN callback route
            'order_id' => $order_id, // Dynamic random order ID
            'order_description' => $order_description, // Modified order description
            'is_fixed_rate' => true,
            'is_fee_paid_by_user' => false,
        ];

        // Make the POST request to NowPayments API using Laravel's Http Client
        $response = Http::withHeaders([
            'x-api-key' => 'JPFWKZC-FJB4X50-KBHD0H8-3CFJ79D', // Replace with your actual API key
            'Content-Type' => 'application/json',
        ])->post('https://api.nowpayments.io/v1/payment', $data);

        // Check for a successful response
        if ($response->successful()) {

            $payAddress = $response->json()['pay_address'];

            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($payAddress);

            Log::info('Generated Pay Address: ' . $payAddress);

          DB::table('wallets')->insert([
    'user_id'  => $request->user_id,
    'currency' => $request->currency,
    'address'  => $payAddress,
    'qr'       => $qrCodeUrl,
    'created_at' => now(), // Adds timestamp
    'updated_at' => now()
]);


            return response()->json([
                'success' => true,
                'data' => $response->json(),
            ]);
        } else {
            // Handle the error case here
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment on NowPayments',
            ], $response->status());
        }
    }   
    
}
