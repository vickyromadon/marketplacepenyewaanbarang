@extends('layouts.owner')

@section('header')
	<h1>
		Dashboard Owner
		<small>Control Panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>{{ count($product) }}</h3>
					<p>Product</p>
				</div>
				<div class="icon">
					<i class="fa fa-cubes"></i>
				</div>
				<a href="{{ route('owner.product.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>{{ count($rekber) }}</h3>
					<p>Transaction Rekber</p>
				</div>
				<div class="icon">
					<i class="fa fa-credit-card"></i>
				</div>
				<a href="{{ route('owner.transaction.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-4 col-md-4">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>{{ count($cod) }}</h3>
					<p>Transaction COD</p>
				</div>
				<div class="icon">
					<i class="fa fa-credit-card"></i>
				</div>
				<a href="{{ route('owner.cod.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
	</div>
@endsection
