<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- //  Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>

<!-- Page Content  -->
<div class="max-w-3xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 sm:p-12 text-center overflow-hidden relative">
        <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-6 border border-emerald-100 shadow-sm">
            <span class="material-symbols-outlined text-3xl">check_circle</span>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight mb-3">Operation Successful</h1>
        <p class="text-base text-slate-600 max-w-md mx-auto mb-8 leading-relaxed">{{ $msg }}</p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ url('index') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[16px]">dashboard</span>
                <span>Return to Dashboard</span>
            </a>
            <a href="{{ url('transactions-list') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                <span>View Transaction Ledger</span>
            </a>
        </div>
    </div>

    @if(count($popupsN) > 0)
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
        <div class="flex flex-wrap items-center gap-3">
            @foreach($popupsN as $popup)
                <a href="javascript:;" onclick="openModal('<?= $popup->id ?>');" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[14px] text-slate-400">info</span>
                    <span><?= $popup->title ?></span>
                </a>

                <div class="modal fade bankPopup<?= $popup->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-2xl border-0 shadow-xl overflow-hidden">
                            <div class="modal-header bg-slate-900 text-white border-0 px-6 py-4">
                                <h5 class="modal-title font-bold text-sm text-white"><?= $popup->title ?></h5>
                                <button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-6 text-sm text-slate-700 leading-relaxed">
                                <?= $popup->content ?>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-[11px] text-slate-400 mt-4 leading-relaxed border-t border-slate-100 pt-3">
            <?= $confiG->bank_name ?? 'Equitable Bank' ?> Finance is authorized by the Prudential Regulation Authority and regulated by the Financial Conduct Authority.
        </p>
    </div>
    @endif
</div>

<script>
    function openModal(id){
        $('.bankPopup'+id).modal('show');
    }
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
