@section('meta-title', 'Địa chỉ nhận hàng')
<section class="panel">
    <header class="panel-heading">
        <div class="panel-body">
            <form id="form_address_step" class="form-horizontal form-bordered" method="post" action="/checkout/success">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="name">Tên</label>
                    <div class="col-md-8">
                        <input id="name" name="name" placeholder="Họ & tên" class="form-control" type="text"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="">Địa chỉ - lầu, số nhà, đường, phường</label>
                    <div class="col-md-8">
                        <textarea class="address form-control" rows="3" size="50" placeholder="Địa chỉ - lầu, số nhà, đường, phường" name="street" id="address"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="">Tỉnh/Thành phố</label>
                    <div class="col-md-8">
                        <select name="cityId" class="form-control">
                            <option value="">Chọn tỉnh/thành phố</option>
                            @foreach($listCity as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="">Quận/huyện</label>
                    <div class="col-md-8">
                        <select data-district="{{$listDistrict}}" disabled="true" name="districtId" class="form-control">
                            <option value="">Chọn quận/huyện</option>
                        </select>
                    </div>
                </div>
                {{--<div class="form-group">--}}
                    {{--<label class="col-md-4 control-label" for="">Phường, xã</label>--}}
                    {{--<div class="col-md-5">--}}
                        {{--<select disabled="true" name="wardId" class="form-control">--}}
                            {{--<option value="">Chọn phường/xã</option>--}}
                            {{--@foreach($listWard as $item)--}}
                                {{--<option data-city-id="{{$item->city_id}}" data-district-id="{{$item->district_id}}"  value="{{$item->id}}">{{$item->name}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                    <label class="col-md-4 control-label" for="">Điện thoại di động</label>
                    <div class="col-md-8">
                        <input id="phone" name="phone" placeholder="Nhập số điện thoại" class="form-control" type="text"/>
                    </div>
                </div>
                <div class="form-group">
                    @if(isset($user) && count($user->userAddress))
                        <div class="col-xs-12 col-sm-6  col-md-4 col-md-offset-4 col-sm-offset-0 vpadding-10">
                            <a href="/checkout?step=choose=address" style="width: 100%;" class="btn btn-primary" type="submit">Danh sách địa chỉ</a>
                        </div>
                    @endif
                    <div class="@if(!(isset($user) && count($user->userAddress)))col-md-offset-4 col-sm-12 col-md-8 col-xs-offset-0 @else col-sm-6 col-md-4 @endif col-xs-12 vpadding-10">
                        <button class="btn btn-primary btn-login-form" id="next-step" type="submit">Hoàn tất</button>
                    </div>
                </div>
            </form>
        </div>
    </header>
</section>