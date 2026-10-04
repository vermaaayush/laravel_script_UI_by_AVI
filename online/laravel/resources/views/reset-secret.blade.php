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
            <span class="text-primary font-bold">Reset Secret</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Security Question Settings</h1>
        <p class="text-sm text-slate-500 mt-1">Configure your primary and secondary authentication security challenges.</p>
    </div>

    @include('flash::message')

    <!-- Main Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-6 border-b border-slate-100 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center border border-emerald-100">
                <span class="material-symbols-outlined text-[24px]">verified_user</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Security Challenge Validation</h3>
                <p class="text-xs text-slate-500">These responses are utilized when authorizing unprompted sessions or self-service credential recovery.</p>
            </div>
        </div>

        <form role="form" method="POST" action="{{ asset('update-secret') }}" class="space-y-6">
            @csrf
            
            <div class="p-5 bg-slate-50/70 rounded-2xl border border-slate-200/80 space-y-3">
                <div class="flex items-center gap-2 text-slate-700 text-xs font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[18px] text-emerald-800">help</span>
                    <span>Primary Challenge Question</span>
                </div>
                <p class="text-sm font-bold text-slate-900">{{ $customer[0]->qid }}</p>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Your Recorded Answer <span class="text-rose-500">*</span></label>
                    <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="ans" id="ans" required value="{{ $customer[0]->ans }}">
                </div>
            </div>
            
            <div class="p-5 bg-slate-50/70 rounded-2xl border border-slate-200/80 space-y-3">
                <div class="flex items-center gap-2 text-slate-700 text-xs font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[18px] text-emerald-800">quiz</span>
                    <span>Secondary Challenge Question</span>
                </div>
                <p class="text-sm font-bold text-slate-900">{{ $customer[0]->qid2 }}</p>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Your Recorded Answer <span class="text-rose-500">*</span></label>
                    <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="ans2" id="ans2" required value="{{ $customer[0]->ans2 }}">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('/online') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Update Security Details</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
