@extends('layouts.kcner.master')

@section('title', 'KacanaEr Management')

@section('section-content-id', 'content-index-page')

@section('content')

    <style>

        .bgimg-1 {
            position: relative;
            opacity: 0.65;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: inherit;

        }
        .bgimg-1 {
            background-image: url("https://source.unsplash.com/1600x400?bags,purses,backpacks");
            height: 100%;
        }

        .caption {
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            text-align: center;
            color: #000;
        }

        .caption span.border {
            background-color: #111;
            color: #fff;
            padding: 18px;
            font-size: 25px;
            letter-spacing: 10px;
        }

        h3 {
            letter-spacing: 5px;
            text-transform: uppercase;
            font: 20px "Lato", sans-serif;
            color: #111;
        }
    </style>
    <style type="text/css">@keyframes fadeInOpacity{0%{opacity:0}to{opacity:1}}:hover>*>.fbvd--wrapper{animation-name:fadeInOpacity;animation-duration:.3s;opacity:1}.fbvd--wrapper{position:absolute;top:10px;left:10px;opacity:0;text-align:center;margin:0;z-index:5}.fbvd--wrapper a{background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiI+PHBhdGggZmlsbD0iIzRiNGY1NiIgZD0iTTggMTUuNWw3LjUtNy41aC00LjV2LThoLTZ2OGgtNC41eiI+PC9wYXRoPjwvc3ZnPg==) no-repeat 3px 4.55px; background-color: #fff; display:inline-block;font:700 14px Helvetica,Arial,sans-serif;color:#4b4f56;text-decoration:none;vertical-align:middle;padding:0px 8px 0px;margin-right:8px;border-radius:2px; line-height: 22px; padding-left:19px; border: 1px solid #e7e7e7; background-size: 13px}.fbvd--wrapper a:last-child{margin-right:0}.fbvd--wrapper a:hover{text-decoration:none}.fbvd--wrapper a:focus{box-shadow:0 0 1px 2px rgba(88,144,255,.75),0 1px 1px rgba(0,0,0,.15);outline:none}.fbvd--wrapper b{font-size:13px;position:relative;top:1px;color:#3b5998;font-weight:400}</style></head>
    <div class="bgimg-1">
        <div class="caption">
            <span class="border">{{Auth::getUser()->name}}</span>
            <br>
            <br>
            <br>
            <span class="border">Fighting together to get GOAL!</span>
        </div>
    </div>

@stop

@section('javascript')
    Kacana.blog.listPost.init();
@stop