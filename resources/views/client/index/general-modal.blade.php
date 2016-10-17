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

<script id="template-product-item" type="template">
    @{{each products}}
    <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
        <div class="product-image" >
            <div class="product-image-inside royalSlider rsDefault" >
                <a data-rsbigimg="${this.image}" href="${this.image}" class="rsImg bugaga" title="${this.name}">
                    ${this.name}
                    <img class="rsTmb" src="${this.image}" alt="${this.name}"/>
                </a>
                @{{each this.properties_js}}
                    @{{if this.product_gallery}}
                        <a id="product-property-gallery-id-${this.id}" class="rsImg bugaga" data-rsbigimg="${this.product_gallery.image}" href="${this.product_gallery.image}" >
                            ${this.color_name}
                            <img class="rsTmb" src="${this.product_gallery.image}"/>
                        </a>
                    @{{/if}}
                @{{/each}}
            </div>
        </div>

        <div class="product-info">
            <div class="product-title"> <a href="${this.urlProductDetail}" title="${this.name}">${this.name}</a></div>
        </div>

        <div class="product-price-wrap">
            @{{if this.discount}}
            <div class="product-price discount">
                <div class="discount-info">
                    <div class="product-price-original">
                        ${this.sell_price_show}
                    </div>
                    <div class="price-discount" >
                        Giảm giá: <b>${this.discount_show}</b>
                    </div>
                </div>
                ${this.price_after_discount_show}</div>
            @{{/if}}
            @{{if !this.discount}}
            <div class="product-price">${this.sell_price_show}</div>
            @{{/if}}
        </div>
        <div class="product-short-description-wrap" id="product-short-description-wrap- ${this.id}">
            <div class="product-short-description">
                ${this.short_description}
            </div>
            @{{if this.isLiked}}
            <span class="save-product-wrap active" >
                        <a
                                data-product-id="${this.id}"
                                data-product-url="${this.urlProductDetail}"
                                href="#remove-product-like"
                                data-offset="-5"
                                data-distance-away="-7"
                                data-position="bottom left"
                                data-title="Bỏ lưu sản phẩm này"
                                data-popup-kacana="title"
                                class="save-product" >

                            <i class="pe-7s-like" ></i>
                            <i class="fa fa-heart" ></i>
                        </a>
                    </span>
            @{{/if}}
            @{{if !this.isLiked}}
            <span class="save-product-wrap">
                        @{{if this.is_login}}
                <a
                        data-product-id="${this.id}"
                        data-product-url="${this.urlProductDetail}"
                        href="#save-product-like"
                        data-offset="-5"
                        data-distance-away="-7"
                        data-position="bottom left"
                        data-title="Lưu sản phẩm này"
                        data-popup-kacana="title"
                        class="save-product" >

                                <i class="pe-7s-like" ></i>
                                <i class="fa fa-heart" ></i>
                            </a>
                @{{/if}}
                @{{if !this.is_login}}
                <a
                        data-product-id="${this.id}"
                        data-product-url="${this.urlProductDetail}"
                        href="#login-header-popup"
                        data-offset="-5"
                        data-distance-away="-7"
                        data-position="bottom left"
                        data-title="Đăng nhập để lưu sản phẩm"
                        data-popup-kacana="title"
                        class="save-product" >

                                <i class="pe-7s-like" ></i>
                                <i class="fa fa-heart" ></i>
                            </a>
                @{{/if}}
                    </span>
            @{{/if}}

            <span class="pull-right viewless-wrap" >
                    <a href="#show-less-short-desc" class="viewless" >
                        <i class="fa fa-angle-double-up" ></i>
                    </a>
                </span>
            <span class="pull-right viewmore-wrap" >
                    <a href="#show-more-short-desc" class="viewmore" >
                        <i class="fa fa-angle-double-down" ></i>
                    </a>
                </span>
            <div class="product-item-box-footer"></div>
        </div>
    </div>
    @{{/each}}
</script>
