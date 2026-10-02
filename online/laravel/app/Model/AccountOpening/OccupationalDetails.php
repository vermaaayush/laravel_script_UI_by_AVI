<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class OccupationalDetails extends Model
{
  protected $table = "reg_occupational_details";
  
  protected $fillable = [
    'od_type',
    'od_details',
    'od_self',
    'od_self_details',
    'od_business',
    'od_business_details'
  ];

  protected $gaurded = [];
}
