 <!-- Header -->
@include('header')
 <!-- // Header -->

 <!-- Sidebar -->
@include('sidebar')
 <!-- //  Sidebar -->

 <!-- top navbar -->
@include('topNav')
 <!-- // top navbar -->


<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-lg">
        <div class="flex items-center gap-sm text-on-surface-variant text-body-md font-body-md mb-xs">
            <a class="hover:text-primary transition-colors" href="#">Customer Feedback</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-on-surface font-medium">View Messages</span>
        </div>
        <h2 class="text-display-lg font-display-lg text-on-surface mb-xs">Message Center</h2>
        <p class="text-body-lg font-body-lg text-on-surface-variant">View your inbox, sent messages, and manage communications.</p>
        
        @include('flash::message')
    </div>

    <style>
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }
    </style>
    
    <div class="flex flex-col lg:flex-row gap-lg relative">
        <!-- Sidebar Navigation -->
        <div class="w-full lg:w-1/4">
            <div class="bg-surface rounded-xl shadow-level-1 border border-outline-variant/20 overflow-hidden">
                <div class="p-lg">
                    <div class="iq-email-list">
                        <!-- Navigation Tabs -->
                        <ul class="nav flex-column nav-pills flex flex-col gap-2 list-none p-0 m-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active flex items-center gap-3 px-4 py-3 rounded-lg text-body-md font-medium text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors cursor-pointer" role="tab" data-toggle="pill" href="#mail-inbox">
                                    <span class="material-symbols-outlined text-[20px]">inbox</span>
                                    Inbox
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-body-md font-medium text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors cursor-pointer" role="tab" data-toggle="pill" href="#mail-sent">
                                    <span class="material-symbols-outlined text-[20px]">send</span>
                                    Sent Mail
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg text-body-md font-medium text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors cursor-pointer" role="tab" data-toggle="pill" href="#mail-trash">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                    Trash
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <!-- Main Content Area -->
        <div class="w-full lg:w-3/4 mail-box-detail">
            <div class="bg-surface rounded-xl shadow-level-1 border border-outline-variant/20 overflow-hidden min-h-[500px]">
                     <div class="p-0">
                        <div class="">
                           <div class="iq-email-to-list p-3">
                              <div class="d-flex justify-content-between">
                                <!--  <ul>
                                    <li>
                                       <a href="#" id="navbarDropdown" data-toggle="dropdown">
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" id="customCheck1">
                                             <label class="block text-sm font-semibold text-on-surface-variant mb-2"><i class="ri-arrow-down-s-line"></i></label>
                                          </div>
                                       </a>
                                       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                       </div>
                                    </li>
                                    <li data-toggle="tooltip" data-placement="top" title="Reload"><a href="#"><i class="ri-restart-line"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Archive"><a href="#"><i class="ri-mail-open-line"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Delete"><a href="#"><i class="ri-delete-bin-line"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Inbox"><a href="#"><i class="ri-mail-unread-line"></i></a></li>
                                    <li data-toggle="tooltip" data-placement="top" title="Zoom"><a href="#"><i class="ri-drag-move-2-line"></i></a></li>
                                 </ul> -->
                                 <!-- <div class="iq-email-search d-flex">
                                    <form class="mr-3 position-relative">
                                       <div class="form-group mb-0">
                                          <input type="email" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Search">
                                          <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                       </div>
                                    </form>
                                    <ul>
                                       <li class="mr-3">
                                          <a class="font-size-14" href="#" id="navbarDropdown" data-toggle="dropdown">
                                          1 - 50 of 505
                                          </a>
                                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                             <a class="dropdown-item" href="#">20 per page</a>
                                             <a class="dropdown-item" href="#">50 per page</a>
                                             <a class="dropdown-item" href="#">100 per page</a>
                                          </div>
                                       </li>
                                       <li data-toggle="tooltip" data-placement="top" title="Previous"><a href="#"><i class="ri-arrow-left-s-line"></i></a></li>
                                       <li data-toggle="tooltip" data-placement="top" title="Next"><a href="#"><i class="ri-arrow-right-s-line"></i></a></li>
                                    </ul>
                                 </div> -->
                              </div>
                           </div>
                           <div class="iq-email-listbox">
                              <div class="tab-content">
                                 <div class="tab-pane fade show active" id="mail-inbox" role="tabpanel">
                                    <ul class="iq-email-sender-list">
                                       @forelse($inbox as $row)
                                       <li class="iq-unread">
                                          <div class="d-flex align-self-center">
                                             <div class="iq-email-sender-info">
                                                <div class="iq-checkbox-mail">
                                                   <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input" id="mailk">
                                                      <label class="block text-sm font-semibold text-on-surface-variant mb-2"></label>
                                                   </div>
                                                </div>
                                                <!-- <span class="ri-star-line iq-star-toggle text-warning"></span> -->
                                                <a href="javascript: void(0);" class="iq-email-title">From: Bank Support</a>
                                             </div>
                                             <div class="iq-email-content">
                                                <a href="javascript: void(0);" class="iq-email-subject">{{ $row->subject }}</a>
                                                <div class="iq-email-date"><?php echo date("d, F, Y", strtotime($row->date)); ?></div>
                                             </div>
                                             <ul class="iq-social-media">
                                                <li data-toggle="tooltip" data-placement="top" title="Delete"><a href="{{ asset('delete-msg/' . $row->id) }}" ><i class="ri-delete-bin-2-line"></i></a></li>
                                                <li data-toggle="tooltip" data-placement="top" title="Reply"><a href="#"><i class="ri-restart-line" data-target="#compose-email-popup" data-toggle="modal"></i></a></li>
                                                <li data-toggle="tooltip" data-placement="top" title="View"><a href="#"><i class="ri-file-list-2-line"></i></a></li>
                                             </ul>
                                          </div>
                                       </li>
                                       <div class="email-app-details">
                                          <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
                                             <div class="iq-card-body p-0">
                                                <div class="">
                                                   <div class="iq-email-to-list p-3">
                                                      <div class="d-flex justify-content-between">
                                                         <ul>
                                                            <li class="mr-3">
                                                               <a href="javascript: void(0);">
                                                                  <h4 class="m-0"><i class="ri-arrow-left-line"></i></h4>
                                                               </a>
                                                            </li><li data-toggle="tooltip" data-placement="top" title="Reply"><a href="#"><i class="ri-restart-line" data-target="#compose-email-popup" data-toggle="modal"></i></a></li>
                                                            <li data-toggle="tooltip" data-placement="top" title="Delete"><a href="{{ asset('delete-msg/' . $row->id) }}"><i class="ri-delete-bin-line"></i></a></li>
                                                         </ul>
                                                         <div class="iq-email-search d-flex">
                                                            <!-- <ul>
                                                               <li class="mr-3">
                                                                  <a class="font-size-14" href="#">1 of 505</a>
                                                               </li>
                                                               <li data-toggle="tooltip" data-placement="top" title="Previous"><a href="#"><i class="ri-arrow-left-s-line"></i></a></li>
                                                               <li data-toggle="tooltip" data-placement="top" title="Next"><a href="#"><i class="ri-arrow-right-s-line"></i></a></li>
                                                            </ul> -->
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <hr class="mt-0">
                                                   <div class="iq-inbox-subject p-3">
                                                      <h5 class="mt-0">{{ $row->subject }}</h5>
                                                      <div class="iq-inbox-subject-info">
                                                         <div class="iq-subject-info">
                                                            <img src="https://{{ Session::get('bank_url') }}/admin/uploads/{{ Session::get('cust_photo') }}"  class="img-fluid rounded" alt="#">
                                                            <div class="iq-subject-status align-self-center">
                                                               <h6 class="mb-0">{{ $row->sender }}</h6>
                                                               <div class="dropdown">
                                                                  <a class="dropdown-toggle" href="#"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                  to {{ $row->receiver }}
                                                                  </a>
                                                                  <div class="dropdown-menu font-size-12" aria-labelledby="dropdownMenuButton">
                                                                     <table class="w-full text-left border-collapse">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">from:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->sender }}</td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">reply-to:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->sender }}</td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">to:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->receiver }}</td>
                                                                           </tr>
                                                                           @if($row->cc != '')
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">cc:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->cc }}</td>
                                                                           </tr>
                                                                           @endif
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">date:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"><?php echo date("d, F, Y", strtotime($row->date)); ?></td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">subject:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->subject }}</td>
                                                                           </tr>
                                                                           <!-- <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">security:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">Standard encryption</td>
                                                                           </tr> -->
                                                                        </tbody>
                                                                     </table>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <span class="float-right align-self-center"><?php echo date("d, F, Y", strtotime($row->date)); ?></span>
                                                         </div>
                                                         <div class="iq-inbox-body mt-5">
                                                            <p>{{ $row->msg }}</p>
                                                         </div>
                                                         <hr>
                                                         @if($row->file != '')
                                                         <div class="attegement">
                                                            <h6 class="mb-2">ATTACHED FILES:</h6>
                                                            <?php
                                                            $file_arr = explode(",", $row->file);
                                                            ?>
                                                            <ul>
                                                               @foreach($file_arr as $file)
                                                               <li class="icon icon-attegment">
                                                                  <a href="uploads/{{ $file }}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="ml-1">{{ $file }}</span></a>
                                                               </li>
                                                               @endforeach
                                                            </ul>
                                                         </div>
                                                         @endif
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       @empty
                                          <div class="flex flex-col items-center justify-center p-12 text-on-surface-variant h-full w-full absolute inset-0">
                                              <span class="material-symbols-outlined text-[64px] mb-4 opacity-50">inbox</span>
                                              <h3 class="text-title-lg font-title-lg text-on-surface mb-2">Your inbox is empty</h3>
                                              <p class="text-body-md font-body-md text-center">You don't have any messages yet.</p>
                                          </div>
                                       @endforelse
                                    </ul>
                                 </div>
                                 <div class="tab-pane fade" id="mail-sent" role="tabpanel">
                                    <ul class="iq-email-sender-list">
                                       @forelse($sent as $row)
                                       <li>
                                          <div class="d-flex align-self-center">
                                             <div class="iq-email-sender-info">
                                                <div class="iq-checkbox-mail">
                                                   <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input" id="mailk11">
                                                      <label class="block text-sm font-semibold text-on-surface-variant mb-2"></label>
                                                   </div>
                                                </div>
                                                <!-- <span class="ri-star-line iq-star-toggle"></span> -->
                                                <a href="javascript: void(0);" class="iq-email-title">To: {{ $row->receiver }}</a>
                                             </div>
                                             <div class="iq-email-content">
                                                <a href="javascript: void(0);" class="iq-email-subject">{{ $row->subject }}
                                                </a>
                                                <div class="iq-email-date"><?php echo date("d, F, Y", strtotime($row->date)); ?></div>
                                             </div>
                                             <ul class="iq-social-media">
                                                <li data-toggle="tooltip" data-placement="top" title="Delete"><a href="{{ asset('delete-msg/' . $row->id) }}" ><i class="ri-delete-bin-2-line"></i></a></li>
                                                <li data-toggle="tooltip" data-placement="top" title="Reply"><a href="#"><i class="ri-restart-line" data-target="#compose-email-popup" data-toggle="modal"></i></a></li>
                                                <li data-toggle="tooltip" data-placement="top" title="View"><a href="#"><i class="ri-file-list-2-line"></i></a></li>
                                             </ul>
                                          </div>
                                       </li>
                                       <div class="email-app-details">
                                          <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
                                             <div class="iq-card-body p-0">
                                                <div class="">
                                                   <div class="iq-email-to-list p-3">
                                                      <div class="d-flex justify-content-between">
                                                         <ul>
                                                            <li class="mr-3">
                                                               <a href="javascript: void(0);">
                                                                  <h4 class="m-0"><i class="ri-arrow-left-line"></i></h4>
                                                               </a>
                                                            </li><li data-toggle="tooltip" data-placement="top" title="Reply"><a href="#"><i class="ri-restart-line" data-target="#compose-email-popup" data-toggle="modal"></i></a></li>
                                                            <li data-toggle="tooltip" data-placement="top" title="Delete"><a href="{{ asset('delete-msg/' . $row->id) }}"><i class="ri-delete-bin-line"></i></a></li>
                                                         </ul>
                                                         <div class="iq-email-search d-flex">
                                                            <!-- <ul>
                                                               <li class="mr-3">
                                                                  <a class="font-size-14" href="#">1 of 505</a>
                                                               </li>
                                                               <li data-toggle="tooltip" data-placement="top" title="Previous"><a href="#"><i class="ri-arrow-left-s-line"></i></a></li>
                                                               <li data-toggle="tooltip" data-placement="top" title="Next"><a href="#"><i class="ri-arrow-right-s-line"></i></a></li>
                                                            </ul> -->
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <hr class="mt-0">
                                                   <div class="iq-inbox-subject p-3">
                                                      <h5 class="mt-0">{{ $row->subject }}</h5>
                                                      <div class="iq-inbox-subject-info">
                                                         <div class="iq-subject-info">
                                                            <img src="https://{{ Session::get('bank_url') }}/admin/uploads/{{ Session::get('cust_photo') }}" class="img-fluid rounded" alt="#">
                                                            <div class="iq-subject-status align-self-center">
                                                               <h6 class="mb-0">{{ $row->sender }}</h6>
                                                               <div class="dropdown">
                                                                  <a class="dropdown-toggle" href="#"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                  to {{ $row->receiver_name }}
                                                                  </a>
                                                                  <div class="dropdown-menu font-size-12" aria-labelledby="dropdownMenuButton">
                                                                     <table class="w-full text-left border-collapse">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">from:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->sender }}</td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">reply-to:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->sender }}</td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">to:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->receiver }}</td>
                                                                           </tr>
                                                                           @if($row->cc != '')
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">cc:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->cc }}</td>
                                                                           </tr>
                                                                           @endif
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">date:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"><?php echo date("d, F, Y", strtotime($row->date)); ?></td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">subject:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->subject }}</td>
                                                                           </tr>
                                                                           <!-- <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">security:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">Standard encryption</td>
                                                                           </tr> -->
                                                                        </tbody>
                                                                     </table>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <span class="float-right align-self-center"><?php echo date("d, F, Y", strtotime($row->date)); ?></span>
                                                         </div>
                                                         <div class="iq-inbox-body mt-5">
                                                            <p>{{ $row->msg }}</p>
                                                         </div>
                                                         <hr>
                                                         @if($row->file != '')
                                                         <div class="attegement">
                                                            <h6 class="mb-2">ATTACHED FILES:</h6>
                                                            <?php
                                                            $file_arr = explode(",", $row->file);
                                                            ?>
                                                            <ul>
                                                               @foreach($file_arr as $file)
                                                               <li class="icon icon-attegment">
                                                                  <a href="uploads/{{ $file }}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="ml-1">{{ $file }}</span></a>
                                                               </li>
                                                               @endforeach
                                                            </ul>
                                                         </div>
                                                         @endif
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       @empty
                                          <div class="flex flex-col items-center justify-center p-12 text-on-surface-variant h-full w-full absolute inset-0">
                                              <span class="material-symbols-outlined text-[64px] mb-4 opacity-50">send</span>
                                              <h3 class="text-title-lg font-title-lg text-on-surface mb-2">No sent messages</h3>
                                              <p class="text-body-md font-body-md text-center">You haven't sent any messages yet.</p>
                                          </div>
                                       @endforelse
                                    </ul>
                                 </div>
                                 <div class="tab-pane fade" id="mail-trash" role="tabpanel">
                                    <ul class="iq-email-sender-list">
                                       @forelse($trash as $row)
                                       <li>
                                          <div class="d-flex align-self-center">
                                             <div class="iq-email-sender-info">
                                                <div class="iq-checkbox-mail">
                                                   <div class="custom-control custom-checkbox">
                                                      <input type="checkbox" class="custom-control-input" id="mailk14">
                                                      <label class="block text-sm font-semibold text-on-surface-variant mb-2"></label>
                                                   </div>
                                                </div>
                                                <!-- <span class="ri-star-line iq-star-toggle"></span> -->
                                                <a href="javascript: void(0);" class="iq-email-title">To: {{ $row->receiver }}</a>
                                             </div>
                                             <div class="iq-email-content">
                                                <a href="javascript: void(0);" class="iq-email-subject">{{ $row->subject }}</a>
                                                <div class="iq-email-date"><?php echo date("d, F, Y", strtotime($row->date)); ?></div>
                                             </div>
                                             <ul class="iq-social-media">
                                                <!-- <li data-toggle="tooltip" data-placement="top" title="Delete"><a href="#" ><i class="ri-delete-bin-2-line"></i></a></li> -->
                                                <li data-toggle="tooltip" data-placement="top" title="Undelete"><a href="{{ asset('undelete-msg/' . $row->id) }}"><i class="ri-restart-line"></i></a></li>
                                                <!-- <li data-toggle="tooltip" data-placement="top" title="View"><a href="#"><i class="ri-file-list-2-line"></i></a></li> -->
                                             </ul>
                                          </div>
                                       </li>
                                       <div class="email-app-details">
                                          <div class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden">
                                             <div class="iq-card-body p-0">
                                                <div class="">
                                                   <div class="iq-email-to-list p-3">
                                                      <div class="d-flex justify-content-between">
                                                         <ul>
                                                            <li class="mr-3">
                                                               <a href="javascript: void(0);">
                                                                  <h4 class="m-0"><i class="ri-arrow-left-line"></i></h4>
                                                               </a>
                                                            </li><li data-toggle="tooltip" data-placement="top" title="Undelete"><a href="{{ asset('undelete-msg/' . $row->id) }}"><i class="ri-restart-line"></i></a></li>
                                                            <!-- <li data-toggle="tooltip" data-placement="top" title="Delete"><a href="#"><i class="ri-delete-bin-line"></i></a></li> -->
                                                         </ul>
                                                         <div class="iq-email-search d-flex">
                                                            <!-- <ul>
                                                               <li class="mr-3">
                                                                  <a class="font-size-14" href="#">1 of 505</a>
                                                               </li>
                                                               <li data-toggle="tooltip" data-placement="top" title="Previous"><a href="#"><i class="ri-arrow-left-s-line"></i></a></li>
                                                               <li data-toggle="tooltip" data-placement="top" title="Next"><a href="#"><i class="ri-arrow-right-s-line"></i></a></li>
                                                            </ul> -->
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <hr class="mt-0">
                                                   <div class="iq-inbox-subject p-3">
                                                      <h5 class="mt-0">{{ $row->subject }}</h5>
                                                      <div class="iq-inbox-subject-info">
                                                         <div class="iq-subject-info">
                                                            <img src="https://{{ Session::get('bank_url') }}/admin/uploads/{{ Session::get('cust_photo') }}"  class="img-fluid rounded" alt="#">
                                                            <div class="iq-subject-status align-self-center">
                                                               <h6 class="mb-0">{{ $row->sender }}</h6>
                                                               <div class="dropdown">
                                                                  <a class="dropdown-toggle" href="#"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                  to {{ $row->receiver }}
                                                                  </a>
                                                                  <div class="dropdown-menu font-size-12" aria-labelledby="dropdownMenuButton">
                                                                     <table class="w-full text-left border-collapse">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">from:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->sender }}</td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">reply-to:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->sender }}</td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">to:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->receiver }}</td>
                                                                           </tr>
                                                                           @if($row->cc != '')
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">cc:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->cc }}</td>
                                                                           </tr>
                                                                           @endif
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">date:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface"><?php echo date("d, F, Y", strtotime($row->date)); ?></td>
                                                                           </tr>
                                                                           <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">subject:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">{{ $row->subject }}</td>
                                                                           </tr>
                                                                           <!-- <tr>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">security:</td>
                                                                              <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">Standard encryption</td>
                                                                           </tr> -->
                                                                        </tbody>
                                                                     </table>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <span class="float-right align-self-center"><?php echo date("d, F, Y", strtotime($row->date)); ?></span>
                                                         </div>
                                                         <div class="iq-inbox-body mt-5">
                                                            <p>{{ $row->msg }}</p>
                                                         </div>
                                                         <hr>
                                                         @if($row->file != '')
                                                         <div class="attegement">
                                                            <h6 class="mb-2">ATTACHED FILES:</h6>
                                                            <?php
                                                            $file_arr = explode(",", $row->file);
                                                            ?>
                                                            <ul>
                                                               @foreach($file_arr as $file)
                                                               <li class="icon icon-attegment">
                                                                  <a href="uploads/{{ $file }}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="ml-1">{{ $file }}</span></a>
                                                               </li>
                                                               @endforeach
                                                            </ul>
                                                         </div>
                                                         @endif
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       @empty
                                          <div class="flex flex-col items-center justify-center p-12 text-on-surface-variant h-full w-full absolute inset-0">
                                              <span class="material-symbols-outlined text-[64px] mb-4 opacity-50">delete</span>
                                              <h3 class="text-title-lg font-title-lg text-on-surface mb-2">Trash is empty</h3>
                                              <p class="text-body-md font-body-md text-center">There are no deleted messages.</p>
                                          </div>
                                       @endforelse
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
             </div>
        </div>
    </div>
</div>
<!-- end content -->

<!-- footer -->
@include('footer')
<!-- // footer -->
