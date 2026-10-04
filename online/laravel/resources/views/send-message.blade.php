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
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors" href="{{ url('all-messages') }}">Communications Desk</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Secure Dispatch</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Compose Banking Transmission</h1>
                <p class="text-sm text-[#53625b] mt-1">Transmit an encrypted inquiry or compliance documentation to your dedicated private wealth desk.</p>
            </div>
            <a href="{{ url('all-messages') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#f2f4f3] hover:bg-[#e6e9e8] text-[#191c1c] text-xs font-bold transition-all">
                <span class="material-symbols-outlined text-[16px]">inbox</span>
                <span>View Inbox</span>
            </a>
        </div>
        
        <div class="mt-4">
            @include('flash::message')
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] overflow-hidden">
        <div class="p-6 sm:p-8">
            <form class="email-form flex flex-col gap-6" role="form" novalidate method="POST" action="{{ asset('insert-send-message') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />
                
                <div class="flex flex-col gap-6">
                    <!-- Recipient & Relationship Officer -->
                    <div class="flex flex-col md:flex-row gap-6 items-start bg-[#f8faf9] p-5 rounded-2xl border border-[#e6e9e8]">
                        <div class="flex flex-col gap-2 flex-grow w-full">
                            <label class="text-xs font-bold text-[#53625b] uppercase tracking-wider">Designated Officer / Recipient</label>
                            <div class="relative">
                                <select name="to_email" id="to_email" class="w-full bg-white border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 pl-4 pr-10 text-sm font-semibold text-[#191c1c] outline-none transition-all appearance-none cursor-pointer" readonly multiple="multiple">
                                    <option selected value="{{ $customer_am[0]->email }}">{{ $customer_am[0]->name }} ({{ $customer_am[0]->email }})</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-[#53625b] pointer-events-none text-[18px]">verified</span>
                            </div>
                            <p class="text-[11px] text-[#53625b]">Messages dispatched through this secure channel are end-to-end encrypted under FINMA standard protocols.</p>
                        </div>
                        @if(isset($customer_am[0]->photo) && $customer_am[0]->photo != '')
                        <div class="flex-shrink-0 flex items-center gap-3 bg-white p-2 rounded-xl border border-[#e6e9e8]">
                            <img class="rounded-lg object-cover w-14 h-14" src="{{ $customer_am[0]->photo }}" alt="Support Contact">
                            <div class="pr-2">
                                <p class="text-xs font-bold text-[#191c1c]">{{ $customer_am[0]->name }}</p>
                                <span class="text-[10px] font-bold text-[#004226] bg-[#e8f7ee] px-2 py-0.5 rounded-md border border-[#aaf2c4]">Online</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Subject -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-[#53625b] uppercase tracking-wider">Transmission Subject</label>
                        <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl py-3 px-4 text-sm font-semibold text-[#191c1c] outline-none transition-all placeholder-[#53625b]/50" name="subject" id="subject" value="" placeholder="e.g. Inward Wire Inquiries / Custody Audit Request" required />
                    </div>

                    <!-- Message Body -->
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-[#53625b] uppercase tracking-wider">Message Content</label>
                        <div class="border border-[#e6e9e8] rounded-xl overflow-hidden focus-within:border-[#004226]">
                            <textarea class="w-full form-control bg-white p-4 text-sm text-[#191c1c] outline-none" name="msg" id="editor" required rows="6" placeholder="Provide full details of your banking inquiry..."></textarea>
                        </div>
                    </div>

                    <!-- Attachment -->
                    <div class="flex flex-col gap-2 pt-4 border-t border-[#f2f4f3]">
                        <label class="text-xs font-bold text-[#53625b] uppercase tracking-wider">Encrypted Document Attachment (Optional)</label>
                        <div class="p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <input type="file" name="file" id="file" class="w-full text-xs text-[#53625b] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#004226] file:text-white hover:file:bg-[#0f5b38] file:cursor-pointer cursor-pointer"/>
                            <p class="text-[11px] text-[#53625b] mt-2">Permitted formats: PDF, PNG, JPG, DOCX up to 15MB. Encrypted via AES-256 upon upload.</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end pt-6 border-t border-[#f2f4f3] gap-4">
                    <a href="{{ url('all-messages') }}" class="px-6 py-3 rounded-xl border border-[#e6e9e8] text-[#53625b] hover:bg-[#f8faf9] text-xs font-bold transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-[#004226] hover:bg-[#0f5b38] text-white font-bold text-xs shadow-sm transition-all flex items-center gap-2">
                        <span>Dispatch Message</span>
                        <span class="material-symbols-outlined text-[16px]">send</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- // Page Content -->

<script src="<?= asset('exasset/ckeditor/ckeditor.js') ?>"></script>

<script type="text/javascript">
	var toolbarGroups = [
	    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
	    { name: 'forms', groups: [ 'forms' ] },
	    '/',
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
	    '/',
	    { name: 'styles', groups: [ 'styles' ] },
	    { name: 'colors', groups: [ 'colors' ] },
	    { name: 'tools', groups: [ 'tools' ] },
	    { name: 'others', groups: [ 'others' ] }
	];
    if(typeof CKEDITOR !== 'undefined' && document.getElementById('editor')) {
        CKEDITOR.replace( 'editor',{
            toolbar : 'Basic',
            toolbarGroups,
        });
    }
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
