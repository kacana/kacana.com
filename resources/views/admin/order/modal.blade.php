<div id="modal-shipping-order" class="modal fade" role="dialog">
    <div class="modal-dialog">

    </div>
</div>

<script id="template-shipping-order" type="template">
    <form id="form-shipping-order" class="form-horizontal" accept-charset="UTF-8" action="/shipping/createShipping" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tạo vận đơn cho khách hàng:${addressReceive.name}</h4>
            </div>
            <div style="max-height: 400px; overflow:auto;" class="modal-body">
                <div class="col-xs-12" id="list-order-detail">
                    @{{if orderDetails}}
                        @{{each orderDetails}}
                            <div class="order-detail-item vpadding-1">
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3">
                                        <img src="${this.image}" class="img-responsive" style="width: 60%">
                                    </div>
                                    <div class="col-xs-7 col-sm-7">
                                        <div class="cart-item-title">
                                            <a href="${this.url}" target="_blank">${this.name}</a>
                                        </div>
                                        <div class="vmargin-1">
                                            <span class="label label-success" >${this.order_service_id}</span>
                                        </div>
                                        <div class="cart-item-price">
                                            Giá: ${Kacana.utils.formatCurrency(this.price)}
                                        </div>
                                        <div class="cart-item-price">
                                            Số lượng:  ${this.quantity}
                                        </div>
                                        @{{if this.discount_type == 3}}
                                            <div class="cart-item-price">
                                               Tặng: ${this.discount_product_ref.name} <img style="width: 50px" src="${this.discount_product_ref.image}">
                                            </div>
                                        @{{/if}}
                                        @{{if this.discount_type != 3 && this.discount_type > 0}}
                                            <div class="cart-item-price">
                                                Giảm giá: ${Kacana.utils.savingDiscount(this.discount_type, this.discount_ref, this.price)}
                                            </div>
                                        @{{/if}}
                                        <div class="cart-item-price color-red">
                                            Tổng:  ${Kacana.utils.formatCurrency(this.subtotal)}
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-sm-2 cart-item-total">
                                        <input type="checkbox" data-total="${this.subtotal}" checked="checked" value="${this.id}" name="orderDetailId[]" >
                                    </div>
                                </div>
                            </div>
                        @{{/each}}
                    @{{else}}
                        <div class="text-center">
                            <h4 class="text-danger" >Không có sản phẩm trong kho để tạo đơn hàng</h4>
                        </div>
                    @{{/if}}
                </div>
                <div class="clear" ></div>
            </div>
            <div class="border-top padding-1" >
                <div class="form-group col-xs-4">
                    <label class="control-label text-red" for="phone">Tổng COD</label>
                    <div>
                        <input id="total_cod" disabled="disabled" class="form-control" type="text" value="0" name="totalCod" plaequired="required">
                    </div>
                </div>

                <div style="margin: 0 10px" class="form-group  col-xs-4">
                    <label class="control-label" for="phone">Phí Ship</label>
                    <div >
                        <input id="ship_fee" class="form-control" type="text" value="40000" name="shipFee" placeholder="Phí ship" required="required">
                    </div>
                </div>
                <div class="form-group  col-xs-4">
                    <label class="control-label text-purple" for="phone">Đã thanh toán</label>
                    <div >
                        <input id="paid" class="form-control" type="text" value="0" name="paid" placeholder="Đã thanh " required="required">
                    </div>
                </div>
                <div style="margin-right: 10px" class="form-group  col-xs-6">
                    <label class="control-label text-green" for="phone">Giảm thêm</label>
                    <div >
                        <input id="extra_discount" class="form-control" type="text" value="0" name="extraDiscount" placeholder="Giảm thêm" required="required">
                    </div>
                </div>
                <div class="form-group  col-xs-6 ">
                    <label class="control-label text-red" for="phone">Ghi chú đơn hàng(bắt buộc)</label>
                    <div >
                        <select class="form-control" name="OrderClientNote" >
                            <option value="Cho xem hàng, không cho thử" >Cho xem hàng, không cho thử</option>
                            <option value="" >Không cho xem hàng</option>
                            <option value="Cho thử hàng" >Cho thử hàng</option>
                        </select>
                    </div>
                </div>
                <div style="margin-right: 10px" class="form-group col-xs-6 ">
                    <label class="control-label text-green" for="phone">Diễn giải giảm thêm</label>
                    <div >
                        <textarea class="form-control" rows="1" size="50" placeholder="Mô tả cho việc giảm thêm để in vận đơn" name="extraDiscountDesc"></textarea>
                    </div>
                </div>
                <div class="form-group col-xs-6 ">
                    <label class="control-label text-green" for="phone">Ghi chú đơn hàng</label>
                    <div >
                        <textarea class="form-control" rows="1" size="50" placeholder="Ghi chú đơn hàng" name="OrderContentNote"></textarea>
                    </div>
                </div>
                <div class="clear" ></div>
            </div>
            <div class="border-top padding-1" >
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="phone">Khối lượng</label>
                    <div class="col-sm-4">
                        <input id="Weight" class="form-control" type="text" value="{{KACANA_SHIP_DEFAULT_WEIGHT}}" name="Weight" plaequired="required">
                        <input class="form-control hidden" type="text" value="{{$order->id}}" name="orderId" plaequired="required">
                    </div>
                    <label class="col-sm-2 control-label" for="phone">Dài</label>
                    <div class="col-sm-4">
                        <input id="Length" class="form-control" type="text" value="{{KACANA_SHIP_DEFAULT_LENGTH}}" name="Length" placeholder="Dài" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="phone">Rộng</label>
                    <div class="col-sm-4">
                        <input id="Width" class="form-control" type="text" value="{{KACANA_SHIP_DEFAULT_WIDTH}}" name="Width" placeholder="Rộng" plaequired="required">
                    </div>
                    <label class="col-sm-2 control-label" for="phone">Cao</label>
                    <div class="col-sm-4">
                        <input id="Height" class="form-control" type="text" value="{{KACANA_SHIP_DEFAULT_HEIGHT}}" name="Height" placeholder="Cao" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="phone">kho hàng</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="pickHubId" name="pickHubId" >
                            @foreach($hubInfos as $hubInfo)
                                <option data-district-code="{{$hubInfo->DistrictCode}}" value="{{$hubInfo->PickHubID}}" >{{$hubInfo->Address.', '.$hubInfo->DistrictName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="phone">Đến</label>
                    @if($user_address->district_id)
                        <div class="col-sm-10">
                            <b>{{$user_address->name}}</b><br> {{$user_address->street}}, {{$user_address->district->name}}, @if($user_address->ward_id) {{$user_address->ward->name}} @endif {{$user_address->city->name}}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button id="btn-check-fee-ship" type="button" class="col-sm-4 col-sm-offset-4 btn btn-primary">Kiểm tra phí ship</button>
                </div>
                <div id="list-shipping-fee" class="form-group">
                    <input id="origin-ship-fee" name="originShipFee" value="0" class="hidden"/>
                    <div id="list-shipping-ghn-fee">
                        @if(isset($shippingServiceInfos))
                            @foreach($shippingServiceInfos as $shippingServiceInfo)
                                <div class="radio margin-bottom">
                                    <label class="col-xs-12" >
                                        <span class="col-xs-1 col-xs-offset-1" ><input data-value="{{$shippingServiceInfo->ServiceFee}}" id="shippingServiceTypeId" type="radio" checked="" value="{{$shippingServiceInfo->ServiceID}}" name="shippingServiceTypeId"></span>
                                        <span class="col-xs-5" >{{$shippingServiceInfo->ServiceName}}</span>
                                        <span class="col-xs-5" >Giá: <strong>{{formatMoney($shippingServiceInfo->ServiceFee)}}</strong></span>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div id="list-shipping-ghtk-fee">
                        @if(isset($feeGhtk) && $feeGhtk->fee->fee)
                            <div class="radio margin-bottom">
                                <label class="col-xs-12" >
                                    <span class="col-xs-1 col-xs-offset-1" ><input data-value="{{$feeGhtk->fee->fee}}" type="radio" checked="" value="{{KACANA_SHIP_TYPE_ID_GHTK}}" name="shippingServiceTypeId"></span>
                                    <span class="col-xs-5 text-danger text-bold" >Giao Hàng Tiết Kiệm</span>
                                    <span class="col-xs-5" >Giá: <strong>{{formatMoney($feeGhtk->fee->fee)}}</strong></span>
                                </label>
                            </div>
                        @else
                            <div class="radio margin-bottom">
                                <label class="col-xs-12" >
                                    <span class="col-xs-1 col-xs-offset-1" ><input disabled data-value="" type="radio" value="{{KACANA_SHIP_TYPE_ID_GHTK}}"></span>
                                    <span class="col-xs-5 text-danger text-bold" >Giao Hàng Tiết Kiệm</span>
                                    <span class="col-xs-5" > Chưa hỗ trợ </span>
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit"  @{{if !orderDetails}} disabled="disabled" @{{/if}} class="btn btn-primary" >Tạo vận đơn</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
</script>

<script id="template-shipping-fee" type="template">
    @{{each listFee}}
        <div class="radio">
            <label class="col-xs-12" >
                <span class="col-xs-1 col-xs-offset-1" ><input data-value="${this.ServiceFee}" id="shippingServiceTypeId" type="radio" checked="" value="${this.ServiceID}" name="shippingServiceTypeId"></span>
                <span class="col-xs-5" >${this.ServiceName}</span>
                <span class="col-xs-5" >Giá: <strong>${Kacana.utils.formatCurrency(this.ServiceFee)}</strong></span>
            </label>
        </div>
    @{{/each }}
</script>

<script id="template-shipping-ghtk-fee" type="template">
    @{{if ghtkFee.fee.fee }}
        <div class="radio">
            <label class="col-xs-12" >
                <span class="col-xs-1 col-xs-offset-1" ><input data-value="${ghtkFee.fee.fee}" type="radio" checked="" value="{{KACANA_SHIP_TYPE_ID_GHTK}}" name="shippingServiceTypeId"></span>
                <span class="col-xs-5 text-danger text-bold" >Giao Hàng Tiết Kiệm</span>
                <span class="col-xs-5" >Giá: <strong>${Kacana.utils.formatCurrency(ghtkFee.fee.fee)}</strong></span>
            </label>
        </div>
    @{{else}}
        <div class="radio margin-bottom">
            <label class="col-xs-12" >
                <span class="col-xs-1 col-xs-offset-1" ><input disabled data-value="" type="radio" value="{{KACANA_SHIP_TYPE_ID_GHTK}}"></span>
                <span class="col-xs-5 text-danger text-bold" >Giao Hàng Tiết Kiệm</span>
                <span class="col-xs-5" > Chưa hỗ trợ </span>
            </label>
        </div>
    @{{/if}}
</script>

<div id="modal-add-product-order" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Thêm sản phẩm</h4>
            </div>
            <form role="form" method="post" action="/order/addProductToOrder">
                <div class="modal-body">
                    <div class="box-body">
                        <input id="deliveryId" name="orderId" class="hidden" value="{{$order->id}}" >
                        <div class="row" >
                            <div class="form-group col-xs-12">
                                <label for="delivery_email">Nhập tên sản phẩm</label>
                                <input name="search_product_name" placeholder="Nhập tên sản phẩm muốn thêm" id="order_search_product_to_add" class="form-control">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-primary" value="Thêm"/>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


