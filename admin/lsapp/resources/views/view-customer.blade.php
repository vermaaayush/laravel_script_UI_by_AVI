@php

// Using DB query to sum amounts based on transaction subjects
$transactionAmounts = DB::table('transactions')
    ->where('user_id', $customer[0]->user_id)
    ->selectRaw('
        sum(case when subject = "Admin Fund Add" then amount else 0 end) as admin_amount,
        sum(case when subject = "Funds Deposit" then amount else 0 end) as real_amount,
        sum(case when subject = "Fund Transfer" then amount else 0 end) as fund_transfer
    ')
    ->first();

// Accessing the results
$admin_amount = $transactionAmounts->admin_amount;
$real_amount = $transactionAmounts->real_amount;
$fund_transfer = $transactionAmounts->fund_transfer;

 try {
            // Fetch the BTC to USD price
            $response = Http::get('https://www.blockonomics.co/api/price?currency=USD');
    
            if ($response->successful()) {
                $btcPrice = $response->json()['price']; // Price in USD for 1 BTC
            } else {
                throw new \Exception('Failed to fetch BTC price.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching BTC price: ' . $e->getMessage());
            $btcPrice = 0; // Default to 0 if API call fails
        }

        $btcFundInUsd = $customer[0]->btc_fund * $btcPrice;


$data = DB::table('wallets')
    ->where('user_id', $customer[0]->user_id)
    ->where('currency', 'btc')
    ->get();

$all_wallets = DB::table('all_wallets')->where('user_id', $customer[0]->user_id)->get();


$walletData = [
    'btc' => DB::table('wallets')->where('currency', 'btc')->first(),
    'eth' => DB::table('wallets')->where('currency', 'eth')->first(),
    'usdt' => DB::table('wallets')->where('currency', 'usdttrc20')->first(),
];

        

@endphp

@include('header2')
<meta name="csrf-token" content="{{ csrf_token() }}">

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Customer Details</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">User Management</a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ asset('view-customers') }}">View All Customers</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Customer Details</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @include('flash::message')
                                    <h4 class="card-title">Customer Account Information</h4>
                                        <div class="form-group card mb-3" style="max-width: 540px;">
                                            <div class="row no-gutters">
                                                <div class="col-md-4">
                                                    @php
                                                    $config = DB::select('select * from configs WHERE id = ?',[1]);
                                                @endphp
                                                    <?php if($customer[0]->cust_photo != '') { ?>
                                                     <?php if(strpos($customer[0]->cust_photo, 'data:image/') !== false) { ?>
                                                     <img src="{{ $customer[0]->cust_photo }}" class="card-image" alt="image" style="width: 200px;" />
                                                     <?php } else { ?>
                                                        <img src="{{ 'https://' . $config[0]->bank_url . '/admin/uploads/' . $customer[0]->cust_photo }}" alt="image" style="width: 200px;"/>
                                                     <?php } ?>
                                                     <?php } ?>

                                                     @if($customer[0]->cust_photo == '')
                                                    <img src="{{ asset('uploads/default.png') }}" class="card-img" alt="Profile Picture" style="width: 200px;" />
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{$customer[0]->cust_name . " " . $customer[0]->middle_name . " " . $customer[0]->sur_name}}</h5>
                                                        <p class="card-text">{{$customer[0]->cust_mail}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- Profile picture update Section  -->

                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Status</label>
                                            <p>
                                                @if($customer[0]->account_status == 0)
                                                    Pending
                                                @elseif($customer[0]->account_status == 1)
                                                    Approved
                                                @elseif($customer[0]->account_status == 2)
                                                    Suspended
                                                @endif
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Full Name</label>
                                            <p>{{$customer[0]->cust_name . " " . $customer[0]->middle_name . " " . $customer[0]->sur_name}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer ID</label>
                                            <p>{{$customer[0]->customer_id}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">User ID</label>
                                            <p>{{$customer[0]->user_id}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">PIN</label>
                                            <p>{{$customer[0]->cust_password}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Security Question 1</label>
                                            <p>{{$customer[0]->qid}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Security Question Answer</label>
                                            <p>{{$customer[0]->ans}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Security Question 2</label>
                                            <p>{{$customer[0]->qid2}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Security Question Answer</label>
                                            <p>{{$customer[0]->ans2}}</p>
                                        </div>
                                        @if($customer[0]->am != '' && $am) 
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Account Manager</label>
                                            <p>Name: {{$am[0]->name}}</p>
                                            <p>Email: {{$am[0]->email}}</p>
                                            <p>Phone: {{$am[0]->countrycode . " " . $am[0]->phone}}</p>
                                            <p>Photo: <img src="{{ $am[0]->photo }}" style="width: 100px;" /></p>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="exampleInputConfirmPassword1">Email</label>
                                            <p>{{$customer[0]->cust_mail}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Phone Number</label>
                                            <p>{{$customer[0]->cust_countrycode . " " . $customer[0]->cust_phone}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Date of Birth</label>
                                            <p>{{$customer[0]->dob}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mother's Maiden Name</label>
                                            <p>{{$customer[0]->mother_maiden}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Social Security / National ID Number</label>
                                            <p>{{$customer[0]->idnumber}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <p>{{$customer[0]->cust_address}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">City</label>
                                            <p>{{$customer[0]->cust_city}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">State</label>
                                            <p>{{$customer[0]->cust_state}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Post Code</label>
                                            <p>{{$customer[0]->post_code}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Country</label>
                                            <p>{{$customer[0]->cust_country}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">National ID</label>
                                            <p><img src="{{ asset('uploads/' . $customer[0]->cust_natioanl_id) }}" style="width: 100px;" /></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Verification Document</label>
                                            <p><img src="{{ asset('uploads/' . $customer[0]->verification_document) }}" style="width: 100px;" /></p>
                                        </div>
                                        <a href="{{ asset('view-customers') }}"><button class="btn btn-light">Back</button></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                   
                                      
                                       
                                       
        <div class="form-group">
            <label for="max_withdraw">Wallet Balance</label>
            <input type="text" id="max_withdraw" class="form-control" name="country" value="Total Balance: ${{ number_format($btcFundInUsd + $customer[0]->eth_fund  + $customer[0]->usdt_fund) }}" readonly >
        </div>

        <br>
        <div class="form-group">
            <label for="max_withdraw">Admin Added Amount</label>
            @php
                
            @endphp
            <input type="text" id="max_withdraw" class="form-control" name="country" value="Total Balance: ${{ number_format( $admin_amount) }}" readonly >
        </div>
        <br>
        <div class="form-group">
            <label for="max_withdraw">Real Deposit Amount</label>
            <input type="text" id="max_withdraw" class="form-control" name="country" value="Total Balance: ${{ number_format($real_amount) }}" readonly >
        </div>
        <br>
        <div class="form-group">
            <label for="max_withdraw">Transfered Fund Amount</label>
            <input type="text" id="max_withdraw" class="form-control" name="country" value="Total Balacne: ${{ number_format($fund_transfer) }}" readonly >
        </div>
               
               
               
    
    
    
                        </div>


<br>
        <div id="message" style="display: none; padding: 10px; border-radius: 5px;"></div>
        <br>
    <div class="form-group">
    <label for="status">Currency Wallet Generator</label>
    <select class="form-select input-group-text flex-grow-0" id="currency" name="currency">
        <?php if (!$walletData['btc']): ?>
            <option value="btc">Bitcoin</option>
        <?php endif; ?>
        <?php if (!$walletData['eth']): ?>
            <option value="eth">Ethereum</option>
        <?php endif; ?>
        <?php if (!$walletData['usdt']): ?>
            <option value="usdttrc20">USDT TRC20</option>
        <?php endif; ?>
    </select>
</div>
<br>
<i id="loading_ani" class="fa fa-spinner fa-spin" style="display: none;"></i>
<div id="generate_button_box">
    <button class="btn btn-primary" id="generate-btn">Generate</button>
</div>


      </div>






                    </div>
                    
                    
                    
                </div>
                
                <!-- content-wrapper ends -->
      <div class="col-md-12">
        <div class="card">
           
            <div class="card-content collapse show">
                <div class="card-body">
                    <h2>Generated BTC Wallets</h2>
                    
                    <div class="table-responsive">
                        <table class="table ">
                           
                            <tbody>

                                @if ($data)
                                    
                               
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                           
                                            <th>Currency</th>
                                            <th>Wallet Balance</th>
                                            <th>Address</th>
                                            <th>QR Code</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $wallet)
                                        <tr>
                                            
                                            <td>{{ strtoupper($wallet->currency) }}</td>
                                            
                                            <td>
                                                @if (strtolower($wallet->currency) == 'btc')
                                                    ${{ number_format($btcFundInUsd ) }} ({{ $customer[0]->btc_fund }} BTC)
                                                @elseif (strtolower($wallet->currency) == 'eth')
                                                    ${{ number_format($customer[0]->eth_fund) }}
                                                @elseif (strtolower($wallet->currency) == 'usdttrc20')
                                                    ${{ number_format($customer[0]->usdt_fund) }}
                                                @else
                                                    $0.00
                                                @endif
                                            </td>

                                            <td>{{ $wallet->address }}</td>
                                            <td><img src="{{ $wallet->qr }}" alt="QR Code" width="100" height="100"></td>
                                            <td>{{ $wallet->created_at }}</td>
                                            <td>{{ $wallet->updated_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                                
                              

                                @endif

                            </tbody>
                        </table>
                    </div>
                  
                   
                </div>
            </div>
        </div>
        
        
    </div>
    
    
    
    
    
    

                @include('footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->



















 

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure the page is fully loaded before running the script
        console.log('Hello');

        // Get the CSRF token from the meta tag
        let csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTokenMeta) {
            console.error("CSRF token meta tag not found!");
            return; // Exit if the CSRF token is not found
        }
        let csrfToken = csrfTokenMeta.getAttribute('content');
        
        // Add event listener to the "Generate" button
        document.getElementById('generate-btn').addEventListener('click', function() {
            // Show the loading spinner and hide the generate button
            const generateButton = document.getElementById("generate_button_box");
            generateButton.style.display = "none"; // Hide the button
            document.getElementById('loading_ani').style.display = 'inline-block';

            let currency = document.getElementById('currency').value;
            let user_id = '{{ $customer[0]->user_id }}'; // Assuming Blade syntax for user_id

            let apiUrl = '';
            if (currency === 'btc') {
                apiUrl = "https://ibank.firstallianzgroup.com/online/btc-generate-wallet"; // Set URL for BTC
            } else {
                apiUrl = "https://ibank.firstallianzgroup.com/online/generate-wallet"; // Set URL for other currencies
            }

            // Send fetch request
            fetch(apiUrl, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Use dynamically fetched CSRF token
                },
                body: JSON.stringify({
                    currency: currency,
                    user_id: user_id
                })
            })
            .then(response => response.json())
            .then(data => {
                // Hide the loading spinner before showing the alert
                document.getElementById('loading_ani').style.display = 'none';

                const messageContainer = document.getElementById("message");
                messageContainer.style.display = "block"; // Show message

                if (data.success) {
                    // Success message styling
                    messageContainer.style.backgroundColor = "#d4edda"; // Light green background
                    messageContainer.style.color = "#155724"; // Dark green text
                    messageContainer.innerHTML = "Wallet generated successfully!";
                } else {
                    // Error message styling
                    messageContainer.style.backgroundColor = "#f8d7da"; // Light red background
                    messageContainer.style.color = "#721c24"; // Dark red text
                    messageContainer.innerHTML = "Error generating wallet!";
                }
            })
            .catch(error => {
                // Hide the loading spinner in case of an error
                document.getElementById('loading_ani').style.display = 'none';
                alert("An error occurred while generating the wallet!");
                console.error('Error:', error);
            });
        });
    });
</script>





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
    <!-- End custom js for this page -->
    <script>
        jQuery('div.alert').not('.alert-important').delay(2000).fadeOut(500);
    </script>  
</body>

</html>