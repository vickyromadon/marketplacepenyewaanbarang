@extends('layouts.owner')

@section('header')
	<h1>
		Upload Album
		<small>Product</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li>Product</li>
		<li><a href="{{ route('owner.product.index') }}">List Product</a></li>
		<li><a href="{{ route('owner.product.show', ['product' => $data->id]) }}">Detail Product</a></li>
		<li class="active">Upload Album Product</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-file-image-o"></i> Upload Foto</h3>
					<a href="{{ route('owner.product.show', ['product' => $data->id]) }}" class="btn btn-warning pull-right"><i class="fa fa-reply"></i> Back</a>
				</div>
				<form action="/" enctype="multipart/form-data" method="POST">
			        <div class="box-body">
				        <div class="dropzone" id="my-dropzone" name="mainFileUploader">
				            <div class="fallback">
				                <input name="file" type="file" multiple />
				            </div>
				        </div>
			        </div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript">
		var myDropzone = Dropzone.options.myDropzone = { 
			url: "{{ route('owner.product.upload', ['id' => $data->id]) }}",
			dictDefaultMessage: '<h1 style="color:#333">Upload your Product! <i class="fa fa-image"></i></h1>',
			autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 100,
			autoProcessQueue: true,
			autoQueue: true,
            maxFiles: 100,
            maxFilesize: 6, //MB

            renameFilename: function (filename) {
            	return new Date().getTime(); + '_' + filename;
        	},

            addRemoveLinks: true,
            removedfile: function(file) {
			  	var name = file.upload.filename; 

			  	$.ajax({
			  		headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			        },
			   		type: 'POST',
				  	url: "{{ route('owner.product.upload', ['id' => $data->id]) }}",
				   	data: {name: name, flag : 2},
				   	dataType: 'html',
			  	});

			  	$.toast({
                    heading: 'Success',
                    text : 'Foto Successfully Deleted',
                    position : 'top-right',
                    allowToastClose : true,
                    showHideTransition : 'fade',
                    icon : 'success',
                    loader : false
                });

			  	var fileRef;
        		return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
			},
           	
           	params: {
            	_token: "{{ csrf_token() }}",
            },
            accept: function(file, done) {
	            if (file.type != "image/jpeg" && file.type != "image/png" && file.type != "image/jpg") {
	                done("Error! Files of this type are not accepted");
	            }
	            else { done(); }
	        },
	        success: function (file, done) {
		    	$.toast({
                    heading: 'Success',
                    text : done.message,
                    position : 'top-right',
                    allowToastClose : true,
                    showHideTransition : 'fade',
                    icon : 'success',
                    loader : false
                });
		    }
		};
	</script>
@endsection