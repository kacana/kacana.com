@extends('layouts.client.master')
@section('meta-title', 'Sản phẩm: '.$tag->name)
@section('meta-description', $tag->short_desc)
@section('meta-keyword', implode(", ",$tag->tagKeyword))

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('@if($tag->image){{ AWS_CDN_URL.$tag->image}}@else /images/client/homepage/account-cover.jpg @endif');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">{{ $tag->name}}</h2>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="listProductPage">
        <div class="block-tag">
            <div class="block-tag-header homepage" >
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8" >
                            <div class="row">
                                <span class="col-xs-12 tag-name">{{ $tag->name}}</span>
                            </div>
                            <div class="row">
                                <span class="col-xs-12 tag-sub-name">@if($tag->short_desc){{ $tag->short_desc}}@else Danh sách {{ $tag->name}} của KACANA! @endif</span>
                            </div>
                        </div>
                        <div class="col-sm-4 pull-right">
                            @include('client.product.sort')
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-tag-body as-accessories-results">
                {{--@include('client.product.sidebar')--}}
                <div class="container taglist as-search-results-tiles background-white" id="content">
                    @forelse($items as $item)
                        @include('client.product.product-item-temple')
                    @empty
                    @endforelse
                </div>
            </div>
        </div>

        <div style="margin-top: -7px" class="container background-white">
            <div class="row">
                <div class="col-md-12 text-center">
                    {!! $items->appends(['sort' => (isset($options['sort']))?$options['sort']:''])->render() !!}
                </div>
            </div>
        </div>
        @if($tag->description)
            <div class="container background-white vpadding-10 margin-top-10px">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {!! fixHtml($tag->description) !!}
                    </div>
                </div>
            </div>
        @endif
        @if(isset($tag->allChilds))
            <div class="container background-white vpadding-10 margin-top-10px">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="color-grey">Sản phẩm nổi bật</h3>
                        @foreach($tag->allChilds as $subTag)
                           <a class="color-grey-light" href="{{urlTag($subTag)}}" >{{$subTag->name}}</a> ,
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>
    <input type="hidden" name="" value="{{$tag->id}}" id="tag-id"/>
    <input type="hidden" name="" value="" id="color-id"/>
    <input type="hidden" name="" value="" id="brand-id"/>
    <input type="hidden" name="" value="" id="sort"/>
@stop

@section('javascript')
    Kacana.homepage.init();
    Kacana.tagpage.init();
@stop
@section('section-modal')
    @include('client.product.modal')
@stop
