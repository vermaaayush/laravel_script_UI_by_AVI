<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class OtherBankAccounts extends Model
{
  protected $table = "reg_other_bank_accounts";
  
  protected $fillable = [
    'ob_other_bank',
    'ob_bank_name',
    'ob_branch',
    'ob_ac_type',
    'ob_ac_number'
  ];

  protected $gaurded = [];
}
