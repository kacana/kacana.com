@extends('layouts.client.master')

@section('top-infomation')
    @include('layouts.client.slide')
@stop
@section('content')
<div id="homepage" >
    @if(count($newest)>0)
        <div class="block-tag" >
            <div class="block-tag-header homepage" >
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12" >
                            <div class="row">
                                <span class="col-xs-12 tag-name">SẢN PHẨM MỚI</span>
                            </div>
                            <div class="row">
                                <span class="col-xs-12 tag-sub-name">Những sản phẩm dành cho tín đồ thời trang mới lên kệ tại KACANA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container background-white" >
                    <div class="row">
                        @foreach($newest as $item)
                            @include('client.product.product-item-temple')
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container background-white" >
                <div class="row">
                    <div class="col-xs-12 text-center" >
                        <a class="btn-see-more-product" href="#load-more-product-with-type" data-page="2" data-type="{{PRODUCT_HOMEPAGE_TYPE_NEWEST}}" >
                            <span data-type="" >
                                <p>Xem tiếp</p>
                                <i class="pe-7s-close pe-2x pe-va"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(count($discount)>0)
        <div class="block-tag" >
            <div class="block-tag-header homepage" >
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8" >
                            <div class="row">
                                <span class="col-xs-12 tag-name">SẢN PHẨM KHUYẾN MÃI</span>
                            </div>
                            <div class="row">
                                <span class="col-xs-12 tag-sub-name">Những sản phẩm đang khuyến mãi hấp dẫn tại KACANA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container background-white" >
                    <div class="row">
                        @foreach($discount as $item)
                            @include('client.product.product-item-temple')
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container background-white" >
                <div class="row">
                    <div class="col-xs-12 text-center" >
                        <a class="btn-see-more-product" href="#load-more-product-with-type" data-page="2" data-type="{{PRODUCT_HOMEPAGE_TYPE_DISCOUNT}}" >
                            <span data-type="" >
                                <p>Xem tiếp</p>
                                <i class="pe-7s-close pe-2x pe-va"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(count($items)>0)
        @foreach($items as $block)
        <div class="block-tag" >
            <div class="block-tag-header homepage" >
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8" >
                            <div class="row">
                                <span class="col-xs-12 tag-name">{{$block['tag']}}</span>
                            </div>
                            <div class="row">
                                <span class="col-xs-12 tag-sub-name">@if($block['short_desc']){{$block['short_desc']}}@else Danh sách {{ $block['tag']}} của KACANA! @endif</span>
                            </div>
                        </div>
                        <div class="show-all col-xs-12 col-sm-4" >
                            <a href="{{urlTagProduct($block)}}">Xem tất cả <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container background-white" >
                    <div class="row">
                        @if(count($block['products'])>0)
                            @foreach($block['products'] as $item)
                                @include('client.product.product-item-temple')
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

@stop

@section('javascript')
    Kacana.homepage.init();
@stop

@section('section-modal')
    @include('client.partials.popup-modal')
@stop

@section('google-param-prodid', implode(", ",getProductIds($newest)))
