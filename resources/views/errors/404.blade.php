
@extends('layouts.client.master')

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('{{AWS_CDN_URL}}/images/client/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Ối - Chời bơi ơi!</h2>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="error-page" >
        @if(\Kacana\Util::isDevEnvironment())
            <div id="error-404-page" class="container background-white vpadding-10" >
                <div class="col-xs-12">
                  {!! createResponseExc($error_message) !!}
                </div>
            </div>
        @else
            <div id="error-404-page" class="container background-white vpadding-10" >
                <div class="col-xs-12 col-sm-7 col-lg-7">
                    <!-- Info -->
                    <div class="info">
                        <h1 style="font-size: 150px;font-weight: 500;color: #4caf50">404</h1>
                        <h2>Xin lỗi chúng tôi không thể tìm thấy trang bạn yêu cầu</h2>
                        <p>Có vẻ như các trang mà bạn đang cố gắng tiếp cận không tồn tại nữa hoặc có thể nó vừa di chuyển. Nếu bạn đang tìm kiếm một sản phẩm, hãy thử tìm kiếm nâng cao hơn.</p>
                        <a href="/" class="btn">Trang chủ</a>
                        <a href="/contact/thong-tin-lien-he" class="btn btn-brown">Liện hệ với chúng tôi</a>
                    </div>
                    <!-- end Info -->
                </div>

                <div class="col-xs-12 col-sm-5 col-lg-5 text-center">
                    <!-- Monkey -->
                    <div class="monkey">
                        <img class="img-responsive" src="/images/client/homepage/monkey.gif" alt="Monkey">
                    </div>
                    <!-- end Monkey -->
                </div>
            </div>
        @endif
    </div>
@stop

@section('javascript')
@stop
@section('section-modal')

@stop