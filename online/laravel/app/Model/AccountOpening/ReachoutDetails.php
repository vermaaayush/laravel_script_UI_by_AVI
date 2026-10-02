<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class ReachoutDetails extends Model
{
  protected $table = "reg_reachout_details";
  
  protected $fillable = [
    'ro_mobile',
    'ro_tell',
    'ro_office_tell',
    'ro_fax',
    'ro_email'
  ];

  protected $gaurded = [];
}
