@include('header') 
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Sms Management</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Sms Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sms Listing</li>
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
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li><br/>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                             <h4 class="card-title">Sms listing</h4>
                                    
                                        </div>
                                       

                                    </div>
                                     <table class="table table-striped">
                                 <thead>
                                    <tr>
                                       <th scope="col">S.no</th>
                                     <th scope="col"> Name</th>
                                        <th scope="col">Sms </th>
                                         <th scope="col">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($sms as $key )
                                    <tr>
                                       <td>{{ $key->id }}</td>
                                       <td>{{ $key->name }}</td>
                                       <td style="position: relative;right: 90px;"><textarea  style="background-color: white;" class="form-control" id="" cols="12" rows="3" readonly="">{{ $key->sms }}</textarea>    </td>
                                    
                                      <td>
                                          <a href="edit-sms/{{$key->id}}">
                                            <button  class="btn btn-success btn-sm"  type="submit"
                                                        style="font-size: smaller;">Edit 
                                         </button>
                                          </a>
                                          
                                        <!-- <a href="delete-sms/{{$key->id}}">
                                            <button  class="btn btn-danger btn-sm"  type="submit" 
                                                        style="font-size: smaller;">Delete  
                                         </button> 
                                         </a> -->     

                                       </td> 

                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>

                                   
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