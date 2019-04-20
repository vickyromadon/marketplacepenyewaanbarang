@extends('layouts.app')

@section('css')
	<style>
		.border{
			border: 1px solid #d3d3d3;
			padding: 10px;
			margin-bottom: 10px;
		}

		.imgProfile{
			width: 200px;
			height: 200px;
			margin: auto;
			margin-bottom: 5px;
		}

		.imageProfile{
			width: 100%;
			height: 100%;
		}

		.headerText{
			font-size: 15px;
			font-weight: bold;
		}

		.isiText{
			font-size: 15px;
			text-align: right;
		}

		.nav-tabs-custom{
			border:1px solid #d3d3d3;
		}
	</style>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="border">
					<div class="row">
						<center><h2>Profil Data</h2></center>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="imgProfile">
								@if ( $data->file != null )
									<img class="img-thumbnail img-responsive imageProfile" src="{{ asset('storage/'. $data->file->path)}}">
								@else
									<img class="img-thumbnail img-responsive imageProfile" src="{{ asset('images/avatar_default.png') }}">
								@endif
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-5">
							<p class="headerText">Nama</p>
							<p class="headerText">Email</p>
							<p class="headerText">Phone</p>
							<p class="headerText">Umur</p>
							{{-- <p class="headerText">Religion</p> --}}
							<p class="headerText">Jenis Kelamin</p>
							<p class="headerText">Tempat Lahir</p>
							<p class="headerText">Tanggal Lahir</p>
							<p class="headerText">Status</p>
						</div>
						<div class="col-md-7">
							<p class="isiText">{{ $data->name }}</p>
							<p class="isiText">{{ $data->email }}</p>
							<p class="isiText">{{ $data->phone != null ? $data->phone : '-' }}</p>
							<p class="isiText">{{ $data->age != null ? $data->age : '-' }}</p>
							{{-- <p class="isiText">{{ $data->religion != null ? $data->religion : '-' }}</p> --}}
							<p class="isiText">{{ $data->gender != null ? $data->gender : '-' }}</p>
							<p class="isiText">{{ $data->birthplace != null ? $data->birthplace : '-' }}</p>
							<p class="isiText">{{ $data->birthdate != null ? date('d F Y', strtotime($data->birthdate)) : '-' }}</p>
							<p class="isiText">
								@if( $data->status == App\Models\User::STATUS_NOT_ACTIVE )
									<span class="label label-danger">{{ $data->status }}</span>
								@elseif( $data->status == App\Models\User::STATUS_CONFIRM )
									<span class="label label-info">{{ $data->status }}</span>
								@else
									<span class="label label-warning">{{ $data->status }}</span>
								@endif
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#settings" data-toggle="tab">Pengaturan</a></li>
						<li><a href="#password" data-toggle="tab">Ubah Password</a></li>
	                    <li><a href="#avatar" data-toggle="tab">Ubah Foto Profil</a></li>
	                    <li><a href="#bank" data-toggle="tab">Ubah Bank</a></li>
	                    <li><a href="#identity_card" data-toggle="tab">Kartu Identitas</a></li>
					</ul>
					<div class="tab-content">
						
						<!-- setting -->
						<div class="active tab-pane" id="settings">
							<form class="form-horizontal" method="POST" id="formSetting">
								@csrf
								<div class="form-group">
									<label class="col-sm-3 control-label">Nama</label>

									<div class="col-sm-9">
										<input type="text" class="form-control" id="name" name="name" placeholder="Nama">
										
										<span class="help-block"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Phone</label>

									<div class="col-sm-9">
										<input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Phone">
										
										<span class="help-block"></span>
									</div>
								</div>
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label">Alamat</label>

	                                <div class="col-sm-9">
	                                    <textarea name="address" id="address" class="form-control" placeholder="Alamat"></textarea>
	                                    
	                                    <span class="help-block"></span>
	                                </div>
	                            </div>
	                            {{-- <div class="form-group">
	                                <label class="col-sm-3 control-label">
	                                    Age
	                                </label>
	                                <div class="col-sm-9">
	                                    <input type="number" class="form-control" id="age" name="age" min="0" max="100" placeholder="Age">
	                                </div>
	                            </div> --}}
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label">
	                                    Tempat / Tanggal Lahir
	                                </label>
	                                <div class="col-sm-5">
	                                    <input type="text" id="birthplace" name="birthplace" class="form-control" placeholder="Tempat Lahir">

	                                    <span class="help-block"></span>
	                                </div>
	                                <div class="col-sm-4">
	                                    <div class="input-group date">
	                                        <div class="input-group-addon">
	                                            <i class="fa fa-calendar"></i>
	                                        </div>
	                                        <input type="text" class="form-control" name="birthdate" id="birthdate" placeholder="Tanggal Lahir">
	                                        <span id="birthdate" class="help-block"></span>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label">
	                                    Jenis Kelamin
	                                </label>
	                                <div class="col-sm-9">
	                                    <label class="radio-inline">
	                                        <input type="radio" id="gender_lk" name="gender" value="Male" checked>Laki - Laki
	                                    </label>
	                                    <label class="radio-inline">
	                                        <input type="radio" id="gender_pr" name="gender" value="Female">Perempuan
	                                    </label>

	                                    <span id="error_gender" class="help-block"></span>
	                                </div>
	                            </div>
	                            {{-- <div class="form-group">
	                                <label class="col-sm-3 control-label">
	                                    Religion
	                                </label>
	                                <div class="col-sm-9">
	                                    <select class="form-control" id="religion" name="religion">
	                                        <option value="">-- Select One --</option>
	                                        <option value="Islam">Islam</option>
	                                        <option value="Kristen Protestan">Kristen Protestan</option>
	                                        <option value="Katolik">Katolik</option>
	                                        <option value="Hindu">Hindu</option>
	                                        <option value="Buddha">Buddha</option>
	                                        <option value="Kong Hu Cu">Kong Hu Cu</option>
	                                    </select>

	                                    <span id="error_religion" class="help-block"></span>
	                                </div>
	                            </div> --}}
								<div class="form-group">
				                    <div class="col-sm-offset-3 col-sm-9">
				                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
				                    </div>
			                  	</div>
							</form>
						</div>

						<!-- password -->
						<div class="tab-pane" id="password">
							<form class="form-horizontal" method="POST" id="formPassword">
								@csrf
								<div class="form-group">
									<label class="col-sm-3 control-label">Password Lama</label>
									<div class="col-sm-9">
										<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password Lama">

										<span class="help-block"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Password Baru</label>

									<div class="col-sm-9">
										<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password Baru">

										<span class="help-block"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Konfirmasi Password</label>

									<div class="col-sm-9">
										<input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="Konfirmasi Password">

										<span class="help-block"></span>
									</div>
								</div>
								
								<div class="form-group">
				                    <div class="col-sm-offset-3 col-sm-9">
				                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
				                    </div>
			                  	</div>
							</form>
						</div>
						
						<!-- avatar -->
	                    <div class="tab-pane" id="avatar">
	                        <form class="form-horizontal" method="POST" id="formAvatar">
	                        	@csrf
	                            <div class="form-group">
	                                <label class="col-sm-3 control-label">Foto Profil</label>
	                                
	                                <div class="col-sm-9 fileinput fileinput-new" data-provides="fileinput">
	                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
	                                        <img id="img-upload" src="{{ asset('images/avatar_default.png') }}" style="width: 200px; height: 150px;">
	                                    </div>
	                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
	                                    <div>
	                                        <span class="btn btn-default btn-file">
	                                            <span class="fileinput-new">Pilih gambar</span>
	                                            <span class="fileinput-exists">Ubah</span>
	                                            <input type="file" id="file_id" name="file_id">
	                                        </span>
	                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
	                                            Hapus
	                                        </a>
	                                    </div>
	                                    <span class="help-block"></span>
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <div class="col-sm-offset-3 col-sm-9">
	                                    <button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
	                                </div>
	                            </div>
	                        </form>
	                    </div>

	                    <!-- bank -->
						<div class="tab-pane" id="bank">
							<form class="form-horizontal" method="POST" id="formBank">
								@csrf
								<input type="hidden" id="bank_id" name="bank_id">
								<div class="form-group">
									<label class="col-sm-3 control-label">Nama Bank</label>
									<div class="col-sm-9">
										<select name="bank_name" id="bank_name" class="form-control" required>
											<option value="">-- Pilih Salah Satu --</option>
											<option value="BNI">BNI</option>
											<option value="BRI">BRI</option>
											<option value="Mandiri">Mandiri</option>
											<option value="BCA">BCA</option>
											<option value="Maybank">Maybank</option>
											<option value="Syariah Mandiri">Syariah Mandiri</option>
											<option value="SUMUT">SUMUT</option>
											<option value="BTPN">BTPN</option>
											<option value="CIMB Niaga">CIMB Niaga</option>
											<option value="Sinarmas">Sinarmas</option>
											<option value="Mega">Mega</option>
										</select>

										<span class="help-block"></span> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Nama Akun</label>

									<div class="col-sm-9">
										<input type="text" class="form-control" id="account_name" name="account_name" placeholder="Nama Akun">

										<span class="help-block"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Nomor Akun</label>

									<div class="col-sm-9">
										<input type="text" class="form-control" id="account_number" name="account_number" placeholder="Nomor Akun">

										<span class="help-block"></span>
									</div>
								</div>
								
								<div class="form-group">
				                    <div class="col-sm-offset-3 col-sm-9">
				                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
				                    </div>
			                  	</div>
							</form>
						</div>

						<!-- identity card -->
						<div class="tab-pane" id="identity_card">
							<form class="form-horizontal" method="POST" id="formIdentityCard">
								@csrf
								<input type="hidden" id="identity_card_id" name="identity_card_id" value="{{ $data->identity_card_id != null ? $data->identity_card_id : '' }}">
								<div class="form-group">
									<label class="col-sm-3 control-label">NIK</label>

									<div class="col-sm-9">
										<input type="text" class="form-control" id="number" name="number" placeholder="NIK" value="{{ $data->identity_card != null ? $data->identity_card->number : '' }}">

										<span class="help-block"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">File Kartu Identitas</label>

									<div class="col-sm-9">
										<input type="file" class="form-control" id="file_identity_card" name="file_identity_card">

										<span class="help-block"></span>
									</div>
								</div>
								<div class="form-group">
				                    <div class="col-sm-offset-3 col-sm-9">
				                      	<button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button>
				                    </div>
			                  	</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="border">
					<div class="row">
						<center><h2>Data Kartu Identitas</h2></center>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="imgProfile">
								@if ( $data->identity_card != null )
									<img class="img-thumbnail img-responsive imageProfile" src="{{ asset('storage/'. $data->identity_card->file->path)}}">
								@else
									<img class="img-thumbnail img-responsive imageProfile" src="{{ asset('images/ktp_default.png') }}">
								@endif
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-4">
							<p class="headerText">NIK</p>
							<p class="headerText">Status</p>
							<p class="headerText">Catatan</p>
						</div>
						<div class="col-md-8">
							<p class="isiText">{{ $data->identity_card != null ? $data->identity_card->number : '-' }}</p>

							@if( $data->identity_card != null )
								@if( $data->identity_card->status == \App\Models\IdentityCard::STATUS_PENDING )
									<p class="isiText">
										<span class="label label-warning">Menunggu</span>
									</p>
								@elseif( $data->identity_card->status == \App\Models\IdentityCard::STATUS_APPROVED )
									<p class="isiText">
										<span class="label label-success">Disetujui</span>
									</p>
								@else
									<p class="isiText">
										<span class="label label-danger">Ditolak</span>
									</p>
								@endif
							@else
								<p class="isiText">-</p>
							@endif

							<p class="isiText">{{ $data->identity_card != null ? $data->identity_card->note : '-' }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>

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

			$('#formBank #bank_id').val("{{ $bank != null ? $bank->id : ''}}");
			$('#formBank #bank_name').val("{{ $bank != null ? $bank->name : ''}}");            
			$('#formBank #account_name').val("{{ $bank != null ? $bank->owner : ''}}");
			$('#formBank #account_number').val("{{ $bank != null ? $bank->number : ''}}");

			$('#formBank').submit(function (event) {
    			event.preventDefault();
    		 	$('#formBank button[type=submit]').button('loading');
    			$('#formBank div.form-group').removeClass('has-error');
    	        $('#formBank .help-block').empty();

    		 	var _data = $("#formBank").serialize();

    		 	$.ajax({
                    url: "{{ route('member.profile.bank', ['id' => $data->id]) }}",
                    method: 'POST',
                    data: _data,
                    cache: false,

                    success: function (response) {
                        if ( response.success ) {
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
                        else{
                        	$.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formBank button[type=submit]').button('reset');
                        $('#formBank')[0].reset();
                    },

    					error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formBank').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formBank input[name='" + data[key].name + "']").length ? $("#formBank input[name='" + data[key].name + "']") : $("#formBank select[name='" + data[key].name + "']");
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
                        $('#formBank button[type=submit]').button('reset');
                	}
                });
    		});            

            $('#formSetting #name').val("{{ $data->name }}");
            $('#formSetting #phone').val("{{ $data->phone }}");
            $('#formSetting #address').val("{{ $data->address }}");
            $('#formSetting #birthplace').val("{{ $data->birthplace }}");
            $('#formSetting #birthdate').val("{{ $data->birthdate }}");
            $('#formSetting #age').val("{{ $data->age }}");
            if( "{{ $data->gender }}" === "Male" )
                $('#gender_lk').prop("checked", true);
            else
                $('#gender_pr').prop("checked", true);
            // $('#formSetting #religion').val("{{ $data->religion }}");

            @if ( $data->file_id != null )
                $('#formAvatar #img-upload').attr('src', "{{ asset('storage/'. $data->file->path)}}");
            @endif

            // Submit Form setting
           	$('#formSetting').submit(function (event) {
                event.preventDefault();
    		 	$('#formSetting button[type=submit]').button('loading');
    		 	$('#formSetting div.form-group').removeClass('has-error');
    	        $('#formSetting .help-block').empty();

    		 	var _data = $("#formSetting").serialize();

    		 	$.ajax({
                    url: "{{ route('member.profile.setting', ['id' => $data->id]) }}",
                    method: 'POST',
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

                            setTimeout(function () { 
                                location.reload();
                            }, 2000);
                        } else {
                            $.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formSetting')[0].reset();
                        $('#formSetting button[type=submit]').button('reset');
                    },
                    error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formSetting').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem;
                                    if( $("#formSetting input[name='" + data[key].name + "']").length )
                                    	elem = $("#formSetting input[name='" + data[key].name + "']");
                                    else if( $("#formSetting textarea[name='" + data[key].name + "']").length )
                                    	elem = $("#formSetting textarea[name='" + data[key].name + "']");
                                    else
                                    	elem = $("#formSetting select[name='" + data[key].name + "']");
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
                        $('#formSetting button[type=submit]').button('reset');
                    }
                });
    		});

    		$('#formPassword').submit(function (event) {
    			event.preventDefault();
    		 	$('#formPassword button[type=submit]').button('loading');
    			$('#formPassword div.form-group').removeClass('has-error');
    	        $('#formPassword .help-block').empty();

    		 	var _data = $("#formPassword").serialize();

    		 	$.ajax({
                    url: "{{ route('member.profile.password', ['id' => $data->id]) }}",
                    method: 'POST',
                    data: _data,
                    cache: false,

                    success: function (response) {
                        if ( response.success ) {
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
                        else{
                        	$.toast({
                                heading: 'Error',
                                text : response.message,
                                position : 'top-right',
                                allowToastClose : true,
                                showHideTransition : 'fade',
                                icon : 'error',
                                loader : false,
                                hideAfter: 5000
                            });
                        }

                        $('#formPassword button[type=submit]').button('reset');
                        $('#formPassword')[0].reset();
                    },

    					error: function(response){
                    	if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formPassword').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formPassword input[name='" + data[key].name + "']").length ? $("#formPassword input[name='" + data[key].name + "']") : $("#formPassword select[name='" + data[key].name + "']");
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
                        $('#formPassword button[type=submit]').button('reset');
                	}
                });
    		});

            $('#formAvatar').submit(function (event) {
                event.preventDefault();
                $('#formAvatar button[type=submit]').button('loading');
                $('#formAvatar div.form-group').removeClass('has-error');
                $('#formAvatar .help-block').empty();

                var formData = new FormData($("#formAvatar")[0]);

                $.ajax({
                    url: "{{ route('member.profile.avatar', ['id' => $data->id]) }}",
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
                        $('#formAvatar button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            if(error['file_id'] != undefined){
                                $("#formAvatar input[name='file_id']").parent().parent().parent().find('.help-block').text(error['file_id']);
                                $("#formAvatar input[name='file_id']").parent().parent().parent().find('.help-block').show();
                                $("#formAvatar input[name='file_id']").parent().parent().parent().parent().addClass('has-error');
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
                        $('#formAvatar button[type=submit]').button('reset');
                    }
                });
            });

			$('#formIdentityCard').submit(function (event) {
                event.preventDefault();
                $('#formIdentityCard button[type=submit]').button('loading');
                $('#formIdentityCard div.form-group').removeClass('has-error');
                $('#formIdentityCard .help-block').empty();

                var formData = new FormData($("#formIdentityCard")[0]);

                $.ajax({
                    url: "{{ route('member.profile.identity_card', ['id' => $data->id]) }}",
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
                        $('#formIdentityCard button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formIdentityCard').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formIdentityCard input[name='" + data[key].name + "']").length ? $("#formIdentityCard input[name='" + data[key].name + "']") : $("#formIdentityCard file[name='" + data[key].name + "']");
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
                        $('#formIdentityCard button[type=submit]').button('reset');
                    }
                });
            });

			//Date picker
	        $('#birthdate').datepicker({
	            autoclose: true,
	            format: 'yyyy-mm-dd',
	            endDate: '+1d',
	            datesDisabled: '+1d',
	        });
	    });
	</script>
@endsection