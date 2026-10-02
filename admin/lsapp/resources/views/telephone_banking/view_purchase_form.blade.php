@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">Purchase Number</h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Twilio Management</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Purchase Number</li>

                            </ol>

                        </nav>

                    </div>


                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-12 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title"></h4>


                                     <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                   
                                                <th>Select Country</th>
                                                 <th>Phone Type</th>
                                               
                                                <th>Actions</th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            <tr>
                                               
                                                 <form class="" method="POST" action="">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">

                                                <td>
                                                    <select class="form-control" id="countryCode" name="countryCode"  required>


                                                        <option selected value="US">United States</option>

                                                        <option value="ES">SPAIN</option>

                                                        <option value="PT">PORTUGAL</option>

                                                        <option value="JP">JAPAN</option>

                                                        <option value="DE">GERMANY</option>

                                                        <option value="FR">FRANCE</option>

                                                        <option value="AE">United Arab Emirates</option>

                                                    </select>

                                                </td>
                                             <td>
                                                 
                                                <select class="form-control" name="phonetype" id="phonetype" required>
                                                    <option selected value="simple">Simple</option>                                                 
                                                    <option  value="tollfree">Toll Free</option>
                                                    

                                                </select>
                                             </td>

                                        <td> 
                                                    <a href="#"
                                                        style="color: white;  text-decoration: none;"> 
                                                        <button
                                                            type="button" id="ser" class="btn btn-info btn-sm"
                                                            style="font-size: smaller;">Search
                                                        </button>
                                                    </a>
                                                   
                                                </td>

                                    </form>
                                                                                             
                                            </tr>
                                          

                                           
                                        </tbody>
                                    </table>
                                      <br>
                                      
                                      <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                   
                                                <th>Twilio Number</th>
                                          
                                                <th>Actions</th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody id="number_data">
                                           
                                           
                                        </tbody>
                                    </table>

                                   
                                    
                                </div>

                            </div>

                        </div>

                        <!--Todo Section of Row-->


                    </div>

                    <!-- partial -->

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
   
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  

     <script>
 
  $('#ser').click(function(){

   fetch_data();
 
 });
 
 $( document ).ready(function() {
     fetch_data();
});

 function fetch_data()
{  
  var phonetype = $('#phonetype').val();
  var countryCode = $('#countryCode').val();
  var _token = $('input[name="_token"]').val();

  $.ajax({
   url:"{{ asset('twilio-fetch') }}",
   method:"POST",
   data:{countryCode:countryCode, phonetype:phonetype, _token:_token},
   dataType:"json",
   success:function(data)
   {

       console.log(data);
      
   
    $('#number_data').html(data.data);

    
   }
  });
 }

</script>
</body>

</html>




