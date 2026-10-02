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
<div class="max-w-2xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Cheques</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Request Cheque Book</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Request Cheque Book</h1>
        <p class="text-sm text-slate-500 mt-1">Order a personalized cheque booklet dispatched directly to your registered or designated address.</p>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ asset('insert-cheque-book-request') }}" class="space-y-6">
            @csrf

            <!-- Account Selection -->
            <div>
                <label for="cust_act_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Debit Account <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="cust_act_number" id="cust_act_number" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">-- Select an Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no }}">{{ $account->account_no }} ({{ $account->account_type }})</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                </div>
            </div>

            <!-- Number of Leaves -->
            <div>
                <label for="leaves" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Number of Leaves <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-3 gap-3">
                    <button type="button" onclick="document.getElementById('leaves').value = '25'" class="py-2.5 px-4 rounded-xl border border-slate-200 hover:border-primary hover:bg-primary/5 text-xs font-bold text-slate-700 transition-all text-center">25 Leaves</button>
                    <button type="button" onclick="document.getElementById('leaves').value = '50'" class="py-2.5 px-4 rounded-xl border border-slate-200 hover:border-primary hover:bg-primary/5 text-xs font-bold text-slate-700 transition-all text-center">50 Leaves</button>
                    <button type="button" onclick="document.getElementById('leaves').value = '100'" class="py-2.5 px-4 rounded-xl border border-slate-200 hover:border-primary hover:bg-primary/5 text-xs font-bold text-slate-700 transition-all text-center">100 Leaves</button>
                </div>
                <input type="number" name="leaves" id="leaves" required placeholder="e.g. 25, 50, 100" class="mt-2 w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>

            <!-- Delivery Address -->
            <div>
                <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Delivery Address <span class="text-rose-500">*</span></label>
                <input type="text" name="address" id="address" required placeholder="Street address, City, State, Postal code" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>

            <!-- Notes -->
            <div>
                <label for="message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Special Delivery Instructions (Optional)</label>
                <textarea name="message" id="message" rows="3" placeholder="Any specific delivery instructions or branch pickup requests..." class="w-full bg-slate-50/60 border border-slate-200 rounded-xl p-4 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none"></textarea>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('/online') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span> Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
