@extends('admin.layouts.master')
@section('content')
<section class="p-t-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <h3 class="title-5 m-b-35">Thông tin sản phẩm</h3>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Thông tin</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Màu sắc</a>
                        </div>
                    </nav>
                        <form action="{{route('admin.createProduct')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="row">
                                                <div class="form-group p-t-10 col-md-4">
                                                        <label for="">Mã sản phẩm</label>
                                                    <input type="text" class="form-control" name="code" id="" aria-describedby="helpId" placeholder="Mã sản phẩm">
                                                    </div>
                                                <div class="form-group p-t-10 col-md-6">
                                                    <label for="">Tên</label>
                                                    <input type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="Tên sản phẩm">
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="form-group p-t-10 col-md-4">
                                                        <label for="">Giá</label>
                                                        <input type="number" class="form-control" name="price" id="" aria-describedby="helpId" placeholder="Giá sản phẩm">
                                                </div>

                                                <div class="form-group p-t-10 col-md-4">
                                                        <label for="">Giảm giá (sale %)</label>
                                                        <input type="number" class="form-control" name="sale" id="" min="0" max="100" aria-describedby="helpId" placeholder="sale">
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="form-group p-t-10 col-md-4">
                                                        <label for="">Loại</label>
                                                        <select class="form-control form-control-sm" name="type">
                                                            <option>Men</option>
                                                            <option>Women</option>
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                <div class="form-group p-t-10 col-md-4">
                                                        <label for="">Danh mục</label>
                                                        <select class="form-control form-control-sm" name="category">

                                                            @foreach ($category as $item)
                                                                <option>{{$item->CategoryName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                        </div>
                                        <div class="row m-t-30 m-l-5">
                                            <div class="form-group">
                                                <label for="">Hình hiển thị</label>
                                                <br>
                                                <input type="file" onchange="readURL(this)" class="form-control-file" name="avatar" accept="image/jpg, image/jpeg, image/png" aria-describedby="fileHelpId">
                                            </div>
                                            <img class="m-l-30" style="height: 300px" src="#" id="img-avatar">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Mô tả</label>
                                            <textarea class="form-control" name="description" id="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <button type="button" class="btn btn-success float-right" id="btn-add-color">Thêm màu</button>
                                        <input type="hidden" id="numcolor" name="numcolor" value="1">
                                        <div class="form-group row p-t-20 p-b-10" style="background-color: honeydew">
                                            <div class="col-4">
                                                    <label for="">Màu</label>
                                                    <input type="text" class="form-control color" name="color1" aria-describedby="helpId">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="">Chọn hình ảnh cho màu</label>
                                                <input type="file" class="form-control-file btn btn-primary file" multiple name="imgcolor1[]" placeholder="Chọn ảnh" aria-describedby="fileHelpId">
                                            </div>
                                            <div class="row p-l-30 m-t-30">
                                                <div class="col-12">
                                                    <label class="col-6"><b>Thông tin size</b></label>
                                                    <a class="btn btn-warning btn-insert-new-size col-3 btn-sm">Thêm size</a>
                                                </div>
                                                <div class="form-group col-12 size-table">
                                                    <div class="row text-center">
                                                            <label class="col-6">Size</label>
                                                            <label class="col-6">Số lượng</label>
                                                    </div>
                                                    <div class="row">
                                                            <input type="text" name="size1[]" class="form-control col-6" placeholder="" aria-describedby="helpId">
                                                            <input type="number" min="0" value="0" name="quantity1[]" id="" class="form-control col-6" placeholder="" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success float-right m-r-30">Xác nhận</button>
                        </form>
            </div>
        </div>
    </div>
</section>

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



    $('.btn-success').click((e)=>{
        console.log(editor.getData());
    })

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
    var countColor = 1;
    $('#btn-add-color').click(function() {
        countColor++;
        // $('#nav-profile').append('<div class="form-group row"><div class="col-4"><label for="">Màu</label><input type="text" class="form-control color" name="color'+countColor+'" aria-describedby="helpId"></div><div class="form-group col-6"><label for="">Chọn hình ảnh cho màu</label><input type="file" class="form-control-file btn btn-primary file" multiple name="imgcolor'+countColor+'[]" placeholder="Chọn ảnh" aria-describedby="fileHelpId"></div></div>');
        $('#nav-profile').append(
            '<div class="form-group row p-t-20 p-b-10" style="background-color: honeydew">'+
                '<div class="col-4">'+
                        '<label for="">Màu</label>'+
                        '<input type="text" class="form-control color" name="color'+countColor+'" aria-describedby="helpId">'+
                '</div>'+
                '<div class="form-group col-6">'+
                    '<label for="">Chọn hình ảnh cho màu</label>'+
                    '<input type="file" class="form-control-file btn btn-primary file" multiple name="imgcolor'+countColor+'[]" placeholder="Chọn ảnh" aria-describedby="fileHelpId">'+
                '</div>'+
                '<div class="row p-l-30">'+
                    '<div class="col-12">'+
                        '<label class="col-6"><b>Thông tin size</b></label>'+
                        '<a class="btn btn-warning btn-insert-new-size col-3 btn-sm">Thêm size</a>'+
                    '</div>'+
                    '<div class="form-group col-12 size-table">'+
                        '<div class="row text-center">'+
                                '<label class="col-6">Size</label>'+
                                '<label class="col-6">Số lượng</label>'+
                        '</div>'+
                        '<div class="row">'+
                                '<input type="text" name="size'+countColor+'[]" class="form-control col-6" placeholder="" aria-describedby="helpId">'+
                                '<input type="number" min="0" value="0" name="quantity'+countColor+'[]" id="" class="form-control col-6" placeholder="" aria-describedby="helpId">'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'
        );
        $('#numcolor').val(countColor);
    });

    $(document).on('click', ".btn-insert-new-size", function(e){
        e.preventDefault();
       $(e.target).parent().parent().children(".size-table").append(
        '<div class="row">'+
                                '<input type="text" name="size'+countColor+'[]" class="form-control col-6" placeholder="" aria-describedby="helpId">'+
                                '<input type="number" min="0" value="0" name="quantity'+countColor+'[]" id="" class="form-control col-6" placeholder="" aria-describedby="helpId">'+
                        '</div>'
       );
    });


</script>
@endsection
