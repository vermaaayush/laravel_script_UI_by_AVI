@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Payment Methods</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Payment Methods</a></li>
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
                                            <h4 class="card-title">List of all Payment Methods</h4>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--<div class="col-md-4">-->
                                        <!--    <form method="post" action="deposit-methods">-->
                                        <!--        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">-->
                                        <!--        <div class="form-group">-->
                                        <!--            <label>Method</label> -->
                                        <!--            <input type="text" name="type" class="form-control" placeholder="Method" required/>-->
                                        <!--        </div>-->
                                        <!--        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>-->
                                        <!--    </form>-->
                                        <!--</div>-->
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Method</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payment_methods as $mthod)
                                                        <tr>
                                                            <td><?= $mthod->name ?></td>
                                                            <td>
                                                                <a href="#" class="btn btn-primary btn-sm" onclick="showModal('<?= $mthod->id ?>');">
                                                                    Edit
                                                                </a>
                                                                <div class="modal fade" id="instructionModal<?= $mthod->id ?>" tabindex="-1" role="dialog">
                                                                    <form method="post" action="inv-payment-methods">
                                                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" >Instructions <?= $mthod->name ?></h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control" rows="8" name="instr" placeholder="Instructions For <?= $mthod->name ?>" required><?= $mthod->description ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <input type="hidden" name="id" value="<?= $mthod->id ?>"/>
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
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
    <!-- endinject -->
    <script>
        function showModal(id){
            $('#instructionModal'+id).modal('show');
        }
    </script>
</body>

</html>