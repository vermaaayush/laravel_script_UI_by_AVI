<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-7xl mx-auto w-full pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Overview
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-secondary">Cards</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Manage Cards</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Payment Cards & Treasury Limits</h1>
                <p class="text-sm text-secondary mt-1">Manage physical and virtual corporate debit cards, limits, and security locks.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('update-card-pin') }}" class="px-4 py-2.5 rounded-full border border-outline-variant/30 bg-surface-container-lowest hover:bg-surface-container text-on-surface text-xs font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1.5 shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">password</span> Change PIN
                </a>
                <a href="{{ url('request-card') }}" class="px-5 py-2.5 rounded-full bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider shadow-md transition-colors inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">add_card</span> Request Card
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Visual Card Showcase (Stitch Screen 2 Exact Realistic Matte Physical Card) -->
    @if(count($cards) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($cards as $card)
        <div class="relative overflow-hidden rounded-3xl p-6 text-white shadow-xl flex flex-col justify-between h-56 transition-all duration-300 hover:scale-[1.02] {{ $card->status == 3 ? 'bg-gradient-to-tr from-slate-900 via-slate-800 to-slate-950 opacity-60' : 'bg-gradient-to-tr from-[#191c1c] via-[#242826] to-[#004226] border border-white/10' }}">
            <div class="absolute -right-12 -top-12 w-44 h-44 rounded-full bg-primary-fixed/10 blur-2xl pointer-events-none"></div>
            
            <!-- Top Card Row -->
            <div class="flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <span class="font-heading text-xs font-bold tracking-wider text-primary-fixed uppercase">{{ $card->card_type ?? 'Sovereign Debit' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    @if($card->status == 0)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-secondary-container text-on-secondary-container">Pending</span>
                    @elseif($card->status == 1)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-fixed text-primary">Active</span>
                    @elseif($card->status == 2)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300">Suspended</span>
                    @elseif($card->status == 3)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-error-container text-error">Blocked</span>
                    @endif
                </div>
            </div>

            <!-- EMV Chip & Contactless -->
            <div class="flex items-center gap-3 z-10 my-auto">
                <div class="w-10 h-7 rounded bg-amber-200/90 shadow-inner flex items-center justify-center">
                    <div class="w-7 h-5 border border-amber-900/40 rounded-sm"></div>
                </div>
                <span class="material-symbols-outlined text-[22px] text-primary-fixed">contactless</span>
            </div>

            <!-- Card Number & Holder -->
            <div class="z-10">
                <p class="font-mono text-base sm:text-lg font-bold tracking-[0.2em] text-white/90">
                    {{ $card->card_number ? chunk_split($card->card_number, 4, ' ') : '4829 •••• •••• 9201' }}
                </p>
                <div class="flex items-end justify-between mt-2 pt-2 border-t border-white/10">
                    <div>
                        <span class="text-[9px] text-white/50 uppercase tracking-widest block">Account</span>
                        <span class="text-xs font-mono font-semibold text-white/90">{{ $card->cust_act_number }}</span>
                    </div>
                    <span class="font-heading font-extrabold text-xs text-primary-fixed tracking-widest uppercase">OripioFin</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Cards Data Table -->
    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-surface-container flex items-center justify-between bg-surface-container-low/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">credit_card</span>
                <h3 class="text-sm font-heading font-bold text-on-surface uppercase tracking-wide">Card Directory</h3>
            </div>
            <span class="text-xs text-secondary">Manage security status and restrictions</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/30 text-secondary text-xs font-semibold uppercase tracking-wider border-b border-surface-container">
                        <th class="py-3.5 px-6">Account No</th>
                        <th class="py-3.5 px-6">Card Type</th>
                        <th class="py-3.5 px-6">Card Number</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6">Comment / Notes</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container text-xs">
                    @forelse($cards as $card)
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-on-surface">
                            {{ $card->cust_act_number }}
                        </td>
                        <td class="py-4 px-6 font-semibold text-secondary">
                            {{ $card->card_type }}
                        </td>
                        <td class="py-4 px-6 font-mono text-xs text-secondary">
                            {{ $card->card_number ? chunk_split($card->card_number, 4, ' ') : 'Processing...' }}
                        </td>
                        <td class="py-4 px-6">
                            @if($card->status == 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-secondary-container text-on-secondary-container">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Pending
                                </span>
                            @elseif($card->status == 1)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-fixed text-primary">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Active
                                </span>
                            @elseif($card->status == 2)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Suspended
                                </span>
                            @elseif($card->status == 3)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-error-container text-error">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Blocked
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-xs text-secondary">
                            {{ $card->message ?? '—' }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center justify-end gap-2">
                                @if($card->status != 3)
                                    <a href="{{ asset('block-card/' . $card->id) }}" class="px-3 py-1.5 rounded-lg border border-error/30 bg-error-container text-error text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Are you sure you want to block this card? This action cannot be easily reversed.');">
                                        <span class="material-symbols-outlined text-[14px]">block</span> Block
                                    </a>
                                @endif

                                @if($card->status != 2)
                                    <a href="{{ asset('suspend-card/' . $card->id) }}" class="px-3 py-1.5 rounded-lg border border-outline-variant/30 bg-surface-container-low text-secondary hover:text-on-surface text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Are you sure you want to suspend this card?');">
                                        <span class="material-symbols-outlined text-[14px]">pause_circle</span> Suspend
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-secondary">
                            <span class="material-symbols-outlined text-[40px] text-outline block mb-2">credit_card_off</span>
                            <p class="text-sm font-semibold text-on-surface">No Cards Issued</p>
                            <p class="text-xs text-secondary mt-0.5">You currently do not have any cards linked to your accounts.</p>
                            <a href="{{ url('request-card') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary hover:bg-primary-container text-on-primary text-xs font-bold uppercase tracking-wider rounded-xl transition-colors shadow-sm">
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
        <div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden p-6 text-center bg-surface-container-lowest">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[32px]">support_agent</span>
            </div>
            <h3 class="text-lg font-heading font-bold text-on-surface mb-2">Request In Progress</h3>
            <p class="text-xs text-secondary leading-relaxed mb-6">
                Processing is currently underway. A dedicated card representative will contact you within the next 2 business days.
            </p>
            <button type="button" class="w-full py-3 bg-primary text-on-primary rounded-xl text-xs font-bold uppercase tracking-wider" data-dismiss="modal">
                Acknowledge
            </button>
        </div>
    </div>
</div>

@include('footer')
