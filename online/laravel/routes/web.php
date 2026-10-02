<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main;
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
/*
 'code_2' => 'required|numeric|digits:4',*/


 //Clear route cache:
 Route::get('/route-cache', function() {
     $exitCode = Artisan::call('route:cache');
     return 'Routes cache cleared';
 });
 
   Route::post('/usdt-generate-wallet', [Main::class, 'usdt_generate_wallet'])->name('usdt.generate.wallet');
   
 Route::post('/generate-wallet', [Main::class, 'generateWallet'])->name('generate.wallet');

Route::post('/btc-generate-wallet', [Main::class, 'btcGenerateWallet'])->name('btc.generate.wallet');

Route::get('/ipn_callback', [Main::class, 'ipn_callback'])->name('ipn_callback');

Route::get('/ipn', [Main::class, 'logIPNData']);

Route::post('/send_funds/{user_id}', [Main::class, 'send_funds']);

Route::get('/success_transfer_confirm', function () { return view('success_transfer_confirm'); });

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

Route::get('/depo-test',[
	'middleware' => 'Auth',
    'uses' => 'DepositController@payPayKassa'
]);

Route::get('/portfolio',[
	'middleware' => 'Auth',
    'uses' => 'Main@portfolio'
]);

Route::get('/',[
	'middleware' => 'Auth',
    'uses' => 'Main@index'
]);

Route::get('print_summary',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@print_summary'
]);


Route::get('login',[
    'uses' => 'Main@login'
]);

Route::get('captcha',[
    'uses' => 'Main@captcha'
]);

Route::post('change', [
    'uses' => 'Open@change'
]);

//Route::post('change', function (){
//
//    dd(\Illuminate\Support\Facades\Session::get('user_id'));
//    $user = \Illuminate\Support\Facades\Session::get('user_id');
//    DB::table('ba_account_holders')->where('user_id',$user)->delete();
//    DB::table('ba_user_accounts')->where('user_id',$user)->delete();
//    return redirect()->intended('login');
//});

Route::post('loginUser',[
    'uses' => 'Main@loginUser'
]);

Route::get('secret-question',[
    'uses' => 'Main@secretQuestion'
]);
Route::get('Controller',[
    'middleware' => 'Auth',
    'uses' => ' Controller@user_notifactions'
]);
Route::get('viewProfile',[
    'middleware' => 'Auth',
    'uses' => 'profile@viewProfile'
]);
Route::get('editProfile',[
    'middleware' => 'Auth',
    'uses' => 'profile@editProfile'
]);

Route::post('editProfile',[
    'middleware' => 'Auth',
    'uses' => 'profile@updateProfile'
]);

Route::post('editProfileVerify',[
    'middleware' => 'Auth',
    'uses' => 'profile@updateProfile'
]);

Route::post('validate-secret-question',[
    'uses' => 'Main@validateSecretQuestion'
]);

Route::post('generate-otp-for-profile-update',[
    'middleware' => 'Auth',
    'uses' => 'profile@generateOTPForprofileUpdate'
]);

Route::get('logout-user',[
	'uses' => 'Main@logoutUser'
]);

Route::get('accounts-summary',[
	'middleware' => 'Auth',
    'uses' => 'Account@accountsSummary'
]);

Route::get('all_crypto_history',[
	'middleware' => 'Auth',
    'uses' => 'Main@all_crypto_history'
]);

Route::get('all_send_req',[
	'middleware' => 'Auth',
    'uses' => 'Main@all_send_req'
]);

Route::get('martketplace',[
	'middleware' => 'Auth',
    'uses' => 'Main@martketplace'
]);

Route::get('news',[
	'middleware' => 'Auth',
    'uses' => 'Main@news'
]);


Route::get('transactionslist',[
	'middleware' => 'Auth',
    'uses' => 'Account@transactionslist'
]);

    /*client new beneficiary*/

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
Route::get('edit-beneficiary-same/{id}',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@edit_Beneficiary_same'
]);
Route::post('update-beneficary-same',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@update_beneficary_same'
]);
Route::post('update-beneficary',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@update_beneficary'
]);

Route::get('del-beneficary/{id}',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@del_beneficary'
]);

Route::get('success_beneficiary/{id}',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@success_beneficiary'
]);
Route::get('success_beneficiary_other/{id}',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@success_beneficiary_other'
]);

Route::get('email-verification/{id}',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@email_verification'
]);

Route::post('code-verification',[
    'middleware' => 'Auth',
    'uses' => 'BeneficiaryController@code_verification'
]);

Route::get('payment-pending',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@paymentPending'
]);

Route::get('pay-invoice',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@paymentPayForm'
]);

Route::post('pay-invoice',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@paymentPay'
]);

Route::get('change-payment-amount-inv/{id}/{amount}',[
    'middleware' => 'guest',
    'uses' => 'PaymentController@changePaymentInvoice'
]);

Route::get('approve-payment-amount-inv/{id}',[
    'middleware' => 'guest',
    'uses' => 'PaymentController@approvePaymentInvoice'
]);

Route::get('reject-payment-amount-inv/{id}',[
    'middleware' => 'guest',
    'uses' => 'PaymentController@rejectPaymentInvoice'
]);

Route::get('payment-part',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@paymentPart'
]);

Route::get('payment-full',[
    'middleware' => 'Auth',
    'uses' => 'PaymentController@paymentFull'
]);

Route::get('user-whitdrawal',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawlController@user_withdrl'
]);

Route::get('user-deposit',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@user_deposit'
]);

Route::post('user-deposit',[
    'middleware' => 'Auth',
    'uses' => 'DepositController@user_deposit_save'
]);

Route::get('user-deposit-approve/{id}',[
    'middleware' => 'guest',
    'uses' => 'DepositController@approveDeposit'
]);

Route::get('user-deposit-update-code/{id}/{price}',[
    'middleware' => 'guest',
    'uses' => 'DepositController@updateDeposit'
]);

Route::get('user-deposit-reject/{id}',[
    'middleware' => 'guest',
    'uses' => 'DepositController@rejectDeposit'
]);

Route::post('add-withdrawl',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawlController@store_withdrawl'
]);

Route::get('user-withdrawl-2/{id}',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawlController@user_withdrl2'
]);

Route::get('view-drawls',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawlController@view_withdrawls'
]);

Route::post('withdrawl-detail',[
    'middleware' => 'Auth',
    'uses' => 'WithdrawlController@update_withdrawl'
]);

    /*cleint benefsry ends*/

Route::get('account-quicklook/{id}',[
	'middleware' => 'Auth',
    'uses' => 'Account@accountQuicklook'
]);

Route::get('account-statement',[
	'middleware' => 'Auth',
    'uses' => 'Account@accountStatement'
]);

Route::post('get-account-statement',[
	'middleware' => 'Auth',
    'uses' => 'Account@getAccountStatement'
]);

Route::get('additional-accounts',[
    'middleware' => 'Auth',
    'uses' => 'Account@additionalAccounts'
]);

Route::post('additional-accounts-save',[
    'middleware' => 'Auth',
    'uses' => 'Account@additionalAccountsSave'
]);

Route::post('additional-accounts-sendpin',[
    'middleware' => 'Auth',
    'uses' => 'Account@additionalAccountsSendPin'
]);

Route::get('spend-analysis',[
    'middleware' => 'Auth',
    'uses' => 'Account@spendAna'
]);

Route::get('account-manager',[
    'middleware' => 'Auth',
    'uses' => 'Account@accountManager'
]);

Route::get('statement-to-thirdparty',[
    'middleware' => 'Auth',
    'uses' => 'Account@statementToThirdParty'
]);

Route::post('send-statement-to-thirdparty',[
    'middleware' => 'Auth',
    'uses' => 'Account@sendStatementToThirdParty'
]);

Route::get('request-card',[
    'middleware' => 'Auth',
    'uses' => 'Card@requestCard'
]);

Route::post('insert-card-request',[
    'middleware' => 'Auth',
    'uses' => 'Card@insertCardRequest'
]);

Route::get('view-cards',[
    'middleware' => 'Auth',
    'uses' => 'Card@viewCards'
]);

Route::get('suspend-card/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Card@suspendCard'
]);

Route::get('block-card/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Card@blockCard'
]);

Route::get('update-card-pin',[
    'middleware' => 'Auth',
    'uses' => 'Card@updateCardPin'
]);

Route::post('get-cards-to-update-pin',[
    'middleware' => 'Auth',
    'uses' => 'Card@getCardsToUpdatePin'
]);

Route::post('update-card-pin-db',[
    'middleware' => 'Auth',
    'uses' => 'Card@updateCardPinDB'
]);

Route::get('request-cheque-book',[
    'middleware' => 'Auth',
    'uses' => 'Cheque@requestChequeBook'
]);

Route::post('insert-cheque-book-request',[
    'middleware' => 'Auth',
    'uses' => 'Cheque@insertChequeBookRequest'
]);

Route::get('stop-cheque',[
    'middleware' => 'Auth',
    'uses' => 'Cheque@stopCheque'
]);

Route::post('insert-stop-cheque',[
    'middleware' => 'Auth',
    'uses' => 'Cheque@insertStopCheque'
]);

Route::get('stop-cheque-success',[
    'middleware' => 'Auth',
    'uses' => 'Cheque@stopChequeSuccess'
]);

Route::get('own-account-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@ownAccountTransfer'
]);

Route::post('get-accounts-to-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@getAccountsToTransfer'
]);

Route::post('initiate-own-account-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@initiateOwnAccountTransfer'
]);

Route::post('success-own-account-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@successOwnAccountTransfer'
]);

Route::get('success',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@success'
]);

Route::get('done',[
   
    'uses' => 'Transfer@done'
]);

Route::get('success_same',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@success_same'
]);

Route::get('transfer-to-same-bank',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@transferToSameBank'
]);

Route::post('initiate-same-bank-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@initiateSameBankTransfer'
]);

Route::get('same-bank-transfer-otp/{tran_id}/{step}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@sameBankTransferOTP'
]);

Route::post('success-same-bank-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@successSameBankTransfer'
]);

Route::get('finalise-same-bank-transfer/{tran_id}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@finaliseSameBankTransfer'
]);

Route::get('resume-local-transfer/{tran_id}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@resumelocalTransfer'
]);

Route::get('transfer-to-other-bank',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@transferToOtherBank'
]);

Route::post('initiate-other-bank-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@initiateOtherBankTransfer'
]);

Route::get('other-bank-transfer-otp/{tran_id}/{step}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@otherBankTransferOTP'
]);

Route::get('other-bank-transfer-otp-new/{tran_id}/{step}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@otherBankTransforOTPIVR'
]);

Route::get('successOtherBank/{tran_id}/{step}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@successOtherBank'
]);


Route::post('success-other-bank-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@successOtherBankTransfer'
]);

Route::get('finalise-other-bank-transfer/{tran_id}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@finaliseOtherBankTransfer'
]);

Route::get('resume-international-transfer/{tran_id}',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@resumeInternationalTransfer'
]);

Route::get('manage-beneficiaries',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@manageBeneficiaries'
]);



Route::get('resume-pending-transfer',[
    'middleware' => 'Auth',
    'uses' => 'Transfer@resumePendingTransfer'
]);

Route::get('request-loan',[
    'middleware' => 'Auth',
    'uses' => 'Loan@requestLoan'
]);

Route::get('request-loan-form',[
    'middleware' => 'Auth',
    'uses' => 'Loan@requestLoanForm'
]);

Route::post('insert-loan-request',[
    'middleware' => 'Auth',
    'uses' => 'Loan@insertLoanRequest'
]);

Route::get('loan-summary',[
    'middleware' => 'Auth',
    'uses' => 'Loan@loanSummary'
]);

Route::get('request-limit',[
    'middleware' => 'Auth',
    'uses' => 'Limit@requestLimit'
]);

Route::post('insert-limit-request',[
    'middleware' => 'Auth',
    'uses' => 'Limit@insertLimitRequest'
]);

Route::get('view-limits',[
    'middleware' => 'Auth',
    'uses' => 'Limit@viewLimits'
]);

Route::post('get-limits-by-account',[
    'middleware' => 'Auth',
    'uses' => 'Limit@getLimitsByAccount'
]);

Route::get('send-message',[
    'middleware' => 'Auth',
    'uses' => 'Feedback@sendMessage'
]);


Route::post('insert-send-message',[
    'middleware' => 'Auth',
    'uses' => 'Feedback@insertSendMessage'
]);

Route::get('all-messages',[
    'middleware' => 'Auth',
    'uses' => 'Feedback@allMessages'
]);

Route::get('delete-msg/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Feedback@deleteMsg'
]);

Route::get('undelete-msg/{id}',[
    'middleware' => 'Auth',
    'uses' => 'Feedback@undeleteMsg'
]);

Route::get('reset-secret',[
    'middleware' => 'Auth',
    'uses' => 'Config@resetSecret'
]);

Route::post('update-secret',[
    'middleware' => 'Auth',
    'uses' => 'Config@updateSecret'
]);

Route::get('password-update',[
    'middleware' => 'Auth',
    'uses' => 'Config@passwordUpdate'
]);

Route::post('validate-user-id',[
    'middleware' => 'Auth',
    'uses' => 'Config@validateUserID'
]);

Route::post('generate-otp-for-password-update',[
    'middleware' => 'Auth',
    'uses' => 'Config@generateOTPForPasswordUpdate'
]);

Route::post('validate-otp-for-password-update',[
    'middleware' => 'Auth',
    'uses' => 'Config@validateOTPForPasswordUpdate'
]);

Route::get('transaction-alert-activation',[
    'middleware' => 'Auth',
    'uses' => 'Config@transactionAlertActivation'
]);

Route::post('update-transaction-alert',[
    'middleware' => 'Auth',
    'uses' => 'Config@updateTransactionAlert'
]);

Route::get('update-verification',[
    'middleware' => 'Auth',
    'uses' => 'Config@updateVerification'
]);

Route::post('update-verification-db',[
    'middleware' => 'Auth',
    'uses' => 'Config@updateVerificationDB'
]);


Route::get('online-open-account',[
    'uses' => 'Open@OnlineOpenAccount'
]);
Route::post('online-open-account',[
    'uses' => 'Open@PostOnlineOpenAccount'
]);

Route::get('verifyaccount',[
    'uses' => 'Open@verifyaccount'
]);
Route::post('verifyaccount',[
    'uses' => 'Open@verifyaccountstatus'
]);

Route::post('verifyunregisteraccount',[
    'uses' => 'Main@verifyunregisteraccount'
]);
Route::get('retrieve-account-pin',[
    'uses' => 'Open@RetrieveAccountPin'
]);
Route::post('retrieve-account-pin',[
    'uses' => 'Open@PostRetrieveAccountPin'
]);

Route::get('retrieve-account-user-id',[
    'uses' => 'Open@RetrieveAccountUserid'
]);
Route::post('retrieve-account-user-id',[
    'uses' => 'Open@PostRetrieveAccountUserid'
]);



Route::get('register-new-internet-account',[
    'uses' => 'Open@RegisterNewInternetAccount'
]);
Route::get('registration-new-internet-account',[
    'uses' => 'Open@RegisterNewInternetAccount'
]);
Route::get('newaccount-steps',[
    'uses' => 'Open@NewAccountSteps'
]);

Route::get('no-key',[
    'middleware' => 'guest',
    'uses' => 'Main@noKey'
])->name('no-key');

