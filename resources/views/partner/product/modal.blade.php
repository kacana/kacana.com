<div id="modal-supper-boot-product" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class=""><a class="text-red" href="#tab_1-1" data-toggle="tab" aria-expanded="false">Chọn tài khoản cần đăng</a></li>
                        <li class=""><a class="text-red" href="#tab_2-2" data-toggle="tab" aria-expanded="false">Mô tả bài đăng</a></li>
                        <li class="active"><a class="text-red" href="#tab_3-2" data-toggle="tab" aria-expanded="true">Chọn hình sản phẩm</a></li>
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

<div id="modal-boot-product-lazada" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class=""><a class="text-red" href="#tab_lazada_2" data-toggle="tab" aria-expanded="false">Chọn hình sản phẩm</a></li>
                            <li class="active"><a class="text-red" href="#tab_lazada_3" data-toggle="tab" aria-expanded="true">Chọn category sản phẩm</a></li>
                        <li class="pull-left header"><i class="fa fa-rocket"></i> LAZADA Super boot sản phẩm</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_lazada_1">
                            <div class="list-social-post">

                            </div>
                        </div>

                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_lazada_2">
                            <div class="list-product-super-boot-item">
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="tab_lazada_3">
                            <div class="list-cat-lazada" >
                                <ul class="cd-accordion-menu animated">
                                    @foreach($lazadaCat as $cat)
                                        @include('partner.product.categories', ['item' => $cat])
                                    @endforeach
                                </ul>
                            </div>
                            <div class="lazada-cat-choose">
                                BAG
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>

            </div>
            <div class="modal-footer">
                <a type="button" href="#btn-post-to-lazada" class="btn btn-primary"><i class="fa fa-rocket"></i> Đăng bài</a>
                <button type="button" class="btn btn-warning" data-dismiss="modal" class="btn">Huỷ</button>
            </div>
        </div>
    </div>
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

<script id="template-lazada-product-super-boot-item" type="template">
    @{{each  properties}}
        <div class="product-boot-item" data-properties-id="${this.id}">
            <label class="name-product-boot-item">${this.nameProperty}</label>
            <div class="wrap-list-image-post-to-facebook">
                <div class="list-image-post-to-facebook">
                    @{{each galleries}}
                        <span data-id="${this.id}" class="item-image-post-to-facebook">
                            <img src="${this.image}">
                        </span>
                    @{{/each}}
                </div>
            </div>
        </div>
    @{{/each}}
</script>