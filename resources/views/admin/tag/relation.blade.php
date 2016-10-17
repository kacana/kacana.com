@extends('layouts.admin.master')

@section('title', 'Tag manager')

@section('section-content-id', 'content-tag-relation')

@section('content')
    <section id="product-detail-page" class="content">
        @if($message != '')
            <div class="row">
                <div class="alert alert-warning alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <b>Alert!</b>
                    {{$message}}
                </div>
            </div>
        @endif

            <div class="row">
                <div class="col-lg-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{$typeName}}</h3>
                            <div class="box-tools pull-left">
                                <button class="btn btn-primary btn-sm create-tag-btn" id="create-tag-btn" data-parent-id="0" data-type-id="{{$typeId}}" type="button">
                                    <i class="icon-plus"></i> Create New Tag
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="tree-tags" data-url="/tag/getTreeTag/?relationType={{$typeId}}"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Tag Collection</h3>
                        </div>
                        <div class="box-body">
                            @include('admin.tag.list')
                        </div>
                    </div>
                </div>
            </div>
    </section>
@stop
@extends('admin.tag.modal')
@section('javascript')
    Kacana.tag.relationTags.init();
@stop