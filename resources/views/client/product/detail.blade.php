@extends('layouts.client.master')

@section('meta-title', ucfirst($product->name))
@section('meta-description', $product->meta)
@section('meta-keyword', implode(", ", $product->metaKeyword))
@section('meta-image', 'http:'.AWS_CDN_URL.str_replace(' ', '%20',$product->getOriginal('image')))
{{--*/ $indexImage = 0 /*--}}

@section('content')
<div role="main" id="product-detail" data-id="{{$product->id}}" data-tag-id="{{$tag->id}}" class="main shop">
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
            <div class="col-xs-12 col-sm-5 col-lg-6">
                <div id="product-detail-gallery" class="royalSlider hidden rsDefault">
                    @if($productSlide && count($productSlide)>0)
                        @foreach($productSlide as $gallery)
                            <a id="product-detail-gallery-id-{{$product->id}}" class="rsImg bugaga" data-rsbigimg="{{$gallery->image}}" href="{{$gallery->image}}">
                                {{$product->name}}
                                <img class="rsTmb" src="{{$gallery->thumb}}">
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-lg-3">
                <h1 class="name-product">{{ucfirst($product->name)}}</h1>
                <p class="price">
                    <span class="amount">
                        @if($product->discount)
                            {{formatMoney($product->sell_price - $product->discount)}}
                        @elseif($product->main_discount)
                            {{formatMoney($product->sell_price - $product->main_discount)}}
                        @else
                            {{formatMoney($product->sell_price)}}
                        @endif
                    </span>
                </p>
                <div class="row">
                    <div class="col-xs-12 kacana-wysiwyg-block product-basic-information">
                        <p >{{$product->short_description}}</p>
                        @if(str_replace(' ','',strip_tags($product->property_description)))
                            {!! $product->property_description !!}
                        @endif
                    </div>
                </div>
                <div class="shop-rule hidden-xs row" >
                    @include('client.product.order-rule')
                </div>
            </div>
            <div class="col-xs-12 col-sm-3">
                <div class="summary entry-summary">
                    @if($product->discount)
                        <div class="block-promotions table">
                            <div class="block-promotions-title">ĐANG KHUYẾN MÃI</div>
                            <div class="block-promotions-infos">
                                <p>
                                    Giảm giá từ {{formatMoney($product->sell_price)}} còn
                                 <span class="text-danger">
                                        <b>{{formatMoney($product->sell_price - $product->discount)}}</b>
                                    </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">Áp dụng từ:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> {{date("d/m/Y")}} </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">Đến:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> Hết hàng </span>
                                </p>
                            </div>
                        </div>
                    @elseif($product->main_discount)
                        <div class="block-promotions table">
                            <div class="block-promotions-title cell">ĐANG KHUYẾN MÃI</div>
                            <div class="block-promotions-infos cell">
                                <p>
                                    ĐANG GIẢM GIÁ TỪ {{formatMoney($product->sell_price)}} XUỐNG CÒN
                                    <span class="text-danger">
                                        <b>{{formatMoney($product->sell_price - $product->main_discount)}}</b>
                                    </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">ÁP DỤNG TỪ:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> 29/10/2016 </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">ĐẾN:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> 02/11/2016 </span>
                                </p>
                            </div>
                        </div>
                    @endif
                    @if(count($product->properties))
                        <h4 class="product-information-head" >
                            Màu sắc
                        </h4>
                        <div class="product-colors current-product-colors multiple-items nav">
                            @foreach($product->properties as $property)
                                @if($productSlide && count($productSlide)>0)
                                    @foreach($productSlide as $galleryIndex => $gallery)
                                        @if($gallery->id == $property->product_gallery_id)
                                                <a href="#choose-product-color" data-index="{{$galleryIndex}}" data-offset="25" data-popup-kacana="title" data-image-id="{{$property->product_gallery_id}}" data-size="{{json_encode($property->sizeIds)}}" data-title="{{$property->color_name}}" data-id="{{$property->color_id}}" >
                                                    <img src="{{$gallery->thumb}}" >
                                                </a>
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

                    @if(isset($product->propertiesSize))
                        <h4 class="product-information-head">
                            Kích thước
                        </h4>
                        <ul class="list-size-product nav">
                            @foreach($product->propertiesSize as $propertySize)
                                <li>
                                    <a class="disable" href="#choose-product-size" data-id="{{$propertySize->id}}" data-color="{{json_encode($propertySize->colorIds)}}" >{{$propertySize->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="row">
                        <span class="col-xs-12">
                            <button type="submit" class="btn btn_kacana_main add-to-cart" id="add-cart-btn">
                                Mua ngay
                            </button>
                   </span>
                    </div>
                    <div class="col-xs-12 quick-order-block">
                        <form method="post" id="quick_order_form" action="/cart/quickOrder" >
                            <h4 class="product-information-head">
                                Đặt hàng ngay chỉ cần để lại SĐT
                            </h4>
                            <input class="hidden" name="sizeId"  value="0" type="text" >
                            <input class="hidden" name="colorId"  value="0" type="text" >
                            <input class="hidden" name="tagId"  value="{{$tag->id}}" type="text" >
                            <input class="hidden" name="productId"  value="{{$product->id}}" type="text" >
                            <input id="phoneQuickOrderNumber" name="phoneQuickOrderNumber" placeholder="Nhập số điện thoại" type="text" >
                            <button type="submit" class="btn btn_kacana_main order-product-with-phone" id="order-product-with-phone">
                               Gọi lại cho tôi
                            </button>
                        </form>
                    </div>
                    <div class="row">
                        <span class="col-xs-12">
                            <a target="_blank" href="/contact/kiem-tiem-voi-chung-toi" type="submit" class="btn btn_kacana_main get-money-with-us-btn" >
                                Kiếm tiền cùng KACANA
                            </a>
                        </span>
                    </div>
                    <div class="row vpadding-10" >
                        <div class="col-xs-6">
                            <span class=@if($product->isLiked)"save-product-wrap active"@else"save-product-wrap"@endif >
                                <a  data-product-id="{{$product->id}}"
                                    data-product-url="{{urlProductDetail($product)}}"
                                    href=@if(\Kacana\Util::isLoggedIn() && !$product->isLiked)"#save-product-like"@elseif(\Kacana\Util::isLoggedIn() && $product->isLiked)"#remove-product-like"@else"#login-header-popup"@endif
                                    class="save-product" >
                                    <i class="pe-7s-like" ></i>
                                    <i class="fa fa-heart" ></i>
                                    <span>
                                        @if(\Kacana\Util::isLoggedIn() && !$product->isLiked)
                                        Lưu sản phẩm này
                                        @elseif(\Kacana\Util::isLoggedIn() && $product->isLiked)
                                            Bỏ lưu sản phẩm này
                                        @else
                                            Lưu sản phẩm này
                                        @endif
                                    </span>
                                </a>
                            </span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <span>
                                <a @if(!\Kacana\Util::isLoggedIn())
                                        data-popup-kacana="title"
                                        data-title="Đăng nhập để đăng lên Facebook"
                                        data-logged="0"
                                   @elseif(\Kacana\Util::hasSocial(KACANA_SOCIAL_TYPE_FACEBOOK))
                                        data-has-social="1"
                                   @endif
                                   class="btn-post-to-facebook"
                                   href="#post-to-facebook" >
                                    <i class="fa fa-facebook" ></i> Facebook
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
        </div>
        <div id="product-main-information" class="row product-information-detail">
            <div class="col-xs-12 col-sm-12">
                @if(str_replace(' ','',strip_tags($product->property)))
                    <div class="toogle" data-plugin-toggle="">
                         <section class="toggle active">
                             <label>
                                 <h2 class="center description-detail-title"><span>Thuộc tính sản phẩm</span></h2>
                             </label>
                             <div class="description-detail-title-footer"></div>
                             <div class="toggle-content">
                                 {!! fixHtml($product->property)  !!}
                             </div>
                         </section>
                     </div>
                @endif
                <div class="toogle product-description-detail" data-plugin-toggle="">
                    <section class="toggle active">
                        <label>
                            <h2 class="center description-detail-title"><span>Thông tin chi tiết</span></h2>
                        </label>
                        <div class="description-detail-title-footer"></div>
                        <div class="toggle-content">
                            {!! $product->descriptionLazyLoad  !!}
                        </div>
                    </section>
                </div>
            </div>
            <div id="list-product-related-wrap" class="col-xs-12 col-sm-12">
                <div class="toogle"  data-plugin-toggle="" id="list-product-related">
                    <section class="toggle active" >
                        <label>
                            <h2 class="center description-detail-title"><span>Sản phẩm tương tự</span></h2>
                        </label>
                        <div class="description-detail-title-footer"></div>
                        <div class="toggle-content">
                            <div class="row" >
                                <div id="listProductPage">
                                    <div class="block-tag">
                                        <div class="block-tag-body as-accessories-results">
                                            <div style="z-index: 1" class="taglist as-search-results-tiles background-white">
                                                @forelse($productRelated as $item)
                                                    @if($item->id != $product->id)
                                                        <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
                                                            @include('client.product.product-item-related-temple')
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="toogle" id="list-tag-related-product" data-plugin-toggle="">
                    <section class="toggle active">
                        <label>
                            <h2 class="center description-detail-title"><span>Có thể bạn đang tìm kiếm</span></h2>
                        </label>
                        <div class="description-detail-title-footer"></div>
                        <div class="toggle-content">
                            @foreach($product->tag as $productTag)
                                <a class="color-grey-light tag-relation-suggestion" href="{{urlTag($productTag)}}" >
                                    <span class="tag-name">{{$productTag->name}}</span>
                                    <span class="tag-count">{{$productTag->countProduct}}<br>SP</span>
                                </a>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12">
                <div class="toogle" data-plugin-toggle="">
                    <section class="toggle active">
                        <label>
                            <h2 class="center description-detail-title"><span>Đánh giá và bình luận</span></h2>
                        </label>
                        <div class="description-detail-title-footer"></div>
                        <div class="toggle-content" style="display: none;">
                            <div class="fb-comments" data-href="{{Request::url()}}" data-width="100%" data-numposts="5"></div>
                        </div>
                    </section>
                </div>
            </div>
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


@section('google-param-prodid', $product->id)
@section('google-param-pagetype', 'product')
@section('google-param-totalvalue', $product->sell_price)