<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transactions Export - <?= strtoupper($bankname) ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            margin: 20px;
            color: #191c1c;
            background: #ffffff;
        }
        .container {
            max-width: 1040px;
            margin: 0 auto;
        }
        .header-box {
            background: #004226;
            color: #ffffff;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
        }
        .meta-box {
            background: #f8faf9;
            border: 1px solid #e6e9e8;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 12px;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th {
            background: #f8faf9;
            color: #004226;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 12px;
            border-bottom: 2px solid #e6e9e8;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e6e9e8;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .text-debit {
            color: #ba1a1a;
            font-weight: 700;
        }
        .text-credit {
            color: #006c42;
            font-weight: 700;
        }
        .footer-note {
            margin-top: 24px;
            padding: 14px 18px;
            background: #f8faf9;
            border: 1px solid #e6e9e8;
            border-radius: 12px;
            font-size: 10px;
            color: #53625b;
            line-height: 1.5;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header-box">
        <h1 style="margin: 0 0 4px 0; font-size: 20px; font-weight: 800;"><?= strtoupper($bankname) ?></h1>
        <p style="margin: 0; font-size: 12px; color: #aaf2c4; font-weight: 600;">OFFICIAL CUSTOMER STATEMENT</p>
        <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 700; color: #ffffff;"><?= ucfirst($customer[0]->cust_name.' '.$customer[0]->middle_name.' '.$customer[0]->sur_name) ?></p>
    </div>

    <div class="meta-box">
        <table style="width: 100%; font-size: 11.5px;">
            <tr>
                <td style="width: 50%; border: none; padding: 3px 0;"><strong>Print Date:</strong> <?php echo date("d/M/Y"); ?></td>
                <td style="width: 50%; border: none; padding: 3px 0;"><strong>Currency:</strong> {{ $account[0]->account_currency }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px 0;"><strong>Account No:</strong> <span class="font-mono">{{ $account_no }}</span></td>
                <td style="border: none; padding: 3px 0;"><strong>Statement Period:</strong> <?php echo date("d/F/Y", $start); ?> To <?php echo date("d/F/Y", $end); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border: none; padding: 3px 0;"><strong>Address:</strong> {{ $customer[0]->cust_address . " " . $customer[0]->cust_city . " " . $customer[0]->cust_state . " " . $customer[0]->cust_country . " " . $customer[0]->post_code }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 14%;">Trans Date</th>
                <th style="width: 18%;">Reference</th>
                <th style="width: 14%; text-align: right;">Debit (-)</th>
                <th style="width: 14%; text-align: right;">Credit (+)</th>
                <th style="width: 14%; text-align: right;">Balance</th>
                <th style="width: 26%;">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $row)
            <tr>
                <td style="color: #53625b;"><?= date('d/M/Y', strtotime($row->datetime)) ?></td>
                <td class="font-mono">{{ $row->tran_id }}</td>
                <td style="text-align: right;" class="font-mono">
                    @if($row->type == 'debited' || $row->type == 'charges')
                        <span class="text-debit">-{{ number_format($row->amount, 2) }}</span>
                    @else
                        —
                    @endif
                </td>
                <td style="text-align: right;" class="font-mono">
                    @if($row->type == 'credited')
                        <span class="text-credit">+{{ number_format($row->amount, 2) }}</span>
                    @else
                        —
                    @endif
                </td>
                <td style="text-align: right; font-weight: 700;" class="font-mono">{{ number_format($row->balance, 2) }}</td>
                <td>{{ $row->reason }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <?php $conFig = DB::table('configs')->where('id','1')->first(); ?>
    <div class="footer-note">
        <strong>PLEASE ADDRESS ALL ENQUIRIES TO <?= strtoupper($bankname) ?></strong><br>
        <?= strtoupper($conFig->bank_address ?? '') ?><br>
        PHONE: <?= strtoupper($conFig->bank_phone ?? '') ?> &bull; FAX: <?= strtoupper($conFig->bank_fax ?? '') ?><br>
        OR THE CUSTOMER INFORMATION UNIT OF YOUR LOCAL BRANCH
    </div>
</div>
</body>
</html>
