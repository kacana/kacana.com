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
                    @elseif($page == 'privacy-rule')
                        @include('client.contact.privacy-rule')
                    @elseif($page == 'customer-rule')
                        @include('client.contact.customer-rule')
                    @elseif($page == 'sale-with-us')
                        @include('client.contact.sale-with-us')
                    @endif
                </div>

                <div class="col-md-3 col-xs-12">
                    <aside class="sidebar">
                        <h4 class="color-green" >Trợ Giúp</h4>
                        <ul class="nav nav-list primary push-bottom">
                            <li><a @if($page == 'intro') class="color-green" @endif href="/contact/gioi-thieu">Giới thiệu</a></li>
                            <li><a @if($page == 'contact-information') class="color-green" @endif href="/contact/thong-tin-lien-he">Thông tin liên hệ</a></li>
                            <li><a @if($page == 'return-rule') class="color-green" @endif href="/contact/chinh-sach-doi-hang">Chính sách đổi hàng</a></li>
                            <li><a @if($page == 'privacy-rule') class="color-green" @endif href="/contact/chinh-sach-bao-mat">Chính sách bảo mật</a></li>
                            <li><a @if($page == 'customer-rule') class="color-green" @endif href="/contact/chinh-sach-khach-hang">Chính sách cho khách hàng</a></li>
                            <li><a @if($page == 'sale-with-us') class="color-green" @endif href="/contact/ban-hang-voi-chung-toi">Bán hàng cùng KACANA</a></li>
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