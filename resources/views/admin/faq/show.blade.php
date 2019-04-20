@extends('layouts.admin')

@section('header')
	<h1>
		FAQ
		<small>Details</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('faq.index') }}">FAQ</a></li>
		<li class="active">FAQ Details</li>
	</ol>
@endsection

@section('content')
	<div class="box box-warning">
		<div class="box-body">
			<strong><i class="fa fa-question margin-r-5"></i> Question</strong>

			<p class="text-muted">{{ $data->question }}</p>

			<hr>

			<strong><i class="fa fa-info margin-r-5"></i> Answer</strong>

			<p class="text-muted">{{ $data->answer }}</p>
		</div>
		<div class="box-footer">
			<a href="{{ route('faq.index') }}" class="btn btn-warning"><i class="fa  fa-mail-reply"></i> Back</a>
		</div>
	</div>
@endsection