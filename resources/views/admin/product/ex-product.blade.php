`@extends('layouts.admin.master')

@section('title', 'Quản lý nhập hàng sản phẩm')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header text-center">
                <h3 class="box-title text-red text-center">Hoá Đơn Bán Lẻ</h3>
            </div>
        </div>
    </section>
    <section id="product-ex-page" class="content">
        <div class="row" >
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin hoá đơn</h3>
                    </div>
                    <form role="form">
                        <div class="box-body">
                            <div class="row-fluid" >
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày</label>
                                        <input class="form-control" disabled="disabled" type="date" value="{{ \Carbon\Carbon::now() }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nhân viên bán hàng</label>
                                        <input class="form-control" disabled="disabled" type="text" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Cửa hàng</label>
                                        <input class="form-control" disabled="disabled" type="text" value="60/36 Trần Hưng Đạo">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Khách hàng</label>
                                        <select id="customer" class="form-control">
                                            <option value="0">Khách Vãng Lai</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Số điện thoại khách hàng</label>
                                        <input class="form-control" id="customer-phone" placeholder="nhập số điện thoại" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Barcode</label>
                                        <input id="barcode-product" name="barcode-product" class="form-control" autocomplete="off" value="" placeholder="nhập barcode" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row" >
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sản phẩm</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Mã SP</th>
                                    <th>Tên SP</th>
                                    <th>Đơn vị tính</th>
                                    <th>Số Lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Giảm giá</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>183</td>
                                    <td>VÍ NAM CẦM TAY JUNLAN W1920</td>
                                    <td>Cái</td>
                                    <td><input type="number" min="1" value="1" ></td>
                                    <td>320.000 đ</td>
                                    <td>0 đ</td>
                                    <td>320.000 đ</td>
                                    <td><a href="#remove-product-order"><i class="text-red fa fa-times" ></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer" >
                        <form role="form">
                            <div class="box-body">
                                <div class="row-fluid" >
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số lượng</label>
                                            <input class="form-control" disabled="disabled" type="date" value="{{ \Carbon\Carbon::now() }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tổng giá</label>
                                            <input class="form-control" disabled="disabled" type="text" value="0">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giảm giá (đ)</label>
                                            <input class="form-control" disabled="disabled" type="text" value="0">
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giảm thêm (đ) </label>
                                            <input class="form-control" type="text" value="0">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Khách trả</label>
                                            <input class="form-control" id="customer-phone" placeholder="nhập số điện thoại" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Trả lại khách</label>
                                            <input id="barcode-product" name="barcode-product" disabled="disabled" class="form-control" autocomplete="off" value="0" type="text">
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số Tiền</label>
                                            <input id="barcode-product" name="barcode-product" class="form-control input-lg text-center text-red" autocomplete="off" value="0" placeholder="nhập barcode" type="text">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info btn-lg">Xuất hàng</button>
                                            <button type="submit" class="btn btn-danger pull-right btn-lg">Thoát</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@extends('admin.product.modal-ex')

@section('javascript')
    Kacana.sale.init();
@stop