
<div id="btn-sort-product" data-popup-kacana="inline" class="pull-right" >
    <span class="title">Sắp xếp:</span>
    <span>
        @if((isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_NEWEST) || (!isset($options['sort']) || !$options['sort']))
            Mới nhất
        @endif
        @if(isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_PRICE_FROM_LOW)
            Giá: Thấp đến Cao
        @endif
        @if(isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_PRICE_FROM_HEIGHT)
            Giá: Cao đến Thấp
        @endif
        @if(isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_DISCCOUNT)
            Giảm giá
        @endif
        @if(isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_COMMENT)
            Đánh giá
        @endif
    </span>
</div>

<ul class="ui popup hidden" id="list-option-sort-product">
    <li>
        <a href="{{Request::url()}}?page=1&sort={{PRODUCT_LIST_SORT_NEWEST}}"
           class="@if((isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_NEWEST) || (!isset($options['sort']))) active  @endif">
            <i class="pe-7s-rocket"></i> Mới nhất
        </a>
    </li>
    <li>
        <a href="{{Request::url()}}?page=1&sort={{PRODUCT_LIST_SORT_PRICE_FROM_LOW}}"
           class="@if((isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_PRICE_FROM_LOW)) active @endif">
            <i class="pe-7s-up-arrow fa-rotate-180"></i> Giá: Thấp đến Cao
        </a>
    </li>
    <li>
        <a href="{{Request::url()}}?page=1&sort={{PRODUCT_LIST_SORT_PRICE_FROM_HEIGHT}}"
           class="@if((isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_PRICE_FROM_HEIGHT)) active @endif">
            <i class="pe-7s-up-arrow"></i> Giá: Cao đến Thấp
        </a>
    </li>
    <li>
        <a href="{{Request::url()}}?page=1&sort={{PRODUCT_LIST_SORT_DISCCOUNT}}"
           class="@if((isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_DISCCOUNT)) active @endif">
            <i class="pe-7s-smile"></i> Giảm giá
        </a>
    </li>
    <li>
        <a href="{{Request::url()}}?page=1&sort={{PRODUCT_LIST_SORT_COMMENT}}"
           class="@if((isset($options['sort']) && $options['sort'] == PRODUCT_LIST_SORT_COMMENT)) active @endif">
            <i class="pe-7s-star"></i> Đánh giá
        </a>
    </li>
</ul>