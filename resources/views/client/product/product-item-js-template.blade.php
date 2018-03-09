<script id="template-product-item" type="template">
    @{{each products}}
    <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-4 product-item" >
        <div class="product-image" >
            <div class="product-image-inside royalSlider rsDefault" data-first-image="${this.image}"  >
                <a data-rsbigimg="${this.image}" href="{{AWS_CDN_URL.PRODUCT_IMAGE_PLACE_HOLDER}}" class="rsImg" title="${this.name}">
                    ${this.name}
                    <img class="rsTmb" data-src="${this.image}" />
                </a>
                @{{if this.properties_js}}
                    @{{each this.properties_js}}
                        @{{if this.product_gallery}}
                            <a id="product-property-gallery-id-${this.id}" class="rsImg" data-rsbigimg="${this.product_gallery.image}" href="${this.product_gallery.image}" >
                                ${this.color_name}
                                <img class="rsTmb" data-src="${this.product_gallery.image}"/>
                            </a>
                        @{{/if}}
                    @{{/each}}
                @{{/if}}
            </div>
        </div>

        @{{if this.properties_js}}
            <div class="list-color-product multiple-items nav hidden-xs" >
                @{{each this.properties_js}}
                    @{{if this.product_gallery}}
                        <div>
                            <a data-id="${this.color_id}" href="#choose-product-color">
                                <img  data-src="${this.product_gallery.image}">
                            </a>
                        </div>
                    @{{/if}}
                @{{/each}}
            </div>
        @{{/if}}

        @{{if !this.properties_js}}
            <div class="list-color-product multiple-items nav hidden-xs" >
                <div>
                    <a >
                        <img  data-src="${this.image}">
                    </a>
                </div>
            </div>
        @{{/if}}

        <div class="product-info">
            <h2 itemprop="name" class="product-title"> <a href="${this.urlProductDetail}" title="${this.name}">${this.name}</a></h2>
        </div>

        <div class="product-price-wrap">
            @{{if this.current_discount != null}}
                <div class="product-price discount">
                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="discount-info">
                        @{{if this.current_discount.discount_type == 3}}
                            <div itemprop="price" class="product-free">
                                Tặng <a target="_blank" href="${this.current_discount.product_ref.urlProductDetail}"><img src="${this.current_discount.product_ref.image}"></a>
                            </div>
                        @{{/if}}
                        @{{if this.current_discount.discount_type != 3}}
                            <div itemprop="price" class="product-price-original">
                                ${this.sell_price_show}
                            </div>
                        @{{/if}}
                    </div>
                    ${Kacana.utils.formatCurrency(Kacana.utils.calculateDiscountPrice(this.sell_price, this.current_discount.discount_type, this.current_discount.ref))}
                </div>
                <div class="discount-tag">
                    <img src="{{AWS_CDN_URL}}/images/client/discount_tag_small.png">
                    @{{if this.current_discount.discount_type == 3}}
                        <div class="product-free-tag">
                            <a target="_blank" href="${this.current_discount.product_ref.urlProductDetail}"><img src="${this.current_discount.product_ref.image}"></a>
                        </div>
                    @{{/if}}
                    @{{if this.current_discount.discount_type != 3}}
                        <div class="discount-tag-ref">${Kacana.utils.discountTagRef(this.current_discount.discount_type, this.current_discount.ref)}</div>
                    @{{/if}}
                </div>
            @{{/if}}
            @{{if this.current_discount == null}}
                <div class="product-price">${this.sell_price_show}</div>
            @{{/if}}
        </div>
        <div class="product-short-description-like-wrap">
            <div class="product-short-description-wrap text-center" id="product-short-description-wrap- ${this.id}">
                <div itemprop="description" class="product-short-description">
                    ${this.short_description}
                </div>
                @{{if this.isLiked}}
                <span class="save-product-wrap hidden-xs active pull-left" >
                    <a  data-product-id="${this.id}"
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
                        Thêm vào giỏ hàng
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