@extends('layouts.admin')

@section('header')
	<h1>
		Owner
		<small>Details</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{ route('owners.index') }}">Owner</a></li>
		<li class="active">Owner Details</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-4">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Profile Owner</h3>
				</div>
				<div class="box-body box-profile">
					@if ( $data->file_id != null )
						<img class="profile-user-img img-responsive" src="{{ asset('storage/'.$data->file->path) }}" alt="User profile picture" style="width: 150px; height: 150px;">
					@else
						<img class="profile-user-img img-responsive" src="{{ asset('images/avatar_default.png') }}" alt="User profile picture" style="width: 150px; height: 150px;">
					@endif

					<h3 class="profile-username text-center">{{ $data->name }}</h3>

					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>Email</b> <a class="pull-right">{{ $data->email }}</a>
						</li>
						<li class="list-group-item">
							<b>Phone</b>
							<a class="pull-right">
								@if ( $data->phone )
									{{ $data->phone }}
								@else
									-
								@endif
							</a>
						</li>
						<li class="list-group-item">
							<b>Register Date</b>
							<a class="pull-right">
								@if ( $data->created_at )
									{!! date('d F Y', strtotime($data->created_at)); !!}
								@else
									-
								@endif
							</a>
						</li>
						<li class="list-group-item">
							<b>Status</b> 
							<a class="pull-right">
								@if ( $data->status == App\Models\User::STATUS_UNCONFIRM )
									<span class="label label-warning">{{ $data->status }}</span>
								@elseif ( $data->status == App\Models\User::STATUS_CONFIRM )
									<span class="label label-primary">{{ $data->status }}</span>
								@else
									<span class="label label-danger">{{ $data->status }}</span>
								@endif
							</a>
						</li>
					</ul>
				</div>
				<div class="box-footer">
					<a href="{{ route('owners.index') }}" class="btn btn-warning"><i class="fa fa-mail-reply"></i> Back</a>

					@if ( $data->status == App\Models\User::STATUS_CONFIRM )
						<button id="btnNotActive" class="btn btn-danger pull-right"><i class="fa fa-power-off"></i> Not Active</button>
					@else
						&nbsp;
					@endif
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Biodata Owner</h3>
				</div>
				<div class="box-body box-profile">
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>Birthdate : </b>
							<a>
								@if ( $data->birthdate != null )
									{!! date('d F Y', strtotime($data->birthdate)); !!}
								@else
									-
								@endif
							</a>
						</li>
						<li class="list-group-item">
							<b>Birthplace : </b>
							<a>
								@if ( $data->birthplace != null )
									{{ $data->birthplace }}
								@else
									-
								@endif
							</a>
						</li>
						<li class="list-group-item">
							<b>Age : </b>
							<a>
								@if ( $data->age != null )
									{{ $data->age }}
								@else
									-
								@endif
							</a>
						</li>
						{{-- <li class="list-group-item">
							<b>Religion : </b> 
							<a>
								@if ( $data->religion != null )
									{{ $data->religion }}
								@else
									-
								@endif
							</a>
						</li> --}}
						<li class="list-group-item">
							<b>Gender : </b> 
							<a>
								@if ( $data->gender != null )
									{{ $data->gender }}
								@else
									-
								@endif
							</a>
						</li>
						<li class="list-group-item">
							<b>Address : </b>
							<a>
								@if ( $data->address != null )
									{{ $data->address }}
								@else
									-
								@endif
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	@if( $data->identity_card != null )
	<div class="row">
		<div class="col-md-4">
			<div class="box box-warning">
				<div class="box-header">
					<h3 class="box-title">Identity Card Member</h3>
				</div>
				<div class="box-body box-profile">
					@if ( $data->identity_card->file_id != null )
						<img class="profile-user-img img-responsive" src="{{ asset('storage/'.$data->identity_card->file->path) }}" alt="User profile picture" style="width: 150px; height: 150px;">
					@else
						<img class="profile-user-img img-responsive" src="{{ asset('images/ktp_default.png') }}" alt="User profile picture" style="width: 150px; height: 150px;">
					@endif
						
					<br>

					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>Number</b>
							<a class="pull-right">
								@if ( $data->identity_card->number )
									{{ $data->identity_card->number }}
								@else
									-
								@endif
							</a>
						</li>
						<li class="list-group-item">
							<b>Note</b>
							<a class="pull-right">
								@if ( $data->identity_card->note )
									{{ $data->identity_card->note }}
								@else
									-
								@endif
							</a>
						</li>
						<li class="list-group-item">
							<b>Status</b>
							<a class="pull-right">
								@if ( $data->identity_card->status )
									@if( $data->identity_card->status == \App\Models\IdentityCard::STATUS_PENDING )
										<span class="label label-warning">{{ $data->identity_card->status }}</span>
									@elseif( $data->identity_card->status == \App\Models\IdentityCard::STATUS_APPROVED )
										<span class="label label-success">{{ $data->identity_card->status }}</span>
									@else
										<span class="label label-danger">{{ $data->identity_card->status }}</span>
									@endif
								@else
									-
								@endif
							</a>
						</li>
					</ul>
				</div>
				@if( $data->identity_card->status == \App\Models\IdentityCard::STATUS_PENDING )
					<div class="box-footer">
						<button id="btnApprove" class="btn btn-success pull-right">Approve</button>
						<button id="btnReject" class="btn btn-danger pull-left">Reject</button>
					</div>
				@endif
			</div>
		</div>
	</div>
	@endif

	<!-- Modal Status -->
    <div class="modal fade" tabindex="-1" role="dialog" id="statusModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formStatus">
                	<input type="hidden" name="id" id="id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <p id="info"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Yes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Approve -->
    <div class="modal fade" tabindex="-1" role="dialog" id="approveModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formApprove">
                	<input type="hidden" name="approve_id" id="approve_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <p id="info"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Yes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div class="modal fade" tabindex="-1" role="dialog" id="rejectModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formReject">
                	<input type="hidden" name="approve_id" id="approve_id" value="{{ $data->id }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <p id="info"></p>

                        <textarea name="note" id="note" class="form-control" placeholder="Note" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Yes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
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

	        $('#btnReject').click(function () {
                $('#formReject')[0].reset();
                $('#formReject .modal-title').text("Reject Identity Card");
                $('#formReject #info').text("Are you sure you want to Reject Identity Card");

                $('#formReject div.form-group').removeClass('has-error');
                $('#formReject .help-block').empty();
                $('#formReject button[type=submit]').button('reset');

                $('#rejectModal').modal('show');
            });

            $('#formReject').submit(function (event) {
                event.preventDefault();
                $('#formReject button[type=submit]').button('loading');
                $('#formReject div.form-group').removeClass('has-error');
                $('#formReject .help-block').empty();

                var _data = $("#formReject").serialize();
                $.ajax({
                    url: "{{ route('owners.reject') }}",
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

	                        $('#rejectModal').modal('hide');
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
                        
                        $('#formReject button[type=submit]').button('reset');
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
                        $('#formReject button[type=submit]').button('reset');
                    }
                });
            });

	        $('#btnApprove').click(function () {
                $('#formApprove')[0].reset();
                $('#formApprove .modal-title').text("Approve Identity Card");
                $('#formApprove #info').text("Are you sure you want to Approve Identity Card");

                $('#formApprove div.form-group').removeClass('has-error');
                $('#formApprove .help-block').empty();
                $('#formApprove button[type=submit]').button('reset');

                $('#approveModal').modal('show');
            });

            $('#formApprove').submit(function (event) {
                event.preventDefault();
                $('#formApprove button[type=submit]').button('loading');
                $('#formApprove div.form-group').removeClass('has-error');
                $('#formApprove .help-block').empty();

                var _data = $("#formApprove").serialize();
                $.ajax({
                    url: "{{ route('owners.approve') }}",
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

	                        $('#approveModal').modal('hide');
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
                        
                        $('#formApprove button[type=submit]').button('reset');
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
                        $('#formApprove button[type=submit]').button('reset');
                    }
                });
            });

	        $('#btnNotActive').click(function () {
                $('#formStatus')[0].reset();
                $('#formStatus .modal-title').text("Not Active Owner");
                $('#formStatus #info').text("Are you sure you want to Not Active Owner");

                $('#formStatus div.form-group').removeClass('has-error');
                $('#formStatus .help-block').empty();
                $('#formStatus button[type=submit]').button('reset');

                $('#statusModal').modal('show');
            });

            $('#formStatus').submit(function (event) {
                event.preventDefault();
                $('#formStatus button[type=submit]').button('loading');
                $('#formStatus div.form-group').removeClass('has-error');
                $('#formStatus .help-block').empty();

                var _data = $("#formStatus").serialize();
                $.ajax({
                    url: "{{ route('owners.not_active') }}",
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

	                        $('#statusModal').modal('hide');
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
                        
                        $('#formStatus button[type=submit]').button('reset');
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
                        $('#formStatus button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection