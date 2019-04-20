@extends('layouts.app')

@section('content')
	<div class="container">
		<ol class="breadcrumb" style="margin-bottom: 5px;">
			<li><a href="{{ route('member.index') }}">Home</a></li>
			<li><a href="{{ route('member.history.index', ['id' => Auth::user()->id ]) }}">Pemesanan</a></li>
			<li class="active">Rincian Pemesanan</li>
		</ol>

		<h2 class="head text-center">Rincian Pemesanan</h2>

		<div class="row">
			<div class="col-md-4">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Pemesanan</h3></center>
					</div>
					<div class="box-body box-profile">
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b>Nama Produk</b> <a class="pull-right">{{ $data->product->name }}</a>
							</li>
							<li class="list-group-item">
								<b>Harga</b> <a class="pull-right">IDR. {{ number_format($data->product->price) }} / {{ $data->product->time_periode }}</a>
							</li>
							<li class="list-group-item">
								<b>Uang Jaminan</b> <a class="pull-right">IDR. {{ number_format($data->product->deposite) }} </a>
							</li>
						</ul>
					</div>
					<div class="box-footer">
						<a href="{{ route('member.product.index', ['data' => $data->product->id]) }}" class="btn btn-default btn-block"><b>Lihat Produk</b></a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Pemilik</h3></center>
					</div>
					<div class="box-body box-profile">
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b>Nama</b> <a class="pull-right">{{ $data->product->user->name }}</a>
							</li>
							<li class="list-group-item">
								<b>Email</b> <a class="pull-right">{{ $data->product->user->email }}</a>
							</li>
							<li class="list-group-item">
								<b>Phone</b> <a class="pull-right">{{ $data->product->user->phone != null ? $data->product->user->phone : '-' }}</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-success">
					<div class="box-header with-border">
						<center><h3 class="box-title">Rincian Pemesanan</h3></center>
					</div>
					<div class="box-body box-profile">
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item">
								<b>Kode Pemesanan</b> <a class="pull-right">{{ $data->code }}</a>
							</li>
							<li class="list-group-item">
								<b>Tanggal Pemesanan</b> <a class="pull-right">{!! date('d F Y', strtotime($data->created_at)); !!}</a>
							</li>
							<li class="list-group-item">
								<b>Mulai Tanggal Sewa</b> 
								<a class="pull-right">
									@if( $data->start_rent != null )
										{!! date('d F Y', strtotime($data->start_rent)); !!}
									@else
										-
									@endif
								</a>
							</li>
							<li class="list-group-item">
								<b>Akhiri Tanggal Sewa</b>
								<a class="pull-right">
									@if( $data->end_rent != null )
										{!! date('d F Y', strtotime($data->end_rent)); !!}
									@else
										-
									@endif
								</a>
							</li>
							<li class="list-group-item">
								<b>Status Pemesanan</b> 
								<a class="pull-right">
									@if ( $data->status == App\Models\Booking::STATUS_EMPTY )
                                        <span class="label label-default status">Silahkan Tentukan Tanggal</span>
                                    @elseif ( $data->status == App\Models\Booking::STATUS_CANCELED )
                                        <span class="label label-warning status">Dibatalkan</span>
                                    @elseif ( $data->status == App\Models\Booking::STATUS_REJECTED )
                                        <span class="label label-danger status">Ditolak</span>
                                    @elseif ( $data->status == App\Models\Booking::STATUS_PENDING )
                                        <span class="label label-info status">Menunggu Persetujuan</span>
                                    @else
                                        <span class="label label-success status">Silakan Pilih Metode Pembayaran</span>
                                    @endif
								</a>
							</li>
						</ul>
					</div>
					<div class="box-footer">
						@if ( $data->status == App\Models\Booking::STATUS_EMPTY )
							<button id="btnRent" class="btn btn-success btn-block"><b>Permintaan Sewa kepada Pemilik </b></button>
						@endif

						@if ( $data->status != App\Models\Booking::STATUS_REJECTED )
							@if ( $data->status != App\Models\Booking::STATUS_CANCELED && $data->transaction == null )
								<button id="btnCancel" class="btn btn-danger btn-block"><b>Batalkan Sewa </b></button>
							@endif
						@else
							<b>Alasan : </b> {{ $data->reason }}
						@endif
					</div>
				</div>
			</div>
		</div>
		@if ( $data->status == App\Models\Booking::STATUS_APPROVED && $data->transaction == null )
			<div class="row">
				<div class="col-md-12">
					<button id="btnDetail" class="btn btn-info pull-right"><i class="fa fa-money"></i> Rincian yang harus dibayar</button>
				</div>
			</div>
		@endif
	</div>
	
	<!-- detail -->
    <div class="modal modal-info fade" tabindex="-1" role="dialog" id="detailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Rincian yang harus dibayar</h4>
                </div>

                <div class="modal-body">
                	<table class="tableDetail">
                    	<tr>
                    		<td>Harga</td>
                    		<td>=</td>
                    		<td style="text-align: right;">{{ number_format($data->product->price) }}</td>
                    	</tr>
                    	<tr>
                    		<td>Jangka Waktu / {{ $data->product->time_periode }}</td>
                    		<td>=</td>
                    		<td style="text-align: right;">
                    			@php
                    				$time = 0;
                    				if( $data->product->time_periode == App\Models\Product::TIME_PERIODE_DAY )
                    					$time = 1;
                    				else if( $data->product->time_periode == App\Models\Product::TIME_PERIODE_WEEK )
                    					$time = 7;
                    				else if( $data->product->time_periode == App\Models\Product::TIME_PERIODE_MONTH )
                    					$time = 31;
                    				else 
                    					$time = 365;
                    				
                    				$timePeriode = ceil(abs((strtotime($data->start_rent) - strtotime ($data->end_rent)) / (60*60*24)) / $time);
                    			@endphp
                    			x {{ $timePeriode }}
                    		</td>
                    	</tr>
                    	<tr>
                    		<td>Uang Jaminan</td>
                    		<td>=</td>
                    		<td style="text-align: right;">{{ number_format($data->product->deposite) }}</td>
                    	</tr>
                        <tr>
                            <td>Kuantitas</td>
                            <td>=</td>
                            <td style="text-align: right;">{{ $data->quantity }}</td>
                        </tr>
                    	<tr>
                    		<td>&nbsp;</td>
                    		<td>&nbsp;</td>
                    		<td><hr></td>
                    	</tr>
                    	<tr>
                    		<td>Total keseluruhan</td>
                    		<td>=</td>
                    		<td style="text-align: right;">Rp. 
								{{ number_format( (($data->product->price * $timePeriode) + $data->product->deposite) * $data->quantity) }}
                    		</td>
                    	</tr>
                    </table>
            	</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
                        Batal
                    </button>
                    <a id="btnNextPayment" href="#" class="btn btn-outline">Lanjut Pembayaran</a>
                </div>
            </div>
        </div>
    </div>

    <!-- method payment -->
    <div class="modal modal-primary fade" tabindex="-1" role="dialog" id="methodPaymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formMethodPayment">
                	@csrf
                	<input type="hidden" id="booking_id" name="booking_id" value="{{ $data->id }}">
                    <input type="hidden" name="price" value="{{ $data->product->price }}">
                    <input type="hidden" name="time_periode" value="{{ $data->product->time_periode }}">
                    <input type="hidden" name="total_periode" value="{{ $timePeriode }}">
                    <input type="hidden" name="deposite" value="{{ $data->product->deposite }}">
                    <input type="hidden" name="grand_total" value="{{ (($data->product->price * $timePeriode) + $data->product->deposite) * $data->quantity }}">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Pilih Metode Pembayaran</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Pilih Satu Metode Pembayaran</label>
                                <div class="col-sm-8">
                                    <label class="radio-inline">
                                        <input type="radio" class="icheck" name="optradio" value="cod" required> COD
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" class="icheck" name="optradio" value="rekber" required> REKBER
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-outline" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<!-- cancel -->
    <div class="modal modal-danger fade" tabindex="-1" role="dialog" id="cancelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formCancel">
                	@csrf
                	<input type="hidden" id="booking_id" name="booking_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Pemesanan Dibatalkan</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Anda yakin ingin membatalkan pemesanan produk ini ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-outline" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<!-- rental -->
    <div class="modal modal-success" tabindex="-1" role="dialog" id="rentalModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formRental">
                	@csrf
					<input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <input type="hidden" name="time_periode" id="time_periode" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Produk Rental</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h3 style="padding: 0px;">Periode Waktu Per <u>{{ $data->product->time_periode }}</u></h3><br>
                                </div>
                                <div class="col-sm-4">
                                    <label>Mulai Sewa</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" name="start_date" id="start_date" required placeholder="Mulai Sewa" autocomplete="off">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <label>Tanggal Periode</label>
                                    <div class="input-group date">
                                       <div class="input-group">
                                            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                                <span>
                                                    <i class="fa fa-calendar"></i> Tanggal Periode
                                                </span>
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                        </div>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Kuantitas</label>
                                    <div class="input-group date">
                                        <div class="input-group">
                                            <select name="quantity" id="quantity" class="form-control">
                                                @for( $i=1; $i<=$data->product->quantity; $i++ )
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-outline" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Ya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
	<style>
		.tableDetail{
			margin:10px;
			font-size: 20px;
		}

		.tableDetail tr td{
			padding:0px 20px;
		}

        .daterangepicker .ranges{
            overflow: scroll;
            height: 300px;
        }
	</style>
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

	        // detail
	        $('#btnDetail').click(function () {
                $('#detailModal').modal('show');
            });

            // method payment
	        $('#btnNextPayment').click(function () {
                $('#methodPaymentModal').modal('show');
                $('#detailModal').modal('hide');
            });

            $('#formMethodPayment').submit(function (event) {
                event.preventDefault();
                $('#formMethodPayment button[type=submit]').button('loading');
                $('#formMethodPayment div.form-group').removeClass('has-error');
                $('#formMethodPayment .help-block').empty();

                var _data = $("#formMethodPayment").serialize();
                $.ajax({
                    url: "{{ route('member.transaction.store') }}",
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
                                location.href = "/transaction";
                            }, 2000);

                            $('#methodPaymentModal').modal('hide');
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
                        
                        $('#formMethodPayment button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formMethodPayment').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formMethodPayment input[name='" + data[key].name + "']").length ? $("#formMethodPayment input[name='" + data[key].name + "']") : $("#formMethodPayment select[name='" + data[key].name + "']");
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
                        $('#formMethodPayment button[type=submit]').button('reset');
                    }
                });
            });

	        // cancel
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
                    url: "{{ route('member.history.cancel') }}",
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
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formCancel').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formCancel input[name='" + data[key].name + "']").length ? $("#formCancel input[name='" + data[key].name + "']") : $("#formCancel select[name='" + data[key].name + "']");
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
                        $('#formCancel button[type=submit]').button('reset');
                    }
                });
            });

	        // rental
            $('#btnRent').click(function () {
            	$('#formRental button[type=submit]').button('reset');
                $('#rentalModal').modal('show');
            });

            $('#formRental').submit(function (event) {
                event.preventDefault();
                $('#formRental button[type=submit]').button('loading');
                $('#formRental div.form-group').removeClass('has-error');
                $('#formRental .help-block').empty();

                var _data = $("#formRental").serialize();
                $.ajax({
                    url: "{{ route('member.history.request') }}",
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
                        
                        $('#formRental button[type=submit]').button('reset');
                    },

                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formRental').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formRental input[name='" + data[key].name + "']").length ? $("#formRental input[name='" + data[key].name + "']") : $("#formRental select[name='" + data[key].name + "']");
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
                        $('#formRental button[type=submit]').button('reset');
                    }
                });
            });

            //Date picker
            $('#start_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                startDate: '+1d'
            });

            $('#end_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                startDate: '+1d'
            });

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-red',
                radioClass: 'iradio_square-red',
                increaseArea: '20%' // optional
            });

            //Date range as a button
            $( "#start_date" ).change(function() {
                var mulai = $(this).val();

                if( {{ $time }} == 1){
                    $(function() {
                        var start = moment('"' + mulai + '"', "YYYY-MM-DD");
                        var end = moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'days');

                        function cb(start, end) {
                            $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                            $('#formRental #time_periode').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                        }

                        $('#daterange-btn').daterangepicker({
                            startDate: start,
                            endDate: end,
                            ranges   : {
                              '1 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'days')],
                              '2 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(2, 'days')],
                              '3 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(3, 'days')],
                              '4 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(4, 'days')],
                              '5 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(5, 'days')],
                              '6 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(6, 'days')],
                              '7 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(7, 'days')],
                              '8 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(8, 'days')],
                              '9 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(9, 'days')],
                              '10 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(10, 'days')],
                              '11 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(11, 'days')],
                              '12 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(12, 'days')],
                              '13 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(13, 'days')],
                              '14 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(14, 'days')],
                              '15 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(15, 'days')],
                              '16 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(16, 'days')],
                              '17 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(17, 'days')],
                              '18 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(18, 'days')],
                              '19 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(19, 'days')],
                              '20 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(20, 'days')],
                              '21 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(21, 'days')],
                              '22 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(22, 'days')],
                              '23 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(23, 'days')],
                              '24 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(24, 'days')],
                              '25 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(25, 'days')],
                              '26 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(26, 'days')],
                              '27 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(27, 'days')],
                              '28 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(28, 'days')],
                              '29 Hari'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(29, 'days')],
                            }
                        }, cb);
                        cb(start, end);
                    });
                }
                else if( {{ $time }} == 7 ){
                    $(function() {
                        var start = moment('"' + mulai + '"', "YYYY-MM-DD");
                        var end = moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'weeks');

                        function cb(start, end) {
                            $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                            $('#formRental #time_periode').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                        }

                        $('#daterange-btn').daterangepicker({
                            startDate: start,
                            endDate: end,
                            ranges   : {
                              '1 Minggu'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'weeks')],
                              '2 Minggu'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(2, 'weeks')],
                              '3 Minggu'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(3, 'weeks')],
                            }
                        }, cb);
                        cb(start, end);
                    });    
                }
                else if( {{ $time }} == 31 ){
                    $(function() {
                        var start = moment('"' + mulai + '"', "YYYY-MM-DD");
                        var end = moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'months');

                        function cb(start, end) {
                            $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                            $('#formRental #time_periode').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                        }

                        $('#daterange-btn').daterangepicker({
                            startDate: start,
                            endDate: end,
                            ranges   : {
                              '1 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'months')],
                              '2 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(2, 'months')],
                              '3 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(3, 'months')],
                              '4 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(4, 'months')],
                              '5 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(5, 'months')],
                              '6 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(6, 'months')],
                              '7 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(7, 'months')],
                              '8 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(8, 'months')],
                              '9 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(9, 'months')],
                              '10 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(10, 'months')],
                              '11 Bulan'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(11, 'months')],
                            }
                        }, cb);
                        cb(start, end);
                    });    
                }
                else{
                    $(function() {
                        var start = moment('"' + mulai + '"', "YYYY-MM-DD");
                        var end = moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'years');

                        function cb(start, end) {
                            $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                            $('#formRental #time_periode').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                        }

                        $('#daterange-btn').daterangepicker({
                            startDate: start,
                            endDate: end,
                            ranges   : {
                              '1 Tahun'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(1, 'years')],
                              '2 Tahun'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(2, 'years')],
                              '3 Tahun'   : [moment('"' + mulai + '"', "YYYY-MM-DD"), moment('"' + mulai + '"', "YYYY-MM-DD").add(3, 'years')],
                            }
                        }, cb);
                        cb(start, end);
                    });    
                }
            });
	    });
	</script>
@endsection