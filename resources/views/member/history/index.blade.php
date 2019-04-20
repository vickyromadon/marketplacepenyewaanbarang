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
			<li class="active">Pemesanan</li>
		</ol>

		<h2 class="head text-center">Pemesanan</h2>
		@if ( count($data) > 0 )
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kode Pemesanan</th>
						<th scope="col">Nama Produk</th>
						<th scope="col">Tanggal Pemesanan</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					@php
						$i=0;
					@endphp
					@foreach ($data as $book)
						@if ( $book->transaction == null )
							<tr>
								<td>{{ $i+=1 }}</td>
								<td>
									<a href="{{ route('member.history.show', ['id' => $book->id]) }}">{{ $book->code }}</a>
								</td>
								<td>{{ $book->product->name }}</td>
								<td>{!! date('d F Y', strtotime($book->created_at)); !!}</td>
								<td>
									@if ( $book->status == App\Models\Booking::STATUS_EMPTY )
										<span class="label label-default status">Silahkan Tentukan Tanggal</span>
									@elseif ( $book->status == App\Models\Booking::STATUS_CANCELED )
										<span class="label label-warning status">Dibatalkan</span>
									@elseif ( $book->status == App\Models\Booking::STATUS_REJECTED )
										<span class="label label-danger status">Ditolak</span>
									@elseif ( $book->status == App\Models\Booking::STATUS_PENDING )
										<span class="label label-info status">Menunggu Persetujuan</span>
									@else
										<span class="label label-success status">Silakan Pilih Metode Pembayaran</span>
									@endif
								</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		@else
			<h1 class="headerData">Tidak Ada Data Tersedia</h1>
		@endif
		<div class="pull-right">
			{{ $data->links() }}
		</div>
	</div>
@endsection