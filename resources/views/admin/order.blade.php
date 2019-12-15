@extends('admin.layouts.master')
@section('content')
 <!-- DATA TABLE-->
 <div class="table-responsive m-t-80">
    <h3 class="title-5 p-b-35 p-t-50">Quản lý đơn hàng</h3>
    <table class="table table-borderless table-data3 display" id="table-order">
        <thead style="background-color: #fff; border: 0.5px rgba(0,0,0,0.1) solid">
            <tr>
                <th>Thời gian</th>
                <th>Mã hóa đơn</th>
                <th>Khách hàng</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Khuyến mãi</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{$order->OrderDate}}</td>
                    <td><a href="{{route('admin.orderDetail', $order->OrderID)}}">{{$order->OrderID}}</a></td>
                    <td>{{$order->customer()->get()->first()->CustomerName}}</td>
                    <td>{{$order->Address}}</td>
                    <td>{{number_format($order->Total)}}</td>
                    <td>{{number_format($order->SubTotal)}}</td>
                    <td>
                            <select style="width: 120px;" class="form-control  form-control-md" name="{{$order->OrderID}}" id="">
                                <option class="Success" @if ($order->Status === 'Success')
                                        selected
                                    @endif>Sucesss</option>
                                <option class="Cancel" @if ($order->Status === 'Cancel')
                                            selected
                                @endif>Cancel</option>
                                <option class="Pending" @if ($order->Status === 'Pending')
                                        selected
                                @endif>Pending</option>
                            </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
    $(document).ready( function () {
        $('#table-order').DataTable({
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                { "orderDataType": "dom-select" }
            ]
        });
    } );
</script>
@endsection
