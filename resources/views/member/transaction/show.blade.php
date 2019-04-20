@extends('layouts.app')

@section('content')
	<div class="container">
		<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li><a href="{{ route('member.index') }}">Home</a></li>
			<li><a href="{{ route('member.transaction.index', ['id' => Auth::user()->id ]) }}">Transaksi</a></li>
			<li class="active">Rincian Transaksi</li>
		</ol>

		<h2 class="head text-center">Rincian Transaksi</h2>
		
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success">
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
				                    <div class="col-md-6">
				                        <strong>Kode Booking</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                           {{ $data->booking->code }}
				                        </p>
				                    </div>
				                </div>

				                <hr>

				                <div class="row">
				                    <div class="col-md-6">
				                        <strong>Nama Produk</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                           <a href="{{ route('member.product.index', ['id' =>  $data->booking->product->id]) }}" target="_blank">{{ $data->booking->product->name }}</a>
				                        </p>
				                    </div>
				                </div>

				                <hr>

				                <div class="row">
				                    <div class="col-md-6">
				                        <strong>Metode Pembayaran</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                           {{ $data->payment_method }}
				                        </p>
				                    </div>
				                </div>

				                <hr>
				                
				                <div class="row">
				                    <div class="col-md-6">
				                        <strong>Status Transaksi</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
											@if ( $data->status == App\Models\Transaction::STATUS_CANCELED )
												<span class="label label-warning status">Dibatalkan</span>
											@elseif ( $data->status == App\Models\Transaction::STATUS_REJECTED )
												<span class="label label-danger status">Ditolak</span>
											@elseif ( $data->status == App\Models\Transaction::STATUS_PENDING )
												<span class="label label-info status">Silakan Unggah Dokumen</span>
											@elseif ( $data->status == App\Models\Transaction::STATUS_VERIFIED )
												@if( $data->payment_method == 'rekber' )
													<span class="label label-primary">Silakan Lakukan Konfirmasi Pembayaran</span>
												@else
													<span class="label label-primary">Harap Buat Rating pada Produk</span>
												@endif	
											@else
												<span class="label label-success status">Selesai</span>
											@endif
				                        </p>
				                    </div>
				                </div>

				                <hr>

				                <div class="row">
				                    <div class="col-md-6">
				                        <strong>Nama Pemilik</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                           {{ $data->booking->product->user->name }} <a href="#" id="btnContact" class="label label-info">Konta Pemilik</a>
				                        </p>
				                    </div>
				                </div>
							</div>

							<div class="col-md-6">
								<div class="row">
				                    <div class="col-md-6">
				                        <strong>Tanggal Sewa</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                        	{!! date('d F Y', strtotime($data->booking->start_rent)); !!} -
				                           	{!! date('d F Y', strtotime($data->booking->end_rent)); !!}
				                        </p>
				                    </div>
				                </div>

				                <hr>

				                <div class="row">
				                    <div class="col-md-6">
				                        <strong>Harga /
											@if( $data->time_periode == 'Day' )
												Hari
											@elseif( $data->time_periode == 'Week' )
												Minggu
											@elseif( $data->time_periode == 'Mounth' )
												Bulan
											@else
												Tahun
											@endif
				                        </strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                           {{ number_format($data->price) }}
				                        </p>
				                    </div>
				                </div>

				                <hr>
				                
				                <div class="row">
				                    <div class="col-md-6">
				                        <strong>Uang Jaminan</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                           {{ number_format($data->deposite) }}
				                        </p>
				                    </div>
				                </div>

				                <hr>

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

				                <hr>

				                <div class="row">
				                    <div class="col-md-6">
				                        <strong>Kuantitas</strong>
				                    </div>
				                    <div class="col-md-6">
				                        <p>
				                           {{ $data->booking->quantity }}
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
				                           {{ number_format($data->grand_total) }}
				                        </p>
				                    </div>
				                </div>

				                @if ( $data->status_payment != \App\Models\Transaction::STATUS_PAYMENT_EMPTY )
				                	<hr>
				                	<div class="row">
					                    <div class="col-md-6">
					                        <strong>Status Pembayaran</strong>
					                    </div>
					                    <div class="col-md-6">
					                        <p>
					                           @if( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_REJECTED )
													<span class="label label-danger">Ditolak</span>
												@elseif( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_APPROVED )
													<span class="label label-success">Disetujui</span>
												@elseif( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_PENDING )
													<span class="label label-warning">menunggu verifikasi pembayaran dari admin</span>
												@elseif( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_VERIFIED )
													<span class="label label-primary">Diverifikasi</span>
												@else
													<span class="label label-default">belum melakukan pembayaran</span>
												@endif
					                        </p>
					                    </div>
					                </div>
				                @endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if ( $data->note != null )
			<div class="row">
				<div class="col-md-12">
					<div class="box box-success">
						<div class="box-header with-border">
							<center><h3 class="box-title">Catatan</h3></center>
				        </div>
				        <div class="box-body">
	    					<div class="row">
			                    <div class="col-md-2">
			                        <strong>Catatan</strong>
			                    </div>
			                    <div class="col-md-10">
			                        <p>
			                           {{ $data->note != null ? $data->note : '-' }}
			                        </p>
			                    </div>
			                </div>

			                @if ( $data->delivery != null )
			                	<div class="row">
				                    <div class="col-md-2">
				                        <strong>Status Pengiriman</strong>
				                    </div>
				                    <div class="col-md-10">
				                        <p>
				                           {{ $data->delivery->status }}
				                        </p>
				                    </div>
				                </div>
			                @endif
				        </div>
					</div>
				</div>
			</div>
		@endif

		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-success">
							<form action="#" method="POST" id="formUploadGuaranty" enctype="multipart/form-data">
								@csrf
								<div class="box-header with-border">
									<center><h3 class="box-title">Syarat dan Ketentuan Jaminan</h3></center>
								</div>
								<div class="box-body">
									<div class="row">
										<div class="col-sm-12">
											<p>
												{!! $data->booking->product->terms_and_conditions !!}
											</p>
										</div>
									</div>

									<hr>

									<div class="form-horizontal">
			                    		<div class="form-group">
			                    			<label class="col-sm-4 control-label">Tipe File</label>
			                    			
			                    			<div class="col-sm-8">
			                                    <select name="type_file" id="type_file" class="form-control">
			                                    	<option value="">-- Pilih Salah Satu --</option>
			                                    	<option value="KTP">Kartu Tanda Penduduk (KTP)</option>
			                                    	<option value="KARTU KELUARGA">Kartu Keluarga (KK)</option>
			                                    	<option value="SIM">Surat Izin Mengemudi (SIM)</option>
			                                    	<option value="PASSPORT">Passport</option>
			                                    </select>
			                                    <span class="help-block"></span>
			                                </div>
			                    		</div>

			                    		<div class="form-group">
			                    			<label class="col-sm-4 control-label">Nomor</label>
			                    			
			                    			<div class="col-sm-8">
												<input type="text" id="number_file" name="number_file" class="form-control" placeholder="Nomor File" autocomplete="off">
			                                    <span class="help-block"></span>
			                                </div>
			                    		</div>

			                    		<div class="form-group">
			                    			<label class="col-sm-4 control-label">Unggah File</label>
			                    			
			                    			<div class="col-sm-8">
			                                    <input type="file" id="upload_file" name="upload_file" class="form-control">
			                                    <span class="help-block"></span>
			                                </div>
			                    		</div>
			                    	</div>
								</div>

								@if( $data->status == \App\Models\Transaction::STATUS_PENDING || $data->status == \App\Models\Transaction::STATUS_REJECTED )
									<div class="box-footer">
										<button type="reset" class="btn btn-cancel pull-left">Setel ulang</button>
										<button type="submit" class="btn btn-success pull-right">Unggah</button>
									</div>
								@endif
							</form>
						</div>
					</div>

					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-header with-border">
								<center><h3 class="box-title">Jaminan Yang Telah Diunggah</h3></center>
							</div>
							<div class="box-body" style="overflow-y: scroll; height: 200px;">
								<div class="col-sm-12">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Nama File</th>
												<th>Tipe File</th>
												<th>Tanggal Unggah</th>
											</tr>
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
				</div>
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-success">
							<form action="#" method="POST" id="formUploadPdf" enctype="multipart/form-data">
								@csrf
								<div class="box-header with-border">
									<center><h3 class="box-title">Surat perjanjian</h3></center>
								</div>
								
								<div class="box-body">
									<div class="row">
										<div class="col-sm-12">
											<center>
												<p>
													Berikut adalah tombol untuk mengunduh surat perjanjian
													<a href="{{ route('member.transaction.getPdf', ['id' => $data->id]) }}">
														<u>Unduh Surat</u>
													</a>
												</p>
											</center>
										</div>
									</div>

									<hr>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-horizontal">
			                            		<div class="form-group">
			                            			<label class="col-sm-4 control-label">Upload Surat Perjanjian</label>
			                            			
			                            			<div class="col-sm-8">
					                                    <input type="file" id="upload_pdf" name="upload_pdf" class="form-control">
					                                    <span class="help-block"></span>
					                                </div>
			                            		</div>
			                            	</div>
										</div>
									</div>
								</div>
								
								@if( $data->status == \App\Models\Transaction::STATUS_PENDING || $data->status == \App\Models\Transaction::STATUS_REJECTED )
									<div class="box-footer"> 
										<button type="reset" class="btn btn-cancel pull-left">Setel ulang</button>
										<button type="submit" class="btn btn-success pull-right">Unggah</button>
									</div>
								@endif
							</form>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-header with-border">
								<center><h3 class="box-title">Surat Perjanjian Yang Telah Diunggah</h3></center>
							</div>
							<div class="box-body" style="overflow-y: scroll; height: 200px;">
								<div class="col-sm-12">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Nama File</th>
												<th>Tanggal Unggah</th>
											</tr>
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

				@if ( $data->status == \App\Models\Transaction::STATUS_APPROVED && $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_APPROVED && $data->delivery == null )
					<button id="btnAddress" class="col-md-12 btn btn-primary">
						<h4 style="color: white; padding: 5px;">Confirmasi Delivery</h4>
					</button>
				@endif

				@if( $data->status == \App\Models\Transaction::STATUS_VERIFIED && $data->payment_method == 'cod' )
					<button id="btnRating" class="col-md-12 btn btn-warning">
						<h4 style="color: white; padding: 5px;">Rating</h4>
					</button>
				@endif
			</div>
		</div>
		
		@if ( $data->payment_method == 'rekber' && ($data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_EMPTY || $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_REJECTED ) && $data->status == \App\Models\Transaction::STATUS_VERIFIED )
			<div class="row">
				<div class="col-md-12">
					<div class="box box-success"> 
						<form action="#" method="POST" id="formPaymentConfirmation" enctype="multipart/form-data">
							@csrf
							<div class="box-header with-border">
								<center><h3 class="box-title">Payment Confirmation</h3></center>
							</div>

							<div class="box-body">
	                    		<div class="form-group">
	                    			<label class="col-sm-12 control-label">Date Of Transfer</label>
	                    			
	                    			<div class="col-sm-12">
	                                    <input type="text" id="transfer_date" name="transfer_date" class="form-control" placeholder="Input Your Date Of Transfer" autocomplete="off">
	                                    <span class="help-block"></span>
	                                </div>
	                    		</div>

	                    		<div class="form-group">
	                    			<label class="col-sm-12 control-label">Bank Name</label>
	                    			
	                    			<div class="col-sm-12">
	                                    <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Input Your Bank Name" autocomplete="off">
	                                    <span class="help-block"></span>
	                                </div>
	                    		</div>

	                    		<div class="form-group">
	                    			<label class="col-sm-12 control-label">Account Name</label>
	                    			
	                    			<div class="col-sm-12">
	                                    <input type="text" id="account_name" name="account_name" class="form-control" placeholder="Input Your Account Name" autocomplete="off">
	                                    <span class="help-block"></span>
	                                </div>
	                    		</div>

	                    		<div class="form-group">
	                    			<label class="col-sm-12 control-label">Account Number</label>
	                    			
	                    			<div class="col-sm-12">
	                                    <input type="text" id="account_number" name="account_number" class="form-control" placeholder="Input Your Account Number" autocomplete="off">
	                                    <span class="help-block"></span>
	                                </div>
	                    		</div>

	                    		<div class="form-group">
	                    			<label class="col-sm-12 control-label">Receive Bank Account</label>
	                    			
	                    			<div class="col-sm-12">
	                    				<select id="receive_bank" name="receive_bank" class="form-control">
	                    					<option value="">-- Select One --</option>
	                    					@foreach($banks as $bank)
	                    						<option value="{{ $bank->id }}">{{ $bank->name }}</option>
	                    					@endforeach
	                    				</select>
	                                    <span class="help-block"></span>
	                                </div>
	                    		</div>

	                    		<div class="form-group">
	                    			<label class="col-sm-12 control-label">Proof Image</label>
	                    			
	                    			<div class="col-sm-12">
	                    				<input type="file" id="proof_image" name="proof_image" class="form-control">
	                                    <span class="help-block"></span>
	                                </div>
	                    		</div>
							</div>

							<div class="box-footer">
								<div class="col-sm-12">
									<button type="submit" class="btn btn-success pull-right">Confirm</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="row">
				@foreach( $banks as $bank )
					<div class="col-md-4">
						<div class="box box-success">
							<div class="box-header with-border">
								<center><h3 class="box-title">{{ $bank->name }}</h3></center>
							</div>
						</div>
						<div class="box-body">
							<div class="row">
			                    <div class="col-md-6">
			                        <strong>Account Name</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ $bank->owner }}
			                        </p>
			                    </div>
			                </div>
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Account Number</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ $bank->number }}
			                        </p>
			                    </div>
			                </div>
						</div>
					</div>
				@endforeach
			</div>
		@endif 
	</div>

	<!-- Modal Request Delivery -->
    <div class="modal modal-primary fade" tabindex="-1" role="dialog" id="addressModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formAddress">
                	@csrf
                	<input type="hidden" id="transaction_id" name="transaction_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Confirmasi Delivery</h4>
                    </div>

                    <div class="modal-body">
                    	<div class="form-horizontal">
                    		<div class="form-group">
	                            <label class="col-sm-3 control-label">Recipient Name</label>
	                            
	                            <div class="col-sm-9">
	                                <input type="text" name="name" id="name" class="form-control" placeholder="Recipient Name" value="{{ $data->booking->user->name }}"> 
	                                <span class="help-block"></span>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-sm-3 control-label">Recipient Phone</label>
	                            
	                            <div class="col-sm-9">
	                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Recipient Phone" value="{{ $data->booking->user->phone }}"> 
	                                <span class="help-block"></span>
	                            </div>
	                        </div>
                    		<div class="form-group">
	                            <label class="col-sm-3 control-label">Recipient Address</label>
	                            
	                            <div class="col-sm-9">
	                                <textarea name="address" id="address" class="form-control" placeholder="Recipient Address">
	                                	{{ $data->booking->user->address }}
	                                </textarea>
	                                <span class="help-block"></span>
	                            </div>
	                        </div>
                    	</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-default" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	
	<!-- contact modal -->
    <div class="modal modal-info fade" tabindex="-1" role="dialog" id="contactModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Detail Contact Owner</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Name</strong>
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
                                {{ $data->booking->product->user->phone }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- rating modal -->
    <div class="modal modal-default fade" tabindex="-1" role="dialog" id="ratingModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formRating">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Rating Product</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" id="product_id" name="product_id" value="{{ $data->booking->product_id }}">
                            <input type="hidden" id="transaction_id" name="transaction_id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Rate</label>
                    
                                <div class="col-sm-10">
                                    <select name="rate" id="rate" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Note</label>
                    
                                <div class="col-sm-10">
                                    <textarea name="note" id="note" class="form-control"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> 
                            Back
                        </button>
                        <button type="submit" class="btn btn-warning pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script>
        jQuery(document).ready(function($){
        	// Checking Session
	    	@if( session('success') )
	    		heading: 'Success',
	    		text : "{{ session('success') }}",
	            position : 'top-right',
	            allowToastClose : true,
	            showHideTransition : 'fade',
	            icon : 'success',
	            loader : false
	    	@endif

	    	@if ( session('error') )
	            $.toast({
	            	heading: 'Error',
	                text : "{{ session('error') }}",
	                position : 'top-right',
	                allowToastClose : true,
	                showHideTransition : 'fade',
	                icon : 'error',
	                loader : false,
	                hideAfter: 5000
	            });
	        @endif

	        $('#btnRating').click(function () {
                $('#formRating')[0].reset();
                $('#formRating button[type=submit]').button('reset');
                $('#formRating div.form-group').removeClass('has-error');
                $('#formRating .help-block').empty();

                $('#ratingModal').modal('show');
            });

            $('#formRating').submit(function (event) {
                event.preventDefault();
                $('#formRating button[type=submit]').button('loading');
                $('#formRating div.form-group').removeClass('has-error');
                $('#formRating .help-block').empty();

                var _data = $("#formRating").serialize();
                $.ajax({
                    url: "{{ route('member.transaction.rating') }}",
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
                                heading: 'Success',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'success',
                                loader : false
                            });

                            setTimeout(function () { 
                                location.reload();
                            }, 2000);

                            $('#ratingModal').modal('hide');
                        }
                        else{
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter : 5000,
                            }); 
                        }
                        
                        $('#formRating button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 400) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        $('#formRating button[type=submit]').button('reset');
                    }
                });
            });

	        $('#btnContact').click(function(event) {
                $('#contactModal').modal('show');              
            });

	        $('#btnAddress').click(function () {
	        	$('#formAddress button[type=submit]').button('reset');
	        	$('#addressModal').modal('show');
	        });

	        $('#formAddress').submit(function (event) {
                event.preventDefault();
                $('#formAddress button[type=submit]').button('loading');
                $('#formAddress div.form-group').removeClass('has-error');
                $('#formAddress .help-block').empty();

                var _data = $("#formAddress").serialize();
                $.ajax({
                    url: "{{ route('member.transaction.confirm_address') }}",
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

                            setTimeout(function () {
                                location.href = "/delivery";
                            }, 2000);

	                        $('#addressModal').modal('hide');
                        }
                        else{
                        	$.toast({
	                            heading: 'Error',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'error',
	                            loader : false,
	                            hideAfter : 5000,
	                        });	
                        }
                        
                        $('#formAddress button[type=submit]').button('reset');
                    },

                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formAddress').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formAddress input[name='" + data[key].name + "']").length ? $("#formAddress input[name='" + data[key].name + "']") : $("#formAddress textarea[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                        }
                        else if (response.status === 400) {
                            // Bad Client Request
	                        $.toast({
	                            heading: 'Error',
	                            text : response.responseJSON.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'error',
	                            loader : false,
	                            hideAfter: 5000
	                        });
                        }
                        else {
                            $.toast({
	                            heading: 'Error',
	                            text : "Whoops, looks like something went wrong.",
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'error',
	                            loader : false,
	                            hideAfter: 5000
	                        });
                        }
                        $('#formAddress button[type=submit]').button('reset');
                    }
                });
            });

	        $('#formUploadGuaranty').submit(function (event) {
                event.preventDefault();
                $('#formUploadGuaranty button[type=submit]').button('loading');
                $('#formUploadGuaranty div.form-group').removeClass('has-error');
                $('#formUploadGuaranty .help-block').empty();

                var formData = new FormData($("#formUploadGuaranty")[0]);

                $.ajax({
                    url: "{{ route('member.transaction.guaranty', ['id' => $data->id]) }}",
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,   
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

	                        setTimeout(function () { 
                                location.reload();
                            }, 2000);
                        }
                        else{
							$.toast({
	                            heading: 'Error',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'error',
	                            loader : false
	                        });                        	
                        }
                        $('#formUploadGuaranty button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formUploadGuaranty').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formUploadGuaranty input[name='" + data[key].name + "']").length ? $("#formUploadGuaranty input[name='" + data[key].name + "']") : $("#formUploadGuaranty select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            
                            if(error['upload_file'] != undefined){
                                $("#formUploadGuaranty input[name='upload_file']").parent().find('.help-block').text(error['upload_file']);
                                $("#formUploadGuaranty input[name='upload_file']").parent().find('.help-block').show();
                                $("#formUploadGuaranty input[name='upload_file']").parent().parent().addClass('has-error');
                            }
                        }
                        else if (response.status === 400) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        $('#formUploadGuaranty button[type=submit]').button('reset');
                    }
                });
            });

	        $('#formUploadPdf').submit(function (event) {
                event.preventDefault();
                $('#formUploadPdf button[type=submit]').button('loading');
                $('#formUploadPdf div.form-group').removeClass('has-error');
                $('#formUploadPdf .help-block').empty();

                var formData = new FormData($("#formUploadPdf")[0]);

                $.ajax({
                    url: "{{ route('member.transaction.getPdf', ['id' => $data->id]) }}",
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,   
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

	                        setTimeout(function () { 
                                location.reload();
                            }, 2000);
                        }
                        else{
							$.toast({
	                            heading: 'Error',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'error',
	                            loader : false
	                        });                        	
                        }
                        $('#formUploadPdf button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            if(error['upload_pdf'] != undefined){
                                $("#formUploadPdf input[name='upload_pdf']").parent().find('.help-block').text(error['upload_pdf']);
                                $("#formUploadPdf input[name='upload_pdf']").parent().find('.help-block').show();
                                $("#formUploadPdf input[name='upload_pdf']").parent().parent().addClass('has-error');
                            }
                        }
                        else if (response.status === 400) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        $('#formUploadPdf button[type=submit]').button('reset');
                    }
                });
            });

			$('#formPaymentConfirmation').submit(function (event) {
                event.preventDefault();
                $('#formPaymentConfirmation button[type=submit]').button('loading');
                $('#formPaymentConfirmation div.form-group').removeClass('has-error');
                $('#formPaymentConfirmation .help-block').empty();

                var formData = new FormData($("#formPaymentConfirmation")[0]);

                $.ajax({
                    url: "{{ route('member.transaction.payment_confirmation', ['id' => $data->id]) }}",
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,   
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

	                        setTimeout(function () { 
                                location.reload();
                            }, 2000);
                        }
                        else{
							$.toast({
	                            heading: 'Error',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'error',
	                            loader : false
	                        });                        	
                        }
                        $('#formPaymentConfirmation button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formPaymentConfirmation').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formPaymentConfirmation input[name='" + data[key].name + "']").length ? $("#formPaymentConfirmation input[name='" + data[key].name + "']") : $("#formPaymentConfirmation select[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['proof_image'] != undefined){
                                $("#formPaymentConfirmation input[name='proof_image']").parent().find('.help-block').text(error['proof_image']);
                                $("#formPaymentConfirmation input[name='proof_image']").parent().find('.help-block').show();
                                $("#formPaymentConfirmation input[name='proof_image']").parent().parent().addClass('has-error');
                            }
                        }
                        else if (response.status === 400) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }
                        $('#formPaymentConfirmation button[type=submit]').button('reset');
                    }
                });
            });

			//Date picker
	        $('#transfer_date').datepicker({
	            autoclose: true,
	            format: 'yyyy-mm-dd',
	            endDate: '+1d',
	            datesDisabled: '+1d',
	        });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('#rate').barrating({
                theme: 'fontawesome-stars'
            });
        });
    </script>
@endsection