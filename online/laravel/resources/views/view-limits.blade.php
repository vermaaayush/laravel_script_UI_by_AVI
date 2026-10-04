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
            <span class="text-[#53625b]">Risk & Safeguards</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Transaction Velocity Ceilings</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Account Velocity Limits</h1>
                <p class="text-sm text-[#53625b] mt-1">Review active transaction ceilings, settlement thresholds, and monthly dispatch allowances.</p>
            </div>
            <div>
                <a href="{{ url('request-limit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                    <span>Request Limit Increase</span>
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Account Selection Card -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm p-6 limit-accounts">
                <div class="flex items-center justify-between pb-4 border-b border-[#f2f4f3] mb-4">
                    <h3 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#004226] text-[18px]">account_balance_wallet</span>
                        <span>Select Custody Vault</span>
                    </h3>
                    <span class="text-xs font-mono text-[#53625b]">{{ count($accounts ?? []) }} Accounts</span>
                </div>

                <div class="space-y-3">
                    @foreach($accounts ?? [] as $key => $account)
                    <label for="account{{$key}}" class="flex items-center justify-between p-4 rounded-xl border border-[#e6e9e8] hover:border-[#004226]/40 hover:bg-[#f8faf9] cursor-pointer transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" class="w-4 h-4 text-[#004226] focus:ring-[#004226] border-[#e6e9e8]" name="cust_act_number" id="account{{$key}}" value="{{ $account->account_no }}" @if($key == 0) checked @endif>
                            <div>
                                <span class="font-mono text-sm font-bold text-[#191c1c] block">{{ $account->account_no }}</span>
                                <span class="text-xs text-[#53625b]">{{ $account->account_type }} &bull; {{ $account->branch_name }}</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-[#53625b] text-[18px]">chevron_right</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Active Limits Table Card -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-[#f2f4f3] flex items-center justify-between bg-[#f8faf9]">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#004226] text-[20px]">tune</span>
                        <h3 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Active Limits Ledger</h3>
                    </div>
                    <span class="text-xs text-[#53625b] font-medium">Monthly Rolling Cap</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#f8faf9] text-[11px] font-bold text-[#53625b] uppercase tracking-wider border-b border-[#f2f4f3]">
                                <th class="py-3.5 px-6">Limit Category</th>
                                <th class="py-3.5 px-6">Maximum Cap</th>
                                <th class="py-3.5 px-6 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody id="limits-body" class="divide-y divide-[#f2f4f3] text-sm">
                            @forelse($limits ?? [] as $limit)
                            <tr class="hover:bg-[#f8faf9] transition-colors">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-[#191c1c] block">{{ $limit->type }} Limit</span>
                                    <span class="text-xs text-[#53625b]">Monthly Rolling Window</span>
                                </td>
                                <td class="py-4 px-6 font-mono font-bold text-[#191c1c]">
                                    {{ $limit->account_currency . " " . number_format($limit->limit_amount, 2) }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if($limit->status == 0)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                                        </span>
                                    @elseif($limit->status == 1)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span> Approved
                                        </span>
                                    @elseif($limit->status == 2)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-[#53625b]">
                                    <span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-1">lock_open</span>
                                    <p class="text-sm font-semibold text-[#191c1c]">Standard Baseline Limits Active</p>
                                    <p class="text-xs text-[#53625b] mt-0.5">Your account is operating on default tier transfer velocities.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-5 bg-[#f8faf9] border-t border-[#f2f4f3]">
                    <p class="text-xs text-[#53625b] italic leading-relaxed">
                        * Monthly outbound dispatch and withdrawal ceilings automatically refresh on the first business day following your statement cycle.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('input[name="cust_act_number"]').on('change', function() {
        var actNo = $(this).val();
        $.ajax({
            url: "{{ url('get-limits-by-account') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                account_no: actNo
            },
            success: function(res) {
                var data = typeof res === 'string' ? JSON.parse(res) : res;
                var html = '';
                if(data && data.length > 0) {
                    data.forEach(function(item) {
                        var statusBadge = '';
                        if(item.status == 0) {
                            statusBadge = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review</span>';
                        } else if(item.status == 1) {
                            statusBadge = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]"><span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span> Approved</span>';
                        } else {
                            statusBadge = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected</span>';
                        }
                        var formattedAmount = parseFloat(item.limit_amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        html += '<tr class="hover:bg-[#f8faf9] transition-colors">' +
                            '<td class="py-4 px-6"><span class="font-bold text-[#191c1c] block">' + (item.type || 'Transfer') + ' Limit</span><span class="text-xs text-[#53625b]">Monthly Rolling Window</span></td>' +
                            '<td class="py-4 px-6 font-mono font-bold text-[#191c1c]">' + (item.account_currency || '') + ' ' + formattedAmount + '</td>' +
                            '<td class="py-4 px-6 text-right">' + statusBadge + '</td>' +
                            '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="3" class="py-12 text-center text-[#53625b]"><span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-1">lock_open</span><p class="text-sm font-semibold text-[#191c1c]">Standard Baseline Limits Active</p><p class="text-xs text-[#53625b] mt-0.5">Your account is operating on default tier transfer velocities.</p></td></tr>';
                }
                $('#limits-body').html(html);
            }
        });
    });
});
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
