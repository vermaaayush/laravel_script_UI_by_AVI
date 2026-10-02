<?php

namespace App\Exports;
use DB;
use App\Transactions;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExportOld implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(string $account_no, string $start, string $end)
    {
        $this->account_no = $account_no;
        $this->start = $start;
        $this->end = $end;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Narration',
            'Ref/Transaction ID',
            'Reason',
            'Amount',
            'Balance',
        ];
    }

    public function query()
    {
        // return Transactions::query();
        $account_no = $this->account_no;
        $start = $this->start;
        $end = $this->end;
        // return Transactions::whereRaw("select * from ba_transactions where act_number = '$account_no' and UNIX_TIMESTAMP(datetime) between '$start' and '$end' order by datetime desc")->toSql();
        return DB::table('ba_transactions')
           ->select('datetime', 'type', 'tran_id', 'reason', 'amount', 'balance')
           ->where('act_number', $account_no)
           ->whereBetween(DB::raw('unix_timestamp(datetime)'), [$start, $end])->orderBy('datetime', 'desc');
    }
}