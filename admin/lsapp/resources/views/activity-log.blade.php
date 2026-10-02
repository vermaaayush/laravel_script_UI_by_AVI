@include('header')





            <!-- partial -->

            <div class="main-panel">



                <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">

                            <span class="page-title-icon bg-gradient-primary text-white mr-2">

                                <i class="mdi mdi-home"></i>

                            </span> Activity Log </h3>

                        <nav aria-label="breadcrumb">

                            <ul class="breadcrumb">

                                <li class="breadcrumb-item active" aria-current="page">

                                    <span></span>Activity Log Overview <i

                                        class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>

                                </li>

                            </ul>

                        </nav>

                    </div>



                    <div class="row">

                        <div class="col-lg-12 stretch-card">

                            <div class="card">

                                <div class="card-body">

                                    <h4 class="card-title">Login and Account Activity Log</h4>

                                    <p class="card-description">All user and account log are below </p>

                                    <table class="table table-bordered">

                                        <thead>

                                            <tr>

                                                <th> Time </th>

                                                <th> Date </th>

                                                <!-- <th>User ID</th> -->

                                                <th> Activity </th>

                                                <th> Description </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($data as $row)

                                            @if($row['activity'] == 'Card Added')
                                            <tr class="table-success">
                                            @endif

                                            @if($row['activity'] == 'Account Added')
                                            <tr class="table-success">
                                            @endif

                                            @if($row['activity'] == 'Customer Added')
                                            <tr class="table-success">
                                            @endif

                                            @if($row['activity'] == 'Debited')
                                            <tr class="table-success">
                                            @endif

                                            @if($row['activity'] == 'Credited')
                                            <tr class="table-danger">
                                            @endif

                                            @if($row['activity'] == 'Charges')
                                            <tr class="table-warning">
                                            @endif

                                                <td> {{ $row['time'] }} </td>

                                                <td> {{ $row['date'] }} </td>

                                                <!-- <td> user0018 </td> -->

                                                <td> {{ $row['activity'] }} </td>

                                                <td> {{ $row['description'] }} </td>

                                            </tr>

                                            @endforeach
                                            <!-- <tr class="table-warning">

                                                <td> 00:00 </td>

                                                <td> July 1, 2015 </td>

                                                <td> user008 </td>

                                                <td> Transfer </td>

                                                <td> Messsy Adam </td>



                                            </tr>

                                            <tr class="table-danger">

                                                <td> 10:00 </td>

                                                <td> Apr 12, 2015 </td>

                                                <td> user0840 </td>

                                                <td> Deposit </td>

                                                <td> John Richards </td>



                                            </tr>

                                            <tr class="table-success">

                                                <td> 01:30 </td>

                                                <td> May 15, 2015 </td>

                                                <td> user8098 </td>

                                                <td> Account Added</td>

                                                <td> Peter Meggik </td>



                                            </tr>

                                            <tr class="table-primary">

                                                <td> 01:30 </td>

                                                <td> May 25, 2015 </td>

                                                <td> user80009 </td>

                                                <td> Withdrawal</td>

                                                <td> Peter Meggik </td>

                                            </tr> -->

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