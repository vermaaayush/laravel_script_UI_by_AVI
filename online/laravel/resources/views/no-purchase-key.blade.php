<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - System Notice</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8f9fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #0f131a;
        }
        .notice-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(15, 19, 26, 0.08), 0 0 0 1px rgba(226, 230, 237, 0.9);
            padding: 44px 36px;
            max-width: 480px;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="notice-card">
        <div style="width: 56px; height: 56px; border-radius: 18px; background: #fff1f0; color: #e11d48; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <span class="material-symbols-outlined" style="font-size: 28px;">key_off</span>
        </div>
        
        <h2 style="font-size: 20px; font-weight: 800; color: #0f131a; margin-bottom: 8px;">License Key Required</h2>
        <p style="font-size: 13.5px; color: #5f6b7c; line-height: 1.5; margin-bottom: 24px;">
            No active deployment purchase key was identified for this installation. Please contact system administration to register your product key.
        </p>

        <a href="{{ url('login') }}" class="btn" style="background: #0f131a; color: #ffffff; border-radius: 12px; font-size: 13px; font-weight: 700; padding: 10px 24px;">
            Return to Login
        </a>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
