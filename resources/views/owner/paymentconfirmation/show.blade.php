@extends('layouts.owner')

@section('header')
	<h1>
		Payment Confirmation
		<small>Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('owner.payment_confirmation.index') }}">Payment Confirmation</a></li>
		<li class="active">Detail Payment Confirmation</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail</h3>
		        </div>
		        
		        <div class="box-body">
		        	<div class="row">
		        		<div class="col-md-6">
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
			                        <strong>Payment Method</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ $data->payment_method }}
			                        </p>
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Product Name</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           <a href="{{ route('owner.product.show', ['id' => $data->booking->product->id]) }}" target="_blank">{{ $data->booking->product->name }}</a>
			                        </p>
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Status Payment</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           @if( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_REJECTED )
											<span class="label label-danger">{{ $data->status_payment }}</span>
										@elseif( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_APPROVED )
											<span class="label label-success">{{ $data->status_payment }}</span>
										@elseif( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_PENDING )
											<span class="label label-warning">{{ $data->status_payment }}</span>
										@elseif( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_VERIFIED )
											<span class="label label-primary">{{ $data->status_payment }}</span>
										@else
											<span class="label label-default">has not made a payment yet</span>
										@endif
			                        </p>
			                    </div>
			                </div>
			                
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Status Transaction</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	@if( $data->status == \App\Models\Transaction::STATUS_PENDING )
											<span class="label label-default">{{ $data->status }}</span>
										@elseif( $data->status == \App\Models\Transaction::STATUS_APPROVED )
											<span class="label label-success">{{ $data->status }}</span>
										@elseif( $data->status == \App\Models\Transaction::STATUS_REJECTED )
											<span class="label label-danger">{{ $data->status }}</span>
										@elseif( $data->status == \App\Models\Transaction::STATUS_CANCELED )
											<span class="label label-warning">{{ $data->status }}</span>
										@else
											<span class="label label-primary">{{ $data->status }}</span>
										@endif
			                        </p>
			                    </div>
			                </div>
		        		</div>
		        		<div class="col-md-6">
							<div class="row">
			                    <div class="col-md-6">
			                        <strong>Rental Date</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                        	{!! date('d F Y', strtotime($data->booking->start_rent)); !!} -
			                           	{!! date('d F Y', strtotime($data->booking->end_rent)); !!}
			                        </p>
			                    </div>
			                </div>

			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Price / {{ $data->time_periode }}</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ $data->price }}
			                        </p>
			                    </div>
			                </div>
			                
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Security Deposite</strong>
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
						</div>
		        	</div>
		        </div>
		        <div class="box-footer">
		        	@if ( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_VERIFIED )
		        		<button id="btnApprove" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Approve</button>
		        	@else
		        		&nbsp;
		        	@endif
		        </div>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-file-image-o"></i> Guaranty</h3>
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
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-file-pdf-o"></i> Aggrement Letter</h3>
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
	
	@if ( $data->note != null )
		<div class="row">
			<div class="col-md-12">
				<div class="box box-danger">
			        <div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-file-pdf-o"></i> Note</h3>
			        </div>
			        <div class="box-body">
			        	<div class="row">
		        			<div class="col-md-12">
		    					<div class="row">
				                    <div class="col-md-1">
				                        <strong>Note</strong>
				                    </div>
				                    <div class="col-md-11">
				                        <p>
				                           {{ $data->note }}
				                        </p>
				                    </div>
				                </div>
			        		</div>
			        	</div>
			        </div>
			    </div>
			</div>
		</div>
	@endif

	<!-- Modal Approve -->
    <div class="modal fade" tabindex="-1" role="dialog" id="approveModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formApprove">
                	<input type="hidden" id="approve_id" name="approve_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Transaction Approve</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you approve this transaction ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Yes
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

	        $('#btnApprove').click(function () {
	        	$('#formApprove button[type=submit]').button('reset');
	        	$('#approveModal').modal('show');
	        });

	        $('#formApprove').submit(function (event) {
                event.preventDefault();
                $('#formApprove button[type=submit]').button('loading');
                $('#formApprove div.form-group').removeClass('has-error');
                $('#formApprove .help-block').empty();

                var _data = $("#formApprove").serialize();
                $.ajax({
                    url: "{{ route('owner.payment_confirmation.approve') }}",
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

	                        $('#approveModal').modal('hide');
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
                        
                        $('#formApprove button[type=submit]').button('reset');
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
                        $('#formApprove button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection