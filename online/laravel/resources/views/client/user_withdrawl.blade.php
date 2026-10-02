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
<div class="max-w-7xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Cash Management</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Withdrawal Request</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Withdraw Funds</h1>
                <p class="text-sm text-slate-500 mt-1">Submit outbound withdrawals to external bank accounts, crypto wallets, or payment channels.</p>
            </div>
            <a href="{{ url('user-all-withdrawls') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">list_alt</span> Full History
            </a>
        </div>
    </div>

    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm">
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
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 pb-5 border-b border-slate-100 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">output</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Initiate Withdrawal</h3>
                        <p class="text-xs text-slate-500">Provide destination details and payout amount</p>
                    </div>
                </div>

                <form method="POST" action="{{ asset('add-withdrawl') }}" id="withSubmit" class="space-y-6">
                    @csrf

                    <!-- Max Amount Info Tile -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Maximum Withdrawal Allowance</span>
                            <span class="text-lg font-mono font-black text-slate-900">{{ number_format((float)$amount->max_amount, 2) }}</span>
                        </div>
                        <input type="hidden" id="maxWithdraw" name="max_amount" value="{{ $amount->max_amount }}">
                        <span class="px-2.5 py-1 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold uppercase">Authorized Cap</span>
                    </div>

                    <!-- Account Selection -->
                    <div>
                        <label for="account_no" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Debit Account <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="account_no" id="account_no" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                <option value="">-- Select Source Account --</option>
                                @foreach($users as $Ba_bene)
                                    <option value="{{ $Ba_bene->id }}">{{ $Ba_bene->account_no }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                    </div>

                    <!-- Withdrawal Channel -->
                    <div>
                        <label for="pay_method" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Payout Method <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <select name="pay_method" id="pay_method" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                                <option value="">-- Select Method --</option>
                                <?php foreach(json_decode($coderanita) as $withkey => $withvalue){ ?> 
                                    <?php $getDisbled = DB::table('ba_withdraw_method_endi')->where('mid',$withvalue->id)->first() ?>
                                    <?php if(!$getDisbled){ ?>
                                        <option value="<?= $withvalue->name ?>" data-title="<?= $withvalue->title ?>"><?= $withvalue->name ?></option>    
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                    </div>

                    <!-- Withdrawal Amount -->
                    <div>
                        <label for="amountWith" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Withdrawal Amount <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-mono font-bold">$</span>
                            <input type="text" name="amount" id="amountWith" placeholder="0.00" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl py-3.5 pl-9 pr-4 text-base font-mono font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all decimal-num">
                        </div>
                        <p id="errorAmount" class="text-xs font-bold text-rose-600 mt-1"></p>
                    </div>

                    <!-- Wallet ID / Destination ID -->
                    <div>
                        <label id="walletText" for="wallet_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Destination Wallet / Account Address <span class="text-rose-500">*</span></label>
                        <input type="text" name="wallet_id" id="wallet_id" required placeholder="Enter destination identifier" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">send</span> Submit Withdrawal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security & Instructions Card -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Settlement Protocol</h3>
                
                <div class="flex items-start gap-3 text-xs text-slate-600">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0">security</span>
                    <span>All external disbursement instructions undergo automated compliance screen and sanction clearance before final broadcast.</span>
                </div>
                <div class="flex items-start gap-3 text-xs text-slate-600">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0">schedule</span>
                    <span>Standard blockchain network transfers execute within 15–30 minutes following internal sign-off. Wire settlements reflect on the next clearing cycle.</span>
                </div>
                <div class="flex items-start gap-3 text-xs text-slate-600">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0">support_agent</span>
                    <span>For questions regarding transfer velocity or to request an expedited limit raise, contact your private account manager.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Withdrawals Ledger -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">history</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Recent Withdrawals</h3>
            </div>
            <span class="text-xs text-slate-400">Outbound settlements</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Account Number</th>
                        <th class="py-3.5 px-6">Amount</th>
                        <th class="py-3.5 px-6">Method & Destination</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Requested Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($withdraws as $single)
                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-slate-800">
                            <?= $account ? $account->account_no : '—' ?>
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-rose-600">
                            -<?= number_format($single->amount, 2) ?>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900 block"><?= $single->withtype ?></span>
                            <span class="font-mono text-xs text-slate-400 block truncate max-w-xs"><?= $single->withid ?></span>
                        </td>
                        <td class="py-4 px-6">
                            <?php if($single->approved == 0){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                                </span>
                            <?php } elseif($single->approved == 1){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Awaiting Confirmation
                                </span>
                            <?php } elseif($single->approved == 2){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                </span>
                            <?php } elseif($single->approved == 3){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                </span>
                            <?php } ?>
                        </td>
                        <td class="py-4 px-6 text-right text-xs font-mono text-slate-500">
                            <?= date('d M, Y', strtotime($single->date_of_with)) ?>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">output</span>
                            <p class="text-sm font-semibold text-slate-600">No Withdrawal History</p>
                            <p class="text-xs text-slate-400 mt-0.5">You have not submitted any withdrawal requests yet.</p>
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
               $('#walletText').html('Destination Wallet / Account Address <span class="text-rose-500">*</span>');
               $('#wallet_id').attr('placeholder', 'Enter destination identifier');
           }
        });

        $('#withSubmit').submit(function(){
            var _max = parseFloat($('#maxWithdraw').val());
            var _amount = parseFloat($('#amountWith').val());
            if(_amount > _max){
                $('#amountWith').focus();
                $('#errorAmount').html('Maximum permitted withdrawal is ' + _max.toLocaleString());
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
