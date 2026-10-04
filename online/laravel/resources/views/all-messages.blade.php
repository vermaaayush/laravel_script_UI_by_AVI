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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">Custody Portal</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Secure Communications</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Communications Center</h1>
                <p class="text-sm text-[#53625b] mt-1">Direct encrypted ledger correspondence with your relationship manager and institutional custody desk.</p>
            </div>
            <div>
                <a href="{{ url('send-message') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">edit_square</span>
                    <span>Compose Transmission</span>
                </a>
            </div>
        </div>
        
        <div class="mt-4">
            @include('flash::message')
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] p-4 sticky top-6">
                <nav class="flex flex-col gap-1.5" id="msgTabs">
                    <button type="button" onclick="switchMsgTab('mail-inbox', this)" class="msg-nav-btn active flex items-center justify-between px-4 py-3 rounded-xl text-xs font-bold transition-all bg-[#004226] text-white">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[18px]">inbox</span>
                            <span>Secure Inbox</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-white/20 text-white">{{ count($inbox ?? []) }}</span>
                    </button>

                    <button type="button" onclick="switchMsgTab('mail-sent', this)" class="msg-nav-btn flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold text-[#53625b] hover:bg-[#f8faf9] hover:text-[#191c1c] transition-all">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            <span>Transmitted</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-[#f2f4f3] text-[#53625b]">{{ count($sent ?? []) }}</span>
                    </button>

                    <button type="button" onclick="switchMsgTab('mail-trash', this)" class="msg-nav-btn flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold text-[#53625b] hover:bg-[#f8faf9] hover:text-[#191c1c] transition-all">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            <span>Archived / Trash</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-[#f2f4f3] text-[#53625b]">{{ count($trash ?? []) }}</span>
                    </button>
                </nav>

                <div class="mt-6 pt-6 border-t border-[#f2f4f3]">
                    <div class="p-3.5 bg-[#f8faf9] rounded-xl border border-[#e6e9e8] text-xs">
                        <div class="flex items-center gap-2 text-[#004226] font-bold mb-1">
                            <span class="material-symbols-outlined text-[16px]">verified_user</span>
                            <span>FINMA Protocol</span>
                        </div>
                        <p class="text-[11px] text-[#53625b] leading-relaxed">Transmissions are retained in an immutable encrypted store for statutory compliance.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-9">
            <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] overflow-hidden min-h-[520px]">
                
                <!-- Inbox Tab -->
                <div id="mail-inbox" class="msg-tab-panel block">
                    <div class="p-4 sm:p-5 border-b border-[#f2f4f3] bg-[#f8faf9] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Custody Inbox</span>
                            <span class="text-[11px] text-[#53625b]">({{ count($inbox ?? []) }} records)</span>
                        </div>
                        <div class="text-[11px] font-semibold text-[#53625b]">Encrypted AES-256</div>
                    </div>

                    @if(count($inbox ?? []) > 0)
                        <div class="divide-y divide-[#f2f4f3]">
                            @foreach($inbox as $row)
                                <div class="p-5 hover:bg-[#f8faf9] transition-colors group cursor-pointer" onclick="toggleMsgDetail('inbox-detail-{{ $row->id }}')">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-start sm:items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-xl bg-[#e8f7ee] border border-[#aaf2c4] text-[#004226] flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-[18px]">account_balance</span>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="text-xs font-bold text-[#191c1c]">{{ $row->sender ?? 'Bank Support Desk' }}</span>
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#e8f7ee] text-[#004226]">Official</span>
                                                </div>
                                                <h4 class="text-sm font-semibold text-[#191c1c] truncate mt-0.5 group-hover:text-[#004226] transition-colors">{{ $row->subject }}</h4>
                                                <p class="text-xs text-[#53625b] truncate max-w-xl">{{ strip_tags($row->msg) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0 justify-between sm:justify-end">
                                            <span class="text-xs font-mono text-[#53625b]"><?= date("d M Y", strtotime($row->date)) ?></span>
                                            <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                                <a href="{{ asset('delete-msg/' . $row->id) }}" class="p-1.5 rounded-lg text-[#53625b] hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </a>
                                                <a href="{{ url('send-message') }}" class="p-1.5 rounded-lg text-[#53625b] hover:text-[#004226] hover:bg-[#e8f7ee] transition-colors" title="Reply">
                                                    <span class="material-symbols-outlined text-[18px]">reply</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Expandable Message Detail -->
                                    <div id="inbox-detail-{{ $row->id }}" class="hidden mt-4 pt-4 border-t border-[#f2f4f3] bg-[#f8faf9] p-4 rounded-xl text-left" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-between text-xs text-[#53625b] mb-3 pb-2 border-b border-[#e6e9e8]">
                                            <div>
                                                <span class="font-bold text-[#191c1c]">From:</span> {{ $row->sender }} | 
                                                <span class="font-bold text-[#191c1c]">To:</span> {{ $row->receiver }}
                                                @if(!empty($row->cc)) | <span class="font-bold text-[#191c1c]">CC:</span> {{ $row->cc }} @endif
                                            </div>
                                            <span class="font-mono"><?= date("d F Y, H:i", strtotime($row->date)) ?></span>
                                        </div>
                                        <div class="text-xs text-[#191c1c] leading-relaxed mb-4 whitespace-pre-line">
                                            {!! $row->msg !!}
                                        </div>
                                        @if(!empty($row->file))
                                            <div class="pt-3 border-t border-[#e6e9e8]">
                                                <p class="text-[10px] font-bold text-[#53625b] uppercase tracking-wider mb-2">Encrypted Attachments:</p>
                                                <div class="flex flex-wrap gap-2">
                                                    <?php $file_arr = explode(",", $row->file); ?>
                                                    @foreach($file_arr as $file)
                                                        @if(trim($file) != '')
                                                            <a href="uploads/{{ trim($file) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-[#e6e9e8] text-xs font-semibold text-[#004226] hover:bg-[#e8f7ee] transition-colors">
                                                                <span class="material-symbols-outlined text-[16px]">attachment</span>
                                                                <span>{{ trim($file) }}</span>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center p-16 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-[#f2f4f3] text-[#53625b] flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-[32px]">mark_email_read</span>
                            </div>
                            <h3 class="text-base font-bold font-headline text-[#191c1c] mb-1">Your Inbox is Clear</h3>
                            <p class="text-xs text-[#53625b] max-w-sm mb-6">No new communications or operational notices received from your banking desk.</p>
                            <a href="{{ url('send-message') }}" class="px-5 py-2.5 rounded-xl bg-[#004226] text-white text-xs font-bold hover:bg-[#0f5b38] transition-all">
                                Transmit Message
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Sent Tab -->
                <div id="mail-sent" class="msg-tab-panel hidden">
                    <div class="p-4 sm:p-5 border-b border-[#f2f4f3] bg-[#f8faf9] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Sent Dispatches</span>
                            <span class="text-[11px] text-[#53625b]">({{ count($sent ?? []) }} records)</span>
                        </div>
                        <div class="text-[11px] font-semibold text-[#53625b]">Authenticated Outbox</div>
                    </div>

                    @if(count($sent ?? []) > 0)
                        <div class="divide-y divide-[#f2f4f3]">
                            @foreach($sent ?? [] as $row)
                                <div class="p-5 hover:bg-[#f8faf9] transition-colors group cursor-pointer" onclick="toggleMsgDetail('sent-detail-{{ $row->id }}')">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-start sm:items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-xl bg-[#f2f4f3] text-[#53625b] flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-[18px]">send</span>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="text-xs font-bold text-[#191c1c]">To: {{ $row->receiver_name ?? $row->receiver }}</span>
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#f2f4f3] text-[#53625b]">Dispatched</span>
                                                </div>
                                                <h4 class="text-sm font-semibold text-[#191c1c] truncate mt-0.5 group-hover:text-[#004226] transition-colors">{{ $row->subject }}</h4>
                                                <p class="text-xs text-[#53625b] truncate max-w-xl">{{ strip_tags($row->msg) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0 justify-between sm:justify-end">
                                            <span class="text-xs font-mono text-[#53625b]"><?= date("d M Y", strtotime($row->date)) ?></span>
                                            <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                                <a href="{{ asset('delete-msg/' . $row->id) }}" class="p-1.5 rounded-lg text-[#53625b] hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Expandable Message Detail -->
                                    <div id="sent-detail-{{ $row->id }}" class="hidden mt-4 pt-4 border-t border-[#f2f4f3] bg-[#f8faf9] p-4 rounded-xl text-left" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-between text-xs text-[#53625b] mb-3 pb-2 border-b border-[#e6e9e8]">
                                            <div>
                                                <span class="font-bold text-[#191c1c]">To:</span> {{ $row->receiver }}
                                                @if(!empty($row->cc)) | <span class="font-bold text-[#191c1c]">CC:</span> {{ $row->cc }} @endif
                                            </div>
                                            <span class="font-mono"><?= date("d F Y, H:i", strtotime($row->date)) ?></span>
                                        </div>
                                        <div class="text-xs text-[#191c1c] leading-relaxed mb-4 whitespace-pre-line">
                                            {!! $row->msg !!}
                                        </div>
                                        @if(!empty($row->file))
                                            <div class="pt-3 border-t border-[#e6e9e8]">
                                                <p class="text-[10px] font-bold text-[#53625b] uppercase tracking-wider mb-2">Attached Documents:</p>
                                                <div class="flex flex-wrap gap-2">
                                                    <?php $file_arr = explode(",", $row->file); ?>
                                                    @foreach($file_arr as $file)
                                                        @if(trim($file) != '')
                                                            <a href="uploads/{{ trim($file) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-[#e6e9e8] text-xs font-semibold text-[#004226] hover:bg-[#e8f7ee] transition-colors">
                                                                <span class="material-symbols-outlined text-[16px]">attachment</span>
                                                                <span>{{ trim($file) }}</span>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center p-16 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-[#f2f4f3] text-[#53625b] flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-[32px]">send</span>
                            </div>
                            <h3 class="text-base font-bold font-headline text-[#191c1c] mb-1">No Sent Communications</h3>
                            <p class="text-xs text-[#53625b] max-w-sm mb-6">You have not transmitted any messages through the electronic desk.</p>
                            <a href="{{ url('send-message') }}" class="px-5 py-2.5 rounded-xl bg-[#004226] text-white text-xs font-bold hover:bg-[#0f5b38] transition-all">
                                Compose New Message
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Trash Tab -->
                <div id="mail-trash" class="msg-tab-panel hidden">
                    <div class="p-4 sm:p-5 border-b border-[#f2f4f3] bg-[#f8faf9] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Archived / Trash</span>
                            <span class="text-[11px] text-[#53625b]">({{ count($trash ?? []) }} records)</span>
                        </div>
                        <div class="text-[11px] font-semibold text-[#53625b]">Deleted Ledger</div>
                    </div>

                    @if(count($trash ?? []) > 0)
                        <div class="divide-y divide-[#f2f4f3]">
                            @foreach($trash ?? [] as $row)
                                <div class="p-5 hover:bg-[#f8faf9] transition-colors group">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-start sm:items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-bold text-[#191c1c]">{{ $row->subject }}</span>
                                                </div>
                                                <p class="text-xs text-[#53625b] truncate max-w-xl mt-0.5">{{ strip_tags($row->msg) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0 justify-between sm:justify-end">
                                            <span class="text-xs font-mono text-[#53625b]"><?= date("d M Y", strtotime($row->date)) ?></span>
                                            <a href="{{ asset('undelete-msg/' . $row->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#e8f7ee] text-[#004226] text-xs font-bold hover:bg-[#aaf2c4] transition-colors" title="Restore to Inbox">
                                                <span class="material-symbols-outlined text-[16px]">restore</span>
                                                <span>Restore</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center p-16 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-[#f2f4f3] text-[#53625b] flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-[32px]">delete_sweep</span>
                            </div>
                            <h3 class="text-base font-bold font-headline text-[#191c1c] mb-1">Trash is Empty</h3>
                            <p class="text-xs text-[#53625b] max-w-sm">No deleted communications in the retention buffer.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
<!-- end content -->

<script>
function switchMsgTab(tabId, btn) {
    document.querySelectorAll('.msg-tab-panel').forEach(function(el) {
        el.classList.add('hidden');
        el.classList.remove('block');
    });
    var target = document.getElementById(tabId);
    if(target) {
        target.classList.remove('hidden');
        target.classList.add('block');
    }

    document.querySelectorAll('.msg-nav-btn').forEach(function(el) {
        el.classList.remove('bg-[#004226]', 'text-white', 'active');
        el.classList.add('text-[#53625b]', 'hover:bg-[#f8faf9]', 'hover:text-[#191c1c]');
        var count = el.querySelector('span:last-child');
        if(count) {
            count.classList.remove('bg-white/20', 'text-white');
            count.classList.add('bg-[#f2f4f3]', 'text-[#53625b]');
        }
    });

    btn.classList.add('bg-[#004226]', 'text-white', 'active');
    btn.classList.remove('text-[#53625b]', 'hover:bg-[#f8faf9]', 'hover:text-[#191c1c]');
    var activeCount = btn.querySelector('span:last-child');
    if(activeCount) {
        activeCount.classList.remove('bg-[#f2f4f3]', 'text-[#53625b]');
        activeCount.classList.add('bg-white/20', 'text-white');
    }
}

function toggleMsgDetail(detailId) {
    var el = document.getElementById(detailId);
    if(el) {
        el.classList.toggle('hidden');
    }
}
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
