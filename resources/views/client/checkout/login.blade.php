<section class="panel vpadding-10">
    <div class="row" >
        <div class="col-sm-6 col-xs-12" >
            <form id="form_login_step" class="form-group form-bordered" method="post" action="/checkout?step=address">
                <div class="form-group">
                    <label class="col-xs-12 control-label text-left" for="inputDefault">Xin vui lòng nhập email:</label>
                    <div class="col-xs-12">
                        <input id="email" name="email" value="@if(isset($userOrder['email'])){{$userOrder['email']}}@endif" class="form-control" type="text"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12">
                        <input id="option-not-signup" checked="checked" type="radio" value="1" name="optionSignup">
                        Đặt hàng mà không cần đăng ký
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-xs-12">
                        <input id="option-signup" type="radio" value="0" name="optionSignup">
                        Tôi đã có tài khoản tại kacana.com
                    </label>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password" name="password" placeholder="vui lòng nhập mật khẩu" disabled class="form-control" type="password">
                    </div>
                </div>
                <div class="form-group margin-bottom-5px">
                    <div class="col-sm-8">
                        <button class="btn btn-primary btn-login-form" id="next-step" type="submit">Tiếp tục »</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <a style="font-weight: 400;" href="/khach-hang/quen-mat-khau" class="control-label" for="inputDefault">Quên mật khẩu?</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-6 col-xs-12" >
            <div class="form-group form-bordered" method="get">
                <div class="form-group margin-bottom-5px">
                    <div style="font-weight: 600" class="col-md-12">
                        Hoặc đăng nhập với
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
    </div>
</section>