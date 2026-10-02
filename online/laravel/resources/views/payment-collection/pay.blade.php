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
<div class="max-w-4xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Payment & Collection</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Pay Invoice</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Invoice Settlement</h1>
                <p class="text-sm text-slate-500 mt-1">Select an outstanding invoice and remit payment via bank wire or bitcoin.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url('invoice-pending') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Pending
                </a>
                <a href="{{ url('invoice-full') }}" class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Paid
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form method="POST" action="pay-invoice" enctype="multipart/form-data" class="space-y-6"> 
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Invoice Select -->
                <div class="md:col-span-2">
                    <label for="invoiceDropDown" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Select Outstanding Invoice <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="invoice" id="invoiceDropDown" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Choose an Invoice to Settle --</option>
                            @foreach($list as $single)
                                <option value="{{ $single->id }}" data-id="<?= $single->id ?>" data-amount="<?= number_format($single->price,2) ?>" data-paid="<?= number_format($single->paid,2) ?>" data-option="<?= $single->pay_option ?>">{{ $single->name }} (Total: <?= number_format($single->price,2) ?>)</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>
                
                <!-- Invoice Amount -->
                <div>
                    <label for="amountToPay" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Invoice Amount</label>
                    <input type="text" name="amountToPay" id="amountToPay" readonly placeholder="0.00" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono font-bold text-slate-900 cursor-not-allowed outline-none">
                </div>
                
                <!-- Paid Amount -->
                <div>
                    <label for="paidAmount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Already Remitted</label>
                    <input type="text" name="paidAmt" id="paidAmount" readonly placeholder="0.00" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono font-bold text-emerald-700 cursor-not-allowed outline-none">
                </div>
                
                <!-- Payment Method -->
                <div class="md:col-span-2">
                    <div class="flex items-center justify-between mb-2">
                        <label for="paymentMethod" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Settlement Channel <span class="text-rose-500">*</span></label>
                        <a href="javascript:void(0)" id="infoBtn" style="display:none;" class="text-primary hover:text-primary-hover text-xs font-bold inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">info</span> View Instructions
                        </a>
                    </div>
                    <div class="relative">
                        <select name="paymentMethod" id="paymentMethod" required class="w-full bg-slate-50/60 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Select an invoice first --</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                    </div>
                </div>
                
                <!-- Payment Amount -->
                <div>
                    <label for="paymentAmount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Remittance Amount <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-mono font-bold">$</span>
                        <input type="number" step="any" name="paymentAmount" id="paymentAmount" required placeholder="0.00" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl py-3 pl-9 pr-4 text-sm font-mono font-bold text-slate-900 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all decimal-num">
                    </div>
                </div>
                
                <!-- BTC to Send -->
                <div id="btcAmountContainer" style="display:none;">
                    <label for="btcToSend" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Exact BTC To Transfer</label>
                    <input type="text" name="btcToSend" id="btcToSend" readonly placeholder="0.000000 BTC" class="w-full bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-sm font-mono font-bold text-amber-800 cursor-not-allowed outline-none">
                </div>
            </div>

            <!-- Bank Details (Hidden initially) -->
            <div id="remarksCashCont" style="display:none;" class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="bank_account" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Originating Bank Account Name</label>
                        <input type="text" name="bank_account" id="bank_account" placeholder="Name on bank account" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    </div>
                    <div>
                        <label for="depo_referance" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deposit / Wire Reference</label>
                        <input type="text" name="depo_referance" id="depo_referance" placeholder="Receipt or bank reference number" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- BTC Hash -->
            <div id="bitHash" style="display:none;">
                <label for="remarks_bitcoin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Blockchain Transaction Hash (Optional)</label>
                <textarea name="remarks_bitcoin" id="remarks_bitcoin" rows="2" placeholder="e.g. 7f83b1657ff1fc53b92dc18148a1d65dfc2d4b1fa3d677284addd200126d9069" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl p-3 text-xs font-mono text-slate-800 focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-y"></textarea>
            </div>
            
            <!-- Upload Proof -->
            <div class="pt-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Attach Payment Confirmation / Wire Advice</label>
                <input type="file" name="fBitcoin" class="w-full bg-slate-50/60 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer">
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <input type="hidden" name="payid" id="payId" />
                <input type="hidden" name="comission" id="commissionAmt" />
                <input type="hidden" name="btcrate" value="<?= $dollerRate ?>" />
                <input type="hidden" name="type" value="new" />
                <button type="submit" class="px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">payments</span> Authorize Invoice Payment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<?php $payMethodB = DB::table('ba_payment_methods')->where('id','1')->first(); ?>
<?php $payMethodBit = DB::table('ba_payment_methods')->where('id','2')->first(); ?>
<div class="modal fade" id="paymentInfo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden">
            <div class="modal-header px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h5 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Remittance Instructions</h5>
                <div class="flex items-center gap-2">
                    <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition-colors inline-flex items-center gap-1" onclick="CreatePDFfromHTML();" id="downloadBtn">
                        <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span> Download PDF
                    </button>
                    <button type="button" class="text-slate-400 hover:text-slate-600" data-dismiss="modal" aria-label="Close">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>
            </div>
            <div class="modal-body p-6 text-sm text-slate-700 leading-relaxed downloadableContent">
                <div class="col-md-12" id="bitcoin">
                    <p class="text-center font-mono font-bold text-primary mb-4">Bitcoin Wallet: <?= json_decode($coderanita)->bitwallet ?? '' ?></p>
                    <div class="text-xs text-slate-600 leading-relaxed">
                        <?= $payMethodBit ? nl2br($payMethodBit->description) : '' ?>
                    </div>
                </div>
                <div class="col-md-12 text-xs text-slate-600 leading-relaxed" id="bank">
                    <?= $payMethodB ? nl2br($payMethodB->description) : '' ?>
                </div>
            </div>
            <div class="modal-footer px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button" class="px-6 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold uppercase tracking-wider" data-dismiss="modal">Proceed</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        var bitCointRate = parseFloat('<?= $dollerRate ?>');
        var Comission = parseFloat('<?= json_decode($coderanita)->pccomission ?? 0 ?>');
        $('#infoBtn').click(function(){
            if($('#paymentMethod').val() != ''){
                if($('#paymentMethod').val() == 'bank'){
                    $('#bank').show();
                    $('#bitcoin').hide();
                    $('#paymentInfo').modal('show');
                    $('#downloadBtn').show();
                }else{
                    $('#bank').hide();
                    $('#bitcoin').show();
                    $('#paymentInfo').modal('show');
                    $('#downloadBtn').hide();
                }
            }
        });
        $('#paymentMethod').change(function(){
            if($('#paymentMethod').val() != ''){
                $('#infoBtn').show();
                if($('#paymentMethod').val() == 'bitcoin'){
                    $('#bank').hide();
                    $('#bitcoin').show();
                    $('#paymentInfo').modal('show');
                    $('#bitHash').show();
                    $('#btcAmountContainer').show();
                    $('#bitHash').find('label').html('BTC Hash (Optional)');
                    $('#remarksCashCont').hide();
                    $('#bank_account').removeAttr('required');
                    $('#depo_referance').removeAttr('required');
                    $('#downloadBtn').hide();
                }else{
                    $('#bank').show();
                    $('#bitcoin').hide();
                    $('#paymentInfo').modal('show');
                    $('#btcAmountContainer').hide();
                    $('#bitHash').show();
                    $('#bitHash').find('label').html('Bank Deposit Details (Optional)');
                    $('#remarksCashCont').show();
                    $('#bank_account').attr('required', 'required');
                    $('#depo_referance').attr('required', 'required');
                    $('#downloadBtn').show();
                }
            }else{
                $('#infoBtn').hide();
                $('#bitHash').hide();
                $('#btcAmountContainer').hide();
            }
        });    
        $('#invoiceDropDown').change(function(){
            if($(this).val() != ""){
                $('#amountToPay').val($(this).find(':selected').data('amount'));
                $('#paidAmount').val($(this).find(':selected').data('paid'));
                $('#payId').val($(this).find(':selected').data('id'));
                var opt = $(this).find(':selected').data('option');
                var option = '';
                if(opt == 'both'){
                    option = '<option value="">--Select Method--</option><option value="bank">Bank Wire</option><option value="bitcoin">Bitcoin Transfer</option>';
                }else if(opt == 'bank'){
                    option = '<option value="">--Select Method--</option><option value="bank">Bank Wire</option>';
                }else{
                    option = '<option value="">--Select Method--</option><option value="bitcoin">Bitcoin Transfer</option>';
                }
                $('#paymentMethod').html(option);
            }
        });
        $('#paymentAmount').keyup(function(){
            if($(this).val() != ""){
                var _price = parseFloat($(this).val());
                var comissionIDoller = ((_price * Comission) / 100);
                _price = _price + comissionIDoller;
                var total = _price * bitCointRate;
                $('#btcToSend').val(total.toFixed(6));
                $('#commissionAmt').val(comissionIDoller.toFixed(2));
            }else{
                $('#btcToSend').val(0);
                $('#commissionAmt').val(0);
            }
        });
    });
    function CreatePDFfromHTML() {
        var HTML_Width = $(".downloadableContent").width();
        var HTML_Height = $(".downloadableContent").height();
        var top_left_margin = 0;
        var PDF_Width = HTML_Width + (top_left_margin * 2);
        var PDF_Height = (PDF_Width * 2) + (top_left_margin * 2);
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
            pdf.save("PaymentInstruction.pdf");
        });
    }
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
