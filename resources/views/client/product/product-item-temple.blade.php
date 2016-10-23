<div class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
    <div class="product-image" >
        {{-- */$i=0;/* --}}
        @if($item->properties && count($item->properties)>0)
            @foreach($item->properties as $property)
                @if($property->product_gallery)
                    @if($i == 0)
                        <div class="product-image-inside royalSlider rsDefault" data-first-image="{{$property->product_gallery->image}}" >
                            <a id="product-property-gallery-id-{{$item->id}}" class="rsImg" data-rsbigimg="{{$property->product_gallery->image}}" href="{{AWS_CDN_URL.PRODUCT_IMAGE_PLACE_HOLDER}}" >
                                {{$item->name}}
                                <img class="rsTmb" data-original="{{$property->product_gallery->thumb}}" >
                            </a>
                    @else
                            <a id="product-property-gallery-id-{{$item->id}}" class="rsImg" data-rsbigimg="{{$property->product_gallery->image}}" href="{{$property->product_gallery->image}}" >
                                <img class="rsTmb" data-original="{{$property->product_gallery->thumb}}" >
                            </a>
                    @endif
                        {{-- */$i++;/* --}}
                @endif
            @endforeach
                        </div>
        @else
            <div class="product-image-inside royalSlider rsDefault" data-first-image="{{$item->image}}" >
                <a data-rsbigimg="{{$item->image}}" href="{{AWS_CDN_URL.PRODUCT_IMAGE_PLACE_HOLDER}}" class="rsImg">
                    {{$item->name}}
                    <img class="rsTmb" data-original="{{$item->image}}"/>
                </a>
            </div>
        @endif
    </div>
    <div class="product-info">
        <div class="product-title"> <a href="{{urlProductDetail($item)}}" title="{{$item->name}}">{{$item->name}}</a></div>
    </div>
    <div class="product-price-wrap">
        @if($item->discount)
            <div class="product-price discount">
                <div class="discount-info">
                    <div class="product-price-original">
                        {{formatMoney($item->sell_price)}}
                    </div>
                    <div class="price-discount" >
                        Giảm giá: <b>{{formatMoney($item->discount)}}</b>
                    </div>
                </div>
                {{formatMoney($item->sell_price - $item->discount)}}</div>
        @else
            <div class="product-price">{{formatMoney($item->sell_price)}}</div>
        @endif
    </div>
    <div class="product-short-description-like-wrap">
        <div class="product-short-description-wrap" id="product-short-description-wrap-{{$item->id}}">
            <div class="product-short-description">
                {{fixHtml($item->short_description)}}
            </div>

            <span class=@if($item->isLiked)"save-product-wrap active"@else"save-product-wrap"@endif >
            <a
                    data-product-id="{{$item->id}}"
                    data-product-url="{{urlProductDetail($item)}}"
                    href=@if(\Kacana\Util::isLoggedIn() && !$item->isLiked)"#save-product-like"@elseif(\Kacana\Util::isLoggedIn() && $item->isLiked)"#remove-product-like"@else"#login-header-popup"@endif
            data-offset="-5"
            data-distance-away="-7"
            data-position="bottom left"
            data-title=@if(\Kacana\Util::isLoggedIn() && !$item->isLiked)"Lưu sản phẩm này"@elseif(\Kacana\Util::isLoggedIn() && $item->isLiked)"Bỏ lưu sản phẩm này"@else"Đăng nhập để lưu sản phẩm"@endif
            data-popup-kacana="title"
            class="save-product" >

            <i class="pe-7s-like" ></i>
            <i class="fa fa-heart" ></i>
            </a>
            </span>
            <span class="pull-right viewless-wrap" >
                <a href="#show-less-short-desc" class="viewless" >
                    <i class="fa fa-angle-double-up" ></i>
                </a>
            </span>
            <span class="pull-right viewmore-wrap" >
                <a href="#show-more-short-desc" class="viewmore" >
                    <i class="fa fa-angle-double-down" ></i>
                </a>
            </span>
            <div class="product-item-box-footer"></div>
        </div>
    </div>

</div>