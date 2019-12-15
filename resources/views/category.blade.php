@extends('layouts.master')
@section('title', 'Tada shop - Product')
@section('content')
<section class="bg0 p-t-23 p-b-130">
    <div class="container">
        <div class="flex-w flex-sb-m p-b-52 m-t-50">

            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                    <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                     Lọc
                </div>


            </div>

            <!-- Filter -->
            @php

                function getPriceURL($price = ""){
                    $matchGetURL = "?";
                    if(strrpos(url()->full(), '?'))
                        $matchGetURL = "&";
                    $priceURL;
                    if(strrpos(url()->full(), 'filterprice')){
                        $re = '/filterprice=((\d+)|[a-z]+)/';
                        if($price)
                            $priceURL = preg_replace($re, "filterprice=".$price, url()->full());
                        else
                            $priceURL = preg_replace($re, "".$price, url()->full());
                    }
                    else
                        $priceURL = url()->full().$matchGetURL."filterprice=".$price;
                    return $priceURL;
                }

                function getOrderURL($key = ""){
                    $matchGetURL = "?";
                    if(strrpos(url()->full(), '?'))
                        $matchGetURL = "&";
                    $orderURL;
                    if(strrpos(url()->full(), 'order')){
                        $re = '/order=((\d)+|[a-z]*)/';
                        $orderURL = preg_replace($re, "order=".$key, url()->full());
                    }
                    else
                        $orderURL = url()->full().$matchGetURL."order=".$key;
                    return $orderURL;
                }

            @endphp
            <div class="dis-none panel-filter w-full p-t-10">
                <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                    <div class="filter-col1 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Sắp xếp theo
                        </div>

                        <ul>
                            <li class="p-b-6">
                                <a href="{{url()->full()}}" class="filter-link stext-106 trans-04">
                                    Mặc định
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="{{getOrderURL("newest")}}" class="filter-link stext-106 trans-04">
                                    Mới nhất
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="{{getOrderURL("price")}}" class="filter-link stext-106 trans-04">
                                    Giá: Thấp đến cao
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="{{getOrderURL("pricedesc")}}" class="filter-link stext-106 trans-04">
                                    Giá: Cao đến thấp
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="filter-col2 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Price
                        </div>

                        <ul>
                            <li class="p-b-6">
                                <a href="{{getPriceURL()}}" class="filter-link stext-106 trans-04 filter-link-active">
                                    Tất cả
                                </a>
                            </li>

                            <li class="p-b-6">
                            <a href="{{getPriceURL("100")}}" class="filter-link stext-106 trans-04">
                                    0đ - 100,000đ
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="{{getPriceURL("300")}}" class="filter-link stext-106 trans-04">
                                    100,000đ - 300,000đ
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="{{getPriceURL("500")}}" class="filter-link stext-106 trans-04">
                                    300,000đ - 500,000đ
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="{{getPriceURL("1000")}}" class="filter-link stext-106 trans-04">
                                    500,000đ - 1,000,000đ
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="{{getPriceURL("max")}}" class="filter-link stext-106 trans-04">
                                    >1,000,000đ
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="row isotope-grid">
            @if ($product->count() > 0)
                @foreach ($product as $item)
                    @php
                        $price = str_replace('.', '', str_replace('₫', '', str_replace(',', '', $item->Price)));
                    @endphp
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
                        <!-- Block2 -->
                        <div class="block2" value="{{$item->GroupNameNoVN}}">
                            <div class="block2-pic hov-img0">
                                <img src="{{route('home')}}/image/{{$item->productByColor()->get()->first()->SmallImage}}" alt="IMG-PRODUCT">
                                <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                    Xem nhanh
                                </a>
                            </div>
                            @if($item->Sale > 0)
                                <label href="#" class="lb-sale flex-r flex-c-m stext-103  size-10  p-lr-15">
                                    -{{$item->Sale}}%
                                </label>
                            @endif

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="{{url()->route('detail', ['id' => $item->GroupNameNoVN])}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{$item->GroupName}}
                                    </a>

                                    @if($item->Sale > 0)
                                        <span class="stext-105 cl13">
                                            {{number_format($price*(100-$item->Sale)/100)}}đ
                                            <span class="stext-109 cl4 p-l-5" style="text-decoration: line-through;">{{ number_format($price) }}đ </span>
                                        </span>
                                    @else
                                        <span class="stext-105 cl13">
                                                {{ number_format($price) }}đ
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="text-center">Xin lỗi, không tìm thấy sản phẩm nào trong danh mục này!</h2>
            @endif
        </div>

        <!-- Pagination -->
        <div class="flex-c-m flex-w w-full p-t-38">
            {{$product->links()}}
        </div>
    </div>
</section>
@endsection
