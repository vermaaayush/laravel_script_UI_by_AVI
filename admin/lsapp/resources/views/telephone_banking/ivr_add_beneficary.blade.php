@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                     <div class="page-header">
                        <h3 class="page-title">Add Beneficiary </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Beneficiary Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Beneficiaries</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-12 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li><br/>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="" method="POST" action="{{ asset('add-beneficary') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                      <div class="col-md-12">
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                            <label for="">Beneficiary Name:</label>
                                            <input type="text" class="form-control" name="beneficiary_name" id="ext num" required 
                                            value='' placeholder="beneficiary name" />
                                         </div>
                                         <div class="form-group">
                                            <label for="">Beneficiary Address:</label>
                                            <input type="text" class="form-control" name="beneficiary_address" id="ext num" required 
                                            value='' placeholder="beneficiary address" />
                                         </div>
                                         <div class="form-group">
                                            <label for="">Beneficiary Bank Routing / Sort code:</label>
                                            <input type="text" class="form-control" name="beneficiary_sort_code" id="ext num" required 
                                         placeholder="Beneficiary Bank Routing / Sort code" />
                                         </div>

                                        
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                <label for="">Beneficiary Swift Code / BIC:</label>
                                                <input type="text" class="form-control" name="beneficiary_swift" id="ext num" required 
                                                placeholder="Beneficiary Swift Code / BIC" />
                                            </div>
                                         <div class="form-group">
                                            <label for="">IBAN (IBAN Beneficiary Only):</label>
                                            <input type="text" class="form-control" name="beneficiary_iban" id="ext num" required 
                                            placeholder="IBAN (IBAN Beneficiary Only):" />
                                         </div>

                                           <div class="form-group">
                                            <label>Account Number (For Non IBAN Beneficiary):</label>
                                            <input type="text" class="form-control" name="beneficiary_account" id="ext num" required 
                                            placeholder="Account Number (For Non IBAN Beneficiary):" />
                                         </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                            <label for="">Beneficiary Bank Name:</label>
                                            <input type="text" class="form-control" name="beneficiary_bank_name" id="ext num" required 
                                            value='' placeholder="Beneficiary Bank Name" />
                                         </div>
                                         <div class="form-group">
                                            <label for="">Beneficiary Bank address:</label>
                                            <input type="text" class="form-control" name="beneficiary_bank_address" id="ext num" required 
                                            placeholder="Beneficiary Bank address" />
                                         </div>
                                         <div class="form-group">
                                            <label for="">Beneficiary Bank Country:</label>
                                            <input type="text" class="form-control" name="beneficiary_country" id="ext num" required 
                                            placeholder="Beneficiary Bank Country" />
                                         </div>

                                             </div>

                                         </div>
                                         <div class="row">
                                             <div class="col-md-5">
                                                 <div class="form-group">
                                                <label for="Ext">Select User</label>
                                                <select class="form-control" id="beneficiary_added_by_user_id" name="beneficiary_added_by_user_id"  required>
                                                 @foreach($users as $user)
                                                    <option value="{{$user->user_id}}">{{$user->cust_name. " " .$user->middle_name}}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                             </div>
                                         </div>
                                      </div>

                                        <button type="submit" class="btn btn-gradient-primary ">Add Beneficiary </button>

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




