@include('header3')
<style>
    span.select2.select2-container {
        display: block !important;
    }
</style>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Set User Withdrawal</h3>
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
                                <li class="breadcrumb-item active" aria-current="page">Set User Withdrawal</li>
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
                                    <h4 class="card-title">Set User Withdrawal</h4>
                                    <p class="card-description"> Enter details to set User Withdrawal </p>
                                    <form class="forms-sample" method="POST" action="{{ asset('set-user-withdrawal') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <input type = "hidden" name = "account_id" value = "{{ $account[0]->id }}">
                                        <input type = "hidden" name = "account_no" value = "{{ $account[0]->account_no }}">
                                        <input type = "hidden" name = "user_id" value = "{{ $customer[0]->user_id }}">

                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Account No.</label>
                                            <p>{{ $account[0]->account_no }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Set</label>
                                            <select class="form-control" name="set" id="set" required>
                                                <option value="1" @if(isset($withdrawal[0])) selected @endif>Yes</option>
                                                <option value="0" @if(!isset($withdrawal[0])) selected @endif>No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            $method_arr = array();
                                            if(isset($withdrawal[0])) {
                                                $method_arr = explode(",", $withdrawal[0]->method);
                                            }
                                            ?>
                                            <label for="exampleInputConfirmPassword1">Payment Method</label>
                                            <select class="form-control" name="method[]" id="method" required multiple>
                                                <option value="">Select Payment Method</option>
                                                <option value="Bitcoin" <?php if(in_array('Bitcoin', $method_arr)) { echo "selected"; } ?>>Bitcoin</option>
                                                <option value="Ethereum" <?php if(in_array('Ethereum', $method_arr)) { echo "selected"; } ?>>Ethereum</option>
                                                <option value="Bitcoin Cash" <?php if(in_array('Bitcoin Cash', $method_arr)) { echo "selected"; } ?>>Bitcoin Cash</option>
                                                <option value="Cash Drop off" <?php if(in_array('Cash Drop off', $method_arr)) { echo "selected"; } ?>>Cash Drop off</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount" required value="@if(isset($withdrawal[0])) {{ $withdrawal[0]->amount }} @endif" placeholder="0.00" />
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
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
    <!-- plugins:js -->
    <!-- <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script> -->
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
        $(document).ready(function() {
            $('#method').select2({
                placeholder: "Select Payment Method"
            });

            $('#set').on('change', function() {
                var set = $('#set').val();
                if(set == 1) {
                    $('#method').attr('required', true).removeAttr('readonly').removeAttr('disabled');
                    $('#amount').attr('required', true).removeAttr('readonly');
                }
                else {
                    // $('#method').attr('readonly', true).removeAttr('required');
                    $('#method').attr("readonly", true).attr("disabled", true).removeAttr('required');
                    $('#amount').attr('readonly', true).removeAttr('required');
                }
            });
        });
    </script>  
</body>

</html>