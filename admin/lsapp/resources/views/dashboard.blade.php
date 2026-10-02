@include('header')
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        @include('flash::message')
        <!-- Dashboard cards -->
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Customers <i
                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                        </h4>
                        <h2 class="">{{ $data['customersCount'] }}</h2>
                        <!-- <h6 class="card-text">Increased by 60%</h6> -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Accounts <i
                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                        <h2 class="">{{ $data['accountsCount'] }}</h2>
                        <!-- <h6 class="card-text">Decreased by 10%</h6> -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3"> Users Online <i class="mdi mdi-diamond mdi-24px float-right"></i>
                        </h4>
                        <h2 class="">{{ $data['usersOnline'] }}</h2>
                        <!-- <h6 class="card-text">Increased by 5%</h6> -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 stretch-card grid-margin">
                <div class="card bg-gradient-warning card-img-holder text-dark">
                    <div class="card-body">
                        <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Crypto Total Deposit <i
                            class="mdi mdi-chart-line mdi-24px float-right"></i>
                        </h4>
                        <?php 
                        
                         $datas = DB::table('transactions')
            ->where('status', 'credit') // Filter by status 'credit'
            ->where('subject', 'Funds Deposit') // Filter by subject 'Funds Deposit'
            ->sum('amount'); // Sum the 'amount' field
            
            
            $datas2 = DB::table('transactions')
            ->where('status', 'credit') // Filter by status 'credit'
            ->where('subject', 'Funds Deposit') // Filter by subject 'Funds Deposit'
            ->whereDate('created_at', '=', today()) // Filter for today's date
            ->sum('amount'); // Sum the 'amount' field


                        
                        ?>
                   <h2 class="">${{ number_format(round($datas), 0, '.', ',') }}</h2>


                        <!-- <h6 class="card-text">Increased by 60%</h6> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 stretch-card grid-margin">
                <div class="card bg-gradient-secondary card-img-holder text-dark">
                    <div class="card-body">
                        <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Crypto Today Deposit<i
                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                        </h4>
                       <h2 class="">${{ number_format(round($datas2), 0, '.', ',') }}</h2>

                    </div>
                </div>
            </div>
           
        </div>
        
        
        <div class="row">
            <div class="col-12 grid-margin">
                <form method="post" action="order-card">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order a Preloaded Master/Visa Card (Physical/Virtual Cards also available)</h4>
                        <p id="textBtcSendCard" style="color:red;"></p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Card Type</label>
                                    <select name="card_type" id="card_type" class="form-control" required>
                                        <option value="">-- Select --</option>
                                        <option value="Physical">Physical</option>
                                        <option value="Virtual">Virtual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Topup amount</label>
                                    <select name="pricing" class="form-control" id="pricingCard" required>
                                        <option value="">-- Select --</option>
                                        <?php foreach(json_decode($data['cardpricing'])->pricing as $withkey => $withvalue){ ?> 
                                            <option value="<?= $withvalue->price ?>"><?= $withvalue->name ?> - $<?= $withvalue->price ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="containerAddress">
                                <div class="form-group">
                                    <label for="" id="lblAddEmail">Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Address" id="inputAddress" required/>
                                </div>
                            </div>   
                            <div class="col-md-3" id="containerBitHash">
                                <div class="form-group">
                                    <label for="" id="lblBitHash">Bitcoin Hash</label>
                                    <textarea type="text" name="bit_hash" class="form-control" placeholder="Bitcoin Hash" id="inputBitHash" required></textarea>
                                </div>
                            </div>   
                            <input type="hidden" name="btc" id="cardBtc" />
                            <input type="hidden" name="btcrate" value="<?= $data['dollerRate'] ?>" />
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Order</button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 grid-margin">
                <form method="post" action="request-feature">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Request A Feature / Modification to Bank Script (Paid/free Request)</h4>
                        <p>Please note only paid request will be responded to, free request will be treated as a suggestion.</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Subject</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Subject" required/>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required/>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Message</label>
                                    <textarea type="text" name="msg" class="form-control" placeholder="Message" required></textarea>
                                </div>
                            </div>   
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Request Type</label>
                                    <select name="request_type" id="request_type" class="form-control" required>
                                        <option value="">-- Select --</option>
                                        <option value="Free">Free</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="req_budget_container" style="display:none;">
                                <div class="form-group">
                                    <label for="">Budget (USD)</label>
                                    <input type="text" name="budget" class="form-control decimal-num" id="req_budget" placeholder="Budget" />
                                </div>
                            </div> 
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Send</button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <form method="post" action="order-twilio">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Twilio account</h4>
                        <p id="textBtcSendTwilio" style="color:red;"></p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Amount</label>
                                    <input type="text" name="amount" class="form-control decimal-num" id="twilioAmount" placeholder="Amount" required/>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Bitcoin Hash</label>
                                    <textarea type="text" name="bithash" class="form-control" placeholder="Bitcoin Hash" required></textarea>
                                </div>
                            </div>   
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                    <input type="hidden" name="btcrate" value="<?= $data['dollerRate'] ?>" />
                                    <input type="hidden" name="btc" id="twilioBtc" />
                                    <button type="submit" class="btn btn-success">Order</button>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>        
        
        <!--User Activities section-->
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Loan Requests</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> User </th>
                                        <th> Loan Type </th>
                                        <th> Status </th>
                                        <th> DOB </th>
                                        <th> Account No. </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['loans'] as $transaction)
                                    <tr>
                                        <td>
                                            {{ $transaction->fname . " " . $transaction->lname }}
                                        </td>
                                        <td> 
                                            {{ $transaction->loan_type }}
                                        </td>
                                        <td>
                                            <?php if($transaction->status == '1'){ ?>
                                                <label class="badge badge-gradient-success">APPROVED</label>
                                            <?php } ?>
                                            <?php if($transaction->status == '0'){ ?>
                                                <label class="badge badge-gradient-warning">PENDING</label>
                                            <?php } ?>
                                            <?php if($transaction->status == '2'){ ?>
                                                <label class="badge badge-gradient-danger">REJECTED</label>
                                            <?php } ?>
                                        </td>
                                        <td> {{ date("M d, Y", strtotime($transaction->dob)) }} </td>
                                        <td> {{ $transaction->account_no }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Card Requests</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> User </th>
                                        <th> Card Type </th>
                                        <th> Status </th>
                                        <th> Date </th>
                                        <th> Account No. </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['cards'] as $transaction)
                                    <?php $cust = DB::table('ba_account_holders')->where('user_id',$transaction->user_id)->first(); ?>
                                    <tr>
                                        <td>
                                            <?= $cust ? $cust->cust_name . " " . $cust->sur_name:'' ?>
                                        </td>
                                        <td> 
                                            {{ $transaction->card_type }}
                                        </td>
                                        <td>
                                            <?php if($transaction->status == '1'){ ?>
                                                <label class="badge badge-gradient-success">APPROVED/ACTIVE</label>
                                            <?php } ?>
                                            <?php if($transaction->status == '0'){ ?>
                                                <label class="badge badge-gradient-warning">PENDING</label>
                                            <?php } ?>
                                            <?php if($transaction->status == '2'){ ?>
                                                <label class="badge badge-gradient-danger">SUSPENDED</label>
                                            <?php } ?>
                                            <?php if($transaction->status == '3'){ ?>
                                                <label class="badge badge-gradient-danger">BLOCKED</label>
                                            <?php } ?>
                                        </td>
                                        <td> {{ date("M d, Y", strtotime($transaction->date)) }} </td>
                                        <td> {{ $transaction->cust_act_number }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Deposit Requests</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> User </th>
                                        <th> Deposit Type </th>
                                        <th> Status </th>
                                        <th> Date </th>
                                        <th> Account No. </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['deposit'] as $transaction)
                                    <?php $cust = DB::table('ba_account_holders')->where('user_id',$transaction->user)->first(); ?>
                                    <?php $account = DB::table('ba_user_accounts')->where('id',$transaction->account)->first() ?>
                                    <tr>
                                        <td>
                                            {{ $cust->cust_name . " " . $cust->sur_name }}
                                        </td>
                                        <td> 
                                            {{ $transaction->deptype }}
                                        </td>
                                        <td>
                                            <label class="badge badge-gradient-warning">PENDING</label>
                                        </td>
                                        <td> {{ date("M d, Y", strtotime($transaction->date_of_deposit)) }} </td>
                                        <td> <?php if($account){ ?>{{ $account->account_no }}<?php } ?></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Withdrawal Requests</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> User </th>
                                        <th> Withdrawal Type </th>
                                        <th> Status </th>
                                        <th> Date </th>
                                        <th> Account No. </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['withdraw'] as $transaction)
                                    <?php $customer = DB::table('ba_account_holders')->where('user_id',$transaction->user)->first() ?>
                                    <?php $account = DB::table('ba_user_accounts')->where('id',$transaction->account)->first() ?>
                                    <tr>
                                        <td><?= $customer->cust_name ?> <?= $customer->middle_name ?> <?= $customer->sur_name ?></td>
                                        <td> 
                                            {{ $transaction->withtype }}
                                        </td>
                                        <td>
                                            <label class="badge badge-gradient-warning">PENDING</label>
                                        </td>
                                        <td> {{ date("M d, Y", strtotime($transaction->date_of_with)) }} </td>
                                        <td> <?php if($account){ ?>{{ $account->account_no }}<?php } ?></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Feedback</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> User </th>
                                        <th> Subject </th>
                                        <th> Message </th>
                                        <th> Date </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['feedback'] as $transaction)
                                    <?php $customer = DB::table('ba_account_holders')->where('user_id',$transaction->user)->first() ?>
                                    <tr>
                                        <td><?= $customer->cust_name ?> <?= $customer->middle_name ?> <?= $customer->sur_name ?></td>
                                        <td> 
                                            {{ $transaction->subject }}
                                        </td>
                                        <td style="max-width:40%;"> 
                                            <?= $transaction->descr ?>
                                        </td>
                                        <td> {{ date("M d, Y", strtotime($transaction->cat)) }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Transfers</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> From </th>
                                        <th> To </th>
                                        <th> Amount </th>
                                        <th> Type </th>
                                        <th> Description </th>
                                        <th> Date </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['transfers'] as $transaction)
                                    <tr>
                                        <td><?= $transaction->f ?></td>
                                        <td><?= $transaction->t ?></td>
                                        <td><?= $transaction->currency ?> <?= $transaction->amount ?></td>
                                        <td><?= $transaction->ttype ?></td>
                                        <td><?= $transaction->descr ?></td>
                                        <td> {{ date("M d, Y", strtotime($transaction->cat)) }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Activities</h4>
                        <div class="table-responsive">
                            <table class="table table-striped tblResponsiveKava">
                                <thead>
                                    <tr>
                                        <th class="text-center"> Photo </th>
                                        <th> Customer </th>
                                        <th> Activity Type </th>
                                        <th class="text-center"> Ip Address </th>
                                        <th> Country </th>
                                        <th> City </th>
                                        <th> Device </th>
                                        <th class="text-center"> Date </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $config = DB::select('select * from configs WHERE id = ?',[1]);
                                @endphp
                                    @foreach ($data['userActivities'] as $single)
                                    <?php $customer = DB::table('ba_account_holders')->where('id',$single->customer)->first() ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if($customer->cust_photo != '') { ?>
                                                <?php if(strpos($customer->cust_photo, 'data:image/') !== false) { ?>
                                                    <img src="{{ $customer->cust_photo }}" class="card-image" alt="image" style="width: 50px; height: auto;" />
                                                <?php } else { ?>
                                                    <img src="{{ 'https://' . $config[0]->bank_url . '/admin/uploads/' . $customer->cust_photo }}" class="card-image" alt="image" style="width: 50px; height: auto;" />

                                                <?php } ?>
                                            <?php }else{ ?>
                                                <img src="{{ asset('uploads/default.png') }}" class="card-img" alt="Profile Picture" style="width: 50px; height: auto;" />
                                            <?php } ?>
                                        </td>
                                        <td><?= $customer->cust_name ?> <?= $customer->middle_name ?> <?= $customer->sur_name ?></td>
                                        <td> {{ $single->activity }} </td>
                                        <td class="text-center"> {{ $single->ip }} </td>
                                        <td> {{ $single->country }} </td>
                                        <td> {{ $single->city }} </td>
                                        <td> {{ $single->os }}<br>{{ $single->browser }} </td>
                                        <td class="text-center"> {{ date("h:i A M d, Y", strtotime($single->cat)) }} </td>    
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
</div>
</div>
</div>
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
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/todolist.js') }}"></script>
<!-- End custom js for this page -->
<script>
    var vc = parseFloat("<?= json_decode($data['cardpricing'])->vcard_comission ?>");
    var pc = parseFloat("<?= json_decode($data['cardpricing'])->pcard_comission ?>");
    var pf = parseFloat("<?= json_decode($data['cardpricing'])->pcard_fees ?>");
    var vf = parseFloat("<?= json_decode($data['cardpricing'])->vcard_fees ?>");
    var tc = parseFloat("<?= json_decode($data['cardpricing'])->twillio_comission ?>");
    var bitRate = parseFloat("<?= $data['dollerRate'] ?>");
    $(function(){
        $('#card_type').change(function(){
           if($('#card_type').val() == 'Physical'){
               //$('#containerAddress').show();
               $('#lblAddEmail').html('Address');
               $("#inputAddress").attr("placeholder", "Address");
           }else if($('#card_type').val() == 'Virtual'){
               //$('#containerAddress').show();
               $('#lblAddEmail').html('Email');
               $("#inputAddress").attr("placeholder", "Email");
           }else{
               $('#containerAddress').hide();
           }
           btcAdd();
        });
        $('#twilioAmount').keyup(function(){
            if($('#twilioAmount').val() != ""){
                price = parseFloat($('#twilioAmount').val());
                total = price + ((price * tc) / 100);
                btc = total * bitRate;
                $('#twilioBtc').val(btc.toFixed(6));
                $('#textBtcSendTwilio').html('Please send exactly '+btc.toFixed(6)+' btc to : <?= json_decode($data['cardpricing'])->bitwallet ?>');
            }else{
                $('#twilioBtc').val(0);
                $('#textBtcSendTwilio').html('');
            }
        });
        $('#pricingCard').change(function(){
             btcAdd();
        });
        $('#request_type').change(function(){
            if($('#request_type').val() == "Paid"){
                $('#req_budget_container').show();
                $('#req_budget').attr('required',true);
            }else{
                $('#req_budget_container').hide();
                $('#req_budget').removeAttr('required');
            }
        })
        $(document).on('keydown','.decimal-num', function(event){ 
    		if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {
    
    		} else {
    			event.preventDefault();
    		}
    		if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
    			event.preventDefault();
    		if($(this).val().indexOf('.') !== -1 && event.keyCode == 110)
    			event.preventDefault();
    	});
    })
    function btcAdd(){
        if($('#pricingCard').val() != "" && $('#card_type').val() != ""){
            if($('#card_type').val() == 'Physical'){
                price = parseFloat($('#pricingCard').val());
                total = price + pf;
                total = total + ((total * pc) / 100);
                btc = total * bitRate;
                $('#cardBtc').val(btc);
                $('#textBtcSendCard').html('Please send exactly '+btc.toFixed(6)+' btc to : <?= json_decode($data['cardpricing'])->bitwallet ?>');
            }
            if($('#card_type').val() == 'Virtual'){
                price = parseFloat($('#pricingCard').val());
                total = price + vf;
                total = total + ((total * vc) / 100);
                btc = total * bitRate;
                $('#cardBtc').val(btc);
                $('#textBtcSendCard').html('Please send exactly '+btc.toFixed(6)+' btc to : <?= json_decode($data['cardpricing'])->bitwallet ?>');
            }
        }else{
            $('#textBtcSendCard').html('');
            $('#cardBtc').val(0);
        }
    }
</script>
</body>
</html>