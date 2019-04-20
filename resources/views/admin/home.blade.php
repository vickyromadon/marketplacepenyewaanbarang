@extends('layouts.admin')

@section('header')
	<h1>
		Dashboard Admin
		<small>Control Panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>{{ count($user) }}</h3>
					<p>Member Active</p>
				</div>
				<div class="icon">
					<i class="fa fa-user"></i>
				</div>
				<a href="{{ route('members.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>{{ count($owner) }}</h3>
					<p>Owner Active</p>
				</div>
				<div class="icon">
					<i class="fa fa-user-md"></i>
				</div>
				<a href="{{ route('owners.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-orange">
				<div class="inner">
					<h3>{{ count($product) }}</h3>
					<p>Product Publish</p>
				</div>
				<div class="icon">
					<i class="fa fa-cubes"></i>
				</div>
				<a href="{{ route('product.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-purple">
				<div class="inner">
					<h3>{{ count($message) }}</h3>
					<p>Message</p>
				</div>
				<div class="icon">
					<i class="fa fa-envelope"></i>
				</div>
				<a href="{{ route('message.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
    </div>

    <div class="row">
		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>{{ count($ktpUser) }}</h3>
					<p>KTP Member Pending</p>
				</div>
				<div class="icon">
					<i class="fa fa-credit-card"></i>
				</div>
				<a href="{{ route('members.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-blue">
				<div class="inner">
					<h3>{{ count($ktpOwner) }}</h3>
					<p>KTP Owner Pending</p>
				</div>
				<div class="icon">
					<i class="fa fa-credit-card"></i>
				</div>
				<a href="{{ route('owners.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-gray">
				<div class="inner">
					<h3>{{ count($rekber) }}</h3>
					<p>Transaction REKBER</p>
				</div>
				<div class="icon">
					<i class="fa fa-credit-card"></i>
				</div>
				<a href="{{ route('transaction_rekber.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>{{ count($cod) }}</h3>
					<p>Transaction COD</p>
				</div>
				<div class="icon">
					<i class="fa fa-credit-card"></i>
				</div>
				<a href="{{ route('transaction_cod.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>    	
    </div>

    <div class="row">
    	<div class="col-lg-3 col-md-3">
			<div class="small-box bg-maroon">
				<div class="inner">
					<h3>{{ count($payment_confirmation) }}</h3>
					<p>Payment Confirmation</p>
				</div>
				<div class="icon">
					<i class="fa fa-money"></i>
				</div>
				<a href="{{ route('payment_confirmation.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<div class="small-box bg-navy">
				<div class="inner">
					<h3>{{ count($refund) }}</h3>
					<p>Refund</p>
				</div>
				<div class="icon">
					<i class="fa fa-dollar"></i>
				</div>
				<a href="{{ route('refund.index') }}" class="small-box-footer">
					More info <i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
    </div>
@endsection
