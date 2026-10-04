@php
    $config = DB::table('configs')->where('id','1')->first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>404 - Page Not Found | {{ $config->bank_name ?? 'Equitable Bank' }}</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 24px;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background: #f8faf9;
            color: #191c1c;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: #ffffff;
            border: 1px solid #e6e9e8;
            border-radius: 28px;
            padding: 48px 36px;
            max-width: 520px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 40px -10px rgba(0, 66, 38, 0.08);
        }
        .icon-circle {
            width: 72px;
            height: 72px;
            border-radius: 24px;
            background: #e8f7ee;
            border: 1px solid #c0ebd0;
            color: #004226;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .code-badge {
            display: inline-block;
            background: #f8faf9;
            border: 1px solid #e6e9e8;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            color: #53625b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
        }
        h1 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 8px 0;
            color: #191c1c;
            letter-spacing: -0.02em;
        }
        p {
            font-size: 13.5px;
            color: #53625b;
            line-height: 1.55;
            margin: 0 0 28px 0;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #004226;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 66, 38, 0.25);
        }
        .btn-primary:hover {
            background: #0f5b38;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
	<div class="error-card">
        <div class="icon-circle">
            <span class="material-symbols-outlined" style="font-size: 36px;">explore_off</span>
        </div>
        <br>
        <span class="code-badge">HTTP 404 &bull; Resource Unreachable</span>
        <h1>Destination Not Located</h1>
        <p>The requested banking URL or resource is unavailable or has been relocated to another ledger section.</p>
        <a href="{{ url('/') }}" class="btn-primary">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
            <span>Return to Client Portal</span>
        </a>
	</div>
</body>
</html>
