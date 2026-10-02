<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Dispatch Statement</h2>
            <p class="text-sm text-slate-500 mt-0.5">Securely forward encrypted bank statements directly to audit, tax, or third-party institutions.</p>
        </div>
        <a href="{{ asset('account-statement') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[17px]">arrow_back</span>
            <span>View Statements</span>
        </a>
    </div>

    @include('flash::message')

    <!-- Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card">
        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200/80 mb-6 flex items-start gap-3">
            <span class="material-symbols-outlined text-amber-600 shrink-0">mark_email_read</span>
            <p class="text-xs text-amber-900 leading-relaxed">
                Third-party dispatches are transmitted via direct secure channels with an institutional verification checksum and digital watermark.
            </p>
        </div>

        <form class="needs-validation space-y-5" role="form" method="POST" action="{{ asset('send-statement-to-thirdparty') }}" id="statement-to-thirdparty-form">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Destination Type -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Delivery Channel</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:border-slate-800 outline-none cursor-pointer" name="destination" id="destination" required>
                        <option value="">-- Select Destination Method --</option>
                        <option value="email">Direct Verified Email</option>
                        <option value="fax">Institutional Fax</option>
                        <option value="address">Courier Physical Dispatch</option>
                        <option value="sms">SMS Digest</option>
                        <option value="whatsapp">Secure WhatsApp Channel</option>
                    </select>
                </div>

                <!-- Dynamic Target Input Fields -->
                <div class="email-div" style="display: none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Recipient Email Address</label>
                    <input type="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="email" id="email" placeholder="recipient@entity.com">
                </div>

                <div class="fax-div" style="display: none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Recipient Fax Number</label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="fax" id="fax" placeholder="+1 (555) 000-0000">
                </div>

                <div class="address-div" style="display: none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mailing Address</label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="address" id="address" placeholder="Attention To, Street, City, Country">
                </div>

                <div class="sms-div" style="display: none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mobile Phone</label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="sms" id="sms" placeholder="+1 555 123 4567">
                </div>

                <div class="whatsapp-div" style="display: none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Mobile Number</label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="whatsapp" id="whatsapp" placeholder="+1 555 987 6543">
                </div>

                <!-- Source Account -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Statement Account</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-medium focus:bg-white focus:border-slate-800 outline-none cursor-pointer font-mono" name="account" id="account" required>
                        <option value="">-- Select Source Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" data-account-title="{{ $account->account_title }}">
                                {{ $account->account_no }} ({{ $account->account_currency }} {{ number_format($account->available_balance, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Start Date</label>
                    <input type="date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="start_date" id="start_date" required value="{{ date('Y-m-01') }}">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">End Date</label>
                    <input type="date" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none" name="end_date" id="end_date" required value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Encrypted 256-Bit SSL Transfer</span>
                <button type="submit" class="px-7 py-3 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span>Dispatch Statement</span>
                </button>
            </div>
        </form>
    </div>
</div>

@include('footer')
