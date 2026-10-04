<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $bankName ?? 'OripioFin' }} - Institutional Account Registration</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CDN with Stitch Sovereign Design Tokens -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    primary: {
                        DEFAULT: "#004226",
                        container: "#0f5b38",
                        fixed: "#aaf2c4",
                        "fixed-dim": "#8fd6a9",
                        dark: "#00301b",
                    },
                    "on-primary": "#ffffff",
                    "on-primary-container": "#8ad1a4",
                    secondary: {
                        DEFAULT: "#53625b",
                        container: "#d3e3db",
                    },
                    "on-secondary": "#ffffff",
                    tertiary: {
                        DEFAULT: "#004219",
                        container: "#005c26",
                        fixed: "#6bff8f",
                    },
                    surface: {
                        DEFAULT: "#f8faf9",
                        container: {
                            lowest: "#ffffff",
                            low: "#f2f4f3",
                            DEFAULT: "#eceeed",
                            high: "#e6e9e8",
                            highest: "#e1e3e2",
                        }
                    },
                    "on-surface": "#191c1c",
                    "on-surface-variant": "#404942",
                    background: "#f8faf9",
                    outline: {
                        DEFAULT: "#707971",
                        variant: "#bfc9bf",
                    },
                    error: {
                        DEFAULT: "#ba1a1a",
                        container: "#ffdad6",
                    }
                },
                fontFamily: {
                    sans: ["'Inter'", "sans-serif"],
                    heading: ["'Plus Jakarta Sans'", "sans-serif"],
                    mono: ["'JetBrains Mono'", "monospace"],
                }
            }
        }
    }
    </script>

    <!-- Legacy Style Assets Retained for Step Wizards and Validation -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/typography.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <link href="css/keyboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/parsley.css">

    <style>
      .material-symbols-outlined {
          font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
          display: inline-block;
          vertical-align: middle;
          line-height: 1;
      }
      body {
          background-color: #f8faf9;
          font-family: 'Inter', sans-serif;
          color: #191c1c;
      }
      .btn-primary, .action-button {
          background-color: #004226 !important;
          border-color: #004226 !important;
          color: #ffffff !important;
          font-weight: 600;
          border-radius: 10px;
          padding: 10px 24px;
          transition: all 0.2s ease;
      }
      .btn-primary:hover, .action-button:hover {
          background-color: #0f5b38 !important;
          border-color: #0f5b38 !important;
      }
      .form-control {
          border-radius: 10px;
          border-color: #bfc9bf;
          font-size: 14px;
      }
      .form-control:focus {
          border-color: #004226;
          box-shadow: 0 0 0 3px rgba(0, 66, 38, 0.15);
      }
    </style>

    <script>
    var url="{{env('APP_URL')}}"
    </script>
  </head>
  <body class="bg-background text-on-surface antialiased">

    @yield('content')

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.keyboard.js"></script>
    <script src="js/jquery.mousewheel.js"></script>
    <script src="https://code.jquery.com/ui/1.9.0/jquery-ui.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/chart-custom.js"></script>
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
