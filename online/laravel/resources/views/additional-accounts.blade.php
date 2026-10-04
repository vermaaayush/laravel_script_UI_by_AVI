<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
                <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">Custody Portal</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#191c1c] font-bold">New Custody Facility</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Open Secondary Custody Account</h1>
            <p class="text-sm text-[#53625b] mt-1">Apply for a secondary checking, savings, or investment account with instant KYC validation.</p>
        </div>
        <a href="{{ asset('accounts-summary') }}" class="px-4 py-2 rounded-xl bg-white border border-[#e6e9e8] text-[#53625b] text-xs font-semibold hover:bg-[#f8faf9] transition-colors shadow-sm flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Accounts Overview</span>
        </a>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-[#e6e9e8] shadow-sm">
        <form action="{{ asset('additional-accounts-save') }}" method="post" id="formAdditional" class="space-y-8">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />

            <!-- Section 1: Personal Details -->
            <div>
                <h4 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-[#004226] text-white flex items-center justify-center text-xs font-bold">1</span>
                    <span>Account Holder Identity</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Full Legal Name</label>
                        <input type="text" name="fullname" required placeholder="e.g. Johnathan Doe" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] font-semibold focus:bg-white focus:border-[#004226] focus:ring-1 focus:ring-[#004226] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">National ID / Passport Number (*)</label>
                        <input type="text" name="idnumber" required placeholder="Tax ID or National Identification" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] font-mono focus:bg-white focus:border-[#004226] focus:ring-1 focus:ring-[#004226] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Date of Birth</label>
                        <input type="date" name="dob" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] font-mono focus:bg-white focus:border-[#004226] focus:ring-1 focus:ring-[#004226] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Mother's Maiden Name</label>
                        <input type="text" name="mother_maiden" required placeholder="Verification security token" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] focus:ring-1 focus:ring-[#004226] outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Section 2: Contact Information -->
            <div class="pt-6 border-t border-[#f2f4f3]">
                <h4 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-[#004226] text-white flex items-center justify-center text-xs font-bold">2</span>
                    <span>Contact & Registered Domicile</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Email Address</label>
                        <input type="email" name="email" id="email" required placeholder="client@example.com" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] focus:ring-1 focus:ring-[#004226] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Phone Number</label>
                        <div class="flex gap-2">
                            <select name="code" id="code" required class="w-2/5 bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-2.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none cursor-pointer"></select>
                            <input type="text" name="phone" id="phone" required placeholder="Phone number" class="w-3/5 bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] font-mono focus:bg-white focus:border-[#004226] outline-none">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Residential Street Address</label>
                        <input type="text" name="address" required placeholder="Apartment, suite, unit, street address" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">City</label>
                        <input type="text" name="city" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">State / Province</label>
                        <input type="text" name="state" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Country / Jurisdiction</label>
                        <select name="country" id="country" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none cursor-pointer"></select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Postal / Zip Code</label>
                        <input type="text" name="zip" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] font-mono focus:bg-white focus:border-[#004226] outline-none">
                    </div>
                </div>
            </div>

            <!-- Section 3: Limits & Security Questions -->
            <div class="pt-6 border-t border-[#f2f4f3]">
                <h4 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-[#004226] text-white flex items-center justify-center text-xs font-bold">3</span>
                    <span>Limits, Advisor & Security Configuration</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Requested Maximum Daily Cap</label>
                        <input type="text" name="max_amount" required placeholder="e.g. 50,000" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] font-mono font-bold focus:bg-white focus:border-[#004226] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Dedicated Account Concierge</label>
                        <select name="am" id="am" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none cursor-pointer">
                            <option value="">Select Account Manager</option>
                            @foreach ($ams as $am)
                                <option value="{{ $am->id }}">{{ $am->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Security Question 1</label>
                        <select name="security_ques1" id="security_ques1" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none cursor-pointer">
                            <option value="">Select Security Question 1</option>
                            @foreach ($security_questions as $ques)
                                <option value="{{ $ques->question }}">{{ $ques->question }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Answer 1</label>
                        <input type="text" name="answer1" id="answer1" required placeholder="Your answer" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Security Question 2</label>
                        <select name="security_ques2" id="security_ques2" required class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none cursor-pointer">
                            <option value="">Select Security Question 2</option>
                            @foreach ($security_questions as $ques)
                                <option value="{{ $ques->question }}">{{ $ques->question }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Answer 2</label>
                        <input type="text" name="answer2" id="answer2" required placeholder="Your answer" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none">
                    </div>
                </div>
            </div>

            <!-- Verification OTP Container -->
            <div id="otpContainer" class="pt-6 border-t border-[#f2f4f3] hidden">
                <div class="p-4 bg-[#e8f7ee] rounded-xl border border-[#aaf2c4] mb-4">
                    <span class="text-xs font-bold text-[#004226] block mb-1">Dual-Channel Authorization PIN</span>
                    <p class="text-[11.5px] text-[#004226]">Enter the verification codes sent to your registered phone and email address.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Phone Verification PIN</label>
                        <input type="text" name="phone_otp" id="phone_otp" placeholder="Enter phone PIN" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-1.5">Email Verification PIN</label>
                        <input type="text" name="email_otp" id="email_otp" placeholder="Enter email PIN" class="w-full bg-[#f8faf9] border border-[#e6e9e8] rounded-xl px-3.5 py-2.5 text-xs text-[#191c1c] focus:bg-white focus:border-[#004226] outline-none font-mono">
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            <div id="alertFormKava" class="p-3.5 bg-rose-50 text-rose-800 rounded-xl border border-rose-200 text-xs font-semibold hidden"></div>
            <div id="alertFormKavaSuccess" class="p-3.5 bg-[#e8f7ee] text-[#004226] rounded-xl border border-[#aaf2c4] text-xs font-semibold hidden"></div>

            <!-- Submit -->
            <div class="pt-6 border-t border-[#f2f4f3] flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-[#53625b]">By continuing, you agree to our Commercial Banking Terms & Disclosures.</p>
                <button type="submit" id="btnformAdditional" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">verified_user</span>
                    <span>Submit Application</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
var codes = {"AF":{"country":"Afghanistan","dial_code":"93"},"AL":{"country":"Albania","dial_code":"355"},"DZ":{"country":"Algeria","dial_code":"213"},"US":{"country":"United States","dial_code":"1"},"GB":{"country":"United Kingdom","dial_code":"44"},"CA":{"country":"Canada","dial_code":"1"},"AU":{"country":"Australia","dial_code":"61"},"DE":{"country":"Germany","dial_code":"49"},"FR":{"country":"France","dial_code":"33"},"IT":{"country":"Italy","dial_code":"39"},"ES":{"country":"Spain","dial_code":"34"},"CH":{"country":"Switzerland","dial_code":"41"},"NL":{"country":"Netherlands","dial_code":"31"},"SG":{"country":"Singapore","dial_code":"65"},"AE":{"country":"United Arab Emirates","dial_code":"971"},"PL":{"country":"Poland","dial_code":"48"},"SE":{"country":"Sweden","dial_code":"46"},"NO":{"country":"Norway","dial_code":"47"},"DK":{"country":"Denmark","dial_code":"45"},"IE":{"country":"Ireland","dial_code":"353"},"IN":{"country":"India","dial_code":"91"},"ZA":{"country":"South Africa","dial_code":"27"},"NG":{"country":"Nigeria","dial_code":"234"},"BR":{"country":"Brazil","dial_code":"55"},"MX":{"country":"Mexico","dial_code":"52"},"JP":{"country":"Japan","dial_code":"81"},"NZ":{"country":"New Zealand","dial_code":"64"}};

document.addEventListener('DOMContentLoaded', function(){
    var content = '<option value="">Country</option>';
    for(var code in codes) {
        content += '<option value="'+codes[code].country+'">'+codes[code].country+'</option>';
    }
    $('#country').append(content);
    var dialOptions = '<option value="">Code</option>';
    for(var code in codes) {
        dialOptions += '<option value="+'+codes[code].dial_code+'">+'+codes[code].dial_code+' (' + codes[code].country + ')</option>';
    }
    $('#code').append(dialOptions);
});

var otpPhone = "";
var otpEmail = "";
$(function(){
    $('#formAdditional').submit(function(e){
        $('#alertFormKava').hide();
        $('#otpContainer').removeClass('hidden');
        if(otpPhone == ""){
            sendOtp();
            return false;
        } else {
            if($('#phone_otp').val() != otpPhone){
                $('#alertFormKava').html('Phone PIN does not match. Please verify.').show();
                $('#phone_otp').focus();
                return false;
            } else if($('#email_otp').val() != otpEmail){
                $('#alertFormKava').html('Email PIN does not match. Please verify.').show();
                $('#email_otp').focus();
                return false;
            } else {
                $('#alertFormKava').hide();
                return true;
            }
        }
    });
});

function sendOtp(){
    if($('#loading').length) $('#loading').show();
    var url = "{{ asset('additional-accounts-sendpin') }}";
    $.ajax({
        url: url,
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            code :  $('#code').val(),  
            phone : $('#phone').val(),
            email : $('#email').val()
        },
        dataType:"json",
        success: function(res) {
            if($('#loading').length) $('#loading').hide();
            $('#alertFormKavaSuccess').html('Security PIN sent to your phone and email.').show();
            setTimeout(function() { $('#alertFormKavaSuccess').hide(); }, 5000);
            otpPhone = res.otpPhone;
            otpEmail = res.otpEmail;
        },
        error: function() {
            if($('#loading').length) $('#loading').hide();
            $('#alertFormKava').html('Unable to generate PIN. Please review your contact information.').show();
        }
    });
}
</script>

@include('footer')
