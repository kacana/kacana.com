<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facebook Comment</title>

    <style>
        .facebook-comment-box{
            max-width:940px;
            margin:auto;
            border:1px solid #eee;
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#000;
        }

        .facebook-comment-box .item{
            height: 100px;
            width: 415px;
            padding: 5px;
            border: 1px solid #ccc;
            margin: 10px;
            display: inline-block;
        }

        .facebook-comment-box .item .image{
            display: inline-block;
        }

        .facebook-comment-box .item .description{
            display: inline-block;
            height: 100px;
            overflow: hidden;
            width: 310px;
        }

        .facebook-comment-box .item .description .name{

        }

        .facebook-comment-box .item .description .comment{

        }
    </style>
</head>

<body>
<div class="facebook-comment-box">
    @foreach($facebookComment as $item)
        <div class="item" >
            <div class="image" >
                <img src="http://graph.facebook.com/{{$item->sender_id}}/picture?type=large" style="width:100px">
            </div>
            <div class="description">
                <div class="name"><b>{{$item->sender_name}}</b> <small>{{$item->created_at}}</small></div>
                <div class="comment"><small>{{$item->message}}</small></div>
            </div>
        </div>
    @endforeach
</div>
<script>
//    window.print();
</script>
</body>
</html>