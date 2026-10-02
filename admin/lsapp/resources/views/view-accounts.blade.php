@include('header2')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Customer Accounts</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customers') }}">View All Customers</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="{{ asset('view-customer/' . $customer[0]->id) }}">View Customer Details</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Customer Accounts</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @include('flash::message')
                                            <h4 class="card-title">Account Listed Under User</h4>
                                            <p class="card-description"> Account Listed Under User</p>
                                        </div>
                                    
                                            
                                        
                                        <div class="col-md-4">Account Title: {{$customer[0]->cust_name}} {{$customer[0]->middle_name}} </div>
                                        <div class="col-md-4 text-right">
                                            <a href="{{ asset('add-account/' . $customer[0]->id) }}"><button type="button"
                                            class="btn btn-gradient-success btn-icon-text">
                                            <i class="mdi mdi mdi-folder-plus btn-icon-prepend"></i> Add Account
                                        </button></a>
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                
                                                <th> Account Number </th>
                                                <th> Account Type </th>
                                                <th> Account Currency </th>
                                                <th> Balance </th>
                                                <th> Account Status </th>
                                                <th> Account Options </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accounts as $acc)
                                            
                                                <td>{{ $acc->account_no }}</td>

                                                <td>{{ $acc->account_type }}</td>
                                                <td>{{ $acc->account_currency }}</td>
                                                <td>{{ number_format($acc->available_balance, 0, '.', ',') }}</td>
                                                <td>
                                                     @if($acc->access == 1)
                                                        Active
                                                      @elseif($acc->access == 2)
                                                      Blocked
                                                      @elseif($acc->access == 3)
                                                     Suspended
                                                     @elseif($acc->access == 4)
                                                      Temporarily suspended
                                                      @endif
                                                </td>
                                               

                                                <td>
                                                    <a href="{{ asset('view-account/' . $acc->id) }}"
                                                        style="text-decoration: none;">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">VIEW</button> </a>
                                                    <a href="{{ asset('edit-account/' . $acc->id) }}"
                                                        style="text-decoration: none;">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button> </a>
                                                    

                                                    @if($acc->hidden == 0)
                                                    <a href="{{ asset('hide-account/' . $acc->id . '/' . $customer[0]->id) }}"><button type="button" class="btn btn-warning btn-sm"
                                                        style="font-size: smaller;">HIDE</button></a>
                                                    @else
                                                    <a href="{{ asset('show-account/' . $acc->id . '/' . $customer[0]->id) }}"><button type="button" class="btn btn-success btn-sm"
                                                        style="font-size: smaller;">SHOW</button></a>
                                                    @endif

                                                    <a href="{{ asset('delete-account/' . $acc->id . '/' . $customer[0]->id) }}"
                                                        style="text-decoration: none;"><button type="button" class="btn btn-danger btn-sm" style="font-size: smaller;">DELETE</button></a>
                                                </td>
                                                <td>
                                                    <li class="nav-item" style="display:inline-block;">

                        <a class="nav-link btn btn-sm btn-success" data-toggle="collapse" href="#general-pages{{$acc->id}}" aria-expanded="false"

                            aria-controls="general-pages{{$acc->id}}">

                            <span class="menu-title">Access</span>

                            <i class="menu-arrow"></i>

                            <i class="mdi mdi-message menu-icon"></i>

                        </a>

                        <div class="collapse" id="general-pages{{$acc->id}}">

                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item"> <a class="nav-link @if($acc->access == 1) active-access @endif" href="{{ asset('activate-account/' . $acc->id . '/' . $customer[0]->id) }}"> Activate </a></li>

                                <!-- <li class="nav-item"> <a class="nav-link" href="../support/inbox.html"> Inbox

                                        Messages</a></li> -->

                                <li class="nav-item"> <a class="nav-link @if($acc->access == 3) active-access @endif" href="{{ asset('suspend-account/' . $acc->id . '/' . $customer[0]->id) }}"> Suspend(Restricted )</a></li>
                                
                                <li class="nav-item"> <a class="nav-link @if($acc->access == 4) active-access @endif" href="{{ asset('temporary-user-suspend-accountt/' . $acc->id . '/' . $customer[0]->id) }}"> Temporal Restriction </a></li>
                                        
                                          <li class="nav-item"> <a class="nav-link @if($acc->access == 2) active-access @endif" href="{{ asset('block-user-account/' . $acc->id . '/' . $customer[0]->id) }}"> Block</a></li>

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


    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
</body>

</html>