<section>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thêm thương hiệu sản phẩm</h4>
                </div>
                {!! Form::open(array('id' =>'form-create-branch', 'onsubmit'=>false, 'enctype'=>"multipart/form-data")) !!}
                    <div class="modal-body">
                        <!-- name -->
                        <div class="form-group">
                            {!! Form::label('name', 'Tên thương hiệu') !!}
                            {!! Form::text('name', null, array('required', 'class' => 'form-control', 'placeholder' => 'Tên thương hiệu')) !!}
                            <span id="error-name" class="has-error text-red"></span>
                        </div>

                        <!-- image -->
                        <div class="form-group">
                            {!! Form::label('image', 'Hình ảnh') !!}
                            {!! Form::file('image', null) !!}
                            <span id="error-image" class="has-error text-red"></span>
                        </div>

                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" id="btn-create" onclick="Kacana.product.branch.createBranch()"class="btn btn-primary">Thêm mới</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</section>
