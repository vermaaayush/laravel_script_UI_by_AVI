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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors" href="{{ url('portfolio') }}">Digital Custody Vault</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Dispatch Queue</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Outgoing Crypto Transfers</h1>
                <p class="text-sm text-[#53625b] mt-1">Status of on-chain dispatches and pending network settlement requests.</p>
            </div>
            <div>
                <a href="{{ url('portfolio') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-[#e6e9e8] text-[#53625b] text-xs font-bold hover:bg-[#f8faf9] transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Return to Vault</span>
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] overflow-hidden">
        <div class="p-5 border-b border-[#f2f4f3] flex items-center justify-between bg-[#f8faf9]">
            <span class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Outbound Requests</span>
            <span class="text-xs font-mono text-[#53625b] font-semibold">{{ count($trans_data) }} Total Transfers</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#f8faf9] text-[#53625b] text-[11px] font-bold uppercase tracking-wider border-b border-[#f2f4f3]">
                    <tr>
                        <th class="p-4 whitespace-nowrap">Timestamp</th>
                        <th class="p-4 whitespace-nowrap">Transaction ID</th>
                        <th class="p-4 whitespace-nowrap">Volume</th>
                        <th class="p-4 whitespace-nowrap">Destination Address</th>
                        <th class="p-4 whitespace-nowrap text-center">Settlement Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f4f3] text-sm">
                    @forelse ($trans_data as $transaction)
                        <tr class="hover:bg-[#f8faf9] transition-colors">
                            <td class="p-4 text-[#191c1c]">
                                <span class="block font-semibold font-mono text-xs">{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i:s') }}</span>
                                <span class="text-[#53625b] text-xs font-mono">{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</span>
                            </td>
                            <td class="p-4 font-mono text-xs font-bold text-[#191c1c]">
                                {{ $transaction->tr_id }}
                            </td>
                            <td class="p-4 font-mono font-bold text-rose-600 text-sm">
                                -${{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="p-4 font-mono text-xs text-[#53625b] max-w-xs truncate" title="{{ $transaction->sent_from }}">
                                {{ $transaction->sent_from }}
                            </td>
                            <td class="p-4 text-center">
                                @if ($transaction->status == 'Debit')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">Settled Outflow</span>
                                @elseif ($transaction->status == 'Pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Pending Broadcast</span>
                                @elseif ($transaction->status == 'Credit')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">Credit</span>
                                @elseif ($transaction->status == 'Reject')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Declined</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#f2f4f3] text-[#53625b]">{{ $transaction->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-[#53625b]">
                                <span class="material-symbols-outlined text-[42px] text-[#53625b]/40 mb-2">send</span>
                                <p class="text-sm font-semibold text-[#191c1c]">No Outbound Transfers Found</p>
                                <p class="text-xs text-[#53625b] mt-0.5">Pending blockchain transfers will display here.</p>
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
