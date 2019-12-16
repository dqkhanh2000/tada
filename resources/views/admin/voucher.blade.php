@extends('admin.layouts.master')
@section('content')
    <!-- DATA TABLE-->
    <link rel="stylesheet" type="text/css" href="{{route('home')}}/admin/vendor/datatable/datatable.css">
    <section>
        <div class="row p-l-5 p-t-120" style="background-color: rgba(189, 189, 189, 0.1); margin-left: 1px;">
            <h3 class="title-5 m-b-35">Quản lý Voucher</h3>
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                </div>
                <div class="table-data__tool-right">
                    <button type="button" data-toggle="modal" data-placement="top" data-target="#modal" class="au-btn au-btn-icon au-btn--green au-btn--small"><i class="zmdi zmdi-plus"></i>Thêm voucher</button>

                </div>
            </div>
            <div class="table-responsive table-responsive-data2" >
                <table class="table table-data2 display" id="table-voucher">
                    <thead style="background-color: #fff">
                        <tr>
                            <th>Thời gian tạo</th>
                            <th>Hết hạn</th>
                            <th>Mã voucher</th>
                            <th>Sự kiện</th>
                            <th>Giá trị(%)</th>
                            <th>Số lượng</th>
                            <th>Đã dùng</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                            <tr class="tr-shadow">
                                <input type="hidden" class="voucher-id" voucherid="{{$voucher->VoucherID}}">
                                <td>
                                    {{DateTime::createFromFormat('Y-m-d H:i:s', $voucher->StartDate)->format('H:i:s')}}
                                    <br>
                                    {{DateTime::createFromFormat('Y-m-d H:i:s', $voucher->StartDate)->format('d-m-Y')}}
                                </td>
                                <td>
                                    {{DateTime::createFromFormat('Y-m-d H:i:s', $voucher->EndDate)->format('H:i:s')}}
                                    <br>
                                    {{DateTime::createFromFormat('Y-m-d H:i:s', $voucher->EndDate)->format('d-m-Y')}}
                                </td>
                                <td>{{$voucher->Code}}</td>
                                <td>{{$voucher->Event}}</td>
                                <td>
                                    <div class="form-group" >
                                        <input type="number" style="width: 60px; font-size: 12px;" min="0" max="100"
                                                onchange="changeValue(this)"    class="form-control value" value="{{$voucher->Value}}">
                                        </div>
                                </td>
                                <td>
                                    <div class="form-group" style="width: 100px">
                                        <input type="number" onchange="changeQuantity(this)" min="{{$voucher->QuantityUsed}}" class="form-control quantity" value="{{$voucher->Quantity}}">
                                    </div>
                                </td>
                                <td>{{$voucher->QuantityUsed}}</td>
                                <td>
                                        <div class="form-group" style="width: 100px;">
                                            <select onchange="changeStatus(this)" class="form-control  form-control-md" name="{{$voucher->VoucherID}}">
                                                <option class="Success" @if ($voucher->Status === 'Active')
                                                        selected
                                                    @endif>Active</option>
                                                <option class="Cancel" @if ($voucher->Status === 'Cancel')
                                                            selected
                                                @endif>Cancel</option>
                                            </select>
                                        </div>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- END DATA TABLE-->

    <!-- Modal delete -->
    <div class="modal" id="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.voucher')}}" method="post" id="add-form">
                    @csrf
                    <div class="form-group">
                      <label>Mã voucher</label>
                      <input type="text" name="code" class="form-control" placeholder="VD: coupon1" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label>Thời gian kết thúc</label>
                        <input id="end-time" name="endtime">
                    </div>
                    <div class="form-group">
                        <label>Sự kiện</label>
                        <input type="text" name="event" class="form-control" placeholder="VD: sale cuối năm" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label>Giá trị(%)</label>
                        <input type="number" min="0" max="100" name="value" class="form-control" placeholder="VD: 50" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" name="quantity" min="0" class="form-control" aria-describedby="helpId">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger btn-delete" onclick="event.preventDefault();
                document.getElementById('add-form').submit();">OK</button>
            </div>
            </div>
        </div>
    </div>
    <script src="{{route('home')}}/admin/vendor/datatable/datatable.js" type="text/javascript" charset="utf8"></script>
    <script>
            function changeQuantity(target){
                var quantity = $(target).val();
                var idVoucher = $(target).parent().parent().parent().children('.voucher-id').attr('voucherid');
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    method: 'POST',
                    url: '{{route("admin.changeVoucher")}}',
                    data:{
                        id: idVoucher,
                        quantity: quantity
                    }

                })
            }
            function changeValue(target){
                var value = $(target).val();
                var idVoucher = $(target).parent().parent().parent().children('.voucher-id').attr('voucherid');
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    method: 'POST',
                    url: '{{route("admin.changeVoucher")}}',
                    data:{
                        id: idVoucher,
                        value: value
                    }

                })
            }
            function changeStatus(target){
                var status = $(target).val();
                var idVoucher = $(target).parent().parent().parent().children('.voucher-id').attr('voucherid');
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    method: 'POST',
                    url: '{{route("admin.changeVoucher")}}',
                    data:{
                        id: idVoucher,
                        status: status
                    }

                })
            }

            $(document).ready( function () {
                $('#table-voucher').DataTable();
            } );
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
    <script>
        gj.core.messages['vi-vi'] = {
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            monthShortNames: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            weekDaysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            weekDaysShort: ['CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5','Thứ 6','Thứ 7'],
            weekDays: ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5','Thứ 6','Thứ 7'],
            am: 'Sa',
            pm: 'Ch',
            ok: 'OK',
            cancel: 'Đóng',
            titleFormat: 'mmmm năm yyyy'
        };
        $('#end-time').datetimepicker({
            modal: true,
            format: 'dd-mm-yyyy HH:MM:ss',
            footer: true,
            locale:'vi-vi'
        });
    </script>



@endsection
