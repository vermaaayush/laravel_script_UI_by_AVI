@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Invoices</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Invoices</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-hover tblInv">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Invoice</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Paid?</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $single)
                                            <?php $customer = DB::table('ba_account_holders')->where('id',$single->user)->first() ?>
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($single->dt)) }}</td>
                                                <td>{{ $customer->cust_name . " " .$customer->middle_name . " " . $customer->sur_name }}</td>
                                                <td>{{ $single->name }}</td>
                                                <td>{{ $single->descr }}</td>
                                                <td>{{ number_format($single->price, 0, '.', ',') . " " . $single->currency }}</td>
                                                <td>{{ number_format($single->paid, 0, '.', ',') . " " . $single->currency }}</td>
                                                <td>
                                                    <?= $single->pd == 1?"Yes":'no' ?>
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