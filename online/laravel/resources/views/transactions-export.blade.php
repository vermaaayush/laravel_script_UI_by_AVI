<!DOCTYPE html>
<html>
<head>
    <title>Transactions Export</title>
</head>
<body>
<div style="width: 1024px;">
<table>
    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap"ead class="bg-surface-container-low text-on-surface-variant font-semibold">
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; text-align: center; font-size: 15px; font-weight: bold;">&nbsp;</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; text-align: center; font-size: 15px; font-weight: bold;"><?= strtoupper($bankname) ?></th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; text-align: center; font-size: 15px; font-weight: bold;">&nbsp;</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; text-align: center; font-size: 15px; font-weight: bold;">CUSTOMER STATEMENT</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; text-align: center; font-size: 15px; font-weight: bold;">&nbsp;</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #000000; text-align: center; font-size: 15px; font-weight: bold;"><?= ucfirst($customer[0]->cust_name.' '.$customer[0]->middle_name.' '.$customer[0]->sur_name) ?></th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; text-align: center; font-size: 15px; font-weight: bold;">&nbsp;</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #000000;">Print Date: <?php echo date("d/M/Y"); ?></th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #000000;">Address: {{ $customer[0]->cust_address . " " . $customer[0]->cust_city . " " . $customer[0]->cust_state . " " . $customer[0]->cust_country . " " . $customer[0]->post_code }}</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #000000;">Account No: {{ $account_no }}</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #000000;">Currency: {{ $account[0]->account_currency }}</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #000000;">Period: <?php echo date("d/F/Y", $start); ?> To <?php echo date("d/F/Y", $end); ?></th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; text-align: center; font-size: 15px; font-weight: bold;">&nbsp;</th>
    </tr>
    <tr>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="color: #006600; font-weight: bold; font-size: 12px; width: 20px">Trans Date</th>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="color: #006600; font-weight: bold; font-size: 12px; width: 40px">Reference</th>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="color: #006600; font-weight: bold; font-size: 12px; width: 15px">Debit</th>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="color: #006600; font-weight: bold; font-size: 12px; width: 15px">Credit</th>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="color: #006600; font-weight: bold; font-size: 12px; width: 15px">Balance</th>
        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" style="color: #006600; font-weight: bold; font-size: 12px; width: 60px">Remarks</th>
    </tr>
    </thead>
    <tbody>
        <?php $conFig = DB::table('configs')->where('id','1')->first(); ?>
        @foreach($transactions as $row)
        <tr>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ date('d/M/Y',strtotime($row->datetime)) }}</td>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->tran_id }}</td>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                @if($row->type == 'debited' || $row->type == 'charges')
                    {{ $row->amount }}
                @endif
            </td>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                @if($row->type == 'credited')
                    {{ $row->amount }}
                @endif
            </td>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->balance }}</td>
            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->reason }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; font-size: 13px; font-weight: bold;">&nbsp;</th>
        </tr>
        <tr>
            <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; font-size: 13px; font-weight: bold;">PLEASE ADDRESS ALL ENQUIRIES TO <?= strtoupper($bankname) ?></th>
        </tr>
        <tr>
            <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; font-size: 13px; font-weight: bold;"><?= strtoupper($conFig->bank_address) ?></th>
        </tr>
        <tr>
            <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; font-size: 13px; font-weight: bold;">PHONE <?= strtoupper($conFig->bank_phone) ?> FAX <?= strtoupper($conFig->bank_fax) ?></th>
        </tr>
        <tr>
            <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" colspan="6" style="color: #006600; font-size: 13px; font-weight: bold;">OR THE CUSTOMER INFORMATION UNIT OF YOUR LOCAL BRANCH</th>
        </tr>
    </tfoot>
</table>
</div>
</body>
</html>
