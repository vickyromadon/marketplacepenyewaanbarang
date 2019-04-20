@extends('layouts.admin')

@section('header')
	<h1>
		Transaction REKBER
		<small>Details</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('transaction_rekber.index') }}">Transaction REKBER</a></li>
		<li class="active">Transaction REKBER Details</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Product</h3>
				</div>
				<div class="box-body">
					<div class="row">
	                    <div class="col-md-6">
	                        <strong>Product Name</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           <a href="{{ route('product.index') }}/{{ $data->booking->product->id }}" target="_blank">{{ $data->booking->product->name }}</a>
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Price</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->price }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Deposite</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->deposite }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Time Periode</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           Per {{ $data->booking->product->time_periode }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Status</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->status }}
	                        </p>
	                    </div>
	                </div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Transaction</h3>
				</div>
				<div class="box-body">
					<div class="row">
	                    <div class="col-md-6">
	                        <strong>Code Booking</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           	{{ $data->booking->code }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Start Rental</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                        	{!! date('d F Y', strtotime($data->booking->start_rent)); !!}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>End Rental</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           	{!! date('d F Y', strtotime($data->booking->end_rent)); !!}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Price</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           	{{ $data->price }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Time Periode</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           	Per {{ $data->time_periode }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Total Periode</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           	{{ $data->total_periode }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Deposite</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           	{{ $data->deposite }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Grand Total</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           	{{ $data->grand_total }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Status</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->status }}
	                        </p>
	                    </div>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Owner Product</h3>
				</div>
				<div class="box-body">
					<div class="row">
	                    <div class="col-md-6">
	                        <strong>Owner Name</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->user->name }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Email</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->user->email }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Phone</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->user->phone != null ? $data->booking->product->user->phone : '-' }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Address</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->user->address != null ? $data->booking->product->user->address : '-' }}
	                        </p>
	                    </div>
	                </div>
					<div class="row">
	                    <div class="col-md-6">
	                        <strong>Status</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->product->user->status }}
	                        </p>
	                    </div>
	                </div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">User Booking</h3>
				</div>
				<div class="box-body">
					<div class="row">
	                    <div class="col-md-6">
	                        <strong>Owner Name</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->user->name }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Email</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->user->email }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Phone</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->user->phone != null ? $data->booking->user->phone : '-' }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Address</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->user->address != null ? $data->booking->product->user->address : '-' }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Status</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->booking->user->status }}
	                        </p>
	                    </div>
	                </div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="box box-warning" style="overflow-y: scroll; height: 200px;">
				<div class="box-header with-border">
					<h3 class="box-title">Guaranties</h3>
				</div>
				<div class="box-body">
		        	<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<th>No</th>
								<th>Filename</th>
								<th>Number File</th>
								<th>Type File</th>
								<th>Uploaded Date</th>
							</thead>
							<tbody>
								@php
									$i=0;
								@endphp
								@foreach ($data->guaranties as $guaranty)
									<tr>
										<td>{{ $i+=1 }}.</td>
										<td>
											<a href="{{ asset('storage/'.$guaranty->file->path) }}" target="_blank">
												{{ $guaranty->file->filename }}
											</a>
										</td>
										<td>{{ $guaranty->number }}</td>
										<td>{{ $guaranty->type }}</td>
										<td>{!! date('d F Y', strtotime($guaranty->created_at)); !!}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
		    	</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="box box-warning" style="overflow-y: scroll; height: 200px;">
				<div class="box-header with-border">
					<h3 class="box-title">Aggrement Letter</h3>
				</div>
				<div class="box-body">
		        	<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<th>No</th>
								<th>Filename</th>
								<th>Uploaded Date</th>
							</thead>
							<tbody>
								@php
									$i=0;
								@endphp
								@foreach ($data->document as $document)
									<tr>
										<td>{{ $i+=1 }}.</td>
										<td>
											<a href="{{ asset('storage/'.$document->file->path) }}" target="_blank">
												{{ $document->file->filename }}
											</a>
										</td>
										<td>{!! date('d F Y', strtotime($document->created_at)); !!}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
		    	</div>
			</div>
		</div>
	</div>
@endsection
