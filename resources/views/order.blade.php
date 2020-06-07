@extends('layouts.master')
@section('title', 'Đơn hàng')
@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-100 p-lr-0-lg">
        <a href="{{url()->route('home')}}" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
            <span class="stext-109 cl4">
                Trạng thái đơn hàng
            </span>
        </div>
    </div>
    @if ($orders->count() == 0)
        <div class="container text-center p-t-100 p-b-100">
                <h3 class="text-center p-b-30">Bạn chưa có đơn hàng nào</h3>
                <a name="" id="" class="btn btn-primary" href="{{route('home')}}" role="button">Quay lại trang chủ</a>
        </div>
    @else
        <!-- Shoping Cart -->
        <form class="bg0 p-t-75 p-b-85">
                <div class="container">
                    @foreach ($orders as $order)
                        <div class="row m-b-100 bg6 p-t-30">
                            <div class="row m-r-50 m-l-50">
                                <div class="col-4">
                                    <span class="header-cart-item-info">
                                        Đơn hàng: {{$order->id}}
                                        <br>Đặt ngày:
                                        <span style="color: green; font-size: 80%">{{$order->order_date}}</span>
                                    </span>
                                </div>
                                <div class="col-4">
                                    Trạng thái đơn hàng: {{$order->status}}
                                </div>
                                <div class="col-4">
                                    <div class="float-right">
                                        @if($order->SubTotal > 0)
                                            <span>Tổng tiền: {{number_format($order->total)}}đ</span>
                                            <br>
                                            <span>Mã giảm giá: {{number_format($order->total)}}đ</span>
                                            <br>
                                            <span>Thanh toán: {{number_format($order->total-$order->total)}}đ</span>
                                        @else
                                            <span>Thanh toán: {{number_format($order->total)}}đ</span>
                                        @endif
                                    </div>
                                </div>
                               <div class="col-12 m-b-20">
                                    <span style="display: block">
                                        Thông tin giao hàng: {{$order->customer()->get()->first()->customer_name}}, {{$order->address}}
                                    </span>
                               </div>
                               <div style="background-color: white; width: 200%; height: 3px;"></div>
                            </div>
                            <div class="col-11 mx-auto">
                                <div class="wrap-table-shopping-cart">
                                    <table class="table-shopping-cart">
                                        @foreach($order->orderDetail()->get() as $orderDetail)
                                            <tr class="table_row" style="height: 130px; border-top: none">
                                                <td class="column-1">
                                                    <div class="how-itemcart1">
                                                            <img src="{{route('home')}}/{{$orderDetail->product()->get()->first()->productBycolor()->get()->first()->groupProduct()->get()->first()->image}}" alt="IMG">
                                                    </div>
                                                </td>
                                                <td class="column-2" colspan="2">
                                                        <a href="{{route('detail', $orderDetail->product()->get()->first()->getGroup()->group_code)}}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                                                {{$orderDetail->product()->get()->first()->getGroup()->group_name}}
                                                        </a>
                                                        <span class="header-cart-item-info">
                                                                Phân loại (màu): {{$orderDetail->product()->get()->first()->productByColor()->get()->first()->color}}
                                                                <br>
                                                                Size: {{$orderDetail->product()->get()->first()->size}}
                                                        </span>
                                                </td>
                                                <td class="column-3">Đơn giá: {{$orderDetail->product()->get()->first()->getGroup()->price}}</td>

                                                <td class="column-5">
                                                    <span>SL: {{$orderDetail->quantity}}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </form>

        <div class="flex-c-m flex-w w-full p-b-38">
            {{$orders->links()}}
        </div>
    @endif
@endsection
