@extends('layouts.partner.master')

@section('title', 'Product Boot')

@section('section-content-id', 'page-content-product')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Danh sách sản phẩm </h3>
            </div><!-- /.box-header -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách sản phẩm BOOT</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body border-bottom">
                        <form method="post" class="form-inline product-boot-form-inline">
                            <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm"/>
                            <select class="form-control" name="discount">
                                <option value="">Tất cả</option>
                                <option value="1">Đang khuyến mãi</option>
                                <option value="0">Không khuyến mãi</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <button type="button" class="btn btn-success disabled product-supper-boot" data-dismiss="modal">Supper boot</button>
                        </form>
                    </div>

                    <div class="box-body">
                        <table id="productBootTable" class="table table-striped">
                        </table>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="button" class="btn btn-success disabled pull-left product-supper-boot" data-dismiss="modal">Supper boot</button>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách sản phẩm đã đăng</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('section-modal')
    @include('partner.product.modal')
@stop

@section('javascript')
    Kacana.product.listProductBoot.init();
@stop