@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Access Token</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Support Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Access Token</li>
                            </ol>
                        </nav>
                    </div> 

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                     @include('flash::message')
                                      <div class="row">
                                       
                                        <div class="col-md-3 stretch">
                                            <a href="add_access_token"
                                                style="color:white;text-decoration: none;"> 
                                                <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="padding:10px 13px !important;">Add Token
                                                </button>
                                            </a>
                                        </div>
                                        
                                        <div class="col-md-9 stretch">
                                    
   <?php
   $x = DB::select('select * from configs');
   
  
   ?>                                 
<form class="form-inline" method="POST" action="{{ asset('access_token_onoff') }}">
  <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
  <div class="form-group mx-sm-3 mb-2">
    <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" <?php if($x[0]->access_token_status==0){ ?> checked   <?php } ?>>
  <label class="form-check-label" for="exampleRadios2">
    Disable
  </label>
  </div>
  <div class="form-group mx-sm-3 mb-2">
    <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1"   <?php if($x[0]->access_token_status==1){ ?> checked   <?php } ?>>
  <label class="form-check-label" for="exampleRadios1">
    Enable
  </label>
  </div>

  <button type="submit" class="btn btn-primary btn-lg" style="padding:10px 13px !important;">Update</button>
</form>
                                        </div>
                                        
                                    </div><br><br>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                   
                                                <th>Token</th>
                                              
                                                <th>Actions</th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Ivr_Msg as $Ivr_Msg)
                                            <tr>
                                               
                                                <td> {{ $Ivr_Msg->token }} </td>
                                                <td> 
                                                
                                                    <a href="edit-access-token/{{ $Ivr_Msg->id }}"
                                                        style="color: white;  text-decoration: none;"> 
                                                        <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT
                                                        </button>
                                                    </a>
                                                  
                                                    <a href="delete-access-token/{{ $Ivr_Msg->id }}"
                                                        style="color: white;  text-decoration: none;"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button>
                                                    </a>
                                                </td>
                                                                                             
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pages" style="position: relative;left: 415px;">
                               
                           </div>
                            </div>
                        </div>
                    </div>
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