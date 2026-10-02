<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>

<!-- Main Content Wrapper -->
<div class="max-w-2xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('manage-beneficiaries') }}">Manage Beneficiaries</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">2FA Authorization</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Beneficiary Authorization</h1>
        <p class="text-sm text-slate-500 mt-1">Please enter the security verification token sent to your registered email.</p>
    </div>

    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-10 relative overflow-hidden">
        <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60 mb-6 flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Beneficiary Target</span>
                <span class="text-sm font-bold text-slate-900">
                    @if($Ba_beneficiary->bank_type == 1)
                        <?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> Internal Transfer
                    @else
                        External Wire Transfer (Foreign Clearing)
                    @endif
                </span>
            </div>
            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200/60 rounded-lg text-xs font-bold uppercase tracking-wider">
                Pending Token
            </span>
        </div>

        <form action="{{ asset('code-verification') }}" method="post" class="space-y-6">
            @csrf
            <input type="hidden" name="id" value="{{$Ba_beneficiary->id}}">

            <div class="text-center max-w-sm mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 border border-primary/20 text-primary flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[32px]">mark_email_read</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Enter Email Security Code</h3>
                <p class="text-xs text-slate-500 mt-1">A one-time authorization token was dispatched to your email address to confirm this new recipient.</p>
            </div>

            <!-- OTP Input -->
            <div class="max-w-xs mx-auto">
                <input type="text" id="verification_code" name="verification_code" value="" placeholder="• • • • • •" required autofocus class="w-full bg-slate-50 border border-slate-300 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-2xl py-3.5 px-4 text-center font-mono font-black text-2xl tracking-[0.3em] text-slate-900 outline-none transition-all shadow-inner">
            </div>

            <div class="flex items-center justify-center">
                <button type="submit" name="next" value="Next" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                    <span>Verify & Authorize</span>
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                </button>
            </div>

            <!-- Security Warning Banner -->
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-center">
                <div class="flex items-center justify-center gap-1.5 text-amber-800 text-xs font-bold mb-1">
                    <span class="material-symbols-outlined text-[16px] text-amber-600">shield</span> Security Safeguard Notice
                </div>
                <p class="text-[11px] text-amber-700 leading-relaxed">
                    Entering an invalid OTP more than 3 consecutive times triggers automatic temporary suspension for fraud prevention. If you did not receive a code, contact your private account officer.
                </p>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
