@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                     <div class="page-header">
                        <h3 class="page-title">Statement Maker</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Statement Maker</a></li>
                              
                            </ol>
                        </nav>
                    </div>


                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-7 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
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

                                    <form class="" method="POST" action="{{ asset('statement_loop') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                        
                                            <input type="text" name="id" hidden value="{{$account[0]->id}}" class="form-control">
                                            <input type="text" name="available_balance" hidden value="{{$account[0]->available_balance}}" class="form-control">
                                            
                                            
                                            
                                            <div class="form-group">
                                                <label for="Ext">Name</label>
                                                <input type="text" name="name" value="{{$account[0]->account_title}}" class="form-control">
                                                
                                               
                                            </div>
                                         

                                            <div class="form-group">
                                                <label for="Ext">Select User bank account</label>
                                                <select class="form-control select_tag" id="user_id" name="account_no"  required>
                                                  @foreach($account as $ac)
                                                   <option value="{{$ac->account_no}}">{{$ac->account_no}}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="form-group"  id="text_control">

                                            <div class="form-group">
                                                <label for="Ext">Date Picker (From)</label>
                                                <input type="date" id="from_date" name="from_date" value="" class="form-control">
                                                
                                               
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="Ext">Date Picker (To)</label>
                                                <input type="date" id="to_date" onchange="checkDate()" name="to_date" value="" class="form-control">
                                                
                                               
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="Ext">Min Amount</label>
                                                <input type="text" name="min_amount" value="" class="form-control">
                                                
                                               
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="Ext">Max Amount</label>
                                                <input type="text"  name="max_amount" value="" placeholder="Make sure Max amount is greater then Min amount" class="form-control">
                                                
                                               
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="Ext">No of Loop(No of transactions)</label>
                                                <input type="number" name="loop_no" value="" class="form-control">
                                                
                                               
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary ">Start</button>

                                    </form>

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
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
    <script>
  function checkDate() {
    var from_date = document.getElementById("from_date").value;
    var to_date = document.getElementById("to_date").value;
    if (from_date >= to_date) {
        alert("From date must be older than the To date");
        document.getElementById("from_date").value = "";
    }
  }
</script>
   
</body>

</html>




