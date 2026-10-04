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

<!-- Page Content (Stitch Sovereign Theme) -->
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors" href="{{ url('transfer-to-other-bank') }}">Transfers</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface">Wire Security Clearance</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">External Wire Verification</h1>
        <p class="text-sm text-secondary mt-1">Real-time interbank clearance validation and cryptographic multi-factor authorization.</p>
    </div>

    @if($step==4)    
        @if($token[0]['allow_code_1']==1)
            <script>
                const loadingTexts = [
                    "ESTABLISHING SECURE PROTOCOL...",
                    "VERIFYING BENEFICIARY CLEARING DETAILS",
                    "CLEARING NETWORK CONFIRMED",
                    "PORTAL CONNECTION SYNCHRONIZED",
                    "INITIATING WIRE DISPATCH",
                    "15% OF SETTLEMENT COMPLETED",
                    "38% OF SETTLEMENT COMPLETED",
                    "60% OF SETTLEMENT COMPLETED"
                ];
            </script>
        @endif
    @elseif($step==5)    
        @if($token[0]['allow_code_2']==1)
            <script>
                const loadingTexts = [
                    "AWAITING REGULATORY CLEARANCE...",
                    "65% OF SETTLEMENT COMPLETED",
                    "70% OF SETTLEMENT COMPLETED",
                    "75% OF SETTLEMENT COMPLETED"
                ];
            </script>
        @endif
    @elseif($step==6)    
        @if($token[0]['allow_code_3']==1)
            <script>
                const loadingTexts = [
                    "FINAL DISPATCH STAGE INITIATED...",
                    "80% OF SETTLEMENT COMPLETED",
                    "90% OF SETTLEMENT COMPLETED",
                    "95% OF SETTLEMENT COMPLETED"
                ];
            </script>
        @endif
    @endif    

    <!-- Section A: Processing Animation -->
    <div id="sectionA" class="py-12">
        <div class="bg-surface-container-lowest rounded-3xl shadow-xl border border-outline-variant/30 p-8 sm:p-12 text-center max-w-lg mx-auto">
            <div class="relative w-20 h-20 mx-auto mb-6 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-surface-container"></div>
                <div class="absolute inset-0 rounded-full border-4 border-primary border-t-transparent animate-spin"></div>
                <span class="material-symbols-outlined text-primary text-3xl">currency_exchange</span>
            </div>

            <h3 class="text-lg font-heading font-bold text-on-surface mb-2">Interbank Settlement in Progress</h3>
            <p id="animate_text" class="text-xs font-mono font-bold text-primary tracking-wider uppercase min-h-[20px]"></p>
            
            <div class="mt-6 p-4 rounded-xl bg-surface-container-low border border-outline-variant/20 text-left">
                <div class="flex items-center gap-2 text-secondary text-xs mb-1">
                    <span class="material-symbols-outlined text-[16px] text-primary">lock</span>
                    <span class="font-semibold text-on-surface">Encrypted Communication Pipeline</span>
                </div>
                <p class="text-[11px] text-secondary">Do not refresh or leave this window while your transaction data is synchronizing with central settlement.</p>
            </div>
        </div>
    </div>

    <!-- Section B: OTP Verification Form -->
    <div id="sectionB" style="display:none">
        <div class="bg-surface-container-lowest rounded-3xl shadow-xl border border-outline-variant/30 overflow-hidden">
            <div class="p-6 border-b border-surface-container flex items-center justify-between bg-surface-container-low/50">
                <div>
                    <h2 class="text-lg font-heading font-bold text-on-surface">Security Authorization Required</h2>
                    <p class="text-xs text-secondary mt-0.5">External wire dispatch for transaction #{{ $tran_id }}</p>
                </div>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                    Step {{ $step - 3 }} of 3
                </span>
            </div>

            <div class="p-6 sm:p-8">
                <form id="form-wizard1" method="POST" action="{{ asset('success-other-bank-transfer') }}">
                    <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />
                    <input type="hidden" name="tran_id" id="tran_id" value="{{ $tran_id }}" />
                    <input type="hidden" name="step" id="step" value="{{$step}}" />
                    
                    <fieldset>
                        <div class="max-w-md mx-auto text-center">
                            @if($step==4 && isset($token[0]) && $token[0]['allow_code_1']==1)
                                <div class="mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-3">
                                        <span class="material-symbols-outlined text-2xl">key</span>
                                    </div>
                                    <h3 class="text-base font-heading font-bold text-on-surface mb-1">Enter {{ $token[0]['code_name_1'] }}</h3>
                                    <p class="text-xs text-secondary">Please provide your authorized {{ $token[0]['code_name_1'] }} token to continue.</p>
                                </div>
                                <div class="mb-6">
                                    <input type="text" class="w-full h-12 rounded-xl border border-outline-variant/30 bg-surface-container-low font-mono text-center text-lg font-bold tracking-widest text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" name="otp" id="otp" required placeholder="••••••••" autocomplete="off" />
                                </div>
                            @elseif($step==5 && isset($token[0]) && $token[0]['allow_code_2']==1)
                                <div class="mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-3">
                                        <span class="material-symbols-outlined text-2xl">security</span>
                                    </div>
                                    <h3 class="text-base font-heading font-bold text-on-surface mb-1">Enter {{ $token[0]['code_name_2'] }}</h3>
                                    <p class="text-xs text-secondary">Please provide your designated {{ $token[0]['code_name_2'] }} token to validate dispatch.</p>
                                </div>
                                <div class="mb-6">
                                    <input type="text" class="w-full h-12 rounded-xl border border-outline-variant/30 bg-surface-container-low font-mono text-center text-lg font-bold tracking-widest text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" name="otp" id="otp" required placeholder="••••••••" autocomplete="off" />
                                </div>
                            @elseif($step==6 && isset($token[0]) && $token[0]['allow_code_3']==1)
                                <div class="mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-3">
                                        <span class="material-symbols-outlined text-2xl">verified_user</span>
                                    </div>
                                    <h3 class="text-base font-heading font-bold text-on-surface mb-1">Enter {{ $token[0]['code_name_3'] }}</h3>
                                    <p class="text-xs text-secondary">Final clearance authorization token required for funds dispatch.</p>
                                </div>
                                <div class="mb-6">
                                    <input type="text" class="w-full h-12 rounded-xl border border-outline-variant/30 bg-surface-container-low font-mono text-center text-lg font-bold tracking-widest text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" name="otp" id="otp" required placeholder="••••••••" autocomplete="off" />
                                </div>
                            @endif    

                            <button type="submit" name="next" class="w-full py-3.5 px-6 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold shadow-md transition-all flex items-center justify-center gap-2" value="Next">
                                <span>Verify & Continue Settlement</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </button>

                            <p class="text-[11px] text-secondary mt-4 leading-relaxed">
                                Entering an incorrect security code more than 3 times will trigger protective account lock. If you need assistance obtaining your code, contact your private account officer.
                            </p>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const animate_text = document.getElementById('animate_text');
    const sectionA = document.getElementById('sectionA');
    const sectionB = document.getElementById('sectionB');

    function updateLoadingText(index) {
        if (typeof loadingTexts !== 'undefined' && loadingTexts[index]) {
            animate_text.textContent = loadingTexts[index];
        }
    }

    function updateTextSequentially(index) {
        if (typeof loadingTexts !== 'undefined') {
            updateLoadingText(index);
            setTimeout(() => {
                if (index < loadingTexts.length - 1) {
                    updateTextSequentially(index + 1);
                } else {
                    sectionB.style.display = "block";
                    sectionA.style.display = "none";
                }
            }, 1000);
        } else {
            sectionB.style.display = "block";
            sectionA.style.display = "none";
        }
    }

    // Start the animation
    setTimeout(() => {
        updateTextSequentially(0);
    }, 1500);
</script>

@include('footer')
