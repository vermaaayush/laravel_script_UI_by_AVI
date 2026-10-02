@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">All Transfers</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-accounts/' . $customer[0]->id) }}">View All Customer Accounts</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-account/' . $account[0]->id) }}">View Customer
                                        Account</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">All Local Transfers</li>
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
                                            <h4 class="card-title">Account Transfers</h4>
                                            <p class="card-description">All transfers under account</p>
                                        </div>
                                        <!-- <div class="col-md-3"></div>
                                        <div class="col-md-3 ">
                                            <a href="../transfers/add_transfer.html"><button type="button"
                                                    class="btn btn-gradient-success btn-icon-text">
                                                    <i class="mdi mdi-plus-circle-outline btn-icon-prepend"></i> Add
                                                    Transfer
                                                </button></a>
                                        </div> -->
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Beneficiary </th>
                                                <th>Beneficiary Bank</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Balance</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transfers as $transfer)
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($transfer->datetime)) }}</td>
                                                <td>{{ date("H:i", strtotime($transfer->datetime)) }}</td>
                                                <td>{{ $transfer->beneficiary }}</td>
                                                <td>{{ $transfer->beneficiary_bank }}</td>
                                                <td>{{ number_format($transfer->amount, 0, '.', ',') . " " . $transfer->account_currency }}</td>
                                                <td>
                                                    @if($transfer->status == 1)
                                                    <label class="badge badge-success">Approved</label>
                                                    @endif

                                                    @if($transfer->status == 0)
                                                    <label class="badge badge-danger">Pending</label>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($transfer->balance, 0, '.', ',') . " " . $transfer->account_currency }}</td>
                                                <td>
                                                    @if($transfer->status == 0)
                                                    <a href="{{ asset('mark-transfer-complete/' . $transfer->tran_id) }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-success btn-sm"
                                                            style="font-size: smaller;">MARK COMPLETE</button></a>
                                                    @endif
                                                    @if($transfer->status == 1)
                                                    <a href="{{ asset('edit-transfer/' . $transfer->tran_id) }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button></a>
                                                    @endif
                                                    <a href="{{ asset('delete-transfer/' . $transfer->tran_id) }}"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button></a>
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