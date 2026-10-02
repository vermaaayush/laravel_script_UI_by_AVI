@include('header2')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Edit Card</h3>
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
                                <li class="breadcrumb-item active" aria-current="page">Approve Card</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Approve Card</h4>
                                    <p class="card-description"> Enter all card details </p>
                                     <form class="forms-sample" method="POST" action="{{ asset('update-approve-card') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="id" id="id" value="{{$card[0]->id}}" />
                                        <input type="hidden" name="customer_id" id="customer_id" value="{{$customer[0]->id}}" />
                                        <input type="hidden" name="customer_user_id" id="customer_user_id" value="{{$customer[0]->user_id}}" />
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Account Number Linked</label>
                                            <p>{{ $card[0]->cust_act_number }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Card Type</label>
                                            <p>{{ $card[0]->card_type }}</p>
                                            <input type="hidden" name="card_type_hid" id="card_type_hid" required value="{{ $card[0]->card_type }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Card Service Type</label>
                                            <p>{{ $card[0]->card_service_type }}</p>
                                            <input type="hidden" name="card_service_type_hid" id="card_service_type_hid" required value="{{ $card[0]->card_service_type }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Card Number</label>
                                            <input type="text" class="form-control" name="card_number" id="card_number" required value="{{ $card[0]->card_number }}" placeholder="Card Number" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Card PIN</label>
                                            <input type="text" class="form-control" name="card_pin" id="card_pin" required value="{{ $card[0]->card_pin }}" placeholder="Card PIN" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Exp Date</label>
                                            <input type="text" class="form-control" name="exp_date" id="exp_date" required value="{{ $card[0]->exp_date }}" placeholder="mm/yy" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">CVV</label>
                                            <input type="text" class="form-control" name="cvv" id="cvv" required value="{{ $card[0]->cvv }}" placeholder="CVV" />
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Approve Card</button>
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