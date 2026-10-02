<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionsExport implements FromView
{

    public function __construct(string $bankname,array $transactions, array $customer, array $account, string $account_no, string $start, string $end)
    {
        $this->transactions = $transactions;
        $this->customer = $customer;
        $this->account = $account;
        $this->account_no = $account_no;
        $this->start = $start;
        $this->end = $end;
        $this->bankname = $bankname;
    }

    public function view(): View
    {
        return view('transactions-export', [
            'transactions' => $this->transactions, 
            'customer' => $this->customer,
            'account' => $this->account,
            'account_no' => $this->account_no,
            'start' => $this->start,
            'end' => $this->end,
            'bankname' => $this->bankname
        ]);
    }
}