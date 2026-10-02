<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class MinorCitizenDetails extends Model
{
  protected $table = "reg_minor_citizen_details";
  
  protected $fillable = [
    'mc_dob',
    'mc_dated',
    'mc_ward_sign',
    'mc_date',
    'mc_ward'
  ];

  protected $gaurded = [];
}
