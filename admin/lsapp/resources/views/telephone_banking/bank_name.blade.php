@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                   <div class="page-header">
                        <h3 class="page-title"> IVR Bank Name Management. </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">IVR Bank Name Management.</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Alot Bank Name</li>
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
                                            <a href="add_bank_name"
                                                style="color:white;text-decoration: none;"> 
                                                <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="padding:10px 13px !important;">Add Bank Name
                                                </button>
                                            </a>
                                        </div>
                                        
                                    </div><br><br>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>Bank Name</th>
                                         
                                        
                                            <th>Action</th>
                                                   
                                            </tr>
                                        </thead>
                                        <tbody>

                                             @foreach ($Ivr_bank_name as $ivr)
                                            <tr>
                                                <td> {{ $ivr->id }} </td>
                                                <td> {{ $ivr->users->cust_name.' '.$ivr->users->middle_name.' '.$ivr->users->sur_name }} </td>
                                                <td> {{ $ivr->bank_name }} </td>
                                                
                                                 
                                                <td> 
                                                    
                                                   
                                                     <a href="delete-bank-name/{{$ivr->id}}"
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
                               <span > </span>
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