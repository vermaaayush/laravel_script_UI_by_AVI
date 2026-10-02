@include('header')

<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,700,300italic);
*, *:before, *:after { box-sizing: border-box; }
html { font-size: 100%;  }

.wrapper {
  max-width: 75%;
  margin: auto;
}


h1 { 
  color: #555; 
  margin: 3rem 0 1rem 0; 
  padding: 0;
  font-size: 1.5rem;
}

textarea {
  width: 100%;
  min-height: 100px;
  resize: none;
  border-radius: 8px;
  border: 1px solid #ddd;
  padding: 0.5rem;
  color: #666;
  box-shadow: inset 0 0 0.25rem #ddd;
  &:focus {
    outline: none;
    border: 1px solid darken(#ddd, 5%);
    box-shadow: inset 0 0 0.5rem darken(#ddd, 5%);
  }
  &[placeholder] { 
    font-style: italic;
    font-size: 0.875rem;
  }
}

#the-count {
  float: right;
  padding: 0.1rem 0 0 0;
  font-size: 0.875rem;
}
</style>
            <!-- partial -->
            <div class="main-panel">
               <div class="content-wrapper">

                     <div class="page-header">
                        <h3 class="page-title">Sms Management</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Sms Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Sms</li>
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
                                    <form class="" method="POST" action="{{ asset('edit-sms') }}">
                                        <input type = "hidden" name = "_token" value ="<?php echo csrf_token(); ?>">
                                         <input type = "hidden" name = "id" value ="{{$SmsEditor->id}}">
                                            <div class="form-group">
                                                <label for="Ext">Select Type</label>
                                                <select class="form-control" id="type" onChange="fetch_data(this.value)" name="type" required>
                                                    
                                                    <option value="accout_card_added" {{(($SmsEditor->type=='accout_card_added')?'selected':'')}}>
                                                        Customer card added to account 
                                                    </option>
                                                    <option value="accout_card_approved"  {{(($SmsEditor->type=='accout_card_approved')?'selected':'')}}>
                                                        Customer card request approved  
                                                    </option>
                                                    <option value="loan_approved" {{(($SmsEditor->type=='loan_approved')?'selected':'')}}>
                                                        Customer loan approved  
                                                    </option>
                                                    <option value="limit_approved" {{(($SmsEditor->type=='limit_approved')?'selected':'')}}>
                                                        Customer limit approved  
                                                    </option>
                                                    <option value="limit_denied" {{(($SmsEditor->type=='limit_denied')?'selected':'')}}>
                                                        Customer limit denied  
                                                    </option>
                                                    <option value="limit_update_approved" {{(($SmsEditor->type=='limit_update_approved')?'selected':'')}}>
                                                        Customer limit update approved  
                                                    </option>
                                                    <option value="withdrawal_declined" {{(($SmsEditor->type=='withdrawal_declined')?'selected':'')}}>
                                                        Withdrawal declined 
                                                    </option>
                                                    <option value="account_statement" {{(($SmsEditor->type=='account_statement')?'selected':'')}}>
                                                        Account Statement 
                                                    </option>
                                                     <option value="account_statement_sent" {{(($SmsEditor->type=='account_statement_sent')?'selected':'')}}>
                                                         Account Statement sent
                                                    </option>
                                                    
                                                    <option value="beneficary_verification_code" {{(($SmsEditor->type=='beneficary_verification_code')?'selected':'')}}>
                                                        Beneficary verification code
                                                    </option>
                                                    <option value="card_request_success" {{(($SmsEditor->type=='card_request_success')?'selected':'')}}>
                                                        Card request successfull
                                                    </option>
                                                     
                                                    <option value="pin_update_otp" {{(($SmsEditor->type=='pin_update_otp')?'selected':'')}}>
                                                        Config initiated Pin for OTP
                                                    </option>
                                                    <option value="password_updated" {{(($SmsEditor->type=='password_updated')?'selected':'')}}>
                                                        Config password updated
                                                    </option>
                                                    <option value="limit_request_success" {{(($SmsEditor->type=='limit_request_success')?'selected':'')}}>
                                                        Limit request successfull
                                                    </option>
                                                    <option value="loan_request_success" {{(($SmsEditor->type=='loan_request_success')?'selected':'')}}>
                                                        Loan request successfull
                                                    </option>
                                                    <option value="transfer_otp" {{(($SmsEditor->type=='transfer_otp')?'selected':'')}}>
                                                        Transfer OTP
                                                    </option>
                                                    <option value="transfer_debited" {{(($SmsEditor->type=='transfer_debited')?'selected':'')}}>
                                                        Transfer amount debited
                                                    </option>
                                                     <option value="transfer_credited" {{(($SmsEditor->type=='transfer_credited')?'selected':'')}}>
                                                        Transfer amount credited
                                                    </option>
                                                    <option value="otp_verified" {{(($SmsEditor->type=='otp_verified')?'selected':'')}}>
                                                        Transfer OTP verified 
                                                    </option>
                                                     <option value="otp_wrong" {{(($SmsEditor->type=='otp_wrong')?'selected':'')}}>
                                                        Transfer OTP wrong
                                                    </option>
                                                     <option value="charges_debited" {{(($SmsEditor->type=='charges_debited')?'selected':'')}}>
                                                       Transfer amount charges debited
                                                    </option>
                                                    <option value="cash_withdrawal" {{(($SmsEditor->type=='cash_withdrawal')?'selected':'')}}>
                                                        Cash withdrawal
                                                    </option>
                                                    <option value="login_alert" {{(($SmsEditor->type=='login_alert')?'selected':'')}}>
                                                       Login alert
                                                    </option>
                                                   <option value="profile_update" {{(($SmsEditor->type=='profile_update')?'selected':'')}}>
                                                       Profile Update
                                                    </option>
                                                    <option value="account_opening_approval" {{(($SmsEditor->type=='account_opening_approval')?'selected':'')}}>
                                                       Account Opening Approval Notice
                                                    </option>
                                                    <option value="verify_phone"  {{(($SmsEditor->type=='verify_phone')?'selected':'')}}>
                                                      Verification code to verify phone
                                                    </option >
                                                     <option value="account_opening_approval" {{(($SmsEditor->type=='account_opening_approval')?'selected':'')}}>  Account opening approval
                                                    </option>
                                                    <option value="registration_denied" {{(($SmsEditor->type=='registration_denied')?'selected':'')}}> Registration Denied
                                                    </option>
                                                    <option value="withdraw_approved" {{(($SmsEditor->type=='withdraw_approved')?'selected':'')}}> Withdraw Request Approved
                                                    </option>
                                                    <option value="withdraw_rejected" {{(($SmsEditor->type=='withdraw_rejected')?'selected':'')}}> Withdraw Request Rejected
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">

                                            <label for="Ext">Note: Use these Magical string for dynamic Data</label>
                                            <textarea class="form-control" id="magic" cols="10" rows="4" readonly=""
                                            style="background-color: white;">
                                            </textarea>

                                        <p></p>

                                        </div>
                                             <div class="form-group">

                                            <label for="Ext">Sms Name</label>
                                            <input type = "text" name = "name" class="form-control" value = "{{$SmsEditor->name}}">

                                        <p></p>

                                        </div>
                                            <div class="form-group">

                                            <label for="Ext">Sms </label>

                                             <textarea required maxlength="250"  name="sms" class="form-control" id="" cols="15" rows="8">{{$SmsEditor->sms}}</textarea >
                                             <div id="the-count">
                                                <span id="current">0</span>
                                                <span id="maximum">/ 250</span>
                                              </div>

                                        </div>

                                        <button type="submit" class="btn btn-gradient-primary ">Edit Sms </button>
                                       
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
  
function fetch_data(type)
{  
  
  //alert(type);
  $.ajax({
   url:"{{ asset('smseditor-fetch') }}",
   method:"get",
   data: {type:type},
   dataType:"json",
   success:function(data)
   {

   console.log(data);

    $('#magic').html(data.data);
    
   }
  });
  
 }
 $(document).ready(function(type){
     
     $(this).find("option:selected").each(function(){
            var type = $(this).attr("value");
            $.ajax({
   url:"{{ asset('smseditor-fetch') }}",
   method:"get",
   data: {type:type},
   dataType:"json",
   success:function(data)
   {

   console.log(data);

    $('#magic').html(data.data);
    
   }
  });
     });
  
 });
 
    </script>
    <script>
        $('textarea').keyup(function() {
    
  var characterCount = $(this).val().length,
      current = $('#current'),
      maximum = $('#maximum'),
      theCount = $('#the-count');
    
  current.text(characterCount);
 
  
  /*This isn't entirely necessary, just playin around*/
  if (characterCount < 70) {
    current.css('color', '#666');
  }
  if (characterCount > 70 && characterCount < 90) {
    current.css('color', '#6d5555');
  }
  if (characterCount > 90 && characterCount < 100) {
    current.css('color', '#793535');
  }
  if (characterCount > 100 && characterCount < 120) {
    current.css('color', '#841c1c');
  }
  if (characterCount > 120 && characterCount < 139) {
    current.css('color', '#8f0001');
  }
  
  if (characterCount >= 140) {
    maximum.css('color', '#8f0001');
    current.css('color', '#8f0001');
    theCount.css('font-weight','bold');
  } else {
    maximum.css('color','#666');
    theCount.css('font-weight','normal');
  }
  
      
});
    </script>
</body>

</html>




