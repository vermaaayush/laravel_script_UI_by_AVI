<?php

namespace App\Model\InternetBanking;

use Illuminate\Database\Eloquent\Model;

class InternetBankingDetails extends Model
{
  protected $fillable = [
    'ib_ac_type',
    'ib_title',
    'ib_fname',
    'ib_mname',
    'ib_sname',
    'ib_dob',
    'ib_phone',
    'ib_email',
    'ib_addr',
    'ib_pincode',
    'fa_country',
    'ib_ac_number',
    'ib_username',
    'ib_q_one',
    'ib_q_two',
    'ib_q_three',
    'ib_otp',
    'ib_pin'
  ];

  protected $gaurded = [];
}
