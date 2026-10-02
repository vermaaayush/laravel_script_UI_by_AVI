<?php

namespace App\Http\Controllers\InternetBanking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Models associated with this controller are listed below.
 */
use App\InternetBankingDetails;

class InternetBankingDetailsController extends Controller
{
  /**
   * constructor
   */
  public function __construct()
  {
    
    $config = DB::select(
      'select bank_email, bank_name, logo, sms_token, sms_sid, sms_phone from configs where 1'
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
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
    return view('registration.apply-for-internet-banking-option', $data);
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
    
    /** fetching enabled form data from db **/
    $data['enableIbForms'] = DB::table('reg_ib_form_settings')->first();
    
    return view('registration.new-account-steps', $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    /*-- Validation --*/
    $validation=[];
    $validationMessages=[];
    $insertArr=$request->except([
      '_token',
      'form-wizard1',
      'terms'
    ]);
     $table="";

    if ($request->form.'-'.'wizard1') {
      $validation['ib_ac_type'] = 'required';
      $validation['ib_title'] = 'required';
      $validation['ib_fname'] ='required';
      $validation['ib_dob'] = 'required';
      $validation['ib_phone'] = 'required';
      $validation['ib_email'] = 'required';
      $validation['ib_addr'] = 'required';
      $validation['ib_pincode'] = 'required';
      $validation['ib_country'] = 'required';
      $validation['ib_ac_number'] = 'required';
      $validation['ib_username'] = 'required|unique:internet_banking_details';
      $validation['ib_q_one'] = 'required';
      $validation['ib_q_two'] = 'required';
      $validation['ib_q_three'] = 'required';
      $validationMessages['ib_ac_type.required'] = 'Please select account type';
      $validationMessages['ib_title.required'] = 'Please select title';
      $validationMessages['ib_fname.required'] ='Please enter your name';
      $validationMessages['ib_dob.required'] = 'Please select your date of birth';
      $validationMessages['ib_phone.required'] = 'please enter phone number';
      $validationMessages['ib_email.required'] = 'please enter email address';
      $validationMessages['ib_addr.required'] = 'please address details';
      $validationMessages['ib_pincode.required'] = 'please enter pincode';
      $validationMessages['ib_country.required'] = 'please select country';
      $validationMessages['ib_ac_number.required'] = 'please enter account number';
      $validationMessages['ib_username.required'] = 'please enter user name';
      $validationMessages['ib_q_one.required'] = 'please answer the question';
      $validationMessages['ib_q_two.required'] = 'please answer the question';
      $validationMessages['ib_q_three.required'] = 'please answer the question';
      $table="internet_banking_details";
    }

    $validator = Validator::make(
      $request->all(),
      $validation,
      $validationMessages
    );

    /*-- in-case validator fails --*/
    if ($validator->fails()) {
      return response()->json($validator->errors(),400);
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

  }

  /**
   * Display the specified resource.
   *
   * @param  \App\InternetBankingDetails  $InternetBankingDetails
   * @return \Illuminate\Http\Response
   */
  public function show(InternetBankingDetails $InternetBankingDetails)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\InternetBankingDetails  $InternetBankingDetails
   * @return \Illuminate\Http\Response
   */
  public function edit(InternetBankingDetails $InternetBankingDetails)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\InternetBankingDetails  $InternetBankingDetails
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, InternetBankingDetails $InternetBankingDetails)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\InternetBankingDetails  $InternetBankingDetails
   * @return \Illuminate\Http\Response
   */
  public function destroy(InternetBankingDetails $InternetBankingDetails)
  {
      //
  }

  /**
   * Recover account pin - showing form
   */
  public function recoverUserPinCreate(InternetBankingDetails $InternetBankingDetails)
  {
    return view('recover.retrieve-account-pin');
  }

  /**
   * if the user is valid user - show edit form
   */
  public function recoverUserPinUpdate(InternetBankingDetails $InternetBankingDetails)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'ib_ac_pin' => 'required', // account pin
        'ib_ac_pin_c' => 'required', // account pin confirm
      ],
      [
        'ib_ac_pin.required' => 'Please enter the new account pin number',
        'ib_ac_c_pin' => 'Please enter the new pin number once again'
      ]
    );
  }

  /**
   * if the user is valid user, then update pin
   */
  public function recoverUserIdCreate(InternetBankingDetails $InternetBankingDetails)
  {
    return view('recover.retrieve-account-user-id');
  }

  /**
   * Recover account user id
   */
  public function recoverUserIdUpdate(InternetBankingDetails $InternetBankingDetails)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'ib_userid' => 'required', // account pin
        'ib_c_userid' => 'required', // account pin confirm
      ],
      [
        'ib_userid.required' => 'Please enter the new user id',
        'ib_c_userid' => 'Please enter the new user id again'
      ]
    );
  }
}
