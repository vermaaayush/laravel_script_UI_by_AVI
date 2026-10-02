@include('header')
<?php $stamp = DB::table('ba_extra_asset')->where('id','1')->first()->telex_stamp; ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Telex Stamp Image</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Telex Stamp Image</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @include('flash::message')
                                            <h4 class="card-title">Telex Stamp Image</h4>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" action="{{ url('telex-stamp') }}" enctype="multipart/form-data">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="file" name="image" onchange="readFile(this)" class="form-control" required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <img src="<?= asset('exasset/uploads/extra/').'/'.$stamp ?>" style="width:180px;"/>
                                                    </div>  
                                                </div>  
                                                <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                                            </form>
                                        </div>
                                    </div>
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
        function readFile(input) {
            if (input.files && input.files[0]) {
                var FileSize = input.files[0].size / 1024 / 1024; // in MB
                var extension = input.files[0].name.substring(input.files[0].name.lastIndexOf('.')+1);
                
                if (FileSize > 2) {
                    alert("Maxiumum File Size Is 2 Mb.");
                    input.value = '';
                    return false;
                }
                else{
                    if (extension == 'jpg' || extension == 'png' || extension == 'jpeg') {
                        
                    }
                    else
                    {
                        alert("Only Allowed '.jpg' OR '.png' OR '.jpeg' Extension ");
                        input.value = '';
                        return false;
                    }
                }
            }
        }
    </script>  
</body>

</html>