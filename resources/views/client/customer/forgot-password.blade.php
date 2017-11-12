@extends('layouts.client.master')
@section('meta-title', 'Quên mật khẩu')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="{{KACANA_URL_BACKGROUND_BANNER_DEFAULT}}');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Quên mật khẩu</h2>
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
                        Bạn quên mật khẩu ?
                    </div>
                </div>
            </div>
        </div>
        <div id="customer-forgot-password-page" class="container background-white vpadding-10" >
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Nhập địa chỉ email của bạn dưới đây và chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                            <form id="form-forgot-password" method="post" action="/khach-hang/quen-mat-khau" class="form-horizontal form-bordered view-type">
                                <div class="form-group">
                                    <label for="inputDisabled" class="col-md-2 control-label">Email</label>
                                    <div class="col-md-4">
                                        <input type="text" value="" placeholder="nhập email của bạn!" name="email" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-2 vpadding-10">
                                        <button type="submit" class="btn kacana-button-green">Gửi</button>
                                    </div>
                                    <div class="col-md-2 vpadding-10">
                                        <a type="button" href="/" class="btn">Quay lại mua hàng</a>
                                    </div>
                                </div>

                            </form>
                            </p>
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
    Kacana.customer.forgot.init();
@stop
@section('section-modal')

@stop