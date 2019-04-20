@extends('layouts.app')

@section('content')
	<div class="container">
		<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li><a href="{{ route('member.index') }}">Home</a></li>
			<li><a href="{{ route('member.delivery.index', ['id' => Auth::user()->id ]) }}">Pengiriman</a></li>
			<li class="active">Rincian Pengiriman</li>
		</ol>

		<h2 class="head text-center">Rincian Pengiriman</h2>

		<div class="row">
			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Penerima</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-4">
		                        <strong>Nama</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->name }}
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
		                           {{ $data->phone }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Alamat</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->address }}
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Tanggal Pengiriman</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
									@if ( $data->delivery_date != null )
										{!! date('d F Y', strtotime($data->delivery_date)); !!}
									@else
										-
									@endif
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Tanggal Tiba</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           @if ( $data->arrive_date != null )
										{!! date('d F Y', strtotime($data->arrive_date)); !!}
									@else
										-
									@endif
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Bukti Pengiriman</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           	@if ( $data->file != null )
		                           		<img src="{{ asset('storage/'.$data->file->path) }}" class="img-thumbnail" style="min-height: 300px; object-fit: cover;">
		                           	@else
		                           		-
		                           	@endif
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
		                           	@if ( $data->status == App\Models\Delivery::STATUS_DELIVERED )
										<span class="label label-info status">produk sedang di jalan</span>
									@elseif ( $data->status == App\Models\Delivery::STATUS_ARRIVED )
										<span class="label label-success status">produk diterima</span>
									@else
										<span class="label label-warning status">menunggu pengiriman</span>
									@endif
		                        </p>
		                    </div>
		                </div>
					</div>
					@if ( $data->status == \App\Models\Delivery::STATUS_DELIVERED )
						<div class="box-footer">
							<button id="btnArrived" class="btn btn-success pull-right">Arrived</button>
						</div>
					@endif
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Sewa</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-4">
		                        <strong>Rincian Produk</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           	<a href="{{ route('member.product.index', ['id' => $data->transaction->booking->product->id]) }}" target="_blank">
		                           		{{ $data->transaction->booking->product->name }}
		                           	</a>
		                        </p>
		                    </div>
		                </div>
		                <hr>
		                <div class="row">
		                    <div class="col-md-4">
		                        <strong>Rincian Transaksi</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           	<a href="{{ route('member.transaction.show', ['id' => $data->transaction->id]) }}" target="_blank">
		                           		{{ $data->transaction->booking->code }}
		                           	</a>
		                        </p>
		                    </div>
		                </div>
		            </div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Arrived -->
    <div class="modal modal-success fade" tabindex="-1" role="dialog" id="arrivedModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formArrived">
                	@csrf
                	<input type="hidden" id="arrived_id" name="arrived_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Konfirmasi Ketibaan Produk</h4>
                    </div>

                    <div class="modal-body">
                        <p>Apakah anda ingin merubah status pengiriman "Menjadi Tiba" ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-default" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                        	Ya
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

	        $('#btnArrived').click(function () {
	        	$('#formArrived button[type=submit]').button('reset');
	        	$('#arrivedModal').modal('show');
	        });

	        $('#formArrived').submit(function (event) {
                event.preventDefault();
                $('#formArrived button[type=submit]').button('loading');
                $('#formArrived div.form-group').removeClass('has-error');
                $('#formArrived .help-block').empty();

                var _data = $("#formArrived").serialize();
                $.ajax({
                    url: "{{ route('member.delivery.arrived') }}",
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

	                        $('#arrivedModal').modal('hide');
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
                        
                        $('#formArrived button[type=submit]').button('reset');
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
                        $('#formArrived button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection