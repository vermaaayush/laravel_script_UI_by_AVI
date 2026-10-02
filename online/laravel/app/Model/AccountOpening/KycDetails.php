<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class KycDetails extends Model
{
  protected $table = "reg_kyc_details";
  
  protected $fillable = [
    'kyc_proof',
    'kyc_doc_no',
    'kyc_place',
    'kyc_issue_date',
    'kyc_exp_date',
    'kyc_purpose',
    'kyc_source',
    'kyc_ac_to',
    'kyc_transaction',
    'kyc_activity',
    'kyc_exist_ac',
    'kyc_cust_id',
    'kyc_ac',
    'kyc_auth',
    'kyc_poa',
    'kyc_dob',
    'kyc_addr',
    'kyc_proof_doc'
  ];

  protected $gaurded = [];
}
