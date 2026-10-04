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
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors flex items-center gap-1" href="{{ url('/') }}">
                <span class="material-symbols-outlined text-[14px]">home</span> Portal
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-[#004226] transition-colors" href="{{ url('view-limits') }}">Account Limits</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Request Adjustment</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Request Limit Adjustment</h1>
                <p class="text-sm text-[#53625b] mt-1">Submit an official application to modify outbound transactional velocity ceilings.</p>
            </div>
            <div>
                <a href="{{ url('view-limits') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#f2f4f3] hover:bg-[#e6e9e8] text-[#191c1c] text-xs font-bold transition-all">
                    <span class="material-symbols-outlined text-[16px]">tune</span>
                    <span>View Active Limits</span>
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm p-6 sm:p-8">
        <form class="needs-validation space-y-6" novalidate="" role="form" method="POST" action="{{ asset('insert-limit-request') }}">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Account Select -->
                <div>
                    <label for="account_no" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Target Custody Account <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="account_no" id="account_no" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-sm text-[#191c1c] font-mono font-bold outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Account --</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->account_no }}">{{ $account->account_no }} ({{ $account->account_type }})</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#53625b]">expand_more</span>
                    </div>
                </div>

                <!-- Limit Type -->
                <div>
                    <label for="type" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Facility Limit Type <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="type" id="type" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-sm text-[#191c1c] font-semibold outline-none transition-all appearance-none cursor-pointer">
                            <option value="Transfer">Outbound Transfer Settlement Cap</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#53625b]">expand_more</span>
                    </div>
                </div>

                <!-- Limit Amount -->
                <div class="sm:col-span-2">
                    <label for="limit_amount" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Requested Monthly Ceiling <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#53625b] font-mono font-bold">{{ Session::get('account_currency') ?? '$' }}</span>
                        <input type="text" name="limit_amount" id="limit_amount" required placeholder="50,000.00" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3.5 pl-10 pr-4 text-base font-mono font-bold text-[#191c1c] outline-none transition-all decimal-num">
                    </div>
                    <p class="text-[11px] text-[#53625b] mt-1.5">Adjustments are evaluated under Tier-1 financial compliance and risk mitigation guidelines.</p>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-[#f8faf9] border border-[#e6e9e8] flex items-start gap-3 text-xs text-[#53625b] leading-relaxed">
                <span class="material-symbols-outlined text-[18px] text-[#004226] shrink-0 mt-0.5">verified_user</span>
                <span>
                    To maintain strict institutional safeguards against unauthorized capital movements, elevated limits undergo dual-custody verification by compliance operations prior to activation.
                </span>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-[#f2f4f3] flex items-center justify-end gap-3">
                <a href="{{ url('view-limits') }}" class="px-5 py-3 rounded-xl border border-[#e6e9e8] bg-white hover:bg-[#f8faf9] text-[#53625b] text-xs font-bold transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">send</span>
                    <span>Submit Adjustment Request</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
