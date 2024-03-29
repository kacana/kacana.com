@extends('layouts.client.master')
@section('meta-title', ucfirst($tag->name_seo))
@section('meta-description', $tag->short_desc)
@section('meta-keyword', implode(", ",$tag->tagKeyword))

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('@if($tag->image){{ AWS_CDN_URL.$tag->image}}@else {{ KACANA_URL_BACKGROUND_BANNER_DEFAULT }} @endif');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h1 class="short text-shadow big white bold">{{ $tag->name}}</h1>
                </div>
            </div>
        </div>
    </section>
@stop

@section('breadcrumb')
    @if(isset($breadcrumb) && count($breadcrumb))
        <div data-spm="breadcrumb" class="breadcrumb_list breadcrumb_custom_cls" data-spm-max-idx="2">
            <div class="container">
                <div class="row">
                    <ul class="breadcrumb">
                        <li class="breadcrumb_item">
                            <span class="breadcrumb_item_text">
                                <a title="Trang chủ" href="/" class="breadcrumb_item_anchor">
                                   <span>Trang chủ</span>
                                </a>
                                <div class="breadcrumb_right_arrow"><i class="fa fa-angle-right"></i></div>
                            </span>
                        </li>
                        @for($i=0; $i<count($breadcrumb)-1;$i++)
                            <li class="breadcrumb_item">
                                <span class="breadcrumb_item_text">
                                    <a title="{{$breadcrumb[$i]->name}}" href="{{urlTag($breadcrumb[$i])}}" class="breadcrumb_item_anchor">
                                        <span>{{$breadcrumb[$i]->name}}</span>
                                    </a>
                                <div class="breadcrumb_right_arrow"><i class="fa fa-angle-right"></i></div>
                                </span>
                            </li>
                        @endfor
                        <li class="breadcrumb_item">
                            <span class="breadcrumb_item_text">
                                <span class="breadcrumb_item_anchor breadcrumb_item_anchor_last">{{$breadcrumb[count($breadcrumb)-1]->name}}</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
@stop

@section('content')
    <div itemscope itemtype="http://schema.org/ItemList" id="listProductPage">
        @foreach($items as $itemTag)
            @if(count($itemTag['products']))
                <div class="block-tag">
                    <div class="block-tag-header homepage" >
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8" >
                                    <div class="row">
                                        @if(count($items) == 1)
                                            <h2>{{ mb_strtoupper($itemTag['tag']->name)}}</h2>
                                        @else
                                            <h2><a href="{{urlTagProduct($itemTag)}}">{{ mb_strtoupper($itemTag['tag']->name)}}</a></h2>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <h3>@if($itemTag['tag']->short_desc){{ $itemTag['tag']->short_desc}}@else Danh sách {{ $itemTag['tag']->name}} của KACANA! @endif</h3>
                                    </div>
                                </div>
                                @if(count($items) == 1)
                                    <div class="col-sm-4 pull-right">
                                        @include('client.product.sort')
                                    </div>
                                @else
                                    <div class="show-all col-xs-12 col-sm-4" >
                                        <a href="{{urlTagProduct($itemTag)}}">Xem tất cả <i class="fa fa-angle-right"></i></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="block-tag-body">
                        {{--@include('client.product.sidebar')--}}
                        <div class="container taglist as-search-results-tiles background-white" id="content">
                            <div class="row">
                                @forelse($itemTag['products'] as $item)
                                    <div itemprop="itemListElement" itemscope itemtype="http://schema.org/Product" class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
                                        @include('client.product.product-item-temple')
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @if(count($items) > 1)
                        @if(count($itemTag['products'])>=KACANA_HOMEPAGE_ITEM_PER_TAG)
                            <div class="container background-white" >
                                <div class="row">
                                    <div class="col-xs-6 text-center" >
                                        <a class="btn-see-more-product" href="{{urlTagProduct($itemTag)}}" >
                                            <span data-type="" >Tất cả <i class="pe-7s-angle-right-circle pe-2x pe-va"></i></span>
                                        </a>
                                    </div>
                                    <div class="col-xs-6 text-center" >
                                        <a class="btn-see-more-product" href="#load-more-product-with-type" data-page="2" data-tag-id="{{$item['tag_id']}}" data-type="{{PRODUCT_HOMEPAGE_TYPE_TAG}}" >
                                            <span data-type="" >Xem tiếp <i class="pe-7s-plus pe-2x pe-va"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        @endforeach

        <div class="block-tag" id="auto-load-more-block" data-tag-id="{{$tag->id}}" data-page="2" data-type="{{PRODUCT_HOMEPAGE_TYPE_TAG}}" >
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

        @if($tag->description)
            <div class="container tag-description vpadding-10 margin-top-10px">
                <div class="row">
                    <div class="col-md-12">
                        {!! fixHtml($tag->description) !!}
                    </div>
                </div>
            </div>
        @endif
        @if(isset($tag->allChilds))
            <div class="container background-white vpadding-10 margin-top-10px">
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-head color-grey">Có thể bạn quan tâm</span>
                        @foreach($tag->allChilds as $subTag)
                            <a class="color-grey-light tag-relation-suggestion" href="{{urlTag($subTag)}}" >
                                <span class="tag-name">{{$subTag->name}}</span>
                                <span class="tag-count">{{$subTag->countProduct}}<br>SP</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    <input type="hidden" name="" value="{{$tag->id}}" id="tag-id"/>
    <input type="hidden" name="" value="" id="color-id"/>
    <input type="hidden" name="" value="" id="brand-id"/>
    <input type="hidden" name="" value="" id="sort"/>
@stop

@section('javascript')
    Kacana.homepage.init();
    Kacana.tagpage.init();
    Kacana.facebookPixel.viewProductContent(1000000, "{{implode(", ",getProductIds($items[0]['products']))}}");
@stop
@section('section-modal')
    @include('client.product.modal')
@stop

@section('google-param-prodid', implode(", ",getProductIds($items[0]['products'])))
@section('google-param-pagetype', 'category')