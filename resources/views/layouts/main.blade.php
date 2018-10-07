<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Arta</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('css/alertify.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/alertify.default.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('vendor/bower-components/bootstrap-calendar/css/calendar.css')}}">

      @yield('style')

      <style media="screen">

      .page-header{
        min-height: 40px;
      }
      </style>
  </head>
  <body>
    <div class="page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="{{url('/')}}" class="navbar-brand d-none d-sm-inline-block">
                  <div class="brand-text d-none d-lg-inline-block"><span><strong>Arta</strong> <small>Kesempurnaan Moment Anda</small></span>
                  </div>
                  <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>BD</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                              <li class="nav-item"><a href="#" onClick="logOut()" class="nav-link logout"> <span class="d-none d-sm-inline">Keluar</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="title">
              <h1 class="h4">
                <?php if (strlen(Auth::user()->email) > 10 ){
                  echo strtok(Auth::user()->email, '@');
                }
                else{
                  echo Auth::user()->email;
                }
                ?>
              </h1>
              <p>Administrator</p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus-->
          <span class="heading">MENU</span>
          <ul class="list-unstyled">
                    <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"><i class="fa fa-handshake-o"></i>Transaksi </a>
                      <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                        <li id="pembelian"><a href="{{url('/transaksi-jual-beli')}}">Penjualan Barang </a></li>
                        <li id="transaksi"><a href="{{route('transaksi')}}">Penyewaan Barang </a></li>
                        <li><a href="{{url('/pengembalian')}}">Pengembalian Barang</a></li>
                        <li><a href="{{url('/pelunasan/pembelian')}}">Pelunasan Pembelian</a></li>
                      </ul>
                    </li>
                    <li id="inventaris"><a href="{{route('inventaris')}}"> <i class="fa fa-suitcase"></i>Inventaris </a></li>
                    <li id="log"><a href="{{route('bukuBesar')}}"> <i class="fa fa-book"></i>Log </a></li>
                    <li id="historis"><a href="{{route('historis')}}"> <i class="fa fa-address-book"></i>Historis </a></li>
                    <li id="check"><a href="{{route('cek.inventaris')}}"> <i class="fa fa-clock-o"></i>Cek barang </a></li>
                    <li id="calendars"><a href="{{route('cek.calendar')}}"> <i class="fa fa-calendar"></i>Kalender </a></li>
                    <li id="report"><a href="{{route('report')}}"> <i class="fa fa-file-pdf-o"></i>Report </a></li>
                    <li id="accounts"><a href="{{url('/accounts')}}"> <i class="fa fa-user"></i>Akun </a></li>

          </ul>
        </nav>
        <div class="content-inner">
          @yield('content')

        </div>
      </div>
    </div>

    <form class="logout-form" action="{{url('/logout')}}" method="post">
        {{ csrf_field() }}
    </form>
    <!-- JavaScript files-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.js"></script>
    <!-- Main File-->
    <script src="{{asset('js/front.js')}}"></script>
    <script src="{{asset('js/alertify.min.js')}}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js" charset="utf-8"></script> --}}

    <script type="text/javascript">
      function logOut(){
        $(".logout-form").submit();
      }

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    @yield('script')
  </body>
</html>
