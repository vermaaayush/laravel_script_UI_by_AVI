@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Transfers</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Transfers</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @include('flash::message')
                                            <h4 class="card-title">List of all Transfers</h4>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-striped tblInv">
                                            <thead>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <th>Deposit Account</th>
                                                    <th>Beneficiary</th>
                                                    <th>Amount</th>
                                                    <th>Transfer At</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transactions as $single)
                                                    <?php $customer = DB::table('ba_account_holders')->where('user_id',$single->user)->first(); ?>
                                                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first(); ?>
                                                    <?php $benefe = DB::table('ba_beneficiary')->where('id',$single->benefe)->first(); ?>
                                                    <tr>
                                                        <td><?= $customer?$customer->cust_name.' '.$customer->middle_name.' '.$customer->sur_name:'' ?></td>
                                                        <td><?= $account?$account->account_no:'' ?></td>
                                                        <td>
                                                            <div class="div-show-container" id="divShowContainer<?= $single->id ?>">
                                                                <b>Name</b>
                                                                <p><?= $benefe?$benefe->beneficiary_name:'' ?></p>
                                                                
                                                                <b>Account No.</b>
                                                                <p><?= $benefe?$benefe->beneficiary_account:'' ?></p>
                                                                
                                                                <b>Address</b>
                                                                <p><?= $benefe?$benefe->beneficiary_address:'' ?></p>
                                                                
                                                                <b>Sort Code</b>
                                                                <p><?= $benefe?$benefe->beneficiary_sort_code:'' ?></p>
                                                                
                                                                <b>Swift</b>
                                                                <p><?= $benefe?$benefe->beneficiary_swift:'' ?></p>
                                                                
                                                                <b>IBAN</b>
                                                                <p><?= $benefe?$benefe->beneficiary_iban:'' ?></p>
                                                                
                                                                <b>Bank</b>
                                                                <p><?= $benefe?$benefe->beneficiary_bank_name:'' ?></p>
                                                                
                                                                <b>Bank Address</b>
                                                                <p><?= $benefe?$benefe->beneficiary_bank_address:'' ?></p>
                                                                
                                                                <b>Country</b>
                                                                <p><?= $benefe?$benefe->beneficiary_country:'' ?></p>
                                                                
                                                                <b>Remark/ Purpose of transfer</b>
                                                                <p><?= $single->remark ?></p>
                                                            </div>
                                                            <p class="show-more"><a href="javascript:;" id="btn_more<?= $single->id ?>" onclick="show_more('<?= $single->id ?>');">Show More</a></p>
                                                        </td>
                                                        <td><?= $single->currency.' '.number_format($single->amount) ?></td>
                                                        <td><?= date('d M, Y',strtotime($single->cat)) ?></td>
                                                        <td>
                                                            <?php if($single->status == "0"){ ?>
                                                                <p style="color:red;">Pending</p>
                                                            <?php }else if($single->status == "1"){ ?>
                                                                <p style="color:red;">Processing</p>
                                                            <?php }else{ ?>
                                                                <p style="color:green;">Completed</p>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if($single->status == "2"){ ?>
                                                                <a href="{{ asset('transfer-other-send').'/' . $single->id }}" class="btn btn-success btn-sm">
                                                                    Send Telex
                                                                </a><br>
                                                            <?php }else if($single->status == "1"){ ?>
                                                                <a href="{{ asset('transfer-other-confirm').'/' . $single->id }}" class="btn btn-success btn-sm" onclick="return confirm('Are you sure?')">
                                                                    Complete
                                                                </a><br>
                                                            <?php } ?>
                                                            <a href="{{ asset('transfer-other').'/' . $single->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to Delete this?')">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- content-wrapper ends -->


                @include('footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
        function show_more(id){
            if($('#divShowContainer'+id).hasClass('div-show-container')){
                $('#divShowContainer'+id).removeClass('div-show-container');
                $('#btn_more'+id).html('Show Less');
            }else{
                $('#divShowContainer'+id).addClass('div-show-container');
                $('#btn_more'+id).html('Show More');
            }
        }
    </script>  
    <style>
        .div-show-container{
            max-height:80px !important; overflow : hidden;
        }
        .tblInv{
            width:100%;
        }
        .tblInv td,.tblInv th{
            white-space: normal !important;
            vertical-align: top;
        }
        .show-more{
            margin-top:5px;
        }
    </style>
    <!-- endinject -->
</body>

</html>