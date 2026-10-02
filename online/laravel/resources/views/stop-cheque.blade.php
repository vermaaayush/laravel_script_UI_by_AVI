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
<div class="max-w-4xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Cheques</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Stop Cheque</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Stop Cheque Payment</h1>
                <p class="text-sm text-slate-500 mt-1">Place an instant stop-payment block on single or sequential cheques.</p>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 border border-rose-200/60 rounded-xl text-rose-700 text-xs font-bold uppercase tracking-wider">
                <span class="material-symbols-outlined text-[16px]">front_hand</span> Immediate Protection
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ asset('insert-stop-cheque') }}" class="space-y-6">
            @csrf

            <!-- Account Selection -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">1. Select Linked Account <span class="text-rose-500">*</span></label>
                <div class="space-y-2.5">
                    @foreach($accounts as $key => $row)
                    <label for="account<?=$key+1;?>" class="flex items-center justify-between p-3.5 rounded-2xl border border-slate-200/80 hover:border-primary/50 hover:bg-slate-50/50 cursor-pointer transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="account_no" id="account<?=$key+1;?>" class="w-4 h-4 text-primary focus:ring-primary border-slate-300" @if($key == 0) checked @endif value="{{ $row->account_no }}">
                            <div>
                                <span class="font-mono text-sm font-bold text-slate-900 block">{{ $row->account_no }}</span>
                                <span class="text-xs text-slate-500">{{ $row->account_type }} &bull; {{ $row->branch_name }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-slate-400">Primary</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Cheque Range & Instrument Details -->
            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">2. Cheque Leaf Range & Instrument Type</label>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="start_cheque" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Start Cheque No. <span class="text-rose-500">*</span></label>
                        <input type="text" name="start_cheque" id="start_cheque" required placeholder="e.g. 000145" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 font-mono font-semibold text-sm text-slate-800 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    </div>

                    <div>
                        <label for="end_cheque" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">End Cheque No. <span class="text-rose-500">*</span></label>
                        <input type="text" name="end_cheque" id="end_cheque" required placeholder="e.g. 000145" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 font-mono font-semibold text-sm text-slate-800 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    </div>

                    <div>
                        <label for="type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Instrument Type <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="type" id="type" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                <option value="Normal Cheque">Normal Cheque</option>
                                <option value="Multi City Cheque">Multi City Cheque</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-2">For a single cheque, enter the identical number into both Start and End fields.</p>
            </div>

            <!-- Caution Note -->
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-xs text-amber-800 leading-relaxed flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[18px] text-amber-600 shrink-0 mt-0.5">warning</span>
                <span>
                    Once placed, the cheque status is registered across the national clearing clearinghouse. A standard stop-payment fee applies per the account fee schedule.
                </span>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('/online') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2" onclick="return confirm('Confirm placing a stop-payment block on the specified cheques?');">
                    <span class="material-symbols-outlined text-[18px]">front_hand</span> Place Stop Order
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
