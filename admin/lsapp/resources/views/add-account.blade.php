@include('header2')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">   
                        <h3 class="page-title">Add Customer Accounts</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customers') }}">View All Customers</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="{{ asset('view-customer/' . $customer[0]->id) }}">View Customer Details</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Customer Account</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Add Account</h4>
                                    <p class="card-description"> Enter all account details </p>
                                    <form class="forms-sample" method="POST" action="{{ asset('insert-account') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type = "hidden" name = "id" value = "{{$customer[0]->id}}">
                                        <input type = "hidden" name = "user_id" value = "{{$customer[0]->user_id}}">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Account Number</label>
                                            <input type="text" class="form-control @error('account_no') is-invalid @enderror" name="account_no" id="account_no" required value="" placeholder="Account Number" />
                                            @error('account_no')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Account Title</label>
                                            <input type="text" class="form-control" name="account_title" id="account_title" required value='{{$customer[0]->cust_name . " " . $customer[0]->middle_name . " " . $customer[0]->sur_name}}' placeholder="Account Title" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Branch</label>
                                            <select class="form-control" name="branch" id="branch" required>
                                                <option value="">Select Branch</option>
                                                @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Account Type</label>
                                            <select class="form-control" name="acc_type" id="acc_type" required>
                                                <option value="">Select Account Type</option>
                                                @foreach ($acc_types as $acc_type)
                                                <option value="{{ $acc_type->type_name }}" @if(!empty($customer_acc_type) && $customer_acc_type == $acc_type->type_name) selected @endif>{{ $acc_type->type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Account Currency</label>
                                            <select class="form-control" name="account_currency" id="account_currency" required>
                                                <option value="">Select Account Currency</option>
                                                @foreach ($currencies as $currency)
                                                <option value="{{ $currency->currency }}" @if(!empty($customer_currency) && $customer_currency == $currency->currency) selected @endif>{{ $currency->currency }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Balance</label>
                                            <input type="text" class="form-control" name="available_balance" id="available_balance" required value="" placeholder="Balance" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Ledge Balance</label>
                                            <input type="text" class="form-control" name="ledge_balance" id="ledge_balance" required value="" placeholder="Ledge Balance" />
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                        <a href="{{ asset('view-customer/' . $customer[0]->id) }}"><button type="button" class="btn btn-light">Cancel</button></a>
                                    </form>
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
     <script>
        $("#available_balance").on('keyup', function(){
             var n = parseInt($(this).val().replace(/\D/g,''),10);
             $(this).val(n.toLocaleString());
        });
        $("#ledge_balance").on('keyup', function(){
             var n = parseInt($(this).val().replace(/\D/g,''),10);
             $(this).val(n.toLocaleString());
        });


    </script>
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