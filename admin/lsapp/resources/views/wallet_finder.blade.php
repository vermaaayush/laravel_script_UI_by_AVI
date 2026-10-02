@include('header')

 <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Tranfer Footer Text</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Tranfer Footer Text</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">

                                     <div class="card-header">
            
            <form action="wallet_finder" method="POST">
                @csrf
            <div class="input-group mb-3">
                <input type="text" id="search" name="address" class="form-control" placeholder="Enter the address and search it." required>
                <button type="submit" class="btn btn-primary "  id="search-button">Search</button>
            </div>
            </form>
            
         
         
        </div>
        
        <br>
        
        <div class="card-content">
               @if (isset($u_info) )
                   
               <div class="row">
                   <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="form-section"><i class="ft-clipboard"></i> User Details</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Full Name:</strong> {{ $u_info->cust_name }}</p>
                            <p><strong>Email:</strong> {{ $u_info->cust_mail }}</p>
                            <p><strong>User ID:</strong> {{ $u_info->user_id }}</p>
                          
                            <p><strong>Country:</strong> {{ $u_info->cust_country }}</p>
                            <p><strong>Phone:</strong> {{ $u_info->cust_phone }}</p>
                            <p><strong>DOB:</strong> {{ $u_info->dob }}</p>
                        </div>
                    </div>
                    
                   </div>

                   <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="form-section"><i class="ft-clipboard"></i>Wallet Details</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Address:</strong> {{ $data['address'] }}</p>
                            <p><strong>Currency:</strong> {{ strtoupper($data['currency']) }}</p>
                            <p><strong>Created At:</strong> {{ $data['created_at'] }}</p>
                           
                        </div>
                    </div>
                   </div>
                </div>   


                <div class="col-md-12">
                    <div class="card">
                       
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <h2>Wallet Transaction History</h2>
                                
                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table id="users-contacts" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                        <thead>
                                            <tr>
                                               
                                                <!--<th>User Id</th>-->
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Subject</th>
                                                 <th>Status</th>
                                                <th>Transaction Id</th>
                                                <th>Sender Address</th>
                                                <th>Receiver Address</th>
                                                <th>Date/Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($transactions as $data)
                                            <tr>
                                                {{-- <td>{{ $data->user_id }}</td> --}}
                                                <!--<td>{{ $data->user_id }}</td>-->
                                               <td>
                 @php
    $userName = DB::table('ba_account_holders')->where('user_id', $data->user_id)->select('cust_name')->first();
@endphp

{{ $userName ? $userName->cust_name : 'NULL' }}

              </td>
                                                <td>$ {{ number_format($data->amount) }}</td>
                                                <td> {{ $data->subject }}</td>
                                                <td>
                  @if ($data->status == 'Debit')
                      <span style="color: red;">{{ $data->status }}</span>
                  @elseif ($data->status == 'Credit')
                      <span style="color: green;">{{ $data->status }}</span>
                  @else
                      {{ $data->status }} <!-- Default case if status is neither Debit nor Credit -->
                  @endif
              </td>
              
                                                <td>{{ $data->tr_id }}</td>
                                                <td>{{ $data->sent_from }}</td> 
                                                <td>{{ $data->sent_to }}</td> 
                                                <td>{{ $data->created_at }}</td> 
                                               
                                               
                                               
                                            </tr>
                                          @endforeach  
                                        </tbody>
                                       
                                    </table>
                                </div>
                              
                               
                            </div>
                        </div>
                    </div>
                </div>
               @endif
          </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- content-wrapper ends -->
   
   
   @include('footer_2')
                <!-- partial -->
   
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
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  