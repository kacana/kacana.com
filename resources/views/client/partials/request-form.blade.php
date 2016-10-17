{!! Form::open(array('id' =>'form-create-request-info', 'onsubmit'=>false)) !!}
<div class="modal-body">
    <!-- name -->
    <div class="form-group">
        {!! Form::label('name', 'Họ và tên') !!}
        {!! Form::text('name', null, array('required', 'class' => 'form-control')) !!}
        <span id="error-name" class="has-error text-red"></span>
    </div>
    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, array('required', 'class' => 'form-control')) !!}
        <span id="error-email" class="has-error text-red"></span>
    </div>
    <div class="form-group">
        {!! Form::label('phone', 'Phone') !!}
        {!! Form::text('phone', null, array('required', 'class' => 'form-control')) !!}
        <span id="error-phone" class="has-error text-red"></span>
    </div>
    <div class="form-group">
        {!! Form::label('message', 'Tin nhắn') !!}
        {!! Form::textarea('message', null, array('required', 'class' => 'form-control custom-height')) !!}
        <span id="error-message" class="has-error text-red"></span>
    </div>

    {!! Form::hidden('product_id',$id, ['id'=>'product_id'])!!}
</div>
<div class="row">
    <div align="center"><button type="button" id="btn-create" onclick="Kacana.homepage.sendRequest({{$id}})" class="btn btn-primary btn-icon">Gửi</button></div>
</div>
{!! Form::close() !!}