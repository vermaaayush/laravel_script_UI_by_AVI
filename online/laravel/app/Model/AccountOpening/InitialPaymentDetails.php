<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class InitialPaymentDetails extends Model
{
  protected $table = "reg_initial_payment_details";
  
  protected $fillable = [
    'ip_currency',
    'ip_amnt',
    'ip_check',
    'ip_dated',
    'ip_drawn',
    'ip_branch',
    'ip_ac',
    'ipr_name',
    'ipr_addr',
    'ipr_cur_amnt',
    'ipr_bank_addr',
  ];

  protected $gaurded = [];
}
