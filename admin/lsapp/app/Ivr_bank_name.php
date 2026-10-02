<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Ivr_bank_name extends Model
{
   
	 use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'ivr_bank_name';
    protected $guarded = [];

     public function users()
		{
		    return $this->belongsTo('App\BaAccountHolders', 'customer_id','customer_id');
		}

    
}
