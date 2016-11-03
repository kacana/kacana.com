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
                            <div class="order-detail-item border-bottom vpadding-1">
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
                                            Giá: ${this.price}
                                        </div>
                                        <div class="cart-item-price">
                                            Số lượng:  ${this.quantity}
                                        </div>
                                        <div class="cart-item-price color-red">
                                            Tổng:  ${this.subtotal}
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-sm-2 cart-item-total">
                                        <input type="checkbox" value="${this.id}" name="orderDetailId[]" >
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
                    <div class="col-sm-10">
                        <b>{{$user_address->name}}</b><br> {{$user_address->street}}, {{$user_address->district->name}}, {{$user_address->city->name}}
                    </div>
                </div>
                <div class="form-group">
                    <button id="btn-check-fee-ship" type="button" class="col-sm-4 col-sm-offset-4 btn btn-primary">Kiểm tra phí ship</button>
                </div>
                <div id="list-shipping-fee" class="form-group">
                    @foreach($shippingServiceInfos as $shippingServiceInfo)
                        <div class="radio margin-bottom">
                            <label class="col-xs-12" >
                                <span class="col-xs-1 col-xs-offset-1" ><input id="shippingServiceTypeId" type="radio" checked="" value="{{$shippingServiceInfo->ServiceID}}" name="shippingServiceTypeId"></span>
                                <span class="col-xs-5" >{{$shippingServiceInfo->ServiceName}}</span>
                                <span class="col-xs-5" >Cước: <strong>{{formatMoney($shippingServiceInfo->ServiceFee)}}</strong></span>
                            </label>
                        </div>
                    @endforeach
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
                <span class="col-xs-1 col-xs-offset-1" ><input id="shippingServiceTypeId" type="radio" checked="" value="${this.ServiceID}" name="shippingServiceTypeId"></span>
                <span class="col-xs-5" >${this.ServiceName}</span>
                <span class="col-xs-5" >Cước: <strong>${this.ServiceFee}</strong></span>
            </label>
        </div>
    @{{/each }}
</script>

<div id="modal-add-product-order" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Tạo đơn hàng</h4>
            </div>
            <form role="form" method="post" action="/order/createOrder">
                <div class="modal-body">
                    <div class="box-body">
                        <p class="lead text-green">Địa chỉ nhận hàng</p>
                        <input id="deliveryId" name="deliveryId" class="hidden" value="5" >
                        <div class="row" >
                            <div class="form-group col-xs-6">
                                <label for="delivery_name">Tên</label>
                                <input required name="deliveryName" type="text" placeholder="tên người nhận hàng" id="deliveryName" class="form-control">
                            </div>
                            <div class="form-group col-xs-6">
                                <label for="deliveryPhone">Số điện thoại</label>
                                <input required name="deliveryPhone" type="text" placeholder="Số điện thoại" id="deliveryPhone" class="form-control">
                            </div>
                            <div class="form-group col-xs-12">
                                <label for="deliveryStreet">Địa chỉ - lầu, số nhà, đường, phường</label>
                                <textarea required id="deliveryStreet" class="deliveryStreet form-control" rows="3" size="50" placeholder="Địa chỉ - lầu, số nhà, đường, phường" name="deliveryStreet"></textarea>
                            </div>

                            <div class="form-group col-xs-12">
                                <label for="delivery_email">Email</label>
                                <input name="deliveryEmail" type="email" placeholder="Email người dùng(tuỳ chọn)" id="deliveryEmail" class="form-control">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="button" id="create-new-address-delivery" class="btn btn-warning" value="tạo đại chỉ mới"/>
                    <input type="submit" class="btn btn-primary" value="Tạo đơn hàng"/>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


