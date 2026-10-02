@include('header2')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Add Card</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customers') }}">View All Customers</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customer/' . $customer[0]->id) }}">Customer
                                        Detail</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Add Card</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Add Card</h4>
                                    <p class="card-description"> Enter all card details </p>
                                     <form class="forms-sample" method="POST" action="{{ asset('insert-card') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="customer_id" id="customer_id" value="{{$customer[0]->id}}" />
                                        <input type="hidden" name="customer_user_id" id="customer_user_id" value="{{$customer[0]->user_id}}" />
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Account Number Linked</label>
                                            <select class="form-control" name="act_number" id="act_number" required>
                                                <option value="">Account Number</option>
                                                @foreach($accounts as $account)
                                                    <option value="{{$account->account_no}}">{{$account->account_no}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Card Type</label>
                                            <select class="form-control" name="card_type" id="card_type" required>
                                                <option value="">Card Type</option>
                                                <option value="Debit Card">Debit Card</option>
                                                <option value="Credit Card">Credit Card</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Card Service Type</label>
                                            <select class="form-control" name="card_service_type" id="card_service_type" required>
                                                <option value="">Card Service Type</option>
                                                <option value="American Express">American Express</option>
                                                <option value="Discover">Discover</option>
                                                <option value="MasterCard">MasterCard</option>
                                                <option value="Visa">Visa</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Card Number</label>
                                            <input type="text" class="form-control" name="card_number" id="card_number" required value="" placeholder="Card Number" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Card PIN</label>
                                            <input type="text" class="form-control" name="card_pin" id="card_pin" required value="" placeholder="Card PIN" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Exp Date</label>
                                            <input type="text" class="form-control" name="exp_date" id="exp_date" required value="" placeholder="mm/yy" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">CVV</label>
                                            <input type="text" class="form-control" name="cvv" id="cvv" required value="" placeholder="CVV" />
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Add Card</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 grid-margin stretch-card"></div>

                    </div>
                </div>
                <!-- content-wrapper ends -->







                @include('footer')
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