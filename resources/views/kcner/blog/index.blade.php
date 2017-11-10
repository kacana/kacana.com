@extends('layouts.kcner.master')

@section('title', 'Blog Management')

@section('section-content-id', 'content-blog-page')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Quản lý POST</h3>
                <div class="box-tools pull-left ">
                    <button id="create-post-btn" class="btn btn-primary btn-sm create-post-btn" type="button">
                        <i class="fa fa-clipboard"></i>
                        Tạo POST
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm POST</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="name" class="form-control" placeholder="Tên Post"/>
                            <select class="form-control" name="searchTagId">
                                <option value="">Chuyên mục</option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách POST</h3>

                    </div>
                    <div class="box-body no-padding">
                        <table id="postTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@extends('admin.blog.modal')

@section('javascript')
    Kacana.blog.listPost.init();
@stop