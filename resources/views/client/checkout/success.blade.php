@extends('layouts.client.master')
<?php
    $user = $order->user;
    $orderDetail = $order->orderDetail;
    $address = $order->addressReceive;
    $city = $address->city;
    $ward = $address->ward;
    $district = $address->district;
?>
@section('meta-title', 'Đã đặt hàng')
@section('content')
    <div role="main" id="checkout-success-page">
        <div id="header-page"  >
            <div class="container" >
                <h1>
                   <i class="glyphicon glyphicon-ok"></i> Đơn hàng của quý khách đã được đặt thành công với thời gian dự kiến giao hàng từ 5 - 10 ngày làm việc (tùy khu vực giao hàng)
                </h1>
            </div>
        </div>
        <div role="main" id="cart-page">
            <div class="container background-white vpadding-20">
                <div class="row">
                    <div class="col-sm-12 text-center" >
                            <img class="vpadding-10" src="{{AWS_CDN_URL}}/images/client/thanks.gif  " />
                        <h2>Cảm ơn quý khách đã đặt hàng tại kacana</h2>
                    </div>
                </div>
                <div class="payment_desc">
                    <p class="color-red" ><b>Chi tiết đơn hàng #{{$order->order_code}}, {{$order->quantity}} sản phẩm được đặt</b></p>
                </div>
                <div class="row">
                    <div class="col-sm-8" >
                        <div class="row">
                            <div id="list-cart-item" class="col-xs-12 col-sm-12" >
                                <div class="cart-header" >
                                    <div class="row" >
                                        <div class="col-xs-3 col-sm-3" >
                                            <h5 class="color-grey-light">Sản phẩm</h5>
                                        </div>
                                        <div class="col-xs-5 col-sm-7" >
                                            <h5 class="color-grey-light">Chi tiết</h5>
                                        </div>
                                        <div class="col-xs-2 col-sm-2" >
                                            <h5 class="color-grey-light text-center">Giá</h5>
                                        </div>
                                    </div>
                                </div>
                                @foreach($orderDetail as $item)
                                    <div class="cart-item" >
                                        <div class="row" >
                                            <div  class="col-xs-3 col-sm-3" >
                                                <a target="_blank" href="{{$item->product_url}}" >
                                                    <img style="max-height: 100px" class="img-responsive" src="{{$item->image}}">
                                                </a>
                                            </div>
                                            <div class="col-xs-5 col-sm-7" >
                                                <div class="cart-item-title" >
                                                    <a target="_blank" href="{{$item->product_url}}" >{{$item->name}}</a>
                                                </div>

                                                @if($item->color_id)
                                                    <div class="cart-item-color">
                                                        Màu sắc: {{$item->color->name}}
                                                    </div>
                                                @endif

                                                @if($item->size_id)
                                                    <div class="cart-item-size" >
                                                        Kích thước: {{$item->size->name}}
                                                    </div>
                                                @endif

                                                <div class="cart-item-price" >
                                                    Giá: {{formatMoney($item->price)}}
                                                </div>
                                                @if($item->discount)
                                                    <div class="cart-item-price" >
                                                        Giảm giá: <b>{{formatMoney($item->discount)}}</b>
                                                    </div>
                                                @elseif($item->discount_type)
                                                    @if($item->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                                        <div class="cart-item-price" >
                                                            Tặng <a target="_blank" class="color-red" href="{{urlProductDetail($item->discountProductRef)}}">
                                                                {{$item->discountProductRef->name}}
                                                                <img style="width: 50px;" src="{{$item->discountProductRef->image}}"></a>
                                                        </div>
                                                    @else
                                                        <div class="cart-item-price" >
                                                            Giảm giá: <span class="color-red" >{{savingDiscount($item->discount_type, $item->discount_ref,$item->price)}}</span>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="cart-item-price" >
                                                    Số lượng: {{$item->quantity}}
                                                </div>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 text-center" >
                                                {{formatMoney($item->subtotal)}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="order-total-info vpadding-10">
                                    <div><b>Thành tiền (đã bao gồm thuế)</b> <b class="pull-right color-red" >{{formatMoney($order->total)}}</b> </div>
                                    @if(!$order->shipping_fee)
                                        <div>Miễn phí vận chuyển(chỉ thanh toán {{formatMoney($order->total)}} khi nhận hàng)</div>
                                    @else
                                        <div>Phí vận chuyển: <b>{{formatMoney($order->shipping_fee)}}</b><br>(chỉ thanh toán {{formatMoney($order->total)}} khi nhận hàng)</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" >
                        <h5 class="color-grey-light">Đơn hàng sẽ được giao đến</h5>
                        <div class="order-user-info">
                            <div class="color-green vpadding-10"><b>{{$user->name}}</b></div>
                            <div>{{$address->street}}, {{$district->name}}, {{$city->name}}</div>
                            <div>Số điện thoại: {{$address->phone}}</div>
                            <div class="vpadding-10"><b>Thư xác nhận đã được gởi</b> tới địa chỉ email {{$user->email}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="description-cash-deliver">
            <div class="container background-white vpadding-20" >
                <div class="payment_desc">
                    <p><b>Thanh toán khi nhận hàng</b></p>
                    <p>1. Kacana.com sẽ không gửi tin nhắn xác nhận đơn hàng đến quý khách. Nếu quý khách có nhu cầu xem lại thông tin mua hàng, vui lòng kiểm tra xác nhận đơn hàng đã được gửi qua email.</p>
                    <p>2. Thời gian giao hàng dự kiến sẽ được cập nhật liên tục qua email và tin nhắn điện thoại. Quý khách hoàn toàn kiểm tra được tình trạng đơn hàng tại  <a style="color: #2dc8d9;" href="{{url()}}/khach-hang/kiem-tra-don-hang" target="_blank">{{url()}}/khach-hang/kiem-tra-don-hang</a></p>
                    {{--<p>3. Khi có nhu cầu thay đổi quyết định mua sắm, quý khách có thể hủy đơn hàng trực tuyến với hướng dẫn đơn giản tại  <a style="color: #2dc8d9;" href="https://www.kacana.com/huong-dan-huy-don-hang-truc-tuyen/" target="_blank"> www.kacana.com/huong-dan-huy-don-hang-truc-tuyen/</a> </p>--}}
                    <p>3. Quý khách cũng có thể tham khảo một số câu hỏi thường gặp tại  <a style="color: #2dc8d9;" href="https://www.kacana.com/FAQ/" target="_blank">www.kacana.com/FAQ/</a></p>
                    <p>4. Nếu quý khách có nhu cầu xuất hóa đơn, quý khách vui lòng liên hệ hotline <b>0906.054.206</b> hoặc gửi thông tin chi tiết (tên công ty, địa chỉ công ty, mã số thuế) tới <a style="color: #2dc8d9;" href="https://www.kacana.com/contact/" target="_blank">www.kacana.com/contact/</a> trong vòng 24 giờ kể từ khi đặt hàng thành công.</p>
                    <p><b>Lưu ý:</b> Đơn hàng của quý khách có thể sẽ được giao thành nhiều kiện nếu các sản phẩm được nhập về trong các kiện hàng khác nhau. </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    Kacana.facebookPixel.purchase({{$order->total}}, "{{implode(", ",getProductIdsFromOrder($orderDetail))}}");
@stop

@section('section-modal')
    @include('client.product.modal')
@stop

@section('google-param-prodid', implode(", ",getProductIdsFromOrder($orderDetail)))
@section('google-param-pagetype', 'purchase')
@section('google-param-totalvalue', $order->total)