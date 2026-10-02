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
?>




<!DOCTYPE html>
<html style="margin: 0px;">
    <head>
        <title>Transactions Export</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <style>
            *,body{
                font-family: 'Roboto', sans-serif;
            }
            .lbl-with-data{
                margin:0px;
                font-size:13px;
                margin-bottom:5px;
            }
            b{
                font-weight:500;
                font-family: 'Roboto', sans-serif;
            }
            .tb-statment th{
                color:#d94f00;
                font-size:12px;
                padding:2px;
                text-align:center;
            }
            .tb-statment td{
                color:#696969;
                padding:2px;
                font-size:11px;
            }
            .footer-p{
                margin:0px;
                font-size:11px;
                margin-bottom:5px;
            }
        </style>
    </head>
    <body style="font-family: 'Roboto', sans-serif;">
        <div style="background: #d94f00; margin:0 15px; margin-top:30px; padding:15px 20px 80px 20px;">
            <table style="width:100%;">
                <tr>
                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="color:#fff; font-weight:700; font-size:20px; width:35%;"><?= ucfirst($customer[0]->cust_name.' '.$customer[0]->middle_name.' '.$customer[0]->sur_name) ?></td>
                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="color:#fff; font-weight:500;font-size:16px; width:30%;" align="center"><u>Customer Statement</u></td>
                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="text-align:right; width:35%;">
                        <img src="<?= $logo ?>" style="width:100px; height:auto;" alt="<?= $bank_name ?>"/>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin:0 30px; margin-top:-50px; border:1px solid #bbb;">
            <div style="padding:15px 10px 20px 10px; background: #f5f5f5;">
                <table style="width: 100%;">
                    <tr>
                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:45%; vertical-align: top;">
                            <p class="lbl-with-data"><b>Print Date: </b> <?= date('F d,Y') ?></p>
                            <p class="lbl-with-data"><b>Account No: </b> <?= $account_no ?></p>
                            <p class="lbl-with-data"><b>Period: </b> <?= date('F d,Y',$start).' - '.date('F d,Y',$end) ?></p>
                            <p class="lbl-with-data"><b>Total Debit: </b> <?= number_format($debitAmount,2,'.',',') ?></p>
                            <p class="lbl-with-data"><b>Branch Name: </b> <?= $account[0]->branch_name ?></p>
                            <p class="lbl-with-data"><b>Debit Count: </b> <?= number_format($debitCount,2,'.',',') ?></p>
                        </td>
                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:55%; vertical-align: top;" >
                            <p class="lbl-with-data"><b>Address: </b> <?= $customer[0]->cust_address ?></p>
                            <p class="lbl-with-data"><b>Currency: </b> <?= $account[0]->account_currency ?></p>
                            <p class="lbl-with-data"><b>Opening Balance: </b> 0</p>
                            <p class="lbl-with-data"><b>Closing Balance: </b> <?= number_format($closingBal,2,'.',',') ?></p>
                            <p class="lbl-with-data"><b>Credit Count: </b> <?= number_format($creditCount,2,'.',',') ?></p>
                            <p class="lbl-with-data"><b>Total Credit: </b> <?= number_format($creditAmount,2,'.',',') ?></p>
                            <p class="lbl-with-data"><b>Account Type: </b> <?= $account[0]->account_type ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="padding:5px 10px 5px 10px;">
                <table style="width:100%; border-collapse: collapse;" class="tb-statment">
                    <tr>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="width:10%;">Trans Date</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="width:15%;">Refe…</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="width:15%; text-align:right;">Debit</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="width:15%; text-align:right;">Credit</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="width:15%; text-align:right;">Balance</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="width:30%;">Remarks</th>
                    </tr>
                    @foreach($transactions as $row)
                        <tr>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:100%;" colspan="6">
                                <table style="width:100%;">
                                    <tr>
                                        <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="border-top:1px solid #bbb;"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:10%; text-align:center;"><?php echo date("d-M-Y", strtotime($row->datetime)); ?></td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:15%;">{{ $row->tran_id }}</td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:15%; text-align:right;">
                                @if($row->type == 'debited' || $row->type == 'charges' || $row->type == 'transfer')
                                    {{ $row->amount }}
                                @endif
                            </td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:15%; text-align:right;">
                                @if($row->type == 'credited')
                                    {{ $row->amount }}
                                @endif
                            </td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:15%; text-align:right;">
                                {{ $row->balance }}
                            </td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" style="width:30%;">
                                {{ $row->reason }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <?php $conFig = DB::table('configs')->where('id','1')->first(); ?>
        <div style="background: #f5f5f5; margin:0 15px; margin-top:20px; padding:15px 20px 15px 20px;">
            <p class="footer-p">PLEASE ADDRESS ALL ENQUIRIES TO <?= strtoupper($bank_name) ?></p>  
            <p class="footer-p"><?= strtoupper($conFig->bank_address) ?></p>  
            <p class="footer-p">PHONE <?= strtoupper($conFig->bank_phone) ?> FAX <?= strtoupper($conFig->bank_fax) ?></p>  
            <p class="footer-p">OR THE CUSTOMER INFORMATION UNIT OF YOUR LOCAL BRANCH</p>  
        </div>
    </body>
</html>
