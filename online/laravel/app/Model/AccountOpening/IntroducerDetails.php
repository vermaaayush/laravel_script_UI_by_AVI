<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class IntroducerDetails extends Model
{
  protected $table = "reg_introducer_details";
  
  protected $fillable = [
    'int_name',
    'int_ac',
    'int_branch',
    'int_sign',
    'int_date',
    'int_place'
  ];

  protected $gaurded = [];
}
