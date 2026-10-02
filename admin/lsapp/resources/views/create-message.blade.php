@include('header')
<style>
    span.select2.select2-container {
        display: block !important;
    }
</style>
            <!-- partial -->

            <div class="main-panel">

                <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">Support Message</h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Support</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Support Message</li>

                            </ol>

                        </nav>

                    </div>



                    <div class="row">



                        <!-- Transation status section of row-->

                        <div class="col-md-7 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Email Support</h4>

                                    <form class="forms-sample" method="POST" action="{{ asset('insert-email-message') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">



                                        <div class="form-group">

                                            <label for="exampleInputEmail3">Recipient email address</label>

                                            <input type="email" class="form-control" name="email" id="email" required value="" placeholder="Email" />

                                        </div>



                                        <div class="form-group">

                                            <label for="exampleInputCity1">Subject</label>

                                            <input type="text" class="form-control" name="subject" id="subject" required value="" placeholder="Email Subject" />

                                        </div>



                                        <div class="form-group">

                                            <label for="exampleTextarea1">Message</label>

                                            <textarea class="form-control" name="message" id="message" required rows="12" placeholder="Message"></textarea>

                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary mr-2">Send Email</button>

                                    </form>

                                </div>

                            </div>

                        </div>



                        <!--Todo Section of Row-->

                        <div class="col-md-5 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">

                                    <h4 class="card-title">SMS or Push Notification Support</h4>

                                    <form class="forms-sample" method="POST" action="{{ asset('insert-sms-push') }}">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                        <div class="form-group">

                                            <label for="exampleSelectGender">Message Type</label>

                                            <select class="form-control" name="msg_type" id="msg_type" required>

                                                <option value="sms">SMS</option>

                                                <option value="push">Push Notification</option>

                                            </select>

                                        </div>
                                        <div class="form-group">

                                            <label for="exampleSelectGender">Account Manager</label>

                                            <select class="form-control" name="account_manager" id="manager" >
                                                <option value="">Select Account Manager</option>
                                                @foreach($managers as $manager)
                                                    <option value="{{ $manager->name }}">{{ $manager->name  }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="form-group" id="audience_type_div" style="display: none;">

                                            <label for="exampleSelectGender">Audience Type</label>

                                            <select class="form-control" name="audience_type" id="audience_type">

                                                <option value="all">All</option>

                                                <option value="specific">Specific</option>

                                            </select>

                                        </div>

                                        <div class="form-group" id="customer_div" style="display: none;">

                                            <label for="exampleSelectGender">Customer</label>

                                            <select class="form-control" name="customer[]" id="customer" multiple>
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $cust)
                                                    <option value="{{ $cust->id }}">{{ $cust->cust_name . " " . $cust->middle_name . " " . $cust->sur_name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        

                                        <div class="form-group" id="phone_div">

                                            <label for="exampleInputEmail3">Recipient phone number</label>

                                            <input type="text" class="form-control" name="phone" id="phone" required value=""  placeholder="Phone Number" />

                                        </div>



                                        <div class="form-group">

                                            <label for="exampleTextarea1">Message</label>

                                            <textarea class="form-control" name="message" id="message" required rows="12"></textarea>

                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary mr-2">Send Message</button>

                                        <button class="btn btn-light">Cancel</button>

                                    </form>

                                </div>

                            </div>

                        </div>



                    </div>

                    <!-- content-wrapper ends -->





                    <!-- partial:../../partials/_footer.html -->

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

        <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>

        <!-- <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script> -->

        <!-- endinject -->

        <!-- Plugin js for this page -->

        <!-- End plugin js for this page -->

        <!-- inject:js -->

        <script src="{{ asset('js/off-canvas.js') }}"></script>

        <script src="{{ asset('js/hoverable-collapse.js') }}"></script>

        <script src="{{ asset('js/misc.js') }}"></script>

        <!-- endinject -->
        <script>
            jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
        </script>

        <script>
            function reset() {
                $('#audience_type_div').hide();
                $('#audience_type').removeAttr('required');
                $('#phone_div').hide();
                $('#phone').removeAttr('required');
            }
            $(document).on('change', '#msg_type', function() {
                var msg_type = $(this).val();

                reset();

                if(msg_type == 'push') {
                    $('#audience_type_div').show();
                    $('#audience_type').attr('required', true);
                }

                if(msg_type == 'sms') {
                    $('#phone_div').show();
                    $('#phone').attr('required', true);
                }
            });

            function reset2() {
                $('#customer_div').hide();
                $('#customer').removeAttr('required');
            }

            $(document).on('change', '#audience_type', function() {
                var audience_type = $(this).val();

                reset2();

                if(audience_type == 'specific') {
                    $('#customer_div').show();
                    $('#customer').attr('required', true);
                }
            });
            $(document).ready(function() {
                $('#customer').select2({
                    placeholder: "Select Customer"
                });
            });
        </script>
</body>



</html>