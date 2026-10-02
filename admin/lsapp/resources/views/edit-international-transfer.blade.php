@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Edit Transfer</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-accounts/' . $customer[0]->id) }}">View All Customer Accounts</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-account/' . $account[0]->id) }}">View Customer
                                        Account</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">International Transfer</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Account Transfer</h4>
                                    @include('flash::message')
                                    <form class="forms-sample" method="POST" action="{{ asset('update-international-transfer') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="old_available_balance" id="old_available_balance" value="{{ $account[0]->available_balance }}" />
                                        <input type="hidden" name="old_amount" id="old_amount" value="{{ $transfer[0]->amount }}" />
                                        <input type="hidden" name="old_charges" id="old_charges" value="{{ $transfer[0]->charges }}" />
                                        <input type="hidden" name="account_id" id="account_id" value="{{ $account[0]->id }}" />
                                        <input type="hidden" name="tran_id" id="tran_id" value="{{ $transfer[0]->tran_id }}" />
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Date</label>
                                            <input type="date" class="form-control" name="tran_date" id="tran_date" required
                                                value="{{ date('Y-m-d', strtotime($transfer[0]->datetime)) }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Time</label>
                                            <input type="text" class="form-control" name="tran_time" id="tran_time" required
                                                value="{{ date('H:i:s', strtotime($transfer[0]->datetime)) }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <input type="text" class="form-control" name="reason" id="reason" required value="{{ $transfer[0]->reason }}" 
                                                placeholder="Description" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Beneficiary Name</label>
                                            <p>{{ $transfer[0]->beneficiary }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Status</label>
                                            <p>
                                                @if($transfer[0]->status == 1)
                                                <label class="badge badge-success">Approved</label>
                                                @endif

                                                @if($transfer[0]->status == 0)
                                                <label class="badge badge-danger">Pending</label>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount" required
                                                value="{{ $transfer[0]->amount }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Charges</label>
                                            <input type="text" class="form-control" name="charges" id="charges" required
                                                value="{{ $transfer[0]->charges }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Balance</label>
                                            <input type="hidden" name="before_charges_balance" id="before_charges_balance" value="" />
                                            <input type="text" class="form-control" name="balance" id="balance" required
                                                value="{{ $account[0]->available_balance }}" readonly />
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
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

        $('#amount').on('keyup', function() {
            calculateBalance();
        });

        function calculateBalance() {
            var old_amount = $('#old_amount').val();
            var old_charges = $('#old_charges').val();
            var old_available_balance = $('#old_available_balance').val();
            var amount = $('#amount').val();

            var newCharges = parseFloat(amount) * 2/100;

             var balance = ((parseFloat(old_available_balance) + parseFloat(old_amount) + parseFloat(old_charges)) - parseFloat(amount));
            
            $('#before_charges_balance').val(balance);

            var balance = parseFloat(balance) - parseFloat(newCharges);

            $('#charges').val(newCharges);
            $('#balance').val(balance);
        }
    </script>
</body>

</html>