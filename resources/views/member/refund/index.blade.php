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
			<li class="active">Pengembalian Dana</li>
		</ol>

		<h2 class="head text-center">Pengembalian Dana</h2>

		@if ( count($data) > 0 )
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kode Pemesanan</th>
						<th scope="col">Nama Produk</th>
						<th scope="col">Tanggal Pembuatan</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					@php
						$i=0;
					@endphp
					@foreach ($data as $refund)
						<tr>
							<td>{{ $i+=1 }}</td>
							<td>
								<a href="{{ route('member.refund.show', ['id' => $refund->id]) }}">{{ $refund->code_booking }}</a>
							</td>
							<td>{{ $refund->product_name }}</td>
							<td>{!! date('d F Y', strtotime($refund->created_at)); !!}</td>
							<td>
								@if ( $refund->status == App\Models\Refund::STATUS_PENDING )
									<span class="label label-warning status">menunggu pemilik konfirmasi</span>
								@elseif ( $refund->status == App\Models\Refund::STATUS_VERIFIED )
									<span class="label label-info status">menunggu admin verifikasi</span>
								@else
									<span class="label label-success status">selesai</span>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<h1 class="headerData">Tidak ada data yang tersedia</h1>
		@endif
	</div>
@endsection