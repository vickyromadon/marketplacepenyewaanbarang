@extends('layouts.app')

@section('content')
	<div class="faq">
		<div class="container">
			<h2 class="head text-center">Contact</h2>
			<div class="row">
				<form id="formMessage" method="post" action="#">
					@csrf
					<div class="col-md-12">
	                    <div class="form-group">
	                        <label class="control-label">
	                        	<strong style="font-size: 20px;">Name</strong>
	                        </label>
	                        
	                        <input type="text" id="name" name="name" class="form-control" placeholder="Who Are You ?">
	                        <span class="help-block"></span>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label">
	                        	<strong style="font-size: 20px;">Email</strong>
	                        </label>
	                        
	                        <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com">
	                        <span class="help-block"></span>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label">
	                        	<strong style="font-size: 20px;">Phone</strong>
	                        </label>
	                        
	                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number">
	                        <span class="help-block"></span>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label">
	                        	<strong style="font-size: 20px;">Message</strong>
	                        </label>
	                        
	                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="Your Message Goes Here ..."></textarea>
	                        <span class="help-block"></span>
	                    </div>
	                    <div class="form-group">
	                    	<button class="col-md-1 btn btn-warning pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
	                    		<i class="fa fa-envelope"></i> Send
	                    	</button>
	                    </div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js')
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

	        $('#formMessage').submit(function (event) {
                $('#formMessage div.form-group').removeClass('has-error');
                $('#formMessage .help-block').empty();
        		event.preventDefault();
                $('#formMessage button[type=submit]').button('loading');

        		var formData = new FormData($("#formMessage")[0]);

        		$.ajax({
                    url: '{{ route("member.message.index") }}',
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
                        }
                        $('#formMessage button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formMessage').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formMessage input[name='" + data[key].name + "']").length )
                                    	elem = $("#formMessage input[name='" + data[key].name + "']");
                                    else if( $("#formMessage select[name='" + data[key].name + "']").length )
                                    	elem = $("#formMessage select[name='" + data[key].name + "']");
                                    else
                                    	elem = $("#formMessage textarea[name='" + data[key].name + "']");
                                    
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().addClass('has-error');
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
                        $('#formMessage button[type=submit]').button('reset');
                    }
                });
        	});
        });
    </script>
@endsection