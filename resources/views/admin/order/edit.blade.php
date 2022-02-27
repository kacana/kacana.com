@extends('layouts.admin.master')

@section('title','Edit Order #'.$order->id )

@section('section-content-id', 'content-edit-order')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Đơn Hàng: #{{$order->order_code}} Của [{{$order->user->name}}] Tổng {{formatMoney($order->total)}}</h3>
                <div class="box-tools pull-left ">
                    @if($order->order_type == KACANA_ORDER_TYPE_ONLINE)
                        @if(isset($feeGhtk) && $feeGhtk && count($order->orderDetail))
                            <button data-toggle="modal" data-target="#modal-shipping-order" class="btn btn-primary btn-sm">
                                <i class="fa fa-plane"></i> Ship cho khách
                            </button>
                        @elseif(isset($feeGhtk) && $feeGhtk && !count($order->orderDetail))
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-ban"></i> Vui lòng thêm sản phẩm
                                </button>
                        @else
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Vui lòng cập nhật địa chỉ khách hàng
                            </button>
                        @endif
                    @else
                        @if(!isset($feeGhtk) && $feeGhtk)
                            <a href="#cus-address-info-block" class="btn btn-warning btn-sm">
                                <i class="ion-alert-circled"></i> Vui lòng cập nhật địa chỉ khách hàng
                            </a>
                        @endif
                        @if($order->status == KACANA_ORDER_STATUS_NEW || $order->status == KACANA_ORDER_STATUS_PROCESSING || $order->status == KACANA_ORDER_STATUS_QUICK_ORDER)
                            <a href="#export-product-store" data-toggle="modal" data-order-id="{{$order->id}}" class="btn btn-primary btn-sm">
                                <i class="ion-android-plane"></i> kiểm tra và xuất sản phẩm
                            </a>
                        @elseif($order->status == KACANA_ORDER_STATUS_COMPLETE)
                            <a href="#" disabled="true" data-toggle="modal" data-order-id="{{$order->id}}" class="btn btn-success btn-sm">
                                Đơn hàng đã hoàn thành!
                            </a>
                            <a href="#show-invoice-at-store" data-toggle="modal" data-order-id="{{$order->id}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> xem hoá đơn
                            </a>
                        @endif
                    @endif

                    @if($order->status == KACANA_ORDER_STATUS_NEW || $order->status == KACANA_ORDER_STATUS_QUICK_ORDER)
                        <a href="#cancel-order" data-order-id="{{$order->id}}" class="btn btn-danger">
                            <i class="ion-android-exit"></i> Huỷ đơn hàng
                        </a>
                    @endif

                    @if($order->status == KACANA_ORDER_STATUS_CANCEL)
                        <a href="#" class="btn btn-danger">
                            Đơn hàng đã huỷ
                        </a>
                    @endif
                </div>
            </div><!-- /.box-header -->
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin đơn hàng</h3>
                        <div class="box-tools pull-right">
                            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <p class="lead">Thông tin Giá</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody><tr>
                                        <th style="width:50%">Giá</th>
                                        <td>{{formatMoney($order->origin_total)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Số lượng</th>
                                        <td>{{$order->quantity}} Sản phẩm</td>
                                    </tr>
                                    <tr>
                                        <th>phí vận chuyển</th>
                                        <td>{{formatMoney($order->shipping_fee)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Giảm giá</th>
                                        <td>{{formatMoney($order->discount)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng</th>
                                        <td class="color-red">{{formatMoney($order->total + $order->shipping_fee)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <p class="lead">Thông tin người mua hàng</p>
                            <form class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="inputEmail3">Order ID:</label>
                                        <div class="col-sm-9">
                                            <input value="{{$order->id}}" data-user-id="{{$order->user_id}}" id="order_id" disabled="disabled"  class="form-control disabled">
                                            <input value="{{$order->address_id}}" id="order_address_id" disabled="disabled"  class="form-control hidden disabled">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="inputEmail3">Tên</label>
                                        <div class="col-sm-9">
                                            <input value="{{$order->user->name}}" disabled="disabled"  class="form-control disabled">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="inputEmail3">Số điện thoại</label>
                                        <div class="col-sm-9">
                                            <input value="{{$order->user->phone}}" disabled="disabled"  class="form-control disabled">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="inputEmail3">Email</label>
                                        <div class="col-sm-9">
                                            <input value="{{$order->user->email}}" disabled="disabled"  class="form-control disabled">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="inputEmail3">Ngày đặt</label>
                                        <div class="col-sm-9">
                                            <input value="{{$order->created_at}}" disabled="disabled"  class="form-control disabled">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="cus-address-info-block" class="col-xs-12">
                            <p class="lead">Thông tin nhận hàng</p>
                            {!! Form::open(array('method'=>'put', 'id' =>'form-edit-order', 'class'=>"form-horizontal")) !!}
                            <div class="box-body">
                                <!-- name -->
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{$user_address->id}}" />
                                    {!! Form::label('name', 'Họ và tên', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                      {!! Form::text('name', ($user_address)?$user_address->name:'', array('required', 'class' => 'form-control', 'placeholder' => 'Họ và tên')) !!}
                                    </div>
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    {!! Form::label('phone', 'Điện thoại', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                    {!! Form::text('phone', $user_address->phone, array('required', 'class' => 'form-control', 'placeholder' => 'Điện thoại')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Email', 'Email', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email', $user_address->email, array( 'class' => 'form-control', 'placeholder' => 'Email')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('street', 'Địa chỉ', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                    {!! Form::text('street', $user_address->street, array('required', 'class'=>'form-control', 'placeholder'=>'Địa chỉ')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('hamlet', 'thôn/ấp/xóm/tổ', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        {!! Form::text('hamlet', $user_address->hamlet, array('required', 'class'=>'form-control', 'placeholder'=>'thôn/ấp/xóm/tổ')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('city_id', 'Thành phố', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                    {!! Form::select('city_id', $cities, ($user_address)?$user_address->city_id:'', array('required', 'class'=>'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Quận', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        @if($user_address->district_id)
                                            <select required data-district="{{$districts}}" id="district" class="form-control" name="district_id">
                                                @foreach($districts as $district)
                                                    @if(($user_address->city_id == $district->city_id))
                                                        <option @if(($user_address->district_id == $district->id)) selected="selected" @endif data-city-id="{{$district->city_id}}" value="{{$district->id}}">{{$district->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select disabled required data-district="{{$districts}}" id="district" class="form-control" name="district_id">
                                                @foreach($districts as $district)
                                                        <option data-city-id="{{$district->city_id}}" value="{{$district->id}}">{{$district->name}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Phường/Xã', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        @if($user_address->district_id)
                                            <select required id="wardId" class="form-control" name="ward_id">
                                                <option value="">Chọn phường/xã</option>
                                                @foreach($wards as $ward)
                                                    <option @if(($user_address->ward_id == $ward->id)) selected="selected" @endif value="{{$ward->id}}">{{$ward->name}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select required id="wardId" class="form-control" disabled name="ward_id">
                                                <option value="">Chọn phường/xã</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="btn-update"class="btn btn-primary">Cập nhật</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-8">
                <div class="box box-primary box-body"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Chi tiết đơn hàng</h3>
                        <div class="box-tools pull-right">
                            <button data-toggle="modal" data-target="#modal-add-product-order" class="btn btn-box-tool"><i class="fa fa-plus"></i> Thêm sản phẩm</button>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive no-padding">
                        <div id="list-order-detail" class="col-xs-12">
                            <div class="cart-header border-bottom" >
                                <div class="row" >
                                    <div class="col-xs-3 col-sm-3" >
                                        <h4 class="color-grey-light">{{$order->quantity}} Sản phẩm</h4>
                                    </div>
                                    <div class="col-xs-6 col-sm-6" >
                                        <h4 class="color-grey-light text-center">Chi tiết</h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3" >
                                        <h4 class="color-grey-light text-center">Shipping</h4>
                                    </div>
                                </div>
                            </div>
                            @foreach($order->orderDetail as $orderDetail)
                            <div class="order-detail-item border-bottom vpadding-1" >
                                <div class="row" >
                                    <div class="col-xs-3 col-sm-3" >
                                        <img style="width: 100%" class="img-responsive" src="{{$orderDetail->image}}">
                                    </div>
                                    <div class="col-xs-6 col-sm-6" >
                                        <form method="POST" accept-charset="UTF-8" action="/order/updateOrderDetail/{{$order->id}}/{{$orderDetail->id}}" class="form-horizontal">
                                            <div class="cart-item-title text-center" >
                                              <a target="_blank" href="{{$orderDetail->product_url}}"> {{$orderDetail->name}}</a>
                                            </div>

                                            <div class="cart-item-price" >
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <label class="col-sm-4 control-label" for="inputEmail3">ĐH từ</label>
                                                    <div class="col-xs-8">
                                                        <select disabled="disabled" name="order-from-id" class="form-control order-from-id" data-order-from-id="{{$orderDetail->order_from_id}}">
                                                            <option value="0" >
                                                                Chọn đơn hàng từ đâu
                                                            </option>
                                                            @foreach($orderFroms as $orderFrom)
                                                                <option value="{{$orderFrom->id}}" @if($orderDetail->order_from_id == $orderFrom->id) selected="true" @endif>
                                                                    {{$orderFrom->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(count($orderDetail->product->productProperties))
                                                <div style="margin-top: 10px; margin-bottom: 5px;" class="form-group">
                                                    <label class="col-sm-4 control-label" >màu & size</label>
                                                    <div class="col-xs-8">
                                                        <select disabled="disabled" name="product-properties" class="form-control product-properties" data-color-id="{{$orderDetail->color_id}}" data-size-id="{{$orderDetail->size_id}}" >
                                                            @foreach($orderDetail->product->productProperties as $productProperty)
                                                                @if(intval($productProperty->tag_size_id))
                                                                    <option value="{{$productProperty->tag_color_id}}-{{$productProperty->tag_size_id}}" @if($productProperty->tag_color_id == $orderDetail->color_id && $productProperty->tag_size_id == $orderDetail->size_id) selected="true" @endif data-color-id="{{$productProperty->tag_color_id}}" data-size-id="{{$productProperty->tag_size_id}}" >
                                                                        {{$productProperty->color->name}} - {{$productProperty->size->name}}
                                                                    </option>
                                                                @elseif(intval($productProperty->tag_color_id))
                                                                    <option value="{{$productProperty->tag_color_id}}-{{$productProperty->tag_size_id}}" @if($productProperty->tag_color_id == $orderDetail->color_id) selected="true" @endif data-color-id="{{$productProperty->tag_color_id}}">
                                                                        {{$productProperty->color->name}}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="cart-item-price" >
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <label class="col-sm-4 control-label" for="inputEmail3">Giá</label>
                                                    <div class="col-xs-8">
                                                        <input disabled="disabled" value="{{formatMoney($orderDetail->price)}}" data-value="{{$orderDetail->price}}" class="form-control product-price" placeholder="Password" type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cart-item-price" >
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <label class="col-sm-4 text-green control-label" for="inputEmail3">Loại khuyến mãi</label>
                                                    <div class="col-xs-8">
                                                        <select data-value="{{$orderDetail->discount_type}}" disabled="disabled" name="discount-type" class="form-control discount-type">
                                                            <option value="0">Please choose deal</option>
                                                            <option @if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PRICE) selected="selected" @endif value="{{KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PRICE}}">giảm giá tiền</option>
                                                            <option @if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PERCENT) selected="selected" @endif value="{{KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PERCENT}}">giảm giá %</option>
                                                            <option @if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT) selected="selected" @endif  value="{{KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT}}">tặng sản phẩm</option>
                                                            <option @if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_SAME_PRICE) selected="selected" @endif  value="{{KACANA_CAMPAIGN_DEAL_TYPE_SAME_PRICE}}">đồng giá</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cart-item-price" >
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <label class="col-sm-4 text-green control-label" for="inputEmail3">khuyến mãi
                                                        @if($orderDetail->discount_type && $orderDetail->discount_type != KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                                            ( {{discountTagRef($orderDetail->discount_type, $orderDetail->discount_ref)}} )
                                                        @endif
                                                    </label>
                                                    <div class="col-xs-8">

                                                        @if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                                            <input name="discount-ref-product-name" disabled="disabled" value="{{($orderDetail->discountProductRef->name)}}" data-value="{{$orderDetail->discountProductRef->name}}" class="form-control discount-ref-product-name" placeholder="Password" type="text">
                                                            <input name="discount-ref" disabled="disabled" value="{{($orderDetail->discount_ref)}}" data-value="{{$orderDetail->discount_ref}}" class="form-control discount-ref hidden" type="text">
                                                        @else
                                                            <input name="discount-ref-product-name" disabled="disabled" data-value="" class="form-control hidden discount-ref-product-name" placeholder="nhập tên sản phẩm" type="text">
                                                            <input name="discount-ref" disabled="disabled" value="{{($orderDetail->discount_ref)}}" data-value="{{$orderDetail->discount_ref}}" class="form-control discount-ref" type="text">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cart-item-price" >
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <label class="col-sm-4 control-label" for="inputEmail3">Số lượng</label>
                                                    <div class="col-xs-8">
                                                        <input min="1" name="product-quantity" disabled="disabled" value="{{$orderDetail->quantity}}" data-value="{{$orderDetail->quantity}}" class="form-control product-quantity" placeholder="Password" type="number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cart-item-price" >
                                                <div style="margin-bottom: 5px;" class="form-group">
                                                    <label class="col-sm-4 text-red control-label" for="inputEmail3">Tổng</label>
                                                    <div class="col-xs-8">
                                                        <input disabled="disabled" value="{{formatMoney($orderDetail->subtotal)}}" data-value="{{$orderDetail->subtotal}}" class="form-control product-total" placeholder="Password" type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cart-item-action text-right" >
                                                <a class="hidden" data-id="{{$orderDetail->id}}" style="margin-left: 10px" data-toggle="tooltip" data-original-title="quay lại" href="#cancel-edit-detail-item" >
                                                    <i class="fa fa-reply text-red" ></i>
                                                </a>
                                                <a class="hidden" data-id="{{$orderDetail->id}}" style="margin-left: 10px" data-toggle="tooltip" data-original-title="ok" href="#submit-edit-detail-item" >
                                                    <i class="fa fa-check text-green" ></i>
                                                </a>
                                                @if(!($orderDetail->shipping_service_code || $order->status == KACANA_ORDER_STATUS_CANCEL))
                                                    <a data-id="{{$orderDetail->id}}" style="margin-left: 10px" data-toggle="tooltip" data-original-title="sửa sản phẩm này" href="#edit-detail-item" >
                                                        <i class="fa fa-pencil" ></i>
                                                    </a>
                                                    <a data-id="{{$orderDetail->id}}"  style="margin-left: 10px" data-toggle="tooltip" data-original-title="xoá sản phẩm này" href="/order/deleteOrderDetail/?orderId={{$order->id}}&orderDetailId={{$orderDetail->id}}" >
                                                        <i class="fa fa-trash" ></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-3 text-center col-sm-3 cart-item-total" >
                                        @if($orderDetail->shipping_service_code)
                                          <a target="_blank" href="/shipping/detail?id={{$orderDetail->shipping->id}}" class="label label-success" >đã ship: {{$orderDetail->shipping_service_code}}</a><br><br><p>tình trạng ship hàng</p>
                                          {!! \Kacana\ViewGenerateHelper::getStatusDescriptionShip($orderDetail->shipping->status, $orderDetail->shipping->id) !!}
                                        @else
                                            <label class="label label-danger" >chưa ship</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <input type="hidden" id="order-id" value="{{$order->id}}" />
        <input type="hidden" id="order-quantity" value="{{$order->quantity}}" />
        <input type="hidden" id="order-total" value="{{formatMoney($order->total + $order->shipping_fee)}}" />
    </section>
@stop

@extends('admin.order.modal')

@section('javascript')
    Kacana.order.detail.init();
@stop