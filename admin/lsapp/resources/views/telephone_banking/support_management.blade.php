@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Support Management</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Support Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Support numbers</li>
                            </ol>
                        </nav>
                    </div> 

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                     @include('flash::message')
                                      <div class="row">
                                       
                                        <div class="col-md-3 stretch">
                                            <a href="add-numbers"
                                                style="color:white;text-decoration: none;"> 
                                                <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="padding:10px 13px !important;">Add Number
                                                </button>
                                            </a>
                                        </div>
                                        
                                    </div><br><br>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                   
                                                <th>Support Number</th>
                                                <th>Ext # </th>
                                                <th>Actions</th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($support_numbers as $support_number)
                                            <tr>
                                                <td> {{ $support_number->support_number }} </td>
                                                <td> {{ $support_number->ext_number }} </td>
                                                <td> 
                                                    <a href="edit-number/{{ $support_number->id }}"
                                                        style="color: white;  text-decoration: none;"> 
                                                        <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT
                                                        </button>
                                                    </a>
                                                    <a href="delete-number/{{ $support_number->id }}"
                                                        style="color: white;  text-decoration: none;"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button>
                                                    </a>
                                                </td>
                                                                                             
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pages" style="position: relative;left: 415px;">
                               
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