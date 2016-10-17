<script id="template-cart-popup-header" type="template">
        <table cellspacing="0" class="cart table-border">
            <tbody>
            @{{each cart.items}}
            <tr id="cart-item-${this.id}" class="cart_table_item">
                <td class="product-image">
                    <img src="${this.options.image}" width="70px"/>
                </td>

                <td class="product-name">
                            <span>
                                <a class="a-b" href="${this.options.url}">
                                    ${this.name}
                                    <br>
                                    <span class="detail-cart-item" >
                                        @{{if this.quantity > 1}}
                                            Số lượng: ${this.quantity}
                                        @{{/if}}
                                        @{{if this.quantity > 1 && this.options.colorId}}
                                         |
                                        @{{/if}}
                                        @{{if this.options.colorId}}
                                            ${this.options.colorName}
                                        @{{/if}}
                                        @{{if this.options.sizeId}}
                                        - ${this.options.sizeName}
                                        @{{/if}}
                                    </span>
                                </a>
                            </span>
                </td>

                <td class="product-subtotal" align="right">
                    <span class="amount"><strong>${this.options.priceShow}</strong></span>
                </td>
            </tr>
            @{{/each }}
            </tbody>
        </table>
        <div class="btn-go-to-cart">
            <a href="/thanh-toan" class="btn btn-primary">Tới giỏ hàng</a>
        </div>
</script>

<div id="login-signup-header-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="login-header-popup">
    <button type="button" class="close" data-dismiss="modal"><span class="pe-7s-close" ></span></button>
    <div class="modal-dialog login-form-wrap" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-xs-6 col-sm-6 text-center tab-login active" >Đăng Nhập</div>
                <div class="col-xs-6 col-sm-6 text-center tab-signup" >Đăng Kí</div>
                <div class="clear"></div>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-8 login-form-block" >
                    <div class="alert alert-danger hidden">

                    </div>
                    <form id="login-signup-form-popup" class="form-horizontal form-bordered" method="post">
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
                                <button class="btn btn-primary btn-login-form" id="submit-login-form-popup" type="submit">Đăng Nhập</button>
                                <div class="margin-top-5px">
                                    <a href="/forgot-password">Quên mật khẩu?</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-4 login-social-block" >
                    <div class="form-horizontal form-bordered" method="get">
                        <div class="form-group margin-bottom-5px">
                            <div class="col-md-12">
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
                <div class="clear"></div>
            </div>
            <div class="modal-footer">
                <p class="text-center">
                    Tôi đã đọc và đồng ý với <a href="/privacy-policy/" target="_blank">điều khoản sử dụng</a> của Kacana.
                </p>
            </div>
        </div>
    </div>
</div>
 @include('/client/product/product-item-js-template');
