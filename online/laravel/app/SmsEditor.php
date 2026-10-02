<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class SmsEditor extends Model
{
   
	 use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'sms_editor';
    protected $guarded = [];

   
    
}
