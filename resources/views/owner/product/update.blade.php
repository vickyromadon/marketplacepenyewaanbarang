@extends('layouts.owner')

@section('header')
	<h1>
		Edit
		<small>Product</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li>Product</li>
		<li><a href="{{ route('owner.product.index') }}">List Product</a></li>
		<li><a href="{{ route('owner.product.show', ['product' => $data->id]) }}">Detail Product</a></li>
		<li class="active">Edit Product</li>
	</ol>
@endsection

@section('content')
	<div class="box box-danger">
       <form action="" id="formEditProduct" enctype="multipart/form-data" method="POST">
	        <div class="box-body">
	        	<input type="hidden" id="id" name="id">
                <div class="form-group">
                    <label class="control-label">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">-- Select One --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <span class="help-block"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Sub Category</label>
                    <select class="form-control" id="sub_category" name="sub_category" required>
                        <option value="">-- Select One --</option>
                        @foreach ($subCategory as $sub_category)
                            <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                        @endforeach
                    </select>

                    <span class="help-block"></span>
                </div>
                
                <div class="form-group">
                    <label class="control-label">Product Name</label>

                    <input class="form-control" type="text" id="name" name="name" placeholder="Product Name" required>
                    <span class="help-block"></span>
                </div>
                
                <div class="form-group">
                    <label class="control-label">Quantity</label>

                    <input type="number" class="form-control" id="quantity" name="quantity" min="0" placeholder="Quantity Product" required>
                    <span class="help-block"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Price</label>

                    <input type="text" class="form-control" id="price" name="price" min="0" placeholder="Price Product" required>
                    <span class="help-block"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Time Periode</label>

                    <select class="form-control" id="time_periode" name="time_periode" required>
                        <option value="">-- Select One --</option>
                        <option value="Day">Per Day</option>
                        <option value="Month">Per Month</option>
                        <option value="Year">Per Year</option>
                    </select>
                    <span class="help-block"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Security Deposite (Optional)</label>

                    <input type="number" class="form-control" id="deposite" name="deposite" min="0" placeholder="Deposite Product">
                    <span class="help-block"></span>
                </div>

                <div class="form-group">
                	<label class="control-label">
                        Cover Product
                    </label><br>

                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                            <img id="img-upload" src="" style="width: 200px; height: 150px;">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <div>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" id="file_id" name="file_id">
                            </span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
                                Remove
                            </a>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label">Description</label>

                    <textarea name="description" id="description" rows="10" class="form-control" placeholder="Description Product" required>{!! $data->description !!}</textarea>
                    <span class="help-block"></span>
                </div>

                <div class="form-group">
                    <label class="control-label">Terms and Conditions</label>

                    <textarea name="terms_and_conditions" id="terms_and_conditions" rows="10" class="form-control" placeholder="Terms and Conditions Product" required>{!! $data->terms_and_conditions !!}</textarea>
                    <span class="help-block"></span>
                </div>

                <div class="form-group">
                    <label for="">Set Location For Products</label>
                    <input type="text" id="searchmap" name="title" class="form-control" required>
                    <div id="map-canvas"></div>
                </div>

                <input type="hidden" id="latitude" name="latitude" class="form-control" required>
                <input type="hidden" id="longitude" name="longitude" class="form-control" required>

                <div class="form-group">
                    <label class="control-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">-- Select One --</option>
                        <option value="unpublish">Unpublish</option>
                        <option value="publish">Publish</option>
                    </select>

                    <span class="help-block"></span>
                </div>
	        </div>
	        <div class="box-footer">
	        	<a href="{{ route('owner.product.show', ['product' => $data->id]) }}" class="btn btn-warning pull-left"> Cancel</a>
                <button type="submit" class="btn btn-primary pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Update
                </button>
	        </div>
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

    <style>
        #map-canvas {
            height: 400px;
            width: 100%;
        }
    </style>
@endsection

@section('js')
	<script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

	<script type="text/javascript">
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

	        $('#formEditProduct #id').val("{{ $data->id }}");
	        $('#formEditProduct #name').val("{{ $data->name }}");
	        $('#formEditProduct #category').val("{{ $data->sub_category->category_id }}");
            $('#formEditProduct #sub_category').val("{{ $data->sub_category_id }}");
	        $('#formEditProduct #quantity').val("{{ $data->quantity }}");
	        $('#formEditProduct #price').val("{{ $data->price }}");
	        $('#formEditProduct #img-upload').attr('src', "{{ asset('storage/'.$data->file->path) }}");
            $('#formEditProduct #status').val("{{ $data->status }}");
            $('#formEditProduct #searchmap').val("{{ $data->location != null ? $data->location->title : null }}");
            $('#formEditProduct #latitude').val("{{ $data->location != null ? $data->location->latitude : null }}");
            $('#formEditProduct #longitude').val("{{ $data->location != null ? $data->location->longitude : null }}");
            $('#formEditProduct #time_periode').val("{{ $data->time_periode }}");
            $('#formEditProduct #deposite').val("{{ $data->deposite }}");

	        $('#formEditProduct').submit(function (event) {
                $('#formEditProduct div.form-group').removeClass('has-error');
                $('#formEditProduct .help-block').empty();
        		event.preventDefault();
                $('#formEditProduct button[type=submit]').button('loading');
        		CKEDITOR.instances['description'].updateElement();
                CKEDITOR.instances['terms_and_conditions'].updateElement();

        		var formData = new FormData($("#formEditProduct")[0]);

        		$.ajax({
                    url: '{{ route("owner.product.update", ['product' => $data->id]) }}',
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
                                location.href = "/owner/product/" + {{ $data->id }};
	                        }, 2000);
                        }
                        $('#formEditProduct button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formEditProduct').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formEditProduct input[name='" + data[key].name + "']").length )
                                    	elem = $("#formEditProduct input[name='" + data[key].name + "']");
                                    else if( $("#formEditProduct select[name='" + data[key].name + "']").length )
                                    	elem = $("#formEditProduct select[name='" + data[key].name + "']");
                                    else
                                    	elem = $("#formEditProduct textarea[name='" + data[key].name + "']");
                                    
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().addClass('has-error');
                                }
                            });
                            if(error['file_id'] != undefined){
                                $("#formEditProduct input[name='file_id']").parent().parent().parent().find('.help-block').text(error['file_id']);
                                $("#formEditProduct input[name='file_id']").parent().parent().parent().find('.help-block').show();
                                $("#formEditProduct input[name='file_id']").parent().parent().parent().parent().addClass('has-error');
                            }
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
                        $('#formEditProduct button[type=submit]').button('reset');
                    }
                });
        	});
            
            $('#formEditProduct #category').on('change', function() {
                $('#formEditProduct #sub_category').children('option:not(:first)').remove();
                
                var idCategory = $(this).find(":selected").val();
                
                @foreach( $subCategories as $item )
                    if( {{ $item->category_id }} == idCategory ){
                        $('#formEditProduct #sub_category').append($('<option>', {
                            value: {{ $item->id }},
                            text: "{{ $item->name }}"
                        }));
                    }
                @endforeach
            });
	    });
	</script>

	<script type="text/javascript">
	  	$(function () {
            CKEDITOR.replace('description', {
                toolbarGroups: [
                    { name: 'document',    groups: [ 'mode', 'document' ] },           
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'links' },
                    { name: 'styles', groups: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', groups: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', groups: [ 'Maximize', 'ShowBlocks' ] },
                ]
            });
        });

        $(function () {
            CKEDITOR.replace('terms_and_conditions', {
                toolbarGroups: [
                    { name: 'document',    groups: [ 'mode', 'document' ] },           
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'links' },
                    { name: 'styles', groups: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', groups: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', groups: [ 'Maximize', 'ShowBlocks' ] },
                ]
            });
        });
    </script>

    <script>
        function initMap() {
            var latitude    = {{ $data->location != null ? $data->location->latitude : 3.5951956 }};
            var longitude   = {{ $data->location != null ? $data->location->longitude : 98.67222270000002 }};
            var posisi = {lat: latitude, lng: longitude};
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 15,
                center: posisi
            });
        
            var marker = new google.maps.Marker({
                position: posisi,
                map: map,
                draggable: true
            });

            var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

            google.maps.event.addListener(marker,'click',function(e){
                info.open(map, marker);   
            });

            google.maps.event.addListener(searchBox, 'places_changed', function(){
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();

                for (var i = 0; places = places[i]; i++) {
                    bounds.extend(places.geometry.location);
                    marker.setPosition(places.geometry.location);

                    map.fitBounds(bounds);
                    map.setZoom(15)
                }
            });

            google.maps.event.addListener(marker, 'position_changed', function(){
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();

                $('#latitude').val(lat);
                $('#longitude').val(lng);

                latCoder = $('#latitude').val(lat).val();
                lngCoder = $('#longitude').val(lng).val();

                getCoder(latCoder, lngCoder);
            });
        }

        function getCoder(latCoder, lngCoder){
            var geocoder  = new google.maps.Geocoder();
            var location  = new google.maps.LatLng(latCoder, lngCoder);         
            geocoder.geocode({'latLng': location}, function (results, status) {
            if(status == google.maps.GeocoderStatus.OK) {          
                    var add=results[0].formatted_address;         
                    $('#searchmap').val(add);
                }
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3gN0AFseoGdJj7jV-gClr6Hsu9VVYsE0&libraries=places&callback=initMap"></script>
@endsection