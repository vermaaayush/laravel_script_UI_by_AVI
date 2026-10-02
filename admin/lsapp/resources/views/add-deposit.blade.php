@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Add Deposits</h3>
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
                                <li class="breadcrumb-item active" aria-current="page">Add Deposits</li>
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
                                    <h4 class="card-title">Add Deposit</h4>
                                    <p class="card-description"> Enter all deposit details to create </p>
                                    @include('flash::message')
                                    <form class="forms-sample" method="POST" action="{{ asset('insert-deposit') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type="hidden" name="old_available_balance" id="old_available_balance" value="{{ $account[0]->available_balance }}" />
                                        <input type="hidden" name="old_ledge_balance" id="old_ledge_balance" value="{{ $account[0]->ledge_balance }}" />
                                        <input type="hidden" name="id" id="id" value="{{ $account[0]->id }}" />
                                        <input type="hidden" name="act_number" id="act_number" value="{{ $account[0]->account_no }}" />
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Date</label>
                                            <input type="date" class="form-control" name="tran_date" id="tran_date" required
                                                value="{{ date('Y-m-d') }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Time</label>
                                            <input type="text" class="form-control" name="tran_time" id="tran_time" required
                                                value="{{ date('H:i:s') }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <input type="text" class="form-control" name="reason" id="reason" required value="" 
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
                                            <input type="text" class="form-control" name="depositor_name" id="depositor_name" required value="" placeholder="Depositor's Name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount" required value="" 
                                                placeholder="Amount" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Type</label>
                                            <select class="form-control" name="balance_type" id="balance_type" required>
                                                <option value="available_balance">Available Balance</option>
                                                <option value="ledge_balance">Ledger Balance</option>
                                            </select>
                                            <br />
                                            <input type="checkbox" name="statement" id="statement" value="1" checked />Appear in Statement
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Balance</label>
                                            <input type="text" class="form-control" name="balance" id="balance" required placeholder="Balance" readonly />
                                            <!--<input type="text" class="form-control" name="balance" id="balance" required placeholder="Balance" />-->
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Add
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






    <!--<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>-->
    <!-- plugins:js -->
    <!--<script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>-->
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <!--<script src="{{ asset('js/off-canvas.js') }}"></script>-->
    <!--<script src="{{ asset('js/hoverable-collapse.js') }}"></script>-->
    <!--<script src="{{ asset('js/misc.js') }}"></script>-->
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->


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
        $("#amount").on('keyup', function(){
             var n = parseInt($(this).val().replace(/\D/g,''),10);
             $(this).val(n.toLocaleString());
            
        });

        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
        $('#amount').on('keyup', function() {
            calculateBalance();
        });
        $('#balance_type').on('change', function() {
            calculateBalance();
        });

        function calculateBalance() {
            var old_available_balance = $('#old_available_balance').val();
            var old_ledge_balance = $('#old_ledge_balance').val();
            var balance_type = $('#balance_type').val();
            var amount = $('#amount').val();
            
            amount = amount.replace(/\,/g,'');      
            amount =parseInt(amount,10);      
            
            if(balance_type == 'available_balance') {
                var balance = parseInt(old_available_balance) + parseInt(amount);
            }
            else {
                var balance = parseInt(old_ledge_balance) + parseInt(amount);
            }
            balance= balance.toLocaleString();
            $('#balance').val(balance);
        }
    </script>  
</body>

</html>