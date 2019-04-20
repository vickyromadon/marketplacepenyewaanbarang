@extends('layouts.owner')

@section('header')
	<h1>
		Reversion
		<small>Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('owner.reversion.index') }}">Reversion</a></li>
		<li class="active">Detail Reversion</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Recipient</h3>
		        </div>

		        <div class="box-body">
        			<div class="row">
	                    <div class="col-md-2">
	                        <strong>Name</strong>
	                    </div>
	                    <div class="col-md-10">
	                        <p>
	                           {{ $data->name }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-2">
	                        <strong>Phone</strong>
	                    </div>
	                    <div class="col-md-10">
	                        <p>
	                           {{ $data->phone }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-2">
	                        <strong>Address</strong>
	                    </div>
	                    <div class="col-md-10">
	                        <p>
	                           {{ $data->address }}
	                        </p>
	                    </div>
	                </div>
					<div class="row">
                        <div class="col-md-2">
                            <strong>End Delivery Date</strong>
                        </div>
                        <div class="col-md-10">
                            <p>
                                @if ( $data->delivery->transaction->booking->end_rent != null )
                                    {!! date('d F Y', strtotime($data->delivery->transaction->booking->end_rent)); !!}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
	                <div class="row">
                        <div class="col-md-2">
                            <strong>Delivery Date</strong>
                        </div>
                        <div class="col-md-10">
                            <p>
                                @if ( $data->delivery_date != null )
                                    {!! date('d F Y', strtotime($data->delivery_date)); !!}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <strong>Arrive Date</strong>
                        </div>
                        <div class="col-md-10">
                            <p>
                               @if ( $data->arrive_date != null )
                                    {!! date('d F Y', strtotime($data->arrive_date)); !!}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <strong>Product Name</strong>
                        </div>
                        <div class="col-md-10">
                            <p>
                               <a class="btn btn-xs btn-warning" href="{{ route('owner.product.show', ['id' => $data->delivery->transaction->booking->product->id ]) }}" target="_blank">{{ $data->delivery->transaction->booking->product->name }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <strong>History Rental</strong>
                        </div>
                        <div class="col-md-10">
                            <p>
                                <a class="btn btn-xs btn-danger" href="{{ route('owner.booking.show', ['id' => $data->delivery->transaction->booking->id]) }}" target="_blank">Detail Booking</a> &nbsp;
                               <a class="btn btn-xs btn-primary" href="{{ route('owner.transaction.index') }}/{{$data->delivery->transaction_id}}" target="_blank">Detail Transaction</a> &nbsp;
                               <a class="btn btn-xs btn-success" href="{{ route('owner.payment_confirmation.index') }}/{{$data->delivery->transaction_id}}" target="_blank">Detail Payment Confirmation</a>
                               
                            </p>
                        </div>
                    </div>
	                <div class="row">
	                    <div class="col-md-2">
	                        <strong>Status</strong>
	                    </div>
	                    <div class="col-md-10">
	                        <p>
	                           @if( $data->status == \App\Models\Reversion::STATUS_EMPTY )
                                    <span class="label label-default">waiting for reversion</span>
                                @elseif( $data->status == \App\Models\Reversion::STATUS_PENDING )
                                    <span class="label label-warning">please product delivery</span>
                                @elseif( $data->status == \App\Models\Reversion::STATUS_DELIVERED )
                                    <span class="label label-info">waiting arrived</span>
                                @else
                                    <span class="label label-success">product received</span>
                                @endif
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-2">
	                        <strong>Proof Reversion</strong>
	                    </div>
	                    <div class="col-md-10">
	                        <p>
	                           @if ( $data->file != null )
	                           		<img src="{{ asset('storage/'.$data->file->path) }}" class="img-thumbnail" style="height: 300px; width: 300px; object-fit: cover;">
	                           	@else
	                           		-
	                           	@endif
	                        </p>
	                    </div>
	                </div>
			    </div>
		   		<div class="box-footer">
			   		@if ( $data->status == \App\Models\Reversion::STATUS_DELIVERED )
				    	<button id="btnArrived" class="btn btn-primary pull-right"> Arrive</button>
			   		@endif
			   		@if( $data->delivery->transaction->refund == null && $data->status == \App\Models\Reversion::STATUS_ARRIVED )	
			   			<button id="btnRefund" class="btn btn-success pull-right"> Comfirmation Refund</button>
			   		@endif
			    </div>
	        </div>
        </div>
    </div>

    <!-- Modal Arrived -->
    <div class="modal fade" tabindex="-1" role="dialog" id="arrivedModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formArrived">
                	<input type="hidden" id="arrived_id" name="arrived_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Reversion Arrived</h4>
                    </div>

                    <div class="modal-body">
                        <p>Would you arrived this Reversion ?</p>
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

    <!-- Modal Refund -->
    <div class="modal fade" tabindex="-1" role="dialog" id="refundModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formRefund">
                	<input type="hidden" id="transaction_id" name="transaction_id" value="{{ $data->delivery->transaction->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Refund Request</h4>
                    </div>

                    <div class="modal-body">
                        <p>Do You Want To Refund?</p>
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

	        $('#btnRefund').click(function () {
	        	$('#formRefund button[type=submit]').button('reset');
	        	$('#refundModal').modal('show');
	        });

	        $('#formRefund').submit(function (event) {
                event.preventDefault();
                $('#formRefund button[type=submit]').button('loading');
                $('#formRefund div.form-group').removeClass('has-error');
                $('#formRefund .help-block').empty();

                var _data = $("#formRefund").serialize();
                $.ajax({
                    url: "{{ route('owner.reversion.refund') }}",
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
                                location.href = "/owner/refund";
                            }, 2000);s

	                        $('#refundModal').modal('hide');
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
                        
                        $('#formRefund button[type=submit]').button('reset');
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
                        $('#formRefund button[type=submit]').button('reset');
                    }
                });
            });

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
                    url: "{{ route('owner.reversion.arrive') }}",
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