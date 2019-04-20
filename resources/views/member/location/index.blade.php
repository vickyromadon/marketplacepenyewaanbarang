@extends('layouts.app')

@section('content')
	<div class="faq">
		<div class="container">
			<h2 class="head text-center">Peta Lokasi Produk</h2>
			<div class="row">
				<div class="col-md-12">
					<div id="map-canvas"></div>
					<br>

					<form action="{{ route('member.location.index') }}" method="post" id="formLocationProduct">
						@csrf
						<input type="hidden" id="latitude" name="latitude" class="form-control">
	                	<input type="hidden" id="longitude" name="longitude" class="form-control">
						
						<div class="row">
							<div class="col-sm-3">
								<input type="number" id="radius" name="radius" class="form-control" placeholder="Masukkan Radius (Km)" required autocomplete="off">
							</div>
							<div class="col-sm-3">
								<select name="category" id="category" class="form-control" required>
									<option value="">-- Pilih Kategori --</option>
									@foreach ($categories as $category)
			                            <option value="{{ $category->id }}">{{ $category->name }}</option>
			                        @endforeach
								</select>
							</div>
							<div class="col-sm-3">
								<select name="sub_category" id="sub_category" class="form-control" required>
									<option value="">-- Pilih Sub Kategori --</option>
								</select>
							</div>

							<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
						</div>
					</form>
				</div>
			</div>
			<br>
			@if( isset($location) )
				<div class="row">
					@if( count($location) != 0 )
						@foreach( $location as $item )
							<div class="col-md-12" style="border: 1px solid #eee; padding: 10px 0px;">
								<div class="col-md-2">
									<img src="{{ asset('storage/'.$item->path) }}" class="img-thumbnail" style="height: 150px; width: 100%;">
								</div>
								<div class="col-md-10">
									<div class="row">
										<div class="col-md-2">
											<b>Pemilik Produk :</b>
										</div>
										<div class="col-md-10">
											{{ $item->owner_name }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<b>Nama Produk :</b>
										</div>
										<div class="col-md-10">
											{{ $item->product_name }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<b>Harga :</b>
										</div>
										<div class="col-md-10">
											Rp. {{ $item->product_price }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<b>Alamat :</b>
										</div>
										<div class="col-md-10">
											{{ $item->product_address }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<b>Jarak :</b>
										</div>
										<div class="col-md-10">
											{!! number_format($item->distance, 3) !!} Km
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<a href="{{ route('member.product.index', ['id' => $item->product_id]) }}">
												<button class="btn btn-info pull-right"><i class="fa fa-eye"></i> Lihat</button>
											</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					@else
						<div class="col-md-12">
							Tidak ada data produk yang paling dekat dengan radius yang Anda masukkan
						</div>
					@endif
				</div>
			@endif
		</div>
	</div>
@endsection

@section('css')
    <style>
        #map-canvas {
            height: 400px;
            width: 100%;
        }
    </style>
@endsection

@section('js')
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('#formLocationProduct #category').on('change', function() {
                $('#formLocationProduct #sub_category').children('option:not(:first)').remove();
                
                var idCategory = $(this).find(":selected").val();
                
                @foreach( $subCategories as $item )
                    if( {{ $item->category_id }} == idCategory ){
                        $('#formLocationProduct #sub_category').append($('<option>', {
                            value: {{ $item->id }},
                            text: "{{ $item->name }}"
                        }));
                    }
                @endforeach
            });
		});
	</script>

	<script>
		var markers = [];

		@for( $i = 0; $i < count($data); $i++ )
			markers[{{$i}}] = [
								'{{ $data[$i]->location->title }}', 
								{{ $data[$i]->location->latitude }}, 
								{{ $data[$i]->location->longitude }}, 
								'{{ $data[$i]->name }}', 
								'{{ $data[$i]->user->name }}',
								{{ $data[$i]->price }},
								{{ $data[$i]->id }}
							];
		@endfor;

		function initialize() {

			var posisi = {lat: 3.587524, lng: 98.69066010000006};
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 15,
                center: posisi
            });

            infoWindow = new google.maps.InfoWindow;

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};

					$('#latitude').val(pos.lat);
                	$('#longitude').val(pos.lng);

					infoWindow.setPosition(pos);
					infoWindow.setContent('Lokasi Anda Saat Ini.');
					infoWindow.open(map);
					map.setCenter(pos);

				}, function() {
					handleLocationError(true, infoWindow, map.getCenter());
					});
			} else {
				// Browser doesn't support Geolocation
				handleLocationError(false, infoWindow, map.getCenter());
			}

			function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		        infoWindow.setPosition(pos);
		        infoWindow.setContent(browserHasGeolocation ?
		                              'Error: Layanan Geolokasi gagal.' :
		                              'Error: Browser Anda tidak mendukung geolokasi.');
		        infoWindow.open(map);
		    }
		    
			var infowindow = new google.maps.InfoWindow(), marker, i;
			// var bounds = new google.maps.LatLngBounds(); // diluar looping
			for (i = 0; i < markers.length; i++) {  
				pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
				marker = new google.maps.Marker({
					position: pos,
					map: map
				});

				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						infowindow.setContent(
								'<b>Nama Produk : </b>'+ markers[i][3] + '<br>' +
								'<b>Alamat : </b>' + markers[i][0] + '<br>' +
								'<b>Pemilik Barang : </b>' + markers[i][4] + '<br>' +
								'<b>Harga : </b>' + 'IDR.' + markers[i][5] + '<br>' +
								'<a href="/product/ '+ markers[i][6] +' ">'+ 'Lihat Produk' +'</a>'
						);
						infowindow.open(map, marker);
					}
				})(marker, i));
				// map.fitBounds(bounds); // setelah looping
			}

		}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3gN0AFseoGdJj7jV-gClr6Hsu9VVYsE0&libraries=places&callback=initialize"></script>
@endsection