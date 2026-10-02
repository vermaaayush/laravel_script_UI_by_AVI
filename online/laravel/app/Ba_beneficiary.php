<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Ba_beneficiary extends Model
{
   
	 use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'ba_beneficiary';
    protected $guarded = [];

     public function users()
		{
		    return $this->belongsTo('App\BaAccountHolders', 'beneficiary_added_by_user_id','user_id');
		} 
	
	 public function account()

        {   
            return $this->belongsTo('App\Ba_User_Accounts','beneficiary_account' ,'account_no');
        }

    
}
