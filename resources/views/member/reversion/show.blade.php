@extends('layouts.app')

@section('content')
	<div class="container">
		<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li><a href="{{ route('member.index') }}">Home</a></li>
			<li><a href="{{ route('member.reversion.index', ['id' => Auth::user()->id ]) }}">Pengembalian</a></li>
			<li class="active">Rincian Pengembalian</li>
		</ol>

		<h2 class="head text-center">Rincian Pengembalian</h2>
	
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Penerima</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-2">
		                        <strong>Nama</strong>
		                    </div>
		                    <div class="col-md-10">
		                        <p>
		                           {{ $data->name }}
		                        </p>
		                    </div>
		                </div>

		                <hr>

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

		                <hr>

		                <div class="row">
		                    <div class="col-md-2">
		                        <strong>Alamat</strong>
		                    </div>
		                    <div class="col-md-10">
		                        <p>
		                           {{ $data->address }}
		                        </p>
		                    </div>
		                </div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Pengiriman</h3></center>
					</div>
					<div class="box-body">
						<div class="row">
		                    <div class="col-md-4">
		                        <strong>Tanggal Pengiriman</strong>
		                    </div>
		                    <div class="col-md-8">
		                        <p>
		                           {{ $data->delivery_date != null ? date('d F Y', strtotime($data->delivery_date)) : '-' }}
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
		                           {{ $data->arrive_date != null ? date('d F Y', strtotime($data->arrive_date)) : '-' }}
		                        </p>
		                    </div>
		                </div>

		                <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <strong>Bukti Pengembalian</strong>
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
                                    @if( $data->status == \App\Models\Reversion::STATUS_EMPTY )
                                        <span class="label label-default">menunggu pengembalian</span>
                                    @elseif( $data->status == \App\Models\Reversion::STATUS_PENDING )
                                        <span class="label label-warning">mohon pengiriman produk</span>
                                    @elseif( $data->status == \App\Models\Reversion::STATUS_DELIVERED )
                                        <span class="label label-info">produk sedang di jalan</span>
                                    @else
                                        <span class="label label-success">produk telah diterima</span>
                                    @endif
                                </p>
                            </div>
                        </div>
					</div>
                    <div class="box-footer">
					    @if ( $data->status == \App\Models\Reversion::STATUS_PENDING )
							<button id="btnReversion" class="btn btn-success pull-right">Pengembalian</button>
                        @elseif( $data->status == \App\Models\Reversion::STATUS_EMPTY )
                            <button id="btnRating" class="btn btn-warning pull-right">Rating</button>
                        @else
                            &nbsp;
                        @endif
                    </div>

				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <center><h3 class="box-title">Rincian Sewa</h3></center>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Rincian Produk</strong>
                        </div>
                        <div class="col-md-8">
                            <p>
                                <a href="{{ route('member.product.index', ['id' => $data->delivery->transaction->booking->product->id]) }}" target="_blank">
                                    {{ $data->delivery->transaction->booking->product->name }}
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
                                <a href="{{ route('member.transaction.show', ['id' => $data->delivery->transaction->id]) }}" target="_blank">
                                    {{ $data->delivery->transaction->booking->code }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<!-- reversion modal -->
    <div class="modal modal-primary fade" tabindex="-1" role="dialog" id="reversionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formReversion" enctype="multipart/form-data">
                	@csrf
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
                                <label class="col-sm-3 control-label">Tanggal Pengiriman</label>
                                
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
                                <label class="col-sm-3 control-label">Tanggal Tiba</label>
                                
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
                                    Bukti Pengiriman
                                </label>
                                                            
                                <div class="fileinput fileinput-new col-sm-9" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img id="img-upload">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">Pilih Gambar</span>
                                            <span class="fileinput-exists">Ubah</span>
                                            <input type="file" id="proof_delivery" name="proof_delivery" accept="image/x-png,image/jpeg">
                                        </span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
                                            Hapus
                                        </a>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> 
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-default" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Simpan
                        </button>
                    </div>
                </form>
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
                        <h4 class="modal-title">Rating Produk</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" id="product_id" name="product_id" value="{{ $data->delivery->transaction->booking->product_id }}">
                            <input type="hidden" id="reversion_id" name="reversion_id" value="{{ $data->id }}">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Peringkat</label>
                    
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
                                <label class="col-sm-2 control-label">Catatan</label>
                    
                                <div class="col-sm-10">
                                    <textarea name="note" id="note" class="form-control"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> 
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-warning pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Simpan
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
                    url: "{{ route('member.rating.store') }}",
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

	        // reverison
            $('#btnReversion').click(function () {
                $('#formReversion')[0].reset();
                $('#formReversion button[type=submit]').button('reset');
                $('#formReversion .modal-title').text("Reversion");
                $('#formReversion div.form-group').removeClass('has-error');
                $('#formReversion .help-block').empty();
                $('#formReversion #img-upload').attr('src', 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image');

                $('#formReversion input[name="_method"]').remove();

                var data = $('#formReversion').serializeArray();
                $.each(data, function(key, value){
                    $("#formReversion input[name='" + data[key].name + "']").parent().find('.help-block').hide();
                });

                $('#reversionModal').modal('show');
            });

            $('#formReversion').submit(function (event) {

                event.preventDefault();
                $('#formReversion button[type=submit]').button('loading');
                $('#formReversion div.form-group').removeClass('has-error');
                $('#formReversion .help-block').empty();

                var _data = $("#formReversion").serialize();

                var formData = new FormData($("#formReversion")[0]);

                $.ajax({
                    url: '{{ route("member.reversion.reversion") }}',
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

                            $('#reversionModal').modal('hide');
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
                        $('#formReversion button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formReversion').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formReversion input[name='" + data[key].name + "']").length ? $("#formReversion input[name='" + data[key].name + "']") : $("#formReversion textarea[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['proof_delivery'] != undefined){
                                $("#formReversion input[name='proof_delivery']").parent().parent().parent().find('.help-block').text(error['proof_delivery']);
                                $("#formReversion input[name='proof_delivery']").parent().parent().parent().find('.help-block').show();
                                $("#formReversion input[name='proof_delivery']").parent().parent().parent().parent().addClass('has-error');
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
                        $('#formReversion button[type=submit]').button('reset');
                    }
                });
            });

            //Date picker
            $('#delivery_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                endDate: '+0d',
            });

            //Date picker
            $('#arrive_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                startDate: '+0d',
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