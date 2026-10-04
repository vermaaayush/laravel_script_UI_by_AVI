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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors flex items-center gap-1" href="{{ url('/') }}">
                <span class="material-symbols-outlined text-[14px]">home</span> Portal
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#53625b]">Liquidity & Payouts</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Withdrawal Dispatch</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Withdraw Capital</h1>
                <p class="text-sm text-[#53625b] mt-1">Authorize outbound settlements to external depository institutions or verified cryptographic wallets.</p>
            </div>
            <a href="{{ url('user-all-withdrawls') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#f2f4f3] hover:bg-[#e6e9e8] text-[#191c1c] text-xs font-bold transition-all">
                <span class="material-symbols-outlined text-[16px]">list_alt</span>
                <span>Full Settlement History</span>
            </a>
        </div>
    </div>

    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        <!-- Withdrawal Form Card -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 pb-5 border-b border-[#f2f4f3] mb-6">
                    <div class="w-10 h-10 rounded-xl bg-[#e8f7ee] border border-[#aaf2c4] text-[#004226] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">output</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold font-headline text-[#191c1c]">Initiate Outbound Payout</h3>
                        <p class="text-xs text-[#53625b]">Select origin custody account and specify payment destination</p>
                    </div>
                </div>

                <form method="POST" action="{{ asset('add-withdrawl') }}" id="withSubmit" class="space-y-5">
                    @csrf

                    <!-- Max Amount Info Tile -->
                    <div class="p-4 rounded-xl bg-[#f8faf9] border border-[#e6e9e8] flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-[#53625b] uppercase tracking-wider block">Maximum Authorized Limit</span>
                            <span class="text-lg font-mono font-bold text-[#191c1c]">{{ Session::get('account_currency') ?? '$' }} {{ number_format((float)(is_object($amount ?? null) ? $amount->max_amount : ($amount ?? 100000)), 2) }}</span>
                        </div>
                        <input type="hidden" id="maxWithdraw" name="max_amount" value="{{ is_object($amount ?? null) ? $amount->max_amount : ($amount ?? 100000) }}">
                        <span class="px-2.5 py-1 bg-white border border-[#e6e9e8] text-[#004226] rounded-lg text-xs font-bold uppercase tracking-wider">Tier-1 Ceiling</span>
                    </div>

                    <!-- Account Selection -->
                    <div>
                        <label for="account_no" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Debit Custody Vault <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="account_no" id="account_no" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-sm text-[#191c1c] font-mono font-bold outline-none transition-all appearance-none cursor-pointer">
                                <option value="">-- Select Source Vault --</option>
                                @foreach($users as $Ba_bene)
                                    <option value="{{ $Ba_bene->id }}">{{ $Ba_bene->account_no }} ({{ $Ba_bene->account_type }})</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#53625b]">expand_more</span>
                        </div>
                    </div>

                    <!-- Withdrawal Channel -->
                    <div>
                        <label for="pay_method" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Settlement Medium <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="pay_method" id="pay_method" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-sm text-[#191c1c] font-semibold outline-none transition-all appearance-none cursor-pointer">
                                <option value="">-- Select Channel --</option>
                                <?php foreach(json_decode($coderanita ?? '[]') ?? [] as $withkey => $withvalue){ ?> 
                                    <?php $getDisbled = DB::table('ba_withdraw_method_endi')->where('mid',$withvalue->id)->first() ?>
                                    <?php if(!$getDisbled){ ?>
                                        <option value="<?= $withvalue->name ?>" data-title="<?= $withvalue->title ?>"><?= $withvalue->name ?></option>    
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#53625b]">expand_more</span>
                        </div>
                    </div>

                    <!-- Withdrawal Amount -->
                    <div>
                        <label for="amountWith" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Disbursement Volume <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#53625b] font-mono font-bold">{{ Session::get('account_currency') ?? '$' }}</span>
                            <input type="text" name="amount" id="amountWith" placeholder="0.00" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3.5 pl-10 pr-4 text-base font-mono font-bold text-[#191c1c] outline-none transition-all decimal-num">
                        </div>
                        <p id="errorAmount" class="text-xs font-bold text-rose-600 mt-1"></p>
                    </div>

                    <!-- Wallet ID / Destination ID -->
                    <div>
                        <label id="walletText" for="wallet_id" class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Destination Account Identifier / Address <span class="text-rose-500">*</span></label>
                        <input type="text" name="wallet_id" id="wallet_id" required placeholder="Enter destination identifier" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-sm text-[#191c1c] font-mono outline-none transition-all">
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 border-t border-[#f2f4f3] flex items-center justify-end">
                        <button type="submit" class="px-8 py-3.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                            <span>Proceed to Confirmation</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security & Instructions Card -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm p-6 space-y-4">
                <h3 class="text-xs font-bold text-[#53625b] uppercase tracking-wider">Settlement Protocol</h3>
                
                <div class="flex items-start gap-3 text-xs text-[#53625b]">
                    <span class="material-symbols-outlined text-[#004226] text-[18px] shrink-0 mt-0.5">verified_user</span>
                    <span>All external disbursement orders undergo automated compliance validation and anti-financial crime screening before broadcast.</span>
                </div>
                <div class="flex items-start gap-3 text-xs text-[#53625b]">
                    <span class="material-symbols-outlined text-[#004226] text-[18px] shrink-0 mt-0.5">schedule</span>
                    <span>Direct network transfers settle in 15–30 minutes post clearance. International wires settle on the next SWIFT processing window.</span>
                </div>
                <div class="flex items-start gap-3 text-xs text-[#53625b]">
                    <span class="material-symbols-outlined text-[#004226] text-[18px] shrink-0 mt-0.5">support_agent</span>
                    <span>For questions regarding transactional velocity or emergency order freezes, communicate directly with your dedicated desk.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Withdrawals Ledger -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-[#f2f4f3] flex items-center justify-between bg-[#f8faf9]">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#004226] text-[20px]">history</span>
                <h3 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Recent Payout Records</h3>
            </div>
            <span class="text-xs text-[#53625b]">Last Outbound Orders</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] text-[11px] font-bold text-[#53625b] uppercase tracking-wider border-b border-[#f2f4f3]">
                        <th class="py-3.5 px-6">Account Number</th>
                        <th class="py-3.5 px-6">Disbursed Volume</th>
                        <th class="py-3.5 px-6">Medium & Recipient</th>
                        <th class="py-3.5 px-6">Settlement State</th>
                        <th class="py-3.5 px-6 text-right">Filing Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f4f3] text-sm">
                    @forelse($withdraws ?? [] as $single)
                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                    <tr class="hover:bg-[#f8faf9] transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-[#191c1c]">
                            <?= $account ? $account->account_no : '—' ?>
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-rose-600">
                            -{{ Session::get('account_currency') ?? '$' }} <?= number_format($single->amount, 2) ?>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-[#191c1c] block"><?= $single->withtype ?></span>
                            <span class="font-mono text-xs text-[#53625b] block truncate max-w-xs"><?= $single->withid ?></span>
                        </td>
                        <td class="py-4 px-6">
                            <?php if($single->approved == 0){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Under Review
                                </span>
                            <?php } elseif($single->approved == 1){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Awaiting Settlement
                                </span>
                            <?php } elseif($single->approved == 2){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span> Disbursed
                                </span>
                            <?php } elseif($single->approved == 3){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Declined
                                </span>
                            <?php } ?>
                        </td>
                        <td class="py-4 px-6 text-right text-xs font-mono text-[#53625b]">
                            <?= date('d M Y', strtotime($single->date_of_with)) ?>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-[#53625b]">
                            <span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-2">output</span>
                            <p class="text-sm font-semibold text-[#191c1c]">No Historical Withdrawals</p>
                            <p class="text-xs text-[#53625b] mt-0.5">Outbound disbursement instructions will appear in this ledger.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#pay_method').change(function(){
           var _this = $(this);
           if(_this.val() != ""){
               var title = _this.find(':selected').data('title');
               if(title) {
                   $('#walletText').html(title + ' <span class="text-rose-500">*</span>');
                   $('#wallet_id').attr('placeholder', title);
               }
           } else {
               $('#walletText').html('Destination Account Identifier / Address <span class="text-rose-500">*</span>');
               $('#wallet_id').attr('placeholder', 'Enter destination identifier');
           }
        });

        $('#withSubmit').submit(function(){
            var _max = parseFloat($('#maxWithdraw').val());
            var _amount = parseFloat($('#amountWith').val());
            if(_amount > _max){
                $('#amountWith').focus();
                $('#errorAmount').html('Maximum permitted withdrawal limit is ' + _max.toLocaleString());
                return false;
            } else {
                $('#errorAmount').html('');
            }
        });
    });
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
