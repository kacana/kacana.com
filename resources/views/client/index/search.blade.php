@extends('layouts.client.master')
@section('meta-title', 'Sản phẩm với từ khoá: '.ucfirst($search))
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('{{KACANA_URL_BACKGROUND_BANNER_DEFAULT}}');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h1 class="short text-shadow big white bold"><span class="color-white" >{{$search}}</span></h1>
                </div>
            </div>
        </div>
    </section>
@stop

@section('breadcrumb')
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
                    <li class="breadcrumb_item">
                        <span class="breadcrumb_item_text">
                            <span class="breadcrumb_item_anchor breadcrumb_item_anchor_last">{{$search}}</span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div id="listProductPage">
        <div class="block-tag">
            <div class="block-tag-body as-accessories-results">
                {{--@include('client.product.sidebar')--}}
                <div class="container taglist as-search-results-tiles background-white" id="content">
                    @forelse($products as $item)
                        <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
                            @include('client.product.product-item-temple')
                        </div>
                    @empty
                        <div style="margin: 50px 0" class="alert alert-warning">
                            <h1> Không tìm thấy sản phẩm nào với từ khoá - {{$search}}</h1>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="container background-white">
            <div class="row">
                <div class="col-md-12 text-center">
                    {!! $products->appends(['sort' => (isset($options['sort']))?$options['sort']:''])->render() !!}
                </div>
            </div>
        </div>
        <div class="loader-response"><i class="fa fa-circle-o-notch fa-spin fa-3x"></i></div>
    </div>
    <input type="hidden" name="" value="{{$search}}" id="search-string"/>
@stop

@section('javascript')
    Kacana.homepage.init();
    Kacana.tagpage.init();
    Kacana.facebookPixel.searchProductContent("{{$search}}","{{implode(", ",getProductIds($products))}}");
@stop
@section('section-modal')
    @include('client.product.modal')
@stop

@section('google-param-prodid', implode(", ",getProductIds($products)))
@section('google-param-pagetype', 'searchresults')
@section('google-param-totalvalue', 1000000)

