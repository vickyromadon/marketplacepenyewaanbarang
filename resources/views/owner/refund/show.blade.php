@extends('layouts.owner')

@section('header')
	<h1>
		Refund
		<small>Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('owner.refund.index') }}">Refund</a></li>
		<li class="active">Detail Refund</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-4">
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Contact Member</h3>
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
	                        <strong>Phone</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->transaction->booking->user->phone }}
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
		        </div>
		    </div>
		</div>

		<div class="col-md-4">
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Transaction</h3>
		        </div>
		        <div class="box-body">
        			<div class="row">
	                    <div class="col-md-6">
	                        <strong>Price</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->transaction->price }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Rental Time</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->transaction->total_periode }} {{ $data->transaction->time_periode }} 
	                        </p>
	                    </div>
	                </div>
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
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Grand Total</strong>
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
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Product</h3>
		        </div>
		        <div class="box-body">
        			<div class="row">
	                    <div class="col-md-6">
	                        <strong>Product Name</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->transaction->booking->product->name }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Time Periode</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           Per {{ $data->transaction->booking->product->time_periode }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                        <strong>Price</strong>
	                    </div>
	                    <div class="col-md-6">
	                        <p>
	                           {{ $data->transaction->booking->product->price }}
	                        </p>
	                    </div>
	                </div>
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
			<div class="box box-danger">
		        <div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-navicon"></i> Detail Refund</h3>
		        </div>
		        <div class="box-body">
        			<div class="row">
	                    <div class="col-md-4">
	                        <strong>Price for Owner</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->price_owner != null ? $data->price_owner : '-' }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Price for Member</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->price_member != null ? $data->price_member : '-' }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Ammercement</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->ammercement != null ? $data->ammercement : '-' }}
	                        </p>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4">
	                        <strong>Note</strong>
	                    </div>
	                    <div class="col-md-8">
	                        <p>
	                           {{ $data->note != null ? $data->note : '-' }}
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
										<span class="label label-warning">please refund</span>
									@elseif( $data->status == \App\Models\Refund::STATUS_VERIFIED )
										<span class="label label-info">waiting verify admin</span>
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
	            	@if ( $data->status == \App\Models\Refund::STATUS_PENDING )
	            		<button id="btnVerify" class="btn btn-primary pull-right">Verify Refund</button>
	            	@endif
	            </div>
	        </div>
	    </div>

	    @if ( $data->status == \App\Models\Refund::STATUS_FINISHED )
			<div class="col-md-6">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Refund be Accepted</h3>
					</div>
					<div class="box-body">
						<center><h3>Rp. {{ $data->grand_total_owner }}</h3></center>
					</div>
				</div>
			</div>
		@endif
	</div>

	<!-- Modal Arrived -->
    <div class="modal fade" tabindex="-1" role="dialog" id="verifyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formVerify">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Verify Refund</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="refund_id" name="refund_id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ammercement</label>
                                
                                <div class="col-sm-9">
                                    <input type="number" id="ammercement" name="ammercement" class="form-control" placeholder="Ammercement" min="0" max="{{ $data->transaction->deposite }}" required>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Note</label>
                                
                                <div class="col-sm-9">
                                    <textarea name="note" id="note" class="form-control" placeholder="Note" required></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
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
                    url: "{{ route('owner.refund.verify') }}",
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
	                            loader : false
	                        });                        	
                        }
                        $('#formVerify button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formVerify').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formVerify input[name='" + data[key].name + "']").length ? $("#formVerify input[name='" + data[key].name + "']") : $("#formVerify textarea[name='" + data[key].name + "']");
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
                        $('#formVerify button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection