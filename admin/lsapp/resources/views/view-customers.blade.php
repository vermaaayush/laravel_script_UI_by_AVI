@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">View All Customers</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View All Customers</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">List of all Users</h4>
                                    <p class="card-description"> All registered users</p>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Account Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $config = DB::select('select * from configs WHERE id = ?',[1]);
                                        @endphp
                                            @foreach ($customers as $customer)
                                            <tr>
                                                <td> {{ $customer->id }} </td>
                                                <td class="py-1">
   
                                                    <?php if($customer->cust_photo != '') { ?>
                                                     <?php if(strpos($customer->cust_photo, 'data:image/') !== false) { ?>
                                                     <img src="{{ $customer->cust_photo }}" alt="image" />
                                                     <?php } else { ?>
                                                        <img src="{{ 'https://' . $config[0]->bank_url . '/admin/uploads/' . $customer->cust_photo }}" alt="image" />

                                                     <?php } ?>
                                                     <?php } ?>

                                                     @if($customer->cust_photo == '')
                                                    <img src="{{ asset('uploads/default.png') }}" class="card-img" alt="Profile Picture" />
                                                    @endif
                                                </td>
                                                <td> {{ $customer->cust_name . " " . $customer->middle_name . " " . $customer->sur_name }} </td>
                                                <td> {{ $customer->cust_mail }} </td>
                                                <td>
                                                    @if($customer->account_status == 0)
                                                        Pending
                                                    @elseif($customer->account_status == 1)
                                                        Approved
                                                    @elseif($customer->account_status == 2)
                                                        Suspended
                                                         @elseif($customer->account_status == 3)
                                                        Blocked
                                                         @elseif($customer->account_status == 4)
                                                        Temporary Restriction
                                                    @endif
                                          
                                                </td>
                                                <td>
                                                    <a href="view-customer/{{ $customer->id }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">VIEW</button></a>
                                                            
                                                    <a href="edit-customer/{{ $customer->id }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button></a>
                                                    
                                                    <a href="delete-customer/{{ $customer->id }}"
                                                        style="color: white;  text-decoration: none;"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button></a>
                                                        
                                                    @if($customer->account_status == 0)         
                                                    <br>
                                                    <a href="approve-access/{{ $customer->id }}"
                                                        style="color: white;  text-decoration: none;"><button type="button" class="btn btn-success btn-sm"
                                                        style="font-size: smaller;">APPROVE</button></a>
                                                    <a href="deny-access/{{ $customer->id }}"
                                                        style="color: white;  text-decoration: none;"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DENY</button></a>
                                                    @endif
                                                    <br>
                                                    <a href="profile-status-message/{{ $customer->id }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;margin-top:5px;">Profile status message</button></a>
                                                </td>
                                                <td>
                                                    <li class="nav-item" style="display:inline-block;">

                        <a class="nav-link btn btn-sm btn-success" data-toggle="collapse" href="#general-pages{{$customer->id}}" aria-expanded="false"

                            aria-controls="general-pages{{$customer->id}}">

                            <span class="menu-title">Access</span>

                            <i class="menu-arrow"></i>

                            <i class="mdi mdi-message menu-icon"></i>

                        </a>

                        <div class="collapse" id="general-pages{{$customer->id}}">

                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link @if($customer->account_status == 1) active-access @endif" href="activate-access/{{ $customer->id }}"> Activate </a></li>

                                <!-- <li class="nav-item"> <a class="nav-link" href="../support/inbox.html"> Inbox

                                        Messages</a></li> -->

                                <li class="nav-item"> <a class="nav-link @if($customer->account_status == 2) active-access @endif" href="suspend-access/{{ $customer->id }}"> Suspend(Restricted )</a></li>
                                
                                <li class="nav-item"> <a class="nav-link @if($customer->account_status == 4) active-access @endif" href="temporary-access/{{ $customer->id }}"> Temporal Restriction </a></li>
                                        
                                          <li class="nav-item"> <a class="nav-link @if($customer->account_status == 3) active-access @endif" href="block-access/{{ $customer->id  }}"> Block</a></li>

                            </ul>

                        </div>

                    </li>  <!-- Support Message Tab -->
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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


    <style>
        .active-access{
            background: #a5e9c0;
        }
    </style>
    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(15000);
    </script>  
</body>

</html>