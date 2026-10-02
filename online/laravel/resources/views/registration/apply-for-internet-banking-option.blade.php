@extends('layouts.stack')

@section('content')
  <style type="text/css">
    .ui-widget-content {
      border: 1px solid var(--iq-border-light);
      background: #fff !important;
      color: #1e3d73;
    }

    .online-support {
      margin-top: 10px;
    }

    .online-support h3 {
      background: #fe517e;
      color: #fff;
      padding-left: 15px;
      margin-bottom: 10px;
      border:1px solid transparent;
      box-shadow: 0px 2px 5px 2px rgba(0,0,0,0.1)
    }

    .online-support .btn-link {
      color:#fff;
      border-bottom: 1px solid #fff;
      border-radius: 0px;
    }

    .input-group-text {
      font-size: 20px;
    }
  </style>

  <!-- loader Start -->
  <div id="loading">
    <div id="loading-center">
    </div>
  </div><!--/ loader END -->

  <!-- Sign in Start -->
  <section class="sign-in-page">
    <div class="container p-0">
      <div class="row no-gutters height-self-center">
        <div class="col-sm-12 align-self-center bg-[#b34020] rounded">
          <div class="row m-0">
            <div class="col-md-8 bg-white sign-in-page-data">
              <div class="sign-in-from">
                <h1 class="mb-0 text-center">Account Registration</h1>
                <p class="text-center text-dark">
                  {{ $bankName }} Bank Account Registration
                </p>
                <div class="flex flex-wrap -mx-3">
                  <div class="col-12 text-dark">
                    <h3 class="text-center pb-4">How to register</h3>
                    <p>
                      <strong>
                        Registering for online servicing is easy and only takes a few minutes. You will need:
                      </strong>
                    </p>
                    <ul>
                      <li>Your name and address</li>
                      <li>
                        The sort code or account number of an existing account you have with us -or- Your existing Bank SA Card number (For Card account)
                      </li>
                    </ul>
                    <p>
                      During the registration process you will be asked to choose a unique username for logging into your account.
                    </p>
                    <p>
                      Once you have completed the registration process you will need to activate your account. You will receive an activation letter before the next 7 days. Upon receipt you will be able to complete the easy to follow activation process by following the instructions on the letter.
                    </p>
                    <div class="text-center">
                      <a
                        href="{{ url('new-account-steps') }}"
                        class="bg-error hover:bg-error/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
                        Continue
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="
              col-sm-6
              col-md-4
              text-center
              sign-in-page-image
              order-md-3">
                <div class="sign-in-detail text-white">
                  <a
                    class="sign-in-logo mb-5"
                    href="#">
                      <img
                        src="images/logo-full.png"
                        class="img-fluid" alt="logo">
                  </a>

                  <div class="online-support">
                    <h3>Registration Area</h3>
                    <a
                      href="{{ url('online-open-account') }}"
                      class="btn btn-danger my-2 d-block">
                      Apply for Account Opening
                    </a>
                    <a
                      href="{{ url('register-new-internet-account') }}"
                      class="btn btn-danger mb-2 d-block"
                      target="_blank">
                      Apply for Internet Banking Option
                    </a>
                    <a
                      href="{{ url('retrieve-account-pin') }}"
                      class="btn btn-danger d-block">
                      Retrieve Account PIN
                    </a>
                    <a
                      href="{{ url('retrieve-account-user-id') }}"
                      class="btn btn-danger my-2 d-block">
                      Retrieve Account User ID
                    </a>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!--/ Sign in END -->

  <script type="text/javascript">
    $('#username,#password').keyboard({openOn : null });

    $('.username').click(function(){
      var kb = $('#username').getkeyboard();
      kb.reveal()
    })
    $('.password').click(function(){
      var kb = $('#password').getkeyboard();
      kb.reveal()
    })
  </script>
@endsection
