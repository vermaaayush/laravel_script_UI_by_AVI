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
            <span class="text-secondary">Cheques</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Request Cheque Book</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Request Cheque Book</h1>
        <p class="text-sm text-secondary mt-1">Order an embossed cheque booklet dispatched securely to your registered domicile address.</p>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ asset('insert-cheque-book-request') }}" class="space-y-6">
            @csrf

            <!-- Account Selection -->
            <div>
                <label for="cust_act_number" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Debit Account <span class="text-error">*</span></label>
                <div class="relative">
                    <select name="cust_act_number" id="cust_act_number" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-mono font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">-- Select an Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no }}">{{ $account->account_no }} ({{ $account->account_type }})</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                </div>
            </div>

            <!-- Number of Leaves -->
            <div>
                <label for="leaves" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Number of Leaves <span class="text-error">*</span></label>
                <div class="grid grid-cols-3 gap-3">
                    <button type="button" onclick="document.getElementById('leaves').value = '25'" class="py-2.5 px-4 rounded-xl border border-outline-variant/30 hover:border-primary hover:bg-primary/10 text-xs font-bold text-on-surface transition-all text-center">25 Leaves</button>
                    <button type="button" onclick="document.getElementById('leaves').value = '50'" class="py-2.5 px-4 rounded-xl border border-outline-variant/30 hover:border-primary hover:bg-primary/10 text-xs font-bold text-on-surface transition-all text-center">50 Leaves</button>
                    <button type="button" onclick="document.getElementById('leaves').value = '100'" class="py-2.5 px-4 rounded-xl border border-outline-variant/30 hover:border-primary hover:bg-primary/10 text-xs font-bold text-on-surface transition-all text-center">100 Leaves</button>
                </div>
                <input type="number" name="leaves" id="leaves" required placeholder="e.g. 25, 50, 100" class="mt-2 w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>

            <!-- Delivery Address -->
            <div>
                <label for="address" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Delivery Address <span class="text-error">*</span></label>
                <input type="text" name="address" id="address" required placeholder="Street address, City, State, Postal code" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-medium focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
            </div>

            <!-- Notes -->
            <div>
                <label for="message" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Special Delivery Instructions (Optional)</label>
                <textarea name="message" id="message" rows="3" placeholder="Any specific delivery instructions or branch pickup requests..." class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl p-4 text-sm text-on-surface font-medium focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all resize-none"></textarea>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-surface-container flex items-center justify-end gap-3">
                <a href="{{ url('/online') }}" class="px-5 py-3 rounded-full border border-outline-variant/30 bg-surface-container-lowest hover:bg-surface-container text-secondary text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-full bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider shadow-md transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span> Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

@include('footer')
