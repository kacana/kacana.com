<div id="modal-create-order" class="modal fade" role="dialog">
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
                            <div class="form-group col-xs-6">
                                <label class="control-label" for="">Tỉnh/Thành phố</label>
                                <select required name="cityId" class="form-control">
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    @foreach($listCity as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xs-6">
                                <label class="control-label" for="">Quận/huyện</label>
                                <select required data-district="{{$listDistrict}}" disabled="true" name="districtId" class="form-control">
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                            <div class="form-group col-xs-6">
                                <label class="control-label" for="">Phường, xã</label>
                                <select required disabled="true" name="wardId" class="form-control">
                                    <option value="">Chọn phường/xã</option>
                                </select>
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