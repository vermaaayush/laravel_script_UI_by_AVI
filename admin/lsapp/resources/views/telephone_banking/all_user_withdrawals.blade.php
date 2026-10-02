@include('header') 
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">User Withdrawals</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Withdrawals</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View all Withdrawals</li>
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
                                             <h4 class="card-title">List of all User withdrawals</h4>
                                    
                                        </div>
                                       

                                    </div>
                                     <table class="table mb-0 table-striped">
                                 <thead>
                                    <tr>
                                       <th scope="col">S.no</th>
                                      <!-- <th scope="col">Name</th>-->
                                       <th scope="col">User</th>
                                       <th scope="col">User Name</th>
                                        <th scope="col">Amount</th>
                                       <th scope="col">Account Number</th>
                                       
                                       <th scope="col">Payment Method</th>
                                         <th scope="col">Status</th>
                                       <!-- <th scope="col">2 % of Transfer</th>-->
                                       <th scope="col">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($users as $key )
                                    <tr>
                                       <td>{{ $key->id }}</td>
                                         <td class="py-1">
                                                    @if($key->cust_photo != '')
                                                    <img src="{{ asset('uploads/' . $key->cust_photo) }}"
                                                        alt="image" />
                                                    @endif

                                                    @if($key->cust_photo == '')
                                                    <img src="{{ asset('uploads/default.png') }}"
                                                        alt="image" />
                                                    @endif
                                                </td>
                                       <td> {{ $key->users->cust_name.' '.$key->users->middle_name.' '.$key->users->sur_name }} </td>
                                      
                                       <td>{{ $key->amount }} USD</td>
                                       <td>{{ $key->account_no }}</td>
                                       @if($key->pay_method==1)

                                       <td>Paypal</td>
                                       
                                       @else
                                       <td>Bitcoin</td>
                                       
                                       @endif
                                       
                                        @if($key->verification == 0)
                                              <td>Pending</td>   
                                         @elseif($key->verification == 2)
                                         <td>Cancelled</td>
                                          @endif

                                       <td>
                                          <button  class="btn btn-success btn-sm" onclick="test({{$key->id}})" type="button" data-toggle="modal" data-target="#mymodal"
                                                        style="font-size: smaller;">Process 
                                         </button>
                                          
                                         <a href="decline/{{$key->id}}">
                                            <button  class="btn btn-danger btn-sm"  type="button" 
                                                        style="font-size: smaller;">Decline  
                                         </button> 
                                         </a>      

                                       </td>  
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>

                                   
                                </div>
                                {{-- <div class="pages" style="position: relative;left: 415px;">
                               <span > {{ $call_logs->links() }}</span>
                           </div> --}}
                            </div>
                           

        </div>
    </div>
                <!-- content-wrapper ends -->
<div class="modal fade" id="mymodal" data-v-6cd5d5aa="" data-v-6690ddf8="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog model-dialog1"  role="document">
    <div class="modal-content mycontent" style="height:350px;padding: 6px 20px;"  data-v-6690ddf8="">
      <div class="modal-header" data-v-6690ddf8="">
        <h5 class="modal-title"  data-v-6690ddf8="" id="exampleModalLabel">User Withdrawal</h5>
        
      </div>
         
          <button data-v-6690ddf8="" style="width: 7%;text-align: center !important;position: relative;float: right;color: #fff;background: #1e3d73;border: none;" data-dismiss="modal" aria-label="Close" class="modal-close modal-close-css1">
            x
          </button>

          <br><br>
          <label style="position: relative;top: 10px;margin-bottom: 15px;">Select Process</label><br>
          <div class="row">
                             <div class="col-md-10">

                                 <div class="form-group">
                               
                                <select class="form-control" onChange="fetch_data(this.value)" required>
                                    <option>Select option</option>
                                    <option id="" value="self">Self Process</option>

                                     <option id="" value="script">Script Process</option>
                                </select>
                            </div>

                             </div>
                              <form action="">
                       
                        <table class="table table-striped">
                             <input type="hidden" id="pay_id" name="id" value="">
                        
                                <thead>
                                    <tr>
                                           
                                        <th>Amount</th>
                                        <th>Payment method</th>
                                         <th>5 Percent</th>
                                         
                                    </tr>
                                </thead>
                                <tbody id="number_data">
                                   
                                </tbody>
                                    
                        </table>
                         
                   
                   </form>
                           
              </div>
                

            </div>
        </div>
    </div>


                <!-- partial -->
            </div>
            <!-- main-panel ends -->
             @include('footer_2')
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/file-upload.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
    <script>

  
function fetch_data(type)
{  
  
  if(type == 'self'){
    var pay_id= $('#pay_id').val() ;

  $.ajax({
   url:"{{ asset('userwithdrawal-fetch') }}",
   method:"get",
   data:{pay_id:pay_id},
   dataType:"json",
   success:function(data)
   {

   console.log(data);

    $('#number_data').html(data.data);
    
   }
  });
  }else{
    var pay_id= $('#pay_id').val() ;
 
  $.ajax({
   url:"{{ asset('userwithdrawal-bit') }}",
   method:"get",
   data:{pay_id:pay_id},
   dataType:"json",
   success:function(data)
   {

   console.log(data);
      
    $('#number_data').html(data.data);
    
   }
  });

  }
 }
    </script>
    <script type="text/javascript">
      function test(id){
        
        $('#pay_id').val(id) ;
        }
    </script>
  
</body>

</html>