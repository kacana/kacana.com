<div class="product-image" >
    <div class="product-image-inside royalSlider rsDefault" data-first-image="{{$item->image}}" data-alt-image="{{$item->name}}" >
        <a data-rsbigimg="{{$item->image}}" href="{{$item->image}}" class="rsImg">
            {{$item->name}}
            <img alt="{{$item->name}}" class="rsTmb" src="{{$item->image}}"/>
        </a>
        @if($item->properties && count($item->properties)>0)
            @foreach($item->properties as $property)
                @if($property->product_gallery)
                    <a id="product-property-gallery-id-{{$item->id}}" class="rsImg" data-rsbigimg="{{$property->product_gallery->image}}" href="{{$property->product_gallery->image}}" >
                        <img alt="{{$item->name}}" class="rsTmb" src="{{$property->product_gallery->thumb}}" >
                    </a>
                @endif
            @endforeach
        @endif
    </div>
</div>

{{--@if($item->properties && count($item->properties)>0)--}}
    {{--<div class="list-color-product multiple-items nav" >--}}
        {{--@foreach($item->properties as $property)--}}
            {{--@if($property->product_gallery)--}}
                {{--<div>--}}
                    {{--<a href="#choose-product-color">--}}
                        {{--<img src="{{$property->product_gallery->thumb}}" >--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--@endif--}}
        {{--@endforeach--}}
    {{--</div>--}}
{{--@else--}}
    {{--<div class="list-color-product multiple-items nav" >--}}
        {{--<div>--}}
            {{--<a >--}}
                {{--<img src="{{$item->image}}">--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endif--}}
<div class="product-info">
    <h4 class="product-title"> <a href="{{urlProductDetail($item)}}" title="{{$item->name}}">{{$item->name}}</a></h4>
</div>
<div class="product-price-wrap">
    @if($item->discount)
        <div class="product-price discount">
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="discount-info">
                <div itemprop="price" class="product-price-original">
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
