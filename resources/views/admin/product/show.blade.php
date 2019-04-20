@extends('layouts.admin')

@section('header')
	<h1>
		Product
		<small>Details</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('product.index') }}">Management Product</a></li>
		<li class="active">Product Details</li>
	</ol>
@endsection

@section('content')
	<div class="box box-warning">
        <div class="box-body" style="overflow-y: scroll; height: 400px;">
        	<div class="row">
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
								Total Report
							</strong>
							<p class="text-muted">
								{{ $data->total_report }}
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
								SubCategory
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
	            <div class="row">
	            	<div class="col-md-12">
	            		<strong>Note : </strong> {{ $data->note }}
	            	</div>
	            </div>
			@endif
        </div>
    </div>

    <div class="box box-warning">
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
	</div>

	<div class="box box-warning">
    	<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-map"></i> Locations Map Product {{ $data->name }}</h3>
		</div>
        <div class="box-body">
    		<div id="map-canvas"></div>
        </div>
    </div>

    <?php
    	$noSatu = 0; $noDua = 0; $noTiga = 0; $noEmpat = 0;

    	foreach ($data->reports as $report){
    		if( $report->content == App\Models\Report::CONTENT_OPTION_1 )
    			$noSatu++;
    		else if( $report->content == App\Models\Report::CONTENT_OPTION_2 )
    			$noDua++;
    		else if( $report->content == App\Models\Report::CONTENT_OPTION_3 )
    			$noTiga++;
    		else
    			$noEmpat++;
    	}
    ?>

	<div class="box box-warning">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-exclamation"></i> Report Product {{ $data->name }}</h3>
		</div>
		<div class="box-body">
			<table class="table table-striped table-bordered table-hover nowrap">
				<tr>
					<th style="width: 5%">No.</th>
					<th style="width: 30%">Content</th>
					<th style="width: 10%">Total</th>
					<th style="width: 50%">Progress</th>
					<th style="width: 15%">Percentage</th>
					<th style="width: 5%">Action</th>
				</tr>
				<tr>
					<td>1.</td>
					<td>{{ App\Models\Report::CONTENT_OPTION_1 }}</td>
					<td>{{ $noSatu }}</td>
					<td>
						<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-danger" style="width: {{ $noSatu * (1 / 100) }}%"></div>
						</div>
					</td>
					<td><span class="badge bg-red">{{ $noSatu * (1 / 100) }}%</span></td>
					<td><a href="#" class="btn btn-xs btn-primary" id="option1"><i class="fa fa-eye"></i> View</a></td>
				</tr>
				<tr>
					<td>2.</td>
					<td>{{ App\Models\Report::CONTENT_OPTION_2 }}</td>
					<td>{{ $noDua }}</td>
					<td>
						<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-yellow" style="width: {{ $noDua * (1 / 100) }}%"></div>
						</div>
					</td>
					<td><span class="badge bg-yellow">{{ $noDua * (1 / 100) }}%</span></td>
					<td><a href="#" class="btn btn-xs btn-primary" id="option2"><i class="fa fa-eye"></i> View</a></td>
				</tr>
				<tr>
					<td>3.</td>
					<td>{{ App\Models\Report::CONTENT_OPTION_3 }}</td>
					<td>{{ $noTiga }}</td>
					<td>
						<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-primary" style="width: {{ $noTiga * (1 / 100) }}%"></div>
						</div>
					</td>
					<td><span class="badge bg-light-blue">{{ $noTiga * (1 / 100) }}%</span></td>
					<td><a href="#" class="btn btn-xs btn-primary" id="option3"><i class="fa fa-eye"></i> View</a></td>
				</tr>
				<tr>
					<td>4.</td>
					<td>{{ App\Models\Report::CONTENT_OPTION_4 }}</td>
					<td>{{ $noEmpat }}</td>
					<td>
						<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-success" style="width: {{ $noEmpat * (1 / 100) }}%"></div>
						</div>
					</td>
					<td><span class="badge bg-green">{{ $noEmpat * (1 / 100) }}%</span></td>
					<td><a href="#" class="btn btn-xs btn-primary" id="option4"><i class="fa fa-eye"></i> View</a></td>
				</tr>
			</table>
		</div>
		<div class="box-footer">
        	<a href="{{ route('product.index') }}" class="pull-left btn btn-warning"><i class="fa  fa-mail-reply"></i> Back</a>
        	
        	@if ( $data->status != \App\Models\Product::STATUS_BLOCKIR )
        		<button id="btnBlockir" class="btn btn-danger pull-right">
	        		<i class="fa fa-close"></i> Blockir
	        	</button>
        	@endif
        </div>
	</div>

    <!-- blockir -->
    <div class="modal fade" tabindex="-1" role="dialog" id="blockirModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formBlockir" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                    	<p id="del-success">Are you sure you want to blockir Product ?</p>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="note" id="note" cols="" rows="" class="form-control" placeholder="Input your note ..."></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>                 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Yes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- option 1 -->
    <div class="modal fade" tabindex="-1" role="dialog" id="option1Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Report {{ App\Models\Report::CONTENT_OPTION_1 }}</h4>
                </div>

                <div class="modal-body" style="overflow-y: scroll; height: 400px;">
                	<table class="table table-striped table-bordered table-hover nowrap">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
						</tr>
						@foreach ($data->reports as $report)
							@if ( $report->content == App\Models\Report::CONTENT_OPTION_1 )
								<tr>
									<th>{{ $report->user->name }}</th>
									<th>{{ $report->user->email }}</th>
									<th>{{ $report->user->phone != null ? $report->user->phone : '-' }}</th>
								</tr>
							@endif
						@endforeach
                	</table>
                </div>
            </div>
        </div>
    </div>

    <!-- option 2 -->
    <div class="modal fade" tabindex="-1" role="dialog" id="option2Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Report {{ App\Models\Report::CONTENT_OPTION_2 }}</h4>
                </div>

                <div class="modal-body" style="overflow-y: scroll; height: 400px;">
                	<table class="table table-striped table-bordered table-hover nowrap">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
						</tr>
						@foreach ($data->reports as $report)
							@if ( $report->content == App\Models\Report::CONTENT_OPTION_2 )
								<tr>
									<th>{{ $report->user->name }}</th>
									<th>{{ $report->user->email }}</th>
									<th>{{ $report->user->phone != null ? $report->user->phone : '-' }}</th>
								</tr>
							@endif
						@endforeach
                	</table>
                </div>
            </div>
        </div>
    </div>

    <!-- option 3 -->
    <div class="modal fade" tabindex="-1" role="dialog" id="option3Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Report {{ App\Models\Report::CONTENT_OPTION_3 }}</h4>
                </div>

                <div class="modal-body" style="overflow-y: scroll; height: 400px;">
                	<table class="table table-striped table-bordered table-hover nowrap">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
						</tr>
						@foreach ($data->reports as $report)
							@if ( $report->content == App\Models\Report::CONTENT_OPTION_3 )
								<tr>
									<th>{{ $report->user->name }}</th>
									<th>{{ $report->user->email }}</th>
									<th>{{ $report->user->phone != null ? $report->user->phone : '-' }}</th>
								</tr>
							@endif
						@endforeach
                	</table>
                </div>
            </div>
        </div>
    </div>

    <!-- option 4 -->
    <div class="modal fade" tabindex="-1" role="dialog" id="option4Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Report {{ App\Models\Report::CONTENT_OPTION_4 }}</h4>
                </div>

                <div class="modal-body" style="overflow-y: scroll; height: 400px;">
                	<table class="table table-striped table-bordered table-hover nowrap">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
						</tr>
						@foreach ($data->reports as $report)
							@if ( $report->content == App\Models\Report::CONTENT_OPTION_4 )
								<tr>
									<td>{{ $report->user->name }}</td>
									<td>{{ $report->user->email }}</td>
									<td>{{ $report->user->phone != null ? $report->user->phone : '-' }}</td>
								</tr>
							@endif
						@endforeach
                	</table>
                </div>
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
    <link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
@endsection

@section('js')
	<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
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

	        $('[data-fancybox]').fancybox({
				protect: true
			});

			$('[data-fancybox="albumProduct"]').fancybox({
				protect    : true,
				slideClass : 'watermark',
				arrows : true,
				infobar : true
			});

	        $('#btnBlockir').click(function () {
                $('#formBlockir')[0].reset();
                $('#formBlockir .modal-title').text("Blockir Product");
                $('#formBlockir div.form-group').removeClass('has-error');
                $('#formBlockir .help-block').empty();
                $('#formBlockir button[type=submit]').button('reset');

                $('#formBlockir .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("product.index") }}' + '/' + {{ $data->id }};

                $('#blockirModal').modal('show');
            });

            $('#formBlockir').submit(function (event) {
                event.preventDefault();
                $('#formBlockir button[type=submit]').button('loading');
                $('#formBlockir div.form-group').removeClass('has-error');
                $('#formBlockir .help-block').empty();

                var _data = $("#formBlockir").serialize();
                $.ajax({
                    url: url,
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

                            $('#blockirModal').modal('hide');
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
                        $('#formBlockir button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formBlockir').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formBlockir input[name='" + data[key].name + "']").length ? $("#formBlockir input[name='" + data[key].name + "']") : $("#formBlockir textarea[name='" + data[key].name + "']");
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
                        $('#formBlockir button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>

    <script>
    	jQuery(document).ready(function($) {
    		// option 1
            $('#option1').click(function () { 
               	$('#option1Modal').modal('show');
            });

            $('#option2').click(function () { 
               	$('#option2Modal').modal('show');
            });

            $('#option3').click(function () { 
               	$('#option3Modal').modal('show');
            });

            $('#option4').click(function () { 
               	$('#option4Modal').modal('show');
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