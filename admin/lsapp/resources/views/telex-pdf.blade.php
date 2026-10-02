<?php $transfer = DB::table('ba_other_transfers')->where('id',$id)->first(); ?>
<?php $config = DB::table('configs')->where('id','1')->first(); ?>
<?php $stamp = DB::table('ba_extra_asset')->where('id','1')->first()->telex_stamp; ?>
<?php $user = DB::table('ba_account_holders')->where('user_id',$transfer->user)->first(); ?>
<?php $bene = DB::table('ba_beneficiary')->where('id',$transfer->benefe)->first(); ?>
<?php $account = DB::table('ba_user_accounts')->where('id',$transfer->account)->first(); ?>
<?php $am = DB::table('ba_am')->where('id',$user->am)->first(); ?>
<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <style>
            @font-face {
                font-family: "Courier New";
                src: url("<?= asset('exasset/pdf/cour.ttf') ?>");
            }
            @font-face {
                font-family: "Courier New";
                src: url("<?= asset('exasset/pdf/courbd.ttf') ?>");
                font-weight: bold;
            }
            
            body{
                font-family: 'Courier New'; 
                font-size:12px;
            }
            @page { margin: 0px; }
            body { margin: 10px; }
        </style>
    </head>
    <body>
        <div class="logo-div">
            <img src="<?= $logo ?>" style="width:20%;" />
        </div>
        
        <div class="top-container">
            <table style="width:100%;">
                <tr>
                    <td>NOTIFICATION</td>
                    <td>: Network Ack</td>
                </tr>
                <tr>
                    <td>DELIVERY STATUS</td>
                    <td>: Approved</td>
                </tr>
                <tr>
                    <td>PRIORITY / DELIVERY</td>
                    <td>: Normal</td>
                </tr>
                <tr>
                    <td>MESSAGE INPUT REFERENCE</td>
                    <td>: <?= date('Y',strtotime($transfer->cat)); ?> 0<?= $transfer->id.strtoupper(str_replace(' ','', $bank)) ?><?= strtotime($transfer->cat); ?></td>
                </tr>
            </table>
        </div>
        
        <div class="border" style="width: 95%;text-align:center;margin: 0 auto;">
            ------------------------------------MESSAGE HEADER------------------------------------
        </div>
        
        <div class="middle-container">
            <table style="width:100%;">
                <tr>
                    <td>SENDER</td>
                    <td>: <?= $user->cust_name.' '.$user->middle_name.' '.$user->sur_name ?></td>
                </tr>
                <tr>
                    <td>BANK NAME</td>
                    <td>: <?= strtoupper($bank) ?></td>
                </tr>
                <tr>
                    <td>BANK ADDRESS</td>
                    <td>: <?= $config->bank_address ?></td>
                </tr>
                <tr>
                    <td>AMOUNT</td>
                    <td>: <?= $transfer->currency.' '.number_format($transfer->amount,2) ?></td>
                </tr>
                <tr>
                    <td>ACCOUNT NAME</td>
                    <td>: <?= $account && $account->account_title != null?$account->account_title:''; ?></td>
                </tr>
                <tr>
                    <td>ACCOUNT NUMBER</td>
                    <td>: <?= $account && $account->account_no != null?$account->account_no:''; ?></td>
                </tr>
                <tr>
                    <td>RECEIVER</td>
                    <td>: <?= $bene && $bene->beneficiary_name != null?$bene->beneficiary_name:''; ?></td>
                </tr>
                <tr>
                    <td>BANK</td>
                    <td>: <?= $bene && $bene->beneficiary_bank_name != null?$bene->beneficiary_bank_name:''; ?></td>
                </tr>
                <tr>
                    <td>BANK ADDRESS</td>
                    <td>: <?= $bene && $bene->beneficiary_bank_address != null?$bene->beneficiary_bank_address:''; ?></td>
                </tr>
                <tr>
                    <td>IBAN NO.</td>
                    <td>: <?= $bene && $bene->beneficiary_iban != null?$bene->beneficiary_iban:''; ?></td>
                </tr>
                <tr>
                    <td>BANK OFFICER</td>
                    <td>: <?= $am?$am->name:'' ?></td>
                </tr>
                <tr>
                    <td>ACCOUNT NAME</td>
                    <td>: <?= $bene && $bene->beneficiary_name != null?$bene->beneficiary_name:''; ?></td>
                </tr>
                <tr>
                    <td>ACCOUNT NUMBER</td>
                    <td>: <?= $bene && $bene->beneficiary_account != null?$bene->beneficiary_account:''; ?></td>
                </tr>
                <tr>
                    <td>IN FAVOR OF</td>
                    <td>: TRANSFER</td>
                </tr>
                
                
                
            </table>
        </div>
        
        <div class="border" style="width: 95%;text-align:center;margin: 0 auto;">
            --------------------------------SWIFT MESSAGE TEXT--------------------------------
        </div>
        <div class="top-container">
            <table style="width:100%;">
                <tr>
                    <td>TRANSACTION CODE</td>
                    <td>: <?= strtoupper(str_replace(' ','', $bank)) ?>/0<?= $transfer->id.mt_rand(11111,99999) ?></td>
                </tr>
                <tr>
                    <td>TRANSACTION NUMBER</td>
                    <td>: <?= $transfer->user ?>/<?= strtoupper(str_replace(' ','', $bank)) ?> /0<?= $transfer->id ?></td>
                </tr>
            </table>
        </div>
        <div class="top-container">
            <p><b>WE, <?= strtoupper($bank) ?></b> REPRESENTED BY THE UNDERSIGNED OFFICERS, HEREBY CONFIRM, WITH FULL RESPONSIBILITY AND LIABILITY ON BEHALF OF OUR ACCOUNT HOLDER <b><?= $account && $account->account_title != null?$account->account_title:''; ?></b> ASSETS IN THE AMOUNT OF <?= strtoupper(convertNumberToWord($transfer->amount)) ?> <?= $transfer->currency ?> <b>(<?= $transfer->currency.' '.number_format($transfer->amount,2) ?>)</b> IN ACCOUNT NUMBER <b><?= $account && $account->account_no != null?$account->account_no:''; ?></b> AS OF THE DATE OF THIS TRANSMISSION IN FAVOR OF <b><?= $bene && $bene->beneficiary_name != null?$bene->beneficiary_name:''; ?></b> FOR THE TRANSACTION <b>REFERENCED ABOVE</b></p>
        </div>
        <div class="top-container">
            <p>WE FURTHER CONFIRM THAT THESE ASSETS ARE GOOD, CLEAN, CLEARED GREAT BRITISH POUNDS OF NON-CRIMINAL ORIGIN AND ARE FROM LEGAL SOURCES. WE ALSO CONFIRM THAT THESE ASSETS ARE VERIFIABLE AND CONFIRMABLE ON A BANK-TO-BANK BASIS. <b>THIS IRREVOCABLE PROOF OF FUNDS WILL BE BLOCKED FOR A PERIOD OF ONE (1) YEAR AND ONE (1) MONTH IN FAVOR OF <?= $account && $account->account_title != null?$account->account_title:''; ?></b></p>
        </div>
        <div class="top-container">
            <p>THIS IS AN OPERATIVE BANK INSTRUMENT AND IS SUBJECT TO THE UNIFORM CODE THROUGH SWIFT MT799 AS IT RELATES TO BANK CREDIT INSTRUMENTS.</p>
        </div>
        <div class="top-container">
            <table style="width:100%;">
                <tr>
                    <td style="width:50%;">
                        <p>DATE RECORDED : <b><?= date('d M, Y',strtotime($transfer->cat)); ?></b> </p>    
                        BANKOFFICER.  <?= $am?$am->name:'' ?><br>
                        TITLE.   OFFICER IN CHARGE
                    </td>
                    <td style="width:50%; text-align:right;">
                        <img src="<?= asset('exasset/uploads/extra/').'/'.$stamp ?>" style="width:180px; height:180px;"/>
                    </td>
                </tr>
            </table>
        </div>
        <style>
            .logo-div{
                text-align:center;
            }
            .top-container{
                width: 80%;
                margin: 0 auto;
            }
            .middle-container{
                width: 60%;
                margin: 0 auto;
            }
            
            table td,table th{
                width:50%;
                padding:2px;
            }
            p{
                margin-bottom:5px;
                margin-top:2px;
            }
        </style>
    </body>
</html>
<?php
function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}
?>