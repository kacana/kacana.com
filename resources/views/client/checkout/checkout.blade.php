@extends('layouts.client.master')

@section('content')
    <div role="main" id="checkout-page">
        <div id="step-line" class="step-process-line-kacana border-bottom background-body-header  vpadding-10"  >
            <div class="container" >
                <div class="row">
                    <section>
                        <div class="wizard">
                            <div class="wizard-inner">
                                <ul class="nav nav-tabs" role="tablist">

                                    <li role="presentation" @if($step == 'login') class="active col-xs-4" @else class="passed  col-xs-4" @endif>
                                        <span class="name-step">Email</span>
                                        <a href="/checkout?step=login" title="login">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-user"></i>
                                            </span>
                                        </a>
                                    </li>

                                    <li role="presentation" @if($step == 'login') class="disabled col-xs-4" @elseif($step == 'address' || $step == 'choose-address') class="active col-xs-4" @endif>
                                        <span class="name-step">Địa chỉ</span>
                                        <a href="/checkout?step=address" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-map-marker"></i>
                                            </span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="disabled col-xs-4">
                                        <span class="name-step">Hoàn thành</span>
                                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
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
            </div>
        </div>
        <div class="container vpadding-20 background-white" >
            <h4 class="color-grey bold">
                @if($step == 'login')
                    Đăng nhập hoặc Đặt hàng không cần đăng ký
                @elseif($step == 'address')
                    Địa chỉ giao hàng của quý khách
                @elseif($step == 'choose-address')
                    Chọn một địa chỉ có sẵn hoặc thêm địa chỉ mới
                @elseif($step == 'success')
                    Đơn hàng của quý khách đã được đặt thành công với thời gian dự kiến giao hàng từ 5 - 10 ngày làm việc (tùy khu vực giao hàng)
                @endif
            </h4>
            <div class="row" >
                <div class="col-xs-12 col-sm-8" >
                    @if($step == 'login')
                        @include('client.checkout.login')
                    @elseif($step == 'address')
                        @include('client.checkout.address')
                    @elseif($step == 'payment')
                        @include('client.checkout.success')
                    @elseif($step == 'choose-address')
                        @include('client.checkout.choose-address')
                    @endif

                </div>
                <div id="cart-information" data-cart-total="{{$cart->total}}" class="col-xs-12 col-sm-4 cart-information-basic">
                    <div class="border-bottom margin-bottom">
                        <div class="row">
                            <div class="col-xs-12">
                                <h5> Thông tin đơn hàng </h5>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom margin-bottom">
                        <div class="row">
                            <div class="col-xs-12 margin-bottom">
                                @foreach($cart->items as $item)
                                    <div class="row cart-item-simple">
                                        <div class="col-xs-8">
                                            {{$item->name}}
                                            @if(isset($item->options->colorId))
                                                - {{$item->options->colorName}}
                                            @endif
                                            @if(isset($item->options->sizeId))
                                                - {{$item->options->sizeName}}
                                            @endif
                                        </div>
                                        <div class="col-xs-4 text-right" >
                                            {{formatMoney($item->subTotal)}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-xs-12 margin-bottom">
                                <span class="pull-left"> Phí vận chuyển <a href="/contact/chinh-sach-van-chuyen" target="_blank"  ><i class="fa fa-info-circle"></i></a></span>
                                @if(intval($cart->total) >= 500000)
                                    <span class="pull-right"> miễn phí </span>
                                @else
                                    <span id="checkout-label-ship-fee" class="pull-right text-red text-right">Hồ Chí Minh: 15.000 đ <br> Khác: 30.000 đ</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 margin-bottom">
                            <span class="pull-left">
                                <h5>Thành tiền</h5>
                                    (Đã bao gồm VAT)
                            </span>
                            <span class="pull-right">
                                <h5 id="checkout-cart-total" class="cart-totals">
                                    {{$cart->totalShow}}
                                    @if(intval($cart->total) < 500000)
                                        <small class="text-red" >+ Ship</small>
                                    @endif
                                </h5>
                            </span>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-xs-12 margin-bottom">
                            <span class="color-red" >phương thức thanh toán:</span> Quý khách sẽ thanh toán bằng tiền mặt khi nhận hàng tại nhà
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    Kacana.checkout.init();
@stop
@section('section-modal')
    @include('client.product.modal')
@stop

@section('google-param-prodid', implode(", ",$cart->productIds))
@section('google-param-pagetype', 'cart')
@section('google-param-totalvalue', $cart->total)
