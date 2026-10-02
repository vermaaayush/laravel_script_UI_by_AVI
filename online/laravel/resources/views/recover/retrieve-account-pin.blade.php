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
  </div>
  <!-- loader END -->

  <!-- Sign in Start -->
  <section class="sign-in-page">
      <div class="container p-0">
        <div class="row no-gutters height-self-center">
          <div class="col-sm-12 align-self-center bg-[#b34020] rounded">
            <div class="row m-0">
              <div class="col-md-8 bg-white sign-in-page-data">
                <div class="sign-in-from">
                  <h3 class="mb-0 text-center">
                    Bank Account - Retrive Account PIN
                  </h3>
                  <p class="text-center text-dark">
                    {{ $bankName }} Bank Account Registration
                  </p>

                  <div class="flex flex-wrap -mx-3">
                    <div class="col-12 text-dark">
                      <form id="form-wizard1" class="text-center mt-6">
                        <!-- fieldsets -->
                        <fieldset class="text-center">
                          <div class="form-card text-left">
                            <div class="row justify-content-center">
                              <div class="col-md-6 col-sm-8 mb-6">
                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">
                                  Your Username
                                </label>
                                <input
                                  type=""
                                  name="ib_username"
                                  class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                                  id="validationCustom06" />
                                <div class="valid-feedback">
                                  <!-- Looks good! -->
                                </div>
                              </div>
                            </div>
                          </div>
                          <button
                            id="checkUsrName"
                            type="button"
                            name="next"
                            class="
                            btn
                            btn-primary
                            next
                            action-button"
                            value="Next">
                            Submit
                          </button>
                        </fieldset>

                        <fieldset class="text-center">
                          <div class="form-card text-left">
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-sm-8 mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">New Account PIN</label>
                                  <input type="" name="ib_pin" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="validationCustom06">
                                  <div class="valid-feedback">
                                      <!-- Looks good! -->
                                  </div>
                                </div>
                                <div class="col-md-6 col-sm-8 mb-6">
                                  <label class="block text-sm font-semibold text-on-surface-variant mb-2">Confirm Account PIN</label>
                                  <input type="" name="ib_ac_c_pin" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="validationCustom06">
                                  <div class="valid-feedback">
                                      <!-- Looks good! -->
                                  </div>
                                </div>

                            </div>
                          </div>
                          <button id="genUserPin" type="button" name="next" class="btn btn-primary next action-button " value="Next">Next</button>
                                <button type="button" name="previous" class="btn btn-dark previous action-button-previous  mr-3" value="Previous">Previous</button>
                        </fieldset>

                        <fieldset class="text-center">
                          <div class="form-card text-left">
                                  <div class="flex flex-wrap -mx-3">
                                      <div class="col-12">
                                        <h3 class="text-center">Enter OTP</h3>
                                        <p class="text-center">We have sent you Token OTP via Email xxxxxxxx@gmail.com ! Please add OTP to proceed!</p>

                                      </div>
                                  </div>
                                  <div class="row justify-content-center">
                                      <div class="w-full md:w-1/2 px-3">
                                        <div class="mb-6">
                                            <!-- <label class="block text-sm font-semibold text-on-surface-variant mb-2">First Name: *</label> -->
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="fname" placeholder="Enter OTP here">
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <button type="button" name="next" class="btn btn-primary next action-button " value="Next">Next</button>
                                <button type="button" name="previous" class="btn btn-dark previous action-button-previous  mr-3" value="Previous">Previous</button>
                                <div class="clearfix"></div>
                                <p class="text-center">Entering the wrong OTP more than 3 times will lead to suspension of the account.<br> If you have any problems with acquiring the OTP, Please contact your account Officer, <br>or visit our nearest Branch</p>
                        </fieldset>

                        <fieldset >
                            <div class="form-card">
                              <br><br>
                              <h2 class="text-secondary text-center"><strong>SUCCESS !</strong></h2>
                              <br>
                              <div class="row justify-content-center">
                                  <div class="col-lg-2 col-md-3 col-sm-5 col-5"> <img src="images/page-img/img-success.png" class="fit-image" alt="fit-image"> </div>
                              </div>
                              <br><br>
                            </div>
                        </fieldset>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <div class="col-sm-6 col-md-4 text-center sign-in-page-image order-md-3">
              <div class="sign-in-detail text-white">
                <a class="sign-in-logo mb-5" href="#"><img src="images/logo-full.png" class="img-fluid" alt="logo"></a>

                    <div class="online-support">
                    <h3>Registration Area</h3>
                    <a href="{{ url('online-open-account') }}" class="btn btn-danger my-2 d-block">Apply for Account Opening</a>
                    <a href="{{ url('register-new-internet-account') }}" class="btn btn-danger mb-2 d-block" target="_blank">Apply for Internet Banking Option</a>
                    <a href="{{ url('retrieve-account-pin') }}" class="btn btn-danger d-block">Retrieve Account PIN</a>
                    <a href="{{ url('retrieve-account-user-id') }}" class="btn btn-danger my-2 d-block"> Retrieve Account User ID</a>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!--/ Sign in END -->
@endsection

@section('script')
<script type="text/javascript">
  jQuery("#load").fadeOut();
  jQuery("#loading").delay().fadeOut("");
</script>
@endsection
