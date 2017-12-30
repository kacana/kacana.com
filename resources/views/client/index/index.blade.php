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
                                <h3>TÚI XÁCH MỚI</h3>
                            </div>
                            <div class="row">
                                <h5>Những mẫu túi xách đẹp mới lên kệ tại KACANA</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container taglist background-white" >
                    <div class="row">
                        @foreach($newest as $item)
                            <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-4 product-item" >
                                @include('client.product.product-item-temple')
                            </div>
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
                                <h4>TÚI XÁCH KHUYẾN MÃI</h4>
                            </div>
                            <div class="row">
                                <h5>Túi xách đang khuyến mãi hấp dẫn tại KACANA</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container taglist background-white" >
                    <div class="row">
                        @foreach($discount as $item)
                            <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-4 product-item" >
                                @include('client.product.product-item-temple')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @if(count($discount) >= KACANA_HOMEPAGE_ITEM_PER_TAG)
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
            @endif
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
                                <h4>{{$block['tag']}}</h4>
                            </div>
                            <div class="row">
                                <h5>@if($block['short_desc']){{$block['short_desc']}}@else Danh sách {{ $block['tag']}} của KACANA! @endif</h5>
                            </div>
                        </div>
                        <div class="show-all col-xs-12 col-sm-4" >
                            <a href="{{urlTagProduct($block)}}">Xem tất cả <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container taglist background-white" >
                    <div class="row">
                        @if(count($block['products'])>0)
                            @foreach($block['products'] as $item)
                                <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-4 product-item" >
                                    @include('client.product.product-item-temple')
                                </div>
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
