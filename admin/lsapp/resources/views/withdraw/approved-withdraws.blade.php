@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Approved Withdraw</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Approved Withdraw</a></li>
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
                                            <h4 class="card-title">List of all Approved Withdraw</h4>
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
                                                    <th>Withdraw Method</th>
                                                    <th>Withdraw Request Made</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($withdrawls as $single)
                                                    <?php $customer = DB::table('ba_account_holders')->where('user_id',$single->user)->first() ?>
                                                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                                                    <?php
                                                        $totalAmount =  ((($single->amount * $single->comission) / 100) + $single->amount) * $single->bitamount; 
                                                    ?>
                                                    <tr>
                                                        <td><?= $customer->cust_name ?> <?= $customer->middle_name ?> <?= $customer->sur_name ?></td>
                                                        <td><?= $account->account_no ?></td>
                                                        <td><?= number_format((float)$totalAmount, 6, '.', '') ?></td>
                                                        <td><?= $single->withtype ?></td>
                                                        <td><?= date('d F, Y',strtotime($single->date_of_with)) ?></td>
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