@extends('layouts.master')
@section('title', 'Giỏ hàng')
@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-100 p-lr-0-lg">
        <a href="{{url()->route('home')}}" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
            <span class="stext-109 cl4">
                Giỏ hàng
            </span>
        </div>
    </div>
    @if ($cart->count() == 0)
        <div class="container text-center p-t-100 p-b-100">
                <h3 class="text-center p-b-30">Giỏ hàng của bạn đang trống!!</h3>
                <a name="" id="" class="btn btn-primary" href="{{route('home')}}" role="button">Quay lại trang chủ</a>
        </div>
    @else
        <!-- Shoping Cart -->
        <form class="bg0 p-t-75 p-b-85">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                            <div class="m-l-25 m-r--38 m-lr-0-xl">
                                <div class="wrap-table-shopping-cart">
                                    <table class="table-shopping-cart">
                                        <tr class="table_head">
                                            <th class="column-1">Sản phẩm</th>
                                            <th class="column-2"></th>
                                            <th class="column-2"></th>
                                            <th class="column-3">Giá</th>
                                            <th class="column-4">Số lượng</th>
                                            <th class="column-5">Tổng</th>
                                        </tr>
                                                @php
                                                    $total = 0;
                                                @endphp
                                                @foreach ($cart as $cartItem)
                                                    @php
                                                        $cartProduct = $cartItem->product()->get()->first();
                                                        $money = str_replace('₫', '', str_replace(',', '', $cartProduct->getGroup()->Price));
                                                        $total += ((int)$money)*$cartItem->Quantity;
                                                    @endphp
                                                <tr class="table_row">
                                                    <td class="column-1">
                                                        <div class="how-itemcart1">
                                                                <img src="{{asset("/image")}}/{{$cartProduct->productByColor()->get()->first()->SmallImage}}" alt="IMG">
                                                        </div>
                                                    </td>

                                                    <td class="column-2" colspan="2">
                                                            <a href="{{route('detail', $cartProduct->getGroup()->GroupNameNoVN)}}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                                                    {{$cartProduct->getGroup()->GroupName}}
                                                            </a>
                                                            <span class="header-cart-item-info">
                                                                    Phân loại (màu): {{$cartProduct->productByColor()->get()->first()->Color}}
                                                                    <br>
                                                                    Size: {{$cartProduct->Size}}
                                                            </span>
                                                    </td>



                                                    <td class="column-3">{{$cartProduct->getGroup()->Price}}</td>

                                                    <td class="column-4">
                                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                                            </div>

                                                            <input class="mtext-104 cl3 txt-center num-product" type="number" id="{{$cartItem->id}}" name="num-product" value="{{$cartItem->Quantity}}">

                                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="column-5">{{number_format($money)}} ₫</td>
                                                </tr>
                                            @endforeach
                                    </table>
                                </div>

                                <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                    <!-- Coupon -->
                                    <div class="flex-w flex-m m-r-20 m-tb-5">
                                        <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5 voucher" type="text" name="voucher" placeholder="Mã giảm giá">

                                        <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5 btn-couppon">
                                            Xác nhận mã
                                        </div>
                                        <script>
                                            var subTotal = 0;
                                            $(document).ready(function(){
                                            setTimeout(() => {
                                                $(".alert").hide();

                                            }, 500);
                                            $(".btn-couppon").click(() =>{
                                                $voucher = $(".voucher").val();

                                                $data = {
                                                    voucher: $voucher
                                                }
                                                if($voucher){
                                                    $.ajax({
                                                        headers: {
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        },
                                                        method: "POST",
                                                        url: "{{route('voucher')}}",
                                                        data: $data,
                                                    }).then(e => {
                                                        $(".alert").show();
                                                        if(e.false){
                                                            $(".alert").removeClass('alert-success');
                                                            $(".alert").addClass('alert-danger');
                                                            $(".alert").children().text(e.false);
                                                            $('.sub-total').text(0 + "đ");
                                                            $('.total').text(formatNumber(parseInt($('.total').attr('total')))+ " đ");
                                                        }else if(e <= 100 && e > 0){
                                                            subTotal = e * parseInt($('.total').attr('total')) / 100;
                                                            $(".alert").removeClass('alert-danger')
                                                            $(".alert").addClass('alert-success');
                                                            $(".alert").children().text("Áp mã giảm giá thành công! Giảm "+ formatNumber(subTotal) + " đ (" + e + "%)" );
                                                            $('.sub-total').text(formatNumber(subTotal) + "đ");
                                                            $('.total').text(formatNumber(parseInt($('.total').attr('total'))-subTotal)+ " đ");
                                                        }
                                                    });
                                                }
                                            })
                                            });
                                        </script>

                                    </div>

                                    <button class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10" id="update">
                                        Cập nhật
                                    </button>
                                    <script>
                                        function update(){
                                            $data = {};
                                            $('.num-product').each((index, value)=>{
                                                $product = $(value);
                                                if($product.attr("id")){
                                                    $data['s'+index] = {
                                                        idCart: $product.attr("id"),
                                                        quantity: $product.val()
                                                    }
                                                }
                                            });

                                            $.ajax({
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                method: "POST",
                                                url: "{{route('updateCart')}}",
                                                data: $data,
                                            }).then(e => {
                                                if(e === 'ok')
                                                    location.reload();
                                            });

                                        }
                                        $('#update').click((e)=>{
                                            e.preventDefault();
                                            update();
                                        })
                                    </script>

                                        <div class="alert" role="alert">
                                                <strong></strong>
                                        </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                                    <h4 class="mtext-109 cl2 p-b-30">
                                            Chi tiết đơn hàng
                                        </h4>

                                        <div class="flex-w flex-t bor12 p-b-13 sub-voucher">
                                            <div class="size-208">
                                                <span class="stext-110 cl2">
                                                    Mã giảm giá:
                                                </span>
                                            </div>

                                            <div class="size-209">
                                                <span class="mtext-110 cl2 sub-total">
                                                    0đ
                                                </span>
                                            </div>

                                            <div class="">
                                                    <span class="stext-110 cl2">
                                                        Phí vận chuyển: 0đ
                                                    </span>
                                                </div>
                                        </div>

                                        <div class="flex-w flex-t p-t-27">
                                            <div class="size-208">
                                                <span class="mtext-101 cl2">
                                                    Tổng cộng:
                                                </span>
                                            </div>

                                            <div class="size-209 p-t-1">
                                                <span class="mtext-110 cl2 total" total="{{$total}}">
                                                    {{number_format($total)}} ₫
                                                </span>
                                            </div>
                                        </div>
                            </div>
                            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                                <h4 class="mtext-109 cl2 p-b-30">
                                    Chi tiết giao hàng
                                </h4>
                                <div class="flex-w flex-t p-t-15">
                                    <div class="w-full-ssm">
                                        <span class="stext-110 cl2 float-left m-t-5 m-r-20">
                                            Họ tên:
                                        </span>
                                        <div class="form-group float-left">
                                          <input type="text" class="form-control" name="name" id="name-cart" aria-describedby="helpId"
                                          value="{{ Auth::user()->Customer()->get()->first()->CustomerName }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-w flex-t p-b-30">
                                        <div class="size-208 w-full-ssm">
                                            <span class="stext-110 cl2">
                                                Địa chỉ:
                                            </span>
                                        </div>

                                        <div class="p-r-0-sm w-full-ssm">
                                            <div class="">
                                                <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                                    <select class="js-select2 city" name="city">
                                                        <option>Tỉnh/Thành phố</option>
                                                        @php
                                                            $citys = App\City::all();
                                                        @endphp
                                                        @foreach ($citys as $city)
                                                            <option id="{{$city->id}}" >{{$city->name}}</option>
                                                        @endforeach

                                                    </select>
                                                    <div class="dropDownSelect2"></div>
                                                </div>

                                                <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                                    <select class="js-select2 district" name="district">
                                                    </select>
                                                    <div class="dropDownSelect2"></div>
                                                </div>

                                                <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                                    <select class="js-select2 commune" name="commune">
                                                    </select>
                                                    <div class="dropDownSelect2"></div>
                                                </div>

                                                <div class="bor8 bg0 m-b-22">
                                                    <input class="stext-111 cl8 plh3 size-111 p-lr-15 street" type="text" name="street" placeholder="Số nhà, đường.." autocomplete="none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer checkout">
                                    Hoàn tất đơn hàng
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    @endif
@endsection
