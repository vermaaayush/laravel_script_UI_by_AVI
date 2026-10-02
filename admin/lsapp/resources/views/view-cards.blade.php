@include('header2')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Card Management</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customers') }}">View All Customers</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customer/' . $customer[0]->id) }}">Customer
                                        Detail</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View Cards</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @include('flash::message')
                                            <h4 class="card-title">All Cards</h4>
                                            <p class="card-description">All Cards under account</p>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 ">
                                            <a href="{{ asset('add-card/' . $customer[0]->id) }}"><button type="button"
                                                    class="btn btn-gradient-success btn-icon-text">
                                                    <i class="mdi mdi-plus-circle-outline btn-icon-prepend"></i> Add
                                                    Card
                                                </button></a>
                                        </div>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                
                                                <th>Account Number</th>
                                                <th>Card Type</th>
                                                <th>Card Service Type </th>
                                                <th>Card Number</th>
                                                <th>Exp Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cards as $card)
                                            <tr>
                                                <td>{{$card->cust_act_number}}</td>
                                                <td>{{$card->card_type}}</td>
                                                <td>{{$card->card_service_type}}</td>
                                                <td>{{$card->card_number}}</td>
                                                <td>{{$card->exp_date}}</td>
                                                <td>
                                                    @if($card->status == 0)
                                                      Pending
                                                    @elseif($card->status == 1)
                                                      Approved
                                                    @elseif($card->status == 2)
                                                      Suspended
                                                    @elseif($card->status == 3)
                                                      Blocked
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ asset('view-card/' . $card->id) }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">VIEW</button></a>
                                                    <a href="{{ asset('edit-card/' . $card->id) }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button></a>
                                                    <a href="{{ asset('delete-card/' . $card->id . '/' . $customer[0]->id) }}"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button></a>
                                                    @if($card->status == 0)
                                                    <a href="{{ asset('approve-card/' . $card->id) }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">APPROVE</button></a>
                                                    @endif
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