    @extends('layouts.master')
    @section('title', 'Tada shop')

    @section('content')
	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1 rs1-slick1">
			<div class="slick1">
				<div class="item-slick1" style="background-image: url(asset/images/slide-03.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-202 cl2 respon2">
									Bộ sưu tập thời trang nam 2019
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
									Thiết kế mới
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="{{route('category', 'men')}}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Mua ngay
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(asset/images/slide-02.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-202 cl2 respon2">
									Thời trang nam mùa mới
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
									Jackets & Coats
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="{{route('category', 'women')}}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Mua ngay
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(asset/images/slide-04.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-202 cl2 respon2">
									Bộ sưu tập thời trang nữ
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
									Thiết kế mới
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="{{route('category', 'accessory')}}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Mua ngay
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Banner -->
	<div class="sec-banner bg0">
		<div class="flex-w flex-c-m">
			<div class="size-202 m-lr-auto respon4">
				<!-- Block1 -->
				<div class="block1 wrap-pic-w">
					<img src="asset/images/banner-04.jpg" alt="IMG-BANNER">

					<a href="{{route('category', 'women')}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								Nữ
							</span>

							<span class="block1-info stext-102 trans-04">
								Mùa xuân 2019
							</span>
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
								Mua ngay
							</div>
						</div>
					</a>
				</div>
			</div>

			<div class="size-202 m-lr-auto respon4">
				<!-- Block1 -->
				<div class="block1 wrap-pic-w">
					<img src="asset/images/banner-05.jpg" alt="IMG-BANNER">

					<a href="{{route('category', 'men')}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								Nam
							</span>

							<span class="block1-info stext-102 trans-04">
                                Mùa xuân 2019
							</span>
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
                                Mua ngay
							</div>
						</div>
					</a>
				</div>
			</div>

			<div class="size-202 m-lr-auto respon4">
				<!-- Block1 -->
				<div class="block1 wrap-pic-w">
					<img src="asset/images/banner-06.jpg" alt="IMG-BANNER">

					<a href="{{route('category', 'accessory')}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
						<div class="block1-txt-child1 flex-col-l">
							<span class="block1-name ltext-102 trans-04 p-b-8">
								Balo-Túi xách
							</span>

							<span class="block1-info stext-102 trans-04">
								Xu hướng mới
							</span>
						</div>

						<div class="block1-txt-child2 p-b-4 trans-05">
							<div class="block1-link stext-101 cl0 trans-09">
								Mua ngay
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>

    <!-- Product -->

    <section class="sec-product bg0 p-t-100 p-b-50">
        <div class="container">
            <div class="p-b-32">
                <h3 class="ltext-105 cl5 txt-center respon1">
                    Sản phẩm mới
                </h3>
            </div>

            <div class="wrap-slick2">
                    <div class="slick2">
                        @foreach ($new as $item)
                            @php
                                $price = str_replace('.', '', str_replace('₫', '', str_replace(',', '', $item->price)));
                            @endphp
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                <!-- Block2 -->
                                <div class="block2" value="{{$item->group_code}}">
                                    <div class="block2-pic hov-img0">
                                        <img src="{{$item->image}}" alt="IMG-PRODUCT" >

                                        <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                            Xem nhanh
                                        </a>
                                    </div>
                                    @if($item->sale_off > 0)
                                    <label href="#" class="lb-sale flex-r flex-c-m stext-103  size-10  p-lr-15">
                                        -{{$item->sale_off}}%
                                    </label>
                                    @endif

                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l ">
                                            <a href="{{route('detail', ['id' => $item->group_code])}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                {{$item->group_name}}
                                            </a>
                                            @if($item->sale_off > 0)
                                                <span class="stext-105 cl13">
                                                    {{number_format($price*(100-$item->sale_off)/100)}}đ
                                                    <span class="stext-109 cl4 p-l-5" style="text-decoration: line-through;">{{ number_format($price) }}đ </span>
                                                </span>
                                            @else
                                                <span class="stext-105 cl13">
                                                        {{ number_format($price) }}đ
                                                </span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        </div>
    </section>

    <section class="sec-product bg0 p-t-100 p-b-50">
        <div class="container">
            <div class="p-b-32">
                <h3 class="ltext-105 cl5 txt-center respon1">
                    Đề xuất cho nữ
                </h3>
            </div>

            <div class="wrap-slick2">
                    <div class="slick2">
                        @foreach ($women as $item)
                            @php
                                $price = str_replace('.', '', str_replace('₫', '', str_replace(',', '', $item->price)));
                            @endphp
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                <!-- Block2 -->
                                <div class="block2" value="{{$item->group_code}}">
                                    <div class="block2-pic hov-img0">
                                        <img src="{{$item->image}}" alt="IMG-PRODUCT" >

                                        <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                            Xem nhanh
                                        </a>
                                    </div>
                                    @if($item->sale_off > 0)
                                    <label href="#" class="lb-sale flex-r flex-c-m stext-103  size-10  p-lr-15">
                                        -{{$item->sale_off}}%
                                    </label>
                                    @endif

                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l ">
                                            <a href="{{route('detail', ['id' => $item->group_code])}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                {{$item->group_name}}
                                            </a>
                                            @if($item->sale_off > 0)
                                                <span class="stext-105 cl13">
                                                    {{number_format($price*(100-$item->sale_off)/100)}}đ
                                                    <span class="stext-109 cl4 p-l-5" style="text-decoration: line-through;">{{ number_format($price) }}đ </span>
                                                </span>
                                            @else
                                                <span class="stext-105 cl13">
                                                        {{ number_format($price) }}đ
                                                </span>
                                            @endif

                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        </div>
    </section>
    <section class="sec-product bg0 p-t-100 p-b-50">
            <div class="container">
                <div class="p-b-32">
                    <h3 class="ltext-105 cl5 txt-center respon1">
                        Đề xuất cho nam
                    </h3>
                </div>

                <div class="wrap-slick2">
                        <div class="slick2">
                            @foreach ($men as $item)
                                @php
                                    $price = str_replace('.', '', str_replace('₫', '', str_replace(',', '', $item->price)));
                                @endphp
                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2" value="{{$item->group_code}}">
                                        <div class="block2-pic hov-img0">
                                            <img src="{{$item->image}}" alt="IMG-PRODUCT" >
                                            <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                                Xem nhanh
                                            </a>
                                        </div>
                                        @if($item->sale_off > 0)
                                        <label href="#" class="lb-sale flex-r flex-c-m stext-103  size-10  p-lr-15">
                                            -{{$item->sale_off}}%
                                        </label>
                                        @endif

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="{{route('detail', ['id' => $item->group_code])}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    {{$item->group_name}}
                                                </a>
                                                @if($item->sale_off > 0)
                                                    <span class="stext-105 cl13">
                                                        {{number_format($price*(100-$item->sale_off)/100)}}đ
                                                        <span class="stext-109 cl4 p-l-5" style="text-decoration: line-through;">{{ number_format($price) }}đ </span>
                                                    </span>
                                                @else
                                                    <span class="stext-105 cl13">
                                                            {{ number_format($price) }}đ
                                                    </span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </section>
    @endsection
