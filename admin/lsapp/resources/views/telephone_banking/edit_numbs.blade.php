
 @include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">Support Number</h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Support Management</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Edit Number</li>

                            </ol>

                        </nav>

                    </div>


                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-7 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Edit Number</h4>

                                   <form class="" method="POST" action="{{ asset('update-numberz') }}">

                                        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                         <input type = "hidden" name = "id" value = "{{$sup_numbs[0]->id}}">
                                        <div class="form-group">
                                            <label for="">Support Phone #</label>
                                            <input type="text" class="form-control" name="support_number" id="sup num" required 
                                            value='{{$sup_numbs[0]->support_number}}' placeholder="support number" />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ext #</label>
                                            <input type="text" class="form-control" name="ext_number" id="ext num" required 
                                            value='{{$sup_numbs[0]->ext_number}}' placeholder="ext number" />
                                        </div>
                                       
                                        <button type="submit" class="btn btn-gradient-primary mr-2">Update
                                            </button>
                                        <button class="btn btn-light">Cancel</button>
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

    <!---->
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
   {{--  <script>
        $('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  --}}
</body>

</html>




