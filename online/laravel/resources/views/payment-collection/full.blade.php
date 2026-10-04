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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors flex items-center gap-1" href="{{ url('/') }}">
                <span class="material-symbols-outlined text-[14px]">home</span> Custody Portal
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#53625b]">Payment & Collection</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Paid Invoices</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Paid & Settled Invoices</h1>
                <p class="text-sm text-[#53625b] mt-1">Archive of all settled accounts receivable and cleared invoice remittances.</p>
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4] rounded-xl text-xs font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span>
                    <span>Fully Cleared</span>
                </span>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Invoice List -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-[#f2f4f3] flex items-center justify-between bg-[#f8faf9]">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#004226] text-[20px]">task_alt</span>
                <h3 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Settlement Archive</h3>
            </div>
            <span class="text-xs font-mono text-[#53625b]">Archived Records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] text-[11px] font-bold text-[#53625b] uppercase tracking-wider border-b border-[#f2f4f3]">
                        <th class="py-3.5 px-6">Settled Date</th>
                        <th class="py-3.5 px-6">Invoice Number</th>
                        <th class="py-3.5 px-6">Total Settled</th>
                        <th class="py-3.5 px-6">Description / Memo</th>
                        <th class="py-3.5 px-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f4f3] text-sm">
                    <?php $fullCount = 0; ?>
                    @foreach($list as $single)
                    @if($single->paid == $single->price)
                    <?php $fullCount++; ?>
                    <tr class="hover:bg-[#f8faf9] transition-colors">
                        <td class="py-4 px-6 text-xs font-mono text-[#53625b]">
                            <?= date("d M Y", strtotime($single->dt)); ?>
                        </td>
                        <td class="py-4 px-6 font-bold text-[#191c1c] font-mono">
                            <?= $single->name ?>
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-[#191c1c]">
                            <?= $single->currency ?> <?= number_format($single->price, 2) ?>
                        </td>
                        <td class="py-4 px-6 text-xs text-[#53625b]">
                            <?= $single->descr ?>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span> Fully Paid
                            </span>
                        </td>
                    </tr>
                    @endif
                    @endforeach

                    @if($fullCount == 0)
                    <tr>
                        <td colspan="5" class="py-12 text-center text-[#53625b]">
                            <span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-2">inventory_2</span>
                            <p class="text-sm font-semibold text-[#191c1c]">No Settled Invoices</p>
                            <p class="text-xs text-[#53625b] mt-0.5">Cleared invoices will appear in this ledger after remittance.</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
