@include('header')
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                   

                    <div class="row">

                        <!-- Transation status section of row-->

                        <div class="col-md-12 grid-margin stretch-card">

                            <div class="card" style="margin:auto">

                              
                              <p style="text-align:center"> <img src="https://uxwing.com/wp-content/themes/uxwing/download/checkmark-cross/success-green-check-mark-icon.png"  width="30%" alt=""></p>
                              
                              
                               
                               <h1 style="text-align:center;font-size:50px">SUCCESS!</h1>

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




