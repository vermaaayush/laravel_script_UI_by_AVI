<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Cards</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Manage Cards</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Payment Cards</h1>
                <p class="text-sm text-slate-500 mt-1">Manage physical and virtual debit/credit cards, limits, and security locks.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('update-card-pin') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">password</span> Change PIN
                </a>
                <a href="{{ url('request-card') }}" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-colors inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">add_card</span> Request Card
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Visual Card Showcase (if user has cards) -->
    @if(count($cards) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($cards as $card)
        <div class="relative overflow-hidden rounded-3xl p-6 text-white shadow-xl flex flex-col justify-between h-56 transition-all duration-300 hover:-translate-y-1 {{ $card->status == 3 ? 'bg-gradient-to-br from-slate-800 to-slate-950 opacity-60' : 'bg-gradient-to-br from-[#121620] via-[#1a202c] to-[#0f131a] border border-slate-700/60' }}">
            <div class="absolute -right-12 -top-12 w-44 h-44 rounded-full bg-primary/20 blur-2xl pointer-events-none"></div>
            
            <!-- Top Card Row -->
            <div class="flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs font-bold uppercase tracking-wider text-slate-300">{{ $card->card_type ?? 'Debit Card' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    @if($card->status == 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Pending</span>
                    @elseif($card->status == 1)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Active</span>
                    @elseif($card->status == 2)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Suspended</span>
                    @elseif($card->status == 3)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">Blocked</span>
                    @endif
                </div>
            </div>

            <!-- EMV Chip & Contactless -->
            <div class="flex items-center gap-3 z-10 my-auto">
                <div class="w-11 h-8 rounded-lg bg-gradient-to-tr from-amber-400 to-amber-200 border border-amber-500/60 shadow-inner flex items-center justify-center">
                    <div class="w-7 h-5 border border-amber-700/40 rounded-sm"></div>
                </div>
                <span class="material-symbols-outlined text-[20px] text-slate-400 rotate-90">contactless</span>
            </div>

            <!-- Card Number & Holder -->
            <div class="z-10">
                <p class="font-mono text-base sm:text-lg font-bold tracking-[0.2em] text-white">
                    {{ $card->card_number ? chunk_split($card->card_number, 4, ' ') : '•••• •••• •••• ••••' }}
                </p>
                <div class="flex items-end justify-between mt-2 pt-2 border-t border-slate-700/50">
                    <div>
                        <span class="text-[9px] text-slate-400 uppercase tracking-widest block">Account</span>
                        <span class="text-xs font-mono font-semibold text-slate-200">{{ $card->cust_act_number }}</span>
                    </div>
                    <span class="font-black text-xs text-primary tracking-widest uppercase">EQUITY BANK</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Cards Data Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">credit_card</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Card Ledger</h3>
            </div>
            <span class="text-xs text-slate-400">Manage security status and restrictions</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Account No</th>
                        <th class="py-3.5 px-6">Card Type</th>
                        <th class="py-3.5 px-6">Card Number</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6">Comment / Notes</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($cards as $card)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-slate-800">
                            {{ $card->cust_act_number }}
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-700">
                            {{ $card->card_type }}
                        </td>
                        <td class="py-4 px-6 font-mono text-xs text-slate-600">
                            {{ $card->card_number ? chunk_split($card->card_number, 4, ' ') : 'Processing...' }}
                        </td>
                        <td class="py-4 px-6">
                            @if($card->status == 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                </span>
                            @elseif($card->status == 1)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                </span>
                            @elseif($card->status == 2)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Suspended
                                </span>
                            @elseif($card->status == 3)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Blocked
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-500">
                            {{ $card->message ?? '—' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center justify-end gap-2">
                                @if($card->status != 3)
                                    <a href="{{ asset('block-card/' . $card->id) }}" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Are you sure you want to block this card? This action cannot be easily reversed.');">
                                        <span class="material-symbols-outlined text-[14px]">block</span> Block
                                    </a>
                                @endif

                                @if($card->status != 2)
                                    <a href="{{ asset('suspend-card/' . $card->id) }}" class="px-3 py-1.5 rounded-lg border border-amber-200 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Are you sure you want to suspend this card?');">
                                        <span class="material-symbols-outlined text-[14px]">pause_circle</span> Suspend
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">credit_card_off</span>
                            <p class="text-sm font-semibold text-slate-600">No Cards Issued</p>
                            <p class="text-xs text-slate-400 mt-0.5">You currently do not have any cards linked to your accounts.</p>
                            <a href="{{ url('request-card') }}" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-colors">
                                <span class="material-symbols-outlined text-[16px]">add_card</span> Request Your First Card
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmPopup" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden p-6 text-center">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[32px]">support_agent</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Request In Progress</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                Processing is currently underway. A dedicated card representative will contact you within the next 2 business days.
            </p>
            <button type="button" class="w-full py-3 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider" data-dismiss="modal">
                Acknowledge
            </button>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
