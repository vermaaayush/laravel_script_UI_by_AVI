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
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Dedicated Account Officer</h2>
            <p class="text-sm text-slate-500 mt-0.5">Your private client banker and dedicated commercial relationship manager.</p>
        </div>
        <a href="{{ asset('accounts-summary') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[17px]">arrow_back</span>
            <span>Accounts</span>
        </a>
    </div>

    <!-- Manager Profile Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card">
        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200/80 mb-6 flex items-start gap-3">
            <span class="material-symbols-outlined text-amber-600 shrink-0">verified_user</span>
            <p class="text-xs text-amber-900 leading-relaxed">
                As a priority client, your personal portfolio officer is available during institutional market hours to assist with wires, credit facilities, limits, and wealth consulting.
            </p>
        </div>

        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 pt-2">
            <!-- Photo / Avatar -->
            <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-3xl overflow-hidden ring-4 ring-slate-100 shrink-0 shadow-sm relative">
                @if(isset($am[0]) && !empty($am[0]->photo))
                    <img src="{{ $am[0]->photo }}" class="w-full h-full object-cover" alt="Account Manager">
                @else
                    <div class="w-full h-full bg-slate-900 text-amber-400 flex flex-col items-center justify-center">
                        <span class="material-symbols-outlined text-5xl">person</span>
                    </div>
                @endif
                <div class="absolute bottom-2 right-2 w-4 h-4 bg-emerald-500 rounded-full ring-2 ring-white"></div>
            </div>

            <!-- Details -->
            <div class="flex-1 text-center md:text-left space-y-4">
                <div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-amber-100 text-amber-800 mb-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        Senior Private Banker
                    </span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        @if(isset($am[0])) {{ $am[0]->name }} @else Senior Relationship Desk @endif
                    </h3>
                    <p class="text-xs text-slate-400 font-medium">Equitable Commercial Banking Division</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700">
                            <span class="material-symbols-outlined text-[18px]">phone</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-semibold block uppercase">Direct Line</span>
                            <span class="font-bold text-slate-800 font-mono">
                                @if(isset($am[0])) {{ $am[0]->countrycode . " " . $am[0]->phone }} @else Direct Support Line @endif
                            </span>
                        </div>
                    </div>

                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700">
                            <span class="material-symbols-outlined text-[18px]">mail</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-semibold block uppercase">Official Email</span>
                            <span class="font-bold text-slate-800 truncate block max-w-[180px]">
                                @if(isset($am[0])) {{ $am[0]->email }} @else support@bank.com @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-2 flex flex-wrap items-center justify-center md:justify-start gap-3">
                    @if(isset($am[0]) && !empty($am[0]->email))
                        <a href="mailto:{{ $am[0]->email }}" class="px-5 py-2.5 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">mail</span>
                            <span>Send Secure Email</span>
                        </a>
                    @endif
                    <a href="{{ asset('send-message') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-2xs flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">forum</span>
                        <span>Send Portal Message</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
