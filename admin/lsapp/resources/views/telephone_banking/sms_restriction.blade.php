@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                     <div class="page-header">
                        <h3 class="page-title">Sms Restriction</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Sms Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sms Restriction</li>
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

                                <form class="" method="POST" action="{{ asset('add-rest') }}">

                                  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                                                 
                                        <div class="col-md-12">
                                            <div class="row">
                                          @foreach($SmsEditor as $sms)
                                          
                              
                                       <div class="col-md-6">
                                         <div class="form-group">
                                     
                                        <label class="">{{$sms->type}}</label>
                                        <input type="hidden" name="type[{{$sms->type}}]" id="{{$sms->type}}" value="{{$sms->verification}}">
                                           <div class="checkbox">
                                           <input type="checkbox"  
                                           class="form-control" 
                                             id="check_{{$sms->type}}" onClick="checkingValue('{{$sms->type}}')"  {{(( $sms->verification == 1)? 'checked':'')}} >  
                                           </div>
                                     
                                        </div>
                                    
                                       </div>
                                     
                                          
                                          @endforeach
                                          
                                          </div>

                                   <button type="submit" class="btn btn-gradient-primary mr-2">Update

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
        function checkingValue(id){
     
            if ($('#check_'+id).is(":checked"))
            {
                  $("#"+id).val(1);
            }else{
                
                   $("#"+id).val(0);  
                    
            }
        }
    </script>  
</body>

</html>




