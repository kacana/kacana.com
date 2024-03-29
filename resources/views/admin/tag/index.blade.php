@extends('layouts.admin.master')

@section('title', 'Tag manager')

@section('section-content-id', 'content-tag-system')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Tag</h3>
                <div class="box-tools pull-left ">
                    <button class="btn btn-primary btn-sm create-tag-btn" type="button">
                        <i class="fa fa-tag"></i>
                        Create tag
                    </button>
                </div>
            </div><!-- /.box-header -->
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Search tag</h3>

                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="search" class="form-control" placeholder="Search"/>
                            <select class="form-control" name="searchStatus">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Find</button>
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
                        <h3 class="box-title">Search result</h3>

                    </div>
                    <div class="box-body no-padding">
                        <table id="tagTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@extends('admin.tag.modal')
@section('javascript')
    Kacana.tag.init();
@stop