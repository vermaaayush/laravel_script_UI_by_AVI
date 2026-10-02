@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">Edit Access Token</h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Token</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Add Token</li>

                            </ol>

                        </nav>

                    </div>


                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-7 grid-margin stretch-card">

                            <div class="card">

                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Edit Token</h4>

                                    <form class="" method="POST" action="{{ asset('update-access-token') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                        
                                        <input hidden type = "text" name ="id" value ="{{$a_token[0]->id}}">

                                        <div class="form-group">

                                            <label for="Support Phone">Token</label>

                                            <input type="text" class="form-control test-input" name="token" value="{{$a_token[0]->token}}"  required
                                             placeholder="Enter Access Token" max="5"/>

                                        </div>
                                        
                                        <div class="form-group">
                                            
                                            <label for="Support Phone">Status</label>
                                            
                                          <div class="form-check" style="margin-left:20px">
  <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1"  <?php if($a_token[0]->status==1){ ?> checked   <?php } ?> >
  <label class="form-check-label" for="exampleRadios1">
    Enable
  </label>
</div>
<div class="form-check" style="margin-left:20px">
  <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" <?php if($a_token[0]->status==0){ ?> checked   <?php } ?>>
  <label class="form-check-label" for="exampleRadios2">
    Disable
  </label>
</div>
  

                                            

                                        </div>
                                        
                                        
                                        <div class="form-group">

                                            <label for="Support Phone">Token Disable Message</label>

                                      
                                             <textarea class="form-control" name="msg" required>{{$a_token[0]->msg}}</textarea>

                                        </div>
                                        
                                       


                                        <button type="submit" class="btn btn-gradient-primary mr-2">Update Token</button>

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
        
        $('.test-input').unbind('keyup change input paste').bind('keyup change input paste',function(e){
    var $this = $(this);
    var val = $this.val();
    var valLength = val.length;
    var maxCount = $this.attr('max');
    if(valLength>maxCount){
        $this.val($this.val().substring(0,maxCount));
    }
}); 
    </script>
</body>

</html>




