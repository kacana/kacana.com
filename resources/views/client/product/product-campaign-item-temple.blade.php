<div class="product-image" >
    <div class="product-image-inside royalSlider rsDefault" data-first-image="{{$item->image}}" data-alt-image="{{$item->name}}" >
        <a data-rsbigimg="{{$item->image}}" href="{{AWS_CDN_URL.PRODUCT_IMAGE_PLACE_HOLDER}}" class="rsImg">
            <div class="rsCaption">{{$item->name}}</div>
        </a>
        @if($item->properties && count($item->properties)>0)
            @foreach($item->properties as $property)
                @if($property->product_gallery)
                    <a id="product-property-gallery-id-{{$item->id}}" class="rsImg" data-rsbigimg="{{$property->product_gallery->image}}" href="{{$property->product_gallery->image}}" >
                        <div class="rsCaption">{{$item->name}}</div>
                    </a>
                @endif
            @endforeach
        @endif
    </div>
</div>

@if($item->properties && count($item->properties)>0)
    <div class="list-color-product multiple-items nav hidden-xs" >
        @foreach($item->properties as $property)
            @if($property->product_gallery)
                <div>
                    <a data-id="{{$property->color_id}}" href="#choose-product-color">
                        <img title="{{$item->name}}" alt="{{$item->name}}" data-src="{{$property->product_gallery->thumb}}">
                    </a>
                </div>
            @endif
        @endforeach
    </div>
@else
    <div class="list-color-product multiple-items nav hidden-xs" >
        <div>
            <a >
                <img title="{{$item->name}}" alt="{{$item->name}}" data-src="{{$item->image}}">
            </a>
        </div>
    </div>
@endif
<div class="product-info">
    <h2 itemprop="name" class="product-title"><a href="{{urlProductDetail($item)}}" title="{{$item->name}}">{{$item->name}}</a></h2>
</div>

<div class="product-price-wrap">
    @if($campaignProduct)
        <div class="product-price discount">
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="discount-info">
                @if($campaignProduct->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                    <div itemprop="price" class="product-free">
                        Tặng <a target="_blank" href="{{urlProductDetail($campaignProduct->productRef)}}"><img src="{{$campaignProduct->productRef->image}}"></a>
                    </div>
                @else
                    <div itemprop="price" class="product-price-original">
                        {{formatMoney($item->sell_price)}}
                    </div>
                @endif

            </div>
            {{formatMoney(calculateDiscountPrice($item->sell_price, $campaignProduct->discount_type, $campaignProduct->ref))}}
        </div>
        {{--<div class="discount-tag">--}}
            {{--<img src="{{AWS_CDN_URL}}/images/client/discount_tag_small.png">--}}
            {{--<div class="discount-tag-name">{{discountTagName($item->currentDiscount->discount_type)}}</div>--}}
            {{--@if($item->currentDiscount->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)--}}
                {{--<div class="product-free-tag">--}}
                    {{--<a target="_blank" href="{{urlProductDetail($item->currentDiscount->productRef)}}"><img src="{{$item->currentDiscount->productRef->image}}"></a>--}}
                {{--</div>--}}
            {{--@else--}}
                {{--<div class="discount-tag-ref">{{discountTagRef($item->currentDiscount->discount_type, $item->currentDiscount->ref)}}</div>--}}
            {{--@endif--}}

        {{--</div>--}}
    @else
        <div class="product-price">{{formatMoney($item->sell_price)}}</div>
    @endif
</div>

<div class="product-short-description-like-wrap">
    <div class="product-short-description-wrap text-center" id="product-short-description-wrap-{{$item->id}}">
        <div itemprop="description" class="product-short-description">
            {{fixHtml($item->short_description)}}
        </div>

        <span class=@if($item->isLiked)"save-product-wrap hidden-xs active pull-left"@else"save-product-wrap hidden-xs pull-left"@endif >
            <a  data-product-id="{{$item->id}}"
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
        @if($item->status == KACANA_PRODUCT_STATUS_SOLD_OUT)
            <span data-id="{{$item->id}}" class="btn btn-danger sold-out-btn">
                hết hàng
            </span>
        @else
            @if($item->currentDiscount)
                <span data-id="{{$item->id}}" class="quick-order-btn">
                    Thêm vào giỏ hàng
                </span>
            @else
                <?php
                    $startDate = $campaignProduct->start_date;
                    $startDate = explode(' ', $startDate);

                    $endDate = $campaignProduct->end_date;
                    $endDate = explode(' ', $endDate);
                ?>


                <span data-id="{{$item->id}}" class="date-discount">
                    <span class="date-discount-start">
                        <div>{{$startDate[0]}}</div>
                        <small>{{$startDate[1]}}</small>
                    </span>
                    <span class="date-discount-end">
                        <div>{{$endDate[0]}}</div>
                        <small>{{$endDate[1]}}</small>
                    </span>
                </span>
            @endif

        @endif
        <span class="pull-right viewless-wrap" >
            <a href="#show-less-short-desc" class="viewless" >
                <i class="fa fa-angle-double-up" ></i>
            </a>
        </span>
        <span class="pull-right hidden-xs viewmore-wrap" >
            <a href="#show-more-short-desc" class="viewmore" >
                <i class="fa fa-angle-double-down" ></i>
            </a>
        </span>
        <div class="product-item-box-footer"></div>
    </div>
</div>