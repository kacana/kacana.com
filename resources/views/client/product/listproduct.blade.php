@extends('layouts.client.master')

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('@if($tag->image){{ $tag->image}}@else /images/client/homepage/account-cover.jpg @endif');">
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
        <div class="container background-white">
            <div class="row">
                <div class="col-md-12 text-center">
                    {!! $items->appends(['sort' => (isset($options['sort']))?$options['sort']:''])->render() !!}
                </div>
            </div>
        </div>
        <div class="loader-response"><i class="fa fa-circle-o-notch fa-spin fa-3x"></i></div>
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
