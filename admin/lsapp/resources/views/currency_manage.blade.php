@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Currency Management</h3>
                      
                    </div> 

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                     @include('flash::message')
                                      <div class="row">
                                       
                                        <div class="col-md-3 stretch">
                                            <a href="add_currency"
                                                style="color:white;text-decoration: none;"> 
                                                <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="padding:10px 13px !important;">Add New
                                                </button>
                                            </a>
                                        </div>
                                        
                                
                                        
                                    </div><br><br>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                   
                                                <th>Currency Icon</th>
                                                <th>Currency Name</th>
                                                <th>Actions</th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($currencies as $currencies)
                                            <tr>
                                               
                                                <td> {{ $currencies->currency }} </td>
                                              <td> {{ $currencies->currency_name }} </td>
                                                <td> 
                                                
                                                    <a href="edit_currency/{{ $currencies->id }}"
                                                        style="color: white;  text-decoration: none;"> 
                                                        <button
                                                            type="button" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">EDIT
                                                        </button>
                                                    </a>
                                                  
                                                    <a href="delete_currency/{{ $currencies->id }}"
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