<script id="template-product-item" type="template">
    @{{each products}}
    <div class="col-xxs-12 col-xs-6 col-sm-4 col-md-3 product-item" >
        <div class="product-image" >
            <a href="${this.urlProductDetail}" title="${this.name}">
                <img src="${this.image}" alt="${this.name}" name="${this.name}">
            </a>
        </div>

        <div class="product-info">
            <div itemprop="name" class="product-title"> <a href="${this.urlProductDetail}" title="${this.name}">${this.name}</a></div>
        </div>

        <div class="product-price-wrap">
            <div class="product-price">
                @{{if this.current_discount != null}}
                    ${Kacana.utils.formatCurrency(Kacana.utils.calculateDiscountPrice(this.sell_price, this.current_discount.discount_type, this.current_discount.ref))}
                @{{/if}}

                @{{if this.current_discount == null}}
                    ${this.sell_price_show}
                @{{/if}}
            </div>

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
                </div>
            @{{/if}}
        </div>

        <div class="product-item-action">
            @{{if this.status == 3}}
                <span data-id="${this.id}" class="btn btn-danger sold-out-btn">hết hàng</span>
            @{{/if}}
            @{{if this.status == 1}}
                <span data-id="${this.id}" class="quick-order-btn">Thêm vào giỏ hàng</span>
            @{{/if}}
        </div>
    </div>
    @{{/each}}
</script>