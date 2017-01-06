@extends('layouts.client.master')

@section('meta-title', 'Tin tức')

@section('content')
    <div class="container" id="blog-page">
        <div class="row">
            @foreach($posts as $post)
                <div class="promote thread col-xs-12" data-author="{{$post->user->name}}">
                    <div class="thread-info width-narrow">
                        <span class="poster-avatar">
                            <a href="#" class="avatar" data-avatarhtml="true">
                                <img src="{{$post->user->image}}" alt="TTKM" height="96" width="96">
                            </a>
                        </span>
                        <span class="poster">
                            <a href="#" class="username" dir="auto">{{$post->user->name}}</a>
                        </span>
                        <span class="process-time">
                            <a href="/tin-tuc/{{$post->slug}}.{{$post->id}}" class="Tooltip">{{formatTimeAgo($post->updated_at)}}</a>
                        </span>
                        <span class="forum">
                            <span>trong</span>
                            <a href="/tin-tuc/chuyen-muc/{{str_slug($post->tag->name)}}.{{str_slug($post->tag->id)}}">{{$post->tag->name}}</a>
                        </span>
                    </div><!-- .thread-info -->
                    <div class="thread-image width-wide" data-src="{{$post->image}}">
                        <a href="/tin-tuc/{{$post->slug}}.{{$post->id}}">
                            <img src="{{$post->image}}">
                        </a>
                    </div>
                    <div class="thread-title width-narrow">
                        <a href="/tin-tuc/{{$post->slug}}.{{$post->id}}">{{$post->title}}</a>
                    </div>
                    <div class="post-body width-narrow">
                        <article>
                            <blockquote class="messageText ugc baseHtml">
                                <a href="/tin-tuc/{{$post->slug}}.{{$post->id}}" class="snippet block">
                                    {!! trim_text($post->body, 600, true, true) !!}
                                </a>
                            </blockquote>
                        </article>
                    </div>
                    <div class="post-controls controls width-narrow">
                        <a href="/tin-tuc/{{$post->slug}}.{{$post->id}}" class="control views">
                            <span>
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                <span class="counter color-grey" style="">{{$post->count_item_blog_post_view}}</span>
                            </span>
                        </a>
                        <a href="/tin-tuc/{{$post->slug}}.{{$post->id}}" class="control replies">
                            <span>
                                <i class="fa fa-comment-o" aria-hidden="true"></i>
                                <span class="counter color-grey" style="">{{$post->count_item_blog_comment}}</span>
                            </span>
                        </a>
                    </div>
                    <div class="separator width-wide">&nbsp;</div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-xs-12 text-center" >
                {!! $posts->appends(['sort' => (isset($options['sort']))?$options['sort']:''])->render() !!}
            </div>
        </div>
    </div>
@stop

@section('javascript')

@stop

@section('section-modal')

@stop