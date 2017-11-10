@extends('layouts.kcner.master')

@section('title', 'Chat management')

@section('section-content-id', 'content-chat-page')

@section('content')
	<section>
		<div class="custom-box">
			<div class="box-header">
				<h3 class="box-title">Quản lý CHAT</h3>
			</div>
		</div>
	</section>

	<section class="content">
		<div id="chat-thread-list" class="row" >

		</div>
	</section>
@stop

@extends('admin.chat.template')

@section('javascript')
	Kacana.chat.bindEvent();
@stop