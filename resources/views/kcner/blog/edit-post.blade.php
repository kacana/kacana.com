@extends('layouts.kcner.master')

@section('title', 'Edit Post: '.$post['title'])

@section('section-content-id', 'content-edit-post')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{$post['title']}}</h3>
                    </div><!-- /.box-header -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-xs-12">
                <div class="box box-primary box-body"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Cập Nhật Post</h3>
                    </div><!-- /.box-header -->
                    {!! Form::open(array('method'=>'post', 'id' =>'form-edit-post', 'enctype'=>"multipart/form-data")) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('name', 'ID') !!}
                            {!! Form::text('id', $post->id, array('required', 'id' => 'postId', 'class' => 'form-control', 'disabled'=>'disabled', 'placeholder' => 'Id')) !!}
                            <input name="id" class="hidden" value="{{$post->id}}" >
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Người viết') !!}
                            {!! Form::text('user_name', $post->user->name, array('required', 'class' => 'form-control', 'disabled'=>'disabled', 'placeholder' => 'Id')) !!}
                        </div>
                        <!-- name -->
                        <div class="form-group">
                            {!! Form::label('name', 'Title') !!}
                            {!! Form::text('title', $post->title, array('required', 'class' => 'form-control', 'placeholder' => 'Title')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Chuyên mục') !!}
                            <select name="tag_id" class="form-control" >
                                @foreach($tags as $tag)
                                    <option @if($post->tag_id == $tag->id) selected @endif value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- status -->
                        <div class="form-group">
                            {!! Form::label('name', 'Status') !!}
                            <select name="status" class="form-control" >
                                <option @if($post->status == KACANA_BLOG_POST_STATUS_ACTIVE) selected="selected" @endif value="{{KACANA_BLOG_POST_STATUS_ACTIVE}}"> Active </option>
                                <option @if($post->status == KACANA_BLOG_POST_STATUS_INACTIVE) selected="selected" @endif value="{{KACANA_BLOG_POST_STATUS_INACTIVE}}"> InActive </option>
                            </select>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Tag Group') !!}
                            <button disabled="disabled" type="button" id="add-group-tag-to-product-tag" class="btn btn-xs btn-primary"><i class="fa fa-plus" ></i> Thêm</button>
                            <button disabled="disabled" type="button" id="remove-group-tag-from-product-tag" class="btn btn-xs btn-danger"><i class="fa fa-trash" ></i> Xoá</button>
                            <select id="group-tag-for-post" class="form-control" multiple size="3">
                                @if(count($groupTag))
                                    @foreach($groupTag as $item)
                                        <option value="{{$item->child_id}}" >{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            {!! Form::label('post_tags', 'Tag Post') !!}
                            <select name="post_tags[]" id="post_tags" class="form-control post_tags" multiple size="3">
                                @if(count($post->tags))
                                    @foreach($post->tags as $tag)
                                        <option value="{{$tag->id}}" selected >{{$tag->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/product/tag">Huỷ</a>
                        <button type="submit" id="btn-update" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div><!-- /.box -->

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách POST</h3>

                    </div>
                    <div class="box-body no-padding">
                        <table id="commentTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
            <div class="col-sm-7 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Hình đại diện</h3>
                    </div><!-- /.box-header -->

                    <div id="post-image-main" class="modal-body">
                        <!-- property -->
                        <div class="box-tools margin-bottom">

                            <div id="image-main-post-upload-container"></div>
                            <button type="button" id="select-file-main-image" class="btn btn-sm btn-primary">
                                <i class="icon icon-plus"></i> <span>Select File</span>
                                <input type="file" class="hide">
                            </button>

                            <button type="button" id="banner-upload-btn" class="btn btn-sm btn-success hide">
                                <i class="icon icon-upload-alt"></i> <span>Confirm</span>
                            </button>
                            @if($post['image'])
                                <button type="button" id="banner-remove-btn" class="btn btn-sm btn-danger">
                                    <i class="icon icon-remove-circle"></i> <span>Remove</span>
                                </button>
                            @endif
                        </div>
                        <div class="row">
                            <div class="banner-cropper col-md-12 margin-bottom">
                                <img style="width: 100%;" class="banner-cropper-preview" src="">
                            </div>
                            @if($post['image'])
                                <div class="col-md-12" id="current-baner-for-product" >
                                    <img style="width: 100%;" src="{{$post['image']}}">
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nội dung</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('name', 'nội dung post  ') !!}
                            <div data-table="blog_posts" data-field="body" data-id="{{$post->id}}" class="kacana-editor-content" contenteditable="true" name="post_body" id="property">{!! $post->body !!}</div>
                        </div>
                        <button id="btn-upload-image-desc" class="" ></button>
                        <div id="image-upload-container"></div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/product/tag">Huỷ</a>
                        <button type="submit" id="btn-update" class="btn btn-primary">Cập nhật</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </section>
@stop

@section('javascript')
    Kacana.blog.detail.init();
@stop

