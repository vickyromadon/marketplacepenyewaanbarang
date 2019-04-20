@extends('layouts.app')

@section('css')
	<style>
		.headerData{
			color: #d3d3d3;
			text-align: center;
			padding: 100px 0px;
		}

		.status{
			font-size: 15px;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li><a href="{{ route('member.index') }}">Home</a></li>
			<li class="active">Pengiriman</li>
		</ol>

		<h2 class="head text-center">Pengiriman</h2>

		@if ( count($data) > 0 )
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kode Booking</th>
						<th scope="col">Nama Produk</th>
						<th scope="col">Tanggal Pengiriman</th>
						<th scope="col">Tanggal Tiba</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					@php
						$i=0;
					@endphp
					@foreach ($data as $delivery)
						<tr>
							<td>{{ $i+=1 }}</td>
							<td>
								<a href="{{ route('member.delivery.show', ['id' => $delivery->id]) }}">{{ $delivery->code_booking }}</a>
							</td>
							<td>{{ $delivery->product_name }}</td>
							<td>
								@if ( $delivery->delivery_date != null )
									{!! date('d F Y', strtotime($delivery->delivery_date)) !!}
								@else
									-
								@endif
							</td>
							<td>
								@if ( $delivery->arrive_date != null )
									{!! date('d F Y', strtotime($delivery->arrive_date)) !!}
								@else
									-
								@endif
							</td>
							<td>
								@if ( $delivery->status == App\Models\Delivery::STATUS_DELIVERED )
									<span class="label label-info status">produk sedang di jalan</span>
								@elseif ( $delivery->status == App\Models\Delivery::STATUS_ARRIVED )
									<span class="label label-success status">produk diterima</span>
								@else
									<span class="label label-warning status">menunggu pengiriman</span>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<h1 class="headerData">No data available</h1>
		@endif
	</div>
@endsection

