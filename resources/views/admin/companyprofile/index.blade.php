@extends('layouts.admin')

@section('header')
	<h1>
		Company Profile
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Company Profile</li>
	</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-phone"></i> Contact Us</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <form action="#" method="post" id="formContactUs">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-phone-square"></i> Number Phone</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Input your number phone" value="@if( $data->phone != '' ) {{ $data->phone }} @endif">

                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-envelope"></i> Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Input your email" value="@if( $data->email != '' ) {{ $data->email }} @endif">

                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <div class="pull-right">
                                <div class="col-sm-1">
                                    <button type="submit" class="btn btn-success" data-loading-text="<i class='fa fa-spinner fa-spin'></i>"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Who We Are</h3>
                    <div class="box-tools pull-right">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
		                    <i class="fa fa-minus"></i>
		                </button>
		            </div>
                </div>
                <div class="box-body"> 
                    <div class="summernote" id="editor1">{!! $data->description !!}</div>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <form method="post">
	                        <button id="editBtn1" type="button" class="btn btn-warning btn-approve"><i
	                            class="fa fa-edit"></i> Edit
	                        </button>
	                        <button id="saveBtn1" type="button" class="btn btn-success btn-approve"><i
	                            class="fa fa-save"></i> Save
	                        </button>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-book"></i> Terms Of Use</h3>
                    <div class="box-tools pull-right">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
		                    <i class="fa fa-minus"></i>
		                </button>
		            </div>
                </div>
                <div class="box-body"> 
                    <div class="summernote" id="editor2">{!! $data->terms_of_use !!}</div>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <form method="post">
	                        <button id="editBtn2" type="button" class="btn btn-warning btn-approve"><i
	                            class="fa fa-edit"></i> Edit
	                        </button>
	                        <button id="saveBtn2" type="button" class="btn btn-success btn-approve"><i
	                            class="fa fa-save"></i> Save
	                        </button>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-shield"></i> Privacy Policy</h3>
                    <div class="box-tools pull-right">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
		                    <i class="fa fa-minus"></i>
		                </button>
		            </div>
                </div>
                <div class="box-body"> 
                    <div class="summernote" id="editor3">{!! $data->privacy_policy !!}</div>
                </div>
                <div class="box-footer">
                    <div class="box-tools pull-right">
                        <form method="post">
	                        <button id="editBtn3" type="button" class="btn btn-warning btn-approve"><i
	                            class="fa fa-edit"></i> Edit
	                        </button>
	                        <button id="saveBtn3" type="button" class="btn btn-success btn-approve"><i
	                            class="fa fa-save"></i> Save
	                        </button>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-map-marker"></i> Set Location</h3>
                </div>
                <form method="post" id="formLocation">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Search Location</label>
                            <input type="text" id="searchmap" name="title" value="{{ $data->location->title }}" class="form-control">
                            <div id="map-canvas"></div>
                        </div>

                        <input type="hidden" id="latitude" name="latitude" class="form-control">
                        <input type="hidden" id="longitude" name="longitude" class="form-control">
                    </div>
                    <div class="box-footer">
                        <div class="box-tools pull-right">
                            <button id="saveBtn4" type="button" class="btn btn-success btn-approve"><i
                                class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
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
    	jQuery(document).ready(function($) {
            // contact us
            $('#formContactUs').submit(function(event){
                event.preventDefault();
                $('#formContactUs div.form-group').removeClass('has-error');
                $('#formContactUs .help-block').empty();
                $('#formContactUs button[type=submit]').button('loading');

                var _data = $('#formContactUs').serialize();

                $.ajax({
                    url: '{{ route("company_profile.contact") }}',
                    type: 'POST',
                    data: _data,
                    dataType: 'json',
                    cache: false,

                    success: function (response) {
                        $('#formContactUs button[type=submit]').button('reset');
                        $('#formContactUs')[0].reset();

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
                    },

                    error: function (response) {
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formContactUs').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formContactUs input[name='" + data[key].name + "']").length ? $("#formContactUs input[name='" + data[key].name + "']") : $("#formContactUs select[name='" + data[key].name + "']");
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
                                loader : false
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }

                        $('#formContactUs button[type=submit]').button('reset');
                    }
                });
            });

    		// who we are
    		$('#editor1').summernote();
            $('#editor1').summernote('destroy');
            $('#saveBtn1').hide();
            var editorFocus1 = false;
            $('#editBtn1').click(function(e){
                if(!editorFocus1){
                    $('#editor1').summernote({focus: true});
                    $('#saveBtn1').show();
                }
                else{
                    $('#editor1').summernote('destroy');
                	$('#saveBtn1').hide();
                }
                editorFocus1=!editorFocus1;
            });

            $('#saveBtn1').click(function(e){

                var markup1 = $('#editor1').summernote('code');
                $('#editor1').summernote('destroy');
                $(this).button('loading');
                editorFocus1=false;
                $.ajax({
                    url: "{{ route('company_profile.description') }}",
                    type: 'POST',
                    data: { "description" : markup1 },
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

	                        $('#saveBtn1').hide();
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
                        $('#saveBtn1').button('reset');
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#saveBtn1').button('reset');
                    }
                });
            });

            // terms of use
    		$('#editor2').summernote();
            $('#editor2').summernote('destroy');
            $('#saveBtn2').hide();
            var editorFocus2 = false;
            $('#editBtn2').click(function(e){
                if(!editorFocus2){
                    $('#editor2').summernote({focus: true});
                    $('#saveBtn2').show();
                }
                else{
                    $('#editor2').summernote('destroy');
                	$('#saveBtn2').hide();
                }
                editorFocus2=!editorFocus2;
            });

            $('#saveBtn2').click(function(e){

                var markup2 = $('#editor2').summernote('code');
                $('#editor2').summernote('destroy');
                $(this).button('loading');
                editorFocus2=false;
                $.ajax({
                    url: "{{ route('company_profile.terms_of_use') }}",
                    type: 'POST',
                    data: { "terms_of_use" : markup2 },
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

	                        $('#saveBtn2').hide();
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
                        $('#saveBtn2').button('reset');
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#saveBtn2').button('reset');
                    }
                });
            });

            // privacy policy
    		$('#editor3').summernote();
            $('#editor3').summernote('destroy');
            $('#saveBtn3').hide();
            var editorFocus3 = false;
            $('#editBtn3').click(function(e){
                if(!editorFocus3){
                    $('#editor3').summernote({focus: true});
                    $('#saveBtn3').show();
                }
                else{
                    $('#editor3').summernote('destroy');
                	$('#saveBtn3').hide();
                }
                editorFocus3=!editorFocus3;
            });

            $('#saveBtn3').click(function(e){

                var markup3 = $('#editor3').summernote('code');
                $('#editor3').summernote('destroy');
                $(this).button('loading');
                editorFocus3=false;
                $.ajax({
                    url: "{{ route('company_profile.privacy_policy') }}",
                    type: 'POST',
                    data: { "privacy_policy" : markup3 },
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

	                        $('#saveBtn3').hide();
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
                        $('#saveBtn3').button('reset');
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#saveBtn3').button('reset');
                    }
                });
            });

            $('#saveBtn4').click(function(event){
                event.preventDefault();
                $(this).button('loading');

                var _data = $("#formLocation").serialize();

                $.ajax({
                    url: "{{ route('company_profile.location') }}",
                    type: 'POST',
                    data: _data,
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
                                loader : false
                            });                         
                        }
                        $('#saveBtn4').button('reset');
                    },
                    error: function(response){
                        if (response.status === 400 || response.status === 422) {
                            // Bad Client Request
                            $.toast({
                                heading: 'Error',
                                text : response.responseJSON.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : "Whoops, looks like something went wrong.",
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false
                            });
                        }
                        $('#saveBtn4').button('reset');
                    }
                });
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

            var contentString = '<div><b>RentOnCome</b> : a market place for rental of products</div>';
            var info = new google.maps.InfoWindow({
                content: contentString
            });
        
            var marker = new google.maps.Marker({
                position: posisi,
                title:'RentOnCome',
                label:'ROC',
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