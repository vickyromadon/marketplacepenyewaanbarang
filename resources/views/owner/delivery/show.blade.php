@extends('layouts.owner')

@section('header')
	<h1>
		Delivery
		<small>Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('owner.delivery.index') }}">Delivery</a></li>
		<li class="active">Detail Delivery</li>
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
                               <a class="btn btn-xs btn-info" href="{{ route('owner.product.show', ['id' => $data->transaction->booking->product->id ]) }}" target="_blank">{{ $data->transaction->booking->product->name }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <strong>History Rental</strong>
                        </div>
                        <div class="col-md-10">
                            <p>
                                <a class="btn btn-xs btn-danger" href="{{ route('owner.booking.show', ['id' => $data->transaction->booking->id]) }}" target="_blank">Detail Booking</a> &nbsp;
                               <a class="btn btn-xs btn-primary" href="{{ route('owner.transaction.index') }}/{{$data->transaction_id}}" target="_blank">Detail Transaction</a> &nbsp;
                               <a class="btn btn-xs btn-success" href="{{ route('owner.payment_confirmation.index') }}/{{$data->transaction_id}}" target="_blank">Detail Payment Confirmation</a>
                               
                            </p>
                        </div>
                    </div>
	                <div class="row">
	                    <div class="col-md-2">
	                        <strong>Status</strong>
	                    </div>
	                    <div class="col-md-10">
	                        <p>
                                @if( $data->status == \App\Models\Delivery::STATUS_PENDING )
                                    <span class="label label-warning">waiting delivery</span>    
                                @elseif( $data->status == \App\Models\Delivery::STATUS_DELIVERED )
                                    <span class="label label-info">product on the way</span>
                                @else
                                    <span class="label label-success">product received</span>
                                @endif
	                        </p>
	                    </div>
	                </div>
			    </div>
			   	@if ( $data->status == \App\Models\Delivery::STATUS_PENDING )
			   		 <div class="box-footer">
				    	<button id="btnDelivery" class="btn btn-primary pull-right"><i class="fa fa-truck"></i> Delivery</button>
				    </div>	
			   	@endif
	        </div>
        </div>
    </div>

    <!-- add and edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="deliveryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formDelivery" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Delivery Date</label>
                                
                                <div class="col-sm-9">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" name="delivery_date" id="delivery_date" placeholder="Delivery Date" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Arrive Date</label>
                                
                                <div class="col-sm-9">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" name="arrive_date" id="arrive_date" placeholder="Arrive Date" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    Proof Delivery
                                </label>
                                                            
                                <div class="fileinput fileinput-new col-sm-9" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img id="img-upload">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Select Image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" id="proof_delivery" name="proof_delivery" accept="image/x-png,image/jpeg">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
                                            Remove
                                        </a>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <hr>
                            
                            <center>
                                <h3>Confirmation Form for Reverison Product</h3>
                            </center>

                            <hr>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $profile->name }}">
                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Phone</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="{{ $profile->phone }}">
                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Address</label>

                                <div class="col-sm-9">
                                    <textarea name="address" id="address" class="form-control" placeholder="Address">{{ $profile->address }}</textarea>
                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> 
                            Back
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
@endsection

@section('js')
	<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
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

	        // Add
            $('#btnDelivery').click(function () {
                $('#formDelivery')[0].reset();
                $('#formDelivery button[type=submit]').button('reset');
                $('#formDelivery .modal-title').text("Delivery");
                $('#formDelivery div.form-group').removeClass('has-error');
                $('#formDelivery .help-block').empty();
                $('#formDelivery #img-upload').attr('src', 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image');

                $('#formDelivery input[name="_method"]').remove();

                var data = $('#formDelivery').serializeArray();
                $.each(data, function(key, value){
                    $("#formDelivery input[name='" + data[key].name + "']").parent().find('.help-block').hide();
                });

                $('#deliveryModal').modal('show');
            });

            $('#formDelivery').submit(function (event) {
                event.preventDefault();
                $('#formDelivery button[type=submit]').button('loading');
                $('#formDelivery div.form-group').removeClass('has-error');
                $('#formDelivery .help-block').empty();

                var _data = $("#formDelivery").serialize();

                var formData = new FormData($("#formDelivery")[0]);

                $.ajax({
                    url: '{{ route("owner.delivery.delivery") }}',
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

                            $('#deliveryModal').modal('hide');
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
                        $('#formDelivery button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formDelivery').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formDelivery input[name='" + data[key].name + "']").length ? $("#formDelivery input[name='" + data[key].name + "']") : $("#formDelivery textarea[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['proof_delivery'] != undefined){
                                $("#formDelivery input[name='proof_delivery']").parent().parent().parent().find('.help-block').text(error['proof_delivery']);
                                $("#formDelivery input[name='proof_delivery']").parent().parent().parent().find('.help-block').show();
                                $("#formDelivery input[name='proof_delivery']").parent().parent().parent().parent().addClass('has-error');
                            }
                        }
                        else if (response.status === 400) {
                            // Bad Client Request
                            toastr.error(response.responseJSON.message);
                        }
                        else if (response.status === 413) {
                            toastr.error("File size too large.");
                        }
                        else {
                            toastr.error("Whoops, looks like something went wrong. Please try again later.");
                        }
                        $('#formDelivery button[type=submit]').button('reset');
                    }
                });
            });

            //Date picker
            $('#delivery_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                startDate: '+0d',
                endDate: '{{ ($data->transaction->booking->start_rent) }}',
            });

            //Date picker
            $('#arrive_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                startDate: '+0d',
                endDate: '{{ ($data->transaction->booking->start_rent) }}',
            });
        });
    </script>
@endsection