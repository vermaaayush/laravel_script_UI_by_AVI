
@include('header2')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">View Card</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customer/' . $customer[0]->id) }}">Customer
                                        Detail</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-cards/' . $customer[0]->id) }}">View All Customer Cards</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View Card Detail</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">View Card</h4>
                                    <form class="forms-sample">
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Account Number Linked</label>
                                            <p>{{ $card[0]->cust_act_number }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Card Type</label>
                                            <p>{{ $card[0]->card_type }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Card Service Type</label>
                                            <p>{{ $card[0]->card_service_type }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Card Number</label>
                                            <p>{{ $card[0]->card_number }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Card PIN</label>
                                            <p>{{ $card[0]->card_pin }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Exp Date</label>
                                            <p>{{ $card[0]->exp_date }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">CVV</label>
                                            <p>{{ $card[0]->cvv }}</p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card"></div>

                    </div>
                </div>
                <!-- content-wrapper ends -->







                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020.
                            All rights reserved.</span>
                    </div>
                </footer>
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