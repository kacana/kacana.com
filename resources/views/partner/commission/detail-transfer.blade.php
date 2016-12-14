@extends('layouts.partner.master')

@section('title', 'Hoá đơn chuyển tiền: '.$payment->ref)

@section('section-content-id', 'content-detail-payment')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Hoá đơn chuyển tiền: {{$payment->ref}}</h3>
            </div><!-- /.box-header -->
        </div>
    </section>

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Công ty TNHH KACANA Việt Nam, Inc.
                    <small class="pull-right">Ngày: {{date("d-m-Y", strtotime($payment->created_at))}}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                Từ
                <address>
                    <strong>KACANA VN, Inc.</strong><br>
                    43 Tản Đà, phường 10, quận 5<br>
                    Hồ Chí Minh, VN<br>
                    Điện thoại: (84) 906-054206<br>
                    Email: admin@kacana.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                Đến
                <address>
                    <strong>{{$payment->user->name}}</strong><br>
                    Điện thoại: {{$payment->user->phone}}<br>
                    Email: {{$payment->user->email}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice #{{$payment->ref}}</b><br>
                <br>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Giảm giá</th>
                        <th>Chiết khấu</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payment->partnerPaymentDetail as $partnerPaymentDetail)
                        <tr>
                            <td>{{$partnerPaymentDetail->orderDetail->quantity}}</td>
                            <td>{{$partnerPaymentDetail->orderDetail->name}}</td>
                            <td>{{formatMoney($partnerPaymentDetail->orderDetail->price)}}</td>
                            <td>{{formatMoney($partnerPaymentDetail->orderDetail->discount)}}</td>
                            <td>{{formatMoney($partnerPaymentDetail->orderDetail->subtotal * PARTNER_DISCOUNT_PERCENT_LEVEL_1 / 100)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="lead">Phương thức chuyển tiền:</p>

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                   Chuyển tiền qua hệ thông e-banking VIETCOMBANK với mã chuyển tiền: {{$payment->ref}}<br>
                   <i>{{$payment->note}}</i>
                </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">Tổng {{date("d-m-Y", strtotime($payment->created_at))}}</p>

                <div class="table-responsive">
                    <table class="table">
                        <tbody><tr>
                            <th style="width:50%">Tổng tạm tính:</th>
                            <td>{{formatMoney($payment->total)}}</td>
                        </tr>
                        <tr>
                            <th>Phí (0%)</th>
                            <td>0 đ</td>
                        </tr>
                        <tr>
                            <th>Thưởng:</th>
                            <td>0 đ</td>
                        </tr>
                        <tr>
                            <th>Tổng Cộng:</th>
                            <td>{{formatMoney($payment->total)}}</td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@stop
@section('javascript')

@stop

