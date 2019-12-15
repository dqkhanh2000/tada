@extends('layouts.master')
@section('title', 'Kết quả tìm kiếm')
@section('content')
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-100 p-lr-0-lg">
        <span class="stext-109 cl4">
            Tìm thấy {{$product->count()}} sản phẩm cho từ khóa '{{$key}}'
        </span>
    </div>
</div>
<section class="bg0 p-t-23 p-b-130">
    <div class="container">
        <div class="row isotope-grid">
            @foreach ($product as $item)
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$item->Type}}">
                <!-- Block2 -->
                <div class="block2" value="{{$item->GroupNameNoVN}}">
                    <div class="block2-pic hov-img0">
                        <img src="image/{{$item->productByColor()->get()->first()->SmallImage}}" alt="IMG-PRODUCT">
                        <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Xem nhanh
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l ">
                            <a href="{{url()->route('detail', ['id' => $item->GroupNameNoVN])}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                {{$item->GroupName}}
                            </a>

                            <span class="stext-105 cl3">
                                {{$item->Price}}
                            </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="asset/images/icons/icon-heart-01.png" alt="ICON">
                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="asset/images/icons/icon-heart-02.png" alt="ICON">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="flex-c-m flex-w w-full p-t-38">
                {{$product->links()}}
            </div>
    </div>
</section>
@endsection
