@extends('layouts.admin.master')

@section('title', 'Dashboard Admin page ')

@section('section-content-id', 'content-dashboard-page')

@section('content')
		<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		KACANA REPORT
		<small>Version 1.0</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- Info boxes -->
	<div class="row" >
		<div class="col-xs-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Kacana Simple Report</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<div class="btn-group">
							<button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/?duration=1">1 ngày</a></li>
								<li class="divider"></li>
								<li><a href="/?duration=7">1 Tuần</a></li>
								<li class="divider"></li>
								<li><a href="/?duration=30">1 Tháng</a></li>
								<li class="divider"></li>
								<li><a href="/?duration=90">3 Tháng</a></li>
								<li class="divider"></li>
								<li><a href="/?duration=180">6 Tháng</a></li>
								<li class="divider"></li>
								<li><a href="/?duration=365">1 Năm</a></li>
								<li class="divider"></li>
								<li><a href="/?duration=all">Tất cả</a></li>
							</ul>
						</div>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<div data-url="/index/reportChartUser" data-color="f39c12" data-type-report="User" data-xkey="created" data-ykey="count" class="info-box item-report bg-yellow">
								<span class="info-box-icon"><i class="ion ion-ios-personadd-outline"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Thành viên</span>
									<span class="info-box-number">{{$user_count}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 0%"></div>
									</div>
									<span class="progress-description">
										{{$user_count_duration}} thành viên mới trong {{$duration}} ngày
									  </span>
								</div><!-- /.info-box-content -->
							</div><!-- /.info-box -->
							<div data-url="/index/reportChartOrder" data-color="00a65a" data-type-report="Order" data-xkey="created" data-ykey="count" class="info-box item-report bg-green">
								<span class="info-box-icon"><i class="ion ion-ios-cart-outline"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Đơn hàng</span>
									<span class="info-box-number">{{$order_count}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 0%"></div>
									</div>
									<span class="progress-description">
										{{$order_count_duration}} đơn hàng trong {{$duration}} ngày
									  </span>
								</div><!-- /.info-box-content -->
							</div><!-- /.info-box -->
							<div data-url="/index/reportChartProductLike" data-color="dd4b39" data-type-report="ProductLike" data-xkey="created" data-ykey="count" class="info-box item-report bg-red">
								<span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Thích sản phẩm</span>
									<span class="info-box-number">{{$like_count}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 0%"></div>
									</div>
									<span class="progress-description">
										{{$like_count_duration}} lượt thích sản phẩm trong {{$duration}} ngày
									  </span>
								</div><!-- /.info-box-content -->
							</div><!-- /.info-box -->
							<div data-url="/index/reportChartProductView" data-color="00c0ef" data-type-report="ProductView" data-xkey="created" data-ykey="count" class="info-box item-report bg-aqua">
								<span class="info-box-icon"><i class="ion ion-ios-eye-outline"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Xem sản phẩm</span>
									<span class="info-box-number">{{$view_count}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 0%"></div>
									</div>
									<span class="progress-description">
										{{$view_count_duration}} lượt xem sản phẩm trong {{$duration}} ngày
									  </span>
								</div><!-- /.info-box-content -->
							</div>
							<div data-url="/index/reportChartTrackingSearch" data-color="d81b60" data-type-report="TrackingSearch" data-xkey="created" data-ykey="count" class="info-box item-report bg-maroon">
								<span class="info-box-icon"><i class="ion ion-ios-search"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Tìm kiếm</span>
									<span class="info-box-number">{{$search_count}}</span>
									<div class="progress">
										<div class="progress-bar" style="width: 0%"></div>
									</div>
									<span class="progress-description">
										{{$search_count_duration}} lượt tìm kiếm trong {{$duration}} ngày
									  </span>
								</div><!-- /.info-box-content -->
							</div>
						</div>
						</div>
					</div><!-- /.row -->
				</div><!-- ./box-body -->
			</div><!-- /.box -->
		<div class="col-xs-8">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Kacana Chart Report</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-xs-4">
							<div class="form-group">
								<label>Chọn thời gian:</label>

								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input class="form-control pull-right" id="report-duration" type="text">
								</div>
								<!-- /.input group -->
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label>Loại báo cáo:</label>

								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-area-chart"></i>
									</div>
									<select id="report-type" class="form-control" >
										<option value="day">
											ngày
										</option>
										<option value="month">
											tháng
										</option>
										<option value="year">
											năm
										</option>
									</select>
								</div>
								<!-- /.input group -->
							</div>
						</div>
						<div class="col-xs-4">
							<label>.</label>
							<div class="form-group">
								<button id="btn-show-report" class="btn btn-primary">Thống kê</button>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 451px;"></div>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- ./box-body -->

		</div><!-- /.box -->
	</div>
	{{--<div class="row">--}}
		{{--<div class="col-lg-12">--}}
			{{--<div class="box box-primary">--}}
				{{--<div class="box-header">--}}
					{{--<h3 class="box-title">Search user</h3>--}}

				{{--</div>--}}
				{{--<div class="box-body">--}}
					{{--<form method="post" class="form-inline">--}}
						{{--<input type="text" name="name" class="form-control" placeholder="Search Name"/>--}}
						{{--<input type="text" name="email" class="form-control" placeholder="Search Email"/>--}}
						{{--<input type="text" name="phone" class="form-control" placeholder="Search Phone"/>--}}
						{{--<select class="form-control" name="searchRole">--}}
							{{--<option value="">All Role</option>--}}
							{{--<option value="'{{KACANA_USER_ROLE_ADMIN}}'">Admin</option>--}}
							{{--<option value="'{{KACANA_USER_ROLE_BUYER}}'">Buyer</option>--}}
						{{--</select>--}}
						{{--<select class="form-control" name="searchStatus">--}}
							{{--<option value="">All Status</option>--}}
							{{--<option value="{{KACANA_USER_STATUS_ACTIVE}}">Active</option>--}}
							{{--<option value="{{KACANA_USER_STATUS_INACTIVE}}">Inactive</option>--}}
							{{--<option value="{{KACANA_USER_STATUS_BLOCK}}">Block</option>--}}
							{{--<option value="{{KACANA_USER_STATUS_CREATE_BY_SYSTEM}}">create by sys</option>--}}
						{{--</select>--}}
						{{--<button type="submit" class="btn btn-primary">Find</button>--}}
						{{--<button type="reset" class="btn btn-default">Reset</button>--}}
					{{--</form>--}}
				{{--</div>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div>--}}
	<div class="row" >
		<div class="col-lg-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title table-title-report">Detail Table</h3>
				</div>
				<div class="box-body no-padding">
					<table id="detailTable" class="table table-striped">
						<thead>
						</thead>
						<tbody>
						</tbody>
					</table>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</section><!-- /.content -->

@stop

@section('javascript')
	Kacana.index.init();
@stop