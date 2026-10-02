<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class ivr_purchase_numbers extends Model
{
   
	 use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


		protected $table = 'ivr_purchase_numbers';

    protected $fillable = [

         'phone_number', 'sid', 'url'
    ];

    
}
