@extends('layouts.admin.master')

@section('title', 'Quản lý order from')

@section('section-content-id', 'content-list-order-from')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Quản lý Order From</h3>
                <div class="box-tools pull-left ">
                    <button id="create-order-from-btn" class="btn btn-primary btn-sm create-post-btn" type="button">
                        <i class="fa fa-clipboard"></i>
                        Tạo Order From
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách Order From</h3>

                    </div>
                    <div class="box-body no-padding">
                        <table id="orderFromTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@extends('admin.orderfrom.modal')
@extends('admin.orderfrom.edit-modal')
@section('javascript')
    Kacana.orderFrom.init();
@stop