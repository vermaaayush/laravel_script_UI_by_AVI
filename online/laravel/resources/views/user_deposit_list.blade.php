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
            <span class="text-slate-400">Cash Management</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Fund Deposit</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Deposit Funds</h1>
                <p class="text-sm text-slate-500 mt-1">Initiate cash or crypto top-ups and review verified transaction settlements.</p>
            </div>
            <a href="#deposit-history" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">history</span> Deposit Ledger
            </a>
        </div>
    </div>

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

    <!-- Deposit Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 mb-8">
        <div class="flex items-center gap-3 pb-5 border-b border-slate-100 mb-6">
            <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">payments</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">New Deposit Notice</h3>
                <p class="text-xs text-slate-500">Provide funding details to generate an official clearing reference</p>
            </div>
        </div>

        <form method="POST" action="{{ asset('user-deposit') }}" enctype="multipart/form-data" class="space-y-6"> 
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Account Select -->
                <div>
                    <label for="account_no" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Target Account <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="account_no" id="account_no" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Destination Account --</option>
                            @foreach($users as $Ba_bene)
                                <option value="{{ $Ba_bene->id }}">{{ $Ba_bene->account_no }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <!-- Deposit Method -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="dep_method" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Deposit Channel <span class="text-rose-500">*</span></label>
                        <a href="javascript:void(0)" id="infoBtn" style="display:none;" class="text-primary hover:text-primary-hover text-xs font-bold inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">info</span> View Instructions
                        </a>
                    </div>
                    <div class="relative">
                        <select name="dep_method" id="dep_method" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select Method --</option>
                            @foreach($methods as $method)
                                <option value="{{ $method->name }}" data-ins="<?= nl2br($method->description); ?>">{{ $method->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>

                <!-- Cash Deposit Amount -->
                <div id="priceCashDepositCont" style="display:none;" class="md:col-span-2">
                    <label for="priceCashDeposit" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deposit Amount <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-mono font-bold">$</span>
                        <input type="text" name="amount" id="priceCashDeposit" placeholder="0.00" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl py-3.5 pl-9 pr-4 text-base font-mono font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all decimal-num">
                    </div>
                </div>

                <!-- Bitcoin Deposit Amounts -->
                <div id="priceBitcoinCont" style="display:none;" class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-2xl bg-amber-50/50 border border-amber-200/60">
                    <div>
                        <label for="priceBitcoin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Amount in ({{ Session::get('account_currency') ?? 'JPY' }}) <span class="text-rose-500">*</span></label>
                        <input type="text" name="priceBitcoin" id="priceBitcoin" placeholder="Amount to deposit" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono font-bold text-slate-900 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all decimal-num">
                    </div>
                    <div>
                        <label for="priceBitcointToDeposit" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Exact BTC To Send</label>
                        <input type="text" id="priceBitcointToDeposit" readonly placeholder="0.000000 BTC" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono font-bold text-amber-700 cursor-not-allowed outline-none">
                    </div>
                </div>

                <!-- Date of Deposit -->
                <div id="date_of_depoCont" style="display:none;">
                    <label for="date_of_depo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Date of Deposit <span class="text-rose-500">*</span></label>
                    <input type="date" name="date_of_depo" id="date_of_depo" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Cash / Bank Deposit Specific Fields -->
                <div id="remarksCashCont" style="display:none;" class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="bank_account" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Originating Bank Account Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="bank_account" id="bank_account" placeholder="Name on sender bank account" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                        </div>
                        <div>
                            <label for="depo_referance" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bank Reference / Cheque No. <span class="text-rose-500">*</span></label>
                            <input type="text" name="depo_referance" id="depo_referance" placeholder="Receipt or bank reference number" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label for="fUploadFile" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Attach Deposit Slip / Bank Receipt <span class="text-rose-500">*</span></label>
                        <input type="file" name="fUpload" id="fUploadFile" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer">
                    </div>
                </div>

                <!-- Bitcoin Specific Fields -->
                <div id="remarksBitcoin" style="display:none;" class="md:col-span-2 space-y-4">
                    <div>
                        <label for="remarks_bitcoin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Blockchain Transaction Hash (Optional)</label>
                        <textarea name="remarks_bitcoin" id="remarks_bitcoin" rows="2" placeholder="e.g. 7f83b1657ff1fc53b92dc18148a1d65dfc2d4b1fa3d677284addd200126d9069" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl p-3 text-xs font-mono text-slate-800 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-y"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Wallet Screenshot / TX Proof</label>
                        <input type="file" name="fBitcoin" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Hidden Params & Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <input type="hidden" name="commissionAmt" id="commissionAmt" value="0" />
                <input type="hidden" name="BTCRate" value="<?= $dollerRate ?>" />
                <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span> Submit Deposit Request
                </button>
            </div>
        </form>
    </div>

    <!-- Deposit History Ledger Card -->
    <div id="deposit-history" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-[20px]">history</span>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Deposit Settlements</h3>
            </div>
            <span class="text-xs text-slate-400">All recent and pending account credits</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Account Number</th>
                        <th class="py-3.5 px-6">Amount</th>
                        <th class="py-3.5 px-6">Channel</th>
                        <th class="py-3.5 px-6">Transaction Particulars</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Deposited At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($deposits as $single)
                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-slate-800">
                            <?= $account ? $account->account_no : '—' ?>
                        </td>
                        <td class="py-4 px-6 font-mono font-bold text-emerald-600">
                            +<?= number_format($single->amount, 2) ?>
                        </td>
                        <td class="py-4 px-6 font-semibold text-slate-700">
                            <?= $single->deptype ?>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            <?php if(!empty($single->bank_account)){ ?>
                                <span class="text-slate-400 block font-sans">Sender: <?= $single->bank_account ?></span>
                            <?php } ?>
                            <?php if(!empty($single->depo_referance)){ ?>
                                <span class="font-mono text-slate-700 block">Ref: <?= $single->depo_referance ?></span>
                            <?php } ?>
                            <?php if(!empty($single->file) && $single->deptype != "Bitcoin"){ ?>
                                <a href="<?= $single->file ?>" download class="inline-flex items-center gap-1 text-primary hover:underline font-semibold mt-1">
                                    <span class="material-symbols-outlined text-[14px]">download</span> Receipt
                                </a>
                            <?php } ?>
                        </td>
                        <td class="py-4 px-6">
                            <?php if($single->approved == 0){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                                </span>
                            <?php } elseif($single->approved == 1){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                </span>
                            <?php } elseif($single->approved == 2){ ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                </span>
                            <?php } ?>
                        </td>
                        <td class="py-4 px-6 text-right text-xs text-slate-500 font-mono">
                            <?= date('d M, Y', strtotime($single->created_at)) ?>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[40px] text-slate-300 block mb-2">payments</span>
                            <p class="text-sm font-semibold text-slate-600">No Deposits Recorded</p>
                            <p class="text-xs text-slate-400 mt-0.5">Submit your first deposit request above.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Instruction Modal -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<div class="modal fade" id="instructionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <form method="post" action="deposit-methods-instruction">
        @csrf
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden">
                <div class="modal-header px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <h5 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Deposit Channel Instructions</h5>
                    <div class="flex items-center gap-2">
                        <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors inline-flex items-center gap-1" id="downloadBtn" onclick="CreatePDFfromHTML();">
                            <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span> Download PDF
                        </button>
                        <button type="button" class="text-slate-400 hover:text-slate-600" data-dismiss="modal" aria-label="Close">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body p-6 text-sm text-slate-700 leading-relaxed downloadableContent">
                    <p class="text-center font-mono font-bold text-primary mb-4" id="bitcoinAddress"></p>
                    <div id="dataOfMethod" class="prose max-w-none text-slate-600 text-xs leading-relaxed"></div>
                </div>
                <div class="modal-footer px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="button" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wider" data-dismiss="modal">
                        Acknowledge & Proceed
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function(){
        var bitCointRate = parseFloat('<?= $dollerRate ?>');
        var Comission = parseFloat('<?= json_decode($coderanita)->comission ?? 0 ?>');
        $('#dep_method').change(function(){
            if($(this).val() == "Cash Deposit"){
                $('#dataOfMethod').html($(this).find(':selected').data('ins'));
                $('#instructionModal').modal('show');
                
                $('#priceCashDeposit').attr('required', 'required');
                $('#bank_account').attr('required', 'required');
                $('#date_of_depo').attr('required', 'required');
                $('#depo_referance').attr('required', 'required');
                $('#fUploadFile').attr('required', 'required');
                $('#bitcoinAddress').hide();
                $('#infoBtn').show();
                $('#remarksCashCont').show();
                $('#priceBitcoinCont').hide();
                $('#priceCashDepositCont').show();
                $('#date_of_depoCont').show();
                $('#downloadBtn').show();
            }else if($(this).val() == "Bitcoin"){
                $('#dataOfMethod').html($(this).find(':selected').data('ins'));
                $('#instructionModal').modal('show');
                
                $('#bitcoinAddress').show();
                $('#infoBtn').show();
                $('#remarksBitcoin').show();
                $('#remarksCashCont').hide();
                $('#priceCashDepositCont').hide();
                $('#priceBitcoinCont').show();
                $('#date_of_depoCont').show();
                
                $('#priceBitcoin').attr('required', 'required');
                $('#date_of_depo').attr('required', 'required');
                
                $('#priceCashDeposit').removeAttr('required');
                $('#bank_account').removeAttr('required');
                $('#fUploadFile').removeAttr('required');
                $('#depo_referance').removeAttr('required');
                $('#downloadBtn').hide();
            }else{
                $('#infoBtn').hide();
                $('#fUploadFile').removeAttr('required');
                $('#bank_account').removeAttr('required');
                $('#date_of_depo').removeAttr('required');
                $('#depo_referance').removeAttr('required');
                $('#remarksCashCont').hide();
                $('#priceCashDepositCont').hide();
                $('#priceBitcoinCont').hide();
                $('#date_of_depoCont').hide();
            }
        });
        $('#infoBtn').click(function(){
            $('#dataOfMethod').html($('#dep_method').find(':selected').data('ins'));
            $('#instructionModal').modal('show');
        });
        
        $('#priceBitcoin').keyup(function(){
            if($(this).val() != ""){
                _price = parseFloat($(this).val());
                comissionIDoller = ((_price * Comission) / 100);
                _price = _price + ((_price * Comission) / 100);
                total = _price * bitCointRate;
                $('#priceBitcointToDeposit').val(total.toFixed(6));
                $('#commissionAmt').val(comissionIDoller.toFixed(2));
            }else{
                $('#priceBitcointToDeposit').val(0);
                $('#commissionAmt').val(0);
            }
        });
    });
    function CreatePDFfromHTML() {
        var HTML_Width = $(".downloadableContent").width();
        var HTML_Height = $(".downloadableContent").height();
        var top_left_margin = 5;
        var PDF_Width = HTML_Width + (top_left_margin * 2);
        var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;
    
        var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;
    
        html2canvas($(".downloadableContent")[0]).then(function (canvas) {
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
            for (var i = 1; i <= totalPDFPages; i++) { 
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            }
            pdf.save("DepositInstruction.pdf");
        });
    }
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
