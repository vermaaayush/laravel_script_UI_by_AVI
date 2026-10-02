<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
     public function __construct() {
         $data =array();
         $data['noti'] ="1";
     }

    
    public function user_notifactions($user_id) {
     
    	//$noti = DB::select('select notifications.customer,notifications.msg_id,msg.msg,msg.sender,msg.date,.notifications.customer,ba_am.photo,ba_am.name from notifications,msg,ba_am where  msg.user_id=?',[$user_id] );
        //view()->share(['noti'=>$noti]);
    }
   
}

$t  =  new Controller();

//$t->user_notifactions();
