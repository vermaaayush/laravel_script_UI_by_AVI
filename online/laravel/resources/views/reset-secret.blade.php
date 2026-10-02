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
            <span class="text-on-surface font-medium">Reset Secret</span>
        </div>
        <h2 class="text-display-lg font-display-lg text-on-surface mb-xs">Reset Secret Question</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant">Update your security questions and answers.</p>
    </div>

    <!-- Main Container -->
    <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
        <div class="p-lg">
            <form role="form" method="POST" action="{{ asset('update-secret') }}">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">{{ $customer[0]->qid }}</label>
                    <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="ans" id="ans" required value="{{ $customer[0]->ans }}">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">{{ $customer[0]->qid2 }}</label>
                    <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="ans2" id="ans2" required value="{{ $customer[0]->ans2 }}">
                </div>

                <div class="mt-lg flex justify-end">
                    <button type="submit" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-8 rounded-lg transition-colors flex items-center gap-2">
                        <span>Update Security Details</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




 <!-- footer -->
@include('footer')
<!-- // footer -->
