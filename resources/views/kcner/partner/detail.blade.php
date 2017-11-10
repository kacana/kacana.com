@extends('layouts.kcner.master')

@section('title','Chiết khấu: '.$user->name)

@section('section-content-id', 'content-detail-commission-partner')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Chiết khấu: {{$user->name}}</h3>
                <input class="hidden" id="user_id" value="{{$user->id}}" >
                <div class="box-tools pull-left ">
                    <button data-toggle="modal" @if(!count($commissions['valid']['data'])) disabled="disabled" @endif data-target="#modal-transfer-partner" class="btn btn-primary">
                        <i class="fa fa-money"></i> Chuyển tiền
                    </button>
                </div>
            </div><!-- /.box-header -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-3" >
                <div class="row">
                    <div class="col-xs-12" >
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="ion-ios-cart-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Tất cả sản phẩm</span>
                                <span class="info-box-number">{{ formatMoney($commissions['all']['total']) }}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                                <span class="progress-description ">
                                    <span class="pull-left" >{{count($commissions['all']['data'])}} đơn</span>
                                    <a class="color-white pull-right" href="#allCommission" >Chi tiết</a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="ion-ios-barcode-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Chiết khấu tạm tính</span>
                                <span class="info-box-number">{{formatMoney($commissions['temp']['total'])}}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                                <span class="progress-description">
                                    <span class="pull-left" >{{count($commissions['temp']['data'])}} đơn</span>
                                    <a class="color-white pull-right" href="#tempCommission" >Chi tiết</a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="col-xs-12" >
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="ion-social-usd-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Chiết khấu khả dụng</span>
                                <span class="info-box-number">{{formatMoney($commissions['valid']['total'])}}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                                <span class="progress-description">
                                    <span class="pull-left" >{{count($commissions['valid']['data'])}} đơn</span>
                                    <a class="color-white pull-right" href="#validCommission" >Chi tiết</a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="col-xs-12" >
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="ion-social-buffer-outline"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Chiết khấu đã chuyển</span>
                                <span class="info-box-number">{{formatMoney($commissions['payment']['total'])}}</span>

                                <div class="progress">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                                <span class="progress-description">
                                    <span class="pull-left" >{{count($commissions['payment']['data'])}} đơn</span>
                                    <a class="color-white pull-right" href="#paymentCommission" >Chi tiết</a>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12" >
                        <div class="box box-danger">
                            <div class="box-header">
                                <h3 class="box-title">Lịch sử chuyển tiền</h3>
                            </div>
                            <div class="box-body no-padding">
                                <table id="paymentHistory" class="table table-striped"></table>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9 commission-box" >
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm sản phẩm</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline form-inline-all">
                            <input type="text" name="order_code" class="form-control" placeholder="mã đơn hàng"/>
                            <input type="text" name="order_detail_name" class="form-control" placeholder="tên sản phẩm"/>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sản phẩm đã gửi cho kacana</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="productSendTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-xs-9 commission-box hidden" >
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm sản phẩm</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline form-inline-temp">
                            <input type="text" name="order_code" class="form-control" placeholder="mã đơn hàng"/>
                            <input type="text" name="order_detail_name" class="form-control" placeholder="tên sản phẩm"/>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sản phẩm đã gửi cho kacana</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="productTempTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-xs-9 commission-box hidden" >
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm sản phẩm</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline form-inline-valid">
                            <input type="text" name="order_code" class="form-control" placeholder="mã đơn hàng"/>
                            <input type="text" name="order_detail_name" class="form-control" placeholder="tên sản phẩm"/>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>

                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sản phẩm đã gửi cho kacana</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table id="productValidTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-xs-9 commission-box hidden" >
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Tìm kiếm sản phẩm</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" class="form-inline form-inline-payment">
                            <input type="text" name="order_code" class="form-control" placeholder="mã đơn hàng"/>
                            <input type="text" name="order_detail_name" class="form-control" placeholder="tên sản phẩm"/>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>

                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sản phẩm đã gửi cho kacana</h3>
                    </div>
                    <div class="box-body no-padding">

                        <table id="productPaymentTable" class="table table-striped"></table>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop
@extends('admin.partner.modal')
@section('javascript')
    Kacana.partner.detail.init();
@stop