@extends('layouts.client.master')
@section('meta-title', 'Kiểm tra đơn hàng')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('/images/client/homepage/shipping-cover.jpg');">
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
    <div id="customer-page" >
        <div class="page-header-simple" >
            <div class="container">
                <div class="row" >
                    <div class="col-xs-12">
                        KIỂM TRA ĐƠN HÀNG
                    </div>
                </div>
            </div>
        </div>
        <div class="container background-white" >
            <div class="row">
                <div class="col-xs-12 vpadding-10">
                    <p>
                        Chào mừng các bạn đã đến với trang Kiểm tra đơn hàng của Kacana Việt Nam!
                    </p>
                    <p>
                        Các bạn vui lòng nhập địa chỉ email và mã số đơn hàng để kiểm tra tình trạng đơn hàng của mình. Các bạn có thể kiểm tra email xác nhận đơn hàng từ Kacana để tìm mã số đơn hàng.
                    </p>
                    <p>
                        Nếu quý khách có bất kỳ thắc mắc nào, xin vui lòng liên hệ: 0906.054.206
                    </p>
                </div>
            </div>
            @if(isset($error_message) && $error_message)
                <div class="alert alert-danger" role="alert">
                    {!! $error_message !!}
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 vpadding-10">
                    <form id="form-checking-tracking-order" method="post" action="/khach-hang/kiem-tra-don-hang" class="form-horizontal form-bordered">
                        <div class="form-group">
                            <label for="inputDefault" class="col-md-2 color-green control-label">Mã số đơn hàng</label>
                            <div class="col-md-4">
                                <input type="text" @if(isset($orderCode) && $orderCode) value="{{$orderCode}}" @endif placeholder="Ví dụ: 25251325" name="orderCode" class="form-control">
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label for="inputDisabled" class="col-md-2 control-label">Email đăng ký đặt hàng</label>--}}
                            {{--<div class="col-md-4">--}}
                                {{--<input type="text"  @if(isset($email) && $email) value="{{$email}}" @endif  placeholder="Email" name="email" class="form-control">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-4">
                                <button type="submit" id="check-tracking-order" class="btn btn-warning">Xem ngay</button>
                            </div>
                        </div>

                        @if(\Kacana\Util::isLoggedIn())
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-4 text-center">
                                    <a href="/khach-hang/don-hang-cua-toi" >Đơn hàng của tôi</a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')
    Kacana.customer.trackingOrder.validateForTracking();
@stop
@section('section-modal')

@stop