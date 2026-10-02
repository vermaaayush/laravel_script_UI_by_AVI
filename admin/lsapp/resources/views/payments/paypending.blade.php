@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Pending Payments</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Pending Payments</a></li>
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
                                            <h4 class="card-title">List of all Pending Payments</h4>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-hover tblInv">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Customer</th>
                                                    <th>Invoice</th>
                                                    <th>Amount</th>
                                                    <th>Payment Details</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list as $single)
                                                <?php $customer = DB::table('ba_account_holders')->where('id',$single->user)->first() ?>
                                                <?php $inv = DB::table('ba_payments')->where('id',$single->payment)->first() ?>
                                                <tr>
                                                    <td>{{ date("d/m/Y", strtotime($single->cat)) }}</td>
                                                    <td>{{ $customer->cust_name . " " .$customer->middle_name . " " . $customer->sur_name }}</td>
                                                    <td>{{ $inv->name }}</td>
                                                    <td>{{ number_format($single->amount, 0, '.', ',') . " USD" }}</td>
                                                    <td>
                                                        <?php if(!empty($single->bank_account)){ ?>
                                                            <b>Bank account name</b>
                                                            <p><?= $single->bank_account ?></p>
                                                        <?php } ?>
                                                        <?php if(!empty($single->depo_referance)){ ?>
                                                            <b>Deposit reference</b>
                                                            <p><?= $single->depo_referance ?></p>
                                                        <?php } ?>
                                                        <?= nl2br($single->hash) ?><br><?php if($single->file != ""){ ?><a href="<?= $single->file ?>" download>Download File</a><?php } ?></td>
                                                    <td>
                                                        <a href="{{ asset('invoice-payment-status').'/' . $single->id.'/1' }}" class="btn btn-success btn-sm">
                                                            Mark as paid
                                                        </a><br>
                                                        <a href="{{ asset('invoice-payment-status').'/' . $single->id.'/2' }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to Reject this?')">
                                                            Reject
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
    <style>
        .tblInv{
            width:100%;
        }
        .tblInv td,.tblInv th{
            white-space: normal !important;
        }
    </style>
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
    </script>  
</body>

</html>