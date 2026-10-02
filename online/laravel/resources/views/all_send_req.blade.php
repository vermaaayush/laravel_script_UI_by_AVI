@php
    $user_id = session()->get('user_id');

    $trans_data = DB::table('transactions')
        ->where('user_id', $user_id)
        ->where('subject', 'Fund Transfer')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- //  Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<!-- Page Content -->
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-[#b34020] transition-colors" href="{{ url('portfolio') }}">Digital Assets</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-800">Dispatch Queue</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Outgoing Crypto Transfers</h1>
                <p class="text-sm text-slate-500 mt-1">Status of on-chain dispatches and pending network settlement requests.</p>
            </div>
            <div>
                <a href="{{ url('portfolio') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-50 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Return to Portfolio</span>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Outbound Requests</span>
            <span class="text-xs font-mono text-slate-500 font-semibold">{{ count($trans_data) }} Total Transfers</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="p-4 whitespace-nowrap">Timestamp</th>
                        <th class="p-4 whitespace-nowrap">Transaction ID</th>
                        <th class="p-4 whitespace-nowrap">Amount</th>
                        <th class="p-4 whitespace-nowrap">Destination Address</th>
                        <th class="p-4 whitespace-nowrap text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($trans_data as $transaction)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 text-slate-900">
                                <span class="block font-semibold font-mono text-xs">{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i:s') }}</span>
                                <span class="text-slate-400 text-xs font-mono">{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</span>
                            </td>
                            <td class="p-4 font-mono text-xs font-bold text-slate-800">
                                {{ $transaction->tr_id }}
                            </td>
                            <td class="p-4 font-mono font-bold text-slate-900 text-sm">
                                ${{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="p-4 font-mono text-xs text-slate-600 max-w-xs truncate" title="{{ $transaction->sent_from }}">
                                {{ $transaction->sent_from }}
                            </td>
                            <td class="p-4 text-center">
                                @if ($transaction->status == 'Debit')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Debit</span>
                                @elseif ($transaction->status == 'Pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                                @elseif ($transaction->status == 'Credit')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Credit</span>
                                @elseif ($transaction->status == 'Reject')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Rejected</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">{{ $transaction->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-[48px] text-slate-300 mb-2">send</span>
                                <p class="text-sm font-semibold">No send requests found.</p>
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
