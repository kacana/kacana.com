@extends('layouts.client.master')

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('{{AWS_CDN_URL}}/images/client/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Kacana hiểu rằng bạn là người xinh đẹp nhất!</h2>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="contact-page" >
        <div class="page-header-simple" >
            <div class="container">
                <div class="row" >
                    <div class="col-xs-12">
                        HỖ TRỢ KHÁCH HÀNG
                    </div>
                </div>
            </div>
        </div>
        <div class="container background-white vpadding-20">

            <div class="row">
                <div class="col-md-9 col-xs-12 margin-bottom">
                    @if($page == 'intro')
                        @include('client.contact.introduction')
                    @elseif($page == 'contact-information')
                        @include('client.contact.contact-information')
                    @elseif($page == 'return-rule')
                        @include('client.contact.return-rule')
                    @elseif($page == 'buy-guide')
                        @include('client.contact.buy-guide')
                    @elseif($page == 'company-rule')
                        @include('client.contact.company-rule')
                    @elseif($page == 'payment-rule')
                        @include('client.contact.payment-rule')
                    @elseif($page == 'shipping-rule')
                        @include('client.contact.shipping-rule')
                    @elseif($page == 'privacy-rule')
                        @include('client.contact.privacy-rule')
                    @elseif($page == 'customer-rule')
                        @include('client.contact.customer-rule')
                    @elseif($page == 'contact-us')
                        @include('client.contact.contact-us')
                    @elseif($page == 'sale-with-us')
                        @include('client.contact.sale-with-us')
                    @elseif($page == 'get-money-with-us')
                        @include('client.contact.get-money-with-us')
                    @endif
                </div>

                <div class="col-md-3 col-xs-12">
                    <aside class="sidebar">
                        <h4 class="color-green" >Hỗ trợ</h4>
                        <ul class="nav nav-list primary push-bottom">
                            <li><a @if($page == 'intro') class="color-green" @endif href="/contact/gioi-thieu">Giới thiệu</a></li>
                            <li><a @if($page == 'contact-information') class="color-green" @endif href="/contact/thong-tin-lien-he">Thông tin liên hệ</a></li>
                            <li><a @if($page == 'return-rule') class="color-green" @endif href="/contact/che-do-bao-hanh">Chính sách đổi/trả hàng và hoàn tiền</a></li>
                            <li><a @if($page == 'buy-guide') class="color-green" @endif href="/contact/huong-dan-mua-hang">Hướng dẫn mua hàng</a></li>
                            <li><a @if($page == 'company-rule') class="color-green" @endif title="Chính sách & Quy định chung" href="/contact/quy-dinh-chung">Chính sách & Quy định chung</a></li>
                            <li><a @if($page == 'payment-rule') class="color-green" @endif title="Quy định và hình thức thanh toán" href="/contact/hinh-thuc-thanh-toan">Quy định và hình thức thanh toán</a></li>
                            <li><a @if($page == 'shipping-rule') class="color-green" @endif title="Chính sách vận chuyển/giao nhận/cài đặt" href="/contact/chinh-sach-van-chuyen">Chính sách vận chuyển/giao nhận/cài đặt</a></li>
                            <li><a @if($page == 'privacy-rule') class="color-green" @endif href="/contact/chinh-sach-bao-mat">Chính sách bảo mật thông tin</a></li>
                            <li><a @if($page == 'customer-rule') class="color-green" @endif href="/contact/chinh-sach-khach-hang">Chính sách tích luỹ cho thành viên</a></li>
                            <li><a @if($page == 'sale-with-us') class="color-green" @endif href="/contact/ban-hang-voi-chung-toi">Bán hàng cùng KACANA</a></li>
                            <li><a @if($page == 'get-money-with-us') class="color-green" @endif href="/contact/kiem-tiem-voi-chung-toi"><b class="color-red">Kiếm tiền với chúng tôi</b></a></li>
                        </ul>
                    </aside>
                </div>
            </div>

        </div>
    </div>
@stop

@section('javascript')
    Kacana.contact.gmapInit();
@stop
@section('section-modal')

@stop