@extends('layouts.client.master')

@section('top-infomation')
    @include('layouts.client.slide')
@stop
@section('content')
<div id="homepage" itemscope itemtype="http://schema.org/ItemList">
    @if(count($newest)>0)
        <div class="block-tag" >
            <div class="block-tag-header homepage" >
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12" >
                            <div class="row">
                                <h1>TÚI XÁCH ĐẸP MỚI</h1>
                            </div>
                            <div class="row">
                                <h3>Những mẫu túi xách đẹp mới lên kệ tại KACANA</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container taglist background-white" >
                    <div class="row">
                        @foreach($newest as $item)
                            <div itemprop="itemListElement" itemscope itemtype="http://schema.org/Product" class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
                                @include('client.product.product-item-temple')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container background-white" >
                <div class="row">
                    <div class="col-xs-12 text-center" >
                        <a class="btn-see-more-product" href="#load-more-product-with-type" data-tag-id="0" data-page="2" data-type="{{PRODUCT_HOMEPAGE_TYPE_NEWEST}}" >
                            <span data-type="" >Xem tiếp <i class="pe-7s-plus pe-2x pe-va"></i></span>
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
                                <h2>Túi xách giảm giá</h2>
                            </div>
                            <div class="row">
                                <h3>Túi xách đang khuyến mãi hấp dẫn tại KACANA</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container taglist background-white" >
                    <div class="row">
                        @foreach($discount as $item)
                            <div itemprop="itemListElement" itemscope itemtype="http://schema.org/Product" class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
                                @include('client.product.product-item-temple')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @if(count($discount) >= KACANA_HOMEPAGE_ITEM_PER_TAG)
                <div class="container background-white" >
                    <div class="row">
                        <div class="col-xs-6 text-center" >
                            <a class="btn-see-more-product" href="/khuyen-mai" >
                                <span data-type="" >Tất cả <i class="pe-7s-angle-right-circle pe-2x pe-va"></i></span>
                            </a>
                        </div>
                        <div class="col-xs-6 text-center" >
                            <a class="btn-see-more-product" href="#load-more-product-with-type" data-page="2" data-tag-id="0" data-type="{{PRODUCT_HOMEPAGE_TYPE_DISCOUNT}}" >
                                <span data-type="" >Xem tiếp <i class="pe-7s-plus pe-2x pe-va"></i>
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
                        <div class="col-xs-12" >
                            <div class="row">
                                <h2><a href="{{urlTagProduct($block)}}" >{{mb_strtoupper($block['tag'])}}</a></h2>
                                @foreach($block['sub_tag'] as $subTag)
                                    <a class="sub-tab-header" href="{{urlTag($subTag)}}" >{{mb_strtoupper($subTag->name)}}</a>
                                @endforeach
                            </div>
                            <div class="row">
                                <h3>@if($block['short_desc']){{$block['short_desc']}}@else Danh sách {{ $block['tag']}} của KACANA! @endif</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body" >
                <div class="container taglist background-white" >
                    <div class="row">
                        @if(count($block['products'])>0)
                            @foreach($block['products'] as $item)
                                <div itemprop="itemListElement" itemscope itemtype="http://schema.org/Product" class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
                                    @include('client.product.product-item-temple')
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @if(count($block['products'])>=KACANA_HOMEPAGE_ITEM_PER_TAG)
                <div class="container background-white" >
                    <div class="row">
                        <div class="col-xs-6 text-center" >
                            <a class="btn-see-more-product" href="{{urlTagProduct($block)}}" >
                                <span data-type="" >Tất cả <i class="pe-7s-angle-right-circle pe-2x pe-va"></i></span>
                            </a>
                        </div>
                        <div class="col-xs-6 text-center" >
                            <a class="btn-see-more-product" href="#load-more-product-with-type" data-page="2" data-tag-id="{{$block['tag_id']}}" data-type="{{PRODUCT_HOMEPAGE_TYPE_TAG}}" >
                                <span data-type="" >Xem tiếp <i class="pe-7s-plus pe-2x pe-va"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    @endif

    <div class="block-tag" id="auto-load-more-block" data-tag-id="0" data-page="2" data-type="{{PRODUCT_HOMEPAGE_TYPE_NEWEST}}" >
        <div class="block-tag-header homepage" >
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12" >
                        <div class="row">
                            <h2>TÚI XÁCH BẠN SẼ THÍCH</h2>
                        </div>
                        <div class="row">
                            <h3>Những mẫu túi xách bạn sẽ thích tại KACANA</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-tag-body" >
            <div class="container taglist background-white" >
                <div class="row">

                </div>
            </div>
        </div>
        <div class="container background-white" >
            <div class="row">
                <div class="col-xs-12 text-center" >
                    <span class="auto-loading-icon-processing" ></span>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('javascript')
    Kacana.homepage.init();
    Kacana.facebookPixel.viewProductContent(1000000, "{{implode(", ",getProductIds($newest))}}");
@stop

@section('section-modal')
    @include('client.partials.popup-modal')
@stop

@section('google-param-prodid', implode(", ",getProductIds($newest)))
