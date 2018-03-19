@extends('layouts.admin.master')

@section('title','Shipping detail #'.$ship->id )

@section('section-content-id', 'content-detail-shipping')

@section('content')
    <section>
        <input id="shipping_id" value="{{$ship->id}}" class="hidden" >
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Mã Đơn Hàng: #{{$ship->id}} Của [{{$ship->addressReceive->name}}] Tổng {{formatMoney($ship->total + $ship->fee - $ship->extra_discount - $ship->paid)}}</h3>
                <div class="box-tools pull-left ">
                    <button data-target="#modal-print-order" class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> in vận đơn
                    </button>
                    <button data-target="#modal-print-barcode" data-href="/shipping/printBarcode?id={{$ship->id}}" class="btn btn-info btn-sm">
                        <i class="fa fa-print"></i> in shipping tag
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
                             <p class="lead">Thông tin Giá</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>

                                    <tr>
                                        <th style="width:50%">Status</th>
                                        <td>{!! $ship->statusDesc !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-red" style="width:50%">Giá COD</th>
                                        <td>{{formatMoney($ship->total + $ship->fee - $ship->extra_discount - $ship->paid)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Số lượng</th>
                                        <td>{{count($ship->orderDetail)}} Sản phẩm</td>
                                    </tr>
                                    <tr>
                                        <th>Phí vận chuyển thực  tế</th>
                                        <td>{{formatMoney($ship->origin_fee)}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-green">Giảm thêm</th>
                                        <td>{{formatMoney($ship->extra_discount)}}</td>
                                    </tr>
                                    <tr>
                                        <th>phí vận chuyển</th>
                                        <td>{{formatMoney($ship->fee)}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-purple">Đã thanh toán</th>
                                        <td>{{formatMoney($ship->paid)}}</td>
                                    </tr>
                                    </tbody></table>
                            </div>
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
                                      {!! Form::text('name', $user_address->name, array('required', 'class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => 'Họ và tên')) !!}
                                    </div>
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    {!! Form::label('phone', 'Điện thoại', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                    {!! Form::text('phone', $user_address->phone, array('required', 'class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => 'Điện thoại')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Email', 'Email', array('class'=>'col-sm-3 control-label')) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email', $user_address->email, array('required', 'class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => 'Email')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('street', 'Địa chỉ', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                    {!! Form::text('street', $user_address->street, array('class'=>'form-control', 'disabled' => 'disabled', 'placeholder'=>'Địa chỉ')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('city_id', 'Thành phố', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                    {!! Form::select('city_id', $cities, $user_address->city_id, array('class'=>'form-control', 'disabled' => 'disabled')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Quận', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        <select id="district" class="form-control" disabled="disabled" name="district_id">
                                            @foreach($districts as $district)
                                                <option @if(($user_address->district_id == $district->id)) selected="selected" @endif class="@if(!($user_address->city_id == $district->city_id)) hidden @endif" data-city-id="{{$district->city_id}}" value="{{$district->id}}">{{$district->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive no-padding">
                        <div id="list-order-detail" class="col-xs-12">
                            <div class="cart-header border-bottom" >
                                <div class="row" >
                                    <div class="col-xs-3 col-sm-4" >
                                        <h4 class="color-grey-light">{{count($ship->orderDetail)}} Sản phẩm</h4>
                                    </div>
                                    <div class="col-xs-5 col-sm-8" >
                                        <h4 class="color-grey-light">Chi tiết</h4>
                                    </div>
                                </div>
                            </div>
                            @foreach($ship->orderDetail as $orderDetail)
                                <div class="order-detail-item border-bottom vpadding-1" >
                                    <div class="row" >
                                        <div class="col-xs-3 col-sm-4" >
                                            <img style="width: 60%" class="img-responsive" src="{{$orderDetail->image}}">
                                        </div>
                                        <div class="col-xs-4 col-sm-8" >
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
                                            @if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                                <div class="cart-item-price" >
                                                    Tặng: {{$orderDetail->discountProductRef->name}} <img style="width: 50px" src="{{$orderDetail->discountProductRef->image}}">
                                                </div>
                                            @elseif($orderDetail->discount_type > 0)
                                                <div class="cart-item-price" >
                                                    Giảm giá: {{savingDiscount($orderDetail->discount_type, $orderDetail->discount_ref, $orderDetail->price)}}
                                                </div>
                                            @endif
                                            <div class="cart-item-price" >
                                                Số lượng: {{$orderDetail->quantity}}
                                            </div>
                                            <div class="cart-item-price color-red" >
                                                Tổng: {{formatMoney($orderDetail->subtotal)}}
                                            </div>

                                            <div class="cart-button-remove" >
                                                <a target="_blank" href="/order/edit/{{$orderDetail->order_id}}" >Đơn đặt hàng: {{$orderDetail->order_service_id}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@stop

@section('javascript')
    Kacana.shipping.init();
@stop