@extends('layouts.kcner.master')

@section('title', 'Tracking Người dùng')

@section('section-content-id', 'content-list-user')

@section('content')
    <section>
        <div id="user-tracking-id" data-id="{{$userTracking->id}}" class="custom-box">
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
                        <h3 class="box-title">Thông tin Người dùng</h3>
                    </div>

                    <div class="box-body">
                        <div class="col-xs-12 col-md-4" >
                            <label class="text-aqua">Thông tin chung</label>
                            <p><b>Địa chỉ URL:</b> <a target="_blank" href="{{$userTracking->url}}">{{$userTracking->url}}</a></p>
                            <p><b>Đến từ:</b> <a target="_blank" href="{{$userTracking->referer}}">{{$userTracking->referer}}</a></p>
                            <p><b>Session ID:</b> {{$userTracking->id}}</p>
                            <p><b>Loại Kết Nối:</b> NORMAL</p>
                            <p><b>Ngày:</b> {{$userTracking->created_at}}</p>
                        </div>
                        <div class="col-xs-12 col-md-4" >
                            <label class="text-aqua">Thông tin địa điểm: <a target="_blank" href="https://freegeoip.net/?q={{$userTracking->ip->ip}}">{{$userTracking->ip->ip}}</a></label>
                            <p>Quốc Gia: {{$userTracking->ip->country_name}}</p>
                            <p>Thành phố: {{$userTracking->ip->region_name}}</p>
                            <p>Bản đồ:
                                <a href="https://www.google.com.vn/maps/@{{$userTracking->ip->latitude}},{{$userTracking->ip->longitude}}z" ng-show="record.latitude &amp;&amp; record.longitude" target="_blank" class="ng-binding">
                                    {{$userTracking->ip->latitude}}, {{$userTracking->ip->longitude}}
                                </a>
                            </p>
                        </div>
                    <div class="col-xs-12 col-md-4" >
                        <label class="text-aqua">Thông tin thiết bị người dùng:</label>
                        <p>Trình Duyệt: {{$userTracking->user_agent->ua->family}} - version : {{$userTracking->user_agent->ua->major}}.{{$userTracking->user_agent->ua->minor}}</p>
                        <p>Hệ điều hành: {{$userTracking->user_agent->os->family}} - version : {{$userTracking->user_agent->os->major}}.{{$userTracking->user_agent->os->minor}}</p>
                        <p>Thiết Bị: {{$userTracking->user_agent->device->family}} - hãng : {{$userTracking->user_agent->device->brand}} - model: {{$userTracking->user_agent->device->model}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Lịch sử duyệt trang người dùng</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="userTrackingTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
</section>
@stop
@section('javascript')
    Kacana.user.setupDatatableForUserTracking();
@stop
@extends('admin.user.popup-modal')

