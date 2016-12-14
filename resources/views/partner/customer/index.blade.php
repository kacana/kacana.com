@extends('layouts.partner.master')

@section('title','Khách hàng')

@section('section-content-id', 'content-customer')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Danh sách khách hàng </h3>
            </div><!-- /.box-header -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm khách hàng</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="name" class="form-control" placeholder="tên"/>
                            <input type="text" name="phone" class="form-control" placeholder="số đt"/>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
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
                        <h3 class="box-title">Danh sách</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="customerTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('javascript')
    Kacana.customer.init();
@stop