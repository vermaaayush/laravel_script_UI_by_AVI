    </main>
    <!-- Wrapper END -->

    <!-- Sovereign Institutional Banking Footer -->
    <footer class="mt-auto py-5 px-6 border-t border-surface-container-high/60 bg-surface-container-lowest text-secondary text-xs">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-2">
                <span class="font-heading font-semibold text-on-surface"><?= $confiG->bank_name ?? 'OripioFin' ?></span>
                <span>•</span>
                <span>Sovereign Tier Custody, Clearing & Multi-Currency Treasury</span>
            </div>
            <div class="flex items-center gap-3 text-secondary">
                <span>Zurich • Singapore • London • New York</span>
                <span class="hidden sm:inline">•</span>
                <span>Copyright &copy; {{ date('Y') }} All Rights Reserved.</span>
            </div>
        </div>
    </footer>
</div> <!-- Close flex min-h-screen wrapper from topNav -->

      <!-- Optional JavaScript & Legacy Handlers -->
      <script src="{{ asset('js/popper.min.js') }}"></script>
      <script src="{{ asset('js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('js/jquery.appear.js') }}"></script>
      <script src="{{ asset('js/waypoints.min.js') }}"></script>
      <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
      <script src="{{ asset('js/slick.min.js') }}"></script>
      <script src="{{ asset('js/select2.min.js') }}"></script>
      <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
      <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
      <script src="{{ asset('js/smooth-scrollbar.js') }}"></script>
      <script src="{{ asset('js/core.js') }}"></script>
      <script src="{{ asset('exasset/datatables.net/js/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('js/custom.js') }}"></script>

      <script>
         /* Own Account Transfer Dropdown Population */
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
                  var options = '<option value="">-- Select Destination Account --</option>';
                  for(i=0; i<data.length; i++) {
                     options += '<option value="'+data[i].account_no+'">'+data[i].account_no+' ('+ (data[i].account_currency || '') +' '+ (parseFloat(data[i].account_balance || 0).toLocaleString()) +')</option>';
                  }
                  $('#transfer_to').html(options);
               }
            });
         }

         /* Card PIN Update Selection */
         $('.update-card-pin #account').on('change', function() {
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
                  var options = '<option value="">-- Select a Card --</option>';
                  for(i=0; i<data.length; i++) {
                     options += '<option value="'+data[i].id+'">'+data[i].card_number+'</option>';
                  }
                  $('#card').html(options);
               }
            });
         });

         /* Statement to Third Party Destination Fields */
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

         /* Request Loan Steps */
         $('#firstLoanForm').on('click', function() {
            $('.text-danger').hide();
            var valid = true;

            var fields = ['dob', 'fname', 'lname', 'loan_type', 'account_no', 'loan_amount', 'loan_tenure', 'employment_type'];
            fields.forEach(function(f) {
                if($('#' + f).val() == '') {
                    $('.' + f + '-error').show();
                    valid = false;
                }
            });

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

            var fields = ['email', 'mobile', 'state', 'city', 'address', 'taken_loan_before'];
            fields.forEach(function(f) {
                if($('#' + f).val() == '') {
                    $('.' + f + '-error').show();
                    valid = false;
                }
            });

            if(valid) {
               $('#thirdLoanStep').click();
            }
         });

         $('#thirdLoanForm').on('click', function() {
            $('.text-danger').hide();
            var valid = true;

            if($('#photo').length && $('#photo').get(0).files.length == 0) {
               $('.photo-error').show();
               valid = false;
            }

            if($('#signature').length && $('#signature').get(0).files.length == 0) {
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

         /* Account Limits */
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
                     var status = data[i].status == 0 ? 'Pending' : (data[i].status == 1 ? 'Approved' : 'Rejected');
                     content += "<tr><td class='font-medium'>" + data[i].type + " Limit (Monthly)</td><td>" + data[i].account_currency + " " + data[i].limit_amount + "</td><td><span class='px-2 py-0.5 rounded-full text-xs font-semibold " + (status == 'Approved' ? 'bg-emerald-50 text-emerald-700' : (status == 'Pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700')) + "'>" + status +"</span></td></tr>";
                  }
                  $('#limits-body').html(content);
               }
            });
         });

         /* Number formatting helpers on inputs */
         $("#amount, #amountWith, #priceCashDeposit, #priceBitcoin, #loan_amount").on('keyup', function(){
             var val = $(this).val().replace(/\D/g,'');
             if(val !== '') {
                 var n = parseInt(val, 10);
                 $(this).val(n.toLocaleString());
             }
         });

         /* Password / PIN Multi-Step Handlers */
         $('.password-update-form #firstForm').on('click', function() {
            var user_id = $('.password-update-form #user_id').val();
            if(user_id == '') {
               $('#passwordUpdateError').show().html('Please enter User ID');
            } else {
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
                     } else {
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
            } else if(pin.length < 4) {
               $('#passwordUpdateError').show().html('PIN must be at least 4 digits long.');
            } else if(pin.length > 6) {
               $('#passwordUpdateError').show().html('PIN can be maximum 6 digits long.');
            } else if(pin !== confirm_pin) {
               $('#pin').val('');
               $('#confirm_pin').val('');
               $('#passwordUpdateError').show().html('PIN and Confirm PIN do not match');
            } else {
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
            } else {
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
                     } else {
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
         
         /* Clean DataTables initialization */
         $(function(){
             if($('._dataTable').length) {
                 $('._dataTable').DataTable({
                    dom: "<'flex flex-col sm:flex-row justify-between items-center gap-3 mb-4'lf><'overflow-x-auto w-full't><'flex flex-col sm:flex-row justify-between items-center gap-3 mt-4 text-xs text-slate-500'ip>",
                    order: [],
                    aLengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                    language: {
                        search: "",
                        searchPlaceholder: "Filter records...",
                        lengthMenu: "Show _MENU_ entries"
                    }
                });
             }
             if($('._dataTable5').length) {
                 $('._dataTable5').DataTable({
                    dom: "<'flex flex-col sm:flex-row justify-between items-center gap-3 mb-4'lf><'overflow-x-auto w-full't><'flex flex-col sm:flex-row justify-between items-center gap-3 mt-4 text-xs text-slate-500'ip>",
                    order: [],
                    aLengthMenu: [[5, 10, 25], [5, 10, 25]],
                    language: {
                        search: "",
                        searchPlaceholder: "Filter records...",
                        lengthMenu: "Show _MENU_ entries"
                    }
                });
             }
         });
      </script>
   </body>
</html>
