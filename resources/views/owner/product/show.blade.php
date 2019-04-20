@extends('layouts.owner')

@section('header')
	<h1>
		Product <small>Detail</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li>Product</li>
		<li><a href="{{ route('owner.product.index') }}">List Product</a></li>
		<li class="active">Detail Product</li>
	</ol>
@endsection

@section('content')
	<div class="box box-danger">
        <div class="box-body">
            <div class="col-md-4">
                <img src="{{ asset('storage/'.$data->file->path) }}" class="img-responsive img-thumbnail" style="height: 300px; width: 100%;">
            </div>
            <div class="col-md-8">
            	<div class="row">
            		<div class="col-md-5">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Product Name
						</strong>
						<p class="text-muted">
							{{ $data->name }}
						</p>

						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Quantity
						</strong>
						<p class="text-muted">
							{{ $data->quantity }}
						</p>

						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Price
						</strong>
						<p class="text-muted">
							IDR. {{ $data->price }} / {{ $data->time_periode }}
						</p>

						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Security Deposite
						</strong>
						<p class="text-muted">
							IDR. {{ $data->deposite }}
						</p>
					</div>
					
					<div class="col-md-5">
						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Total View
						</strong>
						<p class="text-muted">
							{{ $data->view }}
						</p>

						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Category
						</strong>
						<p class="text-muted">
							{{ $data->sub_category->category->name }}
						</p>

						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Sub Category
						</strong>
						<p class="text-muted">
							{{ $data->sub_category->name }}
						</p>

						<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Status
						</strong>
						<p class="text-muted">
							@if ( $data->status == \App\Models\Product::STATUS_PUBLISH )
								<span class="label label-success">{{ $data->status }}</span>
							@elseif( $data->status == \App\Models\Product::STATUS_UNPUBLISH )
								<span class="label label-warning">{{ $data->status }}</span>
							@else
								<span class="label label-danger">{{ $data->status }}</span>
							@endif
						</p>
					</div>
					@if ( $data->status != \App\Models\Product::STATUS_BLOCKIR )
						<div class="col-md-2">
							<a href="{{ route('owner.product.update', ['product' => $data->id]) }}" class="btn btn-warning"><i class="fa fa-gears"></i> Edit</a>
						</div>
					@endif
            	</div>
            	<div class="row">
            		<div class="col-md-12">
            			<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Description
						</strong>
						<p class="text-muted">
							{!! $data->description !!}
						</p>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-12">
            			<strong>
							<i class="fa fa-chevron-circle-right margin-r-5"></i> 
							Terms and Conditions
						</strong>
						<p class="text-muted">
							{!! $data->terms_and_conditions !!}
						</p>
            		</div>
            	</div>
            </div>
        </div>
        @if ( $data->status == \App\Models\Product::STATUS_BLOCKIR )
        	<div class="box-footer">
				<div class="col-md-12">
					<strong>NOTE : </strong> {{ $data->note }}
				</div>
	        </div>
        @endif
    </div>

    <div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-folder-open"></i> Album Product {{ $data->name }}</h3>
		</div>

		<div class="box-body" style="overflow-y: scroll; height: 400px;">
			@if( count($data->albums) > 0 )
				@foreach($data->albums as $album)
					<div class="col-md-4">
						<a data-fancybox="albumProduct" href="{{ asset('storage/'.$album->file->path) }}" style="position: absolute;margin-left: 80%;padding-top: 6%;color: #6d8568;z-index: 1;">
							<i class="fa fa-search" style="color: #FFFFFF;text-shadow: 0px 0px 5px #000000;"></i>
						</a> 
						<label class="checkbox fancy-checkbox-label">
							<span class="fancy-checkbox fancy-checkbox-img"></span> 
							
							<img id="uploadFinish" class="img-responsive img-thumbnail" src="{{ asset('storage/'.$album->file->path) }}" style="width: 300px;height: 150px;object-fit: cover;">
						</label>
					</div>
				@endforeach
			@else
				<center><h1>No Image Available</h1></center>
			@endif
		</div>

		<div class="box-footer">
			<a href="{{ route('owner.product.upload', ['id' => $data->id]) }}" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Upload</a>
		</div>
	</div>
	
    <div class="box box-danger">
    	<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-map"></i> Locations Map Product {{ $data->name }}</h3>
		</div>
        <div class="box-body">
    		<div id="map-canvas"></div>
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
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
@endsection

@section('js')
	<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
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

			$('[data-fancybox]').fancybox({
				protect: true
			});

			$('[data-fancybox="albumProduct"]').fancybox({
				protect    : true,
				slideClass : 'watermark',
				arrows : true,
				infobar : true
			});
		});
	</script>

	<script type="text/javascript">
		function initMap() {
			var latitude    = {{ $data->location != null ? $data->location->latitude : 3.5951956 }};
            var longitude   = {{ $data->location != null ? $data->location->longitude : 98.67222270000002 }};
            var posisi = {lat: latitude, lng: longitude};
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 15,
                center: posisi
            });

            var contentString = '<div><b>{{ $data->user->name }}</b> : {{ $data->name }}</div>';
            var info = new google.maps.InfoWindow({
                content: contentString
            });
        
            var marker = new google.maps.Marker({
                position: posisi,
                title:'Location Product',
                map: map,
            });

            google.maps.event.addListener(marker,'click',function(e){
                info.open(map, marker);   
            });
		}
	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3gN0AFseoGdJj7jV-gClr6Hsu9VVYsE0&libraries=places&callback=initMap"></script>
@endsection

