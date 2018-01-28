@extends('layouts.admin.master')
@section('title', 'Chi tiết tag '.$tag->name)
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Tag: {{$tag->name}}</h3>
                    </div><!-- /.box-header -->
                    @if($success)
                        <div class="alert alert-success">
                            {{$success}}
                        </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="box box-primary box-body"> <!-- Search results -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Cập Nhật Tag</h3>
                        </div><!-- /.box-header -->
                        {!! Form::open(array('method'=>'post', 'id' =>'form-edit-tag', 'enctype'=>"multipart/form-data")) !!}
                        <div class="modal-body">
                            <div class="form-group">
                                {!! Form::label('name', 'ID') !!}
                                {!! Form::text('id', $tag->id, array('required', 'class' => 'form-control', 'disabled'=>'disabled', 'placeholder' => 'Tag')) !!}
                            </div>
                            <!-- name -->
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', $tag->name, array('required', 'class' => 'form-control', 'placeholder' => 'Tag')) !!}
                            </div>
                            <!-- name SEO -->
                            <div class="form-group">
                                {!! Form::label('name', 'Name SEO') !!}
                                {!! Form::text('name_seo', $tag->name_seo, array('required', 'class' => 'form-control', 'placeholder' => 'Tag')) !!}
                            </div>
                            <!-- status -->
                            <div class="form-group">
                                {!! Form::label('name', 'Status') !!}
                                <select name="status" class="form-control" >
                                    <option @if($tag->status == KACANA_TAG_STATUS_ACTIVE) selected="selected" @endif value="{{KACANA_TAG_STATUS_ACTIVE}}"> Active </option>
                                    <option @if($tag->status == KACANA_TAG_STATUS_INACTIVE) selected="selected" @endif value="{{KACANA_TAG_STATUS_INACTIVE}}"> InActive </option>
                                </select>
                            </div>
                            <!--  short description -->
                            <div class="form-group">
                                {!! Form::label('short_desc', 'Miêu tả ngắn') !!}
                                {!! Form::textarea('short_desc', $tag->short_desc, ['size' => '30x4','class' => 'form-control']) !!}
                            </div>

                            <!--  description -->
                            <div class="form-group">
                                {!! Form::label('description', 'Miêu tả') !!}
                                <div class="kacana-editor-content" contenteditable="true" name="description" id="description">
                                    {!! $tag->description !!}
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" href="/product/tag">Huỷ</a>
                            <button type="submit" id="btn-update" class="btn btn-primary">Cập nhật</button>
                        </div>
                        {!! Form::close() !!}
                    </div><!-- /.box -->
                </div>

                <div class="col-xs-8">
                    <div class="box box-primary box-body"> <!-- Search results -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Danh sách sản phẩm của Tag <b>{{$tag->name}}</b></h3>
                        </div><!-- /.box-header -->

                        <div class="box-body table-responsive no-padding">
                            <table id="productTagTable" class="table table-striped"></table>
                            <div class="clearfix"></div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </div>
    </section>
@stop
@section('javascript')
    Kacana.tag.detailTag.init();
@stop

