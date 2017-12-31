@extends('layouts.client.master')
@section('meta-title', 'Cập nhật mật khẩu mới')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('{{KACANA_URL_BACKGROUND_BANNER_DEFAULT}}');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h1 class="short text-shadow big white bold">Quên mật khẩu</h1>
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
                        Mật khẩu mới
                    </div>
                </div>
            </div>
        </div>
        <div id="customer-forgot-password-page" class="container background-white vpadding-10" >
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    @if($check && !isset($updated))
                        <div class="row">
                            <div class="col-xs-12">
                                <p>
                                    Nhập mật khẩu mới của bạn dưới đây để đặt lại.
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <p>
                                <form id="form-new-password" method="post" action="" class="form-horizontal form-bordered view-type">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Mật khẩu</label>
                                        <div class="col-md-4">
                                            <input type="password" autocomplete="" value="" placeholder="nhập mật khẩu mới của bạn!" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Nhập lại mật khẩu</label>
                                        <div class="col-md-4">
                                    <input type="password" value="" placeholder="nhập lại mật khẩu mới của bạn!" name="confirmPassword" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-md-offset-2 vpadding-10">
                                            <button type="submit" class="btn kacana-button-green">Gửi</button>
                                        </div>
                                    </div>

                                </form>
                                </p>
                            </div>
                        </div>
                        @elseif($check && isset($updated) && $updated)
                            <div class="row">
                                <div class="col-xs-12">
                                    <p style="color: #ffffff" class="label-success text-center vpadding-10" >
                                        Cập nhật mật khẩu thành công!
                                    </p>
                                    <p>
                                        Hàng ngàn sản phẩm thời trang xinh lung linh đang chờ bạn <a href="/">Shopping Now!</>
                                    </p>
                                </div>
                            </div>
                        @elseif($check && isset($updated) && !$updated)
                            <div class="row">
                                <div class="col-xs-12">
                                    <p  style="color: #ffffff" class="label-danger  text-center vpadding-10" >
                                        Cập nhật mật khẩu thất bại!
                                    </p>
                                    <p>
                                        Vui lòng check lại các bước cập nhật hoặc liên với <a href="/contact/thong-tin-lien-he">trung tâm hỗ trợ</a> của Kacana
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>
                                        Liên kết này không tồn tại hoặc đã hết hạn
                                    </p>
                                    <p>
                                        Nếu bạn muốn lấy lại mật khẩu.Bạn có thể cập nhật lại mật khẩu <a href="/khach-hang/quen-mat-khau">tại đây !</>
                                    </p>
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
    Kacana.customer.newPassword.init();
@stop
@section('section-modal')

@stop