<?php

namespace App\Http\Controllers\NewAccount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Main;

/**
 * Models associated with this controller are listed below.
 */
use App\Model\AccountOpening\AccountHolderDetails;
use App\Model\AccountOpening\CommunicationDetails;
use App\Model\AccountOpening\CreditFacilities;
use App\Model\AccountOpening\InitialPaymentDetails;
use App\Model\AccountOpening\JointAcHolderDetails;
use App\Model\AccountOpening\KycDetails;
use App\Model\AccountOpening\MinorCitizenDetails;
use App\Model\AccountOpening\OccupationalDetails;
use App\Model\AccountOpening\PersonalDetails;
use App\Model\AccountOpening\ReachoutDetails;
use App\Model\AccountOpening\OtherBankAccounts;
use App\Model\AccountOpening\IntroducerDetails;
use App\Model\AccountOpening\SeniorCitizenDetails;


class OnlineOpeningAccountController extends Controller
{

  /**
   * constructor
   */
  public function __construct()
  {
 
    $config = DB::select(
      'select bank_name, logo, sms_token, sms_sid, sms_phone from configs where 1'
    );
       $this->fromEmail = $config[0]->bank_email;
    $this->bankName = $config[0]->bank_name;
    $this->logo = $config[0]->logo;
    $this->fromNumber = $config[0]->sms_phone;
    $this->accountSid = $config[0]->sms_sid;
    $this->authToken = $config[0]->sms_token;
    $this->env = 'live';
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
      $this->env = 'local';
    }
  }
  /**
   * Display initial view
   */
  public function index()
  {

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $data = array();
    $data['main'] = 'dashboard';
    $data['page'] = '';
    $data['bankName'] = $this->bankName;
    $data['logo'] = $this->logo;
    $user_id = $request->session()->get('user_id');
    $data['summary'] = DB::select(
      'select available_balance, account_currency, (select count(*) as cnt from
      ba_transactions where ba_transactions.user_id = ? and
      ba_transactions.status = 0 and ba_transactions.type = ?) as pending from
      ba_user_accounts where ba_user_accounts.user_id = ? order by
      ba_user_accounts.id asc limit 1', [$user_id, 'debited', $user_id]
    );

    $data['transactions'] = DB::select(
      'select * from ba_transactions where user_id = ? and status = 1 and type = ?',
      [$user_id, 'debited']
    );

    foreach($data['transactions'] as &$transaction) {
      $account = DB::select(
        'select account_currency from ba_user_accounts where account_no = ?',
        [$transaction->act_number]
      );
      $transactions2 = DB::select(
        'select * from ba_transactions where user_id = ?
        and status = 1 and tran_id = ? and id != ? and type = ?',
        [$user_id, $transaction->tran_id, $transaction->id, 'credited']
      );
      $transaction->other_transactions = $transactions2;
      $transaction->account_currency = $account[0]->account_currency;
    }

    /** fetching form data **/
    $data['enabledForms'] = DB::table('reg_form_settings')->first();

    /** fetching currencies **/
    $data['currencies'] = DB::table('currencies')->get();

    /** fetching account type **/
    $data['accountTypes'] = DB::table('account_type')->get();

    /** fetching branch name and code **/
    $data['branchLocations'] =  
    DB::select('select branch_name, id from bank_details');

    return view('registration.apply-for-account-opening', $data);
  }

  /** 
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  /** user id and rand **/

    public function getCustomerID() {
        return $customerID = $this->getRandom(7);
    }

    public function getCustomerPassword() {
        return $customerID = $this->getRandom(5);
    }


    public function getRandom($digits) {
      if($digits == 7) {
        $rand = rand(1000000, 9999999);
        $check = $this->checkCustomerID($rand);

        if($check) {
            return $rand;
        }
        else {
            getRandom(7);
        }
      }
      elseif($digits == 5) {
        $rand = rand(10000, 99999);

        $check = $this->checkCustomerPassword($rand);

        if($check) {
            return $rand;
        }
        else {
            getRandom(5);
        }
      }
    }  

  public function checkCustomerID($rand) {
    $customers = DB::select('select count(*) as cnt from ba_account_holders WHERE customer_id = ?', [$rand]);
    if($customers[0]->cnt == 0) {
        return true;
    }
    else {
        return false;
    }
  }

  public function checkCustomerPassword($rand) {
    $customers = DB::select('select count(*) as cnt from ba_account_holders WHERE cust_password = ?', [$rand]);
    if($customers[0]->cnt == 0) {
        return true;
    }
    else {
        return false;
    }
  }

  public function store(Request $request)
  {

    /*-- Validation --*/
    $validation=[];
    $validationMessages=[];
    $user_id=$request->user_id;
    $insertArr=$request->except([
      '_token',
      'user_id',
      'ao_fs_two',
      'ao_fs_three',
      'ao_fs_four',
      'ao_fs_five',
      'ao_fs_six',
      'ao_fs_seven',
      'ao_fs_eight',
      'ao_fs_nine',
      'ao_fS_ten',
      'ao_fs_eleven',
      'ao_fs_twelve',
      'ao_fs_thirteen',
      'ao_fS_fourteen',
      'ao_fs_fifteen'
    ]);

    $table="";

    if ($request->ao_fs_two) {
      $validation['fa_bank'] = 'required';
      $validation['fa_currency'] = 'required';
      $validation['fa_ac_type'] ='required';
      $validationMessages['fa_ac_mode.required'] = 'Please select branch';
      $validationMessages['fa_currency.required'] = 'Please select currency type';
      $validationMessages['fa_ac_type.required'] ='Please select your account type';
      $table="";

      $validator = Validator::make(
        $request->all(),
        $validation,
        $validationMessages
      );    

      /*-- in-case validator fails --*/
      if ($validator->fails()) {
        return response()->json(["errors"=>$validator->errors()],400);
      } else {
        $bank = $request->input('fa_bank');
        $currency = $request->input('fa_currency');
        $accountType = $request->input('fa_ac_type');

        $c_n = DB::table('currencies')->where('currency', $currency )->value('currency_name');
        DB::insert('insert into ba_user_accounts (bank, account_type, account_currency, currency_name) values(?,?,?,?)',[$bank, $currency, $accountType,$c_n]);
      }
    }



    if ($request->ao_fs_three) {
      $validation['title'] = 'required';
      $validation['cust_name'] = 'required';
      $validation['dob'] = 'required';
      $validationMessages['title.required'] = 'Please select title';
      $validationMessages['cust_name.required'] = 'please enter your name';
      $validationMessages['dob.required'] = 'please enter date of birth';

      $validator = Validator::make(
        $request->all(),
        $validation,
        $validationMessages
      );    

      /*-- in-case validator fails --*/
      if ($validator->fails()) {
        return response()->json(["errors"=>$validator->errors()],400);
      } else {
        $title = $request->input('title');
        $fName = $request->input('cust_name');
        $dateOfBirth = $request->input('dob');

        $user_id = time();
        $customer_id = $this->getCustomerID();
        $cust_password = $this->getCustomerPassword();

        DB::insert('insert into ba_account_holders (title, cust_name, dob, user_id, customer_id, cust_password) values(?,?,?,?,?,?)', [$title, $fName, $dateOfBirth, $user_id, $customer_id, $cust_password]);
      }
    }

    // fieldset - 4 - communication details
    if ($request->ao_fs_four) {
      $validation['cd_addr'] = 'required';
      $validation['cd_city'] = 'required';
      $validation['cd_pincode'] = 'required';
      $validation['cd_citizenship'] = 'required';
      $validation['cd_tell'] = 'required';
      $validation['cd_maddr'] = 'required';
      $validation['cd_mcity'] = 'required';
      $validation['cd_mpincode'] = 'required';
      $validation['cd_mcitizenship'] = 'required';
      $validationMessages['cd_addr.required'] = 'Please enter your communication address';
      $validationMessages['cd_city.required'] = 'Please enter city name';
      $validationMessages['cd_pincode.required'] = 'Please enter pincode';
      $validationMessages['cd_citizenship.required'] = 'Please select citizenship';
      $validationMessages['cd_tell.required'] = 'Please enter tell Number';
      $validationMessages['cd_maddr.required'] = 'Please enter mailing Address';
      $validationMessages['cd_mcity.required'] = 'Please enter mailing city address';
      $validationMessages['cd_mpincode.required'] = 'Please enter your mailing pincode';
      $validationMessages['cd_mcitizenship.required'] = 'Please enter your citizenship';
      $table="communication_details";
    }

    // fieldset - 5 - reachout details
    if ($request->ao_fs_five) {
      $validation['ro_mobile'] = 'required';
      $validation['ro_email'] = 'required';
      $validationMessages['ro_mobile'] = 'Please enter mobile number';
      $validationMessages['ro_email'] = 'Please enter email address';
      $table="reachout_details";
    }

    // fieldset - 6 - personal details
    if ($request->ao_fs_six) {
      $validation['pd_edu'] = 'required'; // educational qualification
      $validation['pd_marital'] = 'required'; // marital status
      $validation['pd_adults'] = 'required'; // adults dependents
      $validation['pd_kids'] = 'required'; // kids dependents
      $validation['pd_ai'] = 'required'; // annual income

      $validationMessages['pd_edu.required'] = 'Please enter education details';
      $validationMessages['pd_marital.required'] = 'Please select marital status';
      $validationMessages['pd_adults.required'] = 'Please enter details';
      $validationMessages['pd_kids.required'] = 'Please enter details';
      $validationMessages['pd_ai.required'] = 'Please enter details';
      $table="personal_details";
    }

    // fieldset - 7 - occupational details
    if ($request->ao_fs_seven) {
      $validation['od_type'] = 'required';
      $validationMessages['od_type'] = 'Please enter type of your occupation';
      $table="occupational_details";
    }

    // fieldset - 8 - joint account holders
    if ($request->ao_fs_eight) {
      $table="joint_ac_holder_details";
    }

    // fieldset - 9 - other bank accounts
    if ($request->ao_fs_nine) {
      $validation['ob_other_bank'] = 'required';
      $validationMessages['ob_other_bank'] = 'Please enter deails';
      $table="other_bank_accounts";
    }

    // fieldset - 10 - credit facilities
    if ($request->ao_fS_ten) {
      $table="credit_facilities";
    }

    // fieldset - 11 - initial payment details
    if ($request->ao_fs_eleven) {
      $table="initial_payment_details";
    }

    // fieldset - 12 - Introducer Details
    if ($request->ao_fs_twelve) {
      $validation['int_name'] = 'required';
      $validation['int_ac'] = 'required';
      $validation['int_branch'] = 'required';
      $validation['int_sign'] = 'required';
      $validation['int_date'] = 'required';
      $validation['int_place'] = 'required';
      $validationMessages['int_name.required'] = 'Please enter deails';
      $validationMessages['int_ac.required'] = 'Please enter deails';
      $validationMessages['int_branch.required'] = 'Please enter deails';
      $validationMessages['int_sign.required'] = 'Please enter deails';
      $validationMessages['int_date.required'] = 'Please enter deails';
      $validationMessages['int_place.required'] = 'Please enter deails';
      $table="introducer_details";
    }

    // fieldset - 13 - minor account
    if ($request->ao_fs_thirteen) {
      $table="minor_citizen_details";
    }

    // fieldset - 14 - senior citizen details
    if ($request->ao_fS_fourteen) {
      $table="senior_citizen_details";
    }

    // fieldset - 15 -
    if ($request->ao_fs_fifteen) {
      $table="";
    }

    $validator = Validator::make(
      $request->all(),
      $validation,
      $validationMessages
    );

    /*-- in-case validator fails --*/
    if ($validator->fails()) {

      return response()->json(["errors"=>$validator->errors()],400);
    }

    if ($user_id) {
      $insertArr["ah_id"]=$user_id;
    }
   if($request->fa_sex)
   {
    $insertArr["fa_gender"]=$requet->fa_sex;
    unset($insertArr["fa_sex"]);
   }
    //insert
    if ($table!="") {
      $insertResult = DB::table($table)->insert($insertArr);
      if (!$insertResult) {
        $insertResult=0;
      }
    } else {
      $insertResult=1;
    }

    $result=[
      'insertResult' => $insertResult,
    ];

    if ($request->ao_fs_three) {
      $result["user_id"]=DB::table($table)
      ->orderBy("created_at","desc")
      ->first()->id;
    }

    return response()->json($result);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\OnlineOpeningAccountModel  $onlineOpeningAccountModel
   * @return \Illuminate\Http\Response
   */
  public function show(AccountHolderDetails $AccountHolderDetails)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\OnlineOpeningAccountModel  $onlineOpeningAccountModel
   * @return \Illuminate\Http\Response
   */
  public function edit(AccountHolderDetails $AccountHolderDetails)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\OnlineOpeningAccountModel  $onlineOpeningAccountModel
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AccountHolderDetails $AccountHolderDetails)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\OnlineOpeningAccountModel  $onlineOpeningAccountModel
   * @return \Illuminate\Http\Response
   */
  public function destroy(AccountHolderDetails $AccountHolderDetails)
  {
    //
  }

}
