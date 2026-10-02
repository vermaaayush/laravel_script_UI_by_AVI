@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Bank Account Types</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Bank Account Types</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('flash::message')
                                            <h4 class="card-title">List of all Bank Account Types</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form method="post" action="bankaccount-types">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                <div class="form-group">
                                                    <label>Account Type</label> 
                                                    <input type="text" name="name" class="form-control" placeholder="Account Type" required/>
                                                </div>
                                                <button type="submit" class="btn btn-gradient-primary mr-2">Add Account Type</button>
                                            </form>
                                        </div>
                                        <div class="col-md-8">
                                            <table class="table table-striped tblResponsiveKava">
                                                <thead>
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Account Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($list as $key =>  $single)
                                                        <tr>
                                                            <td><?= $key + 1 ?></td>
                                                            <td><?= $single->type_name ?></td>
                                                            <td>
                                                                <a href="#" class="btn btn-primary btn-sm" onclick="showModal('<?= $single->id ?>');">
                                                                    Edit
                                                                </a>
                                                                <a href="{{ asset('bankaccount-types').'/' . $single->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <div class="modal fade" id="secModel<?= $single->id ?>" tabindex="-1" role="dialog">
                                                            <form method="post" action="bankaccount-types-update">
                                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" >Edit Account Type</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <input type="text" name="name" class="form-control" placeholder="Account Type" value="<?= $single->type_name ?>" required/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <input type="hidden" name="id" value="<?= $single->id ?>"/>
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
        function showModal(id){
            $('#secModel'+id).modal('show');
        }
    </script>
</body>

</html>