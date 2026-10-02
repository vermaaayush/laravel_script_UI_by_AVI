@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">IVR Transfer Suspend Status</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">IVR Transfer Suspend Status</a></li>
                                <li class="breadcrumb-item active" aria-current="page">IVR Transfer Suspend Status</li>
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
                                            <a href="add_transfer_status"
                                                style="color:white;text-decoration: none;"> 
                                                <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="padding:10px 13px !important;">Add Status
                                                </button>
                                            </a>
                                        </div>
                                                                              <div class="col-md-9 stretch">
                                    
   <?php
   $x = DB::select('select * from configs');
   
  
   ?>                                 
<form class="form-inline" method="POST" action="{{ asset('suspend_status_position') }}">
  <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
  <div class="form-group mx-sm-3 mb-2">
    <input class="form-check-input" type="radio" name="trsf_position" id="exampleRadios2" value="before" <?php if($x[0]->trans_status_position=='before'){ ?> checked   <?php } ?>>
  <label class="form-check-label" for="exampleRadios2">
    Before 
  </label>
  </div>
  <div class="form-group mx-sm-3 mb-2">
    <input class="form-check-input" type="radio" name="trsf_position" id="exampleRadios1" value="after"   <?php if($x[0]->trans_status_position=='after'){ ?> checked   <?php } ?>>
  <label class="form-check-label" for="exampleRadios1">
    After 
  </label>
  </div>

  <button type="submit" class="btn btn-primary btn-lg" style="padding:10px 13px !important;">Update</button>
</form>
                                        </div>
                                        
                                    </div><br><br>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                            <th>User ID</th>
                                            <th>User name</th>
                                            <th>Heading</th>
                                            <th>Status</th>
                                           
                                            <th>Action</th>
                                                   
                                            </tr>
                                        </thead>
                                        <tbody>

                                             @foreach ($Ivr_Msg as $ivr)
                                              

 
                                           
                                            
                                            
                                            <tr>
                                                <td> {{ $ivr->user_id }} </td>
                                                
                                            <td> {{ $ivr->users->cust_name.' '.$ivr->users->middle_name.' '.$ivr->users->sur_name }} </td>
                                                <td>{{ $ivr->heading }}</td>
                                                <td><textarea class="form-control">{{ $ivr->message }}</textarea> </td>
                                               
                                               
                                                <td> 
                                                    
                                                    <a href="delete-transfer-status/{{$ivr->id}}"
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
                               <span > </span>
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