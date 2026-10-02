<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class CreditFacilities extends Model
{
  protected $table = "reg_credit_facilities";
  
  protected $fillable = [
    'cf_nature',
    'cf_amnt_sanct',
    'cf_amnt_util',
    'cf_bank_name',
    'cf_bank_addr',
    'cf_bank_ac'
  ];

  protected $gaurded = [];
}
