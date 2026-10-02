@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">Edit Currency</h3>

                        

                    </div>


                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-7 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')
                                

                                    <form class="" method="POST" action="{{ asset('/update_currency') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                        
                                        <input type="text"  name="id" value="{{$currencies[0]->id}}"  hidden/>

                                        <div class="form-group">

                                            <label for="Support Phone">Token</label>

                                            <input type="text" class="form-control test-input" name="c_icon" value="{{$currencies[0]->currency}}"  required
                                             placeholder="Enter Access Token"/>

                                        </div>
                                      
                                       <div class="form-group">

                                            <label for="Support Phone">Token</label>

                                            <input type="text" class="form-control test-input" name="c_name" value="{{$currencies[0]->currency_name}}"  required
                                             placeholder="Enter Access Token" />

                                        </div>
                                        
                                       
                                        
                                    
                                        
                                       


                                        <button type="submit" class="btn btn-gradient-primary mr-2">Update Token</button>

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




