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
            <span class="text-slate-400">System Config</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Alert Preferences</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Transaction Alert Channels</h1>
        <p class="text-sm text-slate-500 mt-1">Configure your real-time notification dispatch preferences for ledger movements.</p>
    </div>

    @include('flash::message')

    <!-- Main Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-6 border-b border-slate-100 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center border border-emerald-100">
                <span class="material-symbols-outlined text-[24px]">notifications_active</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Institutional Notification Routing</h3>
                <p class="text-xs text-slate-500">Ensure prompt notification whenever credits, debits, or authorization challenges occur.</p>
            </div>
        </div>

        <form role="form" method="POST" action="{{ asset('update-transaction-alert') }}" class="space-y-6">
            @csrf
            
            <div class="flex items-center justify-between p-5 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <div class="pr-4">
                    <h3 class="text-sm font-bold text-slate-900">Email Notification Feed</h3>
                    <p class="text-xs text-slate-500 mt-1">Dispatches cryptographic receipts and transaction digests directly to your registered primary email.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" class="sr-only peer" name="email_notification" id="email_notification" value="1" <?php if(isset($option[0]) && isset($option[0]->step2_send_via_email) && $option[0]->step2_send_via_email == 1) { ?> checked <?php } ?>>
                    <div class="w-12 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#004226]"></div>
                </label>
            </div>

            <div class="flex items-center justify-between p-5 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <div class="pr-4">
                    <h3 class="text-sm font-bold text-slate-900">SMS Direct Telemetry</h3>
                    <p class="text-xs text-slate-500 mt-1">Receives high-priority cellular alerts and one-time verification tokens on your authenticated mobile number.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" class="sr-only peer" name="sms_notification" id="sms_notification" value="1" <?php if(isset($option[0]) && isset($option[0]->step2_send_via_sms) && $option[0]->step2_send_via_sms == 1) { ?> checked <?php } ?>>
                    <div class="w-12 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#004226]"></div>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('/online') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Save Preferences</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
