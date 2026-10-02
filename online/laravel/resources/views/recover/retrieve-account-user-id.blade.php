<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bank</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <link href="css/keyboard.css" rel="stylesheet">
      <style type="text/css">
          .ui-widget-content {
    border: 1px solid var(--iq-border-light);
    background: #fff !important;
    color: #1e3d73;
}
.online-support{margin-top: 10px;}
.online-support h3{background: #fe517e;color: #fff; padding-left: 15px;margin-bottom: 10px;border:1px solid transparent;box-shadow: 0px 2px 5px 2px rgba(0,0,0,0.1)}
.online-support .btn-link{color:#fff;border-bottom: 1px solid #fff;border-radius: 0px;}
.input-group-text{font-size: 20px;}
      </style>
   </head>
   <body>
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
                          <div class="sign-in-from mt-5">
                              <h3 class="mb-0 text-center">Bank Account - Retrive User ID</h3>
                              <!-- <p class="text-center text-dark">{bank name} Bank Account Registration</p> -->

                               <div class="flex flex-wrap -mx-3">
                               <div class="col-12 text-dark">
                                 <form id="form-wizard1" class="text-center py-5">

                                  <!-- fieldsets -->
                                     <fieldset>
                                       <div class="form-card text-center">
                                          <div class="row justify-content-center">
                                             <div class="col-md-6 col-sm-8 mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Your Username</label>
                                               <input type="" name="ib_username" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="validationCustom06">
                                                <div class="valid-feedback">
                                                   <!-- Looks good! -->
                                                </div>
                                             </div>

                                          </div>
                                        </div>
                                        <button id="checkUserName" type="button" name="next" class="btn btn-primary next action-button " value="Next">Submit</button>
                                      </fieldset>
                                      <fieldset>
                                       <div class="form-card text-center">
                                          <div class="row justify-content-center">
                                             <div class="col-md-6 col-sm-8 mb-6 text-left">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">New User ID</label>
                                               <input type="" name="ib_userid" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="validationCustom06">
                                                <div class="valid-feedback">
                                                   <!-- Looks good! -->
                                                </div>
                                             </div>
                                             <!-- confirm user id -->
                                             <div class="col-md-6 col-sm-8 mb-6 text-left">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Confirm User ID</label>
                                               <input type="" name="ib_c_userid" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="validationCustom06">
                                                <div class="valid-feedback">
                                                   <!-- Looks good! -->
                                                </div>
                                             </div>

                                          </div>
                                        </div>
                                        <button id="genUserId" type="button" name="next" class="btn btn-primary next action-button " value="Next">Next</button>
                                             <button type="button" name="previous" class="btn btn-dark previous action-button-previous  mr-3" value="Previous">Previous</button>
                                             <div class="clearfix"></div>
                                      </fieldset>
                                     <fieldset >
                                        <div class="form-card text-center">
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
        </section>
        <!-- Sign in END -->

     <!-- Optional JavaScript -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- Counterup JavaScript -->
      <script src="js/waypoints.min.js"></script>
      <script src="js/jquery.counterup.min.js"></script>
            <!-- Slick JavaScript -->
      <script src="js/slick.min.js"></script>
       <!-- Select2 JavaScript -->
      <script src="js/select2.min.js"></script>
      <!-- Wow JavaScript -->
      <script src="js/wow.min.js"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="js/owl.carousel.min.js"></script>
      <script src="js/jquery.keyboard.js"></script>
      <script src="js/jquery.mousewheel.js"></script>
      <!-- <script src="js/jquery.keyboard.extension-caret.js"></script>
      <script src="js/jquery.keyboard.extension-typing.js"></script> -->
      <script src="https://code.jquery.com/ui/1.9.0/jquery-ui.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="js/jquery.magnific-popup.min.js"></script>
      <script src="js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <!--  <script type="text/javascript">
        $('#username,#password').keyboard({openOn : null });

        $('.username').click(function(){
          var kb = $('#username').getkeyboard();
          kb.reveal()
        })
        $('.password').click(function(){
          var kb = $('#password').getkeyboard();
          kb.reveal()
        })
      </script>-->
      <script src="js/custom.js"></script>
      <script type="text/javascript">
        jQuery("#load").fadeOut();
        jQuery("#loading").delay().fadeOut("");
      </script>
   </body>
</html>
