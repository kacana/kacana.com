@extends('layouts.client.master')

@section('meta-title', ucfirst($product->name_seo))
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
                    <p class="product-tag-title"><a href="{{urlTag($tag)}}" >{{$tag->name}}</a></p>
                </div>
            </div>
        </div>
    </section>
    <div class="container background-white vpadding-20">
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-lg-6">
                <div id="product-detail-gallery" class="royalSlider rsDefault" data-alt-image="{{$product->name}}">
                    @if($productSlide && count($productSlide)>0)
                        @foreach($productSlide as $gallery)
                            <a id="product-detail-gallery-id-{{$product->id}}" class="rsImg bugaga" data-rsbigimg="{{$gallery->image}}" href="{{$gallery->image}}">
                                <img alt="{{$product->name}}" title="{{$product->name}}" class="rsTmb" src="{{$gallery->thumb}}">
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-lg-3">
                <h1  class="name-product">{{ucfirst($product->name)}}</h1>
                <p  class="price">
                    <span class="amount">
                        @if($product->currentDiscount)
                            {{formatMoney(calculateDiscountPrice($product->sell_price, $product->currentDiscount->discount_type, $product->currentDiscount->ref))}}
                            @if($product->currentDiscount->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                <small>Tặng: <a target="_blank" href="{{urlProductDetail($product->currentDiscount->productRef)}}">{{$product->currentDiscount->productRef->name}} <img src="{{$product->currentDiscount->productRef->image}}"></a></small>
                            @else
                                <small>Giá trước đây: <span>{{formatMoney($product->sell_price)}}</span></small>
                                <small>Tiêt kiệm: {{savingDiscount($product->currentDiscount->discount_type, $product->currentDiscount->ref, $product->sell_price)}}</small>
                            @endif
                        @elseif($product->main_discount)
                            {{formatMoney($product->sell_price - $product->main_discount)}}
                        @else
                            {{formatMoney($product->sell_price)}}
                        @endif
                    </span>
                </p>
                <div class="row">
                    <div class="col-xs-12 kacana-wysiwyg-block product-basic-information">
                        <p>{{$product->short_description}}</p>
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
                    @if($product->currentDiscount)
                        <div class="block-promotions table">
                            <div class="block-promotions-title">ĐANG KHUYẾN MÃI</div>
                            <div class="block-promotions-infos">
                                <p>
                                    @if($product->currentDiscount->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                        Tặng:  <a class="color-grey" target="_blank" href="{{urlProductDetail($product->currentDiscount->productRef)}}">{{$product->currentDiscount->productRef->name}} <img src="{{$product->currentDiscount->productRef->image}}"></a>
                                    @else
                                        Giảm giá từ {{formatMoney($product->sell_price)}} còn
                                        <span class="text-danger">
                                        <b>{{formatMoney(calculateDiscountPrice($product->sell_price, $product->currentDiscount->discount_type, $product->currentDiscount->ref))}}</b>
                                    </span>
                                    @endif

                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">Áp dụng từ:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6">{{date('H:i - d/m/y', strtotime($product->currentDiscount->start_date))}}</span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">Đến:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6">{{date('H:i - d/m/y', strtotime($product->currentDiscount->end_date))}}</span>
                                </p>
                            </div>
                        </div>
                    @elseif($product->main_discount)
                        <div class="block-promotions table">
                            <div class="block-promotions-title">ĐANG KHUYẾN MÃI</div>
                            <div class="block-promotions-infos">
                                <p>
                                    Giảm giá từ {{formatMoney($product->sell_price)}} còn
                                    <span class="text-danger">
                                        <b>{{formatMoney($product->sell_price - $product->main_discount)}}</b>
                                    </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">Áp dụng từ:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> 14/03/2017 </span>
                                </p>
                                <p class="row">
                                    <span class="col-lg-4 col-md-4 col-sm-6 col-xs-6">Đến:</span>
                                    <span class="col-lg-8 col-md-8 col-sm-6 col-xs-6"> 21/03/2017 </span>
                                </p>
                            </div>
                        </div>
                    @endif
                    @if(count($product->properties))
                        <p class="product-information-head" >
                            Màu sắc
                        </p>
                        <div class="product-colors current-product-colors multiple-items nav">
                            @foreach($product->properties as $property)
                                @if($productSlide && count($productSlide)>0)
                                    @foreach($productSlide as $galleryIndex => $gallery)
                                        @if($gallery->id == $property->product_gallery_id)
                                                <a href="#choose-product-color" data-index="{{$galleryIndex}}" data-offset="25" data-popup-kacana="title" data-image-id="{{$property->product_gallery_id}}" data-size="{{json_encode($property->sizeIds)}}" data-title="{{$property->color_name}}" data-id="{{$property->color_id}}" >
                                                    <img alt="{{$product->name}} - {{$property->color_name}}" src="{{$gallery->thumb}}" >
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
                        <p class="product-information-head">
                            Kích thước
                        </p>
                        <ul class="list-size-product nav">
                            @foreach($product->propertiesSize as $propertySize)
                                <li>
                                    <a class="disable" href="#choose-product-size" data-id="{{$propertySize->id}}" data-color="{{json_encode($propertySize->colorIds)}}" >{{$propertySize->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if($product->status == KACANA_PRODUCT_STATUS_ACTIVE)
                        <div class="row">
                            <span class="col-xs-12">
                                <button type="submit" class="btn btn_kacana_main add-to-cart" id="add-cart-btn">
                                    Mua ngay
                                </button>
                            </span>
                        </div>
                        <div class="col-xs-12 quick-order-block">
                            <form method="post" id="quick_order_form" action="/cart/quickOrder" >
                                <p class="product-information-head">
                                    Đặt hàng ngay chỉ cần để lại SĐT
                                </p>
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
                    @elseif($product->status == KACANA_PRODUCT_STATUS_SOLD_OUT)
                        <div class="row">
                            <span class="col-xs-12">
                                <button type="submit" class="btn btn_kacana_main margin-top-10px">
                                   sản phẩm tạm hết hàng
                                </button>
                                <label class="margin-top-10px text-red">Gọi 0906.054.206 để liên hệ với chúng tôi nếu bạn muốn mua sản phẩm này!</label>
                            </span>
                        </div>
                    @endif
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
            <div id="product-description" class="col-xs-12 col-sm-9">
                @if(str_replace(' ','',strip_tags($product->property)))
                    <div class="toogle" data-plugin-toggle="">
                         <section class="toggle active">
                             <label>
                                 <p class="center description-detail-title"><span>Thuộc tính sản phẩm</span></p>
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
                            <p class="center description-detail-title"><span>Thông tin chi tiết</span></p>
                        </label>
                        <div class="description-detail-title-footer"></div>
                        <div class="toggle-content">
                            {!! $product->descriptionLazyLoad  !!}
                        </div>
                    </section>
                </div>
            </div>
            <div id="list-product-related-wrap" class="col-xs-12 col-sm-3">
                <div class="toogle"  data-plugin-toggle="" id="list-product-related">
                    <section class="toggle active" >
                        <label>
                            <p class="center description-detail-title"><span>Sản phẩm tương tự</span></p>
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
                                                        <div i class="col-xxs-12 col-xs-6 col-sm-12 product-item" >
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
            <div id="list-tag-related-product-wrap" class="col-xs-12">
                <div class="toogle" id="list-tag-related-product" data-plugin-toggle="">
                    <section class="toggle active">
                        <label>
                            <p class="center description-detail-title"><span>Có thể bạn đang tìm kiếm</span></p>
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
            <div id="comment-block" class="col-xs-12 col-sm-12">
                <div class="toogle" data-plugin-toggle="">
                    <section class="toggle active">
                        <label>
                            <p class="center description-detail-title"><span>Đánh giá và bình luận</span></p>
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
    <script type="application/ld+json">
        {
          "@context": "http://schema.org/",
          "@type": "Product",
          "image": "https:{{$product->image}}",
          "name": "{{$product->name}}",
          "description": "{{$product->short_description}}",
            "offers": {
            "@type": "Offer",
            "priceCurrency": "VND",
            "price": "{{$product->sell_price}}"
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "{{rand(4,5)}}",
            "reviewCount": "{{rand(30, 45)}}"
          },
          "brand": {
            "@type": "thing",
            "name": "kacana",
            "image": "https:{{AWS_CDN_URL}}/images/client/logo.png"
          },
          "color": "{{$property->color_name}}",
          "productID": "{{$product->id}}"
        }
    </script>
@stop

@section('javascript')
    Kacana.productdetail.init();
    Kacana.facebookPixel.viewProductContent({{$product->sell_price}}, {{$product->id}});
@stop


@section('google-param-prodid', $product->id)
@section('google-param-pagetype', 'product')
@section('google-param-totalvalue', $product->sell_price)