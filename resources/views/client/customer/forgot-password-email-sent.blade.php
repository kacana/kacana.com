@extends('layouts.client.master')

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('/images/client/homepage/account-cover.jpg');">
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
                        Đã gửi email
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
                                Chúng tôi đã gửi một email đến <span class="color-green">chicuongnguyenit@gmail.com</span> với một liên kết để đặt lại mật khẩu của bạn.
                            </p>
                            <p>
                                Nếu bạn có thắc mắc nào về kacana.vn, xin vui lòng liên hệ bộ phận <a href="/contact/thong-tin-lien-he" >Chăm sóc khách hàng</a> của Kacana.
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