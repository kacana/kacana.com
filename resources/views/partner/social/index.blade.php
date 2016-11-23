@extends('layouts.partner.master')

@section('title', 'Social Account')

@section('section-content-id', 'page-content-social-account')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Tài khoản Social</h3>
            </div><!-- /.box-header -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tài khoản Facebook</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        @if(count($facebookAccountBusiness))
                            @foreach($facebookAccountBusiness as $item)
                                <div id="social-item-{{$item->social_id}}-{{$item->type}}" data-image="{{$item->image}}" data-name="{{$item->name}}" data-social-id="{{$item->social_id}}" data-type="{{$item->type}}" class="col-lg-3 col-md-6 col-xs-12 vpadding-10 social-item">
                                    <div class="row" >
                                        <div class="col-xs-4" >
                                            <a class="text-red" target="_blank" href="https://facebook.com/{{$item->social_id}}" >
                                                <img class="img-responsive" src="{{$item->image}}"/>
                                            </a>
                                        </div>
                                        <div class="col-xs-8" >
                                            <p><b><a class="text-red social-item-name" target="_blank" href="https://facebook.com/{{$item->social_id}}" >{{$item->name}}</a></b></p>
                                            <p class="text-aqua">Đăng 31 Sản phẩm</p>
                                            <a class="btn btn-xs btn-info" href="#"><i class="fa fa-eye" ></i></a>
                                            <a class="btn btn-xs btn-primary hmargin-10" href="#edit-name-social-item"><i class="fa fa-edit" ></i></a>
                                            <a class="btn btn-xs btn-danger" href="#delete-social-item"><i class="fa fa-trash" ></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3 class="text-center text-warning" >
                                Bạn chưa có tài khoản facebook nào!
                            </h3>
                            <h4 class="text-center">
                                Thêm tài khoản để bán hàng cùng KACANA trên facebook của bạn
                            </h4>
                        @endif
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="#add-new-facebook-account" class="btn btn-social btn-facebook pull-right">
                            <i class="fa fa-facebook"></i>
                            Thêm tài khoản
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('section-modal')
    @include('partner.social.modal')
@stop

@section('javascript')
    Kacana.social.init();
@stop