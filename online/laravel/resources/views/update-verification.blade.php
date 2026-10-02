  <!-- Header -->
@include('header')
 <!-- // Header -->

 <!-- Sidebar -->
@include('sidebar')
 <!-- //  Sidebar -->

 <!-- top navbar -->
@include('topNav')
 <!-- // top navbar -->
<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-lg">
        <div class="flex items-center gap-sm text-on-surface-variant text-body-md font-body-md mb-xs">
            <a class="hover:text-primary transition-colors" href="#">System Config</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface font-medium">Verification Info</span>
        </div>
        <h2 class="text-display-lg font-display-lg text-on-surface mb-xs">Update Verification / Signature Information</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant">Keep your verification documents up to date.</p>
        
        @include('flash::message')
    </div>

    <!-- Main Container -->
    <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
        <div class="p-lg">
            @php
                $config = DB::select('select * from configs WHERE id = ?',[1]);
            @endphp
            <form role="form" method="POST" action="{{ asset('update-verification-db') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload Clear Passport Size Photograph:</label>
                    <div class="mt-2 mb-4">
                        <input type="file" class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-surface-container-high file:text-on-surface hover:file:bg-surface-container-highest cursor-pointer" name="photo" id="photo" accept="image/*">
                    </div>
                    <?php if($customer[0]->cust_photo != '') { ?>
                        <div class="mt-4 p-4 border border-outline-variant/30 rounded-lg bg-surface-container-low inline-block">
                            <p class="text-xs text-on-surface-variant mb-2 uppercase font-semibold tracking-wider">Current Photo</p>
                            <?php if(strpos($customer[0]->cust_photo, 'data:image/') !== false) { ?>
                                <img src="{{ $customer[0]->cust_photo }}" class="w-32 h-auto rounded-lg shadow-sm" />
                            <?php } else { ?>
                                <img src="{{ 'https://' . $config[0]->bank_url . '/uploads/' . $customer[0]->cust_photo }}" class="w-32 h-auto rounded-lg shadow-sm" />
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <span class="text-error photo-error text-sm mt-2" style="display: none;">Please upload Photo</span>
                </div>

                <div class="mb-8 border-t border-surface-container-high pt-8">
                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Upload valid Government issued Identification (Passport, Driver's License, National ID Card):</label>
                    <div class="mt-2 mb-4">
                        <input type="file" class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-surface-container-high file:text-on-surface hover:file:bg-surface-container-highest cursor-pointer" name="national_id" id="national_id" accept="image/*">
                    </div>
                    <?php if($customer[0]->cust_natioanl_id != '') { ?>
                        <div class="mt-4 p-4 border border-outline-variant/30 rounded-lg bg-surface-container-low inline-block">
                            <p class="text-xs text-on-surface-variant mb-2 uppercase font-semibold tracking-wider">Current National ID</p>
                            <?php if(strpos($customer[0]->cust_natioanl_id, 'data:image/') !== false) { ?>
                                <img src="{{ $customer[0]->cust_natioanl_id }}" class="w-48 h-auto rounded-lg shadow-sm" />
                            <?php } else { ?>
                                <img src="{{ 'https://' . $config[0]->bank_url . '/uploads/' . $customer[0]->cust_natioanl_id }}" class="w-48 h-auto rounded-lg shadow-sm" />
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <span class="text-error national_id-error text-sm mt-2" style="display: none;">Please upload Signature</span>
                </div>

                <div class="mb-8 border-t border-surface-container-high pt-8">
                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Data Verification (Use web cam to take a picture of yourself holding the ID near your face):</label>
                    <div class="mt-2 mb-4">
                        <input type="file" class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-surface-container-high file:text-on-surface hover:file:bg-surface-container-highest cursor-pointer" name="verification_document" id="verification_document" accept="image/*">
                    </div>
                    <?php if($customer[0]->verification_document != '') { ?>
                        <div class="mt-4 p-4 border border-outline-variant/30 rounded-lg bg-surface-container-low inline-block">
                            <p class="text-xs text-on-surface-variant mb-2 uppercase font-semibold tracking-wider">Current Verification Document</p>
                            <?php if(strpos($customer[0]->verification_document, 'data:image/') !== false) { ?>
                                <img src="{{ $customer[0]->verification_document }}" class="w-48 h-auto rounded-lg shadow-sm" />
                            <?php } else { ?>
                                <img src="{{ 'https://' . $config[0]->bank_url . '/uploads/' . $customer[0]->verification_document }}" class="w-48 h-auto rounded-lg shadow-sm" />
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="mt-lg flex justify-end">
                    <button type="submit" class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold py-3 px-8 rounded-xl transition-all shadow-md flex items-center gap-2">
                        <span>Submit Documents</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
      
<!-- footer -->
@include('footer')
<!-- // footer -->
