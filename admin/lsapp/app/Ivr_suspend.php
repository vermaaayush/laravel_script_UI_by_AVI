<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ivr_suspend extends Model
{
   
	 use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'ivr_suspend_msg';
    protected $guarded = [];

    public function users()
		{
		    return $this->belongsTo('App\BaAccountHolders', 'user_id','user_id');
		}
    
}
