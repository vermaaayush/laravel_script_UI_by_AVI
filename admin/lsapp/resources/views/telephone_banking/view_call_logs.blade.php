@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Call Logs</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Telephone Banking Setup</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Call Log</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                     <div class="row">
                                        <div class="col-md-6">
                                            @include('flash::message')
                                             <h4 class="card-title">List of all call logs</h4>
                                    <p class="card-description"> All registered call logs</p>
                                        </div>
                                       

                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Call From</th>
                                                <th>Call To</th>
                                                <th>Call Status</th>
                                                <th>From Address</th>
                                              
                                                <th>To Address</th> 
                                                <th>Date </th> 
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($call_logs as $call_log)
                                            <tr>
                                                <td> {{ $call_log->id }} </td>
                                                <td> {{ $call_log->callfrom }} </td>
                                                <td> {{ $call_log->callto }} </td>
                                                <td> {{ $call_log->callstatus }} </td>
                                                <td> {{$call_log->fromcity. " " . $call_log
                                                ->fromstate. " " .$call_log->fromzip. " " .$call_log->fromcountry}} </td>
                                               
                                                <td> {{ $call_log->tocity. " " .$call_log->tostate. " " .$call_log
                                                ->tozip. " " .$call_log->tocountry }} </td>
                                                <td> {{ $call_log->created_at }} </td>                               
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pages" style="position: relative;left: 415px;">
                               <span > {{ $call_logs->links() }}</span>
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