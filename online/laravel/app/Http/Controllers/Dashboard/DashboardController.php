<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Dashboard\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  /**
   * constructor
   */
  public function __construct()
  {
    
    $config = DB::select(
      'select bank_name,bank_email, logo, sms_token, sms_sid, sms_phone from configs where 1'
    );
    $this->fromEmail =  $config[0]->bank_email;
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

    return view('dashboard.dashboard', $data);
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Model\Dashboard\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Dashboard\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Dashboard\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Dashboard\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
