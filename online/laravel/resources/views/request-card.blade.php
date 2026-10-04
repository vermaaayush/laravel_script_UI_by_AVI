<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-5xl mx-auto w-full pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Overview
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('view-cards') }}">Cards</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Request Card</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Request Payment Card</h1>
                <p class="text-sm text-secondary mt-1">Order an embossed debit card or virtual corporate token linked to your custody vault.</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary/10 border border-primary/20 rounded-full text-primary text-xs font-semibold">
                <span class="material-symbols-outlined text-[16px]">receipt</span> Issuance: Complimentary for Tier-1 Accounts
            </div>
        </div>
    </div>

    @include('flash::message')

    <form method="POST" action="{{ asset('insert-card-request') }}" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Form Controls -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Account Selector -->
                <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6">
                    <h3 class="text-sm font-heading font-bold text-on-surface uppercase tracking-wide mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">account_balance_wallet</span> 1. Select Linked Account
                    </h3>
                    <div class="space-y-2.5">
                        @foreach($accounts as $key => $account)
                        <label for="account{{$key}}" class="flex items-center justify-between p-3.5 rounded-2xl border border-outline-variant/30 hover:border-primary/50 hover:bg-surface-container-low cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-surface-container-low">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="cust_act_number" id="account{{$key}}" class="w-4 h-4 text-primary focus:ring-primary accent-primary" @if($key == 0) checked @endif value="{{ $account->account_no }}" onchange="updateCardPreviewAccount('{{ $account->account_no }}')">
                                <div>
                                    <span class="font-mono text-sm font-bold text-on-surface block">{{ $account->account_no }}</span>
                                    <span class="text-xs text-secondary">{{ $account->account_type }} &bull; {{ $account->branch_name }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-primary">{{ $account->account_currency }} {{ number_format($account->available_balance, 2) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Card Details -->
                <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 space-y-5">
                    <h3 class="text-sm font-heading font-bold text-on-surface uppercase tracking-wide flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">credit_card</span> 2. Choose Card Specifications
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="card_type" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Card Type <span class="text-error">*</span></label>
                            <div class="relative">
                                <select name="card_type" id="card_type" required onchange="updateCardPreviewType(this.value)" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                    <option value="" selected disabled>Select Card Type</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Credit Card">Credit Card</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                            </div>
                        </div>

                        <div>
                            <label for="card_service_type" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Network Brand <span class="text-error">*</span></label>
                            <div class="relative">
                                <select name="card_service_type" id="card_service_type" required onchange="updateCardPreviewBrand(this.value)" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                    <option value="" selected disabled>Select Network Brand</option>
                                    <option value="Visa">Visa Infinite</option>
                                    <option value="MasterCard">Mastercard World Elite</option>
                                    <option value="American Express">American Express Centurion</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Delivery Instructions / Comment</label>
                        <input type="text" name="message" id="message" value="" placeholder="e.g. Courier to Zurich office or branch pickup..." class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-medium focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ url('view-cards') }}" class="px-5 py-3 rounded-full border border-outline-variant/30 bg-surface-container-lowest hover:bg-surface-container text-secondary text-xs font-bold uppercase tracking-wider transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider rounded-full shadow-md transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">credit_card</span> Submit Card Request
                    </button>
                </div>
            </div>

            <!-- Right Column: Interactive Card Preview -->
            <div class="lg:col-span-5">
                <div class="sticky top-28 bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 space-y-6">
                    <h3 class="text-xs font-bold text-secondary uppercase tracking-wider">Live Card Visualizer</h3>
                    
                    <!-- Card Mockup (Stitch Screen 2 Exact Physical Matte Finish) -->
                    <div class="relative overflow-hidden rounded-3xl p-6 text-white shadow-2xl h-56 bg-gradient-to-tr from-[#191c1c] via-[#242826] to-[#004226] border border-white/10 flex flex-col justify-between">
                        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-primary-fixed/15 blur-2xl pointer-events-none"></div>

                        <!-- Top row -->
                        <div class="flex items-center justify-between z-10">
                            <span id="previewCardType" class="font-heading text-xs font-bold uppercase tracking-wider text-primary-fixed">SOVEREIGN DEBIT</span>
                            <span class="font-heading font-extrabold text-xs text-primary-fixed tracking-widest uppercase">OripioFin</span>
                        </div>

                        <!-- Chip -->
                        <div class="flex items-center gap-3 z-10 my-auto">
                            <div class="w-10 h-7 rounded bg-amber-200/90 shadow-inner flex items-center justify-center">
                                <div class="w-7 h-5 border border-amber-900/40 rounded-sm"></div>
                            </div>
                            <span class="material-symbols-outlined text-[22px] text-primary-fixed">contactless</span>
                        </div>

                        <!-- Bottom row -->
                        <div class="z-10">
                            <p class="font-mono text-base font-bold tracking-[0.2em] text-white/90">
                                4829 •••• •••• 9201
                            </p>
                            <div class="flex items-end justify-between mt-2 pt-2 border-t border-white/10">
                                <div>
                                    <span class="text-[9px] text-white/50 uppercase tracking-widest block">Account</span>
                                    <span id="previewAccount" class="text-xs font-mono font-semibold text-white/90">
                                        {{ count($accounts) > 0 ? $accounts[0]->account_no : '••••••••••' }}
                                    </span>
                                </div>
                                <span id="previewBrand" class="font-heading font-bold text-xs text-primary-fixed tracking-wider uppercase">
                                    VISA
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/20 text-xs text-secondary space-y-1.5">
                        <p class="font-semibold text-on-surface">Card Delivery Timeline</p>
                        <p class="leading-relaxed">Embossed physical metal cards are manufactured in Switzerland and dispatched via insured DHL Express within 48-72 business hours.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function updateCardPreviewAccount(acc) {
        document.getElementById('previewAccount').innerText = acc;
    }
    function updateCardPreviewType(type) {
        document.getElementById('previewCardType').innerText = type.toUpperCase();
    }
    function updateCardPreviewBrand(brand) {
        document.getElementById('previewBrand').innerText = brand.toUpperCase();
    }
</script>

@include('footer')
