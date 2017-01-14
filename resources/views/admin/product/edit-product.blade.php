@extends('layouts.admin.master')

@section('title', 'Edit product: '.$product['name'])

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Sản phẩm: {{$product['name']}}</h3>
                <div class="box-tools pull-left ">
                    <button class="btn btn-success btn-sm" type="button">
                        Còn 4 sản phẩm trong kho
                    </button>
                    <button id="create-post-btn" class="btn btn-primary btn-sm create-post-btn" type="button">
                        <i class="fa fa-exchange"></i>
                        Nhập hàng
                    </button>
                    <button  class="btn btn-primary btn-sm" type="button">
                        <i class="fa fa-exchange"></i>
                        Chi tiết Nhập xuất
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section id="product-detail-page" class="content">
        {!! Form::open(array('method'=>'post', 'id' =>'form-edit-product', 'onsubmit'=>true, 'enctype'=>"multipart/form-data")) !!}
        <div class="row" >
            <div class="col-xs-5">
                <div class="box box-primary"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin sản phẩm</h3>
                    </div><!-- /.box-header -->

                    <div class="modal-body">
                        <!-- name -->
                        <div class="form-group">
                            {!! Form::label('name', 'ID sản phẩm') !!}
                            {!! Form::text('name', $product['id'], array('required', 'readonly','id' => 'productId', 'class' => 'form-control', 'placeholder' => 'Tên sản phẩm')) !!}
                        </div>
                        <!-- name -->
                        <div class="form-group">
                            {!! Form::label('name', 'Tên sản phẩm') !!}
                            {!! Form::text('name', $product['name'], array('required', 'class' => 'form-control', 'placeholder' => 'Tên sản phẩm')) !!}
                        </div>

                        <!-- sell price -->
                        <div class="form-group">
                            {!! Form::label('price', 'Giá nhập sản phẩm') !!}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <i class="fa fa-dollar"></i>
                                        </span>
                                        {!! Form::text('price', $product['price'], array('required', 'class' => 'form-control currency', 'placeholder' => 'Giá nhập sản phẩm')) !!}
                                    </div>
                                        <!-- /input-group -->
                                </div>
                                    <!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <i class="fa fa-dollar"></i>
                                        </span>
                                        <input id="format-price" type="text" disabled="true" class="form-control">
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                        </div>

                        <!-- sell price -->
                        <div class="form-group">
                            {!! Form::label('sell_price', 'Giá bán sản phẩm') !!}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <i class="fa fa-dollar"></i>
                                        </span>
                                        {!! Form::text('sell_price', $product['sell_price'], array('required', 'class' => 'form-control currency', 'placeholder' => 'Giá bán sản phẩm')) !!}
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <i class="fa fa-dollar"></i>
                                        </span>
                                        <input type="text" id="format-sell_price" disabled="true" class="form-control">
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                        </div>

                        <!-- sell price -->
                        <div class="form-group">
                            {!! Form::label('price_discount', 'Giảm giá') !!}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <i class="fa fa-dollar"></i>
                                        </span>
                                        {!! Form::text('price_discount', $product['discount'], array('class' => 'form-control currency', 'placeholder' => 'Số tiền giảm giá')) !!}
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <i class="fa fa-dollar"></i>
                                        </span>
                                        <input id="format-price_discount" type="text" disabled="true" class="form-control">
                                    </div>
                                    <!-- /input-group -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'phong cách thiết kế') !!}
                            @if($tagStyle)
                                <select name="tag_style_id" class="form-control properties-color">
                                    @foreach($tagStyle as $item)
                                        <option {{(($item->child_id == $product['tag_style_id']))?'selected':''}} value="{{$item->child_id}}" >{{$item->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'sản xuất tại') !!}
                            <select name="made_in" class="form-control">
                                @foreach($countries as $item)
                                    <option {{(($item->id == $product['made_in']))?'selected':''}} value="{{$item->id}}" >{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            {!! Form::label('source_url', 'Link đặt hàng') !!}
                            {!! Form::text('source_url', $product['source_url'], array('required', 'class' => 'form-control', 'placeholder' => 'Link taobao.com, 1688.com, tmall.com,...')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Tag Group') !!}
                            <button disabled="disabled" type="button" id="add-group-tag-to-product-tag" class="btn btn-xs btn-primary"><i class="fa fa-plus" ></i> Thêm</button>
                            <button disabled="disabled" type="button" id="remove-group-tag-from-product-tag" class="btn btn-xs btn-danger"><i class="fa fa-trash" ></i> Xoá</button>
                            <select id="group-tag-for-product" class="form-control" multiple size="3">
                                @if(count($groupTag))
                                    @foreach($groupTag as $item)
                                        <option value="{{$item->child_id}}" >{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            {!! Form::label('tag_search_product', 'Tag sản phẩm') !!}
                            <select name="productTag_{{KACANA_PRODUCT_TAG_TYPE_SEARCH}}[]" id="tag_search_product" class="form-control tag_search_product" multiple size="3">
                                @if(count($product->tag))
                                    @foreach($product->tag as $tag)
                                        @if($tag->pivot->type == KACANA_PRODUCT_TAG_TYPE_SEARCH)
                                            <option value="{{$tag->id}}" selected >{{$tag->name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- tags -->
                        <div class="form-group">
                            {!! Form::label('tags', 'Tag Menu') !!}
                            <div class="treeview-tags" data-role="treeview" id="tree-tags" data-url="/product/getProductTreeMenu?typeId={{ TAG_RELATION_TYPE_MENU }}&productId={{$product['id']}}/"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/product">Huỷ</a>
                        <button type="submit" id="btn-update"class="btn btn-primary">Cập nhật</button>
                    </div>
                </div><!-- /.box -->
            </div>

            <div  class="col-xs-7">
                <div class="row">
                    <div class="col-xs-12">
                        <div id="product-image-detail" class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Slide sản phẩm</h3>
                                <div class="box-tools pull-left">
                                    <div id="image-upload-container"></div>
                                    <button id="select-file-product-image" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus"></i> <span>Select File</span>
                                        <input type="file" class="hide">
                                    </button>

                                    <button id="image-upload-btn" class="btn btn-sm btn-success hide">
                                        <i class="icon icon-upload-alt"></i> <span>Confirm</span>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="list-product-image vspace-bottom-1">
                                    @if($images)
                                        @foreach($images as $image)
                                            @if($image->type == PRODUCT_IMAGE_TYPE_SLIDE || $image->type == PRODUCT_IMAGE_TYPE_NORMAL)
                                                <div class="product-image-item" data-id="{{$image->id}}" data-type="{{$image->type}}" >
                                                    <img src="{{$image->image}}" class="product-image">
                                                    <div class="product-image-tool" >
                                                        <a title="chọn làm hình slide" class="{{($image->type==PRODUCT_IMAGE_TYPE_SLIDE)?'active':''}} pull-left" href="#setSlideImage" ><i class="ion-ios-circle-filled" ></i></a>
                                                        <a class="pull-right" href="#deleteImage" ><i class="ion-trash-b" ></i></a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="box box-primary"> <!-- Search results -->
                            <div class="box-header with-border">
                                <h3 class="box-title">hình đại diện sản phẩm</h3>
                            </div><!-- /.box-header -->

                            <div id="product-image-main" class="modal-body">
                                <!-- property -->
                                <div class="box-tools margin-bottom">

                                    <div id="image-main-product-upload-container"></div>
                                    <button type="button" id="select-file-main-image" class="btn btn-sm btn-primary">
                                        <i class="icon icon-plus"></i> <span>Select File</span>
                                        <input type="file" class="hide">
                                    </button>

                                    <button type="button" id="banner-upload-btn" class="btn btn-sm btn-success hide">
                                        <i class="icon icon-upload-alt"></i> <span>Confirm</span>
                                    </button>
                                    @if($product['image'])
                                        <button type="button" id="banner-remove-btn" class="btn btn-sm btn-danger">
                                            <i class="icon icon-remove-circle"></i> <span>Remove</span>
                                        </button>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="banner-cropper col-md-12 margin-bottom">
                                        <img style="width: 100%;" class="banner-cropper-preview" src="">
                                    </div>
                                    @if($product['image'])
                                        <div class="col-md-12" id="current-baner-for-product" >
                                            <img style="width: 50%;" src="{{$product['image']}}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="box box-primary"> <!-- Search results -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Thông tin sản phẩm</h3>
                            </div><!-- /.box-header -->

                            <div class="modal-body">
                                {!! Form::label('property_description', 'Miêu tả đặc tính sản phẩm') !!}
                                <div class="form-group">
                                    <div class="kacana-editor-content" data-table="products" data-field="property_description" data-id="{{$product->id}}" contenteditable="true" name="property_description" id="property_description">
                                        @if($product->property_description)
                                            {!! $product->getOriginal('property_description') !!}
                                        @else
                                            {!! '<p>+ Màu sắc: </p><p>+ Chất liệu:</p><p>+ Kích thước:<br>   - Chiều ngang: <br>   - Chiều cao:<br>   - Đáy:</p>' !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Thuộc tính sản phẩm</h3>
                        <div class="box-tools pull-left">
                            <button class="btn btn-primary btn-sm" data-target="#add-product-property" data-toggle="modal">
                                <i class="fa fa-plus"></i> thêm thuộc tính
                            </button>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="modal-body list-product-property">
                        <!-- property -->
                        @if($product->productProperties)
                            @foreach($product->productProperties as $property)
                                <div class="row" >
                                    <div class="col-xs-3" >
                                        <div class="form-group">
                                            <label>Chọn màu</label>
                                            <select name="color[]" class="form-control properties-color">
                                                <option value="0" >Chọn màu sắc sản phẩm</option>
                                                @foreach($tagColor as $item)
                                                    <option {{($property->tag_color_id==$item->child_id)?'selected':''}} value="{{$item->child_id}}" >{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2" >
                                        <label>chọn size</label>
                                        <select name="size[]" class="form-control select-size">
                                            <option value="0" >Chọn kích thước sản phẩm</option>
                                            @if($tagSize)
                                                @foreach($tagSize as $item)
                                                    @if($item->childs)
                                                        <optgroup label="{{$item->name}}">
                                                            @foreach($item->childs as $child)
                                                                <option {{($child->child_id == $property->tag_size_id)?'selected':''}} value="{{$child->child_id}}" >{{$child->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-xs-2" >
                                        <div class="form-group wrapper-properties-image">
                                            <label>Giá bán | {{formatMoney($property->price )}}</label><br>
                                            <input name="property_price[]" class="form-control" type="text" value="{{$property->price}}" >
                                        </div>
                                    </div>
                                    <div class="col-xs-1" >
                                        <div class="form-group wrapper-properties-image">
                                            <label>Số lượng</label><br>
                                            <input disabled class="form-control" type="text" value="2" >
                                        </div>
                                    </div>
                                    <div class="col-xs-1" >
                                        <div class="form-group wrapper-properties-image">
                                            <label>Chọn hình</label><br>
                                            @if($property->product_gallery_id)
                                                <button class="btn btn-success btn-sm" data-target="#modal-add-image-product-properties" data-toggle="modal">
                                                    <i class="fa fa-pencil"></i> chọn lại
                                                </button>
                                            @else
                                                <button class="btn btn-primary btn-sm" data-target="#modal-add-image-product-properties" data-toggle="modal">
                                                    <i class="fa fa-plus"></i> hình ảnh
                                                </button>
                                            @endif
                                            <input name="productGalleryId[]" type="text" class="hide" value="{{$property->product_gallery_id}}" >
                                        </div>
                                    </div>
                                    <div class="col-xs-1" >
                                        <div class="form-group">
                                            <label>xoá</label><br>
                                            <button class="btn btn-danger btn-sm" href="#remove-product-property" data-toggle="modal">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin sản phẩm</h3>
                    </div><!-- /.box-header -->

                    <div class="modal-body">
                        <!-- description -->
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả chi tiết sản phẩm') !!}
                            <div class="kacana-editor-content" data-table="products" data-field="description" data-id="{{$product->id}}" contenteditable="true" name="description" id="description">
                                @if($product->description)
                                    {!! $product->getOriginal('description') !!}
                                @endif
                            </div>
                        </div>

                        <!-- property-->
                        <div class="form-group">
                            {!! Form::label('property', 'Đặc tính sản phẩm') !!}
                            <div class="kacana-editor-content" data-table="products" data-field="property" data-id="{{$product->id}}" contenteditable="true" name="property" id="property">{!! $product->property !!}</div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('meta', 'Miêu tả sản phẩm') !!}<br/>
                            {!! Form::textarea('short_description', $product['short_description'], array('class'=>'form-control', 'style'=>'height:80px')) !!}
                        </div>
                        <button id="btn-upload-image-desc" class="" ></button>
                        <!-- meta -->
                        <div class="form-group">
                            {!! Form::label('meta', 'Meta') !!}<br/>
                            {!! Form::textarea('meta', $product['meta'], array('class'=>'form-control', 'style'=>'height:80px')) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/product">Huỷ</a>
                        <button type="submit" id="btn-update"class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </div>

        </div>

        {!! Form::close() !!}
    </section>
@stop
@extends('admin.product.modal')
@section('javascript')
    Kacana.product.detail.init();
@stop

