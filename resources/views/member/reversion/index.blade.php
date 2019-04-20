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
			<li class="active">Pengembalian</li>
		</ol>

		<h2 class="head text-center">Pengembalian</h2>

		@if ( count($data) > 0 )
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kode Pemesanan</th>
						<th scope="col">Nama Produk</th>
						<th scope="col">Tanggal Berakhir Sewa</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					@php
						$i=0;
					@endphp
					@foreach ($data as $reversion)
						<tr>
							<td>{{ $i+=1 }}</td>
							<td>
								<a href="{{ route('member.reversion.show', ['id' => $reversion->id]) }}">{{ $reversion->code_booking }}</a>
							</td>
							<td>{{ $reversion->product_name }}</td>
							<td>{!! date('d F Y', strtotime($reversion->end_rent)); !!}</td>
							<td>
								@if ( $reversion->status == App\Models\Reversion::STATUS_DELIVERED )
									<span class="label label-info status">Produk Sedang di Jalan</span>
								@elseif ( $reversion->status == App\Models\Reversion::STATUS_ARRIVED )
									<span class="label label-success status">Produk Diterima</span>
								@elseif ( $reversion->status == App\Models\Reversion::STATUS_EMPTY )
									<span class="label label-default status">Menunggu Pengembalian</span>
								@else
									<span class="label label-warning status">Mohon Pengiriman Produk</span>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<h1 class="headerData">Tidak Ada Data Tersedia</h1>
		@endif
	</div>
@endsection