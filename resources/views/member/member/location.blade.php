@extends('layouts.app')

@section('content')
	<div class="faq">
		<div class="container">
			<h2 class="head text-center">Locations Map RentOnCome</h2>
		</div>
		<div class="row">
			<div class="col-md-12" style="padding: 0px 50px;">
				<div id="map-canvas"></div>
			</div>
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
	<script>
		function initMap() {
			var latitude    = {{ $data->location->latitude }};
            var longitude   = {{ $data->location->longitude }};
            var posisi = {lat: latitude, lng: longitude};
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 15,
                center: posisi
            });

            var contentString = '<div><b>RentOnCome</b> : a market place for rental of products</div>';
            var info = new google.maps.InfoWindow({
                content: contentString
            });
        
            var marker = new google.maps.Marker({
                position: posisi,
                title:'Locations Office',
                map: map,
            });

            google.maps.event.addListener(marker,'click',function(e){
                info.open(map, marker);   
            });
		}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3gN0AFseoGdJj7jV-gClr6Hsu9VVYsE0&libraries=places&callback=initMap"></script>
@endsection