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
<div class="max-w-4xl mx-auto w-full">
    <!-- Header -->
    <div class="mb-lg">
        <div class="flex items-center gap-sm text-on-surface-variant text-body-md font-body-md mb-xs">
            <a class="hover:text-primary transition-colors" href="#">Customer Feedback</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface font-medium">Send Message</span>
        </div>
        <h2 class="text-display-lg font-display-lg text-on-surface mb-xs">Compose Message</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant">Send a secure message directly to our support team.</p>
        
        @include('flash::message')
    </div>

    <!-- Form Container -->
    <div class="bg-surface rounded-xl shadow-level-1 p-lg border border-outline-variant/20">
        <form class="email-form flex flex-col gap-lg" role="form" novalidate method="POST" action="{{ asset('insert-send-message') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />
            
            <div class="flex flex-col gap-md">
                <!-- To & Profile Picture -->
                <div class="flex flex-col md:flex-row gap-lg items-start">
                    <div class="flex flex-col gap-xs flex-grow w-full">
                        <label class="font-headline-sm text-body-md text-on-surface">To:</label>
                        <div class="relative">
                            <select name="to_email" id="to_email" class="w-full bg-surface-container-low border border-transparent rounded-lg py-3 pl-4 pr-10 font-body-md text-body-md focus:ring-2 focus:ring-primary focus:bg-surface outline-none transition-all appearance-none cursor-pointer" readonly multiple="multiple">
                                <option selected value="{{ $customer_am[0]->email }}">{{ $customer_am[0]->name }}</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    @if(isset($customer_am[0]->photo) && $customer_am[0]->photo != '')
                    <div class="flex-shrink-0">
                        <img class="rounded-xl object-cover w-24 h-24 shadow-sm border border-outline-variant/20" src="{{ $customer_am[0]->photo }}" alt="Support Contact">
                    </div>
                    @endif
                </div>

                <!-- Subject -->
                <div class="flex flex-col gap-xs">
                    <label class="font-headline-sm text-body-md text-on-surface">Subject:</label>
                    <input type="text" class="w-full bg-surface-container-low border border-transparent rounded-lg py-3 px-4 font-body-md text-body-md focus:ring-2 focus:ring-primary focus:bg-surface outline-none transition-all" name="subject" id="subject" value="" placeholder="Enter message subject" required />
                </div>

                <!-- Message -->
                <div class="flex flex-col gap-xs">
                    <label class="font-headline-sm text-body-md text-on-surface">Your Message:</label>
                    <div class="border border-surface-container-high rounded-lg overflow-hidden">
                        <textarea class="w-full form-control" name="msg" id="editor" required rows="5" placeholder="Write your message here..."></textarea>
                    </div>
                </div>

                <!-- Attachment -->
                <div class="flex flex-col gap-xs border-t border-surface-container pt-md">
                    <label class="font-headline-sm text-body-md text-on-surface">Attach File (Optional)</label>
                    <input type="file" name="file" id="file" class="w-full bg-surface-container-low border border-transparent rounded-lg p-2 font-body-md text-body-md focus:ring-2 focus:ring-primary focus:bg-surface outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#b34020]-container file:text-on-primary-container hover:file:bg-[#b34020]/20 cursor-pointer text-on-surface-variant"/>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end pt-md border-t border-surface-container">
                <button type="submit" class="px-8 py-3 rounded-lg bg-[#b34020] text-on-primary font-headline-sm hover:opacity-90 shadow-sm transition-opacity flex items-center gap-sm">
                    Send Message
                    <span class="material-symbols-outlined text-[18px]">send</span>
                </button>
            </div>
        </form>
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
    CKEDITOR.replace( 'editor',{
	    toolbar : 'Basic',
	    toolbarGroups,
   	});
</script>


 <!-- footer -->
@include('footer')
<!-- // footer -->
