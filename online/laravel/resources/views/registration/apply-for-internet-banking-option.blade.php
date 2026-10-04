@extends('layouts.stack')

@section('content')
  <!-- Main Onboarding Container (Stitch Screen 3 Visual Language) -->
  <div class="min-h-screen bg-background flex flex-col justify-between p-4 sm:p-6 lg:p-8">
    <div class="max-w-5xl mx-auto w-full space-y-6">
      
      <!-- Top Institutional Header -->
      <header class="flex flex-col sm:flex-row items-center justify-between bg-surface-container-lowest px-6 py-4 rounded-2xl shadow-sm border border-outline-variant/30 gap-4">
        <div class="flex items-center gap-4">
          <a href="{{ url('/') }}" class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-primary text-on-primary flex items-center justify-center">
              <span class="material-symbols-outlined text-[20px]">account_balance</span>
            </div>
            <div>
              <span class="font-heading font-extrabold text-base text-on-surface block leading-tight">{{ $bankName ?? 'OripioFin' }}</span>
              <span class="text-[10px] tracking-wider uppercase text-secondary font-medium block">Institutional Banking</span>
            </div>
          </a>
          <div class="hidden sm:block h-6 w-px bg-outline-variant/30"></div>
          <div class="hidden sm:flex items-center gap-2">
            <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            <span class="text-xs font-semibold text-on-surface">Client Onboarding & Identity Clearance</span>
            <span class="px-2 py-0.5 rounded-full bg-surface-container text-secondary text-[10px] uppercase font-bold tracking-wider">FATCA / CRS Tier 1</span>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <a href="{{ url('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Sign In</span>
          </a>
        </div>
      </header>

      <!-- Stepper Preview Card -->
      <div class="w-full bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
          <!-- Step 1: Active -->
          <div class="flex items-center gap-3 p-3 rounded-xl bg-primary-container text-on-primary shadow-xs">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-on-primary text-primary font-bold text-xs shrink-0">
              01
            </div>
            <div class="min-w-0">
              <span class="text-[10px] uppercase font-bold text-primary-fixed tracking-wider block">Step 01</span>
              <p class="font-heading font-semibold text-xs text-on-primary truncate">Overview & Requirements</p>
            </div>
          </div>
          <!-- Step 2 -->
          <div class="flex items-center gap-3 p-3 rounded-xl bg-surface-container-low opacity-60">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-surface-container-highest text-secondary font-semibold text-xs shrink-0">
              02
            </div>
            <div class="min-w-0">
              <span class="text-[10px] uppercase font-bold text-secondary tracking-wider block">Step 02</span>
              <p class="font-heading font-semibold text-xs text-on-surface truncate">Account Credentials</p>
            </div>
          </div>
          <!-- Step 3 -->
          <div class="flex items-center gap-3 p-3 rounded-xl bg-surface-container-low opacity-60">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-surface-container-highest text-secondary font-semibold text-xs shrink-0">
              03
            </div>
            <div class="min-w-0">
              <span class="text-[10px] uppercase font-bold text-secondary tracking-wider block">Step 03</span>
              <p class="font-heading font-semibold text-xs text-on-surface truncate">Security Questions</p>
            </div>
          </div>
          <!-- Step 4 -->
          <div class="flex items-center gap-3 p-3 rounded-xl bg-surface-container-low opacity-60">
            <div class="flex items-center justify-center w-7 h-7 rounded-full bg-surface-container-highest text-secondary font-semibold text-xs shrink-0">
              04
            </div>
            <div class="min-w-0">
              <span class="text-[10px] uppercase font-bold text-secondary tracking-wider block">Step 04</span>
              <p class="font-heading font-semibold text-xs text-on-surface truncate">Verification & Sign-off</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Institutional Content Card -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Requirements & Instructions (Col 8) -->
        <div class="lg:col-span-8 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6 sm:p-8">
          <div class="mb-6 pb-6 border-b border-outline-variant/20">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider mb-3">
              <span class="material-symbols-outlined text-[15px]">badge</span>
              <span>Online Banking Enrollment</span>
            </div>
            <h1 class="font-heading font-bold text-2xl text-on-surface tracking-tight mb-2">
              Enroll for Institutional Online Banking
            </h1>
            <p class="text-sm text-secondary leading-relaxed">
              Registering for digital custody and treasury servicing takes only a few minutes. Please ensure you have your account credentials ready before beginning.
            </p>
          </div>

          <div class="space-y-4">
            <h3 class="font-heading font-semibold text-sm text-on-surface">Required Credentials:</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20 flex items-start gap-3">
                <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">person</span>
                <div>
                  <p class="text-xs font-bold text-on-surface">Personal Information</p>
                  <p class="text-[11px] text-secondary">Verified full name, date of birth, and primary domicile address</p>
                </div>
              </div>
              <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/20 flex items-start gap-3">
                <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">credit_card</span>
                <div>
                  <p class="text-xs font-bold text-on-surface">Account or Card Details</p>
                  <p class="text-[11px] text-secondary">Your existing 10-digit account number or active debit card number</p>
                </div>
              </div>
            </div>

            <div class="p-4 rounded-xl bg-surface-container-low/70 border border-outline-variant/20 text-xs text-secondary space-y-2 mt-4">
              <div class="flex items-center gap-2 text-on-surface font-semibold">
                <span class="material-symbols-outlined text-primary text-[18px]">verified_user</span>
                <span>Security Protocol & Activation</span>
              </div>
              <p class="leading-relaxed">
                During this workflow, you will configure a confidential username, password, and multi-tier security questions. Upon successful submission, an activation confirmation code will be dispatched to your registered address and phone.
              </p>
            </div>

            <div class="pt-6">
              <a href="{{ url('new-account-steps') }}" 
                 class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-primary hover:bg-primary-container text-on-primary font-heading font-bold text-sm tracking-wide shadow-md transition-all">
                <span>Begin Account Setup</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Right: Self-Service Directory (Col 4) -->
        <div class="lg:col-span-4 space-y-4">
          <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
            <h3 class="font-heading font-bold text-sm text-on-surface mb-1">Registration Directory</h3>
            <p class="text-xs text-secondary mb-4">Select an alternate onboarding channel:</p>

            <div class="space-y-2.5">
              <a href="{{ url('online-open-account') }}" 
                 class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold transition-colors group">
                <div class="flex items-center gap-2.5">
                  <span class="material-symbols-outlined text-primary text-[18px]">account_circle</span>
                  <span>Apply for Account Opening</span>
                </div>
                <span class="material-symbols-outlined text-secondary text-[16px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
              </a>

              <a href="{{ url('register-new-internet-account') }}" 
                 class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold transition-colors group">
                <div class="flex items-center gap-2.5">
                  <span class="material-symbols-outlined text-primary text-[18px]">devices</span>
                  <span>Internet Banking Access</span>
                </div>
                <span class="material-symbols-outlined text-secondary text-[16px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
              </a>

              <a href="{{ url('retrieve-account-pin') }}" 
                 class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold transition-colors group">
                <div class="flex items-center gap-2.5">
                  <span class="material-symbols-outlined text-primary text-[18px]">pin</span>
                  <span>Retrieve Account PIN</span>
                </div>
                <span class="material-symbols-outlined text-secondary text-[16px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
              </a>

              <a href="{{ url('retrieve-account-user-id') }}" 
                 class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface text-xs font-semibold transition-colors group">
                <div class="flex items-center gap-2.5">
                  <span class="material-symbols-outlined text-primary text-[18px]">badge</span>
                  <span>Retrieve User ID</span>
                </div>
                <span class="material-symbols-outlined text-secondary text-[16px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
              </a>
            </div>
          </div>

          <!-- Institutional Security Badge -->
          <div class="p-5 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex items-start gap-3">
            <span class="material-symbols-outlined text-primary text-[22px] mt-0.5">encrypted</span>
            <div class="text-xs">
              <p class="font-bold text-on-surface">FINMA & SOC2 Certified</p>
              <p class="text-secondary mt-0.5 leading-relaxed">
                All client registration data is encrypted in transit and at rest using FIPS 140-2 Level 3 hardware modules.
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Bottom Footer -->
    <footer class="mt-8 text-center text-xs text-secondary">
      <p>© <?= date('Y') ?> {{ $bankName ?? 'OripioFin' }}. All rights reserved. Sovereign Wealth & Custody Services.</p>
    </footer>
  </div>

  <script type="text/javascript">
    $('#username,#password').keyboard({openOn : null });

    $('.username').click(function(){
      var kb = $('#username').getkeyboard();
      if (kb) kb.reveal();
    });
    $('.password').click(function(){
      var kb = $('#password').getkeyboard();
      if (kb) kb.reveal();
    });
  </script>
@endsection
