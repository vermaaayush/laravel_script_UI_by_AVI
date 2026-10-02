@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Approved Deposits</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Approved Deposits</a></li>
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
                                            <h4 class="card-title">List of all Approved Deposits</h4>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Customer Name</th>
                                                    <th>Account Number</th>
                                                    <th>Amount</th>
                                                    <th>Deposit Method</th>
                                                    <th>Deposit Details</th>
                                                    <th>Deposit Request Made</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($deposit_approved as $single)
                                                    <?php $customer = DB::table('ba_account_holders')->where('user_id',$single->user)->first() ?>
                                                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                                                    <tr>
                                                        <td><?= $customer->cust_name ?> <?= $customer->middle_name ?> <?= $customer->sur_name ?></td>
                                                        <td><?= $account->account_no ?></td>
                                                        <td><?= $single->amount ?></td>
                                                        <td><?= $single->deptype ?></td>
                                                        <td>
                                                            <?php if(!empty($single->bank_account)){ ?>
                                                                <b>Bank account name</b>
                                                                <p><?= $single->bank_account ?></p>
                                                            <?php } ?>
                                                            
                                                            <?php if(!empty($single->bank_account)){ ?>
                                                                <b>Date of deposit</b>
                                                                <p><?= date('d F, Y',strtotime($single->date_of_deposit)) ?></p>
                                                            <?php } ?>
                                                            
                                                            <?php if(!empty($single->depo_referance)){ ?>
                                                                <b>Deposit reference</b>
                                                                <p><?= $single->depo_referance ?></p>
                                                            <?php } ?>
                                                            
                                                            <?php if(!empty($single->file) && $single->deptype != "Bitcoin"){ ?>
                                                                <a href="<?= $single->file ?>" download>Download File</a>
                                                            <?php }else{ ?>
                                                                approved
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= date('d F, Y',strtotime($single->created_at)) ?></td>
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
    </script>  
    <!-- endinject -->
</body>

</html>