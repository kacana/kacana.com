
@extends('layouts.admin.master')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Thương hiệu sản phẩm</h3>
            </div><!-- /.box-header -->
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header box-search">
                        <div class="box-search-title">
                            <h4>Tìm kiếm thương hiệu sản phẩm</h4>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i> Thêm mới
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-search">
                            {!! Form::open(array('id' => 'search-form')) !!}
                            <div class="col-xs-3">
                                {!! Form::text('name', null, array('class' => 'form-control input-sm', 'placeholder' => 'Tìm kiếm', 'id'=>'search-name')) !!}
                            </div>
                            {!! Form::button('Tìm kiếm', array('type' => 'submit', 'class'=>'btn btn-primary btn-sm')) !!}
                            {!! Form::button('Reset', array('type' => 'reset', 'class' => 'btn btn-default btn-sm')) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="box"> <!-- Search results -->
                    <div class="box-header">
                        <h3 class="box-title">Kết quả tìm kiếm</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive no-padding">
                        <table id="table" class="table row-border table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th class="nosort"></th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@stop

@section('javascript')
    Kacana.product.branch.listBranch();

@stop
@extends('admin.branch.form-create')
@extends('admin.branch.edit-modal')

