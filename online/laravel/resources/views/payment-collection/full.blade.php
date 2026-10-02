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
            <span class="text-slate-400">Payment & Collection</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Paid Invoices</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Paid & Settled Invoices</h1>
                <p class="text-sm text-slate-500 mt-1">Archive of all settled accounts receivable and cleared invoice remittances.</p>
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-xl text-xs font-bold uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Fully Cleared
                </span>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Invoice List -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">task_alt</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Settlement Archive</h3>
            </div>
            <span class="text-xs text-slate-400">Archived Records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Settled Date</th>
                        <th class="py-3.5 px-6">Invoice Number</th>
                        <th class="py-3.5 px-6">Total Settled</th>
                        <th class="py-3.5 px-6">Description / Memo</th>
                        <th class="py-3.5 px-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php $fullCount = 0; ?>
                    @foreach($list as $single)
                    @if($single->paid == $single->price)
                    <?php $fullCount++; ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 text-xs font-mono text-slate-500">
                            <?= date("d M Y", strtotime($single->dt)); ?>
                        </td>
                        <td class="py-4 px-6 font-bold text-slate-900 font-mono">
                            <?= $single->name ?>
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-slate-900">
                            <?= $single->currency ?> <?= number_format($single->price, 2) ?>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            <?= $single->descr ?>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Fully Paid
                            </span>
                        </td>
                    </tr>
                    @endif
                    @endforeach

                    @if($fullCount == 0)
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">inventory_2</span>
                            <p class="text-sm font-semibold text-slate-600">No Settled Invoices</p>
                            <p class="text-xs text-slate-400 mt-0.5">Cleared invoices will appear in this ledger after remittance.</p>
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
