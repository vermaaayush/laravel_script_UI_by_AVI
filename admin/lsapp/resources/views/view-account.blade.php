@include('header3')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">View Account Details</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customers') }}">View All Customers</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-accounts/' . $customer[0]->id) }}">Customer Accounts</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View Account</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">View Account Details</h4>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Account Number</label>
                                            <p>{{ $account[0]->account_no }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Account Title</label>
                                            <p>{{ $account[0]->account_title }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Branch</label>
                                            <p>{{ $account[0]->branch_name }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Account Type</label>
                                            <p>{{ $account[0]->account_type }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Account Currency</label>
                                            <p>{{ $account[0]->account_currency }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Balance</label>
                                            <p>{{ number_format($account[0]->available_balance, 0, '.', ',') }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Ledge Balance</label>
                                            <p>{{ number_format($account[0]->ledge_balance, 0, '.', ',') }}</p>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card"></div>
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

























    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
</body>

</html>