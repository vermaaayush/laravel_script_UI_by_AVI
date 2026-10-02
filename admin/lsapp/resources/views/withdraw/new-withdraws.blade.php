@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">New Withdraw</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">New Withdraw</a></li>
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
                                            <h4 class="card-title">List of all New Withdraw</h4>
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
                                                    <th>Amount To Send</th>
                                                    <th>Withdraw Method</th>
                                                    <th>Withdraw Request Made</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($withdrawls as $single)
                                                    <?php $customer = DB::table('ba_account_holders')->where('user_id',$single->user)->first() ?>
                                                    <?php $account = DB::table('ba_user_accounts')->where('id',$single->account)->first() ?>
                                                    <?php
                                                        $totalAmount =  ((($single->amount * $single->comission) / 100) + $single->amount) * $dollerRate; 
                                                    ?>
                                                    <tr>
                                                        <td><?= $customer->cust_name ?> <?= $customer->middle_name ?> <?= $customer->sur_name ?></td>
                                                        <td><?= $account->account_no ?></td>
                                                        <td>Please send exactly <?= number_format((float)$totalAmount, 6, '.', '') ?> btc<br> to Wallet: <?= $bitConinId ?></td>
                                                        <td><?= $single->withtype ?></td>
                                                        <td><?= date('d F, Y',strtotime($single->date_of_with)) ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-success btn-sm" onclick="showWithModel('<?= $single->id ?>','<?= $dollerRate ?>')">
                                                                Mark as paid
                                                            </a><br>
                                                            <a href="{{ asset('user-withdrawal-reject').'/' . $single->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to Reject this?')">
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
    <div class="modal fade" id="modalApprove" tabindex="-1" role="dialog">
        <form method="post" action="user-withdrawal-approve">
            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Tranfer Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="hash" placeholder="BTC hash" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="" id="withDrawId"/>
                        <input type="hidden" name="btcRate" value="" id="btcRate"/>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
    <script>
        function showWithModel(id,btcRate){
            $('#btcRate').val(btcRate);
            $('#withDrawId').val(id);
            $('#modalApprove').modal('show');
        }
    </script>
</body>

</html>