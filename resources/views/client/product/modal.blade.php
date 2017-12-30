<div id="product-add-cart" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="product-add-cart">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
            <div class="modal-footer product-suggestion">

            </div>
        </div>
    </div>
</div>
<div id="modal-post-to-facebook" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <p class="modal-title" id="myModalLabel">Đăng lên Facebook</p>
            </div>
            <div class="modal-body">
                <label class="color-grey">Chọn hình</label>
                <div class="wrap-list-image-post-to-facebook">
                    <div class="list-image-post-to-facebook">
                        @if(isset($productSlide))
                            @foreach($productSlide as $gallery)
                                <span class="item-image-post-to-facebook">
                                <img data-id="{{$gallery->id}}" class="rsTmb" src="{{$gallery->image}}">
                            </span>
                            @endforeach
                        @endif
                    </div>
                </div>
                <label class="color-grey vpadding-10">Nội dung</label>
                <textarea placeholder="Hỏi bạn bè của bạn về sản phẩm trước khi đặt hàng!" class="desc-post-to-facebook"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-post-to-facebook disabled">Đăng</button>
                <button type="button" data-dismiss="modal" class="btn">Huỷ</button>
            </div>
        </div>
    </div>
</div>

<script id="template-cart-product-related" type="template">
    <div class="hidden-xs col-sm-12 text-center color-grey text-suggess" > Sản phẩm có thể bạn thích</div>
    @{{each  products}}
        <div class="hidden-xs col-sm-4 product-item" >
            <div class="product-image">
                <div class="product-image-inside">
                    <a title="${this.name}" href="${this.url}"><img alt="${this.name}" src="${this.image}" style="width: 100%;"></a>
                </div>
            </div>
            <div class="product-info">
                <div class="product-title"> <a title="${this.name}" href="${this.url}">${this.name}</a></div>
            </div>
            <div class="product-price-wrap">
                <div class="product-price pull-left@{{if this.lastPrice}} discount@{{/if}}">
                    <div class="discount-info">
                        @{{if this.lastPrice}}
                            <div class="product-price-original">
                                ${this.priceShow}
                            </div>
                            <div class="price-discount">
                                Giảm giá: <b>${this.discountShow}</b>
                            </div>
                        @{{/if}}
                    </div>
                    @{{if this.lastPrice}}
                      ${this.lastPrice}
                    @{{else}}
                      ${this.priceShow}
                    @{{/if}}
                </div>
            </div>
        </div>
    @{{/each }}
</script>