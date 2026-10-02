<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Mail;
use App\UserActivity;

class Feedback extends Controller {

    public function __construct() {
        $timezone = DB::table('configs')->where('id','1')->first()->timezone;
        config(['app.timezone' => $timezone]);
	    date_default_timezone_set($timezone);
     $config = DB::select('select bank_email, sms_token, sms_sid, sms_phone,bank_name,logo from configs where 1');
     
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

    public function sendMessage(Request $request) {
        $data = array();
        $data['main'] = 'feedback';
        $data['page'] = 'send-message';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        $am_id = DB::select('select am,cust_mail from ba_account_holders where user_id = ?', [$user_id]);
        $data['customer_am'] = DB::select('select * from ba_am where id = ?', [$am_id[0]->am]);
    
        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        return view('send-message', $data);
    }

    public function insertSendMessage(Request $request) {
        $user_id = $request->session()->get('user_id');
        $allowed_types = array('image/jpeg','image/jpg','image/png','image/bmp','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf');
        $destinationPath = 'uploads';
         $user_id = $request->session()->get('user_id');
        $am_id = DB::select('select cust_name from ba_account_holders where user_id = ?', [$user_id]);
        
        $inFeed = [
            'user'      => $user_id,
            'subject'   => $request->subject,
            'descr'     => $request->msg,
            'cat'       => date('Y-m-d H:i:s')
        ];
        DB::table('ba_feedback')->insert($inFeed);
        
        $data = $request->input();

        $file = $request->file('file');

        $data['file'] = $file;
        $data['user_id'] = $user_id;
        $data['bank_sender'] = $this->fromEmail;
        $data['sender'] = $am_id[0]->cust_name;

        if($this->env == 'live') {
            Mail::send([],[], function($message) use ($data)
            {
                $message->from($data['bank_sender'], 'Customer Feedback');

                $message->subject($data['subject']);

                $message->to($data['to_email']);

                if(isset($data['cc_email'])) {
                    $message->cc($data['cc_email']);
                }

                if($data['file'] != '') {
                    $message->attach($data['file'], ['as' => $data['file']->getClientOriginalName(), 'mime' => $data['file']->getMimeType()]);
                }
                $message->setBody($data['msg'],'text/html');
            });
        }
        

        if(!empty($file) && !empty($file_path = $file->getRealPath()) && !empty($file_name = $file->getClientOriginalName())) {
            $file_ext = $file->getClientOriginalExtension();
            $file_type = $file->getMimeType();

            if(!in_array($file_type, $allowed_types)) {
                flash('Please upload allowed file type in file')->error();
                return redirect()->intended('send-message');
            }
            else {
                $data['file'] = md5(time()).$file_name;
                $file->move($destinationPath,$data['file']);
            }

            // $data['file'] = 'data:image/' . $file_type . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }
        else {
            $data['file'] = NULL;
        }

        $data['type'] = 'email';
        $data['date'] = date("Y-m-d");
        $data['receiver'] = $data['to_email'];
        $to_email = $data['to_email'];
        $reveiver_name = DB::select('select name from ba_am where email = ?', [$to_email]);
        $data['receiver_name'] = $reveiver_name[0]->name;
        if(isset($data['cc_email'])) {
            $data['cc'] = $data['cc_email'];    
        }

        unset($data['_token']);
        unset($data['to_email']);
        if(isset($data['cc_email'])) {
            unset($data['cc_email']);
        }

        $query = '';
        foreach($data as $col => $value) {
            $value1 = strip_tags(htmlspecialchars_decode($value));
            if($query == '') {
                
                $query = "$col = '$value1'";
            }
            else {
                $query .= ", $col = '$value1'";
            }
        }

        DB::insert("insert into msg set $query");

        $data = array();
        $data['main'] = 'feedback';
        $data['page'] = 'send-message';
        $data['msg'] = 'Feedback Sent Successfully';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        UserActivity::saveUserActivity($request->session()->get('id'),'Send Feedback');
        return view('notification', $data);
    }

    public function allMessages(Request $request) {
        $data = array();
        $data['main'] = 'feedback';
        $data['page'] = 'all-messages';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;
        $data['bank_sender'] = $this->fromEmail;

        $user_id = $request->session()->get('user_id');

        $notifaction=  new Controller();
        $notifaction->user_notifactions($user_id);
        $user = DB::select('select * from ba_account_holders where user_id = ?', [$user_id]);
        $data['customers'] = DB::select('select * from ba_account_holders');
        $data['sent'] = DB::select('select * from msg where user_id = ? and deleted = 0 and type = ? order by date desc', [$user_id, 'email']);
        $email = $user[0]->cust_mail;
        $data['inbox'] = DB::select("select * from msg where (receiver LIKE '%$email%' || cc LIKE '%$email%') and deleted = 0 and type = ? order by date desc", ['email']);
        $data['trash'] = DB::select('select * from msg where user_id = ? and deleted = 1 and type = ? order by date desc', [$user_id, 'email']);
        return view('all-messages', $data);
    }

    public function deleteMsg(Request $request, $id) {
        $data = array();
        $data['main'] = 'feedback';
        $data['page'] = 'all-messages';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        DB::update('update msg set deleted = 1 where user_id = ? and id = ?', [$user_id, $id]);

        flash('Message Deleted Successfully')->success();
        return redirect()->intended('all-messages');
    }

    public function undeleteMsg(Request $request, $id) {
        $data = array();
        $data['main'] = 'feedback';
        $data['page'] = 'all-messages';
        $data['bankName'] = $this->bankName;
        $data['logo'] = $this->logo;

        $user_id = $request->session()->get('user_id');
        DB::update('update msg set deleted = 0 where user_id = ? and id = ?', [$user_id, $id]);

        flash('Message Undeleted Successfully')->success();
        return redirect()->intended('all-messages');
    }
}
