@include('header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Form Settings</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Form Settings</li>
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
          	action="{{ asset('form-settings') }}"
          	method="POST"
          	class="forms-sample">
          	@csrf
          	<div class="row px-4">
          		<div class="col-sm-12">
                                <div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->auto_activate == 1)
									checked
{{--									onclick="return false;"--}}
								  	@endif
								  	id="auto_activate"
								  	name="auto_activate"
								  	value="auto_activate">
								  <label class="form-check-label" for="form_4">
								  	Auto-activate account
								  </label>
								</div>
								<div class="row">
    								<div class="col-6">
								    <label>Set Values For Account Numbers <br> <small>By Default 10 digits</small></label>
								    </div>
    								<div class="col-3">
    								  <input type="text" value="{{$enableForms->account_start_value}}" name="account_start_value" class="form-control">
    								</div>
                                    <div class="col-3">
    								  <input type="text" value="{{$enableForms->account_end_value}}" name="account_end_value" class="form-control">
    								</div>    
								</div>
                               <!-- 
                                <div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_4 == 1)
								  		checked
								  	@endif
								  	id="form_4"
								  	name="formfour"
								  	value="4">
								  <label class="form-check-label" for="form_4">
								  	Step - 4 - Communication Details
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_5 == 1)
								  		checked
								  	@endif
								  	id="form_5"
								  	name="formfive"
								  	value="5">
								  <label class="form-check-label" for="form_5">
								  	Step - 5 - Contact Details
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_6 == 1)
								  		checked
								  	@endif
								  	id="form_6"
								  	name="formsix"
								  	value="6">
								  <label class="form-check-label" for="form_6">
								  	Step- 6 - Personal Details
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_7 == 1)
								  		checked
								  	@endif
								  	id="form_7"
								  	name="formseven"
								  	value="7">
								  <label class="form-check-label" for="form_7">
								  	Step - 7 - Occupational Details
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_8 == 1)
								  		checked
								  	@endif
								  	id="form_8"
								  	name="formeight"
								  	value="8">
								  <label class="form-check-label" for="form_8">
								  	Step - 8 - Details of account holders
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_9 == 1)
								  		checked
								  	@endif
								  	id="form_9"
								  	name="formnine"
								  	value="9">
								  <label class="form-check-label" for="form_9">
								  	Step - 9 - Credit Facilities with other bank
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_10 == 1)
								  		checked
								  	@endif
								  	id="form_10"
								  	name="formten"
								  	value="10">
								  <label class="form-check-label" for="form_10">
								  	Step - 10 - Listing credit facilities
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_11 == 1)
								  		checked
								  	@endif
								  	id="form_11"
								  	name="formeleven"
								  	value="11">
								  <label class="form-check-label" for="form_11">
								  	Step - 11 - Initial payment details
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_12 == 1)
								  		checked
								  	@endif
								  	id="form_12"
								  	name="formtwelve"
								  	value="12">
								  <label class="form-check-label" for="form_12">
								  	Step - 12 - Introducer Details
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_13 == 1)
								  		checked
								  	@endif
								  	id="form_13"
								  	name="formthirteen"
								  	value="13">
								  <label class="form-check-label" for="form_13">
								  	Step - 13 - Minor declaration
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_14 == 1)
								  		checked
								  	@endif
								  	id="form_14"
								  	name="formfourteen"
								  	value="14">
								  <label class="form-check-label" for="form_14">
								  	Step - 14 - Senior citizen declaration
								  </label>
								</div>
								<div class="form-check form-check">
								  <input
								  	class="form-check-input"
								  	type="checkbox"
								  	@if($enableForms->form_15 == 1)
								  		checked
								  	@endif
								  	id="form_15"
								  	name="formfifteen"
								  	value="15">
								  <label class="form-check-label" for="form_15">
								  	Step - 15 - Know Your Customer Details
								  </label>
								</div>-->
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
