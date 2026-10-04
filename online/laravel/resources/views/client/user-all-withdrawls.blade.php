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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors flex items-center gap-1" href="{{ url('/') }}">
                <span class="material-symbols-outlined text-[14px]">home</span> Custody Portal
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-[#004226] transition-colors" href="{{ url('user-whitdrawal') }}">Withdrawals</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Historical Ledger</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Withdrawal Dispatch Ledger</h1>
                <p class="text-sm text-[#53625b] mt-1">Comprehensive historical record of all outbound funds disbursed across all custody vaults.</p>
            </div>
            <div>
                <a href="{{ url('user-whitdrawal') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                    <span>New Withdrawal Order</span>
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-[#f2f4f3] flex items-center justify-between bg-[#f8faf9]">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#004226] text-[20px]">history</span>
                <h3 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">All Outbound Settlements</h3>
            </div>
            <span class="text-xs font-mono text-[#53625b]">{{ count($withdraws ?? []) }} Records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] text-[11px] font-bold text-[#53625b] uppercase tracking-wider border-b border-[#f2f4f3]">
                        <th class="py-3.5 px-6">Account Number</th>
                        <th class="py-3.5 px-6">Disbursed Volume</th>
                        <th class="py-3.5 px-6">Channel & Target</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Settled Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f4f3] text-sm">
                    @forelse($withdraws ?? [] as $single)
                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                    <tr class="hover:bg-[#f8faf9] transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-[#191c1c]">
                            {{ $account ? $account->account_no : '—' }}
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-rose-600">
                            -{{ Session::get('account_currency') ?? '$' }} {{ number_format($single->amount, 2) }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-[#191c1c] block">{{ $single->withtype }}</span>
                            <span class="font-mono text-xs text-[#53625b] block truncate max-w-xs">{{ $single->withid }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($single->approved == 0)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Under Review
                                </span>
                            @elseif($single->approved == 1)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Awaiting Confirmation
                                </span>
                            @elseif($single->approved == 2)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span> Approved
                                </span>
                            @elseif($single->approved == 3)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right text-xs font-mono text-[#53625b]">
                            {{ date('d M Y', strtotime($single->date_of_with)) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-[#53625b]">
                            <span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-2">output</span>
                            <p class="text-sm font-semibold text-[#191c1c]">No Historical Withdrawals</p>
                            <p class="text-xs text-[#53625b] mt-0.5">All future completed disbursements will be chronicled in this directory.</p>
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
