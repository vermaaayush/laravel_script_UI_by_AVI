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
            <span class="text-on-surface font-medium">PIN Update</span>
        </div>
        <h2 class="text-display-lg font-display-lg text-on-surface mb-xs">Account PIN Update</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant">Securely update your account PIN.</p>
    </div>

    <!-- Main Container -->
    <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
        <div class="p-lg">
            <div class="bg-error-container text-on-error-container p-4 rounded-lg mb-6" id="passwordUpdateError" style="display:none;"></div>
            
            <form id="form-wizard1" class="password-update-form">
                <!-- Step 1: User ID -->
                <fieldset id="pin_step_1" class="text-left">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-on-surface-variant mb-2">Your User ID</label>
                        <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="user_id" id="user_id" required value="{{ Session::get('user_id') ?? ($customer[0]->user_id ?? '') }}" />
                    </div>
                    <div class="mt-lg flex justify-end">
                        <button type="button" id="firstForm" name="next" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-8 rounded-lg transition-colors">Submit</button>
                    </div>
                </fieldset>

                <!-- Step 2: New PIN -->
                <fieldset id="pin_step_2" class="text-left" style="display: none;">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-on-surface-variant mb-2">New Account PIN</label>
                        <input type="password" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="pin" id="pin" required value="" placeholder="Enter 4-6 digit PIN" />
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-on-surface-variant mb-2">Confirm Account PIN</label>
                        <input type="password" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" name="confirm_pin" id="confirm_pin" required value="" placeholder="Confirm PIN" />
                    </div>
                    <div class="mt-lg flex justify-end">
                        <button type="button" id="secondForm" name="next" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-8 rounded-lg transition-colors">Submit</button>
                    </div>
                </fieldset>

                <!-- Step 3: OTP -->
                <fieldset id="pin_step_3" class="text-left" style="display: none;">
                    <div class="mb-8 text-center">
                        <h3 class="text-title-lg font-semibold text-on-surface mb-2">Enter OTP</h3>
                        <p class="text-body-md text-on-surface-variant">We have sent you a Token OTP! Please enter it to proceed.</p>
                    </div>
                    <div class="mb-6">
                        <input type="text" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all text-center tracking-widest text-lg" name="otp" id="otp" required value="" placeholder="Enter OTP here">
                    </div>
                    <div class="mt-lg flex justify-end">
                        <button type="button" id="thirdForm" name="next" class="bg-[#b34020] hover:bg-[#b34020]/90 text-white font-semibold py-3 px-8 rounded-lg transition-colors w-full sm:w-auto">Submit</button>
                    </div>
                    <div class="mt-8 p-4 bg-surface-container-low rounded-lg border border-outline-variant/30">
                        <p class="text-sm text-on-surface-variant text-center">Entering the wrong OTP more than 3 times will lead to suspension of the account. If you have any problems with acquiring the OTP, please contact your account Officer or visit our nearest branch.</p>
                    </div>
                </fieldset>

                <!-- Step 4: Success -->
                <fieldset id="pin_step_4" class="text-center" style="display: none;">
                    <div class="py-12 flex flex-col items-center">
                        <span class="material-symbols-outlined text-[80px] text-[#137333] mb-4">check_circle</span>
                        <h2 class="text-headline-sm font-semibold text-on-surface mb-2">SUCCESS!</h2>
                        <p class="text-body-lg text-on-surface-variant">Your PIN has been successfully updated.</p>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
      
<!-- footer -->
@include('footer')
<!-- // footer -->
