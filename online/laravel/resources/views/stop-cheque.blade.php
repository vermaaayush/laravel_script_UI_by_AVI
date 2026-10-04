<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-4xl mx-auto w-full pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Overview
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-secondary">Cheques</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Stop Cheque</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Stop Cheque Payment</h1>
                <p class="text-sm text-secondary mt-1">Place an instant stop-payment block on single or sequential clearing cheques.</p>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-error-container text-error rounded-full text-xs font-bold uppercase tracking-wider">
                <span class="material-symbols-outlined text-[16px]">front_hand</span> Immediate Protection
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ asset('insert-stop-cheque') }}" class="space-y-6">
            @csrf

            <!-- Account Selection -->
            <div>
                <label class="block text-xs font-bold text-secondary uppercase tracking-wider mb-3">1. Select Linked Custody Account <span class="text-error">*</span></label>
                <div class="space-y-2.5">
                    @foreach($accounts as $key => $row)
                    <label for="account<?=$key+1;?>" class="flex items-center justify-between p-3.5 rounded-2xl border border-outline-variant/30 hover:border-primary/50 hover:bg-surface-container-low cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-surface-container-low">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="account_no" id="account<?=$key+1;?>" class="w-4 h-4 text-primary focus:ring-primary accent-primary" @if($key == 0) checked @endif value="{{ $row->account_no }}">
                            <div>
                                <span class="font-mono text-sm font-bold text-on-surface block">{{ $row->account_no }}</span>
                                <span class="text-xs text-secondary">{{ $row->account_type }} &bull; {{ $row->branch_name }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-primary">Primary</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Cheque Range & Instrument Details -->
            <div class="pt-4 border-t border-surface-container">
                <label class="block text-xs font-bold text-secondary uppercase tracking-wider mb-3">2. Cheque Leaf Range & Instrument Type</label>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="start_cheque" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Start Cheque No. <span class="text-error">*</span></label>
                        <input type="text" name="start_cheque" id="start_cheque" required placeholder="e.g. 000145" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 font-mono font-semibold text-sm text-on-surface focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>

                    <div>
                        <label for="end_cheque" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">End Cheque No. <span class="text-error">*</span></label>
                        <input type="text" name="end_cheque" id="end_cheque" required placeholder="e.g. 000145" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 font-mono font-semibold text-sm text-on-surface focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>

                    <div>
                        <label for="type" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Instrument Type <span class="text-error">*</span></label>
                        <div class="relative">
                            <select name="type" id="type" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface font-semibold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                <option value="Normal Cheque">Normal Cheque</option>
                                <option value="Multi City Cheque">Multi City Cheque</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-secondary">expand_more</span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-secondary mt-2">For a single cheque, enter the identical number into both Start and End fields.</p>
            </div>

            <!-- Caution Note -->
            <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/20 text-xs text-secondary leading-relaxed flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[18px] text-error shrink-0 mt-0.5">warning</span>
                <span>
                    Once placed, the cheque status is registered across the clearing clearinghouse. A standard stop-payment fee applies per the account fee schedule.
                </span>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-surface-container flex items-center justify-end gap-3">
                <a href="{{ url('/online') }}" class="px-5 py-3 rounded-full border border-outline-variant/30 bg-surface-container-lowest hover:bg-surface-container text-secondary text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-full bg-error hover:bg-red-700 text-white text-xs font-bold uppercase tracking-wider shadow-md transition-all flex items-center gap-2" onclick="return confirm('Confirm placing a stop-payment block on the specified cheques?');">
                    <span class="material-symbols-outlined text-[18px]">front_hand</span> Place Stop Order
                </button>
            </div>
        </form>
    </div>
</div>

@include('footer')
