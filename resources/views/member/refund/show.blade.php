@extends('layouts.app')

@section('content')
	<div class="container">
		<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li><a href="{{ route('member.index') }}">Home</a></li>
			<li><a href="{{ route('member.refund.index', ['id' => Auth::user()->id ]) }}">Pengembalian Dana</a></li>
			<li class="active">Rincian Pengembalian Dana</li>
		</ol>

		<h2 class="head text-center">Rincian Pengembalian Dana</h2>

		<div class="row">
			<div class="col-md-4">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Kontak Pemilik</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-4">
		                        <strong>Nama</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->transaction->booking->product->user->name }}
		                        </p>
		                    </div>
		                </div>
						
						<hr>

		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Phone</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->transaction->booking->product->user->phone }}
		                        </p>
		                    </div>
		                </div>

						<hr>

		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Email</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->transaction->booking->product->user->email }}
		                        </p>
		                    </div>
		                </div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Transaksi</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-6">
		                        <strong>Harga</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           {{ $data->transaction->price }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-6">
		                        <strong>Waktu Sewa</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           {{ $data->transaction->total_periode }} {{ $data->transaction->time_periode }} 
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-6">
		                        <strong>Deposite</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           {{ $data->transaction->deposite }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-6">
		                        <strong>Total Keseluruhan</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           {{ $data->transaction->grand_total }}
		                        </p>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class="col-md-4">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Produk</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-6">
		                        <strong>Nama Produk</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           {{ $data->transaction->booking->product->name }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-6">
		                        <strong>Jangka waktu</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           Per {{ $data->transaction->booking->product->time_periode }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-6">
		                        <strong>Harga</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           {{ $data->transaction->booking->product->price }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-6">
		                        <strong>Deposite</strong>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           {{ $data->transaction->booking->product->deposite }}
		                        </p>
		                    </div>
		                </div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Pengembalian Dana</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-4">
		                        <strong>Harga untuk Pemilik</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->price_owner != null ? $data->price_owner : '-' }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Harga untuk Member</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->price_member != null ? $data->price_member : '-' }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Denda</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->ammercement != null ? $data->ammercement : '-' }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Catatan</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->note != null ? $data->note : '-' }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Status</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                          	@if( $data->status != null )
										@if( $data->status == \App\Models\Refund::STATUS_PENDING )
											<span class="label label-warning">menunggu pemilik konfirmasi</span>
										@elseif( $data->status == \App\Models\Refund::STATUS_VERIFIED )
											<span class="label label-info">menunggu admin verifikasi</span>
										@else
											<span class="label label-success">selesai</span>
										@endif
									@else
										-
		                        	@endif
		                        </p>
		                    </div>
		                </div>
					</div>
				</div>
			</div>
			
			@if ( $data->status == \App\Models\Refund::STATUS_FINISHED )
				<div class="col-md-6">
					<div class="box box-success">
						<div class="box-header with-border">
							<center><h3 class="box-title">Pengembalian Dana Diterima</h3></center>
						</div>
						<div class="box-body">
							<center><h3>Rp. {{ $data->grand_total_member }}</h3></center>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection