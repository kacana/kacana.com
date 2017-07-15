<script id="template-product-item" type="template">
    @{{each products}}
    <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-4 product-item" >
        <div class="product-image" >
            <div class="product-image-inside royalSlider rsDefault" data-first-image="${this.image}"  >
                <a data-rsbigimg="${this.image}" href="{{AWS_CDN_URL.PRODUCT_IMAGE_PLACE_HOLDER}}" class="rsImg" title="${this.name}">
                    ${this.name}
                    <img class="rsTmb" data-original="${this.image}" />
                </a>
                @{{if this.properties_js}}
                    @{{each this.properties_js}}
                        @{{if this.product_gallery}}
                            <a id="product-property-gallery-id-${this.id}" class="rsImg" data-rsbigimg="${this.product_gallery.image}" href="${this.product_gallery.image}" >
                                ${this.color_name}
                                <img class="rsTmb" data-original="${this.product_gallery.image}"/>
                            </a>
                        @{{/if}}
                    @{{/each}}
                @{{/if}}
            </div>
        </div>

        @{{if this.properties_js}}
            <div class="list-color-product multiple-items nav" >
                @{{each this.properties_js}}
                    @{{if this.product_gallery}}
                        <div>
                            <a data-id="${this.color_id}" href="#choose-product-color">
                                <img  data-original="${this.product_gallery.image}">
                            </a>
                        </div>
                    @{{/if}}
                @{{/each}}
            </div>
        @{{/if}}

        @{{if !this.properties_js}}
            <div class="list-color-product multiple-items nav" >
                <div>
                    <a >
                        <img  data-original="${this.image}">
                    </a>
                </div>
            </div>
        @{{/if}}

        <div class="product-info">
            <div class="product-title"> <a href="${this.urlProductDetail}" title="${this.name}">${this.name}</a></div>
        </div>

        <div class="product-price-wrap">
            @{{if parseInt(this.discount)}}
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
            @{{if !(parseInt(this.discount))}}
                <div class="product-price">${this.sell_price_show}</div>
            @{{/if}}
        </div>
        <div class="product-short-description-like-wrap">
            <div class="product-short-description-wrap text-center" id="product-short-description-wrap- ${this.id}">
                <div class="product-short-description hidden-xs">
                    ${this.short_description}
                </div>
                @{{if this.isLiked}}
                <span class="save-product-wrap hidden-xs active pull-left" >
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
                <span class="save-product-wrap hidden-xs pull-left">
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
                @{{if this.status == 3}}
                    <span class="btn btn-danger sold-out-btn">
                        hết hàng
                    </span>
                @{{/if}}
                @{{if this.status == 1}}
                    <span data-id="${this.id}" class="quick-order-btn">
                        mua ngay
                    </span>
                @{{/if}}
                <span class="pull-right viewless-wrap" >
                        <a href="#show-less-short-desc" class="viewless" >
                            <i class="fa fa-angle-double-up" ></i>
                        </a>
                </span>
                <span class="pull-right hidden-xs viewmore-wrap" >
                        <a href="#show-more-short-desc" class="viewmore" >
                            <i class="fa fa-angle-double-down" ></i>
                        </a>
                    </span>
                <div class="product-item-box-footer"></div>
            </div>
        </div>
    </div>
    @{{/each}}
</script>