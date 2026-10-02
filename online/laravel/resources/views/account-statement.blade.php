<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-5xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Account Statement</h2>
            <p class="text-sm text-slate-500 mt-0.5">Filter, inspect, and export verified commercial transaction statements.</p>
        </div>
        <a href="{{ asset('accounts-summary') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[17px]">arrow_back</span>
            <span>Back to Accounts</span>
        </a>
    </div>

    <!-- Generate Statement Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card">
        <form role="form" method="POST" action="{{ asset('get-account-statement') }}" class="space-y-6">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            <!-- Step 1: Select Account -->
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">1. Select an Account</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($accounts as $key => $row)
                    <label for="account<?=$key+1;?>" class="relative flex items-center p-4 rounded-2xl border border-slate-200/90 hover:border-slate-800 bg-slate-50/50 hover:bg-white cursor-pointer transition-all has-[:checked]:border-slate-900 has-[:checked]:bg-white has-[:checked]:ring-2 has-[:checked]:ring-slate-900/10 has-[:checked]:shadow-sm">
                        <input type="radio" name="account" id="account<?=$key+1;?>" class="w-4 h-4 text-slate-900 focus:ring-slate-800 border-slate-300" @if($key == 0) checked @endif value="{{ $row->id }}">
                        <div class="ml-3 flex-1 min-w-0">
                            <span class="text-xs font-mono font-bold text-slate-900 block">{{ $row->account_no }}</span>
                            <span class="text-[11px] text-slate-500 block truncate">{{ $row->account_type }} • {{ $row->branch_name ?? 'Commercial' }}</span>
                        </div>
                        <span class="text-xs font-mono font-bold text-slate-800">{{ $row->account_currency }} {{ number_format($row->available_balance, 2) }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Step 2: Date Range & Export Format -->
            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-12 gap-5">
                <!-- Date Period -->
                <div class="md:col-span-8 space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">2. Statement Period</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <span class="text-[11px] text-slate-500 font-medium block mb-1">From Date</span>
                            <input type="date" name="start" id="start" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 focus:ring-2 focus:ring-slate-900/5 outline-none transition-all" value="{{ date('Y-m-01') }}">
                        </div>
                        <div>
                            <span class="text-[11px] text-slate-500 font-medium block mb-1">To Date</span>
                            <input type="date" name="end" id="end" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 focus:ring-2 focus:ring-slate-900/5 outline-none transition-all" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <!-- Export Format -->
                <div class="md:col-span-4 space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">3. Output Format</label>
                    <div>
                        <span class="text-[11px] text-slate-500 font-medium block mb-1">Select View or Export</span>
                        <select name="type" id="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:border-slate-800 focus:ring-2 focus:ring-slate-900/5 outline-none transition-all">
                            <option value="view">Interactive Screen View</option>
                            <option value="pdf">Official PDF Statement</option>
                            <option value="excel">Microsoft Excel (.xlsx)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <span class="material-symbols-outlined text-[17px] text-slate-400">verified</span>
                    <span>Includes official cryptographic bank seal</span>
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                    <span>Generate Statement</span>
                </button>
            </div>
        </form>
    </div>
</div>

@include('footer')
