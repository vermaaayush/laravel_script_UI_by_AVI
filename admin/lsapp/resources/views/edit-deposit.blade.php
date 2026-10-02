@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Edit Deposits</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-account/' . $account[0]->id) }}">View Customer
                                        Account</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-deposits/' . $account[0]->id) }}">View Deposits</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Deposits</li>
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
                                    <h4 class="card-title">Edit Deposit</h4>
                                    <p class="card-description"> Enter all deposit details to update </p>
                                    <form class="forms-sample" method="POST" action="{{ asset('update-deposit') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type = "hidden" id="id" name = "id" value = "{{ $deposit[0]->id }}">
                                        <input type = "hidden" id="account_id" name = "account_id" value = "{{ $account[0]->id }}">
                                        <input type="hidden" name="old_available_balance" id="old_available_balance" value="{{ $account[0]->available_balance }}" />
                                        <input type="hidden" name="old_ledge_balance" id="old_ledge_balance" value="{{ $account[0]->ledge_balance }}" />
                                        <input type = "hidden" id="old_amount" name = "old_amount" value = "{{ $deposit[0]->amount }}">
                                        <input type = "hidden" id="old_balance_type" name = "old_balance_type" value = "{{ $deposit[0]->balance_type }}">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Date</label>
                                            <input type="date" class="form-control" name="tran_date" id="tran_date" required
                                                value="{{ date('Y-m-d', strtotime($deposit[0]->datetime)) }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Time</label>
                                            <input type="text" class="form-control" name="tran_time" id="tran_time" required
                                                value="{{ date('H:i:s', strtotime($deposit[0]->datetime)) }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <input type="text" class="form-control" name="reason" id="reason" required value="{{ $deposit[0]->reason }}" 
                                                placeholder="Description" />
                                            <p class="example-reasons" style="margin-top: 5px;">*Withdrawal atm b/o bow</p>
                                            <p class="example-reasons">*cash transfer b/o bow</p>
                                            <p class="example-reasons">*cash deposit b/o bow</p>
                                            <p class="example-reasons">*cash deposit self</p>
                                            <p class="example-reasons">*approve inward trf - b/o bowtrans tom ifo jenny r</p>
                                            <p class="example-reasons">*approve inward trf - swift inflo b/o bowtrans tom info paul kerheem</p>
                                            <p class="example-reasons">*fx purchase (spot) via internet banking - kerheem, paul - @249.62 @1.595016</p>
                                            <p class="example-reasons">*c.o.t b/o bow</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Depositor's Name</label>
                                            <input type="text" class="form-control" name="depositor_name" id="depositor_name" required value="{{ $deposit[0]->depositor }}" placeholder="Depositor's Name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount" required value="{{ $deposit[0]->amount }}" 
                                                placeholder="Amount" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Type</label>
                                            <select class="form-control" name="balance_type" id="balance_type" required>
                                                <option value="available_balance" @if($deposit[0]->balance_type == 'available_balance') selected @endif>Available Balance</option>
                                                <option value="ledge_balance" @if($deposit[0]->balance_type == 'ledge_balance') selected @endif>Ledger Balance</option>
                                            </select>
                                            <br />
                                            <input type="checkbox" name="statement" id="statement" value="1" @if($deposit[0]->statement == 1) checked @endif />Appear in Statement
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Balance</label>
                                            <input type="text" class="form-control" name="balance" id="balance" required value="{{ $deposit[0]->balance }}" placeholder="Balance" readonly />
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Update
                                            Deposit</button>
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