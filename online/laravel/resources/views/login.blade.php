<!doctype html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>{{ $bankName ?? 'Equitable Bank' }} - Client Sign In</title>
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
      <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      
      <style type="text/css">
          :root {
              --primary-gold: #c59b27;
              --primary-gold-light: #dfbb58;
              --primary-gold-dark: #9c7614;
              --primary-gradient: linear-gradient(135deg, #dfbb58 0%, #c59b27 50%, #9c7614 100%);
              --primary-hover: linear-gradient(135deg, #e9c668 0%, #d4aa33 50%, #aa821c 100%);
              --bg-page: #f8f9fb;
              --card-bg: #ffffff;
              --text-main: #0a0e17;
              --text-muted: #5f6b7c;
              --border-color: #e2e6ed;
          }

          body.dark-theme {
              --bg-page: #080c13;
              --card-bg: #101622;
              --text-main: #f0f6fc;
              --text-muted: #8b949e;
              --border-color: #212936;
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
                  radial-gradient(circle at 10% 20%, rgba(197, 155, 39, 0.06) 0%, transparent 45%),
                  radial-gradient(circle at 90% 80%, rgba(10, 14, 23, 0.05) 0%, transparent 45%);
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

          /* Luxury Center Card Container */
          .login-container {
              max-width: 1020px;
              width: 100%;
              max-height: calc(100vh - 28px);
              background: var(--card-bg);
              border-radius: 28px;
              box-shadow: 0 25px 60px -12px rgba(10, 14, 23, 0.12), 0 0 0 1px var(--border-color);
              padding: 16px;
              display: flex;
              gap: 16px;
              align-items: stretch;
              position: relative;
              overflow: hidden;
              transition: background 0.3s ease;
          }

          /* Left Side: Form Area */
          .form-side {
              flex: 1.1;
              display: flex;
              flex-direction: column;
              justify-content: space-between;
              padding: 18px 24px;
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
              background: linear-gradient(135deg, #121824 0%, #0a0e17 100%);
              border: 1px solid rgba(197, 155, 39, 0.4);
              border-radius: 10px;
              display: flex;
              align-items: center;
              justify-content: center;
              color: #dfbb58;
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
              background: rgba(197, 155, 39, 0.1);
              color: #c59b27;
          }

          .form-header-title {
              text-align: left;
              margin-bottom: 16px;
          }

          .form-header-title h2 {
              font-size: 24px;
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
              margin-bottom: 11px;
          }

          .form-label-custom {
              display: block;
              font-size: 11.5px;
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
              background: #0d121c;
          }

          .input-wrapper:focus-within {
              border-color: #c59b27;
              background: #ffffff;
              box-shadow: 0 0 0 3px rgba(197, 155, 39, 0.15);
          }

          body.dark-theme .input-wrapper:focus-within {
              background: #0d121c;
              border-color: #dfbb58;
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
              height: 42px !important;
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
              color: #c59b27;
          }

          /* Captcha Box */
          .captcha-box-container {
              display: flex;
              align-items: center;
              justify-content: space-between;
              background: #f4f6fa;
              border: 1px solid var(--border-color);
              border-radius: 10px;
              padding: 5px 12px;
              margin-bottom: 7px;
          }

          body.dark-theme .captcha-box-container {
              background: #141b27;
          }

          .captcha-code-text {
              font-family: 'JetBrains Mono', monospace;
              font-size: 18px;
              font-weight: 800;
              letter-spacing: 5px;
              color: #c59b27;
              user-select: none;
          }

          .captcha-refresh-btn {
              background: rgba(197, 155, 39, 0.15);
              color: #9c7614;
              border: none;
              border-radius: 8px;
              width: 28px;
              height: 28px;
              display: flex;
              align-items: center;
              justify-content: center;
              cursor: pointer;
              transition: all 0.2s ease;
          }

          .captcha-refresh-btn:hover {
              background: #c59b27;
              color: #ffffff;
              transform: rotate(180deg);
          }

          .form-options-row {
              display: flex;
              align-items: center;
              justify-content: space-between;
              margin-bottom: 12px;
          }

          .checkbox-label-custom {
              display: flex;
              align-items: center;
              gap: 6px;
              font-size: 11.5px;
              font-weight: 500;
              color: var(--text-muted);
              cursor: pointer;
              user-select: none;
              margin: 0;
          }

          .checkbox-label-custom input {
              accent-color: #c59b27;
              width: 15px;
              height: 15px;
              border-radius: 4px;
              cursor: pointer;
          }

          .forgot-link {
              font-size: 11.5px;
              font-weight: 600;
              color: #c59b27;
              text-decoration: none;
              transition: color 0.2s ease;
          }

          .forgot-link:hover {
              color: #9c7614;
              text-decoration: underline;
          }

          .btn-submit-gradient {
              width: 100%;
              height: 44px;
              background: linear-gradient(135deg, #dfbb58 0%, #c59b27 50%, #9c7614 100%);
              border: none;
              border-radius: 12px;
              color: #0a0e17;
              font-size: 13.5px;
              font-weight: 800;
              letter-spacing: 0.2px;
              display: flex;
              align-items: center;
              justify-content: center;
              gap: 8px;
              cursor: pointer;
              transition: all 0.2s ease;
              box-shadow: 0 4px 14px rgba(197, 155, 39, 0.3);
          }

          .btn-submit-gradient:hover {
              transform: translateY(-1px);
              box-shadow: 0 8px 20px rgba(197, 155, 39, 0.4);
              background: linear-gradient(135deg, #e9c668 0%, #d4aa33 50%, #aa821c 100%);
          }

          .registration-small-link {
              margin-top: 12px;
              padding-top: 8px;
              border-top: 1px solid var(--border-color);
              display: flex;
              align-items: center;
              justify-content: center;
              gap: 6px;
              font-size: 11.5px;
              font-weight: 500;
              color: var(--text-muted);
              text-align: center;
          }

          .create-account-link {
              color: #c59b27;
              font-weight: 700;
              text-decoration: none !important;
              display: inline-flex;
              align-items: center;
              gap: 4px;
          }

          .create-account-link:hover {
              color: #9c7614;
              text-decoration: underline !important;
          }

          /* Right Side: Luxury Black & Gold Architecture Lounge Banner */
          .banner-side {
              flex: 1.1;
              background-image: url('{{ asset("images/auth_luxury_banner.jpg") }}');
              background-size: cover;
              background-position: center;
              border-radius: 20px;
              position: relative;
              display: flex;
              flex-direction: column;
              justify-content: space-between;
              padding: 30px 28px;
              overflow: hidden;
              border: 1px solid rgba(197, 155, 39, 0.25);
          }

          .banner-overlay {
              position: absolute;
              inset: 0;
              background: linear-gradient(180deg, rgba(10, 14, 23, 0.35) 0%, rgba(10, 14, 23, 0.88) 100%);
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
              background: rgba(197, 155, 39, 0.25);
              backdrop-filter: blur(10px);
              padding: 6px 12px;
              border-radius: 30px;
              font-size: 11px;
              font-weight: 700;
              color: #dfbb58;
              border: 1px solid rgba(197, 155, 39, 0.4);
              align-self: flex-start;
          }

          .banner-title {
              font-family: 'Playfair Display', serif;
              font-size: 26px;
              font-weight: 700;
              line-height: 1.25;
              letter-spacing: -0.3px;
              color: #ffffff;
              margin: 0 0 6px 0;
          }

          .banner-subtitle {
              font-size: 12.5px;
              color: rgba(255, 255, 255, 0.82);
              line-height: 1.5;
              margin: 0;
          }

          .trust-pills-row {
              display: flex;
              gap: 8px;
              margin-top: 14px;
          }

          .trust-pill {
              font-size: 10px;
              font-weight: 600;
              background: rgba(255, 255, 255, 0.12);
              backdrop-filter: blur(8px);
              padding: 4px 9px;
              border-radius: 6px;
              color: #f1f5f9;
              display: flex;
              align-items: center;
              gap: 4px;
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
                                      <span class="material-symbols-outlined text-[20px]">account_balance</span>
                                  </div>
                                  <span class="logo-title">{{ $bankName ?? 'Equitable Bank' }}</span>
                              </div>
                          <?php else: ?>
                              <div class="logo-fallback-wrap">
                                  <div class="logo-fallback-icon">
                                      <span class="material-symbols-outlined text-[20px]">account_balance</span>
                                  </div>
                                  <span class="logo-title">{{ $bankName ?? 'Equitable Bank' }}</span>
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
                      <p>Sign in with your secure credentials to manage your portfolio.</p>
                  </div>

                  @include('flash::message')

                  <!-- Form -->
                  <form role="form" method="POST" action="loginUser" id="loginForm">
                      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                      
                      <!-- User ID Field -->
                      <div class="form-group-custom">
                          <label class="form-label-custom">User ID / Account No.</label>
                          <div class="input-wrapper">
                              <span class="field-icon-left">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                              </span>
                              <input type="text" class="custom-input" name="user_id" id="user_id" required value="" placeholder="Enter your User ID" autocomplete="off" />
                              <span class="field-icon-right user_id" title="Open Virtual Keyboard">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M10 8h.01M14 8h.01M18 8h.01M6 12h.01M10 12h.01M14 12h.01M18 12h.01M8 16h8"/></svg>
                              </span>
                          </div>
                      </div>

                      <!-- PIN Field -->
                      <div class="form-group-custom">
                          <label class="form-label-custom">Security PIN / Password</label>
                          <div class="input-wrapper">
                              <span class="field-icon-left">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                              </span>
                              <input type="password" class="custom-input" name="password" id="password" required value="" placeholder="Enter your PIN" autocomplete="off" />
                              <span class="field-icon-right password" title="Open Virtual Keyboard">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M10 8h.01M14 8h.01M18 8h.01M6 12h.01M10 12h.01M14 12h.01M18 12h.01M8 16h8"/></svg>
                              </span>
                          </div>
                      </div>

                      <!-- PIN Security Captcha Field -->
                      <div class="form-group-custom">
                          <label class="form-label-custom">Security Verification Code</label>
                          
                          <div class="captcha-box-container">
                              <span class="captcha-code-text" id="captchaCode"><?php echo $generatedCaptcha; ?></span>
                              <button type="button" class="captcha-refresh-btn" id="refreshCaptchaBtn" title="Generate New Code">
                                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                              </button>
                          </div>

                          <div class="input-wrapper" id="captchaInputWrapper">
                              <span class="field-icon-left">
                                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                              </span>
                              <input type="text" class="custom-input" name="enteredCaptcha" id="enteredCaptcha" required placeholder="Type the code shown above" autocomplete="off" />
                          </div>
                      </div>

                      <!-- Options Row -->
                      <div class="form-options-row">
                          <label class="checkbox-label-custom">
                              <input type="checkbox" id="customCheck1" name="remember" />
                              <span>Remember session</span>
                          </label>
                          <a href="{{ url('retrieve-account-user-id') }}" class="forgot-link">Forgot User ID or PIN?</a>
                      </div>

                      <!-- Sign In Button -->
                      <button type="submit" class="btn-submit-gradient">
                          <span>Sign In Securely</span>
                          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                      </button>
                  </form>
              </div>

              <!-- Registration Link -->
              <div class="registration-small-link">
                  <span>New to {{ $bankName ?? 'Equitable Bank' }}?</span>
                  <a href="{{ url('online-open-account') }}" class="create-account-link">
                      <span>Open an Account</span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </a>
              </div>
          </div>

          <!-- Right Side: Luxury Black & Gold Penthouse Banner -->
          <div class="banner-side">
              <div class="banner-overlay"></div>
              
              <div class="relative z-10">
                  <div class="banner-badge">
                      <span class="material-symbols-outlined text-[15px]">verified_user</span>
                      Private Wealth & Sovereign Banking
                  </div>
              </div>

              <div class="banner-content">
                  <h1 class="banner-title">Preserving Wealth Across Generations.</h1>
                  <p class="banner-subtitle">Institutional-grade custody, seamless multi-currency clearing, and dedicated private banking officers.</p>
                  
                  <div class="trust-pills-row">
                      <span class="trust-pill">
                          <span class="material-symbols-outlined text-[13px]">lock</span>
                          256-Bit SSL
                      </span>
                      <span class="trust-pill">
                          <span class="material-symbols-outlined text-[13px]">shield</span>
                          2FA Protected
                      </span>
                      <span class="trust-pill">
                          <span class="material-symbols-outlined text-[13px]">savings</span>
                          FDIC Insured
                      </span>
                  </div>
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
                    alert('Invalid Security Verification Code. Please type the characters shown in the gold box.');
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
