<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-7xl mx-auto w-full pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Overview
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-secondary">Credit Facilities</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Loan Portfolio</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Credit Facilities & Loan Summary</h1>
                <p class="text-sm text-secondary mt-1">Review approved term facilities, pending institutional underwriting, and monthly debt service schedules.</p>
            </div>
            <div>
                <a href="{{ url('request-loan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider rounded-full shadow-md transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span> Apply For Facility
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <?php
        $loanCollection = collect($loans ?? []);
        $totalLoansCount = $loanCollection->count();
        $approvedLoansCount = $loanCollection->where('status', 1)->count();
        $pendingLoansCount = $loanCollection->where('status', 0)->count();
    ?>

    <!-- Metrics Cards (Bento Design) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="p-6 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Total Loan Facilities</span>
                <span class="text-2xl sm:text-3xl font-heading font-bold text-on-surface font-mono">{{ $totalLoansCount }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-surface-container-low border border-outline-variant/20 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">account_balance</span>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Approved Facilities</span>
                <span class="text-2xl sm:text-3xl font-heading font-bold text-primary font-mono">
                    {{ $approvedLoansCount }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-primary-fixed/40 border border-primary/20 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">verified</span>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-secondary uppercase tracking-wider block mb-1">Under Underwriting</span>
                <span class="text-2xl sm:text-3xl font-heading font-bold text-secondary font-mono">
                    {{ $pendingLoansCount }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-surface-container-low border border-outline-variant/20 text-secondary flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">hourglass_top</span>
            </div>
        </div>
    </div>

    <!-- Loan List Card -->
    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-surface-container flex items-center justify-between bg-surface-container-low/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">real_estate_agent</span>
                <h3 class="text-sm font-heading font-bold text-on-surface uppercase tracking-wide">Facilities Ledger</h3>
            </div>
            <span class="text-xs text-secondary">Active commercial loan contracts and underwriting status</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/30 text-secondary text-xs uppercase font-semibold tracking-wider border-b border-surface-container">
                        <th class="py-3.5 px-6">Account No</th>
                        <th class="py-3.5 px-6">Facility Amount</th>
                        <th class="py-3.5 px-6">Tenure</th>
                        <th class="py-3.5 px-6">Monthly EMI</th>
                        <th class="py-3.5 px-6 text-right">Approval Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container text-xs">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-on-surface">
                            {{ $loan->account_no }}
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-on-surface">
                            {{ $loan->account_currency }} <?php echo number_format($loan->loan_amount, 2); ?>
                        </td>
                        <td class="py-4 px-6 text-secondary">
                            <span class="font-semibold text-on-surface">{{ $loan->loan_tenure }}</span> Months
                        </td>
                        <td class="py-4 px-6 font-mono text-on-surface font-semibold">
                            <?php echo number_format($loan->loan_emi, 2); ?> / mo
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($loan->status == 0)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-secondary-container text-on-secondary-container">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Under Review
                                </span>
                            @elseif($loan->status == 1)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-fixed text-primary">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Approved
                                </span>
                            @elseif($loan->status == 2)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-error-container text-error">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Declined
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-secondary">
                            <span class="material-symbols-outlined text-[40px] text-outline block mb-2">real_estate_agent</span>
                            <p class="text-sm font-semibold text-on-surface">No Active Loans or Applications</p>
                            <p class="text-xs text-secondary mt-0.5">You currently do not have any credit applications registered on file.</p>
                            <a href="{{ url('request-loan') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider rounded-full transition-colors shadow-sm">
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

@include('footer')
