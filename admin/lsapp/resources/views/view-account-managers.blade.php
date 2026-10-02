@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">View All Account Managers</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Account Manager</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View All Account Manager</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">List of all Account Managers</h4>
                                    <p class="card-description"> All registered Account Managers</p>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Photo</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ams as $key => $am)
                                            <tr>
                                                <td> {{ $key+1 }} </td>
                                                <td>{{ $am->name }} </td>
                                                <td>{{ $am->email }} </td>
                                                <td>{{ $am->countrycode . " " . $am->phone }} </td>
                                                <td><img src="{{ $am->photo }}" /></td>
                                                <td>
                                                    <a href="edit-account-manager/{{ $am->id }}"
                                                        style="color: white;  text-decoration: none;"> <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT</button></a>
                                                    <a href="delete-account-manager/{{ $am->id }}"
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
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
</body>

</html>