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
<div class="max-w-5xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('view-cards') }}">Cards</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Request Card</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Request New Payment Card</h1>
                <p class="text-sm text-slate-500 mt-1">Order an embossed debit or credit card linked to your account.</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-50 border border-amber-200/60 rounded-xl text-amber-800 text-xs font-semibold">
                <span class="material-symbols-outlined text-[16px] text-amber-600">receipt</span> Issuance Fee: N1,000.00 + VAT N50
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
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">account_balance_wallet</span> 1. Select Linked Account
                    </h3>
                    <div class="space-y-2.5">
                        @foreach($accounts as $key => $account)
                        <label for="account{{$key}}" class="flex items-center justify-between p-3.5 rounded-2xl border border-slate-200/80 hover:border-primary/50 hover:bg-slate-50/50 cursor-pointer transition-all">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="cust_act_number" id="account{{$key}}" class="w-4 h-4 text-primary focus:ring-primary border-slate-300" @if($key == 0) checked @endif value="{{ $account->account_no }}" onchange="updateCardPreviewAccount('{{ $account->account_no }}')">
                                <div>
                                    <span class="font-mono text-sm font-bold text-slate-900 block">{{ $account->account_no }}</span>
                                    <span class="text-xs text-slate-500">{{ $account->account_type }} &bull; {{ $account->branch_name }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-slate-400">Available</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Card Details -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-5">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">credit_card</span> 2. Choose Card Specifications
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="card_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Card Type <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select name="card_type" id="card_type" required onchange="updateCardPreviewType(this.value)" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                    <option value="" selected disabled>Select Card Type</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="Credit Card">Credit Card</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                            </div>
                        </div>

                        <div>
                            <label for="card_service_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Network Brand <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select name="card_service_type" id="card_service_type" required onchange="updateCardPreviewBrand(this.value)" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                    <option value="" selected disabled>Select Network Brand</option>
                                    <option value="Visa">Visa</option>
                                    <option value="MasterCard">MasterCard</option>
                                    <option value="American Express">American Express</option>
                                    <option value="Discover">Discover</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Delivery Instructions / Comment</label>
                        <input type="text" name="message" id="message" value="" placeholder="e.g. Branch pickup or express delivery..." class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ url('view-cards') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">credit_card</span> Submit Card Request
                    </button>
                </div>
            </div>

            <!-- Right Column: Interactive Card Preview -->
            <div class="lg:col-span-5">
                <div class="sticky top-28 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Live Card Visualizer</h3>
                    
                    <!-- Card Mockup -->
                    <div class="relative overflow-hidden rounded-3xl p-6 text-white shadow-2xl h-56 bg-gradient-to-br from-[#121620] via-[#1a202c] to-[#0f131a] border border-slate-700/60 flex flex-col justify-between">
                        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-primary/25 blur-2xl pointer-events-none"></div>

                        <!-- Top row -->
                        <div class="flex items-center justify-between z-10">
                            <span id="previewCardType" class="font-mono text-xs font-bold uppercase tracking-wider text-slate-300">DEBIT CARD</span>
                            <span class="font-black text-xs text-primary tracking-widest uppercase">EQUITY BANK</span>
                        </div>

                        <!-- Chip -->
                        <div class="flex items-center gap-3 z-10 my-auto">
                            <div class="w-11 h-8 rounded-lg bg-gradient-to-tr from-amber-400 to-amber-200 border border-amber-500/60 shadow-inner flex items-center justify-center">
                                <div class="w-7 h-5 border border-amber-700/40 rounded-sm"></div>
                            </div>
                            <span class="material-symbols-outlined text-[20px] text-slate-400 rotate-90">contactless</span>
                        </div>

                        <!-- Bottom row -->
                        <div class="z-10">
                            <p class="font-mono text-lg font-bold tracking-[0.2em] text-white">4532 •••• •••• 8892</p>
                            <div class="flex items-end justify-between mt-2 pt-2 border-t border-slate-700/50">
                                <div>
                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest block">Linked Account</span>
                                    <span id="previewCardAccount" class="text-xs font-mono font-semibold text-slate-200">{{ count($accounts) ? $accounts[0]->account_no : '••••••••••' }}</span>
                                </div>
                                <span id="previewCardBrand" class="font-black text-sm text-slate-200 tracking-wider uppercase">VISA</span>
                            </div>
                        </div>
                    </div>

                    <!-- Security assurances -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-start gap-2.5 text-xs text-slate-600">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px]">verified</span>
                            <span>Contactless NFC enabled for fast and touch-free transactions worldwide.</span>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs text-slate-600">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px]">lock</span>
                            <span>3D Secure 2.0 fraud defense active on all online and point-of-sale payments.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function updateCardPreviewAccount(acc) {
    document.getElementById('previewCardAccount').innerText = acc;
}
function updateCardPreviewType(type) {
    document.getElementById('previewCardType').innerText = type.toUpperCase();
}
function updateCardPreviewBrand(brand) {
    document.getElementById('previewCardBrand').innerText = brand.toUpperCase();
}
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
