@extends('layouts.client.master')

@section('top-infomation')
    <section class="parallax" id="product-list-top-menu" data-stellar-background-ratio="0.5" style="background-image: url('/images/client/homepage/account-cover.jpg');">
        <div class="container">
            <div class="row center">
                <div class="col-md-12">
                    <h2 class="short text-shadow big white bold">Xin chào {{$user->name}}!</h2>
                </div>
            </div>
        </div>
    </section>
@stop

@section('content')
    <div id="customer-page" >
        <div class="page-header-simple" >
            <div class="container">
                <div class="row" >
                    <div class="col-xs-12">
                        SỔ ĐỊA CHỈ
                    </div>
                </div>
            </div>
        </div>
        <div id="customer-account-page" class="container background-white vpadding-10" >
            <div class="row">
                <div class="col-xs-12 col-sm-9">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Trong mục quản lý địa chỉ, bạn có thể xem tất cả danh sách địa chỉ của bạn. Chọn một link bên dưới để xem hay chỉnh sửa thông tin.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 vpadding-10">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h5>
                                        Danh sách địa chỉ
                                    </h5>
                                </div>
                            </div>
                            @if(count($user->userAddress))
                                @foreach($user->userAddress as $userAddress)
                                    <div class="row" >
                                        <div class="col-xs-12">
                                            <div class="vpadding-10 hpadding-10 @if($userAddress->default) background-body-header @endif border-bottom">
                                                <p><strong>{{$userAddress->name}}</strong></p>
                                                <div>{{$userAddress->street}}</div>
                                                <div>{{$userAddress->district->name}}, {{$userAddress->city->name}}</div>
                                                <div>{{$userAddress->phone}}</div>
                                                <div>{{$userAddress->email}}</div>
                                                <div class="vpadding-20 text-center">
                                                    <span class="pull-left" >
                                                        <a href="/khach-hang/so-dia-chi/{{$userAddress->id}}"><i class="fa fa-pencil"></i> Sửa địa chỉ</a>
                                                    </span>
                                                    <span >
                                                        @if($userAddress->default)                                                      <span class="color-green" ><i class="fa fa-check"></i> địa chỉ mặc định</span>
                                                        @else
                                                            <a href="/khach-hang/thiet-lap-dia-chi-mac-dinh/{{$userAddress->id}}"><i class="fa fa-save"></i> Thiết lập địa chỉ mặc định</a>
                                                        @endif
                                                    </span>
                                                    @if(!$userAddress->default)
                                                        <span class="pull-right" >
                                                            <a data-name="{{$userAddress->name}}" class="delete-address-receive" href="/khach-hang/xoa-dia-chi/{{$userAddress->id}}"><i class="fa fa-trash" ></i> Xoá</a>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    Bạn chưa tạo địa chỉ nào ! Tạo địa chỉ để đặt hàng đơn giản và nhanh hơn. Tạo ngay <a href="/khach-hang/them-dia-chi">tại đây</a>
                                </div>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-6 vpadding-10">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h5>
                                        Thêm địa chỉ mới
                                    </h5>
                                </div>
                            </div>
                            <div class="row" >
                               <div class="col-xs-12">
                                    <div class="vpadding-10">
                                        <div>Bạn muốn thêm một địa chỉ mới! Đăng ký địa chỉ khác <a href="/khach-hang/them-dia-chi">tại đây</a> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    @include('client.customer.customer-nav')
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')
    Kacana.customer.address.init();
@stop
@section('section-modal')

@stop