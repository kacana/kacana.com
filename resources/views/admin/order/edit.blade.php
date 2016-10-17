@extends('layouts.admin.master')

@section('title','Edit Order #'.$order->id )

@section('section-content-id', 'content-edit-order')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Đơn Hàng: #{{$order->id}} Của [{{$order->user->name}}] Tổng {{formatMoney($order->total)}}</h3>
                <div class="box-tools pull-left ">
                    <button data-toggle="modal" data-target="#modal-shipping-order" class="btn btn-primary btn-sm">
                        <i class="fa fa-plane"></i> Ship cho khách
                    </button>
                    <button data-toggle="modal" data-target="#modal-create-product" class="btn btn-danger btn-sm">
                        <i class="fa fa-meh-o"></i> Huỷ đơn hàng
                    </button>
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
                                      {!! Form::text('name', $user_address->name, array('required', 'class' => 'form-control', 'placeholder' => 'Họ và tên')) !!}
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
                                        {!! Form::text('email', $user_address->email, array('required', 'class' => 'form-control', 'placeholder' => 'Email')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('street', 'Địa chỉ', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                    {!! Form::text('street', $user_address->street, array('class'=>'form-control', 'placeholder'=>'Địa chỉ')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('city_id', 'Thành phố', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                    {!! Form::select('city_id', $cities, $user_address->city_id, array('class'=>'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Quận', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        <select id="district" class="form-control" name="district_id">
                                            @foreach($districts as $district)
                                                <option @if(($user_address->district_id == $district->id)) selected="selected" @endif class="@if(!($user_address->city_id == $district->city_id)) hidden @endif" data-city-id="{{$district->city_id}}" value="{{$district->id}}">{{$district->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="btn-update"class="btn btn-primary">Cập nhật</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-xs-12">
                            <p class="lead">Thông tin Giá</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody><tr>
                                        <th style="width:50%">Giá</th>
                                        <td>{{formatMoney($order->total)}}</td>
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
                                        <td>{{$order->deal}}%</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng</th>
                                        <td class="color-red">{{formatMoney($order->total + $order->shipping_fee - ($order->total*$order->deal/100))}}</td>
                                    </tr>
                                    </tbody></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-8">
                <div class="box box-primary box-body"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Chi tiết đơn hàng</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive no-padding">
                        <div id="list-order-detail" class="col-xs-12">
                            <div class="cart-header border-bottom" >
                                <div class="row" >
                                    <div class="col-xs-3 col-sm-3" >
                                        <h4 class="color-grey-light">{{$order->quantity}} Sản phẩm</h4>
                                    </div>
                                    <div class="col-xs-4 col-sm-4" >
                                        <h4 class="color-grey-light">Chi tiết</h4>
                                    </div>
                                    <div class="col-xs-3 col-sm-3" >
                                        <h4 class="color-grey-light">Đặt hàng</h4>
                                    </div>
                                    <div class="col-xs-2 col-sm-2" >
                                        <h4 class="color-grey-light text-center">Shipping</h4>
                                    </div>
                                </div>
                            </div>
                            @foreach($order->orderDetail as $orderDetail)
                            <div class="order-detail-item border-bottom vpadding-1" >
                                <div class="row" >
                                    <div class="col-xs-3 col-sm-3" >
                                        <img style="width: 60%" class="img-responsive" src="{{$orderDetail->image}}">
                                    </div>
                                    <div class="col-xs-4 col-sm-4" >
                                        <div class="cart-item-title" >
                                          <a target="_blank" href="{{$orderDetail->product_url}}"> {{$orderDetail->name}}</a>
                                        </div>

                                        @if($orderDetail->color_id)
                                            <div class="cart-item-color">
                                                Màu sắc: {{$orderDetail->color->name}}
                                            </div>
                                        @endif

                                        @if($orderDetail->size_id)
                                            <div class="cart-item-size" >
                                                Kích thước: {{$orderDetail->size->name}}
                                            </div>
                                        @endif

                                        <div class="cart-item-price" >
                                            Giá: {{formatMoney($orderDetail->price)}}
                                        </div>
                                        @if($orderDetail->discount)
                                            Giảm giá: {{formatMoney($orderDetail->discount)}}
                                        @endif
                                        <div class="cart-item-price" >
                                            Số lượng: {{$orderDetail->quantity}}
                                        </div>
                                        <div class="cart-item-price color-red" >
                                            Tổng: {{formatMoney($orderDetail->subtotal)}}
                                        </div>

                                        <div class="cart-button-remove" >
                                            <a data-id="{{$orderDetail->id}}" href="#remove-detail-item" >xoá sản phẩm này</a>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 order-detail-service" data-image="{{$orderDetail->image}}" data-name="{{$orderDetail->name}}" data-order-detail-id="{{$orderDetail->id}}">
                                        <a target="_blank" href="{{$orderDetail->product->source_url}}"> Link đặt hàng</a>
                                        @if($orderDetail->order_service_status == KACANA_ORDER_SERVICE_STATUS_ORDERED)
                                            <input type="text" value="{{$orderDetail->order_service_id}}" name="order-service-id" placeholder="id nhập hàng" disabled="disabled" class="form-control vmargin-1" required="required">
                                        @elseif($orderDetail->order_service_status == KACANA_ORDER_SERVICE_STATUS_SOLD_OUT)
                                            <div class="label btn-danger"><i class="icon fa fa-ban vmargin-1"></i>sản phẩm đã hết hàng!</div>
                                        @else
                                            <div class="label btn-danger label-sold-out hidden" ><i class="icon fa fa-ban vmargin-1"></i>sản phẩm đã hết hàng!</div>
                                            <input type="text" value="{{KACANA_PREFIX_ORDER_CODE}}" name="order-service-id" placeholder="id nhập hàng" class="form-control vmargin-1" required="required">
                                            <a data-status="{{KACANA_ORDER_SERVICE_STATUS_ORDERED}}" class="btn btn-primary" href="#update-order-service-id" type="submit">Cập nhật</a>
                                            <a data-status="{{KACANA_ORDER_SERVICE_STATUS_SOLD_OUT}}" class="btn btn-danger" href="#update-order-sold-out" type="submit">Hết hàng</a>
                                        @endif
                                    </div>
                                    <div class="col-xs-2 text-center col-sm-2 cart-item-total" >
                                        @if($orderDetail->shipping_service_code)
                                          <a target="_blank" href="/shipping/detail?id={{$orderDetail->shipping->id}}" class="label label-success" >đã ship: {{$orderDetail->shipping_service_code}}</a>
                                        <br>
                                        <br>
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
    </section>
@stop

@extends('admin.order.modal')

@section('javascript')
    Kacana.order.detail.init();
@stop