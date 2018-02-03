@extends('layouts.client.master')

@section('meta-title', ucfirst($post->title_seo))
@section('meta-description', trim_text($post->body, 160, true, true))
@section('meta-keyword', implode(", ", $metaKeyword))
@section('meta-image', 'http:'.AWS_CDN_URL.str_replace(' ', '%20',$post->getOriginal('image')))

@section('content')
    <div itemscope itemtype="http://schema.org/Article" class="container" data-id="{{$post->id}}" id="blog-detail-page">
        <div class="row">
            <div class="col-xs-12 col-sm-9" >
                <div class="row">
                    <div class="col-xs-12 post-header">
                        <h1 itemprop="name" class="post-title" >
                            {{$post->title}}
                        </h1>
                        <img itemprop="image" src="{{$post->image}}" class="img-responsive">

                        <div itemprop="author" itemscope itemtype="http://schema.org/Person" class="post-author">
                            <img class="post-author-image" src="{{$post->user->image}}" >
                            <span itemprop="name" class="post-author-name">
                                {{$post->user->name}}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div itemprop="articleBody" class="col-xs-12 background-white blog-body">
                        <div class="kacana-wysiwyg-block" >
                            {!! $post->bodyLazyLoad !!}
                        </div>
                    </div>
                </div>
                <div class="" >
                    <div class="col-xs-12 background-white" >
                        <div class="fb-comments" data-href="{{Request::url()}}" data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-3" >
                <div class="row">
                    <div class="col-xs-12 left-side-block">
                        <div class="block-header">
                            Cùng chuyên mục
                        </div>
                        <div class="block-body">
                            <ul class="list-post-related">
                                @foreach($relatedPosts as $relatedPost)
                                    <li>
                                        <a href="/tin-tuc/{{$relatedPost->slug}}.{{$relatedPost->id}}" class="avatar">
                                            <img src="{{$relatedPost->image}}" alt="{{$relatedPost->title}}">
                                        </a>
                                        <a href="/tin-tuc/{{$relatedPost->slug}}.{{$relatedPost->id}}" class="title">
                                            {{$relatedPost->title}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 left-side-block">
                        <div class="block-header">
                            Có thể bạn thích
                        </div>
                        <div class="block-body">
                            <div id="listProductPage">
                                <div class="block-tag">
                                    <div class="block-tag-body as-accessories-results">
                                        <div class="taglist as-search-results-tiles background-white">
                                            @forelse($products as $item)
                                                <div class="col-xs-12 product-item" >
                                                    @include('client.product.product-item-related-temple')
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 left-side-block">
                        <div class="block-header">
                            Các chuyên mục nổi bật
                        </div>
                        <div class="block-body">
                            @foreach($post->tags as $tag)
                                <a style="margin-right: 10px" href="/tin-tuc/chuyen-muc/{{str_slug($tag->name)}}.{{$tag->id}}" >{{$tag->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    Kacana.blog.init();
@stop

@section('section-modal')

@stop