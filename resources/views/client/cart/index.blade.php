@extends('layouts.client.master')

@section('meta-title', 'Giỏ hàng')

@section('content')
    <div role="main" id="cart-page">
        <section class="header-page-title">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a class="back-to-continue" href="#" onclick="history.go(-1)">
                            <i class="fa fa-angle-left"></i>  Tiếp tục mua hàng
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <div data-spm="breadcrumb" class="breadcrumb_list breadcrumb_custom_cls" data-spm-max-idx="2">
            <div class="container">
                <div class="row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb_item">
                        <span class="breadcrumb_item_text">
                            <a title="Trang chủ" href="/" class="breadcrumb_item_anchor">
                               <span>Trang chủ</span>
                            </a>
                            <div class="breadcrumb_right_arrow"><i class="fa fa-angle-right"></i></div>
                        </span>
                        </li>
                        <li class="breadcrumb_item">
                        <span class="breadcrumb_item_text">
                            <span class="breadcrumb_item_anchor breadcrumb_item_anchor_last">Giỏ hàng</span>
                        </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container vpadding-20 background-white">
            <div class="border-bottom margin-bottom" >
                <div class="row" >
                    <div id="cart-empty-error" class="col-xs-12 col-sm-12 text-center" >
                        <div class="color-grey-light" >Oop..!</div>
                        <div class="color-grey-light" >Giỏ hàng của bạn trống trơn !!!</div>
                        <div class="color-grey-light" >Kacana với hơn 100.000 sản phẩm tuyệt vời đang chờ bạn <a href="/" >Shopping</a></div>
                    </div>
                </div>
                <div id="block-information-payment-cart" class="hide col-xs-12 alert-signup-user">
                    Nếu muốn sử dụng điểm tích lũy, bạn bấm <a href="/checkout?step=login" ><span class="color-green">Thanh Toán</span></a> và ĐĂNG NHẬP vào hệ thống.<br>
                    Bạn có thể sử dụng điểm tích lũy cho đợt mua sắm lần tới. 1 điểm = 500 VNĐ.
                </div>
                <div class="row">
                    <div id="list-cart-item" class="col-xs-12 col-sm-8" >

                    </div>
                    <div class="col-xs-12 col-sm-4" >
                        <div id="cart-information" class="cart-information-basic">

                        </div>
                        <div class="hide" id="block-action-cart-button" >
                            @if(isset($phoneQuickOrderNumber))
                                <div class="col-xs-12 quick-order-block">
                                    <form method="post" id="quick_order_form" data-phone="{{$phoneQuickOrderNumber}}" action="/checkout/processQuickOrder" >
                                        <h5 class="product-information-head">
                                            Đặt hàng ngay chỉ cần để lại SĐT
                                        </h5>
                                        <input id="phoneQuickOrderNumber" name="phoneQuickOrderNumber" placeholder="Nhập số điện thoại" type="text" >
                                        <button type="submit" class="btn btn_kacana_main order-product-with-phone" id="order-product-with-phone">
                                           Xác nhận đặt hàng
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="row" >
                                    <div class="col-xs-12 margin-bottom">
                                        <a class="btn btn_kacana_main" id="payment" href="/checkout?step=login">Thanh Toán</a>
                                        <div class="col-xs-12 quick-order-block">
                                            <form method="post" id="quick_order_form" action="/checkout/processQuickOrder" >
                                                <h5 class="product-information-head">
                                                    Đặt hàng ngay chỉ cần để lại SĐT
                                                </h5>
                                                <input id="phoneQuickOrderNumber" name="phoneQuickOrderNumber" placeholder="Nhập số điện thoại" type="text" >
                                                <button type="submit" class="btn btn_kacana_main order-product-with-phone" id="order-product-with-phone">
                                                   Xác nhận đặt hàng
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        <div class="row" >
            <div class="col-xs-12 col-sm-4">
                <h5 class="color-grey text-tranform-none" >Khi nào tôi nhận được hàng?</h5>
                <p >
                    Thời gian giao hàng dự kiến là thời gian được tính từ lúc đơn hàng được tạo đến lúc giao đến địa chỉ của quý khách.
                    Thời gian này bao gồm thời gian duyệt đơn hàng, thực hiện đơn hàng, cộng với thời gian giao hàng sau khi chuyển đơn hàng qua đơn hàng vận chuyển.
                </p>
            </div>
            <div class="col-xs-12 col-sm-4">
                <h5 class="color-grey text-tranform-none" >Kacana có những hình thức thanh toán nào?</h5>
                <p >
                    Nhằm mang đến trải nghiệm mua sắm tuyệt vời nhất cho khách hàng, kacana cung cấp nhiều hình thức thanh toán đa dạng sau: Thanh toán khi nhận hàng; Thanh toán qua thẻ tín dụng, thẻ ghi nợ; Thanh toán qua cổng Smartlink/ 123PAY; Thanh toán trả góp qua thẻ tín dụng.
                </p>
            </div>
            <div class="col-xs-12 col-sm-4">
                <h5 class="color-grey text-tranform-none" >Quyền lợi của tôi được kacana bảo vệ như thế nào?</h5>
                <p >
                    kacana cam kết tất cả sản phẩm bán ra là mới 100%, chính hãng, không hư hỏng kỹ thuật hay vật lý.
                    Trong trường hợp sản phẩm không đáp ứng được 1 trong các điều kiện trên, quý khách có thể hoàn trả sản phẩm trong vòng 7 ngày để được hoàn tiền 100%.
                </p>
            </div>
        </div>
    </div>
    </div>
    <!-- confirm modal -->
    <div id="confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Xoá sản phẩm ra khỏi giỏ hàng</h4>
                </div>

                <div class="modal-body">
                    Bạn thật sự muốn xoá sản phẩm này ra khỏi giỏ hàng?
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>

            </div>
        </div>
    </div>
@stop

@section('javascript')
    Kacana.cart.init();
    Kacana.facebookPixel.addToCart({{isset($cart->total)?$cart->total:0}},"{{isset($cart->productIds)?implode(", ", $cart->productIds):0}}");
@stop

@section('section-modal')
    @include('client.cart.modal')
@stop

@section('google-param-prodid', isset($cart->productIds)?implode(", ", $cart->productIds):0)
@section('google-param-pagetype', 'cart')
@section('google-param-totalvalue', isset($cart->total)?$cart->total:0)

