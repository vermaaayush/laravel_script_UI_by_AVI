<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-5xl mx-auto w-full space-y-6 pb-12 font-sans">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="font-heading font-bold text-2xl sm:text-3xl text-on-surface tracking-tight">Account Statement</h1>
            <p class="text-sm text-secondary mt-1">Filter, inspect, and export verified commercial transaction statements.</p>
        </div>
        <a href="{{ asset('accounts-summary') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[17px]">arrow_back</span>
            <span>Back to Accounts</span>
        </a>
    </div>

    <!-- Generate Statement Form Card -->
    <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-outline-variant/30 shadow-sm">
        <form role="form" method="POST" action="{{ asset('get-account-statement') }}" class="space-y-6">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            <!-- Step 1: Select Account -->
            <div>
                <label class="block text-xs font-bold text-secondary uppercase tracking-wider mb-3">1. Select Custody Account</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($accounts as $key => $row)
                    <label for="account<?=$key+1;?>" class="relative flex items-center p-4 rounded-xl border border-outline-variant/30 hover:border-primary bg-surface-container-low/50 hover:bg-surface-container-lowest cursor-pointer transition-all has-[:checked]:border-primary has-[:checked]:bg-surface-container-lowest has-[:checked]:ring-2 has-[:checked]:ring-primary/20 has-[:checked]:shadow-sm">
                        <input type="radio" name="account" id="account<?=$key+1;?>" class="w-4 h-4 text-primary focus:ring-primary accent-primary" @if($key == 0) checked @endif value="{{ $row->id }}">
                        <div class="ml-3 flex-1 min-w-0">
                            <span class="text-xs font-mono font-bold text-on-surface block">{{ $row->account_no }}</span>
                            <span class="text-[11px] text-secondary block truncate">{{ $row->account_type }} • {{ $row->branch_name ?? 'Commercial Treasury' }}</span>
                        </div>
                        <span class="text-xs font-mono font-bold text-primary">{{ $row->account_currency }} {{ number_format($row->available_balance, 2) }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Step 2: Date Range & Export Format -->
            <div class="pt-4 border-t border-surface-container grid grid-cols-1 md:grid-cols-12 gap-5">
                <!-- Date Period -->
                <div class="md:col-span-8 space-y-2">
                    <label class="block text-xs font-bold text-secondary uppercase tracking-wider">2. Statement Period</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <span class="text-[11px] text-secondary font-medium block mb-1">From Date</span>
                            <input type="date" name="start" id="start" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2.5 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" value="{{ date('Y-m-01') }}">
                        </div>
                        <div>
                            <span class="text-[11px] text-secondary font-medium block mb-1">To Date</span>
                            <input type="date" name="end" id="end" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2.5 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <!-- Export Format -->
                <div class="md:col-span-4 space-y-2">
                    <label class="block text-xs font-bold text-secondary uppercase tracking-wider">3. Output Format</label>
                    <div>
                        <span class="text-[11px] text-secondary font-medium block mb-1">Select View or Export</span>
                        <select name="type" id="type" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2.5 text-xs text-on-surface font-semibold focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            <option value="view">Interactive Screen View</option>
                            <option value="pdf">Official PDF Statement (FINMA Sealed)</option>
                            <option value="excel">Microsoft Excel (.xlsx)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-5 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-xs text-secondary">
                    <span class="material-symbols-outlined text-[18px] text-primary">verified</span>
                    <span>Includes official cryptographic bank seal & transaction hashes</span>
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                    <span>Generate Statement</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
@include('footer')
