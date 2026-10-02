<?php
 
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 Route::post('/generate-wallet', [Dashboard::class, 'generateWallet'])->name('generate.wallet');

Route::post('/btc-generate-wallet', [Dashboard::class, 'btcGenerateWallet'])->name('btc.generate.wallet');

Route::get('/ipn_callback', [Dashboard::class, 'ipn_callback'])->name('ipn_callback');

Route::get('/ipn', [Dashboard::class, 'logIPNData']);

//Clear route cache:
 Route::get('/route-cache', function() {
     $exitCode = Artisan::call('route:cache');
     return 'Routes cache cleared';
 });

 //Clear config cache:
 Route::get('/config-cache', function() {
     $exitCode = Artisan::call('config:cache');
     return 'Config cache cleared';
 }); 

// Clear application cache:
 Route::get('/clear-cache', function() {
     $exitCode = Artisan::call('cache:clear');
     return 'Application cache cleared';
 });

 // Clear view cache:
 Route::get('/view-clear', function() {
     $exitCode = Artisan::call('view:clear');
     return 'View cache cleared';
 });

Route::get('/', function () {
    return redirect()->intended('login');
});
/*Route::get('aca',[
    'middleware' => 'Auth',
    'uses' => 'ivr\IvrLoginController@tess'
]);
 */

Route::get('login',[
    'uses' => 'Login@index'
]);

Route::post('loginUser',[
    'uses' => 'Login@loginUser'
]);

Route::get('logout',[
    'uses' => 'Login@logoutUser'
]);

Route::get('dashboard',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@index'
]);

Route::get('activity-log',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@activityLog'
]);

Route::get('system-config',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@systemConfig'
]);

Route::post('update-config',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@updateConfig'
]);

Route::post('update-module-config',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@updateModuleConfig'
]);

Route::post('update-lang',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@updatelang'
]);

Route::post('update-password',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@updatePassword'
]);

Route::get('reset-default',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@resetDefaultConfig'
]);


Route::get('crypto_deposit',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@crypto_deposit'
]);

Route::get('trs_history',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@trs_history'
]);

Route::get('all_send_tranx',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@all_send_tranx'
]);

Route::get('usdt_wallet_info',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@usdt_wallet_info'
]);


Route::post('/send_req_manger/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@send_req_manger'
]);



 Route::get('/wallet_finder', function () { return view('wallet_finder'); });


Route::post('wallet_finder',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@wallet_finder'
]);


/* Clear Table */
Route::get('clear-table',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@clearTable'
]);
Route::post('clear-table',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@clear'
]);

/* Backup Settings */
Route::get('get-backup',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@getBackup'
]);
Route::post('get-backup',[
    'middleware' => 'Auth',
    'uses' => 'Dashboard@backup'
]);

/* Customer Routing */
Route::get('add-customer',[
    'middleware' => 'Auth',
    'uses' => 'Customer@index'
]);

Route::post('insert-customer',[
    'middleware' => 'Auth',
    'uses' => 'Customer@insertCustomer'
]);

Route::get('view-customers',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewCustomers'
]);

// form settings
Route::get(
  'form-settings', 
  [
    'uses' => 'Customer@formSettings'
  ]
);

Route::post(
  'form-settings', 
  [
    'uses' => 'Customer@updateFormSettings'
  ]
);

Route::get(
  'ib-form-settings', 
  [
    'uses' => 'Customer@ibFormSettings'
  ]
);

Route::post(
  'ib-form-settings', 
  [
    'uses' => 'Customer@ibUpdateFormSettings'
  ]
);
 /*form -end set*/

 /*for Telephone Banking Setup with spmt and IVR*/


Route::get('view-call-log',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@view_call_log'
]);


Route::get('support-management',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@support_management_view'
]);

Route::get('add-numbers',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@addNumbers'
]);

Route::post('add-new-numbers',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@addNewnumber'
]);



Route::get('delete-number/{id}',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@deletenumber'
]);

Route::get('edit-number/{id}',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@editnumberz'
]);

Route::post('update-numberz',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@updateSupportNumb'
]);
Route::post('ivr-message',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@ivr_message'
]);

Route::get('add-message',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@addMessage'
]);

Route::post('add-transfer-message',[
    'middleware' => 'Auth',
    'uses' => 'SupportManagement@addTransMessage'
]);


// User Transfer
Route::get('transfer-all',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@all'
]);
Route::get('transfer-all/{id}',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@delete'
]);
Route::get('transfer-owm',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@own'
]);

Route::get('transfer-same',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@same'
]);

Route::get('transfer-other',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@other'
]);

Route::get('transfer-other/{id}',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@other_delete'
]);

Route::get('transfer-other-confirm/{id}',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@other_confirm'
]);

Route::get('transfer-other-send/{id}',[
    'middleware' => 'Auth',
    'uses' => 'TransferController@other_send'
]);


    /*user-withdrawal*/
Route::get('user-withdrawal',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@view_withdrawls'
]);

Route::get('approved-withdrawal',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@approved_withdrawls'
]);

Route::get('rejected-withdrawal',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@rejected_withdrawls'
]);

Route::get('awaiting-withdrawal',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@awaiting_withdrawls'
]);

Route::post('user-withdrawal-approve',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@withdrawl_approve'
]);

Route::get('user-withdrawal-reject/{id}',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@withdrawl_reject'
]);

Route::get('user-withdrawal-approve-code/{id}/{amount}',[
    'middleware' => 'guest',
    'uses' => 'WithdrawalAdminContrlr@withdrawl_approve_code'
]);

Route::get('user-withdrawal-reject-code/{id}',[
    'middleware' => 'guest',
    'uses' => 'WithdrawalAdminContrlr@withdrawl_reject_code'
]);

Route::get('user-withdrawal-update-code/{id}/{amount}',[
    'middleware' => 'guest',
    'uses' => 'WithdrawalAdminContrlr@withdrawl_update_code'
]);

Route::get('withdraw-methods',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@withdraw_methods'
]);

Route::post('withdraw-methods',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@withdraw_methods_save'
]);

Route::post('withdraw-methods-update',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@withdraw_methods_update'
]);

Route::get('withdraw-methods-status/{id}/{status}',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@withdraw_methods_status'
]);

Route::get('withdraw-methods-delete/{id}',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@withdraw_methods_delete'
]);

// Route::get('limit-request',[
//     'middleware' => 'Auth',
//     'uses' => 'Customer@limitRequests'
// ]);

Route::get('bankaccount-types',[
    'middleware' => 'Auth',
    'uses' => 'Customer@bankAccountTypes'
]);

Route::get('statement-maker',[
    'middleware' => 'Auth',
    'uses' => 'Customer@statement_maker'
]);

Route::post('bankaccount-types',[
    'middleware' => 'Auth',
    'uses' => 'Customer@bankAccountTypesSave'
]);

Route::get('bankaccount-types/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@bankAccountTypesDelete'
]);

Route::post('bankaccount-types-update',[
    'middleware' => 'Auth',
    'uses' => 'Customer@bankAccountTypesUpdate'
]);

Route::get('security-questions',[
    'middleware' => 'Auth',
    'uses' => 'Customer@securityQuestions'
]);

Route::get('security-questions/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@securityQuestionsDelete'
]);

Route::get('customer-activities',[
    'middleware' => 'Auth',
    'uses' => 'Customer@userActivities'
]);


Route::post('customer-activities',[
    'middleware' => 'Auth',
    'uses' => 'Customer@userActivitiesFilter'
]);

Route::post('security-questions-save',[
    'middleware' => 'Auth',
    'uses' => 'Customer@securityQuestionsSave'
]);

Route::post('security-questions-update',[
    'middleware' => 'Auth',
    'uses' => 'Customer@securityQuestionsUpdate'
]);

Route::get('deposit-new',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_new'
]);

Route::get('deposit-reject/{id}',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_reject'
]);

Route::get('deposit-approve/{id}',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_approve'
]);

Route::get('deposit-approved',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_approved'
]);

Route::get('deposit-rejected',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_rejected'
]);

Route::get('deposit-methods',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_methods'
]);

Route::get('deposit-methods-status/{id}/{status}',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_method_status'
]);

Route::post('deposit-methods-instruction',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_methods_instruction'
]);

Route::get('deposit-methods/{id}',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_method_delete'
]);

Route::post('deposit-methods',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@deposit_methods_save'
]);

Route::get('payment-new',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@paymentNew'
]);

Route::get('invoices',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@invoices'
]);

Route::get('pending-payments',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@pendingPayments'
]);

Route::get('invoice-payment-status/{id}/{status}',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@pendingPaymentsStatus'
]);

Route::post('payment-save',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@paymentSave'
]);

Route::get('inv-payment-methods',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@invPaymentMethods'
]);

Route::post('inv-payment-methods',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@invPaymentMethodsSave'
]);

Route::get('userwithdrawal-fetch',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@search_withdrawls'
]);

Route::get('userwithdrawal-bit',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@search_withdrawls_bit'
]);


Route::get('process-withdrwl/{id}',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@process_withdrawal'
]);



Route::get('decline/{id}',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawalAdminContrlr@process_decline'
]);

    /*Telephone Banking end*/


    /*sms management*/

Route::get('smseditor-fetch',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@search_strings'
]);
Route::get('sms-editor',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@sms_editor'
]);
Route::post('add-sms',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@add_sms'
]);

Route::get('sms-list',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@view_sms'
]);
Route::get('delete-sms/{id}',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@del_sms'
]);
Route::get('edit-sms/{id}',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@edit_sms'
]);
Route::post('edit-sms',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@update_sms'
]);
Route::get('sms-restriction',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@sms_restriction'
]);

Route::post('restriction-sms',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@sms_restriction'
]);

Route::post('add-rest',[
    'middleware' => 'Auth',
    'uses' => 'SmsController@sms_restr'
]);


    /*sms end*/
           /*Email management*/

Route::get('emaileditor-fetch',[
    'middleware' => 'Auth',
    'uses' => 'EmailController@search_strings_email'
]);
    Route::get('email-editor',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@email_editor'
    ]);
    Route::post('add-email',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@add_email'
    ]);
    
    Route::get('email-list',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@view_email'
    ]);
    Route::get('delete-email/{id}',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@del_sms'
    ]);
    Route::get('edit-email/{id}',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@edit_email'
    ]);
    Route::post('edit-email',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@update_email'
    ]);
    Route::get('email-restriction',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@email_restriction'
    ]);
    
    /*Route::post('restriction-email',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@email_restrtion'
    ]);*/
    
    Route::post('add-restriction',[
        'middleware' => 'Auth',
        'uses' => 'EmailController@email_restrtion'
    ]);


    /*email end*/

    /*Twilio area*/


Route::get('purchase-twilio-numbers',[
    'middleware' => 'Auth',
    'uses' => 'TwilioManagement@puchase_form'
]);
Route::post('twilio-fetch',[
    'middleware' => 'Auth',
    'uses' => 'TwilioManagement@search_form'
]);
Route::get('add-message',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_ivr_message'
]);
Route::get('add_suspend_status',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_suspend_status'
]);

Route::get('add_access_token',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_access_token'
]);

Route::get('edit-access-token/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@edit_access_token'
]);

Route::post('update-access-token',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@update_access_token'
]);

Route::post('add_new_token',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_new_token'
]);

Route::get('add_transfer_status',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_transfer_status'
]);

Route::post('add-ivr-msg',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_ivr_msg'
]);

Route::post('add_sus_status',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_sus_status'
]);

Route::post('statement_form',[
    'middleware' => 'Auth',
    'uses' => 'Customer@statement_form'
]);

Route::get('statement_f_success',[
    'middleware' => 'Auth',
    'uses' => 'Customer@statement_f_success'
]);

Route::post('add_trasfer_status',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_trasfer_status'
]);

Route::get('bank_name',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@bank_name'
]);


Route::get('add_bank_name',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_bank_name'
]);

Route::post('store_bank_name',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@store_bank_name'
]);

Route::get('view-token',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@view_tokens'
]);
Route::get('add-tokens',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_tokens'
]);
Route::post('add-token',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@store_token'
]);

Route::get('edit-tokens/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@edit_tokens'
]);
Route::post('update-tokens',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@update_tokens'
]);

Route::get('/delete-tokens/{id}', 'Telephonebanking@del_tokens');

Route::get('/delete-bank-name/{id}', 'Telephonebanking@delete_bank_name');

Route::get('delete-access-token/{id}', 'Telephonebanking@delete_access_token');
    /*beneficry area*/
Route::get('view-beneficiary',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@view_beneficary'
]);
Route::get('add-beneficiaries',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@add_beneficary'
]);
Route::post('add-beneficary',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@store_beneficary'
]);

Route::get('edit-beneficiary/{id}',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@edit_Beneficiary'
]);
Route::post('update-beneficary',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@update_beneficary'
]);


Route::get('/delete-beneficary/{id}', 'BeneficiaryController@del_beneficary');
    /*benefcry end*/

Route::get('/delete-msg/{id}', 'Telephonebanking@del_ivr_msg');

Route::get('/delete-sus-status/{id}', 'Telephonebanking@del_sus_status');

Route::get('/delete-transfer-status/{id}', 'Telephonebanking@del_tra_status');

Route::get('view-ivr-message',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@ivr_message'
])->name('ivr-message');

Route::get('view-suspend-msg',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@ivr_suspend_msg'
])->name('ivr_suspend_msg');

Route::get('transfer-suspend-msg',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@transfer_suspend_msg'
])->name('transfer_suspend_msg');

Route::get('overdraft',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@overdraft'
]);

Route::get('add_overdraft',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_overdraft'
]);

Route::post('add_overdraft_now',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@add_overdraft_now'
]);

Route::get('/dlt_overdraft/{id}', 'Telephonebanking@dlt_overdraft');


Route::get('access-token',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@access_token'
])->name('access-token');


Route::get('language_control',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@language_control'
])->name('language_control');


Route::post('language_control_update',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@language_control_update'
]);
/*
Route::get('/view-ivr-message', 'Telephonebanking@ivr_message')->name('ivr-message');*/
Route::get('/twilio-number', 'TwilioManagement@view_number')->name('twilio-number');
Route::get('/twilio-purchase/{number}', 'TwilioManagement@purchase_number')->name('twilio-purchase');
Route::get('/twilio-delete-number/{number}', 'TwilioManagement@delete_number')->name('twilio-delete-number');
Route::get('/twilio-number', 'TwilioManagement@view_number')->name('twilio-number');

Route::middleware('ivr.clean')->group(function () {

Route::get('/ivr', 'ivr\IvrController@index')->name('ivr');
Route::get('/ivr-fail', 'ivr\IvrController@ivr_fail')->name('ivr-fail');
Route::get('/ivr-status', 'ivr\IvrController@ivr_status')->name('ivr-status');
Route::get('/handle-language-input', 'ivr\IvrController@handle_language_input')->name('handle-language-input');
Route::get('/handle-input/{lang}', 'ivr\IvrController@handle_input')->name('handle-input');
Route::get('/access_token/{lang}', 'ivr\IvrController@access_token')->name('handle-input');

Route::get('/handle_customer_id', 'ivr\IvrController@handle_customer_id')->name('handle_customer_id');

Route::get('/handle-input-mapped/{lang}', 'ivr\IvrController@handle_input_mapped')->name('handle-input-mapped');
Route::get('/handle-input-mapped-1/{lang}', 'ivr\IvrController@handle_input_mapped_1')->name('handle-input-mapped-1');

Route::get('/customerID-login/{lang}', 'ivr\IvrLoginController@customerID_login')->name('customerID-login');
Route::get('/userID-login/{lang}/{customerID}', 'ivr\IvrLoginController@userID_login')->name('userID-login');
Route::get('/pin-login/{lang}/{customerID}/{userID}', 'ivr\IvrLoginController@pin_login')->name('pin-login');
Route::get('/welcome-user/{lang}/{userID}', 'ivr\IvrLoginController@welcome_user')->name('welcome-user');
Route::get('/welcome-user-2/{lang}/{userID}', 'ivr\IvrLoginController@welcome_user_2')->name('welcome-user-2');
Route::get('/welcome-user-3/{lang}/{userID}', 'ivr\IvrLoginController@welcome_user3')->name('welcome-user-3');

Route::get('/transfer-type/{lang}/{userID}', 'ivr\IvrTransferController@transfer_type')->name('transfer-type');
Route::get('/transfer_acc_process/{lang}/{userID}/{type}', 'ivr\IvrTransferController@transfer_acc_process')->name('transfer_acc_process');
Route::get('/transfer_acc_process_1/{lang}/{userID}/{type}/{accountid}', 'ivr\IvrTransferController@transfer_acc_process_1')->name('transfer_acc_process_1');
Route::get('/transfer_acc_process_2/{lang}/{userID}/{type}/{accountid}', 'ivr\IvrTransferController@transfer_acc_process_2')->name('transfer_acc_process_2');
Route::get('/transfer_acc_process_3/{lang}/{userID}/{type}/{fromaccountid}/{toaccountid}', 'ivr\IvrTransferController@transfer_acc_process_3')->name('transfer_acc-process_3');
Route::get('/transfer_acc_process_4/{lang}/{userID}/{type}/{fromaccountid}/{toaccountid}', 'ivr\IvrTransferController@transfer_acc_process_4')->name('transfer_acc_process_4');
Route::get('/transfer_acc_process_5/{lang}/{userID}/{type}/{fromaccountid}/{toaccountid}', 'ivr\IvrTransferController@transfer_acc_process_5')->name('transfer_acc_process_5');
Route::get('/transfer_acc_process_6/{lang}/{userID}/{type}/{fromaccountid}/{toaccountid}/{amount}', 'ivr\IvrTransferController@transfer_acc_process_6')->name('transfer_acc_process_6');
Route::get('/transfer_token_1/{lang}/{userID}/{type}/{tran_id}', 'ivr\IvrTransferController@transfer_token_1')->name('transfer_token_1');
Route::get('/transfer_token_2/{lang}/{userID}/{type}/{tran_id}', 'ivr\IvrTransferController@transfer_token_2')->name('transfer_token_2');
Route::get('/transfer_token_3/{lang}/{userID}/{type}/{tran_id}', 'ivr\IvrTransferController@transfer_token_3')->name('transfer_token_3');

Route::get('/t_benefi/{lang}/{userID}', 'ivr\IvrAccountController@t_benefi')->name('t_benefi');
Route::get('/t_details/{lang}/{userID}', 'ivr\IvrAccountController@t_details')->name('t_details');
Route::get('/t_details1/{lang}/{userID}', 'ivr\IvrAccountController@t_details1')->name('t_details1');
Route::get('/account-balance-login/{lang}/{userID}', 'ivr\IvrAccountController@account_balance_login')->name('account-balance-login');
Route::get('/account-balance-repeat/{lang}/{userID}/{accountNum}', 'ivr\IvrAccountController@account_balance_repeat')->name('account-balance-repeat');

Route::get('/credit-process/{lang}/{userID}', 'ivr\IvrCreditController@credit_process')->name('credit-process');
Route::get('/credit-process-1/{lang}/{userID}', 'ivr\IvrCreditController@credit_process_1')->name('credit-process-1');
Route::get('/credit-process-5/{lang}/{userID}', 'ivr\IvrCreditController@credit_process_5')->name('credit-process-5');

});



    /*twilio end*/

Route::get('edit-customer/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@editCustomer'
]);

Route::get('view-customer/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewCustomer'
]);

Route::post('update-customer',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateCustomer'
]);

Route::get('approve-access/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@approveAccess'
]);

Route::get('deny-access/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@denyAccess'
]);

Route::get('suspend-access/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@suspendAccess'
]);

Route::get('activate-access/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@activateAccess'
]);
Route::get('block-access/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@blockaccess'
]);
Route::get('temporary-access/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@temporaryaccess'
]);

Route::get('delete-customer/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteCustomer'
]);

/* Account Routing */
Route::get('add-account/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@addAccount'
]);

Route::post('insert-account',[
    'middleware' => 'Auth',
    'uses' => 'Customer@insertAccount'
]);

Route::get('view-accounts/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewAccounts'
]);

Route::get('edit-account/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@editAccount'
]);

Route::post('update-account',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateAccount'
]);

Route::get('view-account/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewAccount'
]);

Route::get('delete-account/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteAccount'
]);

Route::get('suspend-account/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@suspendAccount'
]);
Route::get('block-user-account/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@block_single_account'
]);
Route::get('temporary-user-suspend-accountt/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@temporarysingle_suspendAccount'
]);

Route::get('activate-account/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@activateAccount'
]);

Route::get('hide-account/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@hideAccount'
]);

Route::get('show-account/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@showAccount'
]);

/* Deposit Routing */

Route::get('add-deposit/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@addDeposit'
]);

Route::post('insert-deposit',[
    'middleware' => 'Auth',
    'uses' => 'Customer@insertDeposit'
]);



Route::post('statement_loop',[
    'middleware' => 'Auth',
    'uses' => 'Customer@statement_loop'
]);

Route::get('view-deposits/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewDeposits'
]);

Route::get('edit-deposit/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@editDeposit'
]);

Route::post('update-deposit',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateDeposit'
]);

Route::get('delete-deposit/{id}/{account_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteDeposit'
]);

/* Withdrawal Routing */

Route::get('add-withdrawal/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@addWithdrawal'
]);

Route::post('insert-withdrawal',[
    'middleware' => 'Auth',
    'uses' => 'Customer@insertWithdrawal'
]);

Route::get('view-withdrawals/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewWithdrawals'
]);

Route::get('edit-withdrawal/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@editWithdrawal'
]);

Route::post('update-withdrawal',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateWithdrawal'
]);

Route::get('delete-withdrawal/{id}/{account_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteWithdrawal'
]);

/* Transfer Routing */
Route::get('all-local-transfers/{id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@allLocalTransfers'
]);

Route::get('mark-transfer-complete/{tran_id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@markTransferComplete'
]);

Route::get('edit-transfer/{tran_id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@editTransfer'
]);

Route::post('update-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateTransfer'
]);

Route::get('delete-transfer/{tran_id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteTransfer'
]);

Route::get('all-international-transfers/{id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@allInternationalTransfers'
]);

Route::get('edit-international-transfer/{tran_id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@editInternationalTransfer'
]);

Route::post('update-international-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateInternationalTransfer'
]);

Route::get('mark-international-transfer-complete/{tran_id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@markInternationalTransferComplete'
]);

Route::get('delete-international-transfer/{tran_id}', [
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteInternationalTransfer'
]);

/* Card Routing */
Route::get('add-card/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@addCard'
]);

Route::post('insert-card',[
    'middleware' => 'Auth',
    'uses' => 'Customer@insertCard'
]);

Route::get('view-cards/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewCards'
]);

Route::get('edit-card/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@editCard'
]);

Route::post('update-card',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateCard'
]);

Route::get('approve-card/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@approveCard'
]);

Route::post('update-approve-card',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateApproveCard'
]);

Route::get('view-card/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewCard'
]);

Route::get('delete-card/{id}/{customer_id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteCard'
]);

/* Transaction Routing */

Route::get('view-transactions/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewTransactions'
]);

/* Support Message Routing */
Route::get('create-message',[
    'middleware' => 'Auth',
    'uses' => 'Support@createMessage'
]);

Route::post('insert-email-message',[
    'middleware' => 'Auth',
    'uses' => 'Support@insertEmailMessage'
]);

Route::post('insert-sms-push',[
    'middleware' => 'Auth',
    'uses' => 'Support@insertSMSPush'
]);

Route::get('sent-messages',[
    'middleware' => 'Auth',
    'uses' => 'Support@sentMessages'
]);
Route::get('received-messages',[
    'middleware' => 'Auth',
    'uses' => 'Support@receivedMessages'
]);

Route::get('view-message/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Support@viewMessage'
]);

Route::get('delete-message/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Support@deleteMessage'
]);

/* Branch Routing */
Route::get('branches',[
    'middleware' => 'Auth',
    'uses' => 'Branch@index'
]);

Route::get('add-branch',[
    'middleware' => 'Auth',
    'uses' => 'Branch@addBranch'
]);

Route::post('insert-branch',[
    'middleware' => 'Auth',
    'uses' => 'Branch@insertBranch'
]);

Route::get('edit-branch/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Branch@editBranch'
]);

Route::post('update-branch',[
    'middleware' => 'Auth',
    'uses' => 'Branch@updateBranch'
]);

Route::get('delete-branch/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Branch@deleteBranch'
]);

/* Account Managers Routing */

Route::get('add-account-manager',[
    'middleware' => 'Auth',
    'uses' => 'Customer@addAccountManager'
]);

Route::post('insert-account-manager',[
    'middleware' => 'Auth',
    'uses' => 'Customer@insertAccountManager'
]);

Route::get('view-account-managers',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewAccountManagers'
]);

Route::get('edit-account-manager/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@editAccountManager'
]);

Route::post('update-account-manager',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateAccountManager'
]);

Route::get('delete-account-manager/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@deleteAccountManager'
]);

Route::get('view-loans/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewLoans'
]);

Route::get('approve-loan/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@approveLoan'
]);

Route::post('update-approve-loan',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateApproveLoan'
]);

Route::get('view-limits/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@viewLimits'
]);

Route::get('approve-limit/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@approveLimit'
]);

Route::get('deny-limit/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@denyLimit'
]);

Route::get('edit-limit/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Customer@editLimit'
]);

Route::post('update-limit',[
    'middleware' => 'Auth',
    'uses' => 'Customer@updateLimit'
]);

Route::get('pop_pages',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@pop_pages'
]);

Route::post('pop_pages_save',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@pop_pages_save'
]);

Route::post('pop_pages_update',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@pop_pages_update'
]);

Route::get('pop_pages_delete/{id}',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@pop_pages_delete'
]);

//Kava 
Route::get('profile-status-message/{id}',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@profileStatus'
]);

Route::post('profile-status-message',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@profileStatusUpdate'
]);
Route::get('loan-landing-cms',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@loanLandingPage'
]);

Route::post('loan-landing-cms',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@loanLandingPageSave'
]);

Route::get('transfer-footer',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@tranferFooter'
]);

Route::post('transfer-footer',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@tranferFooterSave'
]);

Route::get('telex-stamp',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@telexStamp'
]);

Route::post('telex-stamp',[
    'middleware' => 'Auth',
    'uses' => 'CmsSection@telexStampSave'
]);

Route::post('order-card',[
    'middleware' => 'Auth',
    'uses' => 'OthersController@orderCard'
]);

Route::post('request-feature',[
    'middleware' => 'Auth',
    'uses' => 'OthersController@requestFeature'
]);

Route::post('order-twilio',[
    'middleware' => 'Auth',
    'uses' => 'OthersController@orderTwilio'
]);

Route::get('purchase-key',[
    'middleware' => 'guest',
    'uses' => 'Dashboard@addPurchaseKey'
])->name('purchase-key');

Route::post('save-purchase-key',[
    'middleware' => 'guest',
    'uses' => 'Dashboard@savePurchaseKey'
]);

Route::get('protection_one',[
    
    'uses' => 'Dashboard@protection_one'
]);

Route::get('protection_two',[
    
    'uses' => 'Dashboard@protection_two'
]);


Route::post('access_token_onoff',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@access_token_onoff'
]);

Route::post('suspend_status_position',[
    'middleware' => 'Auth',
    'uses' => 'Telephonebanking@suspend_status_position'
]);



Route::get('currency_manage',[

    'uses' => 'Dashboard@currency_manage'
]);

Route::get('cloudflare_control',[

    'uses' => 'Dashboard@cloudflare_control'
]);

Route::get('add_currency',[

    'uses' => 'Dashboard@add_currency'
]);

Route::post('add_now_currency',[

    'uses' => 'Dashboard@add_now_currency'
]);


Route::get('edit_currency/{id}',[

    'uses' => 'Dashboard@edit_currency'
]);

Route::post('update_currency',[

    'uses' => 'Dashboard@update_currency'
]);

Route::get('delete_currency/{id}',[

    'uses' => 'Dashboard@delete_currency'
]);
