<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta id="token" token={{ csrf_token() }}>
    <meta id="home-url" value="{{route('admin.admin')}}">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="{{route('home')}}/admin/css/font-face.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{route('home')}}/admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{route('home')}}/admin/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="{{route('home')}}/admin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="{{route('home')}}/admin/vendor/datatable/datatable.css">

    <!-- Main CSS-->
    <link href="{{route('home')}}/admin/css/theme.css" rel="stylesheet" media="all">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


</head>

<body>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                            <a href="{{route('admin.admin')}}" class="logo">
                                    <img src="{{route('home')}}/asset/images/icons/logo-01.png" alt="IMG-LOGO">
                                </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li>
                            <a href="{{route('admin.admin')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{route('admin.product')}}"><i class="fas fa-box"></i>Sản phẩm</a>
                        </li>
                        <li>
                            <a href="{{route('admin.order')}}"><i class="fas fa-dolly"></i>Đơn hàng</a>
                        </li>
                        <li>
                            <a href="{{route('admin.voucher')}}"><i class="fas fa-tag"></i>Voucher</a>
                        </li>
                        <li>
                            <a href="{{route('admin.customer')}}">
                                    <i class="fas fa-users"></i>Khách hàng</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                    <a href="{{route('home')}}" class="logo">
                            <img src="{{route('home')}}/asset/images/icons/logo-01.png" alt="IMG-LOGO">
                        </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a href="{{route('admin.admin')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{route('admin.product')}}"><i class="fas fa-box"></i>Sản phẩm</a>
                        </li>
                        <li>
                            <a href="{{route('admin.order')}}"><i class="fas fa-dolly"></i>Đơn hàng</a>
                        </li>
                        <li>
                            <a href="{{route('admin.voucher')}}"><i class="fas fa-tag"></i>Voucher</a>
                        </li>
                        <li>
                            <a href="{{route('admin.customer')}}">
                                    <i class="fas fa-users"></i>Khách hàng</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" >
                            </form>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">

                                        <div class="content">
                                            <a class="js-acc-btn" href="#">{{Auth::user()->Customer()->get()->first()->CustomerName}}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                    <div class="image">
                                                            <a href="#">
                                                                <img src="{{route('home')}}/asset/images/avatar-06.jpg" alt="John Doe" />
                                                            </a>
                                                        </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">{{Auth::user()->Customer()->get()->first()->CustomerName}}</a>
                                                    </h5>
                                                    <span class="email">{{Auth::user()->email}}</span>
                                                </div>
                                            </div>
                                            {{-- <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                </div>
                                            </div> --}}
                                            <div class="account-dropdown__footer">
                                                        <a class="nav-link" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                        document.getElementById('logout-form').submit();">
                                                            <i class="zmdi zmdi-power"></i>Đăng xuất</a>

                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            @section('content')
            @show

            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

<!-- Jquery JS-->
    <script src="{{route('home')}}/admin/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="{{route('home')}}/admin/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="{{route('home')}}/admin/vendor/slick/slick.min.js">
    </script>
    <script src="{{route('home')}}/admin/vendor/wow/wow.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/animsition/animsition.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="{{route('home')}}/admin/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="{{route('home')}}/admin/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{route('home')}}/admin/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/select2/select2.min.js">
    </script>
    <script src="{{route('home')}}/admin/vendor/datatable/datatable.js" type="text/javascript" charset="utf8"></script>

    <!-- Main JS-->
    <script src="{{route('home')}}/admin/js/main.js"></script>

    <script>
        $.fn.dataTable.ext.order['dom-select'] = function  ( settings, col ){
            return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                return $('select', td).val();
            } );
        }
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var fillter =$('#category-fillter').val();
                var category = data[2]; // use data for the category column

                if(fillter === 'all' || fillter == null) return true;
                else if ( fillter === category )
                {
                    return true;
                }
                return false;
            }
        );

    </script>

</body>

</html>
