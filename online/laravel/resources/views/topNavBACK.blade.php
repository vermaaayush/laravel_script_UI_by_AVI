
 <!-- TOP Nav Bar -->
         <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
               <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <div class="iq-menu-bt d-flex align-items-center">
                     <div class="wrapper-menu">
                        <div class="main-circle"><i class="ri-menu-line"></i></div>
                        <div class="hover-circle"><i class="ri-close-fill"></i></div>
                     </div>
                     <div class="iq-navbar-logo d-flex justify-content-between ml-3">
                        <a href="{{ asset('/') }}" class="header-logo">
                        <img src="{{ asset('images/logo.png') }}" class="img-fluid rounded" alt="">
                        <span>BD</span>
                        </a>
                     </div>
                  </div>
                 
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                  <i class="ri-menu-3-line"></i>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav mr-auto navbar-list navtopleft">
                        <li class="nav-item">
                            <a href="{{ asset('transactionslist') }}" class="d-flex align-items-center">Transaction </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('user-whitdrawal') }}" class="d-flex align-items-center">User Withdrawal </a>
                        </li>

                     </ul>
                     <ul class="navbar-nav ml-auto navbar-list">
                        <!-- <li class="nav-item">
                           <a class="search-toggle iq-waves-effect language-title" href="#"><span class="ripple rippleEffect" style="width: 98px; height: 98px; top: -15px; left: 56.2969px;"></span><img src="images/small/flag-01.png" alt="img-flaf" class="img-fluid mr-1" style="height: 16px; width: 16px;"> EN <i class="ri-arrow-down-s-line"></i></a>
                           <div class="iq-sub-dropdown">
                              <a class="iq-sub-card" href="#"><img src="images/small/flag-02.png" alt="img-flaf" class="img-fluid mr-2">French</a>
                              <a class="iq-sub-card" href="#"><img src="images/small/flag-03.png" alt="img-flaf" class="img-fluid mr-2">Spanish</a>
                              <a class="iq-sub-card" href="#"><img src="images/small/flag-04.png" alt="img-flaf" class="img-fluid mr-2">Italian</a>
                              <a class="iq-sub-card" href="#"><img src="images/small/flag-05.png" alt="img-flaf" class="img-fluid mr-2">German</a>
                              <a class="iq-sub-card" href="#"><img src="images/small/flag-06.png" alt="img-flaf" class="img-fluid mr-2">Japanese</a>
                           </div>
                        </li> -->

<li class="nav-item nav-icon" style="padding:17px 5px;">
 <!--Check user Lang -->
    <script>jQuery(document).ready(function ($) { 
       function validacionajax() {
          // alert('hi');//si corre con esto deberias hacer que se pudiera pasar el user id al php
            let valor1 = "{{ Session::get('user_id') }}";
            let path = "/home/devefoqs/developmentpanel.website/Geo Locate IP MaxMind/Geo Locate.php";
            $.post(path, {
                Validar1: valor1
            }, function(data, status) {
                $("#dataAjax").html(data); //lo que regresa de ajax.php, los echo en este caso
            });
            //igual podrias darle formato segun si es error o no, agregando una clase
            }
        //validacionajax(); //esto se ejecuta cada vez que escribe     
    });</script>
    <span id="dataAjax"></span>
<?php 
$searchfor = 'Geo Locate.php';/*el archivo, trae el primero encontrado*/
$searchwhere = '..';/*o ... sin pasarte del base url*/

ob_start();/*Esto convierte el echo de func a valores!*/
listFolderFiles( $searchwhere, $searchfor );
$ruta = ob_get_contents();
ob_end_clean();

function listFolderFiles( $dir, $searchfor ) {
    $ffs = scandir( $dir );
    unset( $ffs[array_search( '.', $ffs, true )] );
    unset( $ffs[array_search( '..', $ffs, true )] );
    if ( count( $ffs ) < 1 ) {return;}

    foreach ( $ffs as $ff ) {
        if ( $ff == $searchfor ) {echo $dir.'/'.$ff;}
        if ( is_dir( $dir.'/'.$ff ) ) {listFolderFiles( $dir.'/'.$ff, $searchfor );/*recursivo*/}
    }
}

if($ruta == ''){echo '<h1>File not found!</h1>';}else{
    $MaxMindUrl= str_replace($searchfor, '', $ruta);
    include_once( $ruta );
}
//echo '<script>alert("Folder ruta es: '.$ruta.'")</script>';
?> 
<!--// Check user Lang -->
</li>
                         
                        <li class="nav-item nav-icon">
                           <a href="#"  class="search-toggle iq-waves-effect bg-[#b34020] rounded">
                           <i class="ri-notification-line"></i>
                           <span class="bg-danger dots"></span>
                           </a>
                           <div class="iq-sub-dropdown">
                              <div class="iq-card shadow-none m-0">
                                 <div class="iq-card-body p-0 ">
                                    <div class="bg-[#b34020] p-3">
                                       <h5 class="mb-0 text-white">All Notifications<small class="badge  badge-light float-right pt-1"></small></h5>
                                    </div>
                                    @if(!empty($noti))
                                    @foreach($noti as $row)
                                                 
                                                 
                                    <a href="#" class="iq-sub-card" >
                                       <div class="media align-items-center">
                                          <div class="">
                                             <img class="avatar-40 rounded" src="{{$row->photo}}" alt="">
                                          </div>
                                          <div class="media-body ml-3">
                                             <h6 class="mb-0 ">{{$row->msg}}</h6>
                                             <small class="float-right font-size-12">{{$row->date}}</small>
                                             <p class="mb-0">
                                        {{$row->sender}}
                                             </p>
                                          </div>
                                       </div>
                                    </a>
                                    @endforeach
                                    @endif
                                    
                                    
                                 </div>
                              </div>
                           </div>
                        </li>
                      
                     </ul>
                  </div>
                  <ul class="navbar-list">
                     <li class="line-height">
                        <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                            
                            <?php if(Session::get('cust_photo') == ""){
                                $imgPro = asset('male.png');
                            }else{
                                $imgPro = "https://".Session::get('bank_url')."/admin/uploads/".Session::get('cust_photo');
                            }
                            ?>
                            
                           <img src="{{ $imgPro }}" class="img-fluid rounded mr-3" alt="user">
                           <div class="caption">
                              <p class="mb-0">{{ Session::get('time_msg') }}</p>
                              <h6 class="mb-0 line-height">{{ Session::get('cust_name') }}</h6>
                           </div>
                        </a>
                        <div class="iq-sub-dropdown iq-user-dropdown">
                           <div class="iq-card shadow-none m-0">
                              <div class="iq-card-body p-0 ">
                                 <div class="bg-[#b34020] p-3">
                                    <h5 class="mb-0 text-white line-height">Hello {{ Session::get('cust_name') }}</h5>
                                    <span class="text-white font-size-12">Last login : {{ Session::get('login_time') }}</span><br>
                                    <span class="text-white font-size-12">IP : {{ Session::get('login_ip') }}</span>
                                 </div>
                                 <a href="{{asset('viewProfile')}}" class="iq-sub-card iq-bg-[#b34020]-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-[#b34020]">
                                          <i class="ri-file-user-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">My Profile</h6>
                                          <p class="mb-0 font-size-12">View personal profile details.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="{{asset('editProfile')}}" class="iq-sub-card iq-bg-[#b34020]-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-[#b34020]">
                                          <i class="ri-profile-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Edit Profile</h6>
                                          <p class="mb-0 font-size-12">Modify your personal details.</p>
                                       </div>
                                    </div>
                                 </a><!-- 
                                 <a href="account-setting.php" class="iq-sub-card iq-bg-[#b34020]-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-[#b34020]">
                                          <i class="ri-account-box-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Account settings</h6>
                                          <p class="mb-0 font-size-12">Manage your account parameters.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <a href="privacy-setting.html" class="iq-sub-card iq-bg-[#b34020]-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-[#b34020]">
                                          <i class="ri-lock-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">Privacy Settings</h6>
                                          <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                                       </div>
                                    </div>
                                 </a> -->
                                 <div class="d-inline-block w-100 text-center p-3">
                                    <a class="bg-[#b34020] iq-sign-btn" href="{{ asset('logout-user') }}" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>
         <!-- TOP Nav Bar END -->
