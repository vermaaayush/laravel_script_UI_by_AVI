<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="flex flex-col w-full gap-5 pb-12 font-sans">
    
    <!-- Page Actions Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-surface-container">
        <div>
            <h1 class="font-heading font-bold text-2xl sm:text-3xl tracking-tight text-on-surface">Transactions & Settlement History</h1>
            <p class="text-xs sm:text-sm text-secondary mt-1">Real-time ledger of multi-currency wire transfers, settlements, and treasury operations.</p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ url('account-statement') }}" class="inline-flex items-center gap-2 bg-surface-container-lowest text-on-surface hover:bg-surface-container text-xs font-semibold px-4 py-2.5 rounded-xl border border-outline-variant/30 shadow-sm transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px] text-secondary">download</span>
                <span>Export Statement</span>
            </a>
            <a href="{{ url('transfer-to-other-bank') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-container text-on-primary text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>New Wire Transfer</span>
            </a>
        </div>
    </div>

    <!-- Search & Filter Controls Toolbar -->
    <div class="bg-surface-container-lowest rounded-2xl p-4 border border-outline-variant/30 shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
        <!-- Counterparty Search Input -->
        <div class="relative flex-1 min-w-[280px]">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-[20px]">search</span>
            <input class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low rounded-xl text-xs text-on-surface placeholder:text-secondary focus:outline-none focus:bg-surface-container-lowest border border-outline-variant/20 transition-colors" 
                   id="ledger-search-input" 
                   oninput="filterLedger(this.value)" 
                   placeholder="Search by counterparty, reference ID, IBAN, or narration..." 
                   type="text"/>
        </div>
        <!-- Filter Buttons and Selects -->
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ asset('account-statement') }}" class="flex items-center gap-1.5 px-3 py-2 bg-surface-container-low hover:bg-surface-container rounded-xl text-on-surface text-xs font-semibold cursor-pointer border border-outline-variant/20 transition-colors">
                <span class="material-symbols-outlined text-[17px] text-secondary">calendar_today</span>
                <span>Select Date Range</span>
            </a>
            <select id="typeFilter" onchange="filterByType(this.value)" class="bg-surface-container-low rounded-xl text-xs text-on-surface font-semibold px-3 py-2 border border-outline-variant/20 focus:outline-none cursor-pointer">
                <option value="">All Transaction Types</option>
                <option value="credited">Credits Only</option>
                <option value="debited">Debits Only</option>
                <option value="charges">Operational Charges</option>
            </select>
            <button onclick="resetLedgerFilters()" class="text-secondary hover:text-on-surface text-xs font-semibold px-2 py-1 transition-colors" type="button">
                Reset
            </button>
        </div>
    </div>

    <!-- Main Content Table Card -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-4 flex items-center justify-between bg-surface-container-low/50 border-b border-surface-container">
            <div class="flex items-center gap-3">
                <span class="font-heading font-bold text-sm text-on-surface">Settlement Audit Trail</span>
                <span class="px-2.5 py-0.5 rounded-full bg-surface-container text-secondary text-[11px] font-semibold">
                    {{ count($transactions) }} Total Records
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-secondary">Auto-sync:</span>
                <span class="w-2 h-2 rounded-full bg-primary inline-block animate-pulse"></span>
                <span class="text-xs text-primary font-bold">Live Feed</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/30 text-secondary text-xs uppercase font-semibold tracking-wider border-b border-surface-container">
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Reference ID</th>
                        <th class="py-3 px-4">Narration / Counterparty</th>
                        <th class="py-3 px-4 text-right">Debit (-)</th>
                        <th class="py-3 px-4 text-right">Credit (+)</th>
                        <th class="py-3 px-4 text-right">Running Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container text-xs" id="ledger-table-body">
                    @forelse($transactions as $row)
                        @php
                            $currncyN = DB::table('ba_user_accounts')->where('account_no',$row->act_number)->first(); 
                            $crnCy = $currncyN ? $currncyN->account_currency : "$"; 
                            $isDebit = ($row->type == 'debited' || $row->type == 'charges');
                        @endphp
                        <tr class="ledger-row hover:bg-surface-container-low transition-colors group" data-type="{{ strtolower($row->type) }}">
                            <td class="py-3.5 px-4 text-secondary whitespace-nowrap font-medium">
                                <?= date("d M Y", strtotime($row->datetime)); ?>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($isDebit)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-error-container text-error capitalize">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                        {{ $row->type }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-primary-fixed text-primary capitalize">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                        Credited
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono text-secondary">{{ $row->tran_id }}</td>
                            <td class="py-3.5 px-4 font-heading font-semibold text-on-surface">{{ $row->reason }}</td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-error">
                                @if($isDebit)
                                    -{{ $crnCy }} {{ number_format($row->amount, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-primary">
                                @if(!$isDebit)
                                    +{{ $crnCy }} {{ number_format($row->amount, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-on-surface">
                                {{ $crnCy }} {{ number_format($row->balance, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-secondary">
                                <span class="material-symbols-outlined text-[36px] text-outline mb-2">receipt_long</span>
                                <p class="text-sm font-semibold text-on-surface">No transaction records found</p>
                                <p class="text-xs text-secondary mt-1">Settlements will appear here once executed on your account.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 flex items-center justify-between text-secondary text-xs border-t border-surface-container bg-surface-container-low/20">
            <span>Showing verified cryptographic ledger transactions</span>
            <div class="flex items-center gap-2">
                <a href="{{ asset('account-statement') }}" class="text-primary font-bold hover:underline">Download Official Statement</a>
            </div>
        </div>
    </div>

</div>

<!-- Footer -->
@include('footer')

<script>
    function filterLedger(query) {
        const q = query.toLowerCase();
        const rows = document.querySelectorAll('.ledger-row');
        rows.forEach(r => {
            const text = r.innerText.toLowerCase();
            r.style.display = text.includes(q) ? '' : 'none';
        });
    }

    function filterByType(type) {
        const rows = document.querySelectorAll('.ledger-row');
        rows.forEach(r => {
            if (!type) {
                r.style.display = '';
            } else {
                const rType = r.getAttribute('data-type');
                r.style.display = (rType === type.toLowerCase()) ? '' : 'none';
            }
        });
    }

    function resetLedgerFilters() {
        document.getElementById('ledger-search-input').value = '';
        document.getElementById('typeFilter').value = '';
        const rows = document.querySelectorAll('.ledger-row');
        rows.forEach(r => r.style.display = '');
    }
</script>
