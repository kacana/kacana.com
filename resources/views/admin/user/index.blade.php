@extends('layouts.admin.master')

@section('title', 'Người dùng')

@section('section-content-id', 'content-list-user')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Quản lý Người dùng</h3>
            </div><!-- /.box-header -->
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Search user</h3>

                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="name" class="form-control" placeholder="Search Name"/>
                            <input type="text" name="email" class="form-control" placeholder="Search Email"/>
                            <input type="text" name="phone" class="form-control" placeholder="Search Phone"/>
                            <select class="form-control" name="searchRole">
                                <option value="">All Role</option>
                                <option value="{{KACANA_USER_ROLE_ADMIN}}">Admin</option>
                                <option value="{{KACANA_USER_ROLE_BUYER}}">Buyer</option>
                                <option value="{{KACANA_USER_ROLE_PARTNER}}">Partner</option>
                            </select>
                            <select class="form-control" name="searchStatus">
                                <option value="">All Status</option>
                                <option value="{{KACANA_USER_STATUS_ACTIVE}}">Active</option>
                                <option value="{{KACANA_USER_STATUS_INACTIVE}}">Inactive</option>
                                <option value="{{KACANA_USER_STATUS_BLOCK}}">Block</option>
                                <option value="{{KACANA_USER_STATUS_CREATE_BY_SYSTEM}}">create by sys</option>
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
                        <table id="userTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('javascript')
    Kacana.user.setupDatatableForUser();
@stop
@extends('admin.user.popup-modal')

