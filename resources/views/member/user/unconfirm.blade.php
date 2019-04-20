@extends('layouts.app')

@section('content')
	<div class="work-section">
		<div class="container">
			<h2 class="head text-center">Hi, {{ Auth::user()->name }}</h2>
		</div>
		<div class="row">
			<div class="col-md-12" style="padding: 0px 50px; text-align: center;">
				@if ( $action == 'unconfirm' )
					<p>Your account is still not active yet,</p>
					<p>Please check your mail or if you don't receive confirmation email click button below to resend it.</p>
				@elseif($action == "resend_success")
					<p><b>Resend Email Success</b></p>
					<p>Please check your email and confirm your email.</p>
				@endif

				@if ( $action == 'unconfirm' )
					<a href="/user/unconfirm/resend" id="btnResend" data-loading-text="<i class='fa fa-spinner'></i>" class="btn btn-success" style="margin: 10px 0px;">
	                    RESEND CONFIRMATION MAIL
	                </a>
				@endif
				
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

	        $('#formResend').submit(function (event) {
	        	event.preventDefault();

	        	var _data = $("#formResend").serialize();
	        	
	        	var $this = $('#btnResend');
                $this.button('loading');

                var loader = setTimeout(function () {
                    $this.button('reset');
                }, 2000000000);

	        	$.ajax({
                    url: "/mail-confirmation/{{Auth::user()['confirmation_link']}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        clearTimeout(loader, 0);
                        $this.button('reset');
                        $this.html('RESEND CONFIRMATION MAIL');

                        toastr.success(data.msg);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        clearTimeout(loader, 0);
                        $this.button('reset');
                        $this.html('RESEND CONFIRMATION MAIL');
                        console.log(XMLHttpRequest.status, textStatus, errorThrown)
                    }
                });

                return false;
	        });
        });
    </script>
@endsection