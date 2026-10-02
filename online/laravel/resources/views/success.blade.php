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
<div class="max-w-4xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Transfers</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Confirmation</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Transfer Completed</h1>
                <p class="text-sm text-slate-500 mt-1">External wire transmission finalized and recorded on ledger.</p>
            </div>
            <a href="print_summary" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                <span class="material-symbols-outlined text-[18px]">print</span> Print Receipt
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm relative overflow-hidden">
        <!-- Progress bar during initial wire completion -->
        <div id="progress" class="absolute top-0 left-0 w-full h-1.5 bg-slate-100 z-10">
            <div id="bar" class="h-full bg-emerald-500 transition-all duration-300 ease-out" style="width: 80%;"></div>
        </div>

        <!-- Wire Transfer Header -->
        <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">verified</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Transfer To Other Bank</h3>
                    <p class="text-xs text-slate-500"><?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> Foreign / External Wire Network</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-xs font-bold tracking-wide uppercase">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Success
            </span>
        </div>

        <div class="p-6 sm:p-10 flex flex-col items-center">
            <!-- Animated Success Icon / Header -->
            <div class="flex flex-col items-center text-center max-w-md mx-auto mb-8">
                <div class="w-20 h-20 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center text-emerald-600 mb-4 shadow-sm animate-bounce-short">
                    <span class="material-symbols-outlined text-[42px]">check_circle</span>
                </div>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 mb-1">Transaction Authorized</span>
                <h2 class="text-2xl font-black text-slate-900">Funds Transferred Successfully</h2>
                <p class="text-xs text-slate-500 mt-1">Your wire instruction has been processed through the clearance network. A copy of the receipt has been logged to your messages.</p>
            </div>

            <!-- Transaction Summary Card (revealed after progress or default) -->
            <div id="summary" class="w-full text-left" style="display:none;">
                @foreach ($transaction_summary as $t_summary)
                <?php 
                    $x = DB::table('ba_other_transfers')->where('user',$t_summary->user_id)->latest('id')->first();
                    $benefi_name = $x ? DB::table('ba_beneficiary')->where('id',$x->benefe)->first() : null;
                ?>
                <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-6 sm:p-8 mb-6">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200/60 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-[20px]">receipt_long</span>
                            <h4 class="text-sm font-bold text-slate-900 tracking-wide uppercase">Wire Summary</h4>
                        </div>
                        <span class="font-mono text-xs font-semibold px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-slate-700">
                            REF: {{$t_summary->tran_id}}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Transaction Type</p>
                            <p class="text-sm font-bold text-slate-900 capitalize">{{$t_summary->type}}</p>
                        </div>
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Date & Time</p>
                            <p class="text-sm font-bold text-slate-900">{{$t_summary->datetime}}</p>
                        </div>
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Source Account</p>
                            <p class="text-sm font-mono font-bold text-slate-900">{{$acno}}</p>
                        </div>
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200/60">
                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Debited Amount</p>
                            <p class="text-base font-black text-rose-600">-{{$t_summary->amount}}</p>
                        </div>
                    </div>

                    @if($benefi_name)
                    <div class="pt-4 border-t border-slate-200/60">
                        <h5 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-primary">person</span> Beneficiary Details
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="p-3 bg-white/70 rounded-xl border border-slate-200/50">
                                <p class="text-[11px] text-slate-400 font-semibold uppercase">Beneficiary Name</p>
                                <p class="text-sm font-bold text-slate-800">{{$benefi_name->beneficiary_name}}</p>
                            </div>
                            <div class="p-3 bg-white/70 rounded-xl border border-slate-200/50">
                                <p class="text-[11px] text-slate-400 font-semibold uppercase">Beneficiary Bank</p>
                                <p class="text-sm font-bold text-slate-800">{{$benefi_name->beneficiary_bank_name}}</p>
                            </div>
                            <div class="p-3 bg-white/70 rounded-xl border border-slate-200/50">
                                <p class="text-[11px] text-slate-400 font-semibold uppercase">Beneficiary Account</p>
                                <p class="text-sm font-mono font-bold text-slate-800">{{$benefi_name->beneficiary_account}}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-6 pt-4 border-t border-slate-200/60 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Remaining Available Balance</span>
                        <span class="text-lg font-black text-slate-900 font-mono">
                            <?= number_format($balance, 2, '.', ',') ?>
                        </span>
                    </div>
                </div>
                @endforeach

                <!-- Security Badges & Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center gap-4 opacity-75">
                        <img src="images/page-img/entrust_ssl.png" class="h-8 object-contain" alt="Entrust">
                        <img src="images/page-img/norton_lifelock.png" class="h-5 object-contain" alt="Norton">
                        <span class="text-[11px] text-slate-400">256-bit TLS Encrypted Clearance</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/online') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                            Return to Dashboard
                        </a>
                        <a href="print_summary" target="_blank" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-colors flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">print</span> Print
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- // Page Content -->

<script>
    function openModal(id){
        $('.bankPopup'+id).modal('show');
    }
</script>

<script>
    var trans_summary = document.getElementById('summary');
    var progress = document.getElementById("progress");
    var i = 0;

    window.onload = function move() {
      if (i == 0) {
        i = 1;
        var elem = document.getElementById("bar");
        var width = 80;
        var id = setInterval(frame, 20);
        function frame() {
          if (width >= 100) {
            clearInterval(id);
            i = 0;
            setTimeout(function() {
                trans_summary.style.display = "block";
                progress.style.display = "none";
            }, 600);
          } else {
            width++;
            elem.style.width = width + "%";
          }
        }
      }
    }
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
