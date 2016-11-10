@extends('layouts.client.master')
@if(isset($address))
    @section('meta-title', 'Chi tiết địa chỉ - '. $address->name)
@else
    @section('meta-title', 'Thêm địa chỉ mới')
@endif

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('/images/client/homepage/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Xin chào {{$user->name}}!</h2>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="customer-page" >
        <div class="page-header-simple" >
            <div class="container">
                <div class="row" >
                    <div class="col-xs-12">
                        SỔ ĐỊA CHỈ
                    </div>
                </div>
            </div>
        </div>
        <div id="customer-account-page" class="container background-white vpadding-10" >
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            @if(isset($address))
                                <p>
                                    Bấm cập nhật để cập nhật địa chỉ của bạn
                                </p>
                            @else
                                <p>
                                    Bấm thêm mới để thêm mới địa chỉ
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="/khach-hang/so-dia-chi"><i class="fa fa-angle-double-left"></i> danh sách địa chỉ</a>
                        </div>
                    </div>
                    @if(isset($permission_denied) && $permission_denied)
                        <div class="row">
                            <div class="col-xs-12 vpadding-10">
                                <div class="alert alert-warning">
                                    {{$permission_denied_message}}
                                </div>
                            </div>
                        </div>
                    @else
                        @if(isset($ok) && $ok)
                            <div class="row">
                                <div class="col-xs-12 vpadding-10">
                                    <div class="alert alert-success">
                                        {{$ok_message}}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 vpadding-10">
                                <form id="form_address_step" class="form-horizontal form-bordered" method="post">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="name">Tên</label>
                                        <div class="col-md-5">
                                            <input id="name" @if(isset($address->name)) value="{{$address->name}}" @endif name="name" placeholder="Họ & tên" class="form-control" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="">Địa chỉ - lầu, số nhà, đường - phường, xã, thị trấn</label>
                                        <div class="col-md-5">
                                            <textarea class="address form-control" rows="3" size="50" placeholder="Địa chỉ - lầu, số nhà, đường - phường, xã, thị trấn" name="street" id="street">@if(isset($address->street)){{$address->street}}@endif</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="">Tỉnh/Thành phố</label>
                                        <div class="col-md-5">
                                            <select name="cityId" class="form-control">
                                                <option value="">Chọn tỉnh/thành phố</option>
                                                @foreach($listCity as $item)
                                                    <option
                                                            @if(isset($address->city_id) && $address->city_id == $item->id) selected="selected" @endif
                                                            value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="">Quận/huyện</label>
                                        <div class="col-md-5">
                                            <select data-district="{{$listDistrict}}" disabled="true" name="districtId" class="form-control">
                                                <option value="">Chọn quận/huyện</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="">Phường, xã</label>
                                        <div class="col-md-5">
                                            <select disabled="true" name="wardId" class="form-control">
                                                <option value="">Chọn phường/xã</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="">Điện thoại di động</label>
                                        <div class="col-md-5">
                                            <input id="phone"  @if(isset($address->phone)) value="{{$address->phone}}" @endif name="phone" placeholder="Nhập số điện thoại" class="form-control" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-5 ol-xs-offset-0 col-sm-offset-4">
                                            <button class="btn btn-primary" id="next-step" type="submit">
                                                @if(isset($address))
                                                    Cập nhật
                                                @else
                                                    Thêm mới
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-xs-12 col-sm-3">
                    @include('client.customer.customer-nav')
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')
    Kacana.customer.address.init();
@stop
@section('section-modal')

@stop