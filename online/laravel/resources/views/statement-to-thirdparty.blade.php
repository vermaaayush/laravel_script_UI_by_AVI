<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
                <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">Custody Portal</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#191c1c] font-bold">Statement Transmission</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Third-Party Statement Dispatch</h1>
            <p class="text-sm text-[#53625b] mt-1">Direct cryptographically sealed custody statements to audited external entities or tax authorities.</p>
        </div>
        <a href="{{ asset('account-statement') }}" class="px-4 py-2 rounded-xl bg-white border border-[#e6e9e8] text-[#53625b] text-xs font-semibold hover:bg-[#f8faf9] transition-colors shadow-sm flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>View Statements</span>
        </a>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-[#e6e9e8] shadow-sm">
        <div class="p-4 bg-[#e8f7ee] rounded-xl border border-[#aaf2c4] mb-6 flex items-start gap-3">
            <span class="material-symbols-outlined text-[#004226] shrink-0 text-[20px] mt-0.5">verified_user</span>
            <p class="text-xs text-[#004226] leading-relaxed">
                Third-party dispatches are transmitted via direct secure channels with an institutional verification checksum, FINMA-sealed watermark, and hash audit trail.
            </p>
        </div>

        <form class="needs-validation space-y-5" role="form" method="POST" action="{{ asset('send-statement-to-thirdparty') }}" id="statement-to-thirdparty-form">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Destination Type -->
                <div>
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Delivery Channel <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] font-semibold outline-none cursor-pointer appearance-none" name="destination" id="destination" required>
                            <option value="">-- Select Destination Method --</option>
                            <option value="email">Direct Verified Email</option>
                            <option value="fax">Institutional Secure Fax</option>
                            <option value="address">Courier Physical Dispatch</option>
                            <option value="sms">SMS Cryptographic Digest</option>
                            <option value="whatsapp">Secure Messaging Channel</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#53625b]">expand_more</span>
                    </div>
                </div>

                <!-- Dynamic Target Input Fields -->
                <div class="email-div" style="display: none;">
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Recipient Email Address</label>
                    <input type="email" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] outline-none" name="email" id="email" placeholder="compliance@auditor.com">
                </div>

                <div class="fax-div" style="display: none;">
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Recipient Fax Number</label>
                    <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] outline-none" name="fax" id="fax" placeholder="+1 (555) 000-0000">
                </div>

                <div class="address-div" style="display: none;">
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Mailing Address</label>
                    <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] outline-none" name="address" id="address" placeholder="Attention To, Street, City, Country">
                </div>

                <div class="sms-div" style="display: none;">
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Mobile Phone</label>
                    <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] outline-none" name="sms" id="sms" placeholder="+1 555 123 4567">
                </div>

                <div class="whatsapp-div" style="display: none;">
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">WhatsApp Channel Number</label>
                    <input type="text" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] outline-none" name="whatsapp" id="whatsapp" placeholder="+1 555 987 6543">
                </div>

                <!-- Source Account -->
                <div>
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Statement Custody Vault <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] font-semibold font-mono outline-none cursor-pointer appearance-none" name="account" id="account" required>
                            <option value="">-- Select Source Account --</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" data-account-title="{{ $account->account_title }}">
                                    {{ $account->account_no }} ({{ $account->account_currency }} {{ number_format($account->available_balance, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-[#53625b]">expand_more</span>
                    </div>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Statement Start Date</label>
                    <input type="date" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] outline-none font-mono" name="start_date" id="start_date" required value="{{ date('Y-m-01') }}">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#53625b] uppercase tracking-wider mb-2">Statement End Date</label>
                    <input type="date" class="w-full bg-[#f8faf9] border border-[#e6e9e8] focus:border-[#004226] focus:ring-1 focus:ring-[#004226] rounded-xl px-4 py-3 text-xs text-[#191c1c] outline-none font-mono" name="end_date" id="end_date" required value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-6 border-t border-[#f2f4f3] flex items-center justify-between">
                <span class="text-xs text-[#53625b]">Encrypted 256-Bit SSL Transfer &bull; FINMA Compliant</span>
                <button type="submit" class="px-7 py-3 rounded-xl bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">send</span>
                    <span>Dispatch Statement</span>
                </button>
            </div>
        </form>
    </div>
</div>

@include('footer')
