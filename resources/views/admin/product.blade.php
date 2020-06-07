@extends('admin.layouts.master')
@section('content')
    <!-- DATA TABLE-->
    <section>
        <div class="row p-l-5 p-t-120" style="background-color: rgba(189, 189, 189, 0.1); margin-left: 1px;">
            <h3 class="title-5 m-b-35">Quản lý sản phẩm</h3>

            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    <div class="rs-select2--light rs-select2--md">
                        <select class="js-select2" id="category-fillter" name="property">
                            <option value="all" selected="selected">Tất cả danh mục</option>
                            @foreach ($category as $item)
                                <option value="{{$item->category_name}}">{{$item->category_name}}</option>
                            @endforeach
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                </div>
                <div class="table-data__tool-right">
                    <a href="{{route('admin.createProduct')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>Thêm sản phẩm</a>
                </div>
            </div>
            <div class="table-responsive table-responsive-data2" >
                <table class="table table-data2 display" id="table-product">
                    <thead style="background-color: #fff">
                        <tr>
                            <th></th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Loại</th>
                            <th>Giá</th>
                            <th>Khuyến mãi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupProducts as $group)
                            <tr class="tr-shadow">
                                <td>
                                    <img src="{{route('home')}}/{{$group->image}}" style="width:100px">
                                </td>
                                <td>
                                    <a href="{{route('detail', $group->group_code)}}">{{$group->group_name}}</a>

                                </td>
                                <td class="desc">{{$group->category()->get()->first()->category_name}}</td>
                                <td>
                                    <span class="status--process">{{$group->type}}</span>
                                </td>
                                <td>{{$group->price}}</td>
                                <td>{{$group->sale_off}}</td>
                                <td>
                                    <div class="table-data-feature">
                                        <a href="{{route('admin.editProduct', $group->group_code)}}" class="item edit" productid="{{$group->id}}" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <button class="item delete" productid="{{$group->id}}" productname="{{$group->group_name}}" data-toggle="modal" data-placement="top" data-target="#modal" title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form id="delete-form" action="{{ route('admin.product') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" id="productid" name="productid" value="a">
                </form>
                {{-- {{$groupProducts->links()}} --}}
            </div>
        </div>
    </section>
    <!-- END DATA TABLE-->

    <!-- Modal delete -->
    <div class="modal" id="modal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có muốn xóa sản phẩm: <br><span class="target-delete"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger btn-delete" onclick="event.preventDefault();
                document.getElementById('delete-form').submit();">Xóa</button>
            </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{route('home')}}/admin/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="{{route('home')}}/admin/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="{{route('home')}}/admin/vendor/bootstrap-4.1/bootstrap.min.js"></script> --}}
    <script src="{{route('home')}}/admin/vendor/datatable/datatable.js" type="text/javascript" charset="utf8"></script>
    <script>
            $(document).on('click', '.delete', function(){
                var a = $(this);
                $('#delete-form #productid').val(a.attr('productid'));
                $('.target-delete').text(a.attr('productname'));

            });
            $(document).ready( function () {
                var table = $('#table-product').DataTable();
                $('#category-fillter').change( function() {
                    table.draw();
                } );
            } );
            $(document).on('click', ".paginate_button", e =>{
                e.preventDefault();
            })
    </script>

<script>
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var fillter =$('#category-fillter').val();
            var category = data[2]; // use data for the category column

            if(fillter === 'all' || fillter == null || fillter === category) return true;
            return false;
        }
    );

</script>

@endsection
