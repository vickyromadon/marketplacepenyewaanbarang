@extends('layouts.admin')

@section('header')
	<h1>
		Payment Confirmation
		<small>Details</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('payment_confirmation.index') }}">Payment Confirmation</a></li>
		<li class="active">Payment Confirmation Details</li>
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
				</div>
			</div>
		</div>
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
				</div>
			</div>
		</div>
	</div>	

	<div class="row">
		<div class="col-md-6">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Booking</h3>
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

	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Payment Confirmation</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="row">
			                    <div class="col-md-6">
			                        <strong>Account Name of Sender</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	{{ $data->account_name_of_sender }}
			                        </p>
			                    </div>
			                </div>
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Account Number of Sender</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	{{ $data->account_number_of_sender }}
			                        </p>
			                    </div>
			                </div>
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Bank Name of Sender</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	{{ $data->bank_name_of_sender }}
			                        </p>
			                    </div>
			                </div>
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Transfer Date</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	{!! date('d F Y', strtotime($data->transfer_date)); !!}
			                        </p>
			                    </div>
			                </div>
							<div class="row">
			                    <div class="col-md-6">
			                        <strong>Proof Image</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	<img src="{{ asset('storage/'.$data->file->path) }}" class="img-thumbnail" style="min-height: 300px; object-fit: cover;">
			                        </p>
			                    </div>
			                </div>
			            </div>
			            <div class="col-md-6">
			            	<div class="row">
			                    <div class="col-md-6">
			                        <strong>Account Name of Sender</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	{{ $data->bank->owner }}
			                        </p>
			                    </div>
			                </div>
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Account Number of Receiver</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	{{ $data->bank->number }}
			                        </p>
			                    </div>
			                </div>
			            	<div class="row">
			                    <div class="col-md-6">
			                        <strong>Bank Name of Receiver</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           	{{ $data->bank->name }}
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
											<span class="label label-warning">Waiting Verification</span>
										@elseif( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_VERIFIED )
											<span class="label label-primary">{{ $data->status_payment }}</span>
										@else
											<span class="label label-default">has not made a payment yet</span>
										@endif
			                        </p>
			                    </div>
			                </div>
			            </div>
			        </div>
				</div>
				@if ( $data->status_payment == \App\Models\Transaction::STATUS_PAYMENT_PENDING )
					<div class="box-footer">
						<button id="btnVerify" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Approve</button>
						<button id="btnReject" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Reject</button>
					</div>
				@endif
			</div>
		</div>
	</div>

	<!-- Modal Approve -->
    <div class="modal fade" tabindex="-1" role="dialog" id="verifyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formVerify">
                	<input type="hidden" id="verify_id" name="verify_id" value="{{ $data->id }}">
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

    <!-- Modal Reject -->
    <div class="modal fade" tabindex="-1" role="dialog" id="rejectModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formReject">
                	<input type="hidden" id="reject_id" name="reject_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Transaction Reject</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you reject this transaction ?</p>
                        <textarea name="note" class="form-control" placeholder="Note"></textarea>
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

	        $('#btnVerify').click(function () {
	        	$('#formVerify button[type=submit]').button('reset');
	        	$('#verifyModal').modal('show');
	        });

	        $('#formVerify').submit(function (event) {
                event.preventDefault();
                $('#formVerify button[type=submit]').button('loading');
                $('#formVerify div.form-group').removeClass('has-error');
                $('#formVerify .help-block').empty();

                var _data = $("#formVerify").serialize();
                $.ajax({
                    url: "{{ route('payment_confirmation.verify') }}",
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

	                        $('#verifyModal').modal('hide');
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
                        
                        $('#formVerify button[type=submit]').button('reset');
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
                        $('#formVerify button[type=submit]').button('reset');
                    }
                });
            });

            $('#btnReject').click(function () {
	        	$('#rejectModal').modal('show');
	        });

	        $('#formReject').submit(function (event) {
                event.preventDefault();
                $('#formReject button[type=submit]').button('loading');
                $('#formReject div.form-group').removeClass('has-error');
                $('#formReject .help-block').empty();

                var _data = $("#formReject").serialize();
                $.ajax({
                    url: "{{ route('payment_confirmation.reject') }}",
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

	                        $('#rejectModal').modal('hide');
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
                        
                        $('#formReject button[type=submit]').button('reset');
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
                        $('#formReject button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection