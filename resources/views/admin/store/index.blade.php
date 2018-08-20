@extends('layouts.admin.master')

@section('title','Detail '.$store->name )

@section('section-content-id', 'store-index')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title text-red">{{$store->name}}</h3>
                <div class="box-tools pull-left ">
                    <a target="_blank" href="/store/{{$store->id}}/history" class="btn btn-info btn-sm">
                        <i class="fa fa-history"></i> Store history
                    </a>
                    <a target="_blank" href="/store/{{$store->id}}/import" class="btn btn-primary btn-sm">
                        <i class="fa fa-download"></i> Import product
                    </a>
                    <button data-toggle="modal" data-target="#modal-quick-import-product" class="btn btn-warning btn-sm">
                        <i class="fa fa-plus"></i> Quick import product
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row" >
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Store information</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12 col-md-4" >
                            <label class="text-aqua">Thông tin chung</label>
                            <p><b>Tên Cửa hàng:</b> {{$store->name}}</p>
                            <p><b>Địa Chỉ:</b> {{$store->address}} {{$store->ward->name}}, {{$store->district->name}}, {{$store->city->name}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Filter</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="product-name" class="form-control" placeholder="product name"/>
                            <input type="text" name="product-property-name" class="form-control" placeholder="product property name"/>
                            <button type="submit" class="btn btn-primary">Find</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <a type="button" href="#export-excel-file" class="btn btn-success">Export excel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Store Product</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <div class="box-body no-padding">
                            <table id="storeProductTable" data-store-id="{{$store->id}}" class="table table-striped"></table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@extends('admin.store.store-modal')
@section('javascript')
    Kacana.store.indexPage.init();
@stop