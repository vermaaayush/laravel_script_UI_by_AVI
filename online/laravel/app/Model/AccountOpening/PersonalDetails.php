<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
  protected $table = "reg_personal_details";
  
  protected $fillable = [
    'pd_edu',
    'pd_marital',
    'pd_adults',
    'pd_kids',
    'pd_ai'
  ];

  protected $gaurded = [];
}
