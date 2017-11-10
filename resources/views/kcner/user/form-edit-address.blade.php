<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Thêm Người dùng</h4>
        </div>
        {!! Form::open(array('id' =>'form-edit-address', 'onsubmit'=>false, 'enctype'=>"multipart/form-data")) !!}
        <div class="modal-body">
            <!-- name -->
            <div class="form-group">
                {!! Form::label('name', 'Tên') !!}
                {!! Form::text('name', $item->name, array('required', 'class' => 'form-control', 'placeholder' => 'Tên người dùng')) !!}
                <span id="error-name" class="has-error text-red"></span>
            </div>

            <!-- email -->
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', $item->email, array('required', 'class' => 'form-control', 'placeholder' => 'Email người dùng')) !!}
                <span id="error-email" class="has-error text-red"></span>
            </div>

            <!-- phone number -->
            <div class="form-group">
                {!! Form::label('phone', 'Số điện thoại') !!}
                {!! Form::text('phone', $item->phone, array('required', 'class' => 'form-control', 'placeholder' => 'Số điện thoại')) !!}
                <span id="error-phone" class="has-error text-red"></span>
            </div>

            <!-- phone number -->
            <div class="form-group">
                {!! Form::label('street', 'Địa chỉ') !!}
                {!! Form::text('street', $item->street, array('required', 'class' => 'form-control', 'placeholder' => 'Địa chỉ')) !!}
                <span id="error-street" class="has-error text-red"></span>
            </div>

            <!-- city_id -->
            <div class="form-group">
                {!! Form::label('city_id', 'Thành phố') !!}
                <div>{!! Form::select('city_id', $cities, $item->city_id, array('class'=>'form-control', 'onchange'=>'Kacana.user.userAddress.changeCity()')) !!}</div>
            </div>

            <!-- Ward -->
            <div class="form-group">
                {!! Form::label('ward_id', 'Quận') !!}
                <div id="ward">{!! Form::select('ward_id', $wards, $item->ward_id, array('class'=>'form-control')) !!}</div>
            </div>

            <!-- id -->
            {!! Form::hidden('id', $item->id) !!}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            <button type="button" id="btn-create" onclick="Kacana.user.userAddress.edit()" class="btn btn-primary">Cập nhật</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>


