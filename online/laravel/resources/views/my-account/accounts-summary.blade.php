 <!-- Header -->
@include('layouts.header')
 <!-- // Header -->

 <!-- Sidebar -->
@include('layouts.sidebar')
 <!-- //  Sidebar -->

 <!-- top navbar -->
@include('layouts.topNav')
 <!-- // top navbar -->


<!-- Page Content  -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb bg-[#b34020] mb-0">
                  <li class="breadcrumb-item"><a href="#" class="text-white"><i class="ri-home-4-line mr-1 float-left"></i>You Are Here : </a></li>
                  <li class="breadcrumb-item"><a href="#" class="text-white">Account</a></li>
                  <li class="breadcrumb-item active text-white" aria-current="page">Account Summary</li>
               </ol>
            </nav>
            <div class="iq-card">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Account Summary</h4>
                  </div>
               </div>
               <div class="iq-card-body">
<!--
                  <div class="alert text-white bg-warning" role="alert">
                     <div class="iq-alert-icon">
                        <i class="las la-exchange-alt iq-arrow-left"></i>
                     </div>
                     <div class="iq-alert-text">Transaction Accounts</div>
                  </div>
 -->
                   <div class="table-responsive">
                        <table class="table table-striped">
                              <thead>
                                 <tr>
                                    <th scope="col">Account No. / Name</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Available Balance</th>
                                    <th scope="col">Transaction</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <th >0000000000000000</th>
                                    <td>Moscow</td>
                                    <td>$22000</td>
                                    <td><a href="{{ url('recent-transactions') }}" class="text-link">Click Here for last 10 Transaction</a></td>
                                 </tr>
                              </tbody>
                           </table>
                     </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- // Page Content -->

<!-- footer -->
@include('layouts.footer')
<!-- // footer -->
