<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
    $transfer_control = DB::table('ba_account_holders')->where('user_id', $user_id)->first();
    $transfer_status = DB::table('transfer_suspend_msg')->where('user_id', $user_id)->first();
?>

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Wire & External Transfer</h2>
            <p class="text-sm text-slate-500 mt-0.5">Transfer funds to domestic or international commercial bank accounts via SWIFT, BIC, or ACH.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" data-toggle="modal" data-target="#benificaryModalCenter" class="px-4 py-2 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">person_add</span>
                <span>Add Beneficiary</span>
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('flash::message')

    <!-- Security Tip -->
    <div class="p-4 bg-slate-900 text-white rounded-2xl border border-slate-800 flex items-start gap-3 shadow-md">
        <span class="material-symbols-outlined text-amber-400 shrink-0 text-[20px]">enhanced_encryption</span>
        <p class="text-xs text-slate-300 leading-relaxed">
            Wire transfers undergo real-time AML and OFAC screening before final settlement. Please verify all beneficiary routing codes, SWIFT/BIC, and IBAN numbers accurately.
        </p>
    </div>

    <!-- Main Transfer Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card">
        <form id="form-wizard1" method="POST" action="{{ asset('initiate-other-bank-transfer') }}" class="space-y-6">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <!-- From & Debit Accounts (2 cols) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="transfer_from" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">From Account</label>
                    <select name="transfer_from" id="transfer_from" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-900 font-semibold focus:bg-white focus:border-slate-800 outline-none font-mono cursor-pointer">
                        <option value="">-- Select Source Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no }}">{{ $account->account_no }} ({{ $account->account_currency }} {{ number_format($account->available_balance, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="debit_from" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Fee Debit Account</label>
                    <select name="debit_from" id="debit_from" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-900 font-semibold focus:bg-white focus:border-slate-800 outline-none font-mono cursor-pointer">
                        <option value="">-- Select Account for Fee Debit --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no }}">{{ $account->account_no }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Beneficiary Selection -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="receiver_noniban" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Select External Beneficiary</label>
                    <button type="button" data-toggle="modal" data-target="#benificaryModalCenter" class="text-xs font-bold text-[#c59b27] hover:underline flex items-center gap-1">
                        <span>+ Add New Beneficiary</span>
                    </button>
                </div>

                @if (!$Ba_benes->isEmpty())
                    <select name="receiver_noniban" id="receiver_noniban" required class="select_tag w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-900 font-semibold focus:bg-white focus:border-slate-800 outline-none font-mono cursor-pointer">
                        <option value="" data-id="">-- Select Registered External Beneficiary --</option>
                        @foreach($Ba_benes as $Ba_bene)
                            <option value="{{ $Ba_bene->beneficiary_account }}" data-id="{{ $Ba_bene->id }}">
                                {{ $Ba_bene->beneficiary_name }} — {{ $Ba_bene->beneficiary_account }} ({{ $Ba_bene->beneficiary_bank_name ?? 'Bank' }})
                            </option>
                        @endforeach    
                    </select>
                @else
                    <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-2.5 text-xs text-amber-900 font-medium">
                            <span class="material-symbols-outlined text-amber-600 text-[20px]">person_off</span>
                            <span>No external beneficiaries saved in your directory yet.</span>
                        </div>
                        <button type="button" data-toggle="modal" data-target="#benificaryModalCenter" class="px-4 py-2 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-xs shrink-0">
                            + Add Beneficiary First
                        </button>
                    </div>
                @endif
            </div>

            <!-- Dynamic Amount & Purpose Container -->
            @if (!$Ba_benes->isEmpty())
            <div id="amount_id" style="display:none;" class="flex flex-col gap-5 pt-2">
                <div>
                    <label for="amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Transfer Amount</label>
                    <div class="relative rounded-2xl bg-slate-50 border border-slate-200 focus-within:border-slate-800 focus-within:bg-white focus-within:ring-2 focus-within:ring-slate-900/5 transition-all overflow-hidden p-3 sm:p-4">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-slate-400">$</span>
                            <input type="text" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="0.00" class="w-full bg-transparent border-0 text-3xl sm:text-4xl font-extrabold text-slate-900 font-sans focus:ring-0 p-0 outline-none">
                            <input type="hidden" name="beneficiary" id="benefe"/>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="remark" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Payment Purpose / Wire Memo</label>
                    <textarea name="remark" id="remark" required rows="2" placeholder="e.g. Commercial invoice settlement, Vendor contract payment..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none transition-all resize-none"></textarea>
                </div>
            </div>
            @endif

            <!-- Submit -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Institutional Swift / Fedwire Gateway</span>
                <button type="submit" name="next" value="Next" class="px-8 py-3 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md flex items-center gap-2">
                    <span>Initiate Wire</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Beneficiary Modal (Matching New Design) -->
<div class="modal fade" id="benificaryModalCenter" tabindex="-1" role="dialog" aria-labelledby="benificaryModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
            <h5 class="text-base font-bold text-slate-900" id="benificaryModalLongTitle">Register New Beneficiary</h5>
            <p class="text-xs text-slate-500">Save external account details for rapid wire dispatches.</p>
        </div>
        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100" data-dismiss="modal" aria-label="Close">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      <div class="p-6">
        <form method="POST" action="{{ asset('add-beneficary') }}" class="space-y-4">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          
          <div>
             <label for="bank_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Select Destination Entity Type</label>
             <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 font-semibold focus:bg-white focus:border-slate-800 outline-none" onChange="fetch_data(this.value)" id="bank_type" name="bank_type" required>
                <option value="" selected>Select Bank Type</option>
                <option value="1"><?= $confiG->bank_name ?? 'Equitable Bank' ?> (Internal Account)</option>
                <option value="0">External Bank (Domestic / International Foreign Transfer)</option>
             </select>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
             <div style="display:none;" id="beneficiary_name">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Beneficiary Full Legal Name</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="beneficiary_name" id="beneficiary_name1" required value="{{ old('beneficiary_name') }}" placeholder="Full beneficiary name" />
             </div>

             <div style="display:none;" id="beneficiary_account">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Account Number</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none font-mono" name="beneficiary_account" id="beneficiary_account1" required value="{{ old('beneficiary_account') }}" placeholder="Account number" />
             </div>

             <div style="display:none;" id="beneficiary_bank_name">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Beneficiary Bank Name</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="beneficiary_bank_name" id="beneficiary_bank_name1" required value="{{ old('beneficiary_bank_name') }}" placeholder="Receiving bank name" />
             </div>

             <div style="display:none;" id="beneficiary_swift">
                <label class="block text-xs font-semibold text-slate-700 mb-1">SWIFT / BIC Code</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none font-mono" name="beneficiary_swift" value="{{ old('beneficiary_swift') }}" placeholder="e.g. EQUISUS33" />
             </div>

             <div style="display:none;" id="beneficiary_iban">
                <label class="block text-xs font-semibold text-slate-700 mb-1">IBAN (International Account)</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none font-mono" name="beneficiary_iban" value="{{ old('beneficiary_iban') }}" placeholder="IBAN number" />
             </div>

             <div style="display:none;" id="beneficiary_sort_code">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Routing / Sort Code / ABA</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none font-mono" name="beneficiary_sort_code" value="{{ old('beneficiary_sort_code') }}" placeholder="Routing / Sort code" />
             </div>

             <div style="display:none;" id="beneficiary_country" class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Beneficiary Bank Country</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="beneficiary_country" id="beneficiary_country1" required value="{{ old('beneficiary_country') }}" placeholder="Country" />
             </div>

             <div style="display:none;" id="beneficiary_address" class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Beneficiary Street Address</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="beneficiary_address" id="beneficiary_address1" required value="{{ old('beneficiary_address') }}" placeholder="Beneficiary residential address" />
             </div>

             <div style="display:none;" id="beneficiary_bank_address" class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1">Beneficiary Bank Branch Address</label>
                <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="beneficiary_bank_address" id="beneficiary_bank_address1" required value="{{ old('beneficiary_bank_address') }}" placeholder="Branch address" />
             </div>
          </div>
            
          {{ session(['TransferToOtherBank' => '1']) }}
          <div class="flex justify-end pt-4 border-t border-slate-100 mt-4">
             <button type="submit" class="px-6 py-2.5 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md">
                Save Beneficiary
             </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function fetch_data(type) {  
  if(type == '1') {
        $('#beneficiary_account').show();
        $("#beneficiary_account").addClass("accountz");
        $('#beneficiary_name1').removeAttr('required');
        $('#beneficiary_name').hide();
        $('#beneficiary_address1').removeAttr('required');
        $('#beneficiary_address').hide();
        $('#beneficiary_sort_code').hide();
        $('#beneficiary_swift').hide();
        $('#beneficiary_iban').hide();
        $('#beneficiary_bank_name1').removeAttr('required');
        $('#beneficiary_bank_name').hide();
        $('#beneficiary_bank_address1').removeAttr('required');
        $('#beneficiary_bank_address').hide();
        $('#beneficiary_country1').removeAttr('required');
        $('#beneficiary_country').hide();
  } else {
        $("#beneficiary_account").removeClass("accountz");
        $('#beneficiary_account').show();
        $('#beneficiary_name').show();
        $('#beneficiary_address').show();
        $('#beneficiary_sort_code').show();
        $('#beneficiary_swift').show();
        $('#beneficiary_iban').show();
        $('#beneficiary_bank_name').show();
        $('#beneficiary_bank_address').show();
        $('#beneficiary_country').show();
  }
}

function openModal(id){
    $('.bankPopup'+id).modal('show');
}

$(function(){
    $('#receiver_noniban').change(function(){
        $('#benefe').val($(this).find(':selected').data('id'));
    });
    
    $(".select_tag").on('change', function() {
        document.getElementById("amount_id").style.display = "flex";
    });
});
</script>

<!-- Transfer Blocked Popup Modal -->
@if(session('transfer_blocked_message'))
<div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[99999] flex items-center justify-center p-4" id="transferBlockedOverlay">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center shadow-2xl border border-slate-100">
        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-3xl">lock</span>
        </div>
        <h4 class="text-lg font-bold text-slate-900 mb-2">{{ session('transfer_blocked_heading') }}</h4>
        <p class="text-xs text-slate-500 leading-relaxed mb-6">{{ session('transfer_blocked_message') }}</p>
        <button class="w-full py-3 rounded-xl gold-gradient-btn text-xs font-bold shadow-md mb-2" onclick="document.getElementById('transferBlockedOverlay').style.display='none';">
            Return to Dashboard
        </button>
        <button class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold" onclick="document.getElementById('transferBlockedOverlay').style.display='none';">
            Dismiss
        </button>
    </div>
</div>
@endif

@include('footer')
