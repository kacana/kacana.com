<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Cập nhật thương hiệu sản phẩm</h4>
        </div>
        {!! Form::open(array('id' =>'form-create-branch', 'onsubmit'=>false, 'enctype'=>"multipart/form-data")) !!}
            <div class="modal-body">
                <!-- name -->
                <div class="form-group">
                    {!! Form::label('name', 'Tên thương hiệu') !!}
                    {!! Form::text('name', $item->name, array('required', 'class' => 'form-control', 'placeholder' => 'Tên thương hiệu')) !!}
                    <span id="error-name" class="has-error text-red"></span>
                </div>

                <!-- image -->
                <div class="form-group">
                    {!! Form::label('image', 'Hình ảnh') !!}
                    {!! Form::file('image') !!}
                    @if(!empty($item->image))
                    <img width="50" height="50" src="/images/branch/{{date('Y-m-d', strtotime($item->created))}}/{{$item->image}}"/>
                    @endif
                    <span id="error-image" class="has-error text-red"></span>
                </div>

                <!-- id -->
                {!! Form::hidden('id', $item->id) !!}
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            <button type="button" id="btn-create-branch" onclick="Kacana.product.branch.editBranch()"class="btn btn-primary">Cập nhật</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
