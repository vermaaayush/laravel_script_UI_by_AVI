@php

$config = DB::table('configs')->where('id', 1)->first();


@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $config->bank_name }}</title>
    <style>
        /* Reset styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
        }
        /* Container styles */
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            border-bottom: 1px solid #ccc;
            background-color: white;
            color: #fff;
        }
        .header img {
            max-width: 150px;
        }
        .header h1 {
            color: #fff;
            font-size: 24px;
            margin: 10px 0;
        }
        /* Content styles */
        .content {
            margin:20px;
            margin-bottom: 20px;
        }
        .content p {
            margin: 10px 0;
        }
        .content ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .content li {
            margin-bottom: 5px;
        }
        /* Call to action button */
        .cta-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            font-weight: bold;
        }
        .cta-btn:hover {
            background-color: #3b79ba;
        }
        /* Footer styles */
        .footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #ccc;
            background-color: #f5f5f5;
            color: #333;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
           <img src="{{ env('APP_URL') }}/admin/uploads/{{ $config->logo }}" alt="Company Logo">
            
        </div>
        <div class="content">
            
            <p>Dear {{$name}},</p>

<p>We are pleased to confirm that your recent deposit has been processed successfully and the amount has been credited to your account.</p>

<ul>
   @foreach ($currency_amounts as $currency => $amount)
    <li>
        <strong>{{ $currency }} Deposit Amount:</strong>
        @if ($currency === 'BTC')
            {{ $amount }} BTC
        @else
            {{ $currency }} {{ $amount }}
        @endif
    </li>
@endforeach

</ul>

<p>If you require any further assistance or have questions regarding this transaction, please feel free to reach out to our support team. We are here to help.</p>

<p>Thank you for choosing us as your financial partner.</p>

<p>Best regards,</p>
<p><strong>{{ $config->bank_name }} Team</strong></p>
<p><strong>Visit Now: </strong><a href="{{ $config->bank_url }}">{{ $config->bank_url }}</a></p>

        
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $config->bank_name }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
