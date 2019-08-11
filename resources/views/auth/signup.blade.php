@extends('layouts.client.master')
@section('meta-title', 'Đăng kí')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('{{AWS_CDN_URL}}/images/client/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h1 class="short text-shadow big white bold">Đăng ký</h1>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="auth-page" >
        <div data-spm="breadcrumb" class="breadcrumb_list breadcrumb_custom_cls" data-spm-max-idx="2">
            <div class="container">
                <ul class="breadcrumb">
                    <li class="breadcrumb_item">
                    <span class="breadcrumb_item_text">
                        <a title="Trang chủ" href="/" class="breadcrumb_item_anchor">
                            <span>Trang chủ</span>
                        </a>
                        <div class="breadcrumb_right_arrow"><i class="fa fa-angle-right"></i></div>
                    </span>
                    </li>
                    <li class="breadcrumb_item">
                        <span class="breadcrumb_item_text">
                            <a title="Trang chủ" href="#" class="breadcrumb_item_anchor">
                               <span>Tài khoản</span>
                            </a>
                            <div class="breadcrumb_right_arrow"><i class="fa fa-angle-right"></i></div>
                        </span>
                    </li>
                    <li class="breadcrumb_item">
                        <span class="breadcrumb_item_text">
                            <span class="breadcrumb_item_anchor breadcrumb_item_anchor_last">Đăng ký</span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container login-form-wrap background-white" >
            <div class="col-xs-12 col-sm-8 login-form-block" >
                @if(isset($error_message))
                    <div class="alert alert-danger">
                        {{$error_message}}
                    </div>
                @endif
                <form id="login-signup-form" action="/auth/signup" class="form-horizontal form-bordered" method="post">
                    <div class="form-group for-signup">
                        <label class="col-md-3 control-label" for="inputDefault">Tên *</label>
                        <div class="col-md-6">
                            <input id="name" name="name" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Địa chỉ email *</label>
                        <div class="col-md-6">
                            <input id="email" name="email" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group for-signup">
                        <label class="col-md-3 control-label" for="inputDefault">Số ĐT *</label>
                        <div class="col-md-6">
                            <input id="phone" name="phone" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="inputDefault">Mật khẩu *</label>
                        <div class="col-md-6">
                            <input id="password" name="password" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="form-group for-signup">
                        <label class="col-md-3 control-label" for="inputDefault">Nhập lại mật khẩu *</label>
                        <div class="col-md-6">
                            <input id="confirmPassword" name="confirmPassword" class="form-control" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button class="btn btn-primary btn-login-form" id="submit-login-form-popup" type="submit">Đăng ký</button>
                            <div class="margin-top-5px vpadding-10">
                                Bạn là thành viên của KACANA? <a href="/auth/login">Đăng nhập tại đây!</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-4 login-social-block" >
                <div class="form-horizontal form-bordered" method="get">
                    <div class="form-group margin-bottom-5px">
                        <div class="col-md-12">
                            Hoặc đăng ký với
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-social facebook" id="btn-facebook-login-popup"><i class="fa fa-facebook"></i>Facebook</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-social google" id="btn-google-login-popup"><i class="fa fa-google-plus"></i>Google+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
@stop


@section('javascript')
    Kacana.auth.signup();
@stop
@section('section-modal')

@stop

