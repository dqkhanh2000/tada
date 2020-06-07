@extends('admin.layouts.master')
@section('content')
 <!-- DATA TABLE-->
 {{-- <div class="table-responsive m-t-80">
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
                                    @endif>Success</option>
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
</div> --}}
<section>
    <div class="row p-l-5 p-t-120" style="background-color: rgba(189, 189, 189, 0.1); margin-left: 1px;">
        <h3 class="title-5 m-b-35">Quản lý đơn hàng</h3>

        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <div class="rs-select2--light rs-select2--md">
                    <select class="js-select2" id="month-fillter">
                        <option value="all" selected="selected">Chọn tháng</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{$i}}">Tháng {{$i}}</option>
                        @endfor
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
                <div class="rs-select2--light rs-select2--md">
                    <select class="js-select2" id="date-fillter">
                        <option value="all" selected="selected">Chọn ngày</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{$i}}">Ngày {{$i}}</option>
                        @endfor
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2" >
            <table class="table table-data2 display" id="table-order">
                <thead style="background-color: #fff">
                    <tr>
                        <tr>
                            <th>Thời gian</th>
                            <th>Mã hóa đơn</th>
                            <th>Khách hàng</th>
                            <th>Địa chỉ</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->order_date}}</td>
                            <td><a href="{{route('admin.orderDetail', $order->id)}}">{{$order->id}}</a></td>
                            <td>{{$order->customer()->get()->first()->customer_name}}</td>
                            <td>{{$order->address}}</td>
                            <td>{{number_format($order->total)}}</td>
                            <td>
                                    <select style="width: 120px;" class="form-control  form-control-md" name="{{$order->id}}" id="">
                                        <option class="Success" @if ($order->status === 'Success')
                                                selected
                                            @endif>Success</option>
                                        <option class="Cancel" @if ($order->status === 'Cancel')
                                                    selected
                                        @endif>Cancel</option>
                                        <option class="Pending" @if ($order->status === 'Pending')
                                                selected
                                        @endif>Pending</option>
                                    </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- END DATA TABLE -->
<script src="{{route('home')}}/admin/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="{{route('home')}}/admin/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
<script src="{{route('home')}}/admin/vendor/datatable/datatable.js" type="text/javascript" charset="utf8"></script>
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

    $.fn.dataTable.ext.order['dom-select'] = function  ( settings, col ){
            return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                return $('select', td).val();
            } );
        }

    $(document).ready( function () {
        var table = $('#table-order').DataTable({
            "columns": [
                null,
                null,
                null,
                null,
                null,
                { "orderDataType": "dom-select" }
            ]
        });
        $('#month-fillter').change( function() {
                    table.draw();
        });
        $('#date-fillter').change( function() {
                    table.draw();
        });
    } );


    $.fn.dataTable.ext.search.push(
                function( settings, data, dataIndex ) {
                    var monthFillter =$('#month-fillter').val();
                    var dateFillter =$('#date-fillter').val();
                    var dateTable = data[0].split(' ')[0].split("-");

                    if((monthFillter == dateTable[1] && dateFillter === 'all')
                        || (monthFillter === 'all' && dateFillter === 'all')
                        || monthFillter ==null)
                            return true;
                    else if ((dateFillter == dateTable[2] && monthFillter == dateTable[1])
                        || monthFillter === 'all' || monthFillter ==null)
                            return true;
                }
        );

</script>
@endsection
