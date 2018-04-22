@extends('layouts.client.master')
@section('meta-title', 'Hành trình đơn hàng')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5"
             style="background-image: url('/images/client/homepage/shipping-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h1 class="short text-shadow big white bold">nhanh - an toàn - bảo đảm nhất!</h1>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="customer-page">
        <div id="customer-page">
            <div class="page-header-simple">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                           KIỂM TRA ĐƠN HÀNG
                        </div>
                    </div>
                </div>
            </div>
            <div id="detail-tracking-order" class="container vpadding-10 background-white">
                <div class="row">
                    <div class="col-xs-12 col-sm-9 vpadding-10">
                        <div class="row margin-bottom">
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                MÃ ĐƠN HÀNG  #<b>{{$order->order_code}}</b>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                Đặt ngày {{date('H:i d/m/Y', strtotime($order->created_at))}}
                            </div>
                        </div>
                        @foreach($order->orderDetail as $orderDetail)
                            <div class="row order-item">
                                <div class="col-xs-12">
                                    <div id="accordion" class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a href="#collapse-order-item-{{$order->id}}-{{$orderDetail->id}}" data-parent="#accordion" data-toggle="collapse"
                                                       class="accordion-toggle collapsed" aria-expanded="false">
                                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-2 column-1">
                                                            <img src="{{$orderDetail->image}}"
                                                                 class="img-responsive">
                                                        </div>
                                                        <div class="col-xs-5 col-sm-3 col-md-3 col-lg-2 column-2">
                                                            {{$orderDetail->quantity}} sản phẩm
                                                        </div>
                                                        <div class="hidden-xs hidden-sm hidden-md col-lg-4 column-3">
                                                            @if($orderDetail->shipping_service_code !== NULL)
                                                              Dự kiến Giao hàng từ {{date('d/m', strtotime($orderDetail->shipping->expected_delivery_time))}} - {{date('d/m/Y', strtotime("+1 day", strtotime($orderDetail->shipping->expected_delivery_time)))}}
                                                            @else
                                                              Dự kiến Giao hàng từ {{date('d/m', strtotime("+5 day", strtotime($order->created_at)))}} - {{date('d/m/Y', strtotime("+10 day", strtotime($order->created_at)))}}
                                                            @endif
                                                        </div>
                                                        <div class="hidden-xs col-sm-3  col-md-3 col-lg-2 column-4">
                                                            <div>GIAO HÀNG ĐẾN</div>
                                                            @if($orderDetail->shipping_service_code !== NULL)
                                                                <p data-title="{{$orderDetail->shipping->address}}" data-popup-kacana="title" href="#receive-user">
                                                                    <span class="color-green">
                                                                        {{$orderDetail->shipping->receive_name}}
                                                                    </span>
                                                                    <span >
                                                                        <i class="fa fa-question-circle"></i>
                                                                    </span>
                                                                </p>
                                                            @else
                                                                <p data-title="{{$orderDetail->order->addressReceive->street}}, {{$orderDetail->order->addressReceive->district->name}}, {{$orderDetail->order->addressReceive->city->name}}" data-popup-kacana="title" href="#receive-user">
                                                                    <span class="color-green">
                                                                        {{$orderDetail->order->addressReceive->name}}
                                                                    </span>
                                                                    <span >
                                                                        <i class="fa fa-question-circle"></i>
                                                                    </span>
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-3 col-sm-3  col-md-3 col-lg-2 column-5">
                                                            @if($orderDetail->shipping_service_code === NULL)
                                                              <span class="label label-primary" >Đang xử lý</span>
                                                            @elseif($orderDetail->shipping->status == KACANA_SHIP_STATUS_READY_TO_PICK
                                                                        || $orderDetail->shipping->status == KACANA_SHIP_STATUS_STORING
                                                                        || $orderDetail->shipping->status == KACANA_SHIP_STATUS_DELIVERING
                                                                        || $orderDetail->shipping->status == KACANA_SHIP_STATUS_STORE_TO_REDELIVERING)
                                                                <span class="label label-warning" >Đã gửi đi</span>
                                                            @elseif($orderDetail->shipping->status == KACANA_SHIP_STATUS_WAITING_TO_FINISH
                                                                        || $orderDetail->shipping->status == KACANA_SHIP_STATUS_FINISH)
                                                                <span class="label label-success" >Hoàn thành</span>
                                                            @elseif($orderDetail->shipping->status == KACANA_SHIP_STATUS_RETURN
                                                                    || $orderDetail->shipping->status == KACANA_SHIP_STATUS_RETURNED)
                                                                <span class="label label-success" >Đã Trả hàng</span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="accordion-body collapse" id="collapse-order-item-{{$order->id}}-{{$orderDetail->id}}" aria-expanded="false">
                                                <div class="panel-body">
                                                    <div id="step-line" class="step-process-line-kacana">
                                                        <div class="row">
                                                            <section>
                                                                <div class="wizard">
                                                                    <div class="wizard-inner">
                                                                        <ul class="nav nav-tabs" role="tablist">
                                                                            <li role="presentation" class="@if($orderDetail->shipping_service_code === NULL) active @else passed @endif col-xs-4">
                                                                                <span class="name-step">Đang xử lý</span>
                                                                                <a href="#"
                                                                                   title="login">
                                                                                <span class="round-tab">
                                                                                    <i class="fa fa-dropbox"></i>
                                                                                </span>
                                                                                </a>
                                                                            </li>

                                                                            <li role="presentation"
                                                                                @if($orderDetail->shipping_service_code === NULL)
                                                                                    class="disabled col-xs-4"
                                                                                @elseif($orderDetail->shipping->status == KACANA_SHIP_STATUS_READY_TO_PICK
                                                                                || $orderDetail->shipping->status == KACANA_SHIP_STATUS_STORING
                                                                                || $orderDetail->shipping->status == KACANA_SHIP_STATUS_DELIVERING
                                                                                || $orderDetail->shipping->status == KACANA_SHIP_STATUS_STORE_TO_REDELIVERING)
                                                                                    class="active col-xs-4"
                                                                                @else
                                                                                    class="passed col-xs-4"
                                                                                @endif
                                                                            >
                                                                                <span class="name-step">Đã gửi đi</span>
                                                                                <a href="/checkout?step=address"
                                                                                   data-toggle="tab"
                                                                                   aria-controls="step2" role="tab"
                                                                                   title="Step 2">
                                                                                <span class="round-tab">
                                                                                    <i class="fa fa-plane"></i>
                                                                                </span>
                                                                                </a>
                                                                            </li>
                                                                            <li role="presentation"
                                                                                @if($orderDetail->shipping_service_code === NULL
                                                                                || $orderDetail->shipping->status == KACANA_SHIP_STATUS_READY_TO_PICK
                                                                                || $orderDetail->shipping->status == KACANA_SHIP_STATUS_STORING
                                                                                || $orderDetail->shipping->status == KACANA_SHIP_STATUS_DELIVERING
                                                                                || $orderDetail->shipping->status == KACANA_SHIP_STATUS_STORE_TO_REDELIVERING)
                                                                                    class="disabled col-xs-4"
                                                                                @else
                                                                                    class="active col-xs-4"
                                                                                @endif
                                                                            >
                                                                                <span class="name-step">Hoàn thành</span>
                                                                                <a href="#complete" data-toggle="tab"
                                                                                   aria-controls="complete" role="tab"
                                                                                   title="Complete">
                                                                                <span class="round-tab">
                                                                                    <i class="glyphicon glyphicon-ok"></i>
                                                                                </span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                        <h4 class="color-grey vpadding-10" style="margin-bottom: 0" >Chi tiết</h4>
                                                        <div class="row" >
                                                            <div class="col-sm-12" >
                                                                {{date('H:i d/m/Y', strtotime($order->created_at))}} : đã đặt hàng
                                                            </div>
                                                            @if($orderDetail->shipping_service_code !== NULL)
                                                                <div class="col-sm-12" >
                                                                    {{date('H:i d/m/Y', strtotime($orderDetail->shipping->created_at))}} : đã gửi đi - bằng GHN <a target="_blank" href="https://5sao.ghn.vn/Tracking/ViewTracking/{{$orderDetail->shipping->id}}/?">kiểm tra chi tiết</a>
                                                                </div>
                                                            @endif
                                                            <div class="col-sm-12" >
                                                                @if($orderDetail->shipping_service_code !== NULL && ($orderDetail->shipping->status == KACANA_SHIP_STATUS_WAITING_TO_FINISH
                                                                        || $orderDetail->shipping->status == KACANA_SHIP_STATUS_FINISH
                                                                        || $orderDetail->shipping->status == KACANA_SHIP_STATUS_RETURN
                                                                        || $orderDetail->shipping->status == KACANA_SHIP_STATUS_RETURNED))
                                                                    Hoàn thành
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <h4 class="color-grey vpadding-10" style="margin-bottom: 0" >Sản phẩm</h4>
                                                        <a target="_blank" href="{{$orderDetail->product_url}}">{{$orderDetail->name}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xs-12 col-sm-3">
                        @include('client.customer.customer-nav')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

@stop
@section('section-modal')

@stop