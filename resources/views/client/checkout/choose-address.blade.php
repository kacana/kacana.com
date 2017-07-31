@section('meta-title', 'Cảm ơn bạn đã đặt hàng')
<section class="panel">
    <header class="panel-heading">
        <div class="panel-body">
            <div class="row">
                <div id="checkout-choose-address-step" class="col-xs-12 col-sm-12 vpadding-10">
                    @if(count($user->userAddress))
                        <form id="form_address_step" class="form-horizontal form-bordered" method="post" action="/checkout/success">
                            <div class="row" >
                                @foreach($user->userAddress as $userAddress)
                                    <label data-city-id="{{$userAddress->city_id}}" class="col-xs-12 checkout-address-item">
                                        <input @if($userAddress->default)checked="checked"@endif type="radio" value="{{$userAddress->id}}" name="checkout-address-id">
                                        <div class="col-xs-12">
                                            <div class="vpadding-10 hpadding-10">
                                                <div class="color-green" ><strong>{{$userAddress->name}}</strong></div>
                                                <div>{{$userAddress->street}} @if($userAddress->ward_id), {{$userAddress->ward->name}} @endif</div>
                                                <div>{{$userAddress->district->name}}, {{$userAddress->city->name}}</div>
                                                <div>{{$userAddress->phone}}</div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-4 vpadding-10">
                                    <a class="btn btn-primary" style="width: 100%;" href="/checkout/?step=address" type="submit">Thêm địa chỉ mới</a>
                                </div>
                                <div class="col-sm-6 col-lg-4 vpadding-10">
                                    <button class="btn btn-primary btn-login-form" id="next-step" type="submit">Hoàn tất</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            Bạn chưa tạo địa chỉ nào ! Tạo địa chỉ để đặt hàng đơn giản và nhanh hơn. Tạo ngay <a href="/khach-hang/them-dia-chi">tại đây</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>
</section>