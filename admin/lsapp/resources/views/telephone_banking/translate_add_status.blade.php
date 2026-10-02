@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                     <div class="page-header">
                        <h3 class="page-title">Add Transfer Suspended Status</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Transfer Suspended Status</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Transfer Suspended Status</li>
                            </ol>
                        </nav>
                    </div>


                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-7 grid-margin stretch-card">

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

                                    <form class="" method="POST" action="{{ asset('add_trasfer_status') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                         

                                            <div class="form-group">
                                                <label for="Ext">Select User</label>
                                                <select  class="form-control select_tag" id="user_id" name="user_id"  required>
                                                 @foreach($users as $user)
                                                 <option >Select User</option>
                                                    <option value="{{$user->user_id}}">{{$user->cust_name. " " .$user->middle_name}}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="form-group" style="display:none" id="text_control">

                                            <label for="Ext">Heading</label>
                                             <input type="text" name="heading" class="form-control" placeholder="e.g. Transfer Failed" value="Transfer Failed" />

                                            <br>
                                            <label for="Ext">Transfer Status</label>
                                            <?php
                                            $msg = DB::table('default_status')->where('id', '2')->first();
                                            ?>
                                             <textarea name="message" class="form-control" id="" cols="15" rows="8">{{$msg->msg}}</textarea>

                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary ">Add Message </button>

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
    
    <script type="text/javascript">
   $(function(){
    //Whenever the value of #country changes, do:
    $(".select_tag").on('change', function() {
        //Get the new value
     
      document.getElementById("text_control").style.display = "block";
    });
});
</script>
</body>

</html>




