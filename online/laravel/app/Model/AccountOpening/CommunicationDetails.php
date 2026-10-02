<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class CommunicationDetails extends Model
{
  protected $table = "reg_communication_details";
  
  protected $fillable = [
    'cd_addr',
    'cd_city',
    'cd_pincode',
    'cd_citizenship',
    'cd_tell',
    'cd_maddr',
    'cd_mcity',
    'cd_mpincode',
    'cd_mcitizenship'
  ];

  protected $gaurded = [];
}
