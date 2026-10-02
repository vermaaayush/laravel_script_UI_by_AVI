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
            <span class="text-on-surface font-medium">Alert Activation</span>
        </div>
        <h2 class="text-display-lg font-display-lg text-on-surface mb-xs">Transaction Alert Activation</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant">Configure your notification preferences.</p>
    </div>

    <!-- Main Container -->
    <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
        <div class="p-lg">
            <form role="form" method="POST" action="{{ asset('update-transaction-alert') }}">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                
                <div class="flex items-center justify-between py-4 border-b border-surface-container-high">
                    <div>
                        <h3 class="text-title-md font-semibold text-on-surface">Email Notification</h3>
                        <p class="text-body-md text-on-surface-variant mt-1">Receive transaction alerts directly to your registered email address.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" name="email_notification" id="email_notification" value="1" <?php if(isset($option[0]) && isset($option[0]->step2_send_via_email) && $option[0]->step2_send_via_email == 1) { ?> checked <?php } ?>>
                        <div class="w-11 h-6 bg-surface-container-high peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#b34020]"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between py-4 border-b border-surface-container-high">
                    <div>
                        <h3 class="text-title-md font-semibold text-on-surface">SMS Notification</h3>
                        <p class="text-body-md text-on-surface-variant mt-1">Receive immediate text messages on your registered mobile number for every transaction.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" name="sms_notification" id="sms_notification" value="1" <?php if(isset($option[0]) && isset($option[0]->step2_send_via_sms) && $option[0]->step2_send_via_sms == 1) { ?> checked <?php } ?>>
                        <div class="w-11 h-6 bg-surface-container-high peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#b34020]"></div>
                    </label>
                </div>

                <div class="mt-lg flex justify-end">
                    <button type="submit" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-8 rounded-lg transition-colors flex items-center gap-2">
                        <span>Save Preferences</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
      
<!-- footer -->
@include('footer')
<!-- // footer -->
