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
<div class="max-w-3xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('user-withdrawl') }}">Withdrawals</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Confirmation</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Withdrawal Authorization</h1>
        <p class="text-sm text-slate-500 mt-1">Review fees, select settlement channel, and authorize the disbursement request.</p>
    </div>

    <!-- Settlement Breakdown Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 mb-6">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Disbursement Fee Breakdown</h3>
        
        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-5 space-y-3 mb-6">
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-500 font-medium">Principal Withdrawal</span>
                <span class="font-mono font-bold text-slate-900">{{ $curr }} {{ number_format($amount, 2) }}</span>
            </div>
            <div class="flex items-center justify-between text-sm pb-3 border-b border-slate-200/60">
                <span class="text-slate-500 font-medium">Clearance & Processing Surcharge (5%)</span>
                <span class="font-mono font-bold text-slate-700">{{ $curr }} {{ number_format($res, 2) }}</span>
            </div>
            <div class="flex items-center justify-between pt-1">
                <span class="text-sm font-black text-slate-900 uppercase tracking-wide">Total Order Settlement</span>
                <span class="text-xl font-mono font-black text-primary">{{ $curr }} {{ number_format($Grand, 2) }}</span>
            </div>
        </div>

        <form action="{{ asset('withdrawl-detail') }}" method="post" class="space-y-6">
            @csrf
            <input type="hidden" name="id" value="{{$User_Withdrawl->id}}">
            <input type="hidden" name="amount" value="{{$User_Withdrawl->amount}}">
            <input type="hidden" name="transfer_percentage" value="{{$res}}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="pay_method" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Select Withdrawal Channel <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="pay_method" id="pay_method" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="" selected disabled>-- Select Channel --</option>
                            <option value="0">Bitcoin Network (Crypto Settlement)</option>
                            <option value="1">Direct Bank Wire / Local Transfer</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <div>
                    <label for="wallet_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Recipient Wallet / IBAN / Account ID <span class="text-rose-500">*</span></label>
                    <input type="text" name="wallet_id" id="wallet_id" required placeholder="Enter destination identifier" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('user-withdrawl') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Back
                </a>
                <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">verified</span> Confirm & Authorize
                </button>
            </div>
        </form>
    </div>
</div>

<!-- OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden p-6 text-center">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[32px]">shield</span>
            </div>
            <h4 class="text-lg font-bold text-slate-900 mb-1">Enter Security OTP</h4>
            <p class="text-xs text-slate-500 mb-6">A one-time verification token has been dispatched to your email.</p>
            
            <div class="mb-6">
                <input type="text" name="fname" placeholder="• • • • • •" class="w-full py-3 px-4 text-center font-mono font-black text-xl tracking-[0.3em] bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary outline-none">
            </div>

            <div class="flex items-center justify-center gap-3">
                <button type="button" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold uppercase" data-dismiss="modal">Cancel</button>
                <button type="button" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase shadow-sm">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
