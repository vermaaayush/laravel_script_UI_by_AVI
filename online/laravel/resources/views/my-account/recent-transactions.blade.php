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
<div>
   <div class="max-w-7xl mx-auto w-full">
      <div class="flex flex-wrap -mx-3">
         <div class="w-full px-3">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb bg-[#b34020] mb-0">
                  <li class="breadcrumb-item"><a href="#" class="text-white"><i class="ri-home-4-line mr-1 float-left"></i>You Are Here : </a></li>
                  <li class="breadcrumb-item"><a href="#" class="text-white">Account</a></li>
                  <li class="breadcrumb-item active text-white" aria-current="page">Account Summary</li>
               </ol>
            </nav>
            <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
               <div class="p-lg border-b border-outline-variant/30 flex justify-between items-center">
                  <div class="mb-2">
                     <h4 class="text-headline-sm font-headline-sm text-on-surface font-semibold">Account Details</h4>
                  </div>
               </div>
               <div class="p-lg">
                   <div class="table-responsive">
                        <table class="w-full text-left border-collapse">
                              <tbody>
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Account No. </th>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">0000000000000000</td>
                                 </tr>
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Name</th>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">Mr. X</td>
                                 </tr>
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Available Balance</th>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">32,000</td>
                                 </tr>
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Currency</th>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">Dollor</td>
                                 </tr>

                              </tbody>
                           </table>
                     </div>
               </div>
            </div>
            <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
               <div class="p-lg border-b border-outline-variant/30 flex justify-between items-center">
                  <div class="mb-2">
                     <h4 class="text-headline-sm font-headline-sm text-on-surface font-semibold">Last 10 Transaction</h4>
                  </div>
               </div>
               <div class="p-lg">
                   <div class="table-responsive">
                        <table class="w-full text-left border-collapse">
                              <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap"ead class="bg-surface-container-low text-on-surface-variant font-semibold">
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Date</th>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Narration</th>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Ref/Cheque No. </th>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Debit</th>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Credit</th>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Balance</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" >25-Jun-2020</th>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">BY TRANSFER<br/>NEFT*MAHB000000*AccountHolder</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">MAA0004911</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"> - -</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">12,000</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">32,000</td>
                                 </tr>
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" >17-Jun-2020</th>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">BY TRANSFER<br/>NEFT*MAHB000000*AccountHolder</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">MAA0004911</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"> - -</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">15,000</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">20,000</td>
                                 </tr>
                                 <tr>
                                    <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" >01-Jun-2020</th>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">BY TRANSFER<br/>NEFT*MAHB000000*AccountHolder</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"> - -</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">3000</td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"> - - </td>
                                    <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">5,000</td>
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
