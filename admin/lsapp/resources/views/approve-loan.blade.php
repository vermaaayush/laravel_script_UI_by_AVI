@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Approve Loan</h3>
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
                                <li class="breadcrumb-item active" aria-current="page">Approve Loan</li>
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
                                    <h4 class="card-title">Approve Loan</h4>
                                    <p class="card-description"> Enter details to approve loan </p>
                                    <form class="forms-sample" method="POST" action="{{ asset('update-approve-loan') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type = "hidden" name = "user_id" value = "{{ $customer[0]->user_id }}">
                                        <input type = "hidden" name = "account_id" value = "{{ $account[0]->id }}">
                                        <input type = "hidden" name = "id" value = "{{ $loan[0]->id }}">
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">First Name</label>
                                            <p>{{ $loan[0]->fname }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Last Name</label>
                                            <p>{{ $loan[0]->lname }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">DOB</label>
                                            <p>{{ $loan[0]->dob }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Loan Type</label>
                                            <p>{{ $loan[0]->loan_type }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Account No.</label>
                                            <p>{{ $loan[0]->account_no }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Loan Amount</label>
                                            <p>{{ $account[0]->account_currency . " " . $loan[0]->loan_amount }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Loan Tenure</label>
                                            <p>{{ $loan[0]->loan_tenure }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Employment Type</label>
                                            <p>{{ $loan[0]->employment_type }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Email</label>
                                            <p>{{ $loan[0]->email }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Mobile</label>
                                            <p>{{ $loan[0]->mobile }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">State</label>
                                            <p>{{ $loan[0]->state }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">City</label>
                                            <p>{{ $loan[0]->city }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Address</label>
                                            <p>{{ $loan[0]->address }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Taken Loan Before</label>
                                            <p>{{ $loan[0]->taken_loan_before }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Photo</label>
                                            <p><img src="{{ $loan[0]->photo }}" style="width: 200px;" /></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Signature</label>
                                            <p><img src="{{ $loan[0]->signature }}" style="width: 200px;" /></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Salary Slip</label>
                                            @if($loan[0]->salary_slip != '')
                                            <p><img src="{{ $loan[0]->salary_slip }}" style="width: 200px;" /></p>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Loan EMI</label>
                                            <input type="text" class="form-control" name="loan_emi" id="loan_emi" required value="" placeholder="Loan EMI" />
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Approve</button>
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