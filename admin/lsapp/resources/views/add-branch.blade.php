@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Add Bank Branch</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Branches</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Bank Branch</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Add Bank Branch</h4>
                                    <p class="card-description"> Add all Branch details to create</p>

                                    <form action="insert-branch" method="POST" class="forms-sample">
                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Branch Name</label>
                                            <input type="text" class="form-control" name="branch_name" id="branch_name" required value="" placeholder="Branch Name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Branch Code</label>
                                            <input type="text" class="form-control" name="branch_code" id="branch_code" required value="" placeholder="Branch Code" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">IFSC Code</label>
                                            <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" required value="" placeholder="IFSC Code" />
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1"> Branch Address</label>
                                            <input type="text" class="form-control" name="branch_add" id="branch_add" required value="" placeholder="Branch Address" />
                                        </div>
                                        
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Add
                                            Branch</button>
                                        <a href="branches" class="btn btn-light">Cancel</a>
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
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/file-upload.js"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
    <!-- End custom js for this page -->
</body>

</html>