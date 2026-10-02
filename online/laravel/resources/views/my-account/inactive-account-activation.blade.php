<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{--{{ $bankName }}--}}</title>
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
        .input-group-text{font-size: 20px; }
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
            <div class="col-sm-12 align-self-center rounded">
                <div class="row m-0">
                    <div class="col-md-12 bg-white sign-in-page-data">
                        <div class="sign-in-from">
                            <h3 class="mb-0 text-center">Bank Account</h3>
                            <p class="text-center text-dark">Your Account opening application is being reviewed
                                <br>
                                @include('flash::message')
                                  
                            </p>
                            <div class="sign-info text-center">
                              <button type="submit" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2" onclick="location.href='{{url('login')}}';">Back To Login</button>
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

<script>

</script>
<script src="js/custom.js"></script>
<script type="text/javascript">
    jQuery("#load").fadeOut();
    jQuery("#loading").delay().fadeOut("");
</script>
</body>
</html>
