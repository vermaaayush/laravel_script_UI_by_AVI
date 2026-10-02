@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Twilio Management</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Twilio Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Twilio number</li>
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
                                            <a href="purchase-twilio-numbers"
                                                style="color:white;text-decoration: none;"> 
                                                <button type="button"
                                                    class="btn btn-success btn-lg"
                                                    style="padding:10px 13px !important;">Purchase Twilio Number
                                                </button>
                                            </a>
                                        </div>
                                        
                                    </div><br><br>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                   
                                                <th>Twilio Numbers</th>
                                              
                                                <th>Actions</th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
  
                                            
                                           @if(count($numbers)>0) 
                                             @foreach ($numbers as $number)
                                            <tr>
                                                <td> {{ $number->phone_number }} </td>
                                                
                                                <td> 
                                                 
                                                    <a href="twilio-delete-number/{{ $number->id }}"
                                                        style="color: white;  text-decoration: none;"><button type="button" class="btn btn-danger btn-sm"
                                                        style="font-size: smaller;">DELETE</button>
                                                    </a>
                                                </td>
                                                                                             
                                            </tr>
                                            @endforeach
                                            @else
                                            
                                            <tr><td colspan="2">No record found!</td></tr>
                                            
                                            @endif
                                            
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