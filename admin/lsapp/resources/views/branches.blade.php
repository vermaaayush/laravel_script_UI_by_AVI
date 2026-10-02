@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Bank Branches </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Branches</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bank Branches </li>
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
                                            <h4 class="card-title">List of all Bank Branches</h4>
                                            <p class="card-description"> All registered Bank Branches</p>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 stretch">
                                            <a href="add-branch"
                                                style="color: white;  text-decoration: none;"> <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="font-size: smaller;">Add Branch</button>
                                            </a>
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Branch Code</th>
                                                <th>Branch Name</th>
                                                <th>Action Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($branches as $branch)
                                            <tr>
                                                <td> {{ $branch->branch_code }} </td>

                                                <td> {{ $branch->branch_name }} </td>

                                                <td>
                                                    <a href="edit-branch/{{$branch->id}}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">VIEW/EDIT</button>
                                                    </a>
                                                    <a href="delete-branch/{{$branch->id}}"
                                                        style="color: white;  text-decoration: none;"><button type="button" class="btn btn-danger btn-sm"
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
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
    <!-- endinject -->
</body>

</html>