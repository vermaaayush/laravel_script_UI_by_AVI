<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin</title>

    <!-- plugins:css -->

    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">

    <!-- endinject -->

    <!-- Plugin css for this page -->

    <!-- End plugin css for this page -->

    <!-- inject:css -->

    <!-- endinject -->

    <!-- Layout styles -->

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

  </head>



  <body>





    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->

      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

          <a class="navbar-brand brand-logo" href="{{ asset('dashboard') }}"><img src="{{ asset('images/logo.svg') }}" alt="logo" /></a>

          <a class="navbar-brand brand-logo-mini" href="{{ asset('dashboard') }}"><img src="{{ asset('images/logo-mini.svg') }}" alt="logo" /></a>

        </div>

        <div class="navbar-menu-wrapper d-flex align-items-stretch">

          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">

            <span class="mdi mdi-menu"></span>

          </button>

          <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">

              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">

                <div class="nav-profile-img">

                  <img src="{{ asset('images/faces/face1.jpg') }}" alt="image">

                  <span class="availability-status online"></span>

                </div>

                <div class="nav-profile-text">

                  <p class="mb-1 text-black">{{ Session::get('name') }}</p>

                </div>

              </a>

              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

                <a class="dropdown-item" href="{{ asset('activity-log') }}">

                  <i class="mdi mdi-cached mr-2 text-success"></i> Activity Log </a>

                  <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ asset('system-config') }}">

                  <i class="mdi mdi-settings mr-2 text-primary"></i> System Config </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ asset('logout') }}">

                  <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>

              </div>

            </li>

            <li class="nav-item d-none d-lg-block full-screen-link">

              <a class="nav-link">

                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>

              </a>

            </li>







          </ul>

          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">

            <span class="mdi mdi-menu"></span>

          </button>

        </div>

      </nav>





      <!-- partial -->

      <div class="container-fluid page-body-wrapper">



        <!-- partial:partials/_sidebar.html -->

        <nav class="sidebar sidebar-offcanvas" id="sidebar">



          <ul class="nav">

            <li class="nav-item nav-profile">

              <a href="#" class="nav-link">

                <div class="nav-profile-image">

                  <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile">

                  <span class="login-status online"></span>

                  <!--change to offline or busy as needed-->

                </div>

                <div class="nav-profile-text d-flex flex-column">

                  <span class="font-weight-bold mb-2">{{ Session::get('name') }}</span>

                  <!-- <span class="text-secondary text-small">Account Manager</span> -->

                </div>

                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>

              </a>

            </li> <!-- user profile info -->



            <li class="nav-item">

              <a class="nav-link" href="{{ asset('dashboard') }}">

                <span class="menu-title">Dashboard</span>

                <i class="mdi mdi-home menu-icon"></i>

              </a>

            </li>  <!--Dashboard Tab -->



            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic"  aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">User Management</span>

                <i class="menu-arrow"></i>

                <i class="mdi mdi-account-settings menu-icon"></i>

              </a>

              <div class="collapse" id="ui-basic">

                <ul class="nav flex-column sub-menu">

                  <li class="nav-item"> <a class="nav-link" href="{{ asset('add-customer') }}">Add Customer</a></li>

                  <li class="nav-item"> <a class="nav-link" href="{{ asset('view-customers') }}">View All Customer</a></li>

                </ul>

              </div>

            </li> <!--User Management -->

            <li class="nav-item">
              <a class="nav-link collapsed" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
                    <span class="menu-title">Customer Account(s)</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-folder-account menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic2" style="">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ asset('add-account/' . $customer[0]->id) }}">Add Customer Account</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ asset('view-accounts/' . $customer[0]->id) }}">View Customer Account(s)</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
              <a class="nav-link collapsed" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
                    <span class="menu-title">Card Management</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-credit-card-multiple menu-icon"></i>
                </a>
                <div class="collapse" id="ui-basic3" style="">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ asset('add-card/' . $customer[0]->id) }}">Add Card</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ asset('view-cards/' . $customer[0]->id) }}">All Cards</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">

              <a class="nav-link" href="{{ asset('branches') }}">

                <span class="menu-title">Branches</span>

                <i class="mdi mdi-lan menu-icon"></i>

              </a>

            </li>   <!-- Branches Tab -->


            <li class="nav-item">

              <a class="nav-link" href="{{ asset('logout') }}">

                <span class="menu-title">LogOut</span>

                <i class="mdi mdi-power menu-icon"></i>

              </a>

            </li> <!-- LogOut Tab -->

          </ul>

        </nav>

