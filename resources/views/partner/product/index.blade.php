@extends('layouts.partner.master')

@section('title', 'Product Boot')

@section('section-content-id', 'page-content-product')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Danh sách sản phẩm</h3>
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
                    <div class="box-body">

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">

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
    Kacana.social.init();
@stop