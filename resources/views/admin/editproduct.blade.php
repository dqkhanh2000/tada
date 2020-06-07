@extends('admin.layouts.master')
@section('content')
<section class="p-t-100">
    <h3 class="title-5 m-b-35">Thông tin sản phẩm</h3>
    <div class="row p-l-30">
        <input type="hidden" id="data-des" cols="30" rows="10" value="{{$groupProduct->description}}">
        <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Màu sắc</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="clear-fix"></div>
                        <div class="p-l-10 p-t-20 p-b-20" style="background-color: honeydew">
                            <div class="row">
                                <div class="form-group p-t-10 col-md-4">
                                        <label for="">Mã sản phẩm</label>
                                    <input type="text" class="form-control" readonly name="code" aria-describedby="helpId" value="{{$groupProduct->group_code}}" placeholder="Mã sản phẩm">
                                    </div>
                                <div class="form-group p-t-10 col-md-6">
                                    <label for="">Tên</label>
                                    <input type="text" class="form-control" name="name" value="{{$groupProduct->group_name}}" aria-describedby="helpId" placeholder="Tên sản phẩm">
                                </div>
                            </div>
                            <div class="row">
                                    <div class="form-group p-t-10 col-md-4">
                                            <label for="">Giá</label>
                                            @php
                                                $price = $money = str_replace('₫', '', str_replace(',', '', $groupProduct->price));
                                            @endphp
                                            <input type="number" class="form-control" name="price" value="{{$price}}" aria-describedby="helpId" placeholder="Giá sản phẩm">
                                    </div>

                                    <div class="form-group p-t-10 col-md-4">
                                            <label for="">Giảm giá (sale %)</label>
                                            <input type="number" class="form-control" name="sale" value="{{$groupProduct->sale_off}}" min="0" max="100" aria-describedby="helpId" placeholder="sale">
                                    </div>
                            </div>
                            <div class="row m-t-30 m-l-5">
                                <div class="form-group">
                                    <label for="">Hình hiển thị</label>
                                    <br>
                                    <button type="button" class="btn btn-secondary" btn-lg btn-block onclick="$(this).hide(); $(this).parent().children('input').show()">Thay đổi</button>
                                    <input type="file" onchange="readURL(this)" class="form-control-file" style="display: none" name="avatar" accept="jpg, jpeg, png" aria-describedby="fileHelpId">
                                </div>
                                <img class="m-l-30" style="height: 300px" src="{{route('home')}}/{{$groupProduct->image}}" id="img-avatar">
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <button type="button" class="btn btn-success float-right m-r-20" id="btn-add-color">Thêm màu</button>
                        <input type="hidden" id="numcolor" name="numcolor" value="0">

                        @foreach ($groupProduct->productByColor()->get() as $color)
                            <div class="form-group row p-l-10 p-t-20 p-b-20" style="background-color: honeydew">
                                <div class="col-4">
                                        <label for="">Màu</label>
                                        <input type="text" class="form-control color" name="{{$color->color}}" value="{{$color->color}}" aria-describedby="helpId">
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Chọn thêm hình</label>
                                    <input type="file" class="form-control-file btn btn-primary file" multiple name="img{{$color->color}}[]" placeholder="Chọn ảnh" aria-describedby="fileHelpId">
                                </div>

                                <div class="row m-t-20">
                                    @foreach ($color->productImage()->get() as $item)
                                        <div class="col-md-3">
                                                <span class="btn btn-danger"
                                                    onclick="
                                                        $('#deleteImgForm #idimg').val('{{$item->id}}');
                                                        document.getElementById('deleteImgForm').submit();
                                                    ">Xóa</span>
                                                <img src="{{route('home')}}/{{$item->path}}" class="img" alt="">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-7 mx-auto m-b-30 m-t-20">
                                    <b class="m-b-10">Thông tin về size</b>
                                    <button type="button" id="btn-add-size" color-id="{{$color->id_product_color}}"
                                        onclick="$('#modal-add-size .color-id').val($(this).attr('color-id'));
                                        $('#error').hide()" class="btn btn-success m-b-20 float-right btn-sm"  data-toggle="modal" data-target="#modal-add-size">Thêm size</button>
                                    <table style="display:block;" class="table table-data2">
                                        <thead style="background-color: white;">
                                            <tr>
                                                <th>Id Sản phẩm</th>
                                                <th>Size</th>
                                                <th>Số lượng trong kho</th>
                                                <th>Số lượng đã bán</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($color->product()->get() as $product)
                                                <tr class="text-center">
                                                    <td>{{$product->id}}</td>
                                                    <td>{{$product->size}}</td>
                                                    <td><div class="form-group">
                                                            <input type="number" min="0" product-id="{{$product->id}}" onchange="changeQuantity($(this))"
                                                                class="form-control" value="{{$product->quantity_storage}}">
                                                            </div></td>
                                                    <td>{{$product->quantity_selled}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <style>
                                    td, th{
                                        border-top: 1px solid #dee2e6 !important;
                                        padding: 10px 5px !important;
                                        vertical-align: middle !important;
                                    }
                                </style>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-success float-right m-r-30">Xác nhận</button>
        </form>
        <form id="deleteImgForm" action="{{route('admin.deleteImage')}}" method="post">
                @csrf
                <input id="idimg" type="hidden" name="idimage" value="a">
        </form>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="modal-add-size" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Thêm size</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                        <div class="form-group">
                            <input type="hidden" name="color-id" class="color-id">
                            <label>Size</label>
                            <input type="text" class="form-control" name="size" id="new-size" aria-describedby="helpId">
                            <small id="error" style="color: red">Có lỗi</small>
                        </div>
                        <div class="form-group">
                            <label >Số lượng</label>
                            <input type="number" min="0" class="form-control" name="quantity" id="new-size-quantity" value="0" aria-describedby="helpId" placeholder="">
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="btn-submit-new-size">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn-submit-new-size').click(e =>{
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            data: {
                colorid: $('.color-id').val(),
                size: $('#new-size').val(),
                quantity: $('#new-size-quantity').val()
            },
            method: 'POST',
            url: '{{route("admin.newSize")}}'
        }).then(rs =>{

            if(rs === 'ok') location.reload();
            else if(rs.error){
                $('#error').text(rs.error);
                $('#error').show();
            }
        })
    });
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/15.0.0/classic/ckeditor.js"></script>
<script>
    var editor;
        ClassicEditor
            .create( document.querySelector( '#description' ), {
                cloudServices: {
                    tokenUrl: 'https://44310.cke-cs.com/token/dev/Vf98mYYPDx4n2wHqJTi7BZpCb0JbVHG80KpkayeKNGVpYjipKSuRzTLPoTrF',
                    uploadUrl: 'https://44310.cke-cs.com/easyimage/upload/'
                }
            })
            .then( e => {
                editor = e;
                editor.setData($("#data-des").val());
            } )
            .catch( error => {
                    console.error( error );

            } );
    var countColor = 0;
    $('#btn-add-color').click(function() {
        countColor++;
        $('#nav-profile').append('<div class="form-group row"><div class="col-4"><label for="">Màu</label><input type="text" class="form-control color" name="color'+countColor+'" aria-describedby="helpId"></div><div class="form-group col-6"><label for="">Chọn hình ảnh cho màu</label><input type="file" class="form-control-file btn btn-primary file" multiple name="imgcolor'+countColor+'[]" placeholder="Chọn ảnh" aria-describedby="fileHelpId"></div></div>');
        $('#numcolor').val(countColor);
    });
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-avatar')
                        .attr('src', e.target.result)
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    function changeQuantity(target){
        var quantity = target.val();
        var idProduct = target.attr('product-id');
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            method: 'POST',
            url: '{{route("admin.changeQuantityProduct")}}',
            data:{
                id: idProduct,
                quantity: quantity
            }

        })
    }
</script>
@endsection
