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
                <span class="text-[#191c1c] font-bold">Relationship Concierge</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Dedicated Account Officer</h1>
            <p class="text-sm text-[#53625b] mt-1">Your private client banker and institutional relationship concierge.</p>
        </div>
        <a href="{{ asset('accounts-summary') }}" class="px-4 py-2 rounded-xl bg-white border border-[#e6e9e8] text-[#53625b] text-xs font-semibold hover:bg-[#f8faf9] transition-colors shadow-sm flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Accounts</span>
        </a>
    </div>

    <!-- Manager Profile Card -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-[#e6e9e8] shadow-sm">
        <div class="p-4 bg-[#e8f7ee] rounded-xl border border-[#aaf2c4] mb-6 flex items-start gap-3">
            <span class="material-symbols-outlined text-[#004226] shrink-0 text-[20px] mt-0.5">verified_user</span>
            <p class="text-xs text-[#004226] leading-relaxed">
                As a designated client, your personal portfolio officer is available during institutional market hours to assist with wire authorization, liquidity management, credit facilities, and wealth consulting.
            </p>
        </div>

        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 pt-2">
            <!-- Photo / Avatar -->
            <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-2xl overflow-hidden border-2 border-[#e6e9e8] shrink-0 shadow-sm relative">
                @if(isset($am[0]) && !empty($am[0]->photo))
                    <img src="{{ $am[0]->photo }}" class="w-full h-full object-cover" alt="Account Manager">
                @else
                    <div class="w-full h-full bg-[#f8faf9] text-[#004226] flex flex-col items-center justify-center">
                        <span class="material-symbols-outlined text-5xl">person</span>
                    </div>
                @endif
                <div class="absolute bottom-2 right-2 w-4 h-4 bg-[#004226] rounded-full border-2 border-white" title="Active on desk"></div>
            </div>

            <!-- Details -->
            <div class="flex-1 text-center md:text-left space-y-4">
                <div>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold uppercase bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4] mb-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span>
                        Senior Private Banker
                    </span>
                    <h3 class="text-xl sm:text-2xl font-bold font-headline text-[#191c1c] tracking-tight">
                        @if(isset($am[0])) {{ $am[0]->name }} @else Senior Relationship Desk @endif
                    </h3>
                    <p class="text-xs text-[#53625b] font-medium">Equitable Commercial Banking Division</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div class="p-3.5 rounded-xl bg-[#f8faf9] border border-[#e6e9e8] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-[#e6e9e8] shadow-sm flex items-center justify-center text-[#004226]">
                            <span class="material-symbols-outlined text-[18px]">phone</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-[#53625b] font-bold block uppercase tracking-wider">Direct Telephone</span>
                            <span class="font-bold text-[#191c1c] font-mono">
                                @if(isset($am[0])) {{ $am[0]->countrycode . " " . $am[0]->phone }} @else Direct Support Line @endif
                            </span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-[#f8faf9] border border-[#e6e9e8] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-[#e6e9e8] shadow-sm flex items-center justify-center text-[#004226]">
                            <span class="material-symbols-outlined text-[18px]">mail</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-[#53625b] font-bold block uppercase tracking-wider">Official Inquiries</span>
                            <span class="font-bold text-[#191c1c] truncate block max-w-[180px]">
                                @if(isset($am[0])) {{ $am[0]->email }} @else support@bank.com @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex flex-wrap items-center justify-center md:justify-start gap-3">
                    @if(isset($am[0]) && !empty($am[0]->email))
                        <a href="mailto:{{ $am[0]->email }}" class="px-5 py-2.5 rounded-xl bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">mail</span>
                            <span>Direct Email</span>
                        </a>
                    @endif
                    <a href="{{ asset('send-message') }}" class="px-5 py-2.5 rounded-xl bg-[#f2f4f3] hover:bg-[#e6e9e8] text-[#191c1c] text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">forum</span>
                        <span>Portal Secure Message</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
