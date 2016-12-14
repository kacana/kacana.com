@extends('layouts.partner.master')

@section('title','Edit Order #'.$order->order_code )

@section('section-content-id', 'content-edit-order')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Đơn Hàng: #{{$order->order_code}} Của [{{$order->user->name}}] Tổng {{formatMoney($order->total)}}</h3>
                <div class="box-tools pull-left ">
                    @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                        <a href="#cancel-order" data-order-id="{{$order->id}}" class="btn btn-danger">
                            Huỷ đơn hàng
                        </a>
                        @if(count($order->orderDetail))
                            <a href="/order/sendOrder?orderId={{$order->id}}" class="btn btn-info">
                                Gửi đơn hàng cho KACANA
                            </a>
                        @endif
                    @elseif($order->status == KACANA_ORDER_STATUS_NEW )
                        <a class="btn btn-info">
                            Đơn hàng đã gửi cho KACANA
                        </a>
                    @elseif($order->status == KACANA_ORDER_PARTNER_STATUS_CANCEL)
                        <a href="#" class="btn btn-danger">
                            Đơn hàng đã huỷ
                        </a>
                    @elseif($order->status == KACANA_ORDER_STATUS_CANCEL)
                        <a href="#" class="btn btn-danger">
                             Đơn hàng đã huỷ bởi KACANA
                        </a>
                    @elseif($order->status == KACANA_ORDER_STATUS_PROCESSING)
                        <a href="#" class="btn btn-warning">
                            Đơn hàng đang xử lý
                        </a>
                    @elseif($order->status == KACANA_ORDER_STATUS_COMPLETE)
                        <a href="#" class="btn btn-success">
                            Đơn hàng đã hoàn thành
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
                                    </tbody></table>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <p class="lead">Thông tin người mua hàng</p>
                            <form class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="inputEmail3">Order Code:</label>
                                        <div class="col-sm-9">
                                            <input value="{{$order->order_code}}" data-user-id="{{$order->user_id}}" id="order_code_id" disabled="disabled"  class="form-control disabled">
                                            <input value="{{$order->id}}" data-user-id="{{$order->user_id}}" id="order_id" disabled="disabled"  class="form-control hidden disabled">
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
                                            <input value="{{$order->created}}" disabled="disabled"  class="form-control disabled">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-12">
                            <p class="lead">Thông tin nhận hàng</p>
                            {!! Form::open(array('method'=>'put', 'id' =>'form-edit-order', 'class'=>"form-horizontal")) !!}
                            <div class="box-body">
                                <!-- name -->
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{$user_address->id}}" />
                                    {!! Form::label('name', 'Họ và tên', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                                            {!! Form::text('name', $user_address->name, array('required', 'class' => 'form-control', 'placeholder' => 'Họ và tên')) !!}
                                        @else
                                            {!! Form::text('name', $user_address->name, array('required', 'disabled'=>'disabled', 'class' => 'form-control', 'placeholder' => 'Họ và tên')) !!}
                                        @endif
                                    </div>
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    {!! Form::label('phone', 'Điện thoại', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                                            {!! Form::text('phone', $user_address->phone, array('required', 'class' => 'form-control', 'placeholder' => 'Điện thoại')) !!}
                                        @else
                                            {!! Form::text('phone', $user_address->phone, array('required', 'disabled'=>'disabled', 'class' => 'form-control', 'placeholder' => 'Điện thoại')) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Email', 'Email', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                                            {!! Form::text('email', $user_address->email, array( 'class' => 'form-control', 'placeholder' => 'Email')) !!}
                                        @else
                                            {!! Form::text('email', $user_address->email, array( 'class' => 'form-control', 'disabled'=>'disabled', 'placeholder' => 'Email')) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('street', 'Địa chỉ', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                                            {!! Form::text('street', $user_address->street, array('required', 'class'=>'form-control', 'placeholder'=>'Địa chỉ')) !!}
                                        @else
                                            {!! Form::text('street', $user_address->street, array('required', 'class'=>'form-control', 'disabled'=>'disabled', 'placeholder'=>'Địa chỉ')) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('city_id', 'Thành phố', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                                            {!! Form::select('city_id', $cities, $user_address->city_id, array('required', 'class'=>'form-control')) !!}
                                        @else
                                            {!! Form::select('city_id', $cities, $user_address->city_id, array('required', 'disabled'=>'disabled', 'class'=>'form-control')) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Quận', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        <select required data-district="{{$districts}}" id="district" @if($order->status != KACANA_ORDER_PARTNER_STATUS_NEW) disabled="disabled" @endif class="form-control" name="district_id">
                                            @foreach($districts as $district)
                                                @if(($user_address->city_id == $district->city_id))
                                                    <option @if(($user_address->district_id == $district->id)) selected="selected" @endif data-city-id="{{$district->city_id}}" value="{{$district->id}}">{{$district->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Quận', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        <select required id="wardId" @if($order->status != KACANA_ORDER_PARTNER_STATUS_NEW) disabled="disabled" @endif class="form-control" name="ward_id">
                                            <option value="">Chọn phường/xã</option>
                                            @foreach($wards as $ward)
                                                <option @if(($user_address->ward_id == $ward->id)) selected="selected" @endif value="{{$ward->id}}">{{$ward->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                                <div class="modal-footer">
                                    <button type="submit" id="btn-update"class="btn btn-primary">Cập nhật</button>
                                </div>
                            @endif
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-8">
                <div class="box box-primary"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Chi tiết đơn hàng</h3>
                        @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                            <div class="box-tools pull-right">
                                <button data-toggle="modal" data-target="#modal-add-product-order" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Thêm sản phẩm</button>
                            </div>
                        @endif
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive no-padding">
                        <div id="list-order-detail" class="col-xs-12">
                            <div class="cart-header border-bottom" >
                                <div class="row" >
                                    <div class="col-xs-3 col-sm-3" >
                                        <h4 class="color-grey-light">{{$order->quantity}} Sản phẩm</h4>
                                    </div>
                                    <div class="col-xs-7 col-sm-7" >
                                        <h4 class="color-grey-light">Chi tiết</h4>
                                    </div>
                                    <div class="col-xs-2 col-sm-2" >
                                        <h4 class="color-grey-light text-center">Tình trạng</h4>
                                    </div>
                                </div>
                            </div>
                            @foreach($order->orderDetail as $orderDetail)
                            <div class="order-detail-item border-bottom vpadding-10" >
                                <div class="row" >
                                    <div class="col-xs-3 col-sm-3" >
                                        <img style="width: 60%" class="img-responsive" src="{{$orderDetail->image}}">
                                    </div>
                                    <div class="col-xs-7 col-sm-7" >
                                        <form method="POST" accept-charset="UTF-8" action="/order/updateOrderDetail/{{$order->id}}/{{$orderDetail->id}}" class="form-horizontal">
                                            <div class="cart-item-title text-center" >
                                              <a target="_blank" href="{{$orderDetail->product_url}}"> {{$orderDetail->name}}</a>
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
                                                                @else
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
                                                    <label class="col-sm-4 text-green control-label" for="inputEmail3">Giảm giá</label>
                                                    <div class="col-xs-8">
                                                        <input name="product-discount" disabled="disabled" value="{{formatMoney($orderDetail->discount)}}" data-value="{{$orderDetail->discount}}" class="form-control product-discount" placeholder="Giảm giá" type="text">
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
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            @if($order->status == KACANA_ORDER_PARTNER_STATUS_NEW)
                                                <div class="cart-item-action text-right" >
                                                    <a class="hidden" data-id="{{$orderDetail->id}}" style="margin-left: 10px" data-toggle="tooltip" data-original-title="quay lại" href="#cancel-edit-detail-item" >
                                                        <i class="fa fa-reply text-red" ></i>
                                                    </a>
                                                    <a class="hidden" data-id="{{$orderDetail->id}}" style="margin-left: 10px" data-toggle="tooltip" data-original-title="ok" href="#submit-edit-detail-item" >
                                                        <i class="fa fa-check text-green" ></i>
                                                    </a>
                                                    @if(!$orderDetail->shipping_service_code)
                                                        <a data-id="{{$orderDetail->id}}" style="margin-left: 10px" data-toggle="tooltip" data-original-title="sửa sản phẩm này" href="#edit-detail-item" >
                                                            <i class="fa fa-pencil" ></i>
                                                        </a>
                                                        <a data-id="{{$orderDetail->id}}"  style="margin-left: 10px" data-toggle="tooltip" data-original-title="xoá sản phẩm này" href="/order/deleteOrderDetail/?orderId={{$order->id}}&orderDetailId={{$orderDetail->id}}" >
                                                            <i class="fa fa-trash" ></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </form>
                                    </div>

                                    <div class="col-xs-2 text-center col-sm-2 cart-item-total" >
                                        {!! \Kacana\ViewGenerateHelper::getStatusDescriptionOrderDetail($orderDetail) !!}
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
    </section>
@stop

@extends('partner.order.modal')

@section('javascript')
    Kacana.order.detail.init();
@stop