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
            <span class="text-primary font-bold">Pending Invoices</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Pending Invoices</h1>
                <p class="text-sm text-slate-500 mt-1">Review outstanding invoices awaiting settlement.</p>
            </div>
            <div>
                <a href="{{ url('pay-invoice') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">payments</span> Pay Invoices
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Invoice List -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">receipt_long</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Awaiting Payment</h3>
            </div>
            <span class="text-xs text-slate-400">{{ count($list) }} Invoices</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Issue Date</th>
                        <th class="py-3.5 px-6">Invoice Number</th>
                        <th class="py-3.5 px-6">Amount Due</th>
                        <th class="py-3.5 px-6">Description / Memo</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($list as $single)
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
                            <a href="{{ url('pay-invoice') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-colors">
                                <span>Pay Now</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">receipt</span>
                            <p class="text-sm font-semibold text-slate-600">No Pending Invoices</p>
                            <p class="text-xs text-slate-400 mt-0.5">All billing statements have been settled in full.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
