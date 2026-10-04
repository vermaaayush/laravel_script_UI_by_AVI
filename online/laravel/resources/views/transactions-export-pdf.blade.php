<?php 
$debitCount = 0;
$creditCount = 0;
$debitAmount = 0;
$creditAmount = 0;
$closingBal = 0;
foreach($transactions as $row){ 
    if($row->type == 'debited' || $row->type == 'charges' || $row->type == 'transfer'){
        $debitAmount += $row->amount;
        $debitCount++;
    }   
    
    if($row->type == 'credited'){
        $creditAmount += $row->amount;
        $creditCount++;
    }
    
    $closingBal = $row->balance;
}
$conFig = DB::table('configs')->where('id','1')->first();
?>
<!DOCTYPE html>
<html style="margin: 0px;">
    <head>
        <meta charset="utf-8">
        <title>Official Account Statement</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
        <style>
            *, body {
                font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
                box-sizing: border-box;
            }
            body {
                margin: 0;
                padding: 24px;
                color: #191c1c;
                background: #ffffff;
            }
            .header-banner {
                background: #004226;
                color: #ffffff;
                border-radius: 16px;
                padding: 24px 28px;
                margin-bottom: 20px;
            }
            .title-h1 {
                font-size: 20px;
                font-weight: 800;
                margin: 0 0 4px 0;
                letter-spacing: -0.01em;
            }
            .subtitle {
                font-size: 11px;
                color: #aaf2c4;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                margin: 0;
                font-weight: 700;
            }
            .info-panel {
                background: #f8faf9;
                border: 1px solid #e6e9e8;
                border-radius: 14px;
                padding: 18px 20px;
                margin-bottom: 20px;
            }
            .lbl-with-data {
                margin: 0 0 6px 0;
                font-size: 11.5px;
                color: #53625b;
            }
            .lbl-with-data strong {
                color: #191c1c;
                font-weight: 700;
            }
            .tb-statment {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 24px;
            }
            .tb-statment th {
                background: #f8faf9;
                color: #004226;
                font-size: 10.5px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                padding: 10px 12px;
                border-bottom: 1.5px solid #e6e9e8;
            }
            .tb-statment td {
                color: #191c1c;
                padding: 9px 12px;
                font-size: 11px;
                border-bottom: 1px solid #f0f2f1;
            }
            .amount-debit {
                color: #ba1a1a;
                font-weight: 700;
                font-family: 'JetBrains Mono', monospace;
            }
            .amount-credit {
                color: #006c42;
                font-weight: 700;
                font-family: 'JetBrains Mono', monospace;
            }
            .font-mono {
                font-family: 'JetBrains Mono', monospace;
            }
            .footer-p {
                margin: 0 0 4px 0;
                font-size: 10px;
                color: #73847c;
                line-height: 1.4;
            }
            .footer-card {
                background: #f8faf9;
                border: 1px solid #e6e9e8;
                border-radius: 12px;
                padding: 14px 18px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="header-banner">
            <table style="width: 100%;">
                <tr>
                    <td style="vertical-align: middle;">
                        <p class="subtitle">Official Statement of Account</p>
                        <h1 class="title-h1"><?= ucfirst($customer[0]->cust_name.' '.$customer[0]->middle_name.' '.$customer[0]->sur_name) ?></h1>
                        <p style="margin: 0; font-size: 11px; color: #e8f7ee;"><?= strtoupper($bank_name ?? 'Equitable Bank') ?> Institutional Private Banking</p>
                    </td>
                    <td style="text-align: right; vertical-align: middle;">
                        @if($logo)
                            <img src="<?= $logo ?>" style="max-height: 38px; width: auto; object-fit: contain; filter: brightness(0) invert(1);" alt="<?= $bank_name ?>"/>
                        @else
                            <h2 style="margin: 0; color: #ffffff; font-size: 18px; font-weight: 800;"><?= $bank_name ?></h2>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="info-panel">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding-right: 14px;">
                        <p class="lbl-with-data"><strong>Statement Date:</strong> <?= date('F d, Y') ?></p>
                        <p class="lbl-with-data"><strong>Account Number:</strong> <span class="font-mono"><?= $account_no ?></span></p>
                        <p class="lbl-with-data"><strong>Statement Period:</strong> <?= date('F d, Y', $start).' — '.date('F d, Y', $end) ?></p>
                        <p class="lbl-with-data"><strong>Operating Branch:</strong> <?= $account[0]->branch_name ?></p>
                        <p class="lbl-with-data"><strong>Total Debits:</strong> <span class="amount-debit">-<?= number_format($debitAmount, 2, '.', ',') ?></span> (<?= $debitCount ?> transactions)</p>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding-left: 14px; border-left: 1px solid #e6e9e8;">
                        <p class="lbl-with-data"><strong>Client Address:</strong> <?= $customer[0]->cust_address ?></p>
                        <p class="lbl-with-data"><strong>Base Currency:</strong> <?= $account[0]->account_currency ?></p>
                        <p class="lbl-with-data"><strong>Account Type:</strong> <?= $account[0]->account_type ?></p>
                        <p class="lbl-with-data"><strong>Total Credits:</strong> <span class="amount-credit">+<?= number_format($creditAmount, 2, '.', ',') ?></span> (<?= $creditCount ?> transactions)</p>
                        <p class="lbl-with-data"><strong>Closing Balance:</strong> <strong class="font-mono" style="font-size: 13px; color: #004226;"><?= number_format($closingBal, 2, '.', ',') ?></strong></p>
                    </td>
                </tr>
            </table>
        </div>

        <table class="tb-statment">
            <thead>
                <tr>
                    <th style="width: 12%; text-align: left;">Date</th>
                    <th style="width: 16%; text-align: left;">Reference</th>
                    <th style="width: 14%; text-align: right;">Debit (-)</th>
                    <th style="width: 14%; text-align: right;">Credit (+)</th>
                    <th style="width: 16%; text-align: right;">Balance</th>
                    <th style="width: 28%; text-align: left;">Narrative / Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $row)
                    <tr>
                        <td style="font-size: 10px; color: #53625b;"><?= date("d M Y", strtotime($row->datetime)) ?></td>
                        <td class="font-mono" style="font-size: 10px; color: #53625b;">{{ $row->tran_id }}</td>
                        <td style="text-align: right;">
                            @if($row->type == 'debited' || $row->type == 'charges' || $row->type == 'transfer')
                                <span class="amount-debit">-{{ number_format($row->amount, 2) }}</span>
                            @else
                                <span style="color: #c5cac7;">—</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @if($row->type == 'credited')
                                <span class="amount-credit">+{{ number_format($row->amount, 2) }}</span>
                            @else
                                <span style="color: #c5cac7;">—</span>
                            @endif
                        </td>
                        <td style="text-align: right;" class="font-mono" style="font-weight: 700;">
                            {{ number_format($row->balance, 2) }}
                        </td>
                        <td style="font-size: 10.5px; color: #191c1c;">
                            {{ $row->reason }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 24px; color: #73847c;">
                            No financial movements recorded during this period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-card">
            <p class="footer-p" style="font-weight: 700; color: #004226;">CONFIDENTIAL CLIENT STATEMENT — ADDRESS ALL INQUIRIES TO <?= strtoupper($bank_name ?? 'EQUITABLE BANK') ?></p>  
            <p class="footer-p"><?= strtoupper($conFig->bank_address ?? 'Central Financial District') ?></p>  
            <p class="footer-p">PHONE: <?= strtoupper($conFig->bank_phone ?? '+1 (800) 555-0199') ?> &bull; EMAIL: <?= strtolower($conFig->bank_email ?? 'concierge@equitable.com') ?></p>  
            <p class="footer-p" style="font-size: 9px; color: #8e9e97; margin-top: 6px;">Certified by FINMA & FCA Institutional Clearing Gateway &bull; Cryptographically Sealed Document</p>  
        </div>
    </body>
</html>
