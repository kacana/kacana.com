<div id="modal-supper-boot-product" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class=""><a class="text-red" href="#tab_1-1" data-toggle="tab" aria-expanded="false">Chọn tài khoản cần đăng</a></li>
                        <li class=""><a class="text-red" href="#tab_2-2" data-toggle="tab" aria-expanded="false">Mô tả bài đăng</a></li>
                        <li class="active"><a class="text-red" href="#tab_3-2" data-toggle="tab" aria-expanded="true">Chọn hình sản phẩm</a></li>
                        {{--<li class="dropdown">--}}
                            {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                                {{--Dropdown <span class="caret"></span>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>--}}
                                {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>--}}
                                {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>--}}
                                {{--<li role="presentation" class="divider"></li>--}}
                                {{--<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                        <li class="pull-left header"><i class="fa fa-rocket"></i> Super boot sản</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_1-1">
                            <div class="list-social-post">
                                @if(count($facebookAccountBusiness))
                                    <ul class="social-list clearfix">
                                        @foreach($facebookAccountBusiness as $item)
                                            <li data-social-id="{{$item->social_id}}" data-type="{{$item->type}}" class="active">
                                                <img src="{{$item->image}}">
                                                <a class="social-name" href="#">{{$item->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <h4> Không có tài khoản facebook! vui lòng thêm tài khoản facebook <a href="/social_account">tại đây</a></h4>
                                @endif
                            </div>
                        </div>

                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2-2">
                            <div contenteditable="true" class="desc-post-to-social" >
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="tab_3-2">
                            <div class="list-product-super-boot-item" >

                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>

            </div>
            <div class="modal-footer">
                @if(count($facebookAccountBusiness))
                    <a type="button" href="#btn-post-to-social" class="btn btn-primary"><i class="fa fa-rocket"></i> Đăng bài</a>
                @endif
                <button type="button" class="btn btn-warning" data-dismiss="modal" class="btn">Huỷ</button>
            </div>
        </div>
    </div>
</div>
<div>

</div>

<script id="template-desc-super-post-to-social" type="template">
    <br><br>🛫 Giao hàng toàn quốc<br>💵 Thanh toán khi nhận hàng<br>🏍 Miễn phí vận chuyển với đơn hàng trên 500k<br>📱 Mua hàng: {{$user->phone}}
</script>

<script id="template-product-super-boot-item" type="template">
    @{{each  products}}
        <div class="product-boot-item" data-product-id="${this.id}">
            <label class="name-product-boot-item">${this.name}</label>
            <div class="wrap-list-image-post-to-facebook">
                <div class="list-image-post-to-facebook">
                    <span data-id="image" class="item-image-post-to-facebook active">
                        <img class="rsTmb" src="${this.image}">
                    </span>
                    @{{each this.list_gallery}}
                        <span data-id="${this.id}" class="item-image-post-to-facebook">
                            <img src="${this.image}">
                        </span>
                    @{{/each}}
                </div>
            </div>
            <div contenteditable="true" placeholder="mô tả sản phẩm" id="caption-image-${this.id}" class="caption-image"></div>
        </div>
    @{{/each}}
</script>