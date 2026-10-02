@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Internet Banking Form Settings</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">IB Form Settings</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-2 grid-margin stretch-card"></div>
                        <div class="col-md-8 grid-margin stretch-card">
      <!-- enable form -->
      <div class="card">
        <div class="card-body">
          @include('flash::message')
          <h4 class="card-title">Enable / Disable Forms</h4>
          <p
          	class="alert alert-warning">
        		Please note! The checked items only  
        		available to user for online account opening.
        	</p>
          <form 
          	action="{{ asset('ib-form-settings') }}" 
          	method="POST" 
          	class="forms-sample">
          	@csrf
          	<div class="row px-4">
          		<div class="col-sm-12">
          			<div class="form-check form-check">
								  <input  
								  	class="form-check-input" 
								  	type="checkbox" 
								  	@if($enableIbForms->form_1 == 1)
								  		checked
								  	@endif
								  	id="form_1" 
								  	name="formone" 
								  	value="4">
								  <label class="form-check-label" for="form_1">
								  	Step - 2 - Personal Information
								  </label>
								</div>
								<div class="form-check form-check">
								  <input 
								  	class="form-check-input" 
								  	type="checkbox" 
								  	@if($enableIbForms->form_2 == 1)
								  		checked
								  	@endif
								  	id="form_2" 
								  	name="formtwo" 
								  	value="5">
								  <label class="form-check-label" for="form_2">
								  	Step - 3 - Access Security
								  </label>
								</div>
          		</div>
          	</div>
          	<button
							class="
							mt-3
							btn
							btn-primary
							btn-sm">
							Update
						</button>
          </form>
        </div>
      </div>
      <!--/ enable form -->

                        </div>
                        <div class="col-md-2 grid-margin stretch-card"></div>
                    </div>



                </div>
                <!-- content-wrapper ends -->


               @include('footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->










    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!-- plugins:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
    <!-- End custom js for this page -->
</body>

</html>