@extends('admin.layouts.master')
@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Tổng quan</h2>
                    </div>
                </div>
            </div>
            @php
                $countSum = 0;
                $countProduct = 0;
                foreach ($order as $key => $value){
                    $countSum += $value->total ;
                    $countProduct +=$value->orderDetail()->get()->count();
                }
            @endphp
            <div class="row m-t-25">
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fas fa-dolly"></i>
                                </div>
                                <div class="text">
                                    <h2>{{$order->count()}}</h2>
                                    <span>Tổng số đơn hàng</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-shopping-cart"></i>
                                </div>

                                <div class="text">
                                    <h2>
                                        {{$countProduct}}
                                    </h2>
                                    <span>Sản phẩm đã bán</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c3">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-calendar-note"></i>
                                </div>
                                <div class="text">
                                    <h2>
                                        {{$customer->count()}}
                                    </h2>
                                    <span>Tổng số khách hàng</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c4">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-money"></i>
                                </div>
                                <div class="text">
                                    <h2>
                                            {{number_format($countSum)}}đ
                                    </h2>
                                    <span>Tổng doanh thu</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart4"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RECENT REPORT-->
            <div class="recent-report3 m-b-40">
                    <div class="title-wrap">
                        <h3 class="title-3">Biểu đồ</h3>
                        <div class="chart-info-wrap">
                            <div class="chart-note">
                                <span class="dot dot--blue"></span>
                                <span>Doanh thu</span>
                            </div>
                            <div class="chart-note">
                                <span class="dot dot--green"></span>
                                <span>Đơn hàng</span>
                            </div>
                            <div class="chart-note mr-0">
                                <span class="dot dot--red"></span>
                                <span>View</span>
                            </div>
                        </div>
                    </div>
                    <div class="filters m-b-55">
                        <div class="rs-select2--dark rs-select2--sm rs-select2--border">
                            <select class="js-select2 au-select-dark" id="chart-report">
                                <option selected="selected" value="month">Theo tháng</option>
                                <option value="day">Theo ngày</option>
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                    </div>
                    <div class="chart-wrap">
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            <!-- END RECENT REPORT-->
            {{-- <div class="row">
                <div class="au-card au-card--no-shadow au-card--no-pad m-b-40 au-card--border">
                    <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                        <div class="bg-overlay bg-overlay--blue"></div>
                        <h3>
                            <i class="zmdi zmdi-account-calendar"></i>Hoạt động mới</h3>
                    </div>
                    <div class="au-task js-list-load au-task--border">
                        <div class="au-task-list js-scrollbar3">
                            <div class="au-task__item au-task__item--danger">
                                <div class="au-task__item-inner">
                                    <h5 class="task">
                                        <a href="#">Bạn có đơn hàng mới chưa xác nhận!</a>
                                    </h5>
                                </div>
                            </div>
                            <div class="au-task__item au-task__item--warning">
                                <div class="au-task__item-inner">
                                    <h5 class="task">
                                        <a href="#">Create new task for Dashboard</a>
                                    </h5>
                                    <span class="time">11:00 AM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
