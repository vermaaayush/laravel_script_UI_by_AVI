@include('header')

      <div class="card">
          <div class="card-head">
              <div class="card-header">
                  <h4 class="card-title">USDT Wallet Address (Tatum.io)</h4>
                  
                  <button type="button" id="toggle-eye-button">
  VIEW <i class="mdi mdi-eye menu-icon"></i>
</button>
                  
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
                                  <th>Address</th>
                                  
                                  <th>Phrase</th>
                                
                                  <th>Private Key</th>
                                  <th>Amount</th>
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
                    ->first();
@endphp

    {{ $userName ? $userName->cust_name : 'NULL' }}

</td>
                                   <td><textarea rows="3" cols="20">{{ $data->address }}</textarea></td>
<td>
  <input class="secure-input" type="password" value="{{ $data->mnemonic }}" readonly>
</td>
<td>
  <input class="secure-input" type="password" value="{{ $data->private_key }}" readonly>
</td>
                                 <td>${{ $userName ? $userName->usdt_fund : 'NULL' }}</td>
                                 
                                 
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
    
    <script>
  // Get the global eye button and icon
  const eyeButton = document.getElementById('toggle-eye-button');
  const eyeIcon = document.getElementById('eye-icon');

  // Function to toggle visibility of all password fields
  eyeButton.addEventListener('click', () => {
    const inputs = document.querySelectorAll('.secure-input'); // Select all password fields

    inputs.forEach(input => {
      // Toggle input type between password and text
      if (input.type === 'password') {
        input.type = 'text';
      } else {
        input.type = 'password';
      }
    });

    // Toggle the eye icon (change to eye-slash if visible, and eye if hidden)
    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
  });
</script>
</body>

</html>
    
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  