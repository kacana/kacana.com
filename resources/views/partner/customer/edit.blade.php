@extends('layouts.partner.master')

@section('title','Khách hàng: '.$user_address->name)

@section('section-content-id', 'content-edit-customer')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Khách hàng: {{$user_address->name}} </h3>
            </div><!-- /.box-header -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-4" >

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin đơn hàng</h3>
                        <div class="box-tools pull-right">
                            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <p class="lead">Thông tin nhận hàng</p>
                            {!! Form::open(array('method'=>'put', 'id' =>'form-edit-order', 'class'=>"form-horizontal")) !!}
                            <div class="box-body">
                                <!-- name -->
                                <div class="form-group">
                                    <input type="hidden" id="address-receive-id" name="id" value="{{$user_address->id}}" />
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
                                    {!! Form::label('city_id', 'Thành phố', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        {!! Form::select('city_id', $cities, $user_address->city_id, array('required', 'class'=>'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Quận/huyện', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        <select required data-district="{{$districts}}" id="district" class="form-control" name="district_id">
                                            @foreach($districts as $district)
                                                @if(($user_address->city_id == $district->city_id))
                                                    <option @if(($user_address->district_id == $district->id)) selected="selected" @endif data-city-id="{{$district->city_id}}" value="{{$district->id}}">{{$district->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('district_id', 'Phường/xã', array('class'=>'col-sm-3 control-label'))!!}
                                    <div class="col-sm-9">
                                        <select required id="wardId" class="form-control" name="ward_id">
                                            <option value="">Chọn phường/xã</option>
                                            @foreach($wards as $ward)
                                                <option @if(($user_address->ward_id == $ward->id)) selected="selected" @endif value="{{$ward->id}}">{{$ward->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <button type="submit" id="btn-update"class="btn btn-primary pull-right">Cập nhật</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-xs-8" >
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline form-inline-all">
                            <input type="text" name="order_code" class="form-control" placeholder="mã đơn hàng"/>
                            <input type="text" name="order_detail_name" class="form-control" placeholder="tên sản phẩm"/>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sản phẩm đã bán cho khách hàng</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="productSendTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('javascript')
    Kacana.customer.detail.init();
@stop