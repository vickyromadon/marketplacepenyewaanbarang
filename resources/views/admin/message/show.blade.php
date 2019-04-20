@extends('layouts.admin')

@section('header')
	<h1>
		Message
		<small>Details</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('message.index') }}">Message</a></li>
		<li class="active">Message Details</li>
	</ol>
@endsection

@section('content')
	<div class="box box-warning">
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<strong><i class="fa fa-user margin-r-5"></i> Name</strong>

					<p class="text-muted">{{ $data->name }}</p>
				</div>
				<div class="col-md-6">
					<span class=" pull-right"><i class="fa fa-calendar margin-r-5"></i> <b>Date</b> : {!! date('d F Y', strtotime($data->created_at)); !!}</span>
				</div>
			</div>
			
			<hr>

			<strong><i class="fa fa-at margin-r-5"></i> Email</strong>

			<p class="text-muted">{{ $data->email }}</p>

			<hr>

			<strong><i class="fa fa-phone margin-r-5"></i> Phone</strong>

			<p class="text-muted">{{ $data->phone }}</p>

			<hr>

			<strong><i class="fa fa-reorder margin-r-5"></i> Content</strong>

			<p class="text-muted">{{ $data->content }}</p>
		</div>
		<div class="box-footer">
			<a href="{{ route('message.index') }}" class="btn btn-warning"><i class="fa  fa-mail-reply"></i> Back</a>
		</div>
	</div>
@endsection