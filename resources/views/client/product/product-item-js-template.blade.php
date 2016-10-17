<script id="template-product-item" type="template">
    @{{each products}}
    <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
        <div class="product-image" >
            <div class="product-image-inside royalSlider rsDefault" >
                <a data-rsbigimg="${this.image}" href="${this.image}" class="rsImg bugaga" title="${this.name}">
                    ${this.name}
                    <img class="rsTmb" src="${this.image}" alt="${this.name}"/>
                </a>
                @{{each this.properties}}
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