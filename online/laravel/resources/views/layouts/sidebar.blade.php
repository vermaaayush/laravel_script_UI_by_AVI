<div class="iq-sidebar">
  @php
  $config = DB::select('select * from configs WHERE id = ?',[1]);
@endphp
  <div class="iq-navbar-logo d-flex justify-content-between">
    <a href="{{ asset('/') }}" class="header-logo">
      <img
      src="{{ 'https://' . $config[0]->bank_url . '/admin/uploads/' . $logo }}"
      class="img-fluid rounded"
      alt="" />
    
    <span>Bank</span>
    </a>
    <div class="iq-menu-bt align-self-center">
      <div class="wrapper-menu">
        <div class="main-circle">
          <i class="ri-menu-line"></i>
        </div>
        <div class="hover-circle">
          <i class="ri-close-fill"></i>
        </div>
      </div>
    </div>
  </div>
  <div id="sidebar-scrollbar">
    <nav class="iq-sidebar-menu">
      <ul id="iq-sidebar-toggle" class="iq-menu">
        <!-- dashboard -->
        <li @if($main == 'dashboard') class="active" @endif>
          <a href="{{ asset('dashboard') }}" class="iq-waves-effect" ><i class="las la-home iq-arrow-left"></i><span>Dashboard</span></a>
        </li>

        <!-- My account -->
        <li @if($main == 'account') class="active" @endif>
          <a href="#userinfo" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-user-tie iq-arrow-left"></i><span>My Account</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="userinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li @if($page == 'accounts-summary') class="sub-active" @endif><a href="{{ asset('accounts-summary') }}"><i class="las la-file-alt"></i> Accounts Summary</a></li>
              <li @if($page == 'account-statement') class="sub-active" @endif><a href="{{ asset('account-statement') }}"><i class="las la-file-invoice-dollar"></i> Account Statement</a></li>
              <li><a href="additional-accounts.php"><i class="las la-user-plus"></i> Additional Accounts</a></li>
              <li @if($page == 'account-manager') class="sub-active" @endif><a href="{{ asset('account-manager') }}"><i class="las la-user-tie"></i> My Account Manager</a></li>
              <li @if($page == 'statement-to-thirdparty') class="sub-active" @endif><a href="{{ asset('statement-to-thirdparty') }}"><i class="las la-list-alt"></i> Send Statement to <br/>Third Party</a></li>
              <li><a href="spend-analysis.php"><i class="las la-signal"></i> Spend Analysis</a></li>
          </ul>
        </li>


        <li @if($main == 'transfer') class="active" @endif>
          <a href="#transinfo" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-sync iq-arrow-left"></i><span>Transfer</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="transinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li @if($page == 'own-account-transfer') class="sub-active" @endif><a href="{{ asset('own-account-transfer') }}"><i class="las la-piggy-bank"></i> Own Account Transfer</a></li>
              <li @if($page == 'transfer-to-same-bank') class="sub-active" @endif><a href="{{ asset('transfer-to-same-bank') }}"><i class="las la-paper-plane"></i> Transfer to Same Bank</a></li>
              <li @if($page == 'transfer-to-other-bank') class="sub-active" @endif><a href="{{ asset('transfer-to-other-bank') }}"><i class="las la-university"></i> Transfer to Other Banks</a></li>
              <li @if($page == 'resume-pending-transfer') class="sub-active" @endif><a href="{{ asset('resume-pending-transfer') }}"><i class="las la-exclamation-circle"></i> Resume pending transfer</a></li>
              <li @if($page == 'manage-beneficiaries') class="sub-active" @endif><a href="{{ asset('manage-beneficiaries') }}"><i class="las la-user-friends"></i> Manage Beneficiaries</a></li>
          </ul>
        </li>
        <li @if($main == 'cheque') class="active" @endif>
          <a href="#cheinfo" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-book iq-arrow-left"></i><span>Cheques</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="cheinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li @if($page == 'request-cheque-book') class="sub-active" @endif><a href="{{ asset('request-cheque-book') }}"><i class="las la-money-check"></i> Request Cheque Book</a></li>
              <li @if($page == 'stop-cheque') class="sub-active" @endif><a href="{{ asset('stop-cheque') }}"><i class="lar la-hand-paper"></i> Stop Cheque</a></li>
              <!-- <li><a href="confirm-cheque.php"><i class="lar la-check-circle"></i> Confirm Cheque</a></li>
              -->
          </ul>
        </li>
        <li @if($main == 'card') class="active" @endif>
          <a href="#cdinfo" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-credit-card iq-arrow-left"></i><span>Cards</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="cdinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li @if($page == 'request-card') class="sub-active" @endif><a href="{{ asset('request-card') }}"><i class="lab la-cc-mastercard "></i> Request Card</a></li>
              <li @if($page == 'view-cards') class="sub-active" @endif><a href="{{ asset('view-cards') }}"><i class="las la-eye"></i> View Cards</a></li>
              <!-- <li><a href="{{ asset('suspend-card') }}"><i class="las la-exclamation-triangle"></i> Suspend Card</a></li> -->
              <li @if($page == 'update-card-pin') class="sub-active" @endif><a href="{{ asset('update-card-pin') }}"><i class="las la-unlock-alt"></i> Update Card Pin</a></li>
              <!-- <li><a href="block-card.php"><i class="las la-ban"></i> Block Card</a></li> -->

          </ul>
        </li>
        <li @if($main == 'loan') class="active" @endif>
          <a href="#loinfo" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-coins iq-arrow-left"></i><span>Loans </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="loinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li @if($page == 'loan-summary') class="sub-active" @endif><a href="{{ asset('loan-summary') }}"><i class="las la-file-invoice-dollar"></i> Summary </a></li>
              <li @if($page == 'request-loan') class="sub-active" @endif><a href="{{ asset('request-loan') }}"><i class="las la-hand-holding-usd"></i> Request Loan</a></li>

          </ul>
        </li>
        <li>
          <a href="#paycollec" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-coins iq-arrow-left"></i><span>Payment &amp; Collection </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="paycollec" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li><a href="payment-and-collection.php">
                <i class="las la-money-bill-wave "></i>
                Payment </a>
              </li>
              <li>
                <a href="payment-bitcoin.php">
                    <i class="las la-hand-holding-usd "></i>
                Payment Bitcoin
                </a>
              </li>
              <li>
                <a href="payment-bitcoin-list.php">
                  <i class="las la-file-alt"></i>
                  Bitcoin Payment List
                </a>
              </li>

          </ul>
        </li>
        <!--  <li>
          <a href="payment-and-collection.php" class="iq-waves-effect" ><i class="las la-money-bill-wave iq-arrow-left"></i><span>Payment &amp; Collection</span></a>
        </li> -->
        <li @if($main == 'limit') class="active" @endif>
          <a href="#actlinfo" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-ban iq-arrow-left"></i><span>Account Limits</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="actlinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li><a href="{{ asset('request-limit') }}"><i class="las la-coins"></i>Request limits</a></li>
              <li><a href="{{ asset('view-limits') }}"><i class="las la-wallet"></i>View Limits</a></li>
          </ul>
        </li>
      <!-- <li aria-expanded="true">
          <a href="transaction.php" class="iq-waves-effect"><i class="las la-exchange-alt iq-arrow-left"></i><span>Transaction</span></a>
        </li>
        <li aria-expanded="true">
          <a href="user-whitrawal.php" class="iq-waves-effect"><i class="las la-wallet iq-arrow-left"></i><span>User Withdrawal</span></a>
        </li> -->
        <li @if($main == 'feedback') class="active" @endif>
          <a href="#cusfeed" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="las la-mail-bulk iq-arrow-left"></i><span>Customer Feedback</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="cusfeed" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li @if($page == 'all-messages') class="sub-active" @endif><a href="{{ asset('all-messages') }}"><i class="las  las la-inbox"></i>View All messages</a></li>
              <li @if($page == 'send-message') class="sub-active" @endif><a href="{{ asset('send-message') }}"><i class="ri-mail-send-line"></i>Send Message</a></li>
          </ul>
        </li>

        <li @if($main == 'config') class="active" @endif>
          <a href="#sysconfig" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><i class="ri-pages-line iq-arrow-left iq-arrow-left"></i><span>System Config</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
          <ul id="sysconfig" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
              <li @if($page == 'transaction-alert-activation') class="sub-active" @endif><a href="{{ asset('transaction-alert-activation') }}"><i class="ri-question-answer-line"></i> Transaction Alert Activation</a></li>
              <li @if($page == 'reset-secret') class="sub-active" @endif><a href="{{ asset ('reset-secret') }}"><i class="ri-mail-send-line"></i>Reset Secret Question and Answer</a></li>
        <!-- <li><a href="customer-information-update.php"><i class="las la-edit"></i>Customer Information Update</a></li> -->
        <li @if($page == 'password-update') class="sub-active" @endif><a href="{{ asset('password-update') }}"><i class="ri-record-mail-line"></i> PIN/Password Update</a></li>
        <li @if($page == 'update-verification') class="sub-active" @endif><a href="{{ asset('update-verification') }}"><i class="ri-lock-line"></i>Update Verification / Signature Information</a></li>
          </ul>
        </li>
        <!-- <li aria-expanded="true">
          <a href="#" class="iq-waves-effect"><i class="las la-calendar iq-arrow-left"></i><span>Cheque Tracking</span></a>
        </li> -->

      <!--  <li aria-expanded="true">
          <a href="#" class="iq-waves-effect"><i class="las la-calendar iq-arrow-left"></i><span>Payment &amp; Collection</span></a>
        </li> -->

      </ul>
    </nav>
    <div class="p-3"></div>
  </div>
</div>
