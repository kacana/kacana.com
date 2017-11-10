<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Cập nhật tag</h4>
        </div>
        {!! Form::open(array('id' =>'form-edit-tag', 'onsubmit'=>false)) !!}
            <div class="modal-body">
                <!-- name -->
                <div class="form-group">
                    {!! Form::label('name', 'Tag') !!}
                    {!! Form::text('name', $item->name, array('required', 'class' => 'form-control', 'placeholder' => 'Tag')) !!}
                    <span id="error-name" class="has-error text-red"></span>
                </div>

                <!-- id -->
                {!! Form::hidden('id', $item->id) !!}
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            <button type="button" id="btn-create-branch" onclick="Kacana.tag.editTag()"class="btn btn-primary">Cập nhật</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
