@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                     <div class="page-header">
                        <h3 class="page-title">Edit Tokens </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Tokens Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Tokens</li>
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

                                <form class="" method="POST" action="{{ asset('update-tokens') }}">

                                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                               <input type = "hidden" name = "id" 
                                               value = "{{$Ivr_token->id}}">                                      
                                        <div class="col-md-12">
                                            <div class="row">
                                             <div class="col-md-5">
                                                 <div class="form-group">
                                                <label for="Ext"> User name</label>
                                                 <input class="form-control" type="text" readonly value="{{ $Ivr_token->users->cust_name.' '.$Ivr_token->users->middle_name.' '.$Ivr_token->users->sur_name }}">
                                                <!--<select class="form-control" id="user_id" name="user_id" required>
                                                 @foreach($users as $user)
                                                    <option value="{{$user->user_id}}">{{$user->cust_name. " " .$user->middle_name}}</option>
                                                  @endforeach
                                                </select>-->
                                            </div>
                                             </div>
                                         </div>
                                            
                                               <div class="row">
                                                   <div class="col-md-6">
                                                       <div class="form-group">

                                            <label for="Support Phone">Code 1 </label>

                                            <input type="text" class="form-control" name="code_1" id="code_1 " 
                                             value="{{$Ivr_token->code_1}}"
                                             placeholder="Code 1 " />

                                            </div>  
                                             <div class="form-group">

                                            <label for="Support Phone">Code Name 1 </label>

                                            <input type="text" class="form-control" name="code_name_1" id="code_name_1 " 
                                             value="{{$Ivr_token->code_name_1}}"
                                             placeholder="Code name 1 " />

                                            </div>
                                            <div class="form-group">

                                                <label for="Support Phone">Code 2</label>

                                                <input type="text" class="form-control" name="code_2" id="code_2"  
                                                value="{{$Ivr_token->code_2}}"
                                                 placeholder="Code 2" />
                                           </div>
                                           <div class="form-group">

                                            <label for="Support Phone">Code Name 2 </label>

                                            <input type="text" class="form-control" name="code_name_2" id="code_name_2 " 
                                             value="{{$Ivr_token->code_name_2}}"
                                             placeholder="Code name 2" />

                                            </div>
                                                   </div>
                                                   <div class="col-md-6">
                                                    <br><br><br>
                                                        <div class="form-group col-md-4">

                                            <label for="Support Phone">Allow Code 1</label>

                                           <input type="checkbox" value="{{$Ivr_token->allow_code_1}}" 
                                           {{ $Ivr_token->allow_code_1=='1' ? 'checked' : '' }}
                                           class="form-control" 
                                           name="allow_code_1" >

                                            </div>
                                            <br><br><br><br><br>
                                            <div class="form-group col-md-4">

                                            <label for="Support Phone">Allow Code 2</label>

                                           <input type="checkbox" value="{{$Ivr_token->allow_code_2}}"
                                           {{ $Ivr_token->allow_code_2=='1' ? 'checked' : '' }}
                                           class="form-control" name="allow_code_2" >

                                            </div>
                                                   </div>
                                               </div>

                                                 <div class="row">
                                                   <div class="col-md-6">
                                                      
                                             <div class="form-group">

                                            <label for="Support Phone">Code 3 </label>

                                            <input type="text" class="form-control" name="code_3" id="code_3" 
                                               value="{{$Ivr_token->code_3}}"

                                             placeholder="Code 3" />

                                            </div>
                                            
                                             <div class="form-group">

                                            <label for="Support Phone">Code Name 3 </label>

                                            <input type="text" class="form-control" name="code_name_3" id="code_name_3" 
                                               value="{{$Ivr_token->code_name_3}}"

                                             placeholder="Code name 3" />

                                            </div>
                                                   </div>
                                                   <div class="col-md-6">
                                                       
                                                     <div class="form-group col-md-4" style="margin-top: 50px;">

                                            <label for="Support Phone">Allow Code 3</label>

                                           <input type="checkbox" value="{{$Ivr_token->allow_code_3}}"
                                           {{ $Ivr_token->allow_code_3=='1' ? 'checked' : '' }}
                                           class="form-control" name="allow_code_3" >

                                            </div>
                                                   </div>

                                   </div>

                                   <button type="submit" class="btn btn-gradient-primary mr-2">Update Token

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

@include('footer')
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




