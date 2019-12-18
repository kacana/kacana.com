<div class="product-image" >
    <a href="{{urlProductDetail($item)}}" title="{{$item->name}}">
        <img src="{{$item->image}}" alt="{{$item->name}}" name="{{$item->name}}">
    </a>
</div>
<div class="product-info">
    <div itemprop="name" class="product-title"><a href="{{urlProductDetail($item)}}" title="{{$item->name}}">{{$item->name}}</a></div>
</div>

<div class="product-price-wrap">
    <div class="product-price">
        @if($item->currentDiscount)
            {{formatMoney(calculateDiscountPrice($item->sell_price, $item->currentDiscount->discount_type, $item->currentDiscount->ref))}}
        @else
            {{formatMoney($item->sell_price)}}
        @endif
    </div>

    @if($item->currentDiscount)
        <div class="product-price discount">
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="discount-info">
                @if($item->currentDiscount->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                    <div itemprop="price" class="product-free">
                        Tặng <a target="_blank" href="{{urlProductDetail($item->currentDiscount->productRef)}}"><img src="{{$item->currentDiscount->productRef->image}}"></a>
                    </div>
                @else
                    <div itemprop="price" class="product-price-original">
                        {{formatMoney($item->sell_price)}}
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<div class="product-item-action">
    @if($item->status == KACANA_PRODUCT_STATUS_SOLD_OUT)
        <span data-id="{{$item->id}}" class="btn btn-danger sold-out-btn">
                hết hàng
        </span>
    @else
        <span data-id="{{$item->id}}" class="quick-order-btn">
                Thêm vào giỏ hàng
            </span>
    @endif
</div>
