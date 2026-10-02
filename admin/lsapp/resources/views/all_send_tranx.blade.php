@include('header')

      <div class="card">
          <div class="card-head">
              <div class="card-header">
                  <h4 class="card-title">Transactions History</h4>
                  
              </div>
          </div>
          <div class="card-content">
              <div class="card-body">
                  <!-- Task List table -->
                  <div class="table-responsive" style="padding-bottom:100px ">

 <table id="users-contacts" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                          <thead>
                              <tr>
                                 
                                  <!--<th>User Id</th>-->
                                  <th>Name</th>
                                  <th>Amount</th>
                                  
                                  <th>Sender/Receiver Address</th>
                                
                                  <th>Manage</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($datas as $data)
                              <tr>
                                  {{-- <td>{{ $data->user_id }}</td> --}}
                                
                                 <td>

   @php
    $userName = DB::table('ba_account_holders')
                    ->where('user_id', $data->user_id)
                    ->select('cust_name')
                    ->first();
@endphp

    {{ $userName ? $userName->cust_name : 'NULL' }}


 <p style="font-size:10px">({{ $data->created_at }})</p>
</td>
                                  <td>$ {{ $data->amount }}</td>
                                  
                                  <td><span style="font-size:10px;font-weight:bold">From:</span><br>{{ $data->sent_from }} <br><br> <span style="font-size:10px;font-weight:bold">To:</span><br>{{ $data->sent_to }}  <br><br> <span style="font-size:10px;font-weight:bold">Transaction ID:</span><br>{{ $data->tr_id }}</td> 
                                
                                  <td>

                                   
                                        @if ($data->status == 'Pending')
                                        <span class="badge border-warning warning badge-border">Pending!</span>
                                          
                                            <a href="javascript:void(0)"  data-toggle="modal" data-target="#fundsModal-{{ $data->id }}" class="btn btn-sm btn-primary" id="approve_btn">Update</a>
                                      
                                            @elseif ($data->status == 'Reject')
                                        
                                            <span style="color:red" class="badge border-danger danger badge-border">Rejected</span>

                                            @else
                                        
                                            <span style="color:green" class="badge border-success success badge-border">Success</span>
                                        
                                            @endif
                                    
                                      

                                  </td>
                                 
                                 
                                 
                              </tr>


                              {{-- Fetch wallet data for each user --}}
                          
                          
                            <!-- Modal for each user -->
                            <div class="modal fade" id="fundsModal-{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="fundsModalLabel-{{ $data->id }}" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="fundsModalLabel-{{ $data->id }}">Manage Send Request</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="send_req_manger/{{ $data->id }}" method="POST">
                                      @csrf
                                      
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="btc_fund">Transaction ID:</label>
                                                <input class="form-control border-primary" type="text" value="" id="btc_fund" name="hash_id">
                                            </div>
                                       
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" id="approveBtn" class="btn btn-success" name="action" value="approve">Approve</button>
                                        <button type="submit" id="rejectBtn" class="btn btn-danger" name="action" value="reject">Reject</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            @endforeach  
                          </tbody>
                         
                      </table>
                      
                      
                  </div>
                 
              </div>
          </div>
      </div>
 </div>


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
  