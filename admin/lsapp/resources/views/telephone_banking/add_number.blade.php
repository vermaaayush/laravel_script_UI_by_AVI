@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">Support Number</h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Support Management</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Add Number</li>

                            </ol>

                        </nav>

                    </div>


                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-7 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Add Number</h4>

                                    <form class="" method="POST" action="{{ asset('add-new-numbers') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">

                                        <div class="form-group">

                                            <label for="Support Phone">Support Phone #</label>

                                            <input type="text" class="form-control" name="support_number" id="support_number" required value=""
                                             placeholder="Phone" />

                                        </div>

                                        <div class="form-group">

                                            <label for="Ext">Ext #</label>

                                            <input type="text" class="form-control" name="ext_number" id="ext_number" required value=""
                                             placeholder="Ext" />

                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary mr-2">Add New Number</button>

                                    </form>

                                </div>

                            </div>

                        </div>

                        <!--Todo Section of Row-->


                    </div>

                   
                 

                    <!-- partial -->

                </div>
                <!-- content-wrapper ends -->

@include('footer_2')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

   
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
</body>

</html>




