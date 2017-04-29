@if(count($item->children))
    <li class="has-children">
        <input type="checkbox" name ="group-{{$item->categoryId}}" id="group-{{$item->categoryId}}" checked>
        <label for="group-{{$item->categoryId}}">{{$item->name}}</label>
        <ul>
            @foreach($item->children as $child)
                @include('partner.product.categories', ['item' => $child] )
            @endforeach
        </ul>
    </li>
@else
    <li><a data-id="{{$item->categoryId}}" data-name="{{$item->name}}" href="#choose-lazada-category">{{$item->name}}</a></li>
@endif