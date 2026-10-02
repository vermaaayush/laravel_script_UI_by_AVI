@include('header')

      <div class="card" >
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
                                  <th>Subject</th>
                                   <th>Status</th>
                                  <th>Transaction Id</th>
                                  <th>Sender Address</th>
                                  <th>Receiver Address</th>
                                  <th>Date/Time</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($datas as $data)
                              <tr>
                                  {{-- <td>{{ $data->user_id }}</td> --}}
                                  <!--<td>{{ $data->user_id }}</td>-->
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
                                  <td> {{ $data->subject }}</td>
                                  <td>
    @if ($data->status == 'Debit')
        <span style="color: red;">{{ $data->status }}</span>
    @elseif ($data->status == 'Credit')
        <span style="color: green;">{{ $data->status }}</span>
    @elseif ($data->status == 'Pending')
        <span style="color: rgb(143, 143, 10);">{{ $data->status }}</span>    
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
  