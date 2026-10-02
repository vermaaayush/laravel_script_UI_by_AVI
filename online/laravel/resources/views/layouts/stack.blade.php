<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $bankName }}</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <link href="css/keyboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/parsley.css">
    <script>
    var url="{{env('APP_URL')}}"
    </script>
  </head>
  <body>

    @yield('content')

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
    <!-- <script src="js/south.js"></script> -->
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
    <script src="js/parsley.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/south.js"></script>
    <script type="text/javascript">
      jQuery("#load").fadeOut();
      jQuery("#loading").delay().fadeOut("");
    </script>

    @yield('script')
  </body>
</html>
