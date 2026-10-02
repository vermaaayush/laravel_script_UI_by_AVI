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
            <span class="text-slate-400">Transfers</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Resume Pending</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Resume Pending Transfers</h1>
                <p class="text-sm text-slate-500 mt-1">Review incomplete or authorization-pending wires and resume their verification steps.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200/60 rounded-full text-xs font-bold uppercase tracking-wider">
                    {{ count($transactions) }} Pending
                </span>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">pending_actions</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Queue List</h3>
            </div>
            <span class="text-xs text-slate-400">Select any transaction to resume verification</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">From Account</th>
                        <th class="py-3.5 px-6">To Account</th>
                        <th class="py-3.5 px-6">Routing Type</th>
                        <th class="py-3.5 px-6">Amount</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-slate-800">
                            {{ $transaction->act_number }}
                        </td>
                        <td class="py-4 px-6 font-mono text-slate-600">
                            <?= $transaction->other_transactions && count($transaction->other_transactions) ? $transaction->other_transactions[0]->act_number : '<span class="text-slate-400 font-sans text-xs">Direct Wire</span>' ?>
                        </td>
                        <td class="py-4 px-6">
                            @if($transaction->international == 1)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> International Wire
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Local Transfer
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-slate-900">
                            {{ $transaction->amount }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($transaction->international == 1)
                                <a href="{{ asset('resume-international-transfer/' . $transaction->tran_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-colors">
                                    <span>Resume</span>
                                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                </a>
                            @else
                                <a href="{{ asset('resume-local-transfer/' . $transaction->tran_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-colors">
                                    <span>Resume</span>
                                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">check_circle</span>
                            <p class="text-sm font-semibold text-slate-600">No Pending Transfers</p>
                            <p class="text-xs text-slate-400 mt-0.5">All wire and local transfers have been fully completed.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- // Page Content -->

<!-- footer -->
@include('footer')
<!-- // footer -->
