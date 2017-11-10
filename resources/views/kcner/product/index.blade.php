@extends('layouts.kcner.master')

@section('title', 'Danh sách sản phẩm')

@section('section-content-id', 'content-list-product')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Product</h3>
                <div class="box-tools pull-left ">
                    <button data-toggle="modal" data-target="#modal-create-product" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Create product
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
                        <h3 class="box-title">Search product</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="search" class="form-control" placeholder="Search"/>
                            <select class="form-control" name="searchStatus">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                                <option class="text-red" value="3">SOLD OUT</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Find</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <button type="button" id="create-csv-for-remarketing" class="btn btn-success">Create CSV file</button>
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
                        <table id="productTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@extends('admin.product.product-modal')
@section('javascript')
    Kacana.product.listProducts.init();
@stop

