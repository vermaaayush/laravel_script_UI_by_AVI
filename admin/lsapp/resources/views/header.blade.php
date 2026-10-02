<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin</title>

    <!-- plugins:css -->

    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">

    <!-- endinject -->

    <!-- Plugin css for this page -->

    <!-- End plugin css for this page -->

    <!-- inject:css -->

    <!-- endinject -->

    <!-- Layout styles -->

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">

  </head>



  <body>



    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->

      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

          <a class="navbar-brand brand-logo" href="{{ asset('dashboard') }}"><img src="{{ asset('images/logo.svg') }}" alt="logo" /></a>

          <a class="navbar-brand brand-logo-mini" href="{{ asset('dashboard') }}"><img src="{{ asset('images/logo-mini.svg') }}" alt="logo" /></a>

        </div>

        <div class="navbar-menu-wrapper d-flex align-items-stretch">

          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">

            <span class="mdi mdi-menu"></span>

          </button>

          <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">

              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <div class="nav-profile-img">

                  <img src="{{ asset('images/faces/face1.jpg') }}" alt="image">

                  <span class="availability-status online"></span>

                </div>

                <div class="nav-profile-text">

                  <p class="mb-1 text-black">{{ Session::get('name') }}</p>

                </div>

              </a>

              <div class="dropdown-menu navbar-dropdown" role="menu" aria-labelledby="profileDropdown">

                <a class="dropdown-item" href="{{ asset('activity-log') }}">

                  <i class="mdi mdi-cached mr-2 text-success"></i> Activity Log </a>

                  <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ asset('system-config') }}">

                  <i class="mdi mdi-settings mr-2 text-primary"></i> System Config </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ asset('logout') }}">

                  <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>

              </div>

            </li>

            <li class="nav-item d-none d-lg-block full-screen-link">

              <a class="nav-link">

                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>

              </a>

            </li>


          </ul>

          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">

            <span class="mdi mdi-menu"></span>

          </button>

        </div>

      </nav>





      <!-- partial -->

      <div class="container-fluid page-body-wrapper">



        <!-- partial:partials/_sidebar.html -->

        <nav class="sidebar sidebar-offcanvas" id="sidebar">



          <ul class="nav">

            <li class="nav-item nav-profile">

              <a href="#" class="nav-link">

                <div class="nav-profile-image">

                  <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile">

                  <span class="login-status online"></span>

                  <!--change to offline or busy as needed-->

                </div>

                <div class="nav-profile-text d-flex flex-column">

                  <span class="font-weight-bold mb-2">{{ Session::get('name') }}</span>

                  <!-- <span class="text-secondary text-small">Account Manager</span> -->

                </div>

                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>

              </a>

            </li> <!-- user profile info -->



            <li class="nav-item">

              <a class="nav-link" href="{{ asset('dashboard') }}">

                <span class="menu-title">Dashboard</span>

                <i class="mdi mdi-home menu-icon"></i>

              </a>

            </li>  <!--Dashboard Tab -->



            <!-- <li class="nav-item @if($module ?? '' && $module == 'customer') active @endif">
              @if($module ?? '' && $module == 'customer')
              <a class="nav-link" data-toggle="collapse" href="#ui-basic"  aria-expanded="true" aria-controls="ui-basic">
                @else 
                <a class="nav-link" data-toggle="collapse" href="#ui-basic"  aria-expanded="true" aria-controls="ui-basic">

                @endif -->

                <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic"  aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">User Management</span>

                <i class="menu-arrow"></i>

                <i class="mdi mdi-account-settings menu-icon"></i>

              </a>

              <div class="collapse" id="ui-basic">

                <ul class="nav flex-column sub-menu">

                  <li class="nav-item"> <a class="nav-link" href="{{ asset('add-customer') }}">Add Customer</a></li>

                  <li class="nav-item"> <a class="nav-link" href="{{ asset('view-customers') }}">View All Customer</a></li>
                   <li class="nav-item"> <a class="nav-link" href="{{ asset('form-settings') }}">Account Opening Forms</a></li>
                   <li class="nav-item"> <a class="nav-link" href="{{ asset('customer-activities') }}">Customer Activities</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{ asset('security-questions') }}">Security Questions</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{ asset('bankaccount-types') }}">Bank Account Types</a></li>
                  <li class="nav-item"> <a class="nav-link" href="{{ asset('statement-maker') }}">Statement Maker</a></li>
                  <!--<li class="nav-item"> <a class="nav-link" href="{{ asset('limit-request') }}">Limit Requests</a></li>-->
                  <!-- <li class="nav-item"> <a class="nav-link" href="{{ asset('ib-form-settings') }}">Internet Banking Forms</a></li><!---->

                </ul>

              </div>

            </li> <!--User Management -->



            <li class="nav-item">

              <a class="nav-link" href="{{ asset('branches') }}">

                <span class="menu-title">Branches</span>

                <i class="mdi mdi-lan menu-icon"></i>

              </a>

            </li>   <!-- Branches Tab -->


            <li class="nav-item">

                        <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false"

                            aria-controls="general-pages">

                            <span class="menu-title">Support Message</span>

                            <i class="menu-arrow"></i>

                            <i class="mdi mdi-message menu-icon"></i>

                        </a>

                        <div class="collapse" id="general-pages">

                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link" href="{{ asset('create-message') }}"> Create

                                        Message </a></li>

                                <!-- <li class="nav-item"> <a class="nav-link" href="../support/inbox.html"> Inbox

                                        Messages</a></li> -->

                                <li class="nav-item"> <a class="nav-link" href="{{ asset('sent-messages') }}"> Sent

                                        Messages</a></li>
                                        
                                          <li class="nav-item"> <a class="nav-link" href="{{ asset('received-messages') }}"> Received

                                        Messages</a></li>

                            </ul>

                        </div>

                    </li>  <!-- Support Message Tab -->
              <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-account-manager"  aria-expanded="false" aria-controls="ui-account-manager">
                <span class="menu-title">Account Manager</span>

                <i class="menu-arrow"></i>

                <i class="mdi mdi-account-settings menu-icon"></i>

              </a>

              <div class="collapse" id="ui-account-manager">

                <ul class="nav flex-column sub-menu">

                  <li class="nav-item"> <a class="nav-link" href="{{ asset('add-account-manager') }}">Add Account Manager</a></li>

                  <li class="nav-item"> <a class="nav-link" href="{{ asset('view-account-managers') }}">View All Account Managers</a></li>

                </ul>

              </div>

            </li>
        
      <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#TelephoneBanking"  aria-expanded="false" aria-controls="TelephoneBanking">
                <span class="menu-title">Telephone Banking Setup</span>
                  <i class="menu-arrow"></i>
                <i class="mdi mdi-cellphone menu-icon"></i>

              </a>

              <div class=" {{ Request::is('add-beneficiaries') ? 'expand' : ""}}{{ Request::is('add-message') ? 'expand' : ""}}{{ Request::is('add-numbers') ? 'expand' : ""}}{{ Request::is('purchase-twilio-numbers') ? 'expand' : ""}}{{ Request::is('add-tokens') ? 'expand' : ""}}collapse" id="TelephoneBanking">

                <ul class=" nav flex-column sub-menu">
                  <li class="nav-item"><a class="{{ Request::is('add-message') ? 'active ' : ""}}nav-link" href="{{ asset('bank_name')}}">Configure additional banks</a></li>

                  <li class="nav-item"> <a class="nav-link" href="{{ asset('view-call-log') }}">View Call Logs</a></li>

                  <li class="nav-item"><a class="{{ Request::is('add-numbers') ? 'active ' : ""}}nav-link" href="{{ asset('support-management')}}">Support Managemnet</a></li>

                  <li class="nav-item"><a class="{{ Request::is('purchase-twilio-numbers') ? 'active ' : ""}}nav-link" href="{{ asset('twilio-number')}}">Twilio Numbers</a></li>
                  
                  <li class="nav-item"><a class="{{ Request::is('add-message') ? 'active ' : ""}}nav-link" href="{{ asset('view-ivr-message')}}">IVR Message Management</a></li>
                  <li class="nav-item"><a class="{{ Request::is('add-beneficiaries') ? 'active ' : ""}}nav-link" href="{{ asset('view-beneficiary')}}">Manage Beneficiary </a></li>
                   <li class="nav-item"><a class="{{ Request::is('add-tokens') ? 'active ' : ""}}nav-link" href="{{ asset('view-token')}}">IVR Tokens </a></li>
                   <li class="nav-item"><a class="{{ Request::is('view-suspend-msg') ? 'active ' : ""}}nav-link" href="{{ asset('view-suspend-msg')}}">IVR Bank Account Suspend Status</a></li>
                <li class="nav-item"><a class="{{ Request::is('transfer-suspend-msg') ? 'active ' : ""}}nav-link" href="{{ asset('transfer-suspend-msg')}}">IVR Transfer Suspend Status</a></li>
                <li class="nav-item"><a class="{{ Request::is('access-token') ? 'active ' : ""}}nav-link" href="{{ asset('access-token')}}">Access Token</a></li>
                  <li class="nav-item"><a class="{{ Request::is('overdraft') ? 'active ' : ""}}nav-link" href="{{ asset('overdraft')}}">Overdraft</a></li>
                 
                </ul> 

              </div>

            </li>
            <!--transfers Management-->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#transfer"  aria-expanded="false" >
                <span class="menu-title">User Transfer</span>
                  <i class="menu-arrow"></i>
                <i class="mdi mdi-money-check menu-icon"></i>

              </a>

              <div class=" {{ Request::is('transfer') ? 'expand' : ""}}collapse" id="transfer">
                <ul class=" nav flex-column sub-menu">
                    <li class="nav-item"><a class="{{ Request::is('transfer-all') ? 'active ' : ""}}nav-link" href="{{ asset('transfer-all')}}">Transfers</a></li>
                    <!--<li class="nav-item"><a class="{{ Request::is('transfer-owm') ? 'active ' : ""}}nav-link" href="{{ asset('transfer-owm')}}">Own Account</a></li>-->
                    <!--<li class="nav-item"><a class="{{ Request::is('transfer-same') ? 'active ' : ""}}nav-link" href="{{ asset('transfer-same')}}">Same Bank</a></li>-->
                    <li class="nav-item"><a class="{{ Request::is('transfer-other') ? 'active ' : ""}}nav-link" href="{{ asset('transfer-other')}}">Other Bank</a></li>
                </ul> 
              </div>
            </li>
            
            
            {{-- User withdrawal --}}
             <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#withdrawal"  aria-expanded="false" aria-controls="withdrawal">
                <span class="menu-title">User Withdrawals</span>
                  <i class="menu-arrow"></i>
                <i class="mdi mdi-money-check menu-icon"></i>

              </a>

              <div class=" {{ Request::is('user-withdrawal') ? 'expand' : ""}}collapse" id="withdrawal">

                <ul class=" nav flex-column sub-menu">
                 
                  <li class="nav-item"><a class="{{ Request::is('user-withdrawal') ? 'active ' : ""}}nav-link" href="{{ asset('user-withdrawal')}}">New withdrawals</a></li>
                  <li class="nav-item"><a class="{{ Request::is('awaiting-withdrawal') ? 'active ' : ""}}nav-link" href="{{ asset('awaiting-withdrawal')}}">Awaiting Confirmation</a></li>
                  <li class="nav-item"><a class="{{ Request::is('approved-withdrawal') ? 'active ' : ""}}nav-link" href="{{ asset('approved-withdrawal')}}">Approved withdrawals</a></li>
                  <li class="nav-item"><a class="{{ Request::is('rejected-withdrawal') ? 'active ' : ""}}nav-link" href="{{ asset('rejected-withdrawal')}}">Rejected withdrawals</a></li>
                    <li class="nav-item"><a class="{{ Request::is('withdraw-methods') ? 'active ' : ""}}nav-link" href="{{ asset('withdraw-methods')}}">Withdrawal Methods</a></li>
                </ul> 

              </div>

            </li>
            
            <!--Deposit Management-->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#deposit"  aria-expanded="false" >
                <span class="menu-title">User Deposit</span>
                  <i class="menu-arrow"></i>
                <i class="mdi mdi-money-check menu-icon"></i>

              </a>

              <div class=" {{ Request::is('deposit-methods') ? 'expand' : ""}}collapse" id="deposit">

                <ul class=" nav flex-column sub-menu">
                    
                    <li class="nav-item"><a class="{{ Request::is('deposit-new') ? 'active ' : ""}}nav-link" href="{{ asset('deposit-new')}}">New Deposit</a></li>
                    <li class="nav-item"><a class="{{ Request::is('deposit-approved') ? 'active ' : ""}}nav-link" href="{{ asset('deposit-approved')}}">Approved Deposit</a></li>
                    <li class="nav-item"><a class="{{ Request::is('deposit-rejected') ? 'active ' : ""}}nav-link" href="{{ asset('deposit-rejected')}}">Rejected Deposit</a></li>
                  <li class="nav-item"><a class="{{ Request::is('deposit-methods') ? 'active ' : ""}}nav-link" href="{{ asset('deposit-methods')}}">Deposit Methods</a></li>
                 
                </ul> 

              </div>

            </li>
            
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#payments"  aria-expanded="false" >
                <span class="menu-title">Payments & Collection</span>
                  <i class="menu-arrow"></i>
                <i class="mdi mdi-money-check menu-icon"></i>

              </a>

              <div class=" {{ Request::is('deposit-methods') ? 'expand' : ""}}collapse" id="payments">

                <ul class=" nav flex-column sub-menu">
                    
                    <li class="nav-item"><a class="{{ Request::is('payment-new') ? 'active ' : ""}}nav-link" href="{{ asset('payment-new')}}">Create Invoice</a></li>
                    <li class="nav-item"><a class="{{ Request::is('invoices') ? 'active ' : ""}}nav-link" href="{{ asset('invoices')}}">Invoices</a></li>
                    <li class="nav-item"><a class="{{ Request::is('pending-payments') ? 'active ' : ""}}nav-link" href="{{ asset('pending-payments')}}">Pending Payments</a></li>
                    <li class="nav-item"><a class="{{ Request::is('inv-payment-methods') ? 'active ' : ""}}nav-link" href="{{ asset('inv-payment-methods')}}">Payment Methods</a></li>
                </ul> 

              </div>

            </li>
            
            {{--  sms management --}}
           <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#sms_manage"  aria-expanded="false" aria-controls="sms_manage">
                <span class="menu-title">Sms Management</span>
                  <i class="menu-arrow"></i>
                <i class="mdi mdi-message menu-icon "></i>

              </a>

              <div class=" {{ Request::is('sms-editor') ? 'expand' : ""}}collapse" id="sms_manage">

                <ul class=" nav flex-column sub-menu">
                 
                  <li class="nav-item"><a class="{{ Request::is('sms-editor') ? 'active ' : ""}}nav-link" href="#" data-toggle="modal" data-target="#exampleModal2">
                    Sms Editor
                  </a></li>
                   <li class="nav-item"><a class="{{ Request::is('sms-list') ? 'active ' : ""}}nav-link" href="{{ asset('sms-list')}}">
                    View all Sms 
                  </a></li>
                   <li class="nav-item"><a class="{{ Request::is('sms-restriction') ? 'active ' : ""}}nav-link" href="{{ asset('sms-restriction')}}">
                    Sms restriction
                  </a></li>
                 
                </ul> 

              </div>

            </li>
              {{--  email management --}}
           <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#email_manage"  aria-expanded="false" aria-controls="email_manage">
                <span class="menu-title">Email Management</span>
                  <i class="menu-arrow"></i>
                <i class="mdi mdi-message menu-icon "></i>

              </a>

              <div class=" {{ Request::is('email-editor') ? 'expand' : ""}}collapse" id="email_manage">

                <ul class=" nav flex-column sub-menu">
                 
                  <li class="nav-item"><a class="{{ Request::is('email-editor') ? 'active ' : ""}}nav-link" href="{{ asset('email-editor')}}" >
                    Email Editor
                  </a></li>
                   <li class="nav-item"><a class="{{ Request::is('email-list') ? 'active ' : ""}}nav-link" href="{{ asset('email-list')}}">
                    View all Emails 
                  </a></li>
                   <li class="nav-item"><a class="{{ Request::is('email-restriction') ? 'active ' : ""}}nav-link" href="{{ asset('email-restriction')}}">
                    Email restriction
                  </a></li>
                 
                </ul> 

              </div>

            </li>

            <li class="nav-item">

            </li>   <!-- Telephone Tab -->
            
            <!-- Cms Section -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#cmsSection"  aria-expanded="false" aria-controls="cmsSection">
                    <span class="menu-title">Cms Management</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-message menu-icon "></i>
                </a>
                <div class=" {{ Request::is('pop_pages') ? 'expand' : ""}}collapse" id="cmsSection">
                    <ul class=" nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="{{ Request::is('pop_pages') ? 'active ' : ""}}nav-link" href="{{ asset('pop_pages')}}">
                                Page Popups
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ Request::is('') ? 'active ' : ""}}nav-link" href="{{ asset('loan-landing-cms')}}">
                                Loan landing page
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ Request::is('transfer-footer') ? 'active ' : ""}}nav-link" href="{{ asset('transfer-footer')}}">
                                Tranfer Footer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ Request::is('telex-stamp') ? 'active ' : ""}}nav-link" href="{{ asset('telex-stamp')}}">
                                Telex Stamp
                            </a>
                        </li>
                    </ul> 
                </div>
            </li>
            <!-- Cms Section -->

            <!-- Database Settings -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#databaseSettings"  aria-expanded="false" aria-controls="databaseSettings">
                    <span class="menu-title">Database</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-settings menu-icon "></i>
                </a>
                <div class=" {{ Request::is('clear-table') ? 'expand' : ""}}collapse" id="databaseSettings">
                    <ul class=" nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="{{ Request::is('clear-table') ? 'active ' : ""}}nav-link" href="#" data-toggle="modal" data-target="#exampleModal">
                                Clear Tables
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="{{ Request::is('get-backup') ? 'active ' : ""}}nav-link" href="{{ url('get-backup')}}">
                                Get Backup
                            </a>
                        </li>
                        
                    </ul> 
                </div>
            </li>
            <!-- Database Settings -->
            
             <li class="nav-item">

              <a class="nav-link" href="{{ asset('currency_manage') }}">

                <span class="menu-title">Currency Management</span>

                <i class="mdi mdi-currency-usd menu-icon"></i>

              </a>

            </li> <!-- LogOut Tab -->
          <li class="nav-item">
  <a class="nav-link"
     href="https://ibank.firstallianzgroup.com/admin/cloudflare_control.php"
     target="_blank"
     rel="noopener noreferrer">
     
    <span class="menu-title">Cloudflare Control</span>
    <i class="mdi mdi-currency-usd menu-icon"></i>
  </a>
</li>
 <!-- LogOut Tab -->
            
             <!-- Crypto fund management -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#crpto_setting"  aria-expanded="false" aria-controls="crpto_setting">
                    <span class="menu-title">Crypto Management</span>
                    <i class="menu-arrow"></i>
                   <i class="mdi mdi-lan menu-icon"></i>
                </a>
                <div class=" {{ Request::is('clear-table') ? 'expand' : ""}}collapse" id="crpto_setting">
                    <ul class=" nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="{{ Request::is('wallet_finder') ? 'active ' : ""}}nav-link" href="{{ url('wallet_finder')}}" >
                                Wallet Finder
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="{{ Request::is('crypto_deposit') ? 'active ' : ""}}nav-link" href="{{ url('crypto_deposit')}}">
                                Crypto Deposit
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="{{ Request::is('trs_history') ? 'active ' : ""}}nav-link" href="{{ url('trs_history')}}">
                                Transaction History
                            </a>
                        </li>
                        
                         <li class="nav-item">
                            <a class="{{ Request::is('all_send_tranx') ? 'active ' : ""}}nav-link" href="{{ url('all_send_tranx')}}">
                                All Send Transaction 
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="{{ Request::is('all_send_tranx') ? 'active ' : ""}}nav-link" href="{{ url('usdt_wallet_info')}}">
                                USDT Wallet details
                            </a>
                        </li>
                        
                    </ul> 
                </div>
            </li>
            <!-- Database Settings -->

            <li class="nav-item">

              <a class="nav-link" href="{{ asset('logout') }}">

                <span class="menu-title">LogOut</span>

                <i class="mdi mdi-power menu-icon"></i>

              </a>

            </li> <!-- LogOut Tab -->

          </ul>

        </nav>
        
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Password Protection</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  action="protection_one" method="get" >
            <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="pin"  value="" required placeholder="Enter Password" />
                  </div>
            <button type="submit" class="btn btn-primary">Enter</button>
        </form>
      </div>
     
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Password Protection</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  action="protection_two" method="get" >
            <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="pin"  value="" required placeholder="Enter Password" />
                  </div>
            <button type="submit" class="btn btn-primary">Enter</button>
        </form>
      </div>
     
    </div>
  </div>
</div>

