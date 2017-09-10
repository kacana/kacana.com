@extends('layouts.admin.master')

@section('title', 'Campaign management')

@section('section-content-id', 'content-campaign-list-page')

@section('content')
	<section>
		<div class="custom-box">
			<div class="box-header">
				<h3 class="box-title">Quản lý Campaign</h3>
				<div class="box-tools pull-left ">
					<button class="btn btn-primary btn-sm create-campaign-btn" type="button">
						<i class="fa fa-tag"></i>
						Create Campaign
					</button>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Tìm kiếm Campagin</h3>
					</div>
					<div class="box-body">
						<form method="post" class="form-inline">
							<input type="text" name="name" class="form-control" placeholder="Tên Campaign"/>
							<button type="submit" class="btn btn-primary">Tìm kiếm</button>
							<button type="reset" class="btn btn-default">Reset</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Danh sách Campagin</h3>

					</div>
					<div class="box-body no-padding">
						<table id="campaignTable" class="table table-striped"></table>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</section>

@stop

@extends('admin.campaign.modal')

@section('javascript')
	Kacana.campaign.listCampaign.init();
@stop