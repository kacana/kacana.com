@extends('layouts.client.master')

@section('meta-title', $item->name)
@section('meta-description', $item->meta)
@section('meta-keyword', implode(", ", $item->metaKeyword))
@section('meta-image', 'http:'.$item->image)
{{--*/ $indexImage = 0 /*--}}

@section('content')
<div role="main" id="product-detail" data-id="{{$item->id}}" data-tag-id="{{$tag->id}}" class="main shop">
    <section class="header-page-title">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><a href="{{urlTag($tag)}}" >{{$tag->name}}</a></h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container background-white vpadding-20">
        <div class="row">
            <div class="col-xs-12 col-sm-5">
                <div class="summary entry-summary">
                    <h1 class="name-product">{{$item->name}}</h1>

                    <p class="price">
                        <span class="amount">
                            @if($item->discount){{formatMoney($item->sell_price - $item->discount)}}@else{{formatMoney($item->sell_price)}}@endif
                        </span>
                    </p>

                    @if($item->discount)
                        <div class="block-promotions table">
                            <div class="block-promotions-title cell">ĐANG KHUYẾN MÃI</div>
                            <div class="block-promotions-infos cell">
                                <p>
                                    ĐANG GIẢM GIÁ TỪ {{formatMoney($item->sell_price)}} XUỐNG CÒN
                                    <span class="text-danger">
                                        <b>{{formatMoney($item->sell_price - $item->discount)}}</b>
                                    </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">ÁP DỤNG TỪ:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> {{date("d/m/Y")}} </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">ĐẾN:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> Hết hàng </span>
                                </p>
                            </div>
                        </div>
                    @endif

                    <p >{{$item->short_description}}</p>
                    <div class="row" >
                        <div class="col-xxs-12 col-xxs-offset-0 col-xs-10 col-xs-offset-1 hidden-sm hidden-md hidden-lg">
                            <div id="product-detail-gallery-mobile" class="royalSlider rsDefault">
                                @if($productSlide && count($productSlide)>0)
                                    @foreach($productSlide as $gallery)
                                        @if($gallery->type == PRODUCT_IMAGE_TYPE_SLIDE)
                                            <a id="" class="rsImg bugaga" data-rsbigimg="{{$gallery->image}}" href="{{$gallery->image}}">
                                                {{$item->name}}
                                                <img class="rsTmb" src="{{$gallery->thumb}}">
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(count($item->properties))
                        <h4>
                            Màu sắc
                        </h4>
                        <div class="list-color-product multiple-items nav">
                            @foreach($item->properties as $property)
                                @if($productSlide && count($productSlide)>0)
                                    @foreach($productSlide as $galleryIndex => $gallery)
                                        @if($gallery->id == $property->product_gallery_id)
                                            <div>
                                                <a href="#choose-product-color" data-index="{{$galleryIndex}}" data-offset="25" data-popup-kacana="title" data-image-id="{{$property->product_gallery_id}}" data-size="{{json_encode($property->sizeIds)}}" data-title="{{$property->color_name}}" data-id="{{$property->color_id}}" >
                                                    <img src="{{$gallery->thumb}}" >
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div>
                                        <a href="#choose-product-color" data-popup-kacana="title" data-image-id="{{$property->product_gallery_id}}" data-size="{{json_encode($property->sizeIds)}}" data-title="{{$property->color_name}}" data-id="{{$property->color_id}}" >
                                            <img src="" style="background: {{$property->color_code}}; width: 50px; height: 50px;" >
                                        </a>
                                    </div>
                                @endif

                            @endforeach
                        </div>
                    @endif

                    @if(isset($item->propertiesSize))
                        <h4>
                            Kích thước
                        </h4>
                        <ul class="list-size-product nav">
                            @foreach($item->propertiesSize as $propertySize)
                                <li>
                                    <a class="disable" href="#choose-product-size" data-id="{{$propertySize->id}}" data-color="{{json_encode($propertySize->colorIds)}}" >{{$propertySize->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <button type="submit" class="btn btn-primary add-to-cart" id="add-cart-btn">
                         Đặt Mua
                    </button>
                    <span class=@if($item->isLiked)"save-product-wrap active"@else"save-product-wrap"@endif >
                    <a
                            data-product-id="{{$item->id}}"
                            data-product-url="{{urlProductDetail($item)}}"
                            href=@if(\Kacana\Util::isLoggedIn() && !$item->isLiked)"#save-product-like"@elseif(\Kacana\Util::isLoggedIn() && $item->isLiked)"#remove-product-like"@else"#login-header-popup"@endif
                            data-offset="3"
                            data-distance-away="0"
                            data-position="bottom left"
                            data-title=@if(\Kacana\Util::isLoggedIn() && !$item->isLiked)"Lưu sản phẩm này"@elseif(\Kacana\Util::isLoggedIn() && $item->isLiked)"Bỏ lưu sản phẩm này"@else"Đăng nhập để lưu sản phẩm"@endif
                            data-popup-kacana="title"
                            class="save-product" >

                        <i class="pe-7s-like" ></i>
                        <i class="fa fa-heart" ></i>
                    </a>
                    </span>
                    <div class="shop-rule row" >
                        <div class="col-md-12">
                            @include('client.product.order-rule')
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden-xs col-sm-5 col-sm-offset-2">
                <div id="product-detail-gallery" class="royalSlider rsDefault">
                    @if($productSlide && count($productSlide)>0)
                        @foreach($productSlide as $gallery)
                            <a id="product-detail-gallery-id-{{$item->id}}" class="rsImg bugaga" data-rsbigimg="{{$gallery->image}}" href="{{$gallery->image}}">
                                {{$item->name}}
                                <img class="rsTmb" src="{{$gallery->thumb}}">
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="row" >
            <hr class="tall">
        </div>
        <div class="row product-information-detail">
            <span class="col-xs-12">
                @if($item->property)
                    <div class="toogle" data-plugin-toggle="">
                         <section class="toggle active">
                             <label>
                                 <h2 class="description-detail-title">Thuộc tính sản phẩm</h2>
                                 <i class="pe-7s-close"></i>
                             </label>
                             <div class="description-detail-title-footer"></div>
                             <div class="toggle-content" style="display: none;">
                                 {!! fixHtml($item->property)  !!}
                             </div>
                         </section>
                     </div>
                @endif
                <div class="toogle product-description-detail" data-plugin-toggle="">
                    <section class="toggle active">
                        <label>
                            <h2 class="description-detail-title">Thông tin chi tiết</h2>
                            <i class="pe-7s-close"></i>
                        </label>
                        <div class="description-detail-title-footer"></div>
                        <div class="toggle-content">
                            {!! $item->descriptionLazyLoad  !!}
                        </div>
                    </section>
                </div>
                 <div class="toogle" data-plugin-toggle="">
                     <section class="toggle">
                         <label>
                             <h2 class="description-detail-title">Đánh giá và bình luận</h2>
                             <i class="pe-7s-close"></i>
                         </label>
                         <div class="description-detail-title-footer"></div>
                         <div class="toggle-content" style="display: none;">
                             <div class="fb-comments" data-href="{{Request::url()}}" data-width="100%" data-numposts="5"></div>
                         </div>
                     </section>
                 </div>
            </span>
        </div>
    </div>
</div>
@stop

@section('section-modal')
    @include('client.product.modal')
@stop

@section('javascript')
    Kacana.productdetail.init();
@stop


@section('google-param-prodid', $item->id)
@section('google-param-pagetype', 'product')
@section('google-param-totalvalue', formatMoney($item->sell_price))