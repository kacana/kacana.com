@extends('layouts.client.master')
@section('meta-title', 'Đăng kí')
@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('/images/client/homepage/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Đăng nhập</h2>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="auth-page" >
        <div class="page-header-simple" >
            <div class="container">
                <div class="row" >
                    <div class="col-xs-12">
                        Người dùng
                    </div>
                </div>
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

