@extends('layouts.owner')

@section('header')
	<h1>
		Booking
		<small>Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('owner.booking.index') }}">Booking</a></li>
		<li class="active">Detail Booking</li>
	</ol>
@endsection

@section('content')
	<div class="box box-danger">
        <div class="box-body">
        	<div class="row">
        		<div class="col-md-12">
            		<div class="col-md-3">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							User Name
						</strong>
						<p class="text-muted">
							{{ $data->user->name }}
						</p>
					</div>
					<div class="col-md-3">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							User Email
						</strong>
						<p class="text-muted">
							{{ $data->user->email }}
						</p>
					</div>
					<div class="col-md-3">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							User Phone
						</strong>
						<p class="text-muted">
							{{ $data->user->phone != null ? $data->user->phone : '-' }}
						</p>
					</div>
					<div class="col-md-3">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							User Address
						</strong>
						<p class="text-muted">
							{{ $data->user->address != null ? $data->user->address : '-' }}
						</p>
					</div>
				</div>
        	</div>
        	<hr>
        	<div class="row">
            	<div class="col-md-12">
            		<div class="col-md-3">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Code Booking
						</strong>
						<p class="text-muted">
							{{ $data->code }}
						</p>
					</div>
					<div class="col-md-2">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Start Rent
						</strong>
						<p class="text-muted">
							{!! date('d F Y', strtotime($data->start_rent)); !!}
						</p>
					</div>
					<div class="col-md-2">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							End Rent
						</strong>
						<p class="text-muted">
							{!! date('d F Y', strtotime($data->end_rent)); !!}
						</p>
					</div>
					<div class="col-md-2">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Quantity
						</strong>
						<p class="text-muted">
							{{ $data->quantity }}
						</p>
					</div>
					<div class="col-md-3">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Status
						</strong>
						<p class="text-muted">
							@if ( $data->status == App\Models\Booking::STATUS_EMPTY )
								<span class="label label-default status">{{ $data->status }}</span>
							@elseif ( $data->status == App\Models\Booking::STATUS_CANCELED )
								<span class="label label-warning status">{{ $data->status }}</span>
							@elseif ( $data->status == App\Models\Booking::STATUS_REJECTED )
								<span class="label label-danger status">{{ $data->status }}</span>
							@elseif ( $data->status == App\Models\Booking::STATUS_PENDING )
								<span class="label label-info status">Waiting Approval</span>
							@else
								<span class="label label-success status">{{ $data->status }}</span>
							@endif
						</p>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
	            <div class="col-md-4">
	                <img src="{{ asset('storage/'.$data->product->file->path) }}" class="img-responsive img-thumbnail" style="height: 300px; width: 100%;">
	            </div>
	            <div class="col-md-8">
            		<div class="col-md-6">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Product Name
						</strong>
						<p class="text-muted">
							<a href="{{ route('owner.product.show', ['id' => $data->product->id]) }}">{{ $data->product->name }}</a>
						</p>
					</div>
					<div class="col-md-6">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Stock Available
						</strong>
						<p class="text-muted">
							{{ $data->product->quantity }}
						</p>
					</div>
				</div>
			</div>
        </div>
        @if ( $data->status == App\Models\Booking::STATUS_PENDING )
        	<div class="box-footer">
	        	<button id="btnReject" class="btn btn-danger pull-left"><i class="fa fa-close"></i> Reject</button>
	        	<button id="btnApprove" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Approve</button>
        	</div>
        @endif
    </div>

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
                        <h4 class="modal-title">Booking Approve</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you approve this booking ?</p>
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
                        <h4 class="modal-title">Booking Reject</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you reject this booking ?</p>
                        <textarea name="reason" id="reason" class="form-control" placeholder="Reason ..." required></textarea>
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
                    url: "{{ route('owner.booking.approve') }}",
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

	                        $('#rentalModal').modal('hide');
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
                    url: "{{ route('owner.booking.reject') }}",
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

	                        $('#rentalModal').modal('hide');
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