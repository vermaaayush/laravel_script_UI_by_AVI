@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                    <div class="page-header">

                        <h3 class="page-title">Access Token</h3>

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">Support Management</a></li>

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
                                    <h4 class="card-title">Add Token</h4>

                                    <form class="" method="POST" action="{{ asset('add_new_token') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">

                                        <div class="form-group">

                                            <label for="Support Phone">Token</label>

                                            <input type="text" class="form-control test-input" name="token"  required
                                             placeholder="Enter Access Token" max="5"/>

                                        </div>


                                        <button type="submit" class="btn btn-gradient-primary mr-2">Add New Token</button>

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




