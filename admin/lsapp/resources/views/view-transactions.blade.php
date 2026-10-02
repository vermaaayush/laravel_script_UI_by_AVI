@include('header3')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">All Transactions</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-accounts/' . $customer[0]->id) }}">View Customer Accounts</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-account/' . $account[0]->id) }}">View
                                        Account Detail</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">All Transactions</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body" style="overflow-x: scroll !important;">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Account Transactions</h4>
                                            <p class="card-description">All transactions under account</p>
                                        </div>
                                        <!-- <div class="col-md-3"></div>
                                        <div class="col-md-3 ">
                                            <a href="../transactions/add_transaction.html"><button type="button"
                                                    class="btn btn-gradient-success btn-icon-text">
                                                    <i class="mdi mdi-plus-circle-outline btn-icon-prepend"></i> Add
                                                    Transaction
                                                </button></a>
                                        </div> -->
                                    </div>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Customer</th>
                                                <th>Withdrawal/Depositor Name</th>
                                                <th>Amount</th>
                                                <th>Balance</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ date("d/m/Y", strtotime($transaction->datetime)) }}</td>
                                                <td>{{ date("H:i:s", strtotime($transaction->datetime)) }}</td>
                                                <td>
                                                    @if($transaction->depositor != '')
                                                    {{ ucwords($transaction->type) }}
                                                    @endif
                                                    @if($transaction->depositor == '' && $transaction->international == 0)
                                                    Local Transfer
                                                    @endif
                                                    @if($transaction->depositor == '' && $transaction->international == 1 && $transaction->type != 'charges')
                                                    International Transfer
                                                    @endif
                                                    @if($transaction->depositor == '' && $transaction->international == 1 && $transaction->type == 'charges')
                                                    International Transfer Charges
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->reason }}</td>
                                                <td>{{ $customer[0]->cust_name . " " .$customer[0]->middle_name . " " . $customer[0]->sur_name }}</td>
                                                <td>
                                                    @if($transaction->depositor != '')
                                                    {{ $transaction->depositor }}
                                                    @else
                                                    Transferred To - {{ $transaction->beneficiary }}
                                                    @endif
                                                </td>
                                                <td>{{ number_format($transaction->amount, 2, '.', ',') . " " . $account[0]->account_currency }}</td>
                                                <td>{{ number_format($transaction->balance, 2, '.', ',') . " " . $account[0]->account_currency }}</td>
                                                @if($transaction->type == 'credited')
                                                <td>
                                                    <a href="{{ asset('edit-deposit/' . $transaction->id) }}"
                                                        style="color: white;  text-decoration: none;"><button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button>
                                                    </a>
                                                    <a href="{{ asset('delete-deposit/' . $transaction->id . '/' . $account[0]->id) }}"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button></a>
                                                </td>
                                                @endif
                                                @if($transaction->type == 'debited' && $transaction->depositor == '' && $transaction->international == 0)
                                                <td>
                                                    @if($transaction->status == 1)
                                                    <a href="{{ asset('edit-transfer/' . $transaction->tran_id) }}"
                                                        style="color: white;  text-decoration: none;"><button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button>
                                                    </a>
                                                    @endif
                                                    <a href="{{ asset('delete-transfer/' . $transaction->tran_id . '/' . $account[0]->id) }}"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button></a>
                                                </td>
                                                @endif

                                                @if($transaction->type == 'debited' && $transaction->depositor == '' && $transaction->international == 1)
                                                <td>
                                                    @if($transaction->status == 1)
                                                    <a href="{{ asset('edit-international-transfer/' . $transaction->tran_id) }}"
                                                        style="color: white;  text-decoration: none;"><button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button>
                                                    </a>
                                                    @endif
                                                    <a href="{{ asset('delete-international-transfer/' . $transaction->tran_id . '/' . $account[0]->id) }}"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button></a>
                                                </td>
                                                @endif

                                                @if($transaction->type == 'debited' && $transaction->depositor != '')
                                                <td>
                                                    <a href="{{ asset('edit-withdrawal/' . $transaction->id) }}"
                                                        style="color: white;  text-decoration: none;"><button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button>
                                                    </a>
                                                    <a href="{{ asset('delete-withdrawal/' . $transaction->id . '/' . $account[0]->id) }}"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button></a>
                                                </td>
                                                @endif
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