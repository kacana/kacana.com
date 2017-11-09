@extends('layouts.admin.master')

@section('title', 'Người dùng')

@section('section-content-id', 'content-list-user')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Quản lý Facebook Comment</h3>
            </div><!-- /.box-header -->
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Search Facebook Comment</h3>

                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="name" class="form-control" placeholder="Search Sender Name"/>
                            <input type="text" name="post_id" class="form-control" placeholder="Search Post"/>
                            <input type="text" name="message" class="form-control" placeholder="Search Message"/>
                            <select class="form-control" name="search_type">
                                <option value="">All Type</option>
                                <option value="{{KACANA_FACEBOOK_COMMENT_TYPE_COMMENT}}">comment</option>
                                <option value="{{KACANA_FACEBOOK_COMMENT_TYPE_LIKE}}">like</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Find</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <button type="submit" class="btn btn-default">Export Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Search result</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="facebookComment" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('javascript')
    Kacana.user.setupDatatableForFacebookComment();
@stop

