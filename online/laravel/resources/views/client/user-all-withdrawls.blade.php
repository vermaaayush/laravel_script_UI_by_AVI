<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('user-withdrawl') }}">Withdrawals</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Ledger</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Withdrawal Ledger</h1>
                <p class="text-sm text-slate-500 mt-1">Comprehensive historical record of all outbound funds disbursed from your accounts.</p>
            </div>
            <div>
                <a href="{{ url('user-withdrawl') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span> New Withdrawal
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">history</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">All Outbound Transactions</h3>
            </div>
            <span class="text-xs text-slate-400">{{ count($withdraws) }} Records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Account Number</th>
                        <th class="py-3.5 px-6">Amount</th>
                        <th class="py-3.5 px-6">Channel & Target</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Settled Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($withdraws as $single)
                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-slate-800">
                            {{ $account ? $account->account_no : '—' }}
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-rose-600">
                            -{{ number_format($single->amount, 2) }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900 block">{{ $single->withtype }}</span>
                            <span class="font-mono text-xs text-slate-400 block truncate max-w-xs">{{ $single->withid }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($single->approved == 0)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                                </span>
                            @elseif($single->approved == 1)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Awaiting Confirmation
                                </span>
                            @elseif($single->approved == 2)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                </span>
                            @elseif($single->approved == 3)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right text-xs font-mono text-slate-500">
                            {{ date('d M, Y', strtotime($single->date_of_with)) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">output</span>
                            <p class="text-sm font-semibold text-slate-600">No Historical Withdrawals</p>
                            <p class="text-xs text-slate-400 mt-0.5">All future completed disbursements will be chronicled in this directory.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
