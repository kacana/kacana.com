<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Thêm Người dùng</h4>
        </div>
        {!! Form::open(array('id' =>'form-create-user', 'onsubmit'=>false, 'enctype'=>"multipart/form-data")) !!}
        <div class="modal-body">
            <!-- name -->
            <div class="form-group">
                {!! Form::label('name', 'Tên người dùng') !!}
                {!! Form::text('name', null, array('required', 'class' => 'form-control', 'placeholder' => 'Tên người dùng')) !!}
                <span id="error-name" class="has-error text-red"></span>
            </div>

            <!-- email -->
            <div class="form-group">
                {!! Form::label('email', 'Email người dùng') !!}
                {!! Form::text('email', null, array('required', 'class' => 'form-control', 'placeholder' => 'Email người dùng')) !!}
                <span id="error-email" class="has-error text-red"></span>
            </div>

            <!-- phone number -->
            <div class="form-group">
                {!! Form::label('phone', 'Số điện thoại') !!}
                {!! Form::text('phone', null, array('required', 'class' => 'form-control', 'placeholder' => 'Số điện thoại')) !!}
                <span id="error-phone" class="has-error text-red"></span>
            </div>c

            <!-- password -->
            <div class="form-group">
                {!! Form::label('password', 'Mật khẩu người dùng') !!}
                {!! Form::password('password', array('required', 'class' => 'form-control', 'placeholder' => 'Mật khẩu người dùng')) !!}
                <span id="error-password" class="has-error text-red"></span>
            </div>

            <!-- image -->
            <div class="form-group">
                {!! Form::label('image', 'Hình ảnh') !!}
                {!! Form::file('image') !!}
                <span id="error-image" class="has-error text-red"></span>
            </div>

            <!-- role -->
            <div class="form-group">
                {!! Form::label('role', 'Role') !!}
                {!! Form::select('role', array('admin' => 'Admin', 'guess' => 'Guess', 'buyer' => 'Buyer'),'Vui lòng ',array('class'=>'form-control')) !!}
            </div>

            <!-- user_type -->
            <div class="form-group">
                {!! Form::label('user_type', 'User type') !!}
                {!! Form::select('user_type', $types, array('class'=>'form-control')) !!}
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            <button type="button" id="btn-create" onclick="Kacana.user.createUser()"class="btn btn-primary">Thêm mới</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

