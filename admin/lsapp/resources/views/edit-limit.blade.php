@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Edit Limit</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-account/' . $account[0]->id) }}">View Customer
                                        Account</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-loans/' . $account[0]->id) }}">View Loans</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Limit</li>
                            </ol>
                            </ol>
                        </nav>
                    </div>
                    <!-- <a href="../deposits/all_deposits.html"><button type="submit"
                            class="btn btn-gradient-primary mr-2">Go Back</button></a> -->
                    <div class="row">
                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Edit Limit</h4>
                                    <p class="card-description"> Enter details to edit limit </p>
                                    <form class="forms-sample" method="POST" action="{{ asset('update-limit') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type = "hidden" name = "user_id" value = "{{ $customer[0]->user_id }}">
                                        <input type = "hidden" name = "account_id" value = "{{ $account[0]->id }}">
                                        <input type = "hidden" name = "id" value = "{{ $limit[0]->id }}">
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Account No.</label>
                                            <p>{{ $limit[0]->account_no }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Type</label>
                                            <p>{{ $limit[0]->type }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Status</label>
                                            <p>
                                                @if($limit[0]->status == 0)
                                                    Pending
                                                @elseif($limit[0]->status == 1)
                                                    Approved
                                                @elseif($limit[0]->status == 2)
                                                    Rejected
                                                @endif
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Currency</label>
                                            <p>{{ $account[0]->account_currency }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Limit Amount</label>
                                            <input type="text" class="form-control" name="limit_amount" id="limit_amount" required value="{{ $limit[0]->limit_amount }}" />
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
        $('#balance_type').on('change', function() {
            calculateBalance();
        });

        function calculateBalance() {
            var old_amount = $('#old_amount').val();
            var old_available_balance = $('#old_available_balance').val();
            var old_ledge_balance = $('#old_ledge_balance').val();
            var old_balance_type = $('#old_balance_type').val();
            var balance_type = $('#balance_type').val();
            var amount = $('#amount').val();

            if(old_balance_type == balance_type) {
                if(balance_type == 'available_balance') {
                    var balance = (parseInt(old_available_balance) - parseInt(old_amount)) + parseInt(amount);
                } 
                else {
                    var balance = (parseInt(old_ledge_balance) - parseInt(old_amount)) + parseInt(amount);
                }
            }
            else {
                if(balance_type == 'available_balance') {
                var balance = parseInt(old_available_balance) + parseInt(amount);
                } 
                else {
                    var balance = parseInt(old_ledge_balance) + parseInt(amount);
                }
            }
            
            $('#balance').val(balance);
        }
    </script>  
</body>

</html>