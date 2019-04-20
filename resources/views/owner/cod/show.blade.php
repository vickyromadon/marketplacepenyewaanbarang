@extends('layouts.owner')

@section('header')
	<h1>
		COD
		<small>Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('owner.cod.index') }}">COD</a></li>
		<li class="active">Detail COD</li>
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
			                        <strong>Status</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           @if( $data->status == \App\Models\Transaction::STATUS_PENDING )
											<span class="label label-default">{{ $data->status }}</span>
										@elseif( $data->status == \App\Models\Transaction::STATUS_APPROVED )
											<span class="label label-success">finished</span>
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

			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Member Name</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ $data->booking->user->name }} <a href="#" id="btnContact" class="label label-info">Detail Contact</a>
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
			                           {{ number_format($data->price) }}
			                        </p>
			                    </div>
			                </div>
			                
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Security Deposite</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ number_format($data->deposite) }}
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
			                        <strong>Quantity</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ $data->booking->quantity }}
			                        </p>
			                    </div>
			                </div>
			                
			                <div class="row">
			                    <div class="col-md-6">
			                        <strong>Grand Total</strong>
			                    </div>
			                    <div class="col-md-6">
			                        <p>
			                           {{ number_format($data->grand_total) }}
			                        </p>
			                    </div>
			                </div>
						</div>
		        	</div>
		        </div>
		        <div class="box-footer">
		        	@if ( $data->status == \App\Models\Transaction::STATUS_PENDING )
		        		<button id="btnVerify" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Verify</button>
		        		<button id="btnReject" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Reject</button>
		        	@elseif( $data->status == \App\Models\Transaction::STATUS_VERIFIED )
		        		<button id="btnCancel" class="btn btn-warning pull-right"><i class="fa fa-close"></i> Cancel</button>
		        	@else
		        		&nbsp;
		        	@endif
		        </div>
		    </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="box box-danger" style="overflow-y: scroll; height: 200px;">
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
			<div class="box box-danger" style="overflow-y: scroll; height: 200px;">
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

	<!-- Modal verify -->
    <div class="modal fade" tabindex="-1" role="dialog" id="verifyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formVerify">
                	<input type="hidden" id="verify_id" name="verify_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">COD Verify</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you verify this COD ?</p>
						
						<textarea name="note" class="form-control" placeholder="Note" required></textarea>
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
                        <h4 class="modal-title">COD Reject</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you reject this COD ?</p>
                        <textarea name="note" class="form-control" placeholder="Note" required></textarea>
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

    <!-- Modal Cancel -->
    <div class="modal fade" tabindex="-1" role="dialog" id="cancelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formCancel">
                	<input type="hidden" id="cancel_id" name="cancel_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">COD Cancel</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you cancel this COD ?</p>
                        <textarea name="note" class="form-control" placeholder="Note" required></textarea>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="contactModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Detail Contact Member</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Name</strong>
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
                                {{ $data->booking->user->phone }}
                            </p>
                        </div>
                    </div>
                </div>
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

	        $('#btnContact').click(function(event) {
                $('#contactModal').modal('show');              
            });

	        $('#btnCancel').click(function () {
	        	$('#formCancel button[type=submit]').button('reset');
	        	$('#cancelModal').modal('show');
	        });

	        $('#formCancel').submit(function (event) {
                event.preventDefault();
                $('#formCancel button[type=submit]').button('loading');
                $('#formCancel div.form-group').removeClass('has-error');
                $('#formCancel .help-block').empty();

                var _data = $("#formCancel").serialize();
                $.ajax({
                    url: "{{ route('owner.cod.cancel') }}",
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

	                        $('#cancelModal').modal('hide');
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
                        
                        $('#formCancel button[type=submit]').button('reset');
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
                        $('#formCancel button[type=submit]').button('reset');
                    }
                });
            });

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
                    url: "{{ route('owner.cod.verify') }}",
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
	        	$('#formReject button[type=submit]').button('reset');
	        	$('#rejectModal').modal('show');
	        });

	        $('#formReject').submit(function (event) {
                event.preventDefault();
                $('#formReject button[type=submit]').button('loading');
                $('#formReject div.form-group').removeClass('has-error');
                $('#formReject .help-block').empty();

                var _data = $("#formReject").serialize();
                $.ajax({
                    url: "{{ route('owner.cod.reject') }}",
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