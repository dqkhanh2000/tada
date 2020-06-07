@extends('admin.layouts.master')
@section('content')
 <!-- DATA TABLE-->
<form class="bg0 p-t-100 p-b-85">
    <div class="row">
        <h3 class="title-5 m-l-30 m-b-35">Chi tiết đơn hàng</h3>
        <div class="row m-r-50 m-l-50">
            <div class="col-4">
                <span class="header-cart-item-info">
                    Đơn hàng: {{$order->id}}
                    <br>Đặt ngày:
                    <span style="color: green; font-size: 80%">{{$order->order_date}}</span>
                </span>
            </div>
            <div class="col-4">
                <span>Trạng thái đơn hàng</span>
                <div class="form-group" style="width: 150px;">
                    <select class="form-control  form-control-md" name="{{$order->id}}" id="">
                        <option class="Success" @if ($order->status === 'Success')
                                selected
                            @endif>Sucesss</option>
                        <option class="Cancel" @if ($order->status === 'Cancel')
                                    selected
                        @endif>Cancel</option>
                        <option class="Pending" @if ($order->status === 'Pending')
                                selected
                        @endif>Pending</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="float-right">
                    @if($order->SubTotal > 0)
                        <span>Tổng tiền: {{number_format($order->total)}}đ</span>
                        <br>
                        <span>Thanh toán: {{number_format($order->total)}}đ</span>
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
        <div class="col-12 mx-auto">
            <div class="wrap-table-shopping-cart">
                <table class="table-shopping-cart">
                    @foreach($order->orderDetail()->get() as $orderDetail)
                        <tr class="table_row" style="height: 130px; border-top: none">
                            <td class="column-1">
                                <div class="how-itemcart1">
                                        <img src="{{asset("/image")}}/{{$orderDetail->product()->get()->first()->image}}" alt="IMG">
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
</form>
<link rel="stylesheet" href="{{route('home')}}/asset/css/main.css">
<!-- END DATA TABLE -->
<script>
    $(document).on('change', '.form-control', function(){
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            url: "{{route('admin.changeOrderStatus')}}",
            method: 'POST',
            data: {
                id: $(this).attr('name'),
                status: $(this).val()
            },
            success: function(e){ console.log(e)}
        })
    });
</script>
@endsection
