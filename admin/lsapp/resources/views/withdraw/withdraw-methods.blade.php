@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Withdraw Methods</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Withdraw Methods</a></li>
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
                                            <h4 class="card-title">List of all Withdraw Methods</h4>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--<div class="col-md-4">-->
                                        <!--    <form method="post" action="withdraw-methods">-->
                                        <!--        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">-->
                                        <!--        <div class="form-group">-->
                                        <!--            <label>Method</label> -->
                                        <!--            <input type="text" name="type" class="form-control" placeholder="Method" required/>-->
                                        <!--        </div>-->
                                        <!--        <div class="form-group">-->
                                        <!--            <label>Lable Text</label> -->
                                        <!--            <input type="text" name="lable" class="form-control" placeholder="Lable Text" required/>-->
                                        <!--        </div>-->
                                        <!--        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>-->
                                        <!--    </form>-->
                                        <!--</div>-->
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Method</th>
                                                        <th>Lable Text</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($withdraw_methods as $mthod)
                                                        <?php $getDisbled = DB::table('ba_withdraw_method_endi')->where('mid',$mthod->id)->first() ?>
                                                        <tr>
                                                            <td><?= $mthod->name ?></td>
                                                            <td><?= $mthod->title ?></td>
                                                            <td>
                                                                <?php if(!$getDisbled){ ?>
                                                                    <a href="withdraw-methods-status/<?= $mthod->id ?>/0" class="btn btn-success btn-sm">
                                                                        Enabled
                                                                    </a>
                                                                <?php }else{ ?>
                                                                    <a href="withdraw-methods-status/<?= $mthod->id ?>/1" class="btn btn-danger btn-sm">
                                                                        Disabled
                                                                    </a>
                                                                <?php } ?>
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