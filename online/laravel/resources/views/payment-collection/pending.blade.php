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
            <span class="text-[#191c1c] font-bold">Pending Invoices</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Pending Invoices</h1>
                <p class="text-sm text-[#53625b] mt-1">Review outstanding invoices awaiting settlement.</p>
            </div>
            <div>
                <a href="{{ url('pay-invoice') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[16px]">payments</span>
                    <span>Pay Invoices</span>
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Invoice List -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-[#f2f4f3] flex items-center justify-between bg-[#f8faf9]">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#004226] text-[20px]">receipt_long</span>
                <h3 class="text-xs font-bold text-[#191c1c] uppercase tracking-wider">Awaiting Settlement</h3>
            </div>
            <span class="text-xs font-mono text-[#53625b]">{{ count($list) }} Invoices</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] text-[11px] font-bold text-[#53625b] uppercase tracking-wider border-b border-[#f2f4f3]">
                        <th class="py-3.5 px-6">Issue Date</th>
                        <th class="py-3.5 px-6">Invoice Number</th>
                        <th class="py-3.5 px-6">Amount Due</th>
                        <th class="py-3.5 px-6">Description / Memo</th>
                        <th class="py-3.5 px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f4f3] text-sm">
                    @forelse($list as $single)
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
                            <a href="{{ url('pay-invoice') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-colors">
                                <span>Pay Now</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-[#53625b]">
                            <span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-2">receipt</span>
                            <p class="text-sm font-semibold text-[#191c1c]">No Pending Invoices</p>
                            <p class="text-xs text-[#53625b] mt-0.5">All billing statements have been settled in full.</p>
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
