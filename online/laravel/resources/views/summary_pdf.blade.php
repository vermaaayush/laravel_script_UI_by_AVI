<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $user_info = DB::table('ba_account_holders')->where('user_id',$u_id)->first();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wire Transfer Advice - <?= $confiG->bank_name ?? 'Equitable Bank' ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        *, body {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
        }
        body {
            background-color: #f8faf9;
            color: #191c1c;
            margin: 0;
            padding: 30px 15px;
        }
        .advice-sheet {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e6e9e8;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 66, 38, 0.05);
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e6e9e8;
            padding-bottom: 24px;
            margin-bottom: 24px;
        }
        .brand-title {
            font-size: 22px;
            font-weight: 800;
            color: #004226;
            margin: 0 0 4px 0;
        }
        .brand-sub {
            font-size: 11px;
            font-weight: 700;
            color: #53625b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0;
        }
        .doc-type-badge {
            display: inline-block;
            background: #e8f7ee;
            border: 1px solid #c0ebd0;
            color: #004226;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
            font-size: 12.5px;
        }
        .info-card {
            background: #f8faf9;
            border: 1px solid #e6e9e8;
            border-radius: 12px;
            padding: 16px 20px;
        }
        .info-card h4 {
            font-size: 11px;
            font-weight: 800;
            color: #004226;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin: 0 0 10px 0;
        }
        .info-card p {
            margin: 0 0 4px 0;
            color: #53625b;
            line-height: 1.5;
        }
        .info-card strong {
            color: #191c1c;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .table-custom th {
            background: #f8faf9;
            color: #004226;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 14px;
            border: 1px solid #e6e9e8;
            text-align: left;
        }
        .table-custom td {
            padding: 12px 14px;
            border: 1px solid #e6e9e8;
            font-size: 12.5px;
            color: #191c1c;
        }
        .charges-box {
            background: #f8faf9;
            border: 1px solid #e6e9e8;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 28px;
        }
        .charges-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e6e9e8;
            font-size: 13px;
        }
        .charges-row.total {
            border-bottom: none;
            padding-top: 12px;
            font-size: 15px;
            font-weight: 800;
            color: #004226;
        }
        .footer-legal {
            border-top: 1px solid #e6e9e8;
            padding-top: 18px;
            font-size: 10px;
            color: #73847c;
            line-height: 1.5;
        }
        @media print {
            body { background: #ffffff; padding: 0; }
            .advice-sheet { border: none; box-shadow: none; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="advice-sheet">
        <div class="no-print" style="text-align: right; margin-bottom: 16px;">
            <button onclick="window.print()" style="background: #004226; color: #ffffff; border: none; padding: 8px 18px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer;">
                Print Document
            </button>
        </div>

        <div class="header-row">
            <div>
                <span class="doc-type-badge">Electronic Funds Settlement Advice</span>
                <h1 class="brand-title"><?= $confiG->bank_name ?? 'Equitable Bank' ?></h1>
                <p class="brand-sub">Institutional Wire Operations & Bullion Clearance</p>
                <p style="font-size: 11px; color: #73847c; margin: 4px 0 0 0;"><?= $confiG->bank_address ?? 'Central Financial Hub' ?></p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0 0 4px 0; font-size: 11px; color: #53625b;">Advice Date: <strong><?= date("F j, Y") ?></strong></p>
                <p style="margin: 0; font-size: 11px; color: #53625b;">Phone: <strong><?= $confiG->bank_phone ?? '+1 (800) 555-0199' ?></strong></p>
                <p style="margin: 2px 0 0 0; font-size: 11px; color: #53625b;">Email: <strong><?= $confiG->bank_email ?? 'settlement@bank.com' ?></strong></p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h4>Ordering Customer (Sender)</h4>
                <p><strong><?= $user_info->title ?? '' ?> <?= $user_info->cust_name ?? '' ?> <?= $user_info->sur_name ?? '' ?></strong></p>
                <p><?= $user_info->cust_address ?? 'Registered Client Address' ?></p>
            </div>
            @foreach ($transaction_summary as $t_summary)
            <?php 
                $x = DB::table('ba_other_transfers')->where('user',$t_summary->user_id)->latest('id')->first();                               
                $benefi_name = $x ? DB::table('ba_beneficiary')->where('id',$x->benefe)->first() : null;
                $charges = DB::table('ba_transactions')->where('tran_id',$t_summary->tran_id)->where('type','charges')->first();
                $chargeAmount = $charges ? $charges->amount : 0;
                $total = $t_summary->amount + $chargeAmount;
                $footer_text = DB::table('ba_extras')->where('id','2')->first();
            ?>
            <div class="info-card">
                <h4>Beneficiary Counterparty</h4>
                <p><strong><?= $benefi_name->beneficiary_name ?? 'Designated Recipient' ?></strong></p>
                <p>Bank: <strong><?= $benefi_name->beneficiary_bank_name ?? 'Target Financial Institution' ?></strong></p>
                <p>Account: <strong class="font-mono"><?= $benefi_name->beneficiary_account ?? '—' ?></strong></p>
            </div>
        </div>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>Clearing Reference</th>
                    <th>Execution Timestamp</th>
                    <th>Channel Type</th>
                    <th>Settlement Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-mono" style="font-weight: 700; color: #004226;">{{ $t_summary->tran_id }}</td>
                    <td style="color: #53625b;">{{ $t_summary->datetime }}</td>
                    <td>SWIFT Telegraphic Clearance</td>
                    <td class="font-mono" style="font-weight: 800; font-size: 14px;">{{ $currency }} {{ number_format($t_summary->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="charges-box">
            <div class="charges-row">
                <span style="color: #53625b;">Principal Transfer Amount:</span>
                <span class="font-mono" style="font-weight: 600;">{{ $currency }} {{ number_format($t_summary->amount, 2) }}</span>
            </div>
            <div class="charges-row">
                <span style="color: #53625b;">Telegraphic / Clearance Surcharge:</span>
                <span class="font-mono" style="font-weight: 600;">{{ $currency }} {{ number_format($chargeAmount, 2) }}</span>
            </div>
            <div class="charges-row total">
                <span>Total Funds Debited:</span>
                <span class="font-mono">{{ $currency }} {{ number_format($total, 2) }}</span>
            </div>
        </div>
        @endforeach

        <div class="footer-legal">
            @if(isset($footer_text) && !empty($footer_text->loan_landing_text))
                <div>{!! $footer_text->loan_landing_text !!}</div>
            @endif
            <p style="margin-top: 10px;">This advice is generated automatically by the institutional core ledger and serves as official proof of payment. Authorized by the Prudential Regulation Authority.</p>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
