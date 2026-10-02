@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Tranfer Footer Text</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Tranfer Footer Text</a></li>
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
                                            <h4 class="card-title">Tranfer Footer Text</h4>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" action="{{ url('transfer-footer') }}">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                <div class="form-group">
                                                    <!--<label>Profile Status Message</label> -->
                                                    <textarea type="text" name="content" id="editor" rows="8" class="form-control" placeholder="Tranfer Footer Text" ><?= $extra->loan_landing_text ?></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
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
    <script src="<?= asset('exasset/ckeditor/ckeditor.js') ?>"></script>

    <script type="text/javascript">
    	var toolbarGroups = [
    	    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    	    { name: 'forms', groups: [ 'forms' ] },
    	    '/',
    	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    	    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    	    '/',
    	    { name: 'styles', groups: [ 'styles' ] },
    	    { name: 'colors', groups: [ 'colors' ] },
    	    { name: 'tools', groups: [ 'tools' ] },
    	    { name: 'others', groups: [ 'others' ] }
    	];
        CKEDITOR.replace( 'editor',{
    	    toolbar : 'Basic',
    	    toolbarGroups,
       	});
    </script>
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
</body>

</html>