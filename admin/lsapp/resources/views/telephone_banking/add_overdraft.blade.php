@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                     <div class="page-header">
                        <h3 class="page-title">Add in Overdraft</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Add in Overdraft</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add in Overdraft</li>
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

                                    <form class="" method="POST" action="{{ asset('add_overdraft_now') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                         

                                            <div class="form-group">
                                                <label for="Ext">Select User</label>
                                                <select  class="form-control select_tag" id="user_id" name="user_id"  required>
                                                 @foreach($users as $user)
                                               
                                                    <option value="{{$user->user_id}}">{{$user->cust_name. " " .$user->middle_name}}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                            
                                         

                                        <button type="submit" class="btn btn-gradient-primary ">Add Now </button>

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
  
</body>

</html>




