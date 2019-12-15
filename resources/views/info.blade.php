@extends('layouts.master')
@section('title', 'Tada shop - Info')
@section('content')
<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{route('home')}}/asset/images/bg-01.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Giới thiệu
    </h2>
</section>


<!-- Content page -->
<section class="bg0 p-t-75 p-b-120">
    <div class="container">
        <div class="row p-b-148">
            <div class="col-md-7 col-lg-8">
                <div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                        Tổng quan
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        Phần này để giới thiệu về shop, nhưng mà đây chỉ là sản phẩm chưa biết có có chữ gì nên mới viết bậy bạ như vậy cho có chữ cho cái trang nó đẹp hơn.
                        Và để tiếp tục cho cái phần này nó được dài thì sau đây là một số đoạn chữ loream vô nghĩa mời bạn đọc cho đỡ chán nhé!! ^_%^
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores amet animi voluptate nulla corrupti, molestias dolor aliquid sequi a ducimus consectetur? Ullam quasi maiores, modi neque, labore mollitia consectetur temporibus quaerat numquam voluptatum delectus omnis in nostrum, ratione itaque repellat.
                    </p>

                    <p class="stext-113 cl6 p-b-26">
                        Donec gravida lorem elit, quis condimentum ex semper sit amet. Fusce eget ligula magna. Aliquam aliquam imperdiet sodales. Ut fringilla turpis in vehicula vehicula. Pellentesque congue ac orci ut gravida. Aliquam erat volutpat. Donec iaculis lectus a arcu facilisis, eu sodales lectus sagittis. Etiam pellentesque, magna vel dictum rutrum, neque justo eleifend elit, vel tincidunt erat arcu ut sem. Sed rutrum, turpis ut commodo efficitur, quam velit convallis ipsum, et maximus enim ligula ac ligula.
                    </p>

                    <p class="stext-113 cl6 p-b-26">
                        Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
                    </p>
                </div>
            </div>

            <div class="col-11 col-md-5 col-lg-4 m-lr-auto">
                <div class="how-bor1 ">
                    <div class="hov-img0">
                        <img src="{{route('home')}}/asset/images/about-01.jpg" alt="IMG">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                    <h3 class="mtext-111 cl2 p-b-16">
                        Sứ mệnh
                    </h3>

                    <p class="stext-113 cl6 p-b-26">
                        Đây lại là một phần để nói về sứ mệnh của cái shop này nhưng mà nó đã làm gì phải là một cái shop đâu. Nên mình lại viết những chữ vô nghĩa này để các bạn ddocj cho vui. Hihi cảm ơn bạn đã đọc đến đây, chắc bạn cũng là cong người quá rảnh rỗi để đọc đến những chữ này nhỉ ^_%^!
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, rem tempora, omnis harum perferendis beatae inventore exercitationem magnam aut hic tenetur nam aspernatur mollitia! Repellendus, at! Maxime eum ex a.
                    </p>

                    <div class="bor16 p-l-29 p-b-9 m-t-22">
                        <p class="stext-114 cl6 p-r-40 p-b-11">
                            Làm ra được cái web này quả à điều không dễ nhưng mà đây là thành quả do chính tay tui làm ra nên cũng đáng đó chứ nhỉ ^_%^!
                        </p>

                        <span class="stext-111 cl8">
                            D.Q.Khánh
                        </span>
                    </div>
                </div>
            </div>

            <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                <div class="how-bor2">
                    <div class="hov-img0">
                        <img src="{{route('home')}}/asset/images/about-02.jpg" alt="IMG">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg0 p-t-104 p-b-116">
		<div class="container">
			<div class="flex-w flex-tr ">

				<div class="size-210 bor10 mx-auto flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                        <h2 class="m-b-30 txt-center">
                                Liên hệ
                        </h2>
					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-map-marker"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Địa chỉ
							</span>

							<p class="stext-115 cl6 size-213 p-t-18">
								Tada Store số 1234, đường abc, Ngũ Hành Sơn, Đà Nẵng
							</p>
						</div>
					</div>

					<div class="flex-w w-full p-b-42">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-phone-handset"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Số điện thoại
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								01234567890
							</p>
						</div>
					</div>

					<div class="flex-w w-full">
						<span class="fs-18 cl5 txt-center size-211">
							<span class="lnr lnr-envelope"></span>
						</span>

						<div class="size-212 p-t-2">
							<span class="mtext-110 cl2">
								Email liên hệ
							</span>

							<p class="stext-115 cl1 size-213 p-t-18">
								tadafashion.shop@gmail.com
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- Map -->
	<div class="map">
		<div class="size-303" id="google_map" data-map-x="16.013143937208255" data-map-y="108.23832291271492" data-pin="images/icons/pn.pnig" data-scrollwhell="0" data-draggable="1" data-zoom="11"></div>
	</div>
@endsection
