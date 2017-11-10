@extends('layouts.kcner.master')

@section('title', 'Người dùng: '.$item->name)

@section('section-content-id', 'content-edit-user')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Người dùng: {{$item->name}}</h3>
            </div><!-- /.box-header -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-4">
                <div class="box"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Cập nhật thông tin người dùng</h3>
                    </div><!-- /.box-header -->
                    @if($_POST)
                        @if ($errors->count() > 0)
                            <div class="alert alert-danger alert-dismissible">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="alert alert-success alert-dismissible">
                                Cập nhật thành công
                            </div>
                        @endif
                    @endif
                    {!! Form::open(array('method'=>'post', 'id' =>'form-edit-product', 'enctype'=>"multipart/form-data")) !!}
                    <div class="modal-body">
                        <!-- name -->
                        <div class="form-group">
                            {!! Form::label('name', 'Tên người dùng') !!}
                            {!! Form::text('name', $item->name, array('required', 'class' => 'form-control', 'placeholder' => 'Tên người dùng')) !!}
                        </div>

                        <!-- email -->
                        <div class="form-group">
                            {!! Form::label('email', 'Email người dùng') !!}
                            {!! Form::text('email', $item->email, array('required', 'class' => 'form-control', 'placeholder' => 'Email người dùng')) !!}
                            <span id="error-email" class="has-error text-red"></span>
                        </div>

                        <!-- phone number -->
                        <div class="form-group">
                            {!! Form::label('phone', 'Điện thoại') !!}
                            {!! Form::text('phone', $item->phone, array('required', 'class' => 'form-control', 'placeholder' => 'Email người dùng')) !!}
                            <span id="error-phone" class="has-error text-red"></span>
                        </div>

                        <!-- password -->
                        <div class="form-group">
                            {!! Form::label('password', 'Mật khẩu người dùng') !!}
                            {!! Form::password('passwd', array('class' => 'form-control', 'placeholder' => 'Mật khẩu mới người dùng')) !!}
                            <span id="error-password" class="has-error text-red"></span>
                        </div>

                        <!-- role -->
                        <div class="form-group">
                            {!! Form::label('role', 'Role') !!}
                            {!! Form::select('role', array('admin' => 'Admin', 'guess' => 'Guess', 'buyer' => 'Buyer'),$item->role,array('class'=>'form-control')) !!}
                        </div>

                        {!! Form::hidden('user_id', $item->id, array('id' => 'user_id'))!!}
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/user">Huỷ</a>
                        <button type="submit" id="btn-update"class="btn btn-primary">Cập nhật</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-xs-8">
                <div class="row" >
                    <div class="col-xs-12" >
                        <div class="box"> <!-- Search results -->
                            <div class="box-header with-border">
                                <h3 class="box-title">User Address</h3>
                            </div><!-- /.box-header -->

                            <div class="box-body table-responsive no-padding">
                                <table id="addressReceiveTable" class="table table-striped">
                                </table>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                    <div class="col-xs-12">
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
            </div>
        </div>
    </section>
@stop

@extends('admin.user.popup-modal')

@stop
@section('javascript')
    Kacana.user.detailUser.init();
@stop
