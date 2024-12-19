<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('/dashboard/vendors/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('/dashboard/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('/dashboard/vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  {{-- <link rel="stylesheet" href="{{asset('/dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}"> --}}
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/js/select.dataTables.min.css')}}"> --}}
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('/dashboard/css/vertical-layout-light/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('/dashboard/images/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('/css/style.css')}}" />
  <link rel="stylesheet" href="{{asset('/css/app.css')}}" />

  <link rel="preconnect" href="https://fonts.bunny.net">
  {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> --}}

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Styles -->

  {{-- <link rel="stylesheet" type="text/css" href="https://rern.github.io/sortable/css/sortable.css"> --}}

  <style>
      td{
          vertical-align: middle;
      }
  </style>
          <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
          <script src="{{ asset('/jquery/jquery.js')}}"></script>

</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="/"><img src="{{asset('storage/logo/logo-34.png')}}" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="/"><img src="{{asset('storage/logo/logo-2.png')}}" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text me-3" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control border-none outline-none" style="box-shadow: none" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          {{-- <li class="nav-item">
            <img src="{{asset('storage/user_images/user-logo.png')}}" width="auto" height="30px" alt="">
            <div class="ms-2">{{$user->name}}</div>
          </li> --}}
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <div class="d-flex">
                <img src="{{asset('storage/user_images/user-logo.png')}}" width="auto" height="30px" alt="">
              <div class="ms-2" id="username">{{$user->name}}</div>
              </div>
              {{-- <span class="count"></span> --}}
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              {{-- <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p> --}}
              <a class="dropdown-item preview-item" href="/manager/profile/{{$user->id}}">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-normal">Profile</h6>
                </div>
              </a>
              <a class="dropdown-item preview-item" onclick="naviageUserRegistration()">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="ti-user mx-0"></i>
                  </div>
                </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                  </div>
              </a>
              <a class="dropdown-item preview-item" onclick="handleLogout()">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="ti-settings mx-0"></i>
                  </div>
                </div>
                <form action="{{route('logout')}}" id="logout-form" method="POST">
                <div class="preview-item-content">
                    <input type="submit" class="preview-subject font-weight-normal fs-6 border-0 py-2 bg-transparent ms-2" value="Logout">
                    {{-- <h6 class="preview-subject font-weight-normal"><a href="">Logout</a></h6> --}}
                  </div>
                </form>
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      {{-- <h1 class="text-3xl font-bold underline">
        Hello world!
      </h1> --}}
      {{-- <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div>
        </div>
      </div> --}}
      
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="/manager/dashboard">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#order" aria-expanded="false" aria-controls="order">
              <i class="ti-receipt menu-icon"></i>
              <span class="menu-title">Order</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="order">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/waiter">Order</a></li>
                <li class="nav-item"> <a class="nav-link" href="/kitchen/order">Kitchen Display</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/manager/type">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Order Type</span>
            </a>
          </li>
          <li class="nav-item nav-menu">
            <a class="nav-link" data-toggle="collapse" href="#menus" aria-expanded="false" aria-controls="menus">
              <i class="ti-view-list-alt menu-icon"></i>
              <span class="menu-title">Menu</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menus">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/manager/category">Category</a></li>
                <li class="nav-item"> <a class="nav-link" href="/manager/menu">Menu</a></li>
                <li class="nav-item"> <a class="nav-link" href="/manager/material">Ingredients</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item purchase">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="ti-shopping-cart menu-icon"></i>
              <span class="menu-title">Purchase</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="/manager/purchase">Purchase Lists</a></li>
                <li class="nav-item"><a class="nav-link" href="/manager/purchase/create/menu">Menu Purchase</a></li>
                <li class="nav-item"><a class="nav-link" href="/manager/purchase/create/raw_material">Raw Material Purchase</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#manufacture" aria-expanded="false" aria-controls="manufacture">
              <i class="ti-settings menu-icon"></i>
              <span class="menu-title">Manufacture</span>
              <i class="menu-arrow"></i>
            </a>
            </a>
            <div class="collapse" id="manufacture">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="/manager/manufacture">Manufacture</a></li>
                <li class="nav-item"><a class="nav-link" href="/manager/unmanufacture">Unmanufacture</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/manager/supplier">
              <i class="ti-user menu-icon"></i>
              <span class="menu-title">Supplier</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="/manager/table">
              <i class="icon-grid-2 menu-icon"></i>
              <span class="menu-title">Tables</span>
              {{-- <i class="menu-arrow"></i> --}}
            </a>
            {{-- <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
              </ul>
            </div> --}}
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">User</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/manager/role"> Role </a></li>
                <li class="nav-item"> <a class="nav-link" href="/manager/user"> User </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/manager/profile/{{$user->id}}">
              <i class="icon-head menu-icon"></i>
              <span class="profile">Profile</span>
            </a>
          </li>
          <li class="nav-item report">
            <a class="nav-link" data-toggle="collapse" href="#report" aria-expanded="false" aria-controls="report">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Report</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="report">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="/manager/report/order">Order Report</a></li>
                <li class="nav-item"><a class="nav-link" href="/manager/report/purchase">Purchase Report</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      @yield('dashboard')

      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{asset('/dashboard/vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{asset('/dashboard/vendors/chart.js/Chart.min.js')}}"></script>
  <!-- <script src="{{asset('/dashboard/vendors/datatables.net/jquery.dataTables.js')}}"></script> -->
  <script src="{{asset('/dashboard/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
  <script src="{{asset('/dashboard/js/dataTables.select.min.js')}}"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('/dashboard/js/off-canvas.js')}}"></script>
  <script src="{{asset('/dashboard/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('/dashboard/js/template.js')}}"></script>
  <script src="{{asset('/dashboard/js/settings.js')}}"></script>
  <script src="{{asset('/dashboard/js/todolist.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('/dashboard/js/dashboard.js')}}"></script>
  <script src="{{asset('/dashboard/js/Chart.roundedBarCharts.js')}}"></script>
  <!-- End custom js for this page-->

  <script src="{{ asset('/bootstrap/js/bootstrap.js')}}"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> --}}
  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script> --}}
  <script src="{{asset('/js/menu-filter.js')}}" type="text/javascript"></script>
  <script>
//     $(document).ready(function() 
//     { 
//         $("#myTable").tablesorter(); 
//     } 
// ); 
// $(document).ready(function() 
//     { 
//         $("#myTable").tablesorter( {sortList: [[0,0], [1,0]]} ); 
//     } 
// ); 

function handleLogout() {
    console.log('logout');
    $('#logout-form').submit();
  }

  function naviageUserRegistration() {
    window.location.href = '/manager/user/create';
  }
    
  </script>
  <script>

      function openimage(){
          let uploadimage = document.getElementById('uploadimage');
          let menuimage = document.getElementById('menuimage');

          menuimage.click();
      }

  const input = document.getElementById('menuimage');
  const previewPhoto = (path) => {
  const file = input.files;
  if (file) {
      const fileReader = new FileReader();
      const preview = document.getElementById('uploadimage');
      fileReader.onload = function (event) {
          preview.setAttribute('src', event.target.result);
      }
      if(file[0]){

          fileReader.readAsDataURL(file[0]);
      }
      // else{
      //     preview.setAttribute('src', path);
      // }
  }
  }


  </script>
</body>

</html>

