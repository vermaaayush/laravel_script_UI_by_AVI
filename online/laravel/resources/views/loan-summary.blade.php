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
            <span class="text-slate-400">Credit Facilities</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Loan Portfolio</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Loan Facilities & Summary</h1>
                <p class="text-sm text-slate-500 mt-1">Review approved term loans, pending applications, and monthly EMI schedules.</p>
            </div>
            <div>
                <a href="{{ url('request-loan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span> Apply For Loan
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Total Loan Facilities</span>
                <span class="text-2xl font-black text-slate-900 font-mono">{{ count($loans) }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">account_balance</span>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Approved Facilities</span>
                <span class="text-2xl font-black text-emerald-600 font-mono">
                    {{ $loans->where('status', 1)->count() }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">verified</span>
            </div>
        </div>

        <div class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Under Underwriting</span>
                <span class="text-2xl font-black text-amber-600 font-mono">
                    {{ $loans->where('status', 0)->count() }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">hourglass_top</span>
            </div>
        </div>
    </div>

    <!-- Loan List Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">real_estate_agent</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Facilities Ledger</h3>
            </div>
            <span class="text-xs text-slate-400">Applications and active contracts</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Account No</th>
                        <th class="py-3.5 px-6">Facility Amount</th>
                        <th class="py-3.5 px-6">Tenure</th>
                        <th class="py-3.5 px-6">Monthly EMI</th>
                        <th class="py-3.5 px-6 text-right">Approval Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-slate-800">
                            {{ $loan->account_no }}
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-slate-900">
                            {{ $loan->account_currency }} <?php echo number_format($loan->loan_amount, 2); ?>
                        </td>
                        <td class="py-4 px-6 text-slate-700">
                            <span class="font-semibold">{{ $loan->loan_tenure }}</span> Months
                        </td>
                        <td class="py-4 px-6 font-mono text-slate-800">
                            <?php echo number_format($loan->loan_emi, 2); ?> / mo
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($loan->status == 0)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Under Review
                                </span>
                            @elseif($loan->status == 1)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                </span>
                            @elseif($loan->status == 2)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Declined
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">real_estate_agent</span>
                            <p class="text-sm font-semibold text-slate-600">No Active Loans or Applications</p>
                            <p class="text-xs text-slate-400 mt-0.5">You currently do not have any credit applications registered on file.</p>
                            <a href="{{ url('request-loan') }}" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-colors">
                                <span class="material-symbols-outlined text-[16px]">add_circle</span> Apply For Loan
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmPopup" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden p-6 text-center">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[32px]">support_agent</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Loan Underwriting In Progress</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                Your loan request has been routed to our credit underwriting division. A loan officer will reach out within 2 business days.
            </p>
            <button type="button" class="w-full py-3 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider" data-dismiss="modal">
                Acknowledge
            </button>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
