<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fb;
            color: #333;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
            font-size: 24px;
        }
        .qr-container {
            text-align: center;
            margin-top: 20px;
        }
        .qr-container img {
            width: 200px;
            height: 200px;
        }
        .address {
            font-size: 16px;
            color: #555;
            word-wrap: break-word;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 4px;
        }
        .note {
            margin-top: 15px;
            font-size: 14px;
            color: #999;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Generated Address for Your {{ strtoupper($currency) }} Deposit</h2>
       <p style="text-align:center;">
    Scan to receive {{ strtoupper($currency) }} 
    @if(strtoupper($currency) === 'USDT') 
        - TRC20 Network 
    @endif
</p>

        <p style="text-align:center;">You can only receive {{ strtoupper($currency) }} to this address</p>
        
        <div class="qr-container">
            <img src="{{ $qr }}" alt="QR Code for {{ strtoupper($currency) }} Address">
        </div>

        <div class="address">
            {{ $address }}
        </div>

        <p class="note">
            Ensure you select the correct crypto network.<br>
            Please only use the appropriate cryptocurrency network to send your crypto. If you accidentally send crypto using the wrong network, you cannot get your crypto back.<br>
            Note: Must reach 6 confirmations to be available in balance.
        </p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} BLC Fund. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
