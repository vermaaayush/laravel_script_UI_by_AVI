<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class AccountHolderDetails extends Model
{
  protected $table = "reg_account_holder_details";
  
  protected $fillable = [
    'fa_bank',
    'fa_currency',
    'fa_ac_type',
    'title',
    'cust_name',
    'fa_alias',
    'fa_alias_reason',
    'dob',
    'fa_sex',
    'fa_nationality',
    'fa_pan',
    'fa_is_ma',
    'fa_sc',
    'fa_ward',
    'fa_rel',
    'fa_reg_number'
  ];

  protected $gaurded = [];
}
