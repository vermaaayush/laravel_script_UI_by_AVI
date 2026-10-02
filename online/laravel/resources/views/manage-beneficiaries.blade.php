<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Transfers</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Manage Beneficiaries</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Beneficiary Directory</h1>
                <p class="text-sm text-slate-500 mt-1">Manage verified internal recipients and international wire counterparties.</p>
            </div>
            <div>
                <a href="add-beneficiaries" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">person_add</span> Add New Beneficiary
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden" id="mapAfteraccount">
        <!-- Segmented Tab Bar -->
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
            <div class="flex items-center gap-2 bg-slate-200/60 p-1 rounded-2xl w-fit">
                <button type="button" id="addBeneficiary" onclick="switchTab('same')" class="px-5 py-2 text-xs font-bold rounded-xl transition-all shadow-sm bg-white text-slate-900">
                    <?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> Accounts
                </button>
                <button type="button" id="listBenificiary" onclick="switchTab('other')" class="px-5 py-2 text-xs font-bold rounded-xl transition-all text-slate-600 hover:text-slate-900">
                    External / Other Banks
                </button>
            </div>
            <div class="text-xs text-slate-400">
                Authorized recipients eligible for instant or wire transfer
            </div>
        </div>

        <div class="p-6">
            <!-- Same Bank Beneficiaries Tab -->
            <div id="sameBankBeneficiary">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-5">Beneficiary Name</th>
                                <th class="py-3 px-5">Account Number</th>
                                <th class="py-3 px-5">Verification</th>
                                <th class="py-3 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <?php $sameCount = 0; ?>
                            @foreach ($Ba_beneficiary as $ivr)
                            @if ($ivr->bank_type == '1')
                            <?php $sameCount++; ?>
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-xs text-slate-700">
                                            {{ strtoupper(substr($ivr->account->account_title ?? 'U', 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-slate-900">{{ $ivr->account->account_title ?? 'Account Holder' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 font-mono font-semibold text-slate-800">
                                    {{ $ivr->beneficiary_account }}
                                </td>
                                <td class="py-4 px-5">
                                    @if ($ivr->verification == '1')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Non-Verified
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        @if ($ivr->verification == '1')
                                            <a href="del-beneficary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Delete this beneficiary?');">
                                                <span class="material-symbols-outlined text-[14px]">delete</span> Delete
                                            </a>
                                        @else
                                            <a href="edit-beneficiary-same/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">edit</span> Edit
                                            </a>
                                            <a href="success_beneficiary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">verified</span> Verify
                                            </a>
                                            <a href="del-beneficary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Delete this beneficiary?');">
                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @if($sameCount == 0)
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <span class="material-symbols-outlined text-[36px] text-slate-300 block mb-1">group_off</span>
                                    <p class="text-sm font-semibold text-slate-600">No <?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> Beneficiaries</p>
                                    <p class="text-xs text-slate-400">Click "Add New Beneficiary" above to add an internal account recipient.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Other Bank Beneficiaries Tab -->
            <div id="otherBankBeneficiary" class="hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3 px-5">Name & Bank</th>
                                <th class="py-3 px-5">Account / IBAN</th>
                                <th class="py-3 px-5">Swift / Sort Code</th>
                                <th class="py-3 px-5">Country</th>
                                <th class="py-3 px-5">Status</th>
                                <th class="py-3 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <?php $otherCount = 0; ?>
                            @foreach($Ba_beneficiary as $ivr)
                            @if ($ivr->bank_type == '0')
                            <?php $otherCount++; ?>
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-5">
                                    <p class="font-bold text-slate-900">{{ $ivr->beneficiary_name }}</p>
                                    <p class="text-xs text-slate-500">{{ $ivr->beneficiary_bank_name }}</p>
                                </td>
                                <td class="py-4 px-5 font-mono text-xs">
                                    <span class="font-bold text-slate-800 block">{{ $ivr->beneficiary_account }}</span>
                                    @if($ivr->beneficiary_iban)
                                        <span class="text-slate-400">{{ $ivr->beneficiary_iban }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 font-mono text-xs text-slate-600">
                                    <div>SWIFT: {{ $ivr->beneficiary_swift ?? 'N/A' }}</div>
                                    @if($ivr->beneficiary_sort_code)
                                        <div class="text-slate-400">SORT: {{ $ivr->beneficiary_sort_code }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-xs text-slate-700">
                                    {{ $ivr->beneficiary_country }}
                                </td>
                                <td class="py-4 px-5">
                                    @if ($ivr->verification == '1')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        @if ($ivr->verification == '1')
                                            <a href="del-beneficary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Delete this beneficiary?');">
                                                <span class="material-symbols-outlined text-[14px]">delete</span> Delete
                                            </a>
                                        @else
                                            <a href="edit-beneficiary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">edit</span> Edit
                                            </a>
                                            <a href="success_beneficiary_other/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">verified</span> Verify
                                            </a>
                                            <a href="del-beneficary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Delete this beneficiary?');">
                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @if($otherCount == 0)
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <span class="material-symbols-outlined text-[36px] text-slate-300 block mb-1">public_off</span>
                                    <p class="text-sm font-semibold text-slate-600">No External Beneficiaries Found</p>
                                    <p class="text-xs text-slate-400">Add an external bank or international recipient to enable fast wire dispatch.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        const tabSameBtn = document.getElementById('addBeneficiary');
        const tabOtherBtn = document.getElementById('listBenificiary');
        const paneSame = document.getElementById('sameBankBeneficiary');
        const paneOther = document.getElementById('otherBankBeneficiary');

        if (tab === 'same') {
            paneSame.classList.remove('hidden');
            paneOther.classList.add('hidden');
            tabSameBtn.className = 'px-5 py-2 text-xs font-bold rounded-xl transition-all shadow-sm bg-white text-slate-900';
            tabOtherBtn.className = 'px-5 py-2 text-xs font-bold rounded-xl transition-all text-slate-600 hover:text-slate-900';
        } else {
            paneOther.classList.remove('hidden');
            paneSame.classList.add('hidden');
            tabOtherBtn.className = 'px-5 py-2 text-xs font-bold rounded-xl transition-all shadow-sm bg-white text-slate-900';
            tabSameBtn.className = 'px-5 py-2 text-xs font-bold rounded-xl transition-all text-slate-600 hover:text-slate-900';
        }
    }
</script>
<!-- // Page Content -->

<!-- footer -->
@include('footer')
<!-- // footer -->
