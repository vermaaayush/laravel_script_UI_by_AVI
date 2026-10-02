<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class CallLog extends Model
{
   
	 use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'ivr_call_log';
    protected $fillable = [

         'callerid', 'accountid', 'callfrom','callto','callstatus','apiversion','direction','fromcity','fromstate','fromzip','fromcountry','tocity','tostate','	tozip','tocountry'
    ];


    
}
