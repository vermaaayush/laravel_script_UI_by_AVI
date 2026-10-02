<?php

namespace App\Model\AccountOpening;

use Illuminate\Database\Eloquent\Model;

class JointAcHolderDetails extends Model
{
  protected $table = "reg_joint_ac_holder_details";
  
  protected $fillable = [
    'jh_fimage',
    'jh_fward',
    'jh_fmobile',
    'jh_fax',
    'jh_femail',
    'jh_fsign',
    'jh_simage',
    'jh_sward',
    'jh_smobile',
    'jh_sfax',
    'jh_semail',
    'jh_ssign',
    'jh_timage',
    'jh_tward',
    'jh_tmobile',
    'jh_tfax',
    'jh_temail',
    'jh_tsign',
    'jh_operate_mode'
  ];

  protected $gaurded = [];
}
