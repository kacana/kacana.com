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
                        Giá: ${this.options.priceShow}
                    </div>
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
                    ${cart.totalShow}
                </span>
            </div>
            <div class="col-xs-12 margin-bottom">
                <span class="pull-left" >
                    Phí vận chuyển
                </span>
                <span class="pull-right">
                    miễn phí
                </span>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-xs-12  margin-bottom">
            <span class="pull-left" >
                <h5>Thành tiền</h5> (Đã bao gồm VAT)
            </span>
            <span class="pull-right" >
                <h5 class="cart-totals" >${cart.totalShow}</h5>
            </span>
        </div>
    </div>
    <div class="row" >
        <div class="col-xs-12 margin-bottom">
            <a class="btn btn-primary" id="payment" href="/checkout?step=login">TIẾN HÀNH THANH TOÁN</a>
        </div>
    </div>
</script>
