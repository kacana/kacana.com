@extends('layouts.kcner.master')

@section('title','List Shipping')

@section('section-content-id', 'content-list-shipping')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Quản lý Shipping</h3>
                <div class="box-tools pull-left ">
                </div>
            </div><!-- /.box-header -->
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm đơn hàng</h3>

                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="orderCode" class="form-control" placeholder="mã đơn hàng"/>
                            <input type="text" name="receiveUser" class="form-control" placeholder="Người nhận"/>
                            <select class="form-control" name="searchStatus">
                                <option value="">All Status</option>
                                <option value="'{{KACANA_SHIP_STATUS_READY_TO_PICK}}'">Mới tạo</option>
                                <option value="'{{KACANA_SHIP_STATUS_STORING}}'">đã lấy</option>
                                <option value="'{{KACANA_SHIP_STATUS_DELIVERING}}'">đang giao</option>
                                <option value="'{{KACANA_SHIP_STATUS_STORE_TO_REDELIVERING}}'">giao lại</option>
                                <option value="'{{KACANA_SHIP_STATUS_RETURN}}'">đang trả</option>
                                <option value="'{{KACANA_SHIP_STATUS_RETURNED}}'">Đã hoàn trả</option>
                                <option value="'{{KACANA_SHIP_STATUS_WAITING_TO_FINISH}}'">Chờ chuyển COD</option>
                                <option value="'{{KACANA_SHIP_STATUS_FINISH}}'">Hoàn thành</option>
                                <option value="'{{KACANA_SHIP_STATUS_CANCEL}}'">Đã huỷ</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Find</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Search result</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="shippingTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop

@section('javascript')
    Kacana.shipping.init();
@stop
