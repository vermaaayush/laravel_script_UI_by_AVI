  </div>
      <!-- Wrapper END -->
       <!-- Footer -->
      <footer class="iq-footer">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-6">
                  <!-- <ul class="list-inline mb-0">
                     <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                     <li class="list-inline-item"><a href="#">Terms of Use</a></li>
                  </ul> -->
               </div>
               <div class="col-lg-12 text-center">
                  Copyright &copy; 2020  All Rights Reserved.
               </div>
            </div>
         </div>
      </footer>
      <!-- Footer END -->

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->

      <script src="{{ asset('js/popper.min.js') }}"></script>
      <script src="{{ asset('js/bootstrap.min.js') }}"></script>
      <!-- Appear JavaScript -->
      <script src="{{ asset('js/jquery.appear.js') }}"></script>
      <!-- Countdown JavaScript -->
      <!-- <script src="{{ asset('js/countdown.min.js') }}"></script> -->
      <!-- Counterup JavaScript -->
      <script src="{{ asset('js/waypoints.min.js') }}"></script>
      <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
      <!-- Wow JavaScript -->
      <script src="{{ asset('js/wow.min.js') }}"></script>
            <!-- Slick JavaScript -->
      <script src="{{ asset('js/slick.min.js') }}"></script>
      <!-- Select2 JavaScript -->
      <script src="{{ asset('js/select2.min.js') }}"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="{{ asset('js/smooth-scrollbar.js') }}"></script>
      <!-- lottie JavaScript -->
      <script src="{{ asset('js/lottie.js') }}"></script>
       <!-- core JavaScript -->
      <script src="{{ asset('js/core.js') }}"></script>
      <!-- charts JavaScript -->
      <script src="{{ asset('js/charts.js') }}"></script>
      <!-- am animated JavaScript -->
      <script src="{{ asset('js/animated.js') }}"></script>
      <!-- am kelly JavaScript -->
      <script src="{{ asset('js/kelly.js') }}"></script>

       <!-- Style Customizer -->
      <!-- Chart Custom JavaScript -->
      <script src="{{ asset('js/chart-custom.js') }}"></script>
      <!-- Custom JavaScript -->
      <script src="{{ asset('js/custom.js') }}"></script>
      <script src="{{ asset('js/south.js') }}"></script>

      <script>
         /* Own Account Transfer */
         function getAccounts() {
            var url = "{{ asset('get-accounts-to-transfer') }}";
            var transferFrom = $('#transfer_from').val();
            var data = new FormData();
            data.append('_token', "<?php echo csrf_token(); ?>");
            data.append('transferFrom', transferFrom);
            $.ajax({
               url: url,
               method: "POST",
               data: data,
               processData: false,
               contentType: false,
               success: function(res) {
                  var data = JSON.parse(res);
                  var options = '<option value="">--Select an Account--</option>';
                  for(i=0; i<data.length; i++) {
                     options += '<option value="'+data[i].account_no+'">'+data[i].account_no+'</option>';
                  }
                  $('#transfer_to').html(options);
               }
            })
         }

         $('.update-card-pin #account').on('change', function() {
            var account_no = $('.update-card-pin #account').val();

            var url = "{{ asset('get-cards-to-update-pin') }}";
            var account_no = $('#account').val();
            var data = new FormData();
            data.append('_token', "<?php echo csrf_token(); ?>");
            data.append('account_no', account_no);
            $.ajax({
               url: url,
               method: "POST",
               data: data,
               processData: false,
               contentType: false,
               success: function(res) {
                  var data = JSON.parse(res);
                  var options = '<option value="">--Select a Card--</option>';
                  for(i=0; i<data.length; i++) {
                     options += '<option value="'+data[i].id+'">'+data[i].card_number+'</option>';
                  }
                  $('#card').html(options);
               }
            })
         });
         // $(document).on('click', '#submit-first-step', function(e) {
         //    var transfer_from = $('#transfer_from').val()
         //    if(transfer_from == '') {
         //       alert('Please select Transfer From Account');
         //       return false;
         //    }

         //    var transfer_to = $('#transfer_to').val()
         //    if(transfer_to == '') {
         //       alert('Please select Transfer To Account');
         //       return false;
         //    }

         //    var amount = $('#amount').val()
         //    if(amount == '') {
         //       alert('Please enter Amount to Transfer');
         //       return false;
         //    }

         //    var url = "{{ asset('initiate-own-account-transfer') }}";
         //    var data = new FormData();
         //    data.append('_token', "<?php echo csrf_token(); ?>");
         //    data.append('transfer_from', transfer_from);
         //    data.append('transfer_to', transfer_to);
         //    data.append('amount', amount);
         //    data.append('description', $('#description').val());
         //    $.ajax({
         //       url: url,
         //       method: "POST",
         //       data: data,
         //       processData: false,
         //       contentType: false,
         //       success: function(res) {
         //          var data = JSON.parse(res);
         //          if(data.error) {
         //             alert(data.msg);
         //          }
         //          else {
         //             $('#tran_id').val(data.tran_id);
         //             $('#next-step-second').click();
         //          }
         //       }
         //    });
         // });

         // $(document).on('click', '#submit-second-step', function(e) {
         //    var otp = $('#otp').val()
         //    if(otp == '') {
         //       alert('Please enter OTP');
         //       return false;
         //    }

         //    var url = "{{ asset('success-own-account-transfer') }}";
         //    var data = new FormData();
         //    data.append('_token', "<?php echo csrf_token(); ?>");
         //    data.append('otp', otp);
         //    data.append('tran_id', $('#tran_id').val());
         //    $.ajax({
         //       url: url,
         //       method: "POST",
         //       data: data,
         //       processData: false,
         //       contentType: false,
         //       success: function(res) {
         //          var data = JSON.parse(res);
         //          if(data.error) {
         //             alert(data.msg);
         //             window.location = "own-account-transfer";
         //          }
         //          else {
         //             $('#next-step-third').click();
         //          }
         //       }
         //    });
         // });
         /* Own Account Transfer */

         /* Same Bank Transfer */
         // $(document).on('click', '#submit-first-step-sb', function(e) {
         //    var beneficiary_account = $('#beneficiary_account').val()
         //    if(beneficiary_account == '') {
         //       alert('Please enter Beneficiary Account');
         //       return false;
         //    }

         //    var transfer_from = $('#transfer_from').val()
         //    if(transfer_from == '') {
         //       alert('Please select Account');
         //       return false;
         //    }

         //    var amount = $('#amount').val()
         //    if(amount == '') {
         //       alert('Please enter Amount to Transfer');
         //       return false;
         //    }

         //    var url = "{{ asset('initiate-same-bank-transfer') }}";
         //    var data = new FormData();
         //    data.append('_token', "<?php echo csrf_token(); ?>");
         //    data.append('beneficiary_account', beneficiary_account);
         //    data.append('transfer_from', transfer_from);
         //    data.append('amount', amount);
         //    data.append('beneficiary_name', $('#beneficiary_name').val());
         //    data.append('description', $('#description').val());
         //    $.ajax({
         //       url: url,
         //       method: "POST",
         //       data: data,
         //       processData: false,
         //       contentType: false,
         //       success: function(res) {
         //          var data = JSON.parse(res);
         //          if(data.error) {
         //             alert(data.msg);
         //          }
         //          else {
         //             $('#tran_id').val(data.tran_id);
         //             $('#next-step-second-sb').click();
         //          }
         //       }
         //    });
         // });

         // $(document).on('click', '#submit-second-step-sb', function(e) {
         //    var otp = $('#otp').val()
         //    if(otp == '') {
         //       alert('Please enter OTP');
         //       return false;
         //    }

         //    var url = "{{ asset('success-same-bank-transfer') }}";
         //    var data = new FormData();
         //    data.append('_token', "<?php echo csrf_token(); ?>");
         //    data.append('otp', otp);
         //    data.append('tran_id', $('#tran_id').val());
         //    $.ajax({
         //       url: url,
         //       method: "POST",
         //       data: data,
         //       processData: false,
         //       contentType: false,
         //       success: function(res) {
         //          var data = JSON.parse(res);
         //          if(data.error) {
         //             alert(data.msg);
         //             window.location = "transfer-to-same-bank";
         //          }
         //          else {
         //             $('#next-step-third-sb').click();
         //          }
         //       }
         //    });
         // });
         /* Same Bank Transfer */
         // $('#statement-to-thirdparty-form #account').on('change', function() {
         //    $('#account_name').val($('#statement-to-thirdparty-form #account option:selected').attr('data-account-title'));
         // });
         function resetFields() {
            $('.email-div').attr('required', false).hide();
            $('.fax-div').attr('required', false).hide();
            $('.address-div').attr('required', false).hide();
            $('.whatsapp-div').attr('required', false).hide();
            $('.sms-div').attr('required', false).hide();
         }
         $('#statement-to-thirdparty-form #destination').on('change', function() {
            resetFields();
            var destination = $('#destination').val();
            if(destination != '') {
               $('.' + destination + "-div").show();
               $('#' + destination).attr('required', true);
            }
         });

         /* Request Loan Form */
         $('#firstLoanForm').on('click', function() {
            $('.text-danger').hide();
            var valid = true;

            var dob = $('#dob').val();
            if(dob == '') {
               $('.dob-error').show();
               valid = false;
            }

            var fname = $('#fname').val();
            if(fname == '') {
               $('.fname-error').show();
               valid = false;
            }

            var lname = $('#lname').val();
            if(lname == '') {
               $('.lname-error').show();
               valid = false;
            }

            var loan_type = $('#loan_type').val();
            if(loan_type == '') {
               $('.loan_type-error').show();
               valid = false;
            }

            var account_no = $('#account_no').val();
            if(account_no == '') {
               $('.account_no-error').show();
               valid = false;
            }

            var loan_amount = $('#loan_amount').val();
            if(loan_amount == '') {
               $('.loan_amount-error').show();
               valid = false;
            }

            var loan_tenure = $('#loan_tenure').val();
            if(loan_tenure == '') {
               $('.loan_tenure-error').show();
               valid = false;
            }

            var employment_type = $('#employment_type').val();
            if(employment_type == '') {
               $('.employment_type-error').show();
               valid = false;
            }

            if(!$('#info_correct').is(':checked')) {
               $('.info_correct-error').show();
               valid = false;
            }

            if(valid) {
               $('#secondLoanStep').click();
            }
         });

         $('#secondLoanForm').on('click', function() {
            $('.text-danger').hide();
            var valid = true;

            var email = $('#email').val();
            if(email == '') {
               $('.email-error').show();
               valid = false;
            }

            var mobile = $('#mobile').val();
            if(mobile == '') {
               $('.mobile-error').show();
               valid = false;
            }

            var state = $('#state').val();
            if(state == '') {
               $('.state-error').show();
               valid = false;
            }

            var city = $('#city').val();
            if(city == '') {
               $('.city-error').show();
               valid = false;
            }

            var address = $('#address').val();
            if(address == '') {
               $('.address-error').show();
               valid = false;
            }

            var taken_loan_before = $('#taken_loan_before').val();
            if(taken_loan_before == '') {
               $('.taken_loan_before-error').show();
               valid = false;
            }

            if(valid) {
               $('#thirdLoanStep').click();
            }
         });

         $('#thirdLoanForm').on('click', function() {
            $('.text-danger').hide();
            var valid = true;

            if($('#photo').get(0).files.length == 0) {
               $('.photo-error').show();
               valid = false;
            }

            if($('#signature').get(0).files.length == 0) {
               $('.signature-error').show();
               valid = false;
            }

            if(valid) {
               var url = "{{ asset('insert-loan-request') }}";
               var data = new FormData();
               data.append('_token', "<?php echo csrf_token(); ?>");
               $.ajax({
                  url: url,
                  method: "POST",
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(res) {
                     $('#fourthLoanStep').click();
                  }
               });
            }
         });

         $('.limit-accounts input[type="radio"]').on('click', function() {
            var account_no = $(this).val();
            var url = "{{ asset('get-limits-by-account') }}";
               var data = new FormData();
               data.append('_token', "<?php echo csrf_token(); ?>");
               data.append('account_no', account_no);
               $.ajax({
                  url: url,
                  method: "POST",
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(res) {
                     var data = JSON.parse(res);
                     var content = '';
                     for(var i=0; i<data.length; i++) {
                        if(data[i].status == 0) {
                           var status = 'Pending';
                        }
                        if(data[i].status == 1) {
                           var status = 'Approved';
                        }
                        if(data[i].status == 2) {
                           var status = 'Rejected';
                        }
                        content += "<tr><td>" + data[i].type + " Limit(Monthly)*</td><td>" + data[i].account_currency + " " + data[i].limit_amount + "</td><td>" + status +"</td></tr>";
                     }
                     $('#limits-body').html(content);
                  }
               });
         });
         $("#amount").on('keyup', function(){
             var n = parseInt($(this).val().replace(/\D/g,''),10);
             $(this).val(n.toLocaleString());
         });
         $("#loan_amount").on('keyup', function(){
             var n = parseInt($(this).val().replace(/\D/g,''),10);
             $(this).val(n.toLocaleString());
         });

         $('.password-update-form #firstForm').on('click', function() {
            var user_id = $('.password-update-form #user_id').val();
            if(user_id == '') {
               $('#passwordUpdateError').show().html('Please enter User ID');
            }
            else {
                if($('#loading').length) $('#loading').show();
               var url = "{{ asset('validate-user-id') }}";
               var data = new FormData();
               data.append('_token', "<?php echo csrf_token(); ?>");
               data.append('user_id', user_id);
               $.ajax({
                  url: url,
                  method: "POST",
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(res) {
                     if($('#loading').length) $('#loading').hide();
                     var data = typeof res === 'string' ? JSON.parse(res) : res;
                     if(data.valid == true) {
                        $('#passwordUpdateError').hide();
                        $('#pin_step_1').hide();
                        $('#pin_step_2').fadeIn();
                     }
                     else {
                        $('#user_id').val('');
                        $('#passwordUpdateError').show().html('Please enter correct User ID');
                     }
                  },
                  error: function() {
                     if($('#loading').length) $('#loading').hide();
                     $('#passwordUpdateError').show().html('An error occurred. Please try again.');
                  }
               });
            }
         });

         $('.password-update-form #secondForm').on('click', function() {
            var pin = $('#pin').val();
            var confirm_pin = $('#confirm_pin').val();

            if(pin == '' || confirm_pin == '') {
               $('#passwordUpdateError').show().html('Please enter PIN and Confirm PIN');
            }
            else if(pin.length < 4) {
               $('#passwordUpdateError').show().html('PIN must be at least 4 digits long.');
            }
            else if(pin.length > 6) {
               $('#passwordUpdateError').show().html('PIN can be maximum 6 digits long.');
            }
            else if(pin !== confirm_pin) {
               $('#pin').val('');
               $('#confirm_pin').val('');
               $('#passwordUpdateError').show().html('PIN and Confirm PIN do not match');
            }
            else {
                if($('#loading').length) $('#loading').show();
               var url = "{{ asset('generate-otp-for-password-update') }}";
               var data = new FormData();
               data.append('_token', "<?php echo csrf_token(); ?>");
               $.ajax({
                  url: url,
                  method: "POST",
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(res) {
                     if($('#loading').length) $('#loading').hide();
                     $('#passwordUpdateError').hide();
                     $('#pin_step_2').hide();
                     $('#pin_step_3').fadeIn();
                  },
                  error: function() {
                     if($('#loading').length) $('#loading').hide();
                     $('#passwordUpdateError').show().html('Failed to generate OTP. Please try again.');
                  }
               });
            }
         });

         $('.password-update-form #thirdForm').on('click', function() {
            var otp = $('#otp').val();
            var pin = $('#pin').val();
            if(otp == '') {
               $('#passwordUpdateError').show().html('Please enter OTP');
            }
            else {
                if($('#loading').length) $('#loading').show();
               var url = "{{ asset('validate-otp-for-password-update') }}";
               var data = new FormData();
               data.append('_token', "<?php echo csrf_token(); ?>");
               data.append('otp', otp);
               data.append('pin', pin);
               $.ajax({
                  url: url,
                  method: "POST",
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(res) {
                     if($('#loading').length) $('#loading').hide();
                     var data = typeof res === 'string' ? JSON.parse(res) : res;
                     if(data.valid == false) {
                        $('#otp').val('');
                        $('#passwordUpdateError').show().html('You have entered wrong OTP');
                     }
                     else {
                        $('#passwordUpdateError').hide();
                        $('#pin_step_3').hide();
                        $('#pin_step_4').fadeIn();
                     }
                  },
                  error: function() {
                     if($('#loading').length) $('#loading').hide();
                     $('#passwordUpdateError').show().html('An error occurred. Please try again.');
                  }
               });
            }
         });
      </script>

   </body>
</html>
