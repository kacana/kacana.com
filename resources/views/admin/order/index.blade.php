
@extends('layouts.admin.master')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Quản lý đơn hàng</h3>
                <div class="box-tools pull-left ">
                    <button data-toggle="modal" data-target="#modal-create-product" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> tạo đơn hàng
                    </button>
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
                            <input type="text" name="name" class="form-control" placeholder="Search Name"/>
                            <input type="text" name="phone" class="form-control" placeholder="Search Phone"/>
                            <select class="form-control" name="searchStatus">
                                <option value="">All Status</option>
                                <option value="'{{KACANA_ORDER_STATUS_NEW}}'">New</option>
                                <option value="'{{KACANA_ORDER_STATUS_PROCESSING}}'">Processing</option>
                                <option value="'{{KACANA_ORDER_STATUS_CANCEL}}'">Cancel</option>
                                <option value="'{{KACANA_ORDER_STATUS_COMPLETE}}'">Complete</option>
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
                        <table id="orderTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('javascript')
    Kacana.order.init();
@stop
