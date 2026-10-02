@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">IVR Message</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">IVR Message Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">IVR Messages</li>
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
                                            <a href="add-message"
                                                style="color:white;text-decoration: none;"> 
                                                <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="padding:10px 13px !important;">Add Message
                                                </button>
                                            </a>
                                        </div>
                                        
                                    </div><br><br>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                            <th>ID</th>
                                            <th>User name</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                                   
                                            </tr>
                                        </thead>
                                        <tbody>

                                             @foreach ($Ivr_Msg as $ivr)
                                            <tr>
                                                <td> {{ $ivr->id }} </td>
                                                <td> {{ $ivr->users->cust_name.' '.$ivr->users->middle_name.' '.$ivr->users->sur_name }} </td>
                                                 <td> {{ $ivr->message }} </td>
                                               
                                                 @if($ivr->status == 0)         
                                                   <td>Unread</td>
                                                 @endif
                                                 @if($ivr->status == 1)         
                                                    <td>Read</td>
                                                @endif
                                                
                                                <td> 
                                                    
                                                    <a href="delete-msg/{{$ivr->id}}"
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