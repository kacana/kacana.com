<div class="product-image" >
    <a href="{{urlProductDetail($item)}}" title="{{$item->name}}">
        <img src="{{$item->image}}" alt="{{$item->name}}" name="{{$item->name}}">
    </a>
</div>

<div class="product-info">
    <h2 itemprop="name" class="product-title"><a href="{{urlProductDetail($item)}}" title="{{$item->name}}">{{$item->name}}</a></h2>
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
        <span data-id="{{$item->id}}" class="btn btn-danger sold-out-btn">hết hàng</span>
    @else
        @if($item->currentDiscount)
            <span data-id="{{$item->id}}" class="quick-order-btn">Thêm vào giỏ hàng</span>
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
</div>