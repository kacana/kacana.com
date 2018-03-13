<script type="template" id="list-cart-item-template">
    <div class="cart-header" >
        <div class="row" >
            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" >
                <h5 class="color-grey-light">${cart.quantity} Sản phẩm</h5>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-6 col-lg-5" >
                <h5 class="color-grey-light">Chi tiết</h5>
            </div>
            <div class="hidden-xs hidden-sm hidden-md col-lg-2" >
                <h5 class="color-grey-light text-center">Số lượng</h5>
            </div>
            <div class="hidden-xs hidden-sm col-md-3 col-lg-2" >
                <h5 class="color-grey-light text-center">Giá</h5>
            </div>
        </div>
    </div>
    @{{each items}}
        <div class="cart-item" >
            <div class="row" >
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3" >
                    <a target="_blank" href="${this.options.url}"><img class="img-responsive" src="${this.options.image}"></a>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-6 col-lg-5 detail-information-product" >
                    <div class="cart-item-title" >
                        <a target="_blank" href="${this.options.url}">${this.name}</a>
                    </div>

                    @{{if this.options.colorId}}
                        <div class="cart-item-color">
                            Màu sắc: ${this.options.colorName}
                        </div>
                    @{{/if}}

                    @{{if this.options.sizeId}}
                        <div class="cart-item-size" >
                            Kích thước: ${this.options.sizeName}
                        </div>
                    @{{/if}}

                    <div class="cart-item-price" >
                        Giá: ${this.options.origin_price_show}
                    </div>
                    @{{if parseInt(this.options.main_discount)}}
                        <div class="cart-item-price" >
                            Giảm giá: <span class="color-red" >${this.options.main_discount_show}</span>
                        </div>
                    @{{/if}}
                    @{{if parseInt(this.options.main_discount) == 0 && this.options.current_discount}}
                        @{{if this.options.current_discount.discount_type == 3}}
                            <div class="cart-item-price" >
                                Tặng <a target="_blank" class="color-red" href="${this.options.current_discount.product_ref.url_product_detail}">${this.options.current_discount.product_ref.name} <img style="width: 50px;" src="${this.options.current_discount.product_ref.image}"></a>
                            </div>
                        @{{/if}}
                        @{{if this.options.current_discount.discount_type != 3}}
                            <div class="cart-item-price" >
                                Giảm giá: <span class="color-red" >${Kacana.utils.savingDiscount(this.options.current_discount.discount_type, this.options.current_discount.ref,this.options.origin_price)}</span>
                            </div>
                        @{{/if}}
                    @{{/if}}
                    <div class="hidden-lg" >
                        <span class="pull-left cart-item-price" >số lượng:</span>
                        <div class="input-group cart-quantity">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[${this.rowId}]">
                                  <span class="fa fa-minus"></span>
                              </button>
                            </span>
                                <input type="text" name="quant[${this.rowId}]" data-id="${this.rowId}" data-old-value="${this.quantity}" class="form-control input-number" value="${this.quantity}" min="1" max="10">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[${this.rowId}]">
                                  <span class="fa fa-plus"></span>
                              </button>
                            </span>
                        </div>
                    </div>
                    <div class="hidden-lg hidden-md" >
                        Tổng: <b>${this.options.subtotalShow}</b>
                    </div>
                    <div class="cart-button-remove" >
                        <a data-id="${this.rowId}" class="color-green" href="#remove-cart-item" >xoá sản phẩm này</a>
                    </div>
                </div>
                <div class="hidden-xs hidden-sm hidden-md col-lg-2" >
                    <div class="input-group cart-quantity">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[${this.rowId}]">
                              <span class="fa fa-minus"></span>
                          </button>
                        </span>
                        <input type="text" name="quant[${this.rowId}]" data-id="${this.rowId}" data-old-value="${this.quantity}" class="form-control input-number" value="${this.quantity}" min="1" max="10">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[${this.rowId}]">
                              <span class="fa fa-plus"></span>
                          </button>
                        </span>
                    </div>
                </div>
                <div class="hidden-xs hidden-sm col-md-3 col-lg-2 cart-item-total" >
                    ${this.options.subtotalShow}
                </div>
            </div>
        </div>
    @{{/each}}
</script>
<script type="template" id="cart-information-template">
    <div class="border-bottom margin-bottom" >
        <div class="row" >
            <div class="col-xs-12">
                <h5 >
                    Thông tin đơn hàng
                </h5>
            </div>
        </div>
    </div>
    <div class="border-bottom margin-bottom" >
        <div class="row" >
            <div class="col-xs-12 margin-bottom">
                <span class="pull-left" >
                    Tạm tính
                </span>
                <span class="pull-right">
                    ${cart.originTotalShow}
                </span>
            </div>
            @{{if parseInt(cart.discount)}}
                <div class="col-xs-12 margin-bottom">
                    <span class="pull-left" >
                        Giảm giá
                    </span>
                    <span class="pull-right color-red">
                        ${cart.discountShow}
                    </span>
                </div>
            @{{/if}}
            <div class="col-xs-12 margin-bottom">
                <span class="pull-left" >
                    Phí vận chuyển <a href="/contact/chinh-sach-van-chuyen" target="_blank"  ><i class="fa fa-info-circle"></i></a>
                </span>
                @{{if parseInt(cart.total) >= 500000}}
                    <span class="pull-right">
                        miễn phí
                    </span>
                @{{/if}}
                @{{if parseInt(cart.total) < 500000}}
                <span class="pull-right text-red text-right">
                        Hồ Chí Minh: 15.000 đ <br> Khác: 30.000 đ
                </span>
                @{{/if}}
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-xs-12">
            <span class="pull-left" >
                <h5>Thành tiền<small>(Đã bao gồm VAT)</small></h5>
            </span>
            <span class="pull-right" >
                <h5 class="cart-totals" >
                    ${cart.totalShow}
                    @{{if parseInt(cart.total) < 500000}}
                        <small class="text-red" >+ Ship</small>
                    @{{/if}}
                </h5>
            </span>
        </div>
    </div>
    <div class="col-xs-12 score-save margin-bottom">
            <span class="pull-left" >
                <h5>Điểm tích luỹ</h5>
            </span>
        <span class="pull-right" >
                <h5 class="cart-totals" >${parseInt(cart.total/10000)} điểm <small>(${Kacana.utils.formatCurrency(parseInt(cart.total*0.05))})</small></h5>
            </span>
    </div>
</script>
