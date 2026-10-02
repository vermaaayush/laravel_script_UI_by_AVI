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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-[#c59b27] transition-colors" href="#">My Account</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-800">Client Profile</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Profile & Identity Overview</h1>
                <p class="text-sm text-slate-500 mt-1">Review legal identity details, dedicated relationship officer, and transaction limits.</p>
            </div>
            <div>
                <a href="{{ url('editProfile') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: User Card & Relationship Officer -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            
            <!-- User Information Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Account Holder</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        KYC Verified
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
                        <img src="<?= $imgPro ?>" onerror="this.src='{{ asset('exasset/user.png') }}';" class="w-28 h-28 rounded-full object-cover shadow-sm border-4 border-slate-50" alt="user">
                    </div> 
                    <h3 class="text-lg font-bold text-slate-900">{{$cust_name}}</h3>
                    <p class="text-xs font-mono text-slate-400 mt-0.5">ID: {{$customer_id}}</p>

                    <div class="w-full mt-6 space-y-3 text-left">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="material-symbols-outlined text-slate-400 text-[20px]">mail</span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Primary Email</p>
                                <p class="text-xs font-semibold text-slate-800 truncate">{{$email}}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="material-symbols-outlined text-slate-400 text-[20px]">phone_iphone</span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Mobile Number</p>
                                <p class="text-xs font-semibold text-slate-800">{{$cust_phone_country_code}}{{$cust_phone}}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="material-symbols-outlined text-slate-400 text-[20px] mt-0.5">home_pin</span>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Registered Address</p>
                                <p class="text-xs font-semibold text-slate-800 leading-relaxed">{{$address}}, {{$country}}, {{$postcode}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manager Information Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Relationship Officer</span>
                </div>
                <div class="p-6 flex flex-col items-center text-center">
                    <div class="mb-3">
                        <img src="<?= $manager?$manager[0]->photo:asset('exasset/user.png') ?>" onerror="this.src='{{ asset('exasset/user.png') }}';" class="w-20 h-20 rounded-full object-cover shadow-sm border-2 border-slate-100" alt="manager">
                    </div> 
                    <h4 class="text-base font-bold text-slate-900"><?= $manager?$manager[0]->name:'Private Client Officer' ?></h4>
                    <p class="text-xs text-slate-500 mb-4">Dedicated Wealth Concierge</p>

                    <div class="w-full space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-400 font-medium">Direct Line</span>
                            <span class="font-semibold text-slate-800 font-mono"><?= $manager?$manager[0]->countrycode:''?><?= $manager?$manager[0]->phone:'' ?></span>
                        </div>
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-50">
                            <span class="text-slate-400 font-medium">Email</span>
                            <span class="font-semibold text-slate-800"><?= $manager?$manager[0]->email :''?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Account Details Grid -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Credential & Security Parameters</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Official compliance metadata associated with your client account.</p>
                    </div>
                    <span class="material-symbols-outlined text-slate-300">verified</span>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="p-4 bg-slate-50/80 rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Date of Birth</p>
                            <p class="text-sm font-bold text-slate-800 font-mono">{{$dob}}</p>
                        </div>
                        
                        <div class="p-4 bg-slate-50/80 rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Mother's Maiden Name</p>
                            <p class="text-sm font-bold text-slate-800 font-mono">••••••••••</p>
                        </div>
                        
                        <div class="p-4 bg-slate-50/80 rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">User Identification (UID)</p>
                            <p class="text-sm font-bold text-slate-800 font-mono">{{$user_id}}</p>
                        </div>
                        
                        <div class="p-4 bg-slate-50/80 rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Customer Client ID</p>
                            <p class="text-sm font-bold text-slate-800 font-mono">{{$customer_id}}</p>
                        </div>

                        <div class="p-4 bg-slate-50/80 rounded-xl border border-slate-200/60 md:col-span-2">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Security Question 1</p>
                            <p class="text-sm font-semibold text-slate-800">{{$q1}}</p>
                        </div>

                        <div class="p-4 bg-slate-50/80 rounded-xl border border-slate-200/60 md:col-span-2">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Security Question 2</p>
                            <p class="text-sm font-semibold text-slate-800">{{$q2}}</p>
                        </div>
                    </div>

                    <!-- Limit Banner -->
                    <div class="mt-6 p-5 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white relative overflow-hidden border border-slate-700">
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 rounded-full bg-[#c59b27]/20 blur-2xl pointer-events-none"></div>
                        <div class="flex items-center justify-between relative z-10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white/10 border border-[#c59b27]/30 flex items-center justify-center text-[#dfbb58]">
                                    <span class="material-symbols-outlined text-[24px]">account_balance_wallet</span>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Maximum Daily Withdrawal Limit</p>
                                    <p class="text-2xl font-bold font-mono tracking-tight text-white mt-0.5">
                                        {{ Session::get('account_currency') ?? 'JPY' }} {{ number_format($max_amount, 2) }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ url('request-limit') }}" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/10 transition-colors">
                                    Request Upgrade
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
