@include('header')

            <!-- partial -->
           
               <div class="card" >
          <div class="card-head">
              <div class="card-header">
                  <h4 class="card-title">All Real Crypto Deposit</h4>
                  
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
                                  <th>Address</th>
                                  <th>Transaction Id</th>
                                  
                                  <th>Currency</th>
                                  <th>Date/Time</th>
                              </tr>
                          </thead>
                          <tbody  id="user-list">
                            @foreach ($datas as $data)
                              <tr>
                                  {{-- <td>{{ $data->user_id }}</td> --}}
                                 {{-- {{ $data->user_id }} --}}
                                 <td>
   @php
    $userName = DB::table('ba_account_holders')
                    ->where('user_id', $data->user_id)
                    ->select('cust_name')
                    ->first();
@endphp

    {{ $userName ? $userName->cust_name : 'NULL' }}
</td>
                                  <td>$ {{ number_format($data->amount) }}</td>
                                  <td>{{ $data->sent_from }}</td> 
                                  <td>{{ $data->tr_id }}</td>
                                  
                                  <td>{{ $data->currency }}</td> 
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