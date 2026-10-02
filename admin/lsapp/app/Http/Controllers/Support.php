<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class Support extends Controller
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

    public function createMessage() {
        $customers = DB::select('select id, cust_name, middle_name, sur_name from ba_account_holders order by cust_name, middle_name, sur_name');
        $managers = DB::select('select id, name from ba_am ');
    	return view('create-message', ['module' => $this->module, 'customers' => $customers,'managers'=>$managers]);
    }

    public function sentMessages() {
        $sentMessages = DB::select('select * from msg WHERE sender = ? && type = ? || (type = ?) || (type = ?) order by date desc',[$this->fromEmail, 'email', 'sms', 'push']);
        return view('sent-messages', ['module' => $this->module, 'sentMessages' => $sentMessages]);
    }
    public function receivedMessages() {
        $sentMessages = DB::select('select * from msg where type="email" AND user_id IS NOT NULL ');
        return view('received-messages', ['module' => $this->module, 'sentMessages' => $sentMessages]);
    }

    public function insertEmailMessage(Request $request) {
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        $date = date("Y-m-d");
        $sender = $this->fromEmail;
        $type = 'email';

        if(!empty($email) && !empty($subject) && !empty($message)) {
            DB::insert('insert into msg (type, msg,subject,date,sender,receiver) values(?,?,?,?,?,?)',[$type,$message,$subject,$date,$sender,$email]);

            $to = $email;
            $subject = $subject;

            $body = "<html><head></head><body>";
            $body .= $message;
            $body .= "</body></html>";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $headers .= 'From: ' . $this->bankName . ' <'. $this->fromEmail .'>' . "\r\n";

          Mail::send([], [], function ($message) use ($to, $subject, $body) {
    $message->to($to)
            ->subject($subject)
            ->setBody($body, 'text/html');
});

            flash('Email Sent Successfully')->success();
            return redirect()->intended('sent-messages');
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('create-message');
        }
    }

    public function insertSMSPush(Request $request) {
        $msg_type = $request->input('msg_type');
        $phone = $request->input('phone');
        $message = $request->input('message');
        $audience_type = $request->input('audience_type');
        $customer = $request->input('customer');
        $account_manager = $request->input('account_manager');

    


        $date = date("Y-m-d");
        $type = $msg_type;

        if(!empty($msg_type) && !empty($message)) {
            if($msg_type == 'sms') {
                DB::insert('insert into msg (type,msg,date,receiver,sender) values(?,?,?,?,?)',[$type,$message,$date,$phone,$account_manager]);

                if($this->env == 'live') {
                    $client = new Client($this->accountSid, $this->authToken);
                    $recipients = $phone;
                    $recipients_arr = explode(",", $recipients);
                    foreach($recipients_arr as $recipient) {
                        $client->messages->create($recipient, 
                        ['from' => $this->fromNumber, 'body' => $message] );
                    }
                }  

                flash('SMS Sent Successfully')->success();
                return redirect()->intended('sent-messages');
            }

            if($msg_type == 'push') {
                if($audience_type == 'all') {
                    $msgData = array(
                        'type' => $type,
                        'msg' => $message,
                        'date' => $date,
                        'sender'=>$account_manager,
                        'receiver' => $audience_type
                    );
                    $msg_id = DB::table('msg')->insertGetId($msgData);
                    $customers = DB::select('select id from ba_account_holders');
                    foreach($customers as $cust) {
                        DB::insert('insert into notifications (msg_id,customer) values(?,?)',[$msg_id,$cust->id]);
                    }
                }
                else {
                     
                    $customer_str = implode(",", $customer);
                    $customer_data = DB::select('select user_id from ba_account_holders where id =?',[$customer_str ]);
                    $msgData = array(
                        'type' => $type,
                        'msg' => $message,
                        'date' => $date,
                        'user_id'=>$customer_data[0]->user_id,
                        'sender'=>$account_manager,
                        'receiver' => $customer_str
                    );
                    $msg_id = DB::table('msg')->insertGetId($msgData);
                    foreach($customer as $cust) {
                        DB::insert('insert into notifications (msg_id,customer) values(?,?)',[$msg_id,$cust]);
                    } 
                }
                flash('Push Notification Sent Successfully')->success();
                return redirect()->intended('sent-messages');
            }
        }
        else {
            flash('Please fill all the required fields')->error();
            return redirect()->intended('create-message');
        }
    }

    public function viewMessage($id) {
        $message = DB::select('select * from msg WHERE id = ?',[$id]);
        $receivers = array();
        if($message[0]->type == 'push' && $message[0]->receiver != 'all') {
            $receivers = DB::select('select GROUP_CONCAT(CONCAT(cust_name, " ", middle_name, " ", sur_name)) as name from ba_account_holders where id IN ('.$message[0]->receiver.')');
        }
        return view('view-message', ['module' => $this->module, 'message' => $message, 'receivers' => $receivers]);
    }

    public function deleteMessage($id) {
        $message = DB::delete('delete from msg WHERE id = ?',[$id]);

        flash('Message Deleted Successfully')->success();
        return redirect()->intended('sent-messages');
    }
}
