@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Loan Management</h3>
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
                                <li class="breadcrumb-item active" aria-current="page">All Loans</li>
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
                                            <h4 class="card-title">All Loans</h4>
                                            <p class="card-description">All Loans under account</p>
                                        </div>
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                
                                                <th>Customer</th>
                                                <th>Account Number</th>
                                                <th>Loan Amount</th>
                                                <th>Loan Tenure</th>
                                                <th>EMI</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($loans as $loan)
                                            <tr>
                                                <td>{{ $loan->fname . " " . $loan->lname }}</td>
                                                <td>{{ $loan->account_no }}</td>
                                                <td>{{ $account[0]->account_currency . " " . $loan->loan_amount }}</td>
                                                <td>{{ $loan->loan_tenure }}</td>
                                                <td>{{ $loan->loan_emi }}</td>
                                                <td>
                                                    @if($loan->status == 0)
                                                        Pending
                                                    @elseif($loan->status == 1)
                                                        Approved
                                                    @elseif($loan->status == 2)
                                                        Rejected
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($loan->status == 0)
                                                    <a href="{{ asset('approve-loan/' . $loan->id) }}"
                                                        style="color: white;  text-decoration: none;"><button
                                                            type="button" class="btn btn-success btn-sm"
                                                            style="font-size: smaller;">APPROVE</button>
                                                    </a>
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