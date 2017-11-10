@extends('layouts.kcner.master')

@section('title', 'Quản lý nhập hàng sản phẩm')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Quản lý nhập hàng sản phẩm</h3>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Bộ lọc tìm kiếm</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="name" class="form-control" placeholder="tên sản phẩm"/>
                            <input type="text" name="user" class="form-control" placeholder="người nhập"/>
                            <input type="text" name="productId" class="form-control" placeholder="id sản phẩm"/>
                            <input type="text" name="propertyId" class="form-control" placeholder="id thuộc tính"/>
                            <button type="submit" class="btn btn-primary">Find</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <a type="button" href="#export-excel-file" class="btn btn-success">Export excel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sản phẩm đã nhập</h3>

                    </div>
                    <div class="box-body no-padding">
                        <table id="importProductTable" class="table table-striped">

                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@extends('admin.product.im-modal')
@section('javascript')
    Kacana.product.imProduct.init();
@stop