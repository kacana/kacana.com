@extends('layouts.client.master')
@section('meta-title', 'Quản lý tài khoản')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('{{KACANA_URL_BACKGROUND_BANNER_DEFAULT}}');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h1 class="short text-shadow big white bold">Xin chào {{$user->name}}!</h1>
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
                        QUẢN LÝ TÀI KHOẢN
                    </div>
                </div>
            </div>
        </div>
        <div id="customer-account-page" class="container background-white vpadding-10" >
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Trong mục quản lý tài khoản, bạn có thể xem các hoạt động gần đây của bạn cũng như quản lý thông tin tài khoản. Chọn một link bên dưới để xem hay chỉnh sửa thông tin.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h5>
                                Thông tin tài khoản
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 vpadding-10">
                            @if(isset($accountUpdateInformation) && $accountUpdateInformation['ok'])
                                <div class="alert alert-success">
                                    cập nhật thông tin thành công
                                </div>
                            @elseif(isset($accountUpdateInformation)&& !$accountUpdateInformation['ok'])
                                <div class="alert alert-danger">
                                    {{$accountUpdateInformation['error_message']}}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 vpadding-10">
                            <form id="form-update-account-information" method="post" action="/khach-hang/cap-nhat-thong-tin" class="form-horizontal form-bordered view-type">
                                <div class="form-group">
                                    <label for="inputDefault" class="col-md-2 control-label">Họ tên</label>
                                    <div class="col-md-4">
                                        <input data-value="{{$user->name}}" type="text" value="{{$user->name}}" readonly placeholder="tên của bạn" name="name" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputDisabled" class="col-md-2 control-label">Số điện thoại</label>
                                    <div class="col-md-4">
                                        <input data-value="{{$user->phone}}" type="text" value="{{$user->phone}}" readonly placeholder="Số điện thoại" name="phone" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputDisabled" class="col-md-2 control-label">Email</label>
                                    <div style="margin-top: 5px" class="col-md-4">
                                        {{$user->email}}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-2 vpadding-10 view-type-hidden">
                                        <button type="button" id="btn-cancel-account-information" class="btn">Cancel</button>
                                    </div>
                                    <div class="col-md-2 vpadding-10 view-type-hidden">
                                        <button type="submit" id="btn-update-account-information" class="btn kacana-button-red">Cập nhật</button>
                                    </div>
                                    <div class="col-md-2 col-md-offset-4 vpadding-10">
                                        <button type="button" id="btn-change-account-information" class="btn kacana-button-green">Chỉnh sửa</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 vpadding-10">
                            @if(isset($accountUpdatePassword) && $accountUpdatePassword['ok'])
                                <div class="alert alert-success">
                                    cập nhật mật khẩu thành công
                                </div>
                            @elseif(isset($accountUpdatePassword)&& !$accountUpdatePassword['ok'])
                                <div class="alert alert-danger">
                                    {{$accountUpdatePassword['error_message']}}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h5>
                                Mật khẩu
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 vpadding-10">
                            <form id="form-change-password" method="post" action="/khach-hang/cap-nhat-mat-khau" class="form-horizontal form-bordered view-type">
                                <div class="form-group">
                                    <label for="inputDefault" class="col-md-2 control-label">Mật khẩu hiện tại</label>
                                    <div class="col-md-4">
                                        <input type="password" value="" readonly placeholder="Mật khẩu hiện tại" name="currentPassword" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group view-type-hidden">
                                    <label for="inputDisabled" class="col-md-2 control-label">Mật khẩu mới</label>
                                    <div class="col-md-4">
                                        <input type="password" value="" placeholder="Mật khẩu mới" name="password" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group view-type-hidden">
                                    <label for="inputDisabled" class="col-md-2 control-label">Nhập lại mật khẩu</label>
                                    <div class="col-md-4">
                                        <input type="password" value="" placeholder="Nhập lại mật khẩu mới" name="confirmPassword" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-2 vpadding-10 view-type-hidden">
                                        <button type="button" id="btn-cancel-account-password" class="btn">Cancel</button>
                                    </div>
                                    <div class="col-md-2 vpadding-10 view-type-hidden">
                                        <button type="submit" id="btn-update-account-password" class="btn kacana-button-red">Cập nhật</button>
                                    </div>
                                    <div class="col-md-2 col-md-offset-4 vpadding-10">
                                        <button type="button" id="btn-change-account-password" class="btn kacana-button-green">Chỉnh sửa</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    @include('client.customer.customer-nav')
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')
    Kacana.customer.account.init();
@stop
@section('section-modal')

@stop