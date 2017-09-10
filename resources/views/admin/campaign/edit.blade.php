@extends('layouts.admin.master')

@section('title', 'Campaign management')

@section('section-content-id', 'campaign-edit-page')

@section('content')
    <section>
        <div class="custom-box">
            <div class="box-header">
                <h3 class="box-title">Campaign: {{$campaign->name}}</h3>
                <div class="box-tools pull-left ">
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        {!! Form::open(array('method'=>'post', 'id' =>'form-edit-product', 'onsubmit'=>true, 'enctype'=>"multipart/form-data")) !!}
        <div class="row">
            <div class="col-xs-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Campaign Information</h3>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Campaign ID</label>
                            <input required="required" readonly="readonly" id="campagin_id" class="form-control"
                                   placeholder="campaign id" name="campaign_id" value="{{$campaign->id}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="name">Campaign name</label>
                            <input required="required" id="campagin_name" class="form-control" placeholder="campaign id"
                                   name="campaign_name" value="{{$campaign->name}}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="name">Display date</label>
                            <input data-start="{{$campaign->display_start_date}}"
                                   data-end="{{$campaign->display_end_date}}" required="required" id="display_date"
                                   class="form-control"
                                   placeholder="displace date" name="display_date"
                                   value="{{$campaign->display_start_date}} - {{$campaign->display_end_date}}"
                                   type="text">
                        </div>
                        <div class="form-group">
                            <label for="name">Apply date</label>
                            <input data-start="{{$campaign->start_date}}" data-end="{{$campaign->end_date}}"
                                   required="required" id="apply_date" class="form-control"
                                   placeholder="displace date" name="apply_date"
                                   value="{{$campaign->start_date}} - {{$campaign->end_date}}"
                                   type="text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/campaign/edit?campaignId={{$campaign->id}}">Huỷ</a>
                        <button type="submit" id="btn-update" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Campaign Rocket</h3>
                        <div class="box-tools pull-left ">
                            <button class="btn btn-success btn-sm create-campaign-rocket-btn" type="button">
                                <i class="fa fa-plus"></i>
                                 Create
                            </button>
                        </div>
                    </div>

                    <div class="box-body no-padding">
                        <table id="campaignRocketTable" class="table table-striped"></table>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Campaign banner</h3>
                    </div>

                    <div id="campaign-banner" class="modal-body">
                        <!-- property -->
                        <div class="box-tools margin-bottom">
                            <div id="image-upload-container"></div>
                            <button type="button" id="select-file-main-image" class="btn btn-sm btn-primary">
                                <i class="icon icon-plus"></i> <span>Select File</span>
                                <input type="file" class="hide">
                            </button>

                            <button type="button" id="banner-upload-btn" class="btn btn-sm btn-success hide">
                                <i class="icon icon-upload-alt"></i> <span>Confirm</span>
                            </button>
                            @if($campaign['image'])
                                <button type="button" id="banner-remove-btn" class="btn btn-sm btn-danger">
                                    <i class="icon icon-remove-circle"></i> <span>Remove</span>
                                </button>
                            @endif
                        </div>
                        <div class="row">
                            <div class="banner-cropper col-md-12 margin-bottom">
                                <img style="width: 100%;" class="banner-cropper-preview" src="">
                            </div>
                            @if($campaign['image'])
                                <div class="col-md-12" id="current-baner-for-product" >
                                    <img style="width: 50%;" src="{{$campaign['image']}}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Campaign description</h3>
                    </div>
                    <div class="modal-body">
                        <div class="kacana-editor-content" data-table="campaigns" data-field="description" data-id="{{$campaign->id}}" contenteditable="true" name="description" id="description">
                            @if($campaign->description)
                                {!! $campaign->getOriginal('description') !!}
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" href="/campaign/edit?campaignId={{$campaign->id}}">Huỷ</a>
                        <button type="submit" id="btn-update" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <button id="btn-upload-image-desc" class=""></button>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Campaign Product</h3>
                        <div class="box-tools pull-left ">
                            <button class="btn btn-success btn-sm create-campaign-rocket-btn" type="button">
                                <i class="fa fa-plus"></i>
                                Add product
                            </button>
                        </div>
                    </div>
                </div>

                <div class="box-body no-padding">
                    <table id="campaignProductTable" class="table table-striped"></table>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>

@stop

@extends('admin.campaign.modal')

@section('javascript')
    Kacana.campaign.editCampaign.init();
@stop