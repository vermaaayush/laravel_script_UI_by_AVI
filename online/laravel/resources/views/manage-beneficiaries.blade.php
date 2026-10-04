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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors flex items-center gap-1" href="{{ url('/') }}">
                <span class="material-symbols-outlined text-[14px]">home</span> Custody Portal
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#53625b]">Settlements & Transfers</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Beneficiary Directory</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Beneficiary Directory</h1>
                <p class="text-sm text-[#53625b] mt-1">Manage verified internal custody counterparties and certified international wire recipients.</p>
            </div>
            <div>
                <a href="add-beneficiaries" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[16px]">person_add</span>
                    <span>Add New Beneficiary</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs font-semibold">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Container -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm overflow-hidden" id="mapAfteraccount">
        <!-- Segmented Tab Bar -->
        <div class="px-6 py-4 border-b border-[#f2f4f3] flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#f8faf9]">
            <div class="flex items-center gap-1.5 bg-[#e6e9e8]/60 p-1 rounded-xl w-fit">
                <button type="button" id="addBeneficiary" onclick="switchTab('same')" class="px-5 py-2 text-xs font-bold rounded-lg transition-all shadow-sm bg-white text-[#191c1c]">
                    <?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> Accounts
                </button>
                <button type="button" id="listBenificiary" onclick="switchTab('other')" class="px-5 py-2 text-xs font-semibold rounded-lg transition-all text-[#53625b] hover:text-[#191c1c]">
                    External / Wire Counterparties
                </button>
            </div>
            <div class="text-xs text-[#53625b]">
                Authorized recipients eligible for instant custody or SWIFT wire settlement
            </div>
        </div>

        <div class="p-6">
            <!-- Same Bank Beneficiaries Tab -->
            <div id="sameBankBeneficiary">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#f8faf9] text-[11px] font-bold text-[#53625b] uppercase tracking-wider border-b border-[#f2f4f3]">
                                <th class="py-3 px-5">Beneficiary Identity</th>
                                <th class="py-3 px-5">Account Number</th>
                                <th class="py-3 px-5">Verification State</th>
                                <th class="py-3 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f2f4f3] text-sm">
                            <?php $sameCount = 0; ?>
                            @foreach ($Ba_beneficiary as $ivr)
                            @if ($ivr->bank_type == '1')
                            <?php $sameCount++; ?>
                            <tr class="hover:bg-[#f8faf9] transition-colors">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-[#e8f7ee] border border-[#aaf2c4] flex items-center justify-center font-bold text-xs text-[#004226]">
                                            {{ strtoupper(substr($ivr->account->account_title ?? 'U', 0, 2)) }}
                                        </div>
                                        <span class="font-bold text-[#191c1c]">{{ $ivr->account->account_title ?? 'Account Holder' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 font-mono font-bold text-[#191c1c]">
                                    {{ $ivr->beneficiary_account }}
                                </td>
                                <td class="py-4 px-5">
                                    @if ($ivr->verification == '1')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span> Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Unverified
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        @if ($ivr->verification == '1')
                                            <a href="del-beneficary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Delete this beneficiary?');">
                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                                <span>Delete</span>
                                            </a>
                                        @else
                                            <a href="edit-beneficiary-same/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-[#e6e9e8] bg-white hover:bg-[#f8faf9] text-[#53625b] text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">edit</span>
                                                <span>Edit</span>
                                            </a>
                                            <a href="success_beneficiary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">verified</span>
                                                <span>Verify</span>
                                            </a>
                                            <a href="del-beneficary/{{$ivr->id}}" class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center" onclick="return confirm('Delete this beneficiary?');" title="Delete">
                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @if($sameCount == 0)
                            <tr>
                                <td colspan="4" class="py-12 text-center text-[#53625b]">
                                    <span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-1">group_off</span>
                                    <p class="text-sm font-semibold text-[#191c1c]">No <?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> Beneficiaries Registered</p>
                                    <p class="text-xs text-[#53625b]">Click "Add New Beneficiary" above to link an internal counterparty.</p>
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
                            <tr class="bg-[#f8faf9] text-[11px] font-bold text-[#53625b] uppercase tracking-wider border-b border-[#f2f4f3]">
                                <th class="py-3 px-5">Name & Bank</th>
                                <th class="py-3 px-5">Account / IBAN</th>
                                <th class="py-3 px-5">Swift / Sort Code</th>
                                <th class="py-3 px-5">Country</th>
                                <th class="py-3 px-5">Status</th>
                                <th class="py-3 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f2f4f3] text-sm">
                            <?php $otherCount = 0; ?>
                            @foreach($Ba_beneficiary as $ivr)
                            @if ($ivr->bank_type == '0')
                            <?php $otherCount++; ?>
                            <tr class="hover:bg-[#f8faf9] transition-colors">
                                <td class="py-4 px-5">
                                    <p class="font-bold text-[#191c1c]">{{ $ivr->beneficiary_name }}</p>
                                    <p class="text-xs text-[#53625b]">{{ $ivr->beneficiary_bank_name }}</p>
                                </td>
                                <td class="py-4 px-5 font-mono text-xs">
                                    <span class="font-bold text-[#191c1c] block">{{ $ivr->beneficiary_account }}</span>
                                    @if($ivr->beneficiary_iban)
                                        <span class="text-[#53625b]">{{ $ivr->beneficiary_iban }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 font-mono text-xs text-[#53625b]">
                                    <div>SWIFT: {{ $ivr->beneficiary_swift ?? 'N/A' }}</div>
                                    @if($ivr->beneficiary_sort_code)
                                        <div class="text-[#53625b]">SORT: {{ $ivr->beneficiary_sort_code }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-xs text-[#191c1c]">
                                    {{ $ivr->beneficiary_country }}
                                </td>
                                <td class="py-4 px-5">
                                    @if ($ivr->verification == '1')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span> Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        @if ($ivr->verification == '1')
                                            <a href="del-beneficary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="return confirm('Delete this beneficiary?');">
                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                                <span>Delete</span>
                                            </a>
                                        @else
                                            <a href="edit-beneficiary/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg border border-[#e6e9e8] bg-white hover:bg-[#f8faf9] text-[#53625b] text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">edit</span>
                                                <span>Edit</span>
                                            </a>
                                            <a href="success_beneficiary_other/{{$ivr->id}}" class="px-3 py-1.5 rounded-lg bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-colors inline-flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">verified</span>
                                                <span>Verify</span>
                                            </a>
                                            <a href="del-beneficary/{{$ivr->id}}" class="p-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition-colors inline-flex items-center" onclick="return confirm('Delete this beneficiary?');" title="Delete">
                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @if($otherCount == 0)
                            <tr>
                                <td colspan="6" class="py-12 text-center text-[#53625b]">
                                    <span class="material-symbols-outlined text-[36px] text-[#53625b]/40 block mb-1">public_off</span>
                                    <p class="text-sm font-semibold text-[#191c1c]">No External Counterparties Registered</p>
                                    <p class="text-xs text-[#53625b]">Add an external bank or international recipient to enable fast wire settlements.</p>
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
            tabSameBtn.className = 'px-5 py-2 text-xs font-bold rounded-lg transition-all shadow-sm bg-white text-[#191c1c]';
            tabOtherBtn.className = 'px-5 py-2 text-xs font-semibold rounded-lg transition-all text-[#53625b] hover:text-[#191c1c]';
        } else {
            paneOther.classList.remove('hidden');
            paneSame.classList.add('hidden');
            tabOtherBtn.className = 'px-5 py-2 text-xs font-bold rounded-lg transition-all shadow-sm bg-white text-[#191c1c]';
            tabSameBtn.className = 'px-5 py-2 text-xs font-semibold rounded-lg transition-all text-[#53625b] hover:text-[#191c1c]';
        }
    }
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
