<div id="modal-supper-boot-product" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Super boot sản </h4>
            </div>
            <div class="modal-body">
                <label class="vpadding-10 hpadding-10 text-center text-red title-index" >Chọn hình sản phẩm</label>
                <div class="list-product-super-boot-item" >

                </div>
                <label class="vpadding-10 hpadding-10 text-center text-red title-index" >Mô tả bài đăng</label>
                <div contenteditable="true" class="desc-post-to-social" >
                    </div>
                <label class="vpadding-10 hpadding-10 text-center text-red title-index" >Chọn tài khoản cần đăng</label>
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
            <div class="modal-footer">
                @if(count($facebookAccountBusiness))
                    <a type="button" href="#btn-post-to-social" class="btn btn-primary"><i class="fa fa-rocket"></i> Đăng bài</a>
                @endif
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