<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class SeniorCitizenDetails extends Model
{
  protected $table = "reg_senior_citizen_details";
  
  protected $fillable = [
    'sc_branch_one',
    'sc_branch_two',
    'sc_app_one',
    'sc_app_two',
    'sc_app_three'
  ];

  protected $gaurded = [];
}
