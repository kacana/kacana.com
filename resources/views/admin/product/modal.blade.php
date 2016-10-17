<section>
    <div id="modal-add-image-product-properties" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">chọn hình cho sản phẩm màu: </h4>
                </div>

                <div class="modal-body">
                    <div class="row margin-bottom" >
                        @if($images)
                            @foreach($images as $image)
                                @if($image->type == PRODUCT_IMAGE_TYPE_SLIDE)
                                      <div data-id="{{$image->id}}" class="wraper-image margin-bottom" >
                                          <img src="<?= $image->image;?>">
                                      </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script id="template-product-properties" type="template">
        <div class="row" >
            <div class="col-xs-5" >
                <div class="form-group">
                    <label>Chọn màu</label>
                    <select name="color[]" class="form-control properties-color new-property">
                        @foreach($tagColor as $item)
                            <option value="{{$item->child_id}}" >{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4" >
                <label>chọn size</label>
                <select name="size" class="form-control select-size" multiple size="3">
                    @if($tagSize)
                        @foreach($tagSize as $item)
                            @if($item->childs)
                                <optgroup label="{{$item->name}}">
                                    @foreach($item->childs as $child)
                                        <option value="{{$child->child_id}}" >{{$child->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-xs-2" >
                <div class="form-group wrapper-properties-image">
                    <label>Chọn hình</label>
                    <button class="btn btn-primary btn-sm" data-target="#modal-add-image-product-properties" data-toggle="modal">
                        <i class="fa fa-plus"></i> hình ảnh
                    </button>
                    <input name="productGalleryId[]" type="text" class="hide" value="0" >
                </div>
            </div>
            <div class="col-xs-1" >
                <div class="form-group">
                    <label>xoá</label>
                    <button class="btn btn-danger btn-sm" href="#remove-product-property" data-toggle="modal">
                        <i class="fa fa-remove"></i>
                    </button>
                </div>
            </div>
        </div>
    </script>
</section>
