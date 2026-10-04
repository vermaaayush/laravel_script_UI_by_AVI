<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-xl mx-auto w-full space-y-6 pb-12 font-sans">
    <!-- Header -->
    <div class="text-center">
        <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-3 shadow-sm border border-primary/20">
            <span class="material-symbols-outlined text-3xl">verified_user</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Security Authorization</h1>
        <p class="text-xs text-secondary mt-1 max-w-sm mx-auto">
            A one-time cryptographic authorization code has been dispatched to your registered credentials for transfer authorization.
        </p>
    </div>

    <!-- OTP Card -->
    <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 border border-outline-variant/30 shadow-xl">
        <form id="form-wizard1" method="POST" action="{{ asset('success-same-bank-transfer') }}" class="space-y-6">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />
            <input type="hidden" name="tran_id" id="tran_id" value="{{ $tran_id }}" />
            <input type="hidden" name="step" id="step" value="{{ $step }}" />

            <div>
                <label for="otp" class="block text-xs font-bold text-secondary uppercase tracking-wider text-center mb-2">Enter One-Time Security Passcode (OTP)</label>
                <div class="max-w-xs mx-auto">
                    <input type="text" name="otp" id="otp" required autofocus placeholder="••••••" class="w-full bg-surface-container-low border border-outline-variant/30 focus:border-primary focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 rounded-2xl py-3.5 px-4 text-center text-2xl font-mono tracking-[0.3em] font-bold text-on-surface outline-none transition-all shadow-inner">
                </div>
            </div>

            <!-- Warning Notice -->
            <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant/20 text-center">
                <span class="text-xs font-bold text-on-surface block mb-1">Security Notice</span>
                <p class="text-[11.5px] text-secondary leading-relaxed">
                    Entering an invalid OTP multiple times will temporarily freeze outbound liquidity transfers. If you require assistance, please contact your private banking desk.
                </p>
            </div>

            <!-- Submit -->
            <div class="pt-2 flex flex-col gap-2.5">
                <button type="submit" name="next" value="Next" class="w-full py-3.5 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">lock_open</span>
                    <span>Verify & Release Funds</span>
                </button>
                <a href="{{ asset('/') }}" class="w-full py-2.5 rounded-xl text-center text-xs font-semibold text-secondary hover:text-on-surface transition-colors">
                    Cancel Transfer
                </a>
            </div>
        </form>
    </div>
</div>

@include('footer')
