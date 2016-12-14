@extends('layouts.admin.master')

@section('title', 'Danh sách chờ chuyển tiền')

@section('section-content-id', 'content-list-user-waiting-transfer')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Danh sách chờ chuyển tiền</h3>
            </div><!-- /.box-header -->
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Search user</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline">
                            <input type="text" name="name" class="form-control" placeholder="Search Name"/>
                            <input type="text" name="phone" class="form-control" placeholder="Search Phone"/>
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
                        <table id="userWaitingTransferTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('javascript')
    Kacana.partner.init();
@stop

