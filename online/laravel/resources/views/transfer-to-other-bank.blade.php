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

<!-- Main Content Wrapper (Stitch Sovereign Design Language) -->
<div class="max-w-4xl mx-auto w-full space-y-6 pb-12 font-sans">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider mb-2">
                <span class="material-symbols-outlined text-[15px]">swap_horiz</span>
                <span>Cross-Border & External Settlement</span>
            </div>
            <h1 class="font-heading font-bold text-2xl sm:text-3xl text-on-surface tracking-tight">Wire & External Transfer</h1>
            <p class="text-sm text-secondary mt-1">Transfer funds to domestic or international commercial bank accounts via SWIFT, BIC, or ACH.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" data-toggle="modal" data-target="#benificaryModalCenter" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[17px]">person_add</span>
                <span>Add Beneficiary</span>
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-error-container text-error rounded-2xl text-xs border border-error/20">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('flash::message')

    <!-- Security Tip -->
    <div class="p-4 bg-primary text-on-primary rounded-2xl border border-white/10 flex items-start gap-3 shadow-md">
        <span class="material-symbols-outlined text-primary-fixed shrink-0 text-[20px] mt-0.5">enhanced_encryption</span>
        <p class="text-xs text-white/80 leading-relaxed">
            Wire transfers undergo real-time AML and OFAC screening before final settlement. Please verify all beneficiary routing codes, SWIFT/BIC, and IBAN numbers accurately.
        </p>
    </div>

    <!-- Main Transfer Card -->
    <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-outline-variant/30 shadow-sm">
        <form id="form-wizard1" method="POST" action="{{ asset('initiate-other-bank-transfer') }}" class="space-y-6">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <!-- From & Debit Accounts (2 cols) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="transfer_from" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">From Source Account</label>
                    <select name="transfer_from" id="transfer_from" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface font-semibold focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none font-mono cursor-pointer transition-all">
                        <option value="">-- Select Source Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no }}">{{ $account->account_no }} ({{ $account->account_currency }} {{ number_format($account->available_balance, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="debit_from" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Operational Fee Debit Account</label>
                    <select name="debit_from" id="debit_from" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface font-semibold focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none font-mono cursor-pointer transition-all">
                        <option value="">-- Select Account for Fee Debit --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->account_no }}">{{ $account->account_no }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Beneficiary Selection -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label for="receiver_noniban" class="block text-xs font-bold text-secondary uppercase tracking-wider">Select External Beneficiary</label>
                    <button type="button" data-toggle="modal" data-target="#benificaryModalCenter" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                        <span>+ Add New Beneficiary</span>
                    </button>
                </div>

                @if (!$Ba_benes->isEmpty())
                    <select name="receiver_noniban" id="receiver_noniban" required class="select_tag w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface font-semibold focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none font-mono cursor-pointer transition-all">
                        <option value="" data-id="">-- Select Registered External Beneficiary --</option>
                        @foreach($Ba_benes as $Ba_bene)
                            <option value="{{ $Ba_bene->beneficiary_account }}" data-id="{{ $Ba_bene->id }}">
                                {{ $Ba_bene->beneficiary_name }} — {{ $Ba_bene->beneficiary_account }} ({{ $Ba_bene->beneficiary_bank_name ?? 'Bank' }})
                            </option>
                        @endforeach    
                    </select>
                @else
                    <div class="p-5 rounded-2xl bg-surface-container-low border border-outline-variant/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-2.5 text-xs text-secondary font-medium">
                            <span class="material-symbols-outlined text-primary text-[20px]">person_off</span>
                            <span>No external beneficiaries saved in your directory yet.</span>
                        </div>
                        <button type="button" data-toggle="modal" data-target="#benificaryModalCenter" class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-sm shrink-0">
                            + Add Beneficiary First
                        </button>
                    </div>
                @endif
            </div>

            <!-- Dynamic Amount & Purpose Container -->
            @if (!$Ba_benes->isEmpty())
            <div id="amount_id" style="display:none;" class="flex flex-col gap-5 pt-2">
                <div>
                    <label for="amount" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Transfer Amount</label>
                    <div class="relative rounded-2xl bg-surface-container-low border border-outline-variant/30 focus-within:border-primary focus-within:bg-surface-container-lowest focus-within:ring-2 focus-within:ring-primary/20 transition-all overflow-hidden p-3 sm:p-4">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-secondary">$</span>
                            <input type="text" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="0.00" class="w-full bg-transparent border-0 text-3xl sm:text-4xl font-extrabold text-on-surface font-sans focus:ring-0 p-0 outline-none">
                            <input type="hidden" name="beneficiary" id="benefe"/>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="remark" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Payment Purpose / Wire Memo</label>
                    <textarea name="remark" id="remark" required rows="2" placeholder="e.g. Commercial invoice settlement, Vendor contract payment..." class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none"></textarea>
                </div>
            </div>
            @endif

            <!-- Submit -->
            <div class="pt-5 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs text-secondary font-medium">Institutional SWIFT / Fedwire Gateway</span>
                <button type="submit" name="next" value="Next" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <span>Initiate Wire Settlement</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Beneficiary Modal (Matching Stitch Design) -->
<div class="modal fade" id="benificaryModalCenter" tabindex="-1" role="dialog" aria-labelledby="benificaryModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-3xl border border-outline-variant/30 shadow-2xl overflow-hidden">
      <div class="p-6 border-b border-surface-container flex justify-between items-center bg-surface-container-low/50">
        <div>
            <h5 class="text-base font-heading font-bold text-on-surface" id="benificaryModalLongTitle">Register New Beneficiary</h5>
            <p class="text-xs text-secondary">Save external account details for rapid wire dispatches.</p>
        </div>
        <button type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-secondary hover:text-on-surface hover:bg-surface-container" data-dismiss="modal" aria-label="Close">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      <div class="p-6 bg-surface-container-lowest">
        <form method="POST" action="{{ asset('add-beneficary') }}" class="space-y-4">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          
          <div>
             <label for="bank_type" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Select Destination Entity Type</label>
             <select class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-xs text-on-surface font-semibold focus:bg-surface-container-lowest focus:border-primary outline-none" onChange="fetch_data(this.value)" id="bank_type" name="bank_type" required>
                <option value="" selected>Select Bank Type</option>
                <option value="1"><?= $confiG->bank_name ?? 'OripioFin' ?> (Internal Account)</option>
                <option value="0">External Bank (Domestic / International Foreign Transfer)</option>
             </select>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
             <div style="display:none;" id="beneficiary_name">
                <label class="block text-xs font-semibold text-secondary mb-1">Beneficiary Full Legal Name</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none" name="beneficiary_name" id="beneficiary_name1" required value="{{ old('beneficiary_name') }}" placeholder="Full beneficiary name" />
             </div>

             <div style="display:none;" id="beneficiary_account">
                <label class="block text-xs font-semibold text-secondary mb-1">Account Number</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none font-mono" name="beneficiary_account" id="beneficiary_account1" required value="{{ old('beneficiary_account') }}" placeholder="Account number" />
             </div>

             <div style="display:none;" id="beneficiary_bank_name">
                <label class="block text-xs font-semibold text-secondary mb-1">Beneficiary Bank Name</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none" name="beneficiary_bank_name" id="beneficiary_bank_name1" required value="{{ old('beneficiary_bank_name') }}" placeholder="Receiving bank name" />
             </div>

             <div style="display:none;" id="beneficiary_swift">
                <label class="block text-xs font-semibold text-secondary mb-1">SWIFT / BIC Code</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none font-mono" name="beneficiary_swift" value="{{ old('beneficiary_swift') }}" placeholder="e.g. EQUISUS33" />
             </div>

             <div style="display:none;" id="beneficiary_iban">
                <label class="block text-xs font-semibold text-secondary mb-1">IBAN (International Account)</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none font-mono" name="beneficiary_iban" value="{{ old('beneficiary_iban') }}" placeholder="IBAN number" />
             </div>

             <div style="display:none;" id="beneficiary_sort_code">
                <label class="block text-xs font-semibold text-secondary mb-1">Routing / Sort Code / ABA</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none font-mono" name="beneficiary_sort_code" value="{{ old('beneficiary_sort_code') }}" placeholder="Routing / Sort code" />
             </div>

             <div style="display:none;" id="beneficiary_country" class="sm:col-span-2">
                <label class="block text-xs font-semibold text-secondary mb-1">Beneficiary Bank Country</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none" name="beneficiary_country" id="beneficiary_country1" required value="{{ old('beneficiary_country') }}" placeholder="Country" />
             </div>

             <div style="display:none;" id="beneficiary_address" class="sm:col-span-2">
                <label class="block text-xs font-semibold text-secondary mb-1">Beneficiary Street Address</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none" name="beneficiary_address" id="beneficiary_address1" required value="{{ old('beneficiary_address') }}" placeholder="Beneficiary residential address" />
             </div>

             <div style="display:none;" id="beneficiary_bank_address" class="sm:col-span-2">
                <label class="block text-xs font-semibold text-secondary mb-1">Beneficiary Bank Branch Address</label>
                <input type="text" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3.5 py-2 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none" name="beneficiary_bank_address" id="beneficiary_bank_address1" required value="{{ old('beneficiary_bank_address') }}" placeholder="Branch address" />
             </div>
          </div>
            
          {{ session(['TransferToOtherBank' => '1']) }}
          <div class="flex justify-end pt-4 border-t border-surface-container mt-4">
             <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md">
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
<div class="fixed inset-0 bg-on-surface/60 backdrop-blur-sm z-[99999] flex items-center justify-center p-4" id="transferBlockedOverlay">
    <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center shadow-2xl border border-outline-variant/30">
        <div class="w-14 h-14 rounded-2xl bg-error-container text-error flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-3xl">lock</span>
        </div>
        <h4 class="text-lg font-heading font-bold text-on-surface mb-2">{{ session('transfer_blocked_heading') }}</h4>
        <p class="text-xs text-secondary leading-relaxed mb-6">{{ session('transfer_blocked_message') }}</p>
        <button class="w-full py-3 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold shadow-md mb-2" onclick="document.getElementById('transferBlockedOverlay').style.display='none';">
            Return to Dashboard
        </button>
        <button class="w-full py-2.5 rounded-xl bg-surface-container-low hover:bg-surface-container text-secondary text-xs font-semibold" onclick="document.getElementById('transferBlockedOverlay').style.display='none';">
            Dismiss
        </button>
    </div>
</div>
@endif

@include('footer')
