@extends('layouts.admin.master')

@section('content')
    <section id="product-detail-page" class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                </div>
            </div>
            {!! Form::open(array('method'=>'post', 'id' =>'form-edit-product', 'onsubmit'=>true, 'enctype'=>"multipart/form-data")) !!}
            <div class="col-xs-5">
                <div class="box box-primary box-body"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin sản phẩm</h3>
                    </div><!-- /.box-header -->

                    <div class="modal-body">
                        <!-- name -->
                        <div class="form-group">
                            {!! Form::label('name', 'ID sản phẩm') !!}
                            {!! Form::text('name', null, array('required','id' => 'productId', 'class' => 'form-control', 'placeholder' => 'Tên sản phẩm')) !!}
                        </div>
                        <!-- name -->
                        <div class="form-group">
                            {!! Form::label('name', 'Tên sản phẩm') !!}
                            {!! Form::text('name', null, array('required', 'class' => 'form-control', 'placeholder' => 'Tên sản phẩm')) !!}
                        </div>

                        <!-- price -->
                        <div class="form-group">
                            {!! Form::label('price', 'Giá sản phẩm') !!}
                            {!! Form::text('price', null, array('required', 'class' => 'form-control', 'placeholder' => 'Gía sản phẩm')) !!}
                            <span id="error-price" class="has-error text-red"></span>
                        </div>

                        <!-- sell price -->
                        <div class="form-group">
                            {!! Form::label('sell_price', 'Giá bán sản phẩm') !!}
                            {!! Form::text('sell_price', null, array('required', 'class' => 'form-control', 'placeholder' => 'Giá bán sản phẩm')) !!}
                        </div>

                        <!-- tags -->
                        <div class="form-group">
                            {!! Form::label('tags', 'Tags') !!}
                            <div class="treeview-tags" data-role="treeview" id="tree-tags" data-url="/tag/getTags"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/product">Huỷ</a>
                        <button type="submit" id="btn-update"class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </div>

            <div id="product-image-detail" class="col-xs-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Hình ảnh sản phẩm</h3>
                        <div class="box-tools pull-left">
                            <div id="image-upload-container"></div>
                            <button id="select-file" class="btn btn-sm btn-primary">
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

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-primary box-body"> <!-- Search results -->
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin sản phẩm</h3>
                    </div><!-- /.box-header -->

                    <div class="modal-body">
                        <!-- property -->
                        <div class="form-group">
                            {!! Form::label('property', 'Đặc tính sản phẩm') !!}
                            <div class="kacana-editor-content" contenteditable="true" name="property" id="property"></div>
                            {{--{!! Form::textarea('property', $product['property']) !!}--}}
                        </div>

                        <!-- property description -->
                        <div class="form-group">
                            {!! Form::label('property_description', 'Miêu tả đặc tính sản phẩm') !!}
                            <div class="kacana-editor-content" contenteditable="true" name="property_description" id="property_description"></div>
                        </div>

                        <!-- description -->
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả sản phẩm') !!}
                            <div class="kacana-editor-content" contenteditable="true" name="description" id="description"></div>

                            {{--{!! Form::textarea('description', $product['description']) !!}--}}
                        </div>

                        <!-- meta -->
                        <div class="form-group">
                            {!! Form::label('meta', 'Meta') !!}<br/>
                            {!! Form::textarea('meta', null, array('class'=>'form-control', 'style'=>'height:80px')) !!}
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
@section('javascript')
    Kacana.product.detail.init();
@stop

