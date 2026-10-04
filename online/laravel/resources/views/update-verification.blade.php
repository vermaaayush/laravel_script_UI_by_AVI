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
<div class="max-w-4xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">System Config</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Verification Documents</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">KYC Document & Signature Updates</h1>
        <p class="text-sm text-slate-500 mt-1">Submit authentic identity and biometric credentials to maintain uninterrupted Tier-1 banking status.</p>
    </div>

    @include('flash::message')

    @php
        $config = DB::select('select * from configs WHERE id = ?',[1]);
    @endphp

    <!-- Main Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-6 border-b border-slate-100 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center border border-emerald-100">
                <span class="material-symbols-outlined text-[24px]">badge</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Encrypted Document Vault</h3>
                <p class="text-xs text-slate-500">All uploaded credentials are stored with AES-256 bank-grade encryption and audited by compliance officers.</p>
            </div>
        </div>

        <form role="form" method="POST" action="{{ asset('update-verification-db') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Section 1: Passport Photo -->
            <div class="p-6 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-900">1. Passport Photograph</label>
                        <p class="text-xs text-slate-500 mt-0.5">High-resolution recent color photograph with a neutral background.</p>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-slate-200/70 text-slate-700">JPEG/PNG Max 5MB</span>
                </div>

                <input type="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#004226] file:text-white hover:file:bg-[#0f5b38] file:cursor-pointer cursor-pointer bg-white border border-slate-200 rounded-xl p-2" name="photo" id="photo" accept="image/*">
                
                @if($customer[0]->cust_photo != '')
                    <div class="mt-4 p-4 border border-slate-200/80 rounded-xl bg-white inline-flex flex-col items-start">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">On-File Photo</span>
                        @if(strpos($customer[0]->cust_photo, 'data:image/') !== false)
                            <img src="{{ $customer[0]->cust_photo }}" class="w-28 h-auto rounded-lg shadow-sm border border-slate-100" />
                        @else
                            <img src="{{ 'https://' . $config[0]->bank_url . '/uploads/' . $customer[0]->cust_photo }}" class="w-28 h-auto rounded-lg shadow-sm border border-slate-100" />
                        @endif
                    </div>
                @endif
                <span class="text-rose-600 photo-error text-xs font-semibold mt-2" style="display: none;">Please select a valid image</span>
            </div>

            <!-- Section 2: National ID -->
            <div class="p-6 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-900">2. Government-Issued Identification</label>
                        <p class="text-xs text-slate-500 mt-0.5">Passport, International Driver's License, or National Identity Smart Card.</p>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-slate-200/70 text-slate-700">Clear Scan</span>
                </div>

                <input type="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#004226] file:text-white hover:file:bg-[#0f5b38] file:cursor-pointer cursor-pointer bg-white border border-slate-200 rounded-xl p-2" name="national_id" id="national_id" accept="image/*">
                
                @if($customer[0]->cust_natioanl_id != '')
                    <div class="mt-4 p-4 border border-slate-200/80 rounded-xl bg-white inline-flex flex-col items-start">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">On-File Government ID</span>
                        @if(strpos($customer[0]->cust_natioanl_id, 'data:image/') !== false)
                            <img src="{{ $customer[0]->cust_natioanl_id }}" class="w-40 h-auto rounded-lg shadow-sm border border-slate-100" />
                        @else
                            <img src="{{ 'https://' . $config[0]->bank_url . '/uploads/' . $customer[0]->cust_natioanl_id }}" class="w-40 h-auto rounded-lg shadow-sm border border-slate-100" />
                        @endif
                    </div>
                @endif
                <span class="text-rose-600 national_id-error text-xs font-semibold mt-2" style="display: none;">Please select a valid image</span>
            </div>

            <!-- Section 3: Selfie Verification Document -->
            <div class="p-6 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-900">3. Live Identity Verification (Selfie Holding ID)</label>
                        <p class="text-xs text-slate-500 mt-0.5">Photograph of yourself holding your government-issued ID clearly visible beside your face.</p>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200">Biometric Match</span>
                </div>

                <input type="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#004226] file:text-white hover:file:bg-[#0f5b38] file:cursor-pointer cursor-pointer bg-white border border-slate-200 rounded-xl p-2" name="verification_document" id="verification_document" accept="image/*">
                
                @if($customer[0]->verification_document != '')
                    <div class="mt-4 p-4 border border-slate-200/80 rounded-xl bg-white inline-flex flex-col items-start">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">On-File Biometric Capture</span>
                        @if(strpos($customer[0]->verification_document, 'data:image/') !== false)
                            <img src="{{ $customer[0]->verification_document }}" class="w-40 h-auto rounded-lg shadow-sm border border-slate-100" />
                        @else
                            <img src="{{ 'https://' . $config[0]->bank_url . '/uploads/' . $customer[0]->verification_document }}" class="w-40 h-auto rounded-lg shadow-sm border border-slate-100" />
                        @endif
                    </div>
                @endif
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('/online') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                    <span>Submit Documents</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
