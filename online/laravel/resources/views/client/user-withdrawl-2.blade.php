<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

@php
    $amount = $User_Withdrawl->amount;
    $res = $amount * 5 / 100;
    $Grand = $amount + $res;
    $curr = Session::get('account_currency') ?? 'USD';
@endphp

<!-- Main Content Wrapper -->
<div class="max-w-3xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors flex items-center gap-1" href="{{ url('/') }}">
                <span class="material-symbols-outlined text-[14px]">home</span> Portal
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-[#004226] transition-colors" href="{{ url('user-whitdrawal') }}">Withdrawals</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Execution Review</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Withdrawal Authorization</h1>
        <p class="text-sm text-[#53625b] mt-1">Review clearing surcharges, select destination route, and commit the settlement.</p>
    </div>

    <!-- Settlement Breakdown Card -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm p-6 sm:p-8 mb-6">
        <h3 class="text-xs font-bold text-[#53625b] uppercase tracking-wider mb-4">Disbursement Fee Breakdown</h3>
        
        <div class="bg-[#f8faf9] border border-[#e6e9e8] rounded-xl p-5 space-y-3 mb-6">
            <div class="flex items-center justify-between text-xs">
                <span class="text-[#53625b] font-medium">Principal Capital Outflow</span>
                <span class="font-mono font-bold text-[#191c1c]">{{ $curr }} {{ number_format($amount, 2) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs pb-3 border-b border-[#e6e9e8]">
                <span class="text-[#53625b] font-medium">FINMA Network Clearance Surcharge (5%)</span>
                <span class="font-mono font-bold text-[#53625b]">{{ $curr }} {{ number_format($res, 2) }}</span>
            </div>
            <div class="flex items-center justify-between pt-1">
                <span class="text-xs font-bold uppercase tracking-wider text-[#191c1c]">Total Liquidity Order</span>
                <span class="text-xl font-mono font-bold text-[#004226]">{{ $curr }} {{ number_format($Grand, 2) }}</span>
            </div>
        </div>

        <form action="{{ asset('withdrawl-detail') }}" method="post" class="space-y-6">
            @csrf
            <input type="hidden" name="id" value="{{$User_Withdrawl->id}}">
            <input type="hidden" name="amount" value="{{$User_Withdrawl->amount}}">
            <input type="hidden" name="transfer_percentage" value="{{$res}}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="pay_method" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Disbursement Channel <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="pay_method" id="pay_method" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-sm text-[#191c1c] font-semibold outline-none transition-all appearance-none cursor-pointer">
                            <option value="" selected disabled>-- Select Route --</option>
                            <option value="0">Cryptographic Blockchain Settlement</option>
                            <option value="1">Direct Interbank Wire / Local Clearing</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#53625b]">expand_more</span>
                    </div>
                </div>

                <div>
                    <label for="wallet_id" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Beneficiary Identifier / Wallet Address <span class="text-rose-500">*</span></label>
                    <input type="text" name="wallet_id" id="wallet_id" required placeholder="Enter destination identifier" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-sm text-[#191c1c] font-mono outline-none transition-all">
                </div>
            </div>

            <div class="pt-4 border-t border-[#f2f4f3] flex items-center justify-end gap-3">
                <a href="{{ url('user-whitdrawal') }}" class="px-5 py-3 rounded-xl border border-[#e6e9e8] bg-white hover:bg-[#f8faf9] text-[#53625b] text-xs font-bold transition-colors">
                    Back
                </a>
                <button type="submit" class="px-8 py-3.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Commit & Authorize</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
