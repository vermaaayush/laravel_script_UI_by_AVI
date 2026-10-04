<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-2xl mx-auto w-full pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Overview
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('view-cards') }}">Cards</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Update PIN</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Update Card PIN</h1>
        <p class="text-sm text-secondary mt-1">Change your 4-digit ATM and point-of-sale security PIN securely with HSM tokenization.</p>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 sm:p-8">
        <form id="form-wizard1" method="POST" action="{{ asset('update-card-pin-db') }}" class="space-y-6">
            @csrf

            <!-- Account & Card Selection -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="account" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Select Account <span class="text-error">*</span></label>
                    <div class="relative">
                        <select name="account" id="account" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-mono font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Account --</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->account_no }}">{{ $account->account_no }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                    </div>
                </div>

                <div>
                    <label for="card" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Card Number <span class="text-error">*</span></label>
                    <div class="relative">
                        <select name="card" id="card" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-mono font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Account First --</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                    </div>
                </div>
            </div>

            <!-- PIN Fields -->
            <div class="pt-4 border-t border-surface-container">
                <h4 class="text-xs font-bold text-secondary uppercase tracking-wider mb-4">Security PIN Credentials</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="old_pin" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Current PIN <span class="text-error">*</span></label>
                        <input type="password" name="old_pin" id="old_pin" required maxlength="6" placeholder="••••" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-center text-lg font-mono font-bold tracking-widest text-on-surface focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>

                    <div>
                        <label for="new_pin" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">New PIN <span class="text-error">*</span></label>
                        <input type="password" name="new_pin" id="new_pin" required maxlength="6" placeholder="••••" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-center text-lg font-mono font-bold tracking-widest text-on-surface focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>

                    <div>
                        <label for="confirm_new_pin" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Confirm PIN <span class="text-error">*</span></label>
                        <input type="password" name="confirm_new_pin" id="confirm_new_pin" required maxlength="6" placeholder="••••" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-center text-lg font-mono font-bold tracking-widest text-on-surface focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Notice -->
            <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/20 flex items-start gap-3">
                <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">lock</span>
                <p class="text-xs text-secondary leading-relaxed">
                    Never disclose your PIN to anyone, including bank representatives. For institutional security, avoid consecutive numbers or birthdates.
                </p>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-surface-container flex items-center justify-end gap-3">
                <a href="{{ url('view-cards') }}" class="px-5 py-3 rounded-full border border-outline-variant/30 bg-surface-container-lowest hover:bg-surface-container text-secondary text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" name="next" value="Next" class="px-7 py-3 rounded-full bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider shadow-md transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">lock_reset</span> Update PIN
                </button>
            </div>
        </form>
    </div>
</div>

@include('footer')
