<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class BaCards extends Model
{
   
	 use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'ba_cards';
    protected $guarded = [];

     public function users()
		{
		    return $this->belongsTo('App\BaAccountHolders', 'user_id','user_id');
		}

    
}
