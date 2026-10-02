<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a class="hover:text-slate-900 transition-colors" href="{{ asset('account-statement') }}">Statements</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">Statement Results</span>
            </nav>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Statement Record</h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Period: <strong><?= date("d M Y", strtotime($start)); ?></strong> to <strong><?= date("d M Y", strtotime($end)); ?></strong> • Account: <strong class="font-mono"><?= $account[0]->account_no; ?></strong>
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ asset('account-statement') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">tune</span>
                <span>Change Filter</span>
            </a>
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition-colors shadow-2xs flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">print</span>
                <span>Print</span>
            </button>
        </div>
    </div>

    <!-- Statement Table Card -->
    <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card">
        <div class="overflow-x-auto">
            <table class="table _dataTable w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Ref/Tran ID</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4 text-right">Debit (-)</th>
                        <th class="py-3 px-4 text-right">Credit (+)</th>
                        <th class="py-3 px-4 text-right">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @foreach($transactions as $row)
                        <?php 
                            $currncyN = DB::table('ba_user_accounts')->where('account_no',$row->act_number)->first(); 
                            $crnCy = $currncyN ? $currncyN->account_currency : ""; 
                        ?>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap font-medium">
                                <?= date("d M Y", strtotime($row->datetime)); ?>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($row->type == 'debited' || $row->type == 'charges')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 capitalize">Debit</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 capitalize">Credit</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500">{{ $row->tran_id }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $row->reason }}</td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-rose-600">
                                @if($row->type == 'debited' || $row->type == 'charges')
                                    -{{ $crnCy }} {{ number_format($row->amount, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-emerald-600">
                                @if($row->type == 'credited')
                                    +{{ $crnCy }} {{ number_format($row->amount, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900">
                                {{ $crnCy }} {{ number_format($row->balance, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('footer')
