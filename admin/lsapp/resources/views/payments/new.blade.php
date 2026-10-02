@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Add Invoice</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Add Invoice</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Add Invoice Form</h4>
                                    <form action="payment-save" method="POST" class="forms-sample" enctype="multipart/form-data">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Date of Invoice</label>
                                            <input type="date" class="form-control" name="date" required value="" placeholder="Date of Invoice" />
                                        </div>
                                        <div class="form-group" id="customer_div">
                                            <label for="exampleSelectGender">Customer</label>
                                            <select class="form-control" name="customer" required>
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $cust)
                                                    <option value="{{ $cust->id }}">{{ $cust->cust_name . " " . $cust->middle_name . " " . $cust->sur_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Invoice Name</label>
                                            <input type="text" class="form-control" name="inv" required value="" placeholder="Invoice Name" />
                                        </div>
                                        <div class="col-md-2" style="display: inline-block; padding-left: 0px !important; padding-right: 0px !important;">
                                            <div class="form-group">
                                                <label for="exampleSelectGender">Currency</label>
                                                <input type="text" name="currency" class="form-control" value="USD" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-8" style="display: inline-block; padding-left: 0px !important; padding-right: 0px !important;">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Invoice Amount</label>
                                                <input type="text" class="form-control decimal-num" name="amount" required value="" placeholder="Invoice Amount" />
                                            </div>    
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectGender">Payment Option</label>
                                            <select class="form-control" name="payment_option">
                                                <option value="">Select Payment Option</option>
                                                <option value="both">Both</option>
                                                <option value="bank">Bank</option>
                                                <option value="bitcoin">Bitcoin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Description</label>
                                            <textarea type="text" class="form-control" name="descr" rows="5" required value="" placeholder="Description" ></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>

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

    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
    <script>
        $(function(){
            $(document).on('keydown','.decimal-num', function(event){

        
        		if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {
        
        		} else {
        			event.preventDefault();
        		}
        		
        		if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
        			event.preventDefault();
        
        		if($(this).val().indexOf('.') !== -1 && event.keyCode == 110)
        			event.preventDefault();
        
        	});
        })
    </script>
    <!-- endinject -->
</body>

</html>