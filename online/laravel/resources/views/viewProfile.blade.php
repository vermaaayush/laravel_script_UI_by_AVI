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
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
            <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">Custody Portal</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#191c1c] font-bold">Client Identity & Credentials</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Profile & Identity Overview</h1>
                <p class="text-sm text-[#53625b] mt-1">Review legal identity records, dedicated relationship concierge, and certified institutional parameters.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ url('editProfile') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#004226] hover:bg-[#0f5b38] text-white text-xs font-bold transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">edit_note</span>
                    <span>Update Record</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: User Card & Relationship Officer -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <!-- User Information Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] overflow-hidden">
                <div class="p-5 border-b border-[#f2f4f3] flex items-center justify-between">
                    <span class="text-xs font-bold text-[#53625b] uppercase tracking-wider">Account Holder</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#e8f7ee] text-[#004226] border border-[#aaf2c4]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span>
                        FINMA Tier 1 Verified
                    </span>
                </div>
                <div class="p-6 flex flex-col items-center text-center">
                    <?php if(Session::get('cust_photo') == ""){
                        $imgPro = asset('exasset/user.png');
                    }else{
                        $imgPro = "https://".Session::get('bank_url')."/admin/uploads/".Session::get('cust_photo');
                    }
                    ?>
                    <div class="mb-4 relative">
                        <img src="<?= $imgPro ?>" onerror="this.src='{{ asset('exasset/user.png') }}';" class="w-28 h-28 rounded-full object-cover shadow-sm border-4 border-[#f2f4f3]" alt="user">
                        <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-[#004226] text-white flex items-center justify-center border-2 border-white" title="Verified Custody Entity">
                            <span class="material-symbols-outlined text-[14px]">verified_user</span>
                        </div>
                    </div> 
                    <h3 class="text-lg font-bold font-headline text-[#191c1c]">{{$cust_name}}</h3>
                    <p class="text-xs font-mono text-[#53625b] mt-0.5 tracking-wider">CLIENT UID: {{$customer_id}}</p>

                    <div class="w-full mt-6 space-y-3 text-left">
                        <div class="flex items-center gap-3 p-3.5 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <div class="w-9 h-9 rounded-lg bg-white border border-[#e6e9e8] flex items-center justify-center text-[#004226] shrink-0">
                                <span class="material-symbols-outlined text-[18px]">mail</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] uppercase font-bold text-[#53625b] tracking-wider">Primary Email</p>
                                <p class="text-xs font-semibold text-[#191c1c] truncate">{{ $email ?? ($customer[0]->cust_email ?? 'N/A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3.5 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <div class="w-9 h-9 rounded-lg bg-white border border-[#e6e9e8] flex items-center justify-center text-[#004226] shrink-0">
                                <span class="material-symbols-outlined text-[18px]">phone_iphone</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] uppercase font-bold text-[#53625b] tracking-wider">Mobile Number</p>
                                <p class="text-xs font-semibold text-[#191c1c] font-mono">{{ $cust_phone_country_code ?? '' }} {{ $cust_phone ?? ($customer[0]->cust_phone ?? 'N/A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3.5 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <div class="w-9 h-9 rounded-lg bg-white border border-[#e6e9e8] flex items-center justify-center text-[#004226] shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[18px]">home_pin</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] uppercase font-bold text-[#53625b] tracking-wider">Registered Domicile</p>
                                <p class="text-xs font-semibold text-[#191c1c] leading-relaxed">{{ $address ?? ($customer[0]->cust_address ?? '') }}, {{ $country ?? ($customer[0]->cust_country ?? '') }}, {{ $postcode ?? ($customer[0]->post_code ?? '') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manager Information Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] overflow-hidden">
                <div class="p-5 border-b border-[#f2f4f3] flex items-center justify-between">
                    <span class="text-xs font-bold text-[#53625b] uppercase tracking-wider">Private Client Desk</span>
                    <span class="material-symbols-outlined text-[18px] text-[#004226]">support_agent</span>
                </div>
                <div class="p-6 flex flex-col items-center text-center">
                    <div class="mb-3">
                        <img src="<?= (isset($manager) && !empty($manager)) ? $manager[0]->photo : asset('exasset/user.png') ?>" onerror="this.src='{{ asset('exasset/user.png') }}';" class="w-18 h-18 rounded-full object-cover shadow-sm border-2 border-[#e6e9e8]" alt="manager">
                    </div> 
                    <h4 class="text-base font-bold font-headline text-[#191c1c]"><?= (isset($manager) && !empty($manager)) ? $manager[0]->name : 'Private Client Desk' ?></h4>
                    <p class="text-xs text-[#53625b] mb-4">Dedicated Institutional Concierge</p>

                    <div class="w-full space-y-2 text-xs">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#f8faf9] border border-[#e6e9e8]">
                            <span class="text-[#53625b] font-medium">Direct Telephone</span>
                            <span class="font-bold text-[#191c1c] font-mono"><?= (isset($manager) && !empty($manager)) ? ($manager[0]->countrycode ?? '') . ($manager[0]->phone ?? '') : '—' ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#f8faf9] border border-[#e6e9e8]">
                            <span class="text-[#53625b] font-medium">Direct Inquiries</span>
                            <span class="font-semibold text-[#004226]"><?= (isset($manager) && !empty($manager)) ? ($manager[0]->email ?? '') : 'support@bank.institutional' ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Account Details Grid -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-[#e6e9e8] overflow-hidden">
                <div class="p-6 border-b border-[#f2f4f3] flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-headline text-[#191c1c]">Credential & Compliance Parameters</h2>
                        <p class="text-xs text-[#53625b] mt-0.5">Encrypted institutional metadata verified against banking KYC registries.</p>
                    </div>
                    <span class="material-symbols-outlined text-[#004226]">verified</span>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <p class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider mb-1">Date of Birth</p>
                            <p class="text-sm font-bold text-[#191c1c] font-mono">{{ $dob ?? 'Verified' }}</p>
                        </div>
                        
                        <div class="p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <p class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider mb-1">Mother's Maiden Name</p>
                            <p class="text-sm font-bold text-[#191c1c] font-mono tracking-widest">••••••••••</p>
                        </div>
                        
                        <div class="p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <p class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider mb-1">User Identifier (UID)</p>
                            <p class="text-sm font-bold text-[#191c1c] font-mono">{{ $user_id ?? (Session::get('u_id') ?? '1') }}</p>
                        </div>
                        
                        <div class="p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8]">
                            <p class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider mb-1">Customer Client ID</p>
                            <p class="text-sm font-bold text-[#191c1c] font-mono">{{ $customer_id ?? '1' }}</p>
                        </div>

                        <div class="p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8] md:col-span-2">
                            <p class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider mb-1">Security Question 1</p>
                            <p class="text-sm font-semibold text-[#191c1c]">{{ $q1 ?? 'Configured' }}</p>
                        </div>

                        <div class="p-4 bg-[#f8faf9] rounded-xl border border-[#e6e9e8] md:col-span-2">
                            <p class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider mb-1">Security Question 2</p>
                            <p class="text-sm font-semibold text-[#191c1c]">{{ $q2 ?? 'Configured' }}</p>
                        </div>
                    </div>

                    <!-- Limit Banner -->
                    <div class="mt-6 p-6 rounded-2xl bg-gradient-to-br from-[#004226] via-[#084e30] to-[#012d1a] text-white relative overflow-hidden shadow-md">
                        <div class="absolute -right-8 -bottom-8 w-40 h-40 rounded-full bg-[#aaf2c4]/15 blur-3xl pointer-events-none"></div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white/10 border border-[#aaf2c4]/30 flex items-center justify-center text-[#aaf2c4] shrink-0">
                                    <span class="material-symbols-outlined text-[24px]">account_balance_wallet</span>
                                </div>
                                <div>
                                    <p class="text-[11px] font-semibold text-[#8fd6a9] uppercase tracking-wider">Authorized Daily Settlement Cap</p>
                                    <p class="text-2xl font-bold font-mono tracking-tight text-white mt-0.5">
                                        {{ Session::get('account_currency') ?? 'JPY' }} {{ number_format($max_amount ?? 50000, 2) }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ url('request-limit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#aaf2c4] hover:bg-[#8fd6a9] text-[#004226] text-xs font-bold transition-all shadow-sm">
                                    <span>Request Limit Adjustment</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- // Page Content -->

<!-- footer -->
@include('footer')
<!-- // footer -->
