@extends('layouts.app')

@section('content')
	<div class="single-page main-grid-border">
		<div class="container">
			<ol class="breadcrumb" style="margin-bottom: 5px;">
				<li><a href="{{ route('member.index') }}">Home</a></li>
				<li><a href="{{ route('member.main_categories') }}">Kategori Utama</a></li>
				<li class="active">
					<a href="{{ route('member.category.index', ['id' => $data->sub_category->id]) }}">
						{{ $data->sub_category->name }}
					</a>
				</li>
				<li class="active">{{ $data->name }}</li>
			</ol>
			<div class="product-desc">
				<div class="col-md-7 product-view">
					<h2>{{ $data->name }}</h2>
					<p>
						<i class="fa fa-clock-o"></i>
						<b>Ditambahkan Pada : </b> {{\Carbon\Carbon::parse($data->created_at)->toDayDateTimeString()}}
					</p>
					<p>
						<i class="fa fa-user"></i>
						<b>Pemilik : </b> <a href="{{ route('member.product.owner', ['id' => $data->user->id]) }}">{{ $data->user->name }}</a>
					</p>
					<div class="flexslider">
						<ul class="slides">
							<li data-thumb="{{ asset('storage/'.$data->file->path) }}">
								<img src="{{ asset('storage/'.$data->file->path) }}" style="width: 100%; height: 400px;">
							</li>

							@foreach ($data->albums as $album)
								<li data-thumb="{{ asset('storage/'.$album->file->path) }}">
									<img src="{{ asset('storage/'.$album->file->path) }}" style="width: 100%; height: 400px;">
								</li>
							@endforeach
						</ul>
					</div>
					<div class="product-details">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#home">Deskripsi</a></li>
							<li><a data-toggle="tab" href="#terms_and_conditions">Syarat dan Ketentuan</a></li>
							<li><a data-toggle="tab" href="#menu1">Ulasan dan Rating</a></li>
						</ul>
						<div class="tab-content">
							<div id="home" class="tab-pane fade in active">
								{!! $data->description !!}
							</div>
							<div id="terms_and_conditions" class="tab-pane fade">
								{!! $data->terms_and_conditions !!}
							</div>
							<div id="menu1" class="tab-pane fade">
								@if ( count($data->ratings) != 0 )
									@foreach( $data->ratings as $rating )
										<div class="row">
											<div class="col-sm-2">
												@if( $rating->user->file != null )
													<img src="{{ asset('storage/'.$rating->user->file->path) }}" class="img-thumbnail" style="height: 100px; width: 100px;">
												@else
													<img src="{{ asset('images/avatar_default.png') }}" class="img-thumbnail" style="height: 100px; width: 100px;">
												@endif
												
												
											</div>
											<div class="col-sm-10">
												<div class="row">
													<div class="col-sm-2"><b>Nama</b></div>
													<div class="col-sm-10">{{ $rating->user->name }}</div>
												</div>
												<div class="row">
													<div class="col-sm-2"><b>Email</b></div>
													<div class="col-sm-10">{{ $rating->user->email }}</div>
												</div>
												<div class="row">
													<div class="col-sm-2"><b>Rating</b></div>
													<div class="col-sm-10">
														<div style="padding: 0;" class="rateYo" data-rating="{{ $rating->rate }}"></div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-2"><b>Ulasan</b></div>
													<div class="col-sm-10">{{ $rating->note }}</div>
												</div>
											</div>
										</div>
										<hr>
									@endforeach
								@else
									<h3>Review / Rating Empty</h3>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5 product-details-grid">
					<div class="item-price">
						<div class="condition">
							<p class="p-price">Harga</p>
							<h5 style="color: gold; font-weight: bold; font-size: 18px;">IDR. {{ number_format($data->price) }}</h5>
							<div class="clearfix"></div>
						</div>
						<div class="condition">
							<p class="p-price">Jangka waktu</p>
							<h5>Per {{ $data->time_periode }}</h5>
							<div class="clearfix"></div>
						</div>
						<div class="condition">
							<p class="p-price">Uang Jaminan</p>
							<h5>{{ number_format($data->deposite) }}</h5>
							<div class="clearfix"></div>
						</div>
						<div class="condition">
							<p class="p-price">Persediaan</p>
							<h5>{{ $data->quantity }}</h5>
							<div class="clearfix"></div>
						</div>
						<div class="itemtype">
							<p class="p-price">Dilihat</p>
							<h5>{{ $data->view }}</h5>
							<div class="clearfix"></div>
						</div>

					</div>
					
					@if ( Auth::user() )
						<div class="divRent">
							<div class="col-md-12" style="padding: 0px 5px 0px 0px;">
								@if( $data->quantity > 0 )
									<button class="btn btn-info btnRent" id="btnBook"><i class="fa fa-cart-plus"></i> Memesan</button>
								@else
									<button class="btn btn-warning btnRent disabled"><i class="fa fa-close"></i> Persediaan Produk Kosong</button>
								@endif
							</div>
						</div>
					@endif

					<br><br>
					
					<div class="item-location" style="margin-top: 10px;">
						<h4 class="text-center">Peta Lokasi Produk</h4>
						<p> <br>
							<b>Lokasi : </b>
							{{ $data->location->title }}
						</p> <br>
						<div id="map-canvas"></div>
					</div>

					@if ( Auth::user() )
						<div class="divRent">
							<div class="col-md-12" style="padding: 0px 0px 0px 5px;">
								<button class="btn btn-danger btnRent" id="btnReport"><i class="fa fa-exclamation"></i> Laporkan</button>
							</div>
						</div>
					@endif
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>

	@if ( Auth::user() )
		<!-- report -->
		<div class="modal modal-danger fade" tabindex="-1" role="dialog" id="reportModal">
			<div class="modal-dialog">
				<form action="#" method="post" id="formReport">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Laporkan Produk</h4>
						</div>
						<div class="modal-body">
							@csrf
							<input type="hidden" id="id_user" name="id_user" value="{{ Auth::user()->id }}">
							<input type="hidden" id="id_product" name="id_product" value="{{ $data->id }}">
							<div class="form-group">
								<div class="radio">
									<label>
										<input type="radio" name="content" id="optionReport1" value="option1">
										Produk menunjukkan penipuan
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="content" id="optionReport2" value="option2">
										Produk tidak layak diiklankan
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="content" id="optionReport3" value="option3">
										Produk ini duplikat dengan produk lain
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="content" id="optionReport4" value="option4">
										Informasi produk palsu
									</label>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
	                            Tutup
	                        </button>
	                        <button type="submit" class="btn btn-outline" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Simpan
	                        </button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- book -->
	    <div class="modal modal-info fade" tabindex="-1" role="dialog" id="bookModal">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <form action="#" method="post" id="formBook">
	                	@csrf
	                	<input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
	                	<input type="hidden" id="product_id" name="product_id" value="{{ $data->id }}">
	                    <div class="modal-header">
	                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">&times;</span>
	                        </button>
	                        <h4 class="modal-title">Pemesanan Produk</h4>
	                    </div>

	                    <div class="modal-body">
	                        <p id="del-success">Anda yakin ingin memesan produk ini ?</p>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
	                            Tidak
	                        </button>
	                        <button type="submit" class="btn btn-outline" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Ya
	                        </button>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
	@endif
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('rentoncome/css/flexslider.css') }}" type="text/css" media="screen">

    <style>
        #map-canvas {
            height: 300px;
            width: 100%;
            margin-bottom: 10px;
        }

        .item-location h4{
        	margin: 10px 0px;
        }

        .tab-content{
			border:1px solid #d3d3d3;
			padding: 10px;
		}

		.divRent{
			padding-top: 15px;
			margin-left: 65px;
		}

		.btnRent{
			width: 100%;
			color: black;
			font-weight: bold;
		}
    </style>
@endsection

@section('js')
  	<script defer src="{{ asset('rentoncome/js/jquery.flexslider.js') }}"></script>
	
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

	        // report
            $('#btnReport').click(function () {
            	$('#formReport button[type=submit]').button('reset');
                $('#reportModal').modal('show');
            });

            $('#formReport').submit(function (event) {
                event.preventDefault();
                $('#formReport button[type=submit]').button('loading');
                $('#formReport div.form-group').removeClass('has-error');
                $('#formReport .help-block').empty();

                var _data = $("#formReport").serialize();
                $.ajax({
                    url: "{{ route('member.report.store') }}",
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
                        $('#reportModal').modal('hide');
                        $('#formReport button[type=submit]').button('reset');
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
                        $('#formReport button[type=submit]').button('reset');
                    }
                });
            });

            // booking
            $('#btnBook').click(function () {
            	$('#formBook button[type=submit]').button('reset');
                $('#bookModal').modal('show');
            });

            $('#formBook').submit(function (event) {
                event.preventDefault();
                $('#formBook button[type=submit]').button('loading');
                $('#formBook div.form-group').removeClass('has-error');
                $('#formBook .help-block').empty();

                var _data = $("#formBook").serialize();
                $.ajax({
                    url: "{{ route('member.booking.store') }}",
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
                        $('#bookModal').modal('hide');
                        $('#formBook button[type=submit]').button('reset');
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
                        $('#formBook button[type=submit]').button('reset');
                    }
                });
            });
	    });
	</script>

	<script>
		$(window).load(function() {
			$('.flexslider').flexslider({
				animation: "slide",
				controlNav: "thumbnails"
			});
		});
	</script>

	<script>
		function initMap() {
			var latitude    = {{ $data->location->latitude }};
            var longitude   = {{ $data->location->longitude }};
            var posisi = {lat: latitude, lng: longitude};
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 15,
                center: posisi
            });

            var contentString = '<div><b>{{ $data->name }}</b>';
            var info = new google.maps.InfoWindow({
                content: contentString
            });
        	
        	var image = 'https://png.icons8.com/ios-glyphs/50/e74c3c/find-hospital.png';
            var marker = new google.maps.Marker({
                position: posisi,
                title:'Locations Office',
                map: map,
                icon: image, 
            });

            google.maps.event.addListener(marker,'click',function(e){
                info.open(map, marker);   
            });
		}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3gN0AFseoGdJj7jV-gClr6Hsu9VVYsE0&libraries=places&callback=initMap"></script>

	<script type="text/javascript">
        $(".rateYo").each( function() {
            var rating = $(this).attr("data-rating");
            $(this).rateYo(
                {
                    ratedFill: "gold",
                    starWidth: "20px",
                    rating: rating,
                    fullStar: true,
                    readOnly: true
                }
            );
        });
    </script>
@endsection