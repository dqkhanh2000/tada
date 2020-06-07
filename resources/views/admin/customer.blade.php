@extends('admin.layouts.master')
@section('content')
 <!-- DATA TABLE-->
 <div class="table-responsive m-t-80">
    <h3 class="title-5 p-b-35 p-t-50">Thông tin khách hàng</h3>
    <table class="table table-borderless table-data3 display" id="table-customer">
        <thead style="background-color: #fff; border: 0.5px rgba(0,0,0,0.1) solid">
            <tr>
                <th>Mã khách hàng</th>
                <th>Họ tên</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Giới tính</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{$customer->id}}</td>
                    <td>{{$customer->customer_name}}</td>
                    <td>{{$customer->address}}</td>
                    <td>{{$customer->phone}}</td>
                    <td>{{$customer->user()->get()->first()->email}}</td>
                    <td>{{$customer->gender}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- END DATA TABLE -->
<script src="{{route('home')}}/admin/vendor/datatable/datatable.js" type="text/javascript" charset="utf8"></script>
<script>
    $(document).ready( function () {
                $('#table-customer').DataTable();
    } );
</script>
@endsection
