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
			<li class="active">Transaksi</li>
		</ol>
		
		<h2 class="head text-center">Transaksi</h2>
		@if ( count($data) > 0 )
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Kode Booking</th>
						<th scope="col">Metode Pembayaran</th>
						<th scope="col">Tanggal Transaksi</th>
						<th scope="col">Status</th>
					</tr>
				</thead>
				<tbody>
					@php
						$i=0;
					@endphp
					@foreach ($data as $transaction)
						<tr>
							<td>{{ $i+=1 }}</td>
							<td>
								<a href="{{ route('member.transaction.show', ['id' => $transaction->id]) }}">{{ $transaction->code }}</a>
							</td>
							<td>{{ $transaction->payment_method }}</td>
							<td>{!! date('d F Y', strtotime($transaction->created_at)); !!}</td>
							<td>
								@if ( $transaction->status == App\Models\Transaction::STATUS_CANCELED )
									<span class="label label-warning status">Dibatalkan</span>
								@elseif ( $transaction->status == App\Models\Transaction::STATUS_REJECTED )
									<span class="label label-danger status">Ditolak</span>
								@elseif ( $transaction->status == App\Models\Transaction::STATUS_PENDING )
									<span class="label label-info status">Silakan Unggah Dokumen</span>
								@elseif ( $transaction->status == App\Models\Transaction::STATUS_VERIFIED )
									@if( $transaction->payment_method == 'rekber' )
										<span class="label label-primary status">Silakan Lakukan Konfirmasi Pembayaran</span>
									@else
										<span class="label label-primary status">Harap Buat Rating pada Produk</span>
									@endif
								@else
									<span class="label label-success status">Selesai</span>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<h1 class="headerData">Tidak ada data yang tersedia</h1>
		@endif
		<div class="pull-right">
			{{ $data->links() }}
		</div>
	</div>


@endsection