<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- //  Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">System Config</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Credential Security</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Account PIN Update</h1>
                <p class="text-sm text-[#53625b] mt-1">Cryptographically re-key your master account authorization PIN with dual-factor verification.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4] text-xs font-bold">
                <span class="material-symbols-outlined text-[16px]">lock</span>
                <span>HSM Hardware Keyed</span>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] mb-8 overflow-hidden">
        
        <!-- Stepper Indicator -->
        <div class="p-6 border-b border-[#f2f4f3] bg-[#f8faf9]">
            <div class="grid grid-cols-3 gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#004226] text-white flex items-center justify-center font-bold text-xs">1</div>
                    <div class="hidden sm:block">
                        <p class="text-[11px] font-bold text-[#191c1c]">Identity</p>
                        <p class="text-[10px] text-[#53625b]">Verify UID</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#e6e9e8] text-[#53625b] flex items-center justify-center font-bold text-xs">2</div>
                    <div class="hidden sm:block">
                        <p class="text-[11px] font-bold text-[#53625b]">New PIN</p>
                        <p class="text-[10px] text-[#53625b]">Set 4-6 Digits</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[#e6e9e8] text-[#53625b] flex items-center justify-center font-bold text-xs">3</div>
                    <div class="hidden sm:block">
                        <p class="text-[11px] font-bold text-[#53625b]">Authorize</p>
                        <p class="text-[10px] text-[#53625b]">OTP Verification</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold mb-6 flex items-center gap-2" id="passwordUpdateError" style="display:none;"></div>
            
            <form id="form-wizard1" class="password-update-form">
                <!-- Step 1: User ID -->
                <fieldset id="pin_step_1" class="text-left">
                    <div class="max-w-md mx-auto py-4">
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Master Client User ID</label>
                            <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-mono font-bold text-[#191c1c] outline-none transition-all" name="user_id" id="user_id" required value="{{ Session::get('user_id') ?? ($customer[0]->user_id ?? '') }}" placeholder="Enter UID" />
                            <p class="text-[11px] text-[#53625b] mt-1.5">Enter your sovereign account user identification number to confirm identity ownership.</p>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="button" id="firstForm" name="next" class="w-full sm:w-auto bg-[#004226] hover:bg-[#0f5b38] text-white font-bold py-3 px-8 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                                <span>Continue to PIN Setup</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </fieldset>

                <!-- Step 2: New PIN -->
                <fieldset id="pin_step_2" class="text-left" style="display: none;">
                    <div class="max-w-md mx-auto py-4">
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">New Account PIN (4-6 Digits)</label>
                            <input type="password" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-base font-mono tracking-widest text-[#191c1c] outline-none transition-all placeholder-[#53625b]/40" name="pin" id="pin" required value="" placeholder="••••" maxlength="6" />
                        </div>
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Confirm New Account PIN</label>
                            <input type="password" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-base font-mono tracking-widest text-[#191c1c] outline-none transition-all placeholder-[#53625b]/40" name="confirm_pin" id="confirm_pin" required value="" placeholder="••••" maxlength="6" />
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="button" id="secondForm" name="next" class="w-full sm:w-auto bg-[#004226] hover:bg-[#0f5b38] text-white font-bold py-3 px-8 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                                <span>Generate Dual-Factor OTP</span>
                                <span class="material-symbols-outlined text-[16px]">key</span>
                            </button>
                        </div>
                    </div>
                </fieldset>

                <!-- Step 3: OTP -->
                <fieldset id="pin_step_3" class="text-left" style="display: none;">
                    <div class="max-w-md mx-auto py-4 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-[#e8f7ee] border border-[#aaf2c4] text-[#004226] flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-[28px]">mark_email_read</span>
                        </div>
                        <h3 class="text-lg font-bold font-headline text-[#191c1c] mb-1">Enter Security Token</h3>
                        <p class="text-xs text-[#53625b] mb-6">A one-time hardware authorization OTP has been generated for your account. Please enter it below to confirm re-keying.</p>
                        
                        <div class="mb-6 text-left">
                            <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Cryptographic Token (OTP)</label>
                            <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-lg font-mono tracking-widest text-center text-[#191c1c] outline-none transition-all placeholder-[#53625b]/40" name="otp" id="otp" required value="" placeholder="• • • • • •" autocomplete="one-time-code">
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" id="thirdForm" name="next" class="w-full bg-[#004226] hover:bg-[#0f5b38] text-white font-bold py-3 px-8 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                                <span>Commit & Encrypt PIN</span>
                            </button>
                        </div>
                        <div class="mt-6 p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8] text-left">
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[18px] text-[#53625b] shrink-0 mt-0.5">info</span>
                                <p class="text-[11px] text-[#53625b] leading-relaxed">Entering an incorrect verification OTP exceeding 3 attempts will lock electronic transactions for 24 hours. If you require assistance, consult your dedicated relationship concierge.</p>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <!-- Step 4: Success -->
                <fieldset id="pin_step_4" class="text-center" style="display: none;">
                    <div class="py-12 flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-[#e8f7ee] border-2 border-[#aaf2c4] text-[#004226] flex items-center justify-center mb-5">
                            <span class="material-symbols-outlined text-[42px]">check_circle</span>
                        </div>
                        <h2 class="text-xl font-bold font-headline text-[#191c1c] mb-2">PIN Updated Successfully</h2>
                        <p class="text-sm text-[#53625b] max-w-md mx-auto mb-6">Your sovereign account authorization PIN has been cryptographically updated and synchronized with the banking core.</p>
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">dashboard</span>
                            <span>Return to Client Portal</span>
                        </a>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
      
<!-- footer -->
@include('footer')
<!-- // footer -->
