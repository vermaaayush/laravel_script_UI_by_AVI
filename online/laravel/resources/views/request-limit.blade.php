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
<div class="max-w-3xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('view-limits') }}">Account Limits</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Request Increase</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Request Limit Adjustment</h1>
                <p class="text-sm text-slate-500 mt-1">Apply to elevate daily or monthly transfer velocity limits on your account.</p>
            </div>
            <div>
                <a href="{{ url('view-limits') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">tune</span> View Current Limits
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form class="needs-validation space-y-6" novalidate="" role="form" method="POST" action="{{ asset('insert-limit-request') }}">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Account Select -->
                <div>
                    <label for="account_no" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Select Account <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="account_no" id="account_no" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Account --</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->account_no }}">{{ $account->account_no }} ({{ $account->account_type }})</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <!-- Limit Type -->
                <div>
                    <label for="type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Facility Limit Type <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="type" id="type" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="Transfer">Outbound Transfer Limit</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <!-- Limit Amount -->
                <div class="sm:col-span-2">
                    <label for="limit_amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Desired Monthly Ceiling <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-mono font-bold">$</span>
                        <input type="text" name="limit_amount" id="limit_amount" required placeholder="50,000.00" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl py-3.5 pl-9 pr-4 text-base font-mono font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all decimal-num">
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Adjustments are subject to compliance assessment and account tier classification.</p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-start gap-2.5 text-xs text-slate-500 leading-relaxed">
                <span class="material-symbols-outlined text-[18px] text-slate-400 shrink-0 mt-0.5">verified_user</span>
                <span>
                    To maintain rigorous defense against fraudulent exploitation, higher volume ceilings require one-time approval from risk operations.
                </span>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('view-limits') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span> Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
