
                                     <?php 
                    $confiG = DB::table('configs')->where('id','1')->first();
                    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
                ?>

                    @include('flash::message')
                                    @if ($errors->any())
                                    <div class="bg-error-container text-on-error-container p-4 rounded-lg">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li><br/>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                      <form class="" method="POST" action="{{ asset('add-beneficary') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                      <div class="col-md-12">
                                         <div class="flex flex-wrap -mx-3">
                                            
                                             <div class="col-md-5">
                                                 <div class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Select Bank type</label>
                                                <select class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" onChange="fetch_data(this.value)" id="bank_type" name="bank_type"  required>
                                                  
                                                    <option value="" selected>Select Bank</option>
                                                    <option value="1"><?= $confiG->bank_name ?></option>
                                                    <option value="0">Other bank (Foreign/External Transfer)</option>
                                                 
                                                </select>
                                            </div>
                                             </div>
                                         <div class="flex flex-wrap -mx-3">
                                             <div class="col-md-4">
                                                 <div style="display:none;" id="beneficiary_name" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Beneficiary Name:</label>
                                         </div>e
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"  name="beneficiary_name" id="beneficiary_name1" required 
                                            value="{{ old('beneficiary_name') }}" placeholder="beneficiary name" />
                                         </div>
                                         <div style="display:none;" id="beneficiary_address" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Beneficiary Address:</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_address" id="beneficiary_address1" required 
                                            value="{{ old('beneficiary_address') }}" placeholder="beneficiary address" />
                                         </div>
                                         <div style="display:none;" id="beneficiary_sort_code" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Beneficiary Bank Routing / Sort code:</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_sort_code"  value="{{ old('beneficiary_sort_code') }}"
                                         placeholder="Beneficiary Bank Routing / Sort code" />
                                         </div>

                                        
                                             </div>
                                             <div class="col-md-4">
                                                 <div style="display:none;" id="beneficiary_swift" class="mb-6">
                                                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Beneficiary Swift Code / BIC:</label>
                                                <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_swift"    value="{{ old('beneficiary_swift') }}"
                                                placeholder="Beneficiary Swift Code / BIC" />
                                            </div>
                                         <div style="display:none;" id="beneficiary_iban" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">IBAN (IBAN Beneficiary Only):</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_iban"   value="{{ old('beneficiary_iban') }}" 
                                            placeholder="IBAN (IBAN Beneficiary Only):" />
                                         </div>

                                           <div style="display:none;" id="beneficiary_account" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Account Number :</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_account" id="beneficiary_account1" required  value="{{ old('beneficiary_account') }}" 
                                            placeholder="Account Number " />
                                         </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div style="display:none;" id="beneficiary_bank_name" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Beneficiary Bank Name:</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_bank_name" id="beneficiary_bank_name1" required 
                                            value="{{ old('beneficiary_bank_name') }}" placeholder="Beneficiary Bank Name" />
                                         </div>
                                         <div style="display:none;" id="beneficiary_bank_address" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Beneficiary Bank address:</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_bank_address" id="beneficiary_bank_address1" required  value="{{ old('beneficiary_bank_address') }}"
                                            placeholder="Beneficiary Bank address" />
                                         </div>
                                         <div style="display:none;" id="beneficiary_country" class="mb-6">
                                            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Beneficiary Bank Country:</label>
                                            <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="beneficiary_country" id="beneficiary_country1" required  value="{{ old('beneficiary_country') }}"
                                            placeholder="Beneficiary Bank Country" />
                                         </div>

                                             </div>

                                         </div>
                                        
                                      </div>

                                        <button type="submit" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">Add Beneficiary </button>

                                    </form>
                
            
<script>

  
function fetch_data(type)
{  

  if(type == '1'){
     alert('heloo');
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
        
         }else{
        
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
 
</script>        
