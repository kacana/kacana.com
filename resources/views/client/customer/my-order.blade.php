@extends('layouts.client.master')
@section('meta-title', 'Đơn hàng của tôi')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('/images/client/homepage/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Xin chào {{$user->name}}!</h2>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="customer-page" >
        <div class="page-header-simple" >
            <div class="container">
                <div class="row" >
                    <div class="col-xs-12">
                        ĐƠN HÀNG CỦA TÔI
                    </div>
                </div>
            </div>
        </div>
        <div id="customer-my-order-page" class="container background-white vpadding-10" >
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Trong mục quản lý đơn hàng, bạn có thể xem các thông tin về đơn hàng của bạn. Chọn một đơn hàng bên dưới để kiểm tra chi tiết tình trạng đơn hàng.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h5>
                                Danh sách đơn hàng
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 vpadding-10">
                            @if(count($user->order))
                                @foreach($user->order as $order)
                                    <div class="row order-item">
                                        <div class="col-xs-12">
                                            <div class="panel-group" id="accordion">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a aria-expanded="false" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-order-item-{{$order->id}}">
                                                                <div class="col-xs-8 col-sm-4 col-md-3 col-lg-3 column-field-order">
                                                                    <div>
                                                                        ĐƠN HÀNG # <span class="color-green" >{{$order->id}}</span>
                                                                    </div>
                                                                    <p>
                                                                        Đặt ngày {{date('d/m/Y', strtotime($order->created))}}
                                                                    </p>
                                                                </div>
                                                                <div class="hidden-xs col-sm-4  col-md-3 col-lg-3 column-field-order">
                                                                    <div>THÀNH TIỀN</div>
                                                                    <p>
                                                                        {{formatMoney($order->total)}}
                                                                    </p>
                                                                </div>
                                                                <div class="hidden-xs hidden-sm col-md-3 col-lg-3 column-field-order">
                                                                    <div>THANH TOÁN</div>
                                                                    <p>
                                                                        Thanh toán khi nhận hàng
                                                                    </p>
                                                                </div>
                                                                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3 column-5">
                                                                    <div class="color-green text-center" >Chi tiết <i class="fa fa-angle-double-right"></i></div>
                                                                </div>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div aria-expanded="false" id="collapse-order-item-{{$order->id}}" class="accordion-body collapse" style="">
                                                        <div class="panel-body">
                                                            @foreach($order->orderDetail as $orderDetail)
                                                                <div class="order-detail-item row border-bottom vpadding-10">
                                                                    <div class="col-xs-3 col-xss-12">
                                                                        <img style="max-width: 100px;" class="img-responsive" src="{{$orderDetail->image}}">
                                                                    </div>
                                                                    <div class="col-xs-9 col-xxs-12">
                                                                        <div>
                                                                           {{$orderDetail->name}}
                                                                        </div>
                                                                        <div>
                                                                            Số lượng: {{$orderDetail->quantity}}
                                                                        </div>
                                                                        @if($orderDetail->color_id)
                                                                            <div>
                                                                                Màu sắc: {{$orderDetail->color->name}}
                                                                            </div>
                                                                        @endif

                                                                        @if($orderDetail->size_id)
                                                                            <div>
                                                                                Kích thước: {{$orderDetail->size->name}}
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <a target="_blank" href="/khach-hang/kiem-tra-don-hang/{{$order->id}}">Kiểm tra hành trình đơn hàng</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    Bạn chưa có đơn hàng nào! <a href="/">Shopping ngay</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    @include('client.customer.customer-nav')
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')
    Kacana.customer.account.init();
@stop
@section('section-modal')

@stop