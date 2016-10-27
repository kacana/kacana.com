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
        <div class="container vpadding-20 background-white">
            <div class="border-bottom margin-bottom" >
                <h4 class="color-grey bold">Giỏ hàng của tôi</h4>
                <div class="row" >
                    <div id="cart-empty-error" class="col-xs-12 col-sm-12 text-center" >
                        <div class="color-grey-light" >Oop..!</div>
                        <div class="color-grey-light" >Giỏ hàng của bạn trống trơn !!!</div>
                        <div class="color-grey-light" >Kacana với hơn 100.000 sản phẩm tuyệt vời đang chờ bạn <a href="/" >Shopping</a></div>
                    </div>
                </div>
                <div class="row">
                    <div id="list-cart-item" class="col-xs-12 col-sm-8" >

                    </div>
                    <div id="cart-information" class="col-xs-12 col-sm-4 cart-information-basic" >

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
@stop

@section('section-modal')
    @include('client.cart.modal')
@stop

@section('google-param-prodid', implode(", ",$cart->productIds))
@section('google-param-pagetype', 'cart')
@section('google-param-totalvalue', $cart->total)

