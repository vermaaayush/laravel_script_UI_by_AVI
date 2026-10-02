@include('header')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Customer Activities</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Customer Activities</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('flash::message')
                                            <h4 class="card-title">Filter By Customer</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" action="customer-activities">
                                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-control" name="customer" required>
                                                                <option value="">Select Customer</option>
                                                                @foreach($customers as $cust)
                                                                    <option value="{{ $cust->id }}" <?= $customer == $cust->id?'selected':'' ?>>{{ $cust->cust_name . " " . $cust->middle_name . " " . $cust->sur_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-gradient-primary mr-2">Filter</button>    
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                    
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('flash::message')
                                            <h4 class="card-title">List of Customer Activities</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
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
                                                    @foreach ($activities as $single)
                                                    <?php $customer = DB::table('ba_account_holders')->where('id',$single->customer)->first() ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?php if($customer->cust_photo != '') { ?>
                                                                <?php if(strpos($customer->cust_photo, 'data:image/') !== false) { ?>
                                                                    <img src="{{ $customer->cust_photo }}" class="card-image" alt="image" style="width: 50px; height: auto;" />
                                                                <?php } else { ?>
                                                                    <img src="{{ 'https://' . $config[0]->bank_url . '/admin/uploads/' . $customer->cust_photo }}" alt="image" />
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
                </div>
                <!-- content-wrapper ends -->


                @include('footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/misc.js"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
</body>

</html>