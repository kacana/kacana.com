@extends('layouts.client.master')

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('/images/client/homepage/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Xin chào {{$user->name}}!</h2>
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
                        DANH SÁCH YÊU THÍCH
                    </div>
                </div>
            </div>
        </div>
        <div id="customer-product-like-page" class="container background-white vpadding-10" >
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Trong mục danh sách yêu thích, bạn có thể xem tất cả các sản phẩm mà bạn đã bấm lưu. Chọn một link bên dưới để xem chi tiết sản phẩm và đặt mua!.
                            </p>
                        </div>
                    </div>
                    @if(count($user->productLike))
                        @foreach($user->productLike as $productLike)
                            <div class="product-item row border-bottom vpadding-10 hmargin-10">
                                <div class="col-xs-3 col-xss-12">
                                    <img style="max-width: 100px;" class="img-responsive" src="{{$productLike->image}}">
                                </div>
                                <div class="col-xs-9 col-xxs-12">
                                    <div>
                                       <a href="{{$productLike->pivot->product_url}}" target="_blank">{{$productLike->name}}</a>
                                    </div>
                                    <div>
                                        Giá: {{formatMoney($productLike->sell_price)}}
                                    </div>

                                    <div>
                                        Ngày Lưu: {{date('d/m/Y', strtotime($productLike->pivot->created_at))}}
                                    </div>
                                    <div>
                                        <span class="save-product-wrap active" >
                                            <a
                                                data-product-id="{{$productLike->id}}"
                                                data-product-url="{{$productLike->pivot->product_url}}"
                                                href="#remove-product-like"
                                                data-offset="3"
                                                data-distance-away="0"
                                                data-position="bottom left"
                                                data-title="Bỏ lưu sản phẩm này"
                                                data-popup-kacana="title"
                                                class="save-product" >

                                                <i class="pe-7s-like" ></i>
                                                <i class="fa fa-heart" ></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            Bạn chưa lưu sản phâm nào cả nào! Để lưu sản phẩm bấm <i class="pe-7s-like"></i> để lưu sản phẩm bạn thích - <a href="/">Shopping ngay</a>
                        </div>
                    @endif
                </div>
                <div class="col-xs-12 col-sm-3">
                    @include('client.customer.customer-nav')
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')
    Kacana.customer.address.init();
@stop
@section('section-modal')

@stop