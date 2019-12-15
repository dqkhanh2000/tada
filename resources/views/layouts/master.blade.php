<!DOCTYPE html>
<html lang="en">
<head>
    <meta id="home-url" value="{{route('home')}}">
    <title>@yield('title')</title>
    <meta id="token" token={{ csrf_token() }}>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="{{url()->route('home')}}/asset/images/icons/favicon.png"/>
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/animate/animate.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/slick/slick.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/vendor/perfect-scrollbar/perfect-scrollbar.css">

        <script>
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            }
        </script>
    <!--===============================================================================================-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/css/util.css">
        <link rel="stylesheet" type="text/css" href="{{url()->route('home')}}/asset/css/main.css">
    <script>
            var idCustomer = @guest
                            {{"null"}}
                         @else
                         {{ Session::get('idCustomer')}}
                         @endguest
    </script>
    <!--===============================================================================================-->
</head>

{{-- get user  --}}
@auth
    @php
        $userLogged =Auth::user()->Customer()->get()->first();
    @endphp
@endauth



<body class="animsition">

	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">

					<!-- Logo desktop -->
                <a href="{{url()->route('home')}}" class="logo">
						<img src="{{url()->route('home')}}/asset/images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
                            <li @isset($home) class = "active-menu" @endisset >
                                <a href="{{url()->route('home')}}">Trang chủ</a>
							</li>
                            @foreach (App\ProductType::all() as $type)
                            <li>
                                <a href="{{route('category', $type->TypeCode)}}">{{$type->TypeName}}</a>
                                @php
                                    $categorys = $type->category()->get();
                                @endphp
                                @if ($categorys->count() > 0)
                                <ul class="sub-menu">
                                    @foreach ($categorys as $category)
                                    <li><a href="{{route('category', [$type->TypeCode, $category->CategoryCode])}}">{{$category->CategoryName}}</a></li>
                                    @endforeach
								</ul>
                                @endif
                            </li>
                            @endforeach
							<li @isset($about) class = "active-menu" @endisset>
								<a href="{{route('contact')}}">Giới thiệu</a>
							</li>

						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                            <i class="zmdi zmdi-search"></i>
                        </div>

                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                            data-notify="{{$cart->count()}}">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>

                        <div class="flex-c-m h-full p-lr-19">
							<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 main-menu">
                                <i class="zmdi zmdi-account">
                                    <ul class="sub-menu">
                                            @guest
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                                                </li>
                                                @if (Route::has('register'))
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                                                    </li>
                                                @endif
                                            @else
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link" role="button" data-toggle="modal" data-target="#modal-profile" aria-haspopup="true" aria-expanded="false">
                                                        {{$userLogged->CustomerName}}
                                                    </a>

                                                    <a class="nav-link" href="{{route('order')}}">Đơn hàng của tôi</a>
                                                    <a class="nav-link" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                        document.getElementById('logout-form').submit();">
                                                            {{ __('Đăng xuất') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            @endguest
                                    </ul>
                                </i>
							</div>
						</div>
                    </div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
                <a href="{{route("home")}}"><img src="{{url()->route('home')}}/asset/images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
				<div class="flex-c-m h-full p-r-10">
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
						<i class="zmdi zmdi-search"></i>
					</div>
				</div>

				<div class="flex-c-m h-full p-lr-10 bor5">
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart"  data-notify="{{$cart->count()}}">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>
				</div>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="main-menu-m">

                <li >
                        <a href="{{url()->route('home')}}">Trang chủ</a>
                    </li>
                    @foreach (App\ProductType::all() as $type)
                    <li>
                        <a href="{{route('category', $type->TypeCode)}}">{{$type->TypeName}}</a>
                        @php
                            $categorys = $type->category()->get();
                        @endphp
                        @if ($categorys->count() > 0)
                            <ul class="sub-menu-m">
                                @foreach ($categorys as $category)
                                <li><a href="{{route('category', [$type->TypeCode, $category->CategoryCode])}}">{{$category->CategoryName}}</a></li>
                                @endforeach
                            </ul>
                            <span class="arrow-main-menu-m">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </span>
                        @endif
                    </li>
                    @endforeach
                    <li>
                        <a href="{{route('contact')}}">Giới thiệu</a>
                    </li>

			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="{{url()->route('home')}}/asset/images/icons/icon-close2.png" alt="CLOSE">
				</button>

                <form class="wrap-search-header flex-w p-l-15" action="{{route('search')}}">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="k" placeholder="Search...">
				</form>
			</div>
		</div>
    </header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Giỏ hàng
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
                @if ($cart->count() == 0)
                    <div class="header-cart-total w-full p-tb-40">
                       Giỏ hàng của bạn đang trống!
                    </div>
                @else
                    <div class="header-cart-content flex-w js-pscroll">
                            <ul class="header-cart-wrapitem w-full">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($cart as $cartItem)
                                    @php
                                        $cartProduct = $cartItem->product()->get()->first();
                                        $money = str_replace('₫', '', str_replace(',', '', $cartProduct->getGroup()->Price));
                                        if($cartProduct->getGroup()->Sale > 0)
                                            $money = $money*(100-$cartProduct->getGroup()->Sale)/100;
                                        $total+= ((int)$money)*$cartItem->Quantity;
                                    @endphp
                                    <li class="header-cart-item flex-w flex-t m-b-12">
                                        <div class="header-cart-item-img">
                                            <img src="{{asset("/image")}}/{{$cartProduct->productByColor()->get()->first()->SmallImage}}" alt="IMG">
                                        </div>

                                        <div class="header-cart-item-txt p-t-8">
                                            <a href="{{route('detail', $cartProduct->getGroup()->GroupNameNoVN)}}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                                    {{$cartProduct->getGroup()->GroupName}}
                                            </a>

                                            <span class="header-cart-item-info">
                                                Phân loại (màu): {{$cartProduct->productByColor()->get()->first()->Color}},
                                                Size: {{$cartProduct->Size}}
                                                <br>
                                                {{$cartItem->Quantity}} x {{number_format($money)}}đ
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="w-full">
                                <div class="header-cart-total w-full p-tb-40">
                                    Tổng tiền: {{number_format($total)}}₫
                                </div>

                                <div class="header-cart-buttons flex-w w-full">
                                    <a href="{{route('cart')}}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                                        Xem giỏ hàng
                                    </a>
                                </div>
                            </div>
                    </div>
                @endif

		</div>
	</div>

    <!-- Content page -->
    @section('content')
    @show

    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Phân loại
					</h4>

					<ul>
                        @foreach (App\ProductType::all() as $type)
                            <li class="p-b-10">
                                <a class="stext-107 cl7 hov-cl1 trans-04" href="{{route('category', $type->TypeCode)}}">{{$type->TypeName}}</a>

                            </li>
                        @endforeach

					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Trợ giúp
					</h4>

					<ul>
						<li class="p-b-10">
                            <a href="{{route('order')}}" class="stext-107 cl7 hov-cl1 trans-04">
								Xem thông tin đơn hàng
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Đổi trả
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Vận chuyển
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Hỏi đáp
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Liên hệ
					</h4>

					<p class="stext-107 cl7 size-201">
						Mọi thắc mắc vui lòng liên hệ với chúng tôi tại số 80, đường Lê Văn Liêm, thành phố Đà Nẵng. Hoặc liên hệ qua (+84) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
						</a>
					</div>
				</div>
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Thông tin mới nhất
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Đăng ký
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="{{url()->route('home')}}/asset/images/icons/icon-pay-01.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{url()->route('home')}}/asset/images/icons/icon-pay-02.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{url()->route('home')}}/asset/images/icons/icon-pay-03.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{url()->route('home')}}/asset/images/icons/icon-pay-04.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="{{url()->route('home')}}/asset/images/icons/icon-pay-05.png" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

				</p>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<!-- Modal product -->
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="{{route('home')}}/asset/images/icons/icon-close.png" alt="CLOSE">
				</button>

				<div class="row">
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

								<div class="slick3 gallery-lb" id="gallery-modal">
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">

							<h4 class="mtext-105 cl2 js-name-detail p-b-14" id="group-name-detail">

                            </h4>
                            <span style="display: none" id="groupID"></span>
                            <span>Mã sản phẩm: <span id="id-product-detail"></span></span>
                            <br>
							<span class="mtext-106 cl2" id="price">

                            </span><span class="stext-109 cl4 p-l-5" style="text-decoration: line-through;" id="sale"></span>

							<p class="stext-102 cl3 p-t-23" id="description">

							</p>

							<!--  -->
							<div class="p-t-33">
                                <div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Color
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" id="color-detail">
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
                                </div>

                                <div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Size
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" id="size-detail">
												<option>Choose an option</option>
												<option>Size S</option>
												<option>Size M</option>
												<option>Size L</option>
												<option>Size XL</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number" id="num-product" name="num-product" value="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>

										<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail add-cart">
											Thêm vào giỏ hàng
										</button>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

    <!-- Modal profile -->

   @auth
   <div class="modal fade bd-example-modal-lg" style="z-index: 100000" id="modal-profile" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Thông tin cá nhân</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Mật khẩu</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <form action="{{route('changeUserInfo')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" name="name" value="{{$userLogged->CustomerName}}" aria-describedby="helpId" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <select class="form-control  form-control-md" name="gender">
                                    <option @auth
                                        @if ($userLogged->Gender === 'Men')
                                            selected
                                        @endif
                                    @endauth>Men</option>
                                    <option @auth
                                        @if ($userLogged->Gender === 'Women')
                                            selected
                                        @endif
                                    @endauth>Women</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" value="{{$userLogged->Address}}" name="address" aria-describedby="helpId" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" value="{{$userLogged->Phone}}" name="phone" aria-describedby="helpId" autocomplete="off">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Lưu">
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <fieldset>
                            <div class="form-group">
                            <label>Mật khẩu cũ</label>
                            <input required type="password" class="form-control" id="modal-old-password" aria-describedby="helpId" autocomplete="off">
                            </div>
                            <div class="form-group">
                            <label>Mật khẩu mới</label>
                            <input required type="password" class="form-control" id="modal-new-password" aria-describedby="helpId" autocomplete="off">
                            </div>
                            <div class="form-group">
                            <label>Nhập lại mật khẩu</label>
                            <input required type="password" class="form-control" id="modal-confirm-password" aria-describedby="helpId" autocomplete="off">
                            </div>
                            <button id="modal-btn-change-password" class="btn btn-primary" href="#" role="button">Thay đổi</button>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   @endauth

<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/bootstrap/js/popper.js"></script>
	<script src="{{url()->route('home')}}/asset/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/select2/select2.min.js"></script>
	<script>

		$(".js-select2").each(function(){
			$(this).select2({
				dropdownParent: $(this).next('.dropDownSelect2')
			});
        });
	</script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/daterangepicker/moment.min.js"></script>
	<script src="{{url()->route('home')}}/asset/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/slick/slick.min.js"></script>
	<script src="{{url()->route('home')}}/asset/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/parallax100/parallax100.js"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
        });
    </script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/sweetalert/sweetalert.min.js"></script>
<!--===============================================================================================-->
	<script src="{{url()->route('home')}}/asset/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
    </script>

<!--===============================================================================================-->
<script src="{{url()->route('home')}}/asset/js/main.js"></script>

<script src="{{route("home")}}/asset/js/app.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
<script src="{{route("home")}}/asset/js/map-custom.js"></script>

</body>
</html>
