@extends('layouts.admin')

@section('header')
	<h1>
		Refund
		<small>Details</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('payment_confirmation.index') }}">Refund</a></li>
		<li class="active">Refund Details</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="box box-warning">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Owner</h3>
		        </div>
		        <div class="box-body">
	        		<div class="row">
	                    <div class="col-md-4">
	                        <strong>Name</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->product->user->name }}
	                        </p>
	                    </div>
	                </div>
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
	        	</div>
	        </div>
	    </div>

	    <div class="col-md-6">
			<div class="box box-warning">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Member</h3>
		        </div>
		        <div class="box-body">
					<div class="row">
	                    <div class="col-md-4">
	                        <strong>Name</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->user->name }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Email</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->user->email }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Phone</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->user->phone }}
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
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Bank Owner</h3>
		        </div>
		        <div class="box-body">
		        	<div class="row">
	                    <div class="col-md-4">
	                        <strong>Name</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
								@if( count($data->transaction->booking->product->user->banks) > 0 )
	                           		{{ $data->transaction->booking->product->user->banks[0]->name }}
	                           	@else
	                           		-
	                           	@endif
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Account Name</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
								@if( count($data->transaction->booking->product->user->banks) > 0 )
	                           		{{ $data->transaction->booking->product->user->banks[0]->owner }}
	                           	@else
	                           		-
	                           	@endif
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Account Number</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
								@if( count($data->transaction->booking->product->user->banks) > 0 )
	                           		{{ $data->transaction->booking->product->user->banks[0]->number }}
	                        	@else
	                           		-
	                           	@endif
	                        </p>
	                    </div>
	                </div>
		        </div>
		    </div>
		</div>

		<div class="col-md-6">
			<div class="box box-warning">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Bank Member</h3>
		        </div>
		        <div class="box-body">
		        	<div class="row">
	                    <div class="col-md-4">
	                        <strong>Name</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->user->banks[0]->name }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Account Name</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->user->banks[0]->owner }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Account Number</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->user->banks[0]->number }}
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
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Refund</h3>
		        </div>
		        <div class="box-body">
		        	<div class="row">
	                    <div class="col-md-4">
	                        <strong>Price Owner</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->price_owner }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Price Member</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->price_member }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Ammercement</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->ammercement }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Grand Total Owner</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->grand_total_owner }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Grand Total Member</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->grand_total_member }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Note</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->note }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Status</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           	@if( $data->status != null )
									@if( $data->status == \App\Models\Refund::STATUS_PENDING )
										<span class="label label-warning">{{ $data->status }}</span>
									@elseif( $data->status == \App\Models\Refund::STATUS_VERIFIED )
										<span class="label label-info">please verify</span>
									@else
										<span class="label label-success">{{ $data->status }}</span>
									@endif
								@else
									-
	                        	@endif
	                        </p>
	                    </div>
	                </div>
		        </div>
		        <div class="box-footer">
		        	@if ( $data->status == \App\Models\Refund::STATUS_VERIFIED )
		        		<button id="btnFinished" class="btn btn-primary pull-right">Finished Refund</button>
		        	@endif
		        </div>
		    </div>
		</div>
	</div>

	<!-- Modal Finished -->
    <div class="modal fade" tabindex="-1" role="dialog" id="finishedModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formFinished">
                	<input type="hidden" name="id" id="id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Refund Finished</h4>
                    </div>

                    <div class="modal-body">
                        <p id="info">Are you sure you want to Finished</p>
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

	        $('#btnFinished').click(function () {
	        	$('#formFinished button[type=submit]').button('reset');
	        	$('#finishedModal').modal('show');
	        });

	        $('#formFinished').submit(function (event) {
                event.preventDefault();
                $('#formFinished button[type=submit]').button('loading');
                $('#formFinished div.form-group').removeClass('has-error');
                $('#formFinished .help-block').empty();

                var _data = $("#formFinished").serialize();
                $.ajax({
                    url: "{{ route('refund.finished') }}",
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

	                        $('#finishedModal').modal('hide');
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
                        
                        $('#formFinished button[type=submit]').button('reset');
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
                        $('#formFinished button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection