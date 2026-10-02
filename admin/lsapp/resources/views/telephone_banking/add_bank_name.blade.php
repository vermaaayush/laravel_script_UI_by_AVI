@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                    <div class="page-header">
                        <h3 class="page-title">Add Bank Name </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Tokens Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Tokens</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-12 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li><br/>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                    @include('flash::message')

                                <form class="" method="POST" action="{{ asset('store_bank_name') }}">

                                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                               <input type = "hidden" name = "id" value = "{{-- {{$ivr_message[0]->id}} --}}">                                      
                                        <div class="col-md-12">
                                            <div class="row">
                                             <div class="col-md-5">
                                                 <div class="form-group">
                                                <label for="Ext">Select User</label>
                                                <select class="form-control" id="customer_id" name="customer_id" required>
                                                 @foreach($users as $user)
                                                    <option value="{{$user->customer_id}}">{{$user->cust_name. " " .$user->middle_name}}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                             </div>
                                         </div>
                                            
                                              

                                               <div class="row">
                                                  
                                           
                                               </div>

                                                 <div class="row">
                                                   <div class="col-md-6">
                                                      
                                             <div class="form-group">

                                            <label for="Support Phone">Bank Name</label>

                                            <input type="text" class="form-control" name="bank_name" id="code_3" 
                                               value=""

                                             placeholder="Enter Bank Name" />

                                            </div>
                                           
                                            
                                                   </div>
                                                  

                                   </div>

                                                
                                   <button type="submit" class="btn btn-gradient-primary mr-2">Add Now

                                                    </button>

                                               

                                            </form>
                                        </div>   
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




