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

<!-- Main Content Wrapper -->
<div class="max-w-xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="text-center">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-[#c59b27] flex items-center justify-center mx-auto mb-3 shadow-2xs">
            <span class="material-symbols-outlined text-3xl">verified_user</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Wire Authorization</h2>
        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
            <?= $confiG->bank_name ?? 'Equitable Bank' ?> Wire Settlement Network. Please complete 2FA verification to release outbound wire funds.
        </p>
    </div>

    <!-- Processing Progress Bar -->
    <div id="progress" class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card text-center space-y-4">
        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Initiating Wire Transmission</span>
        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
            <div id="bar" class="bg-gradient-to-r from-amber-500 to-[#c59b27] h-full rounded-full transition-all duration-[15ms]" style="width: 10%"></div>
        </div>
        <p class="text-[11.5px] text-slate-400">Communicating with interbank clearing engine...</p>
    </div>

    <!-- OTP Form Card -->
    <div id="form-wizard1" style="display:none;" class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card space-y-6">
        <form method="POST" action="{{ asset('success-other-bank-transfer') }}" class="space-y-6">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />
            <input type="hidden" name="tran_id" id="tran_id" value="{{ $tran_id }}" />
            <input type="hidden" name="step" id="step" value="{{ $step }}" />

            <div>
                <label for="otp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider text-center mb-2">Enter OTP Authorization Code</label>
                <div class="max-w-xs mx-auto">
                    <input type="text" name="otp" id="otp" required autofocus placeholder="••••••" class="w-full bg-slate-50 border-2 border-slate-200 focus:border-slate-900 focus:bg-white rounded-2xl py-3.5 px-4 text-center text-2xl font-mono tracking-[0.3em] font-bold text-slate-900 outline-none transition-all shadow-inner">
                </div>
            </div>

            <!-- Warning Notice -->
            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200/80 text-center">
                <span class="text-xs font-bold text-amber-900 block mb-1">Notice</span>
                <p class="text-[11.5px] text-amber-700 leading-relaxed">
                    Entering the wrong OTP more than 3 times will lead to suspension of outbound wire privileges. Please check your registered email or contact your account officer.
                </p>
            </div>

            <!-- Submit -->
            <div class="pt-2 flex flex-col gap-2">
                <button type="submit" name="next" value="Next" class="w-full py-3.5 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                    <span>Confirm & Transmit Wire</span>
                </button>
                <a href="{{ asset('/') }}" class="w-full py-2.5 rounded-xl text-center text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel & Return
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    var otp_verification_form = document.getElementById('form-wizard1');
    var progress = document.getElementById("progress");
    var i = 0;

    window.onload = function move() {
      if (i == 0) {
        i = 1;
        var elem = document.getElementById("bar");
        var width = 10;
        var id = setInterval(frame, 15);
        function frame() {
          if (width >= 100) {
            clearInterval(id);
            i = 0;
            setTimeout(function() {
                if(otp_verification_form) otp_verification_form.style.display = "block";
                if(progress) progress.style.display = "none";
            }, 600);
          } else {
            width++;
            if(elem) elem.style.width = width + "%";
          }
        }
      }
    }
</script>

@include('footer')
