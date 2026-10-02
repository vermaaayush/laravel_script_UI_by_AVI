<?php

namespace App\Http\Controllers\Recover;

use App\Http\Controllers\Controller;
use App\Model\Recover\RecoverPin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecoverPinController extends Controller
{
  /**
   * constructor
   */
  public function __construct()
  {
   
    $config = DB::select(
      'select bank_name, logo, bank_email, sms_token, sms_sid, sms_phone from configs where 1'
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
    return view('recover.retrieve-account-pin', $data);
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Recover\RecoverPin  $recoverPin
     * @return \Illuminate\Http\Response
     */
    public function show(RecoverPin $recoverPin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Recover\RecoverPin  $recoverPin
     * @return \Illuminate\Http\Response
     */
    public function edit(RecoverPin $recoverPin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Recover\RecoverPin  $recoverPin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecoverPin $recoverPin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Recover\RecoverPin  $recoverPin
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecoverPin $recoverPin)
    {
        //
    }
}
