@extends('layouts.admin.master')

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

	<section id="chat-thread-list" class="content">

	</section>
@stop

@extends('admin.chat.template')

@section('javascript')
	Kacana.chat.init();
@stop