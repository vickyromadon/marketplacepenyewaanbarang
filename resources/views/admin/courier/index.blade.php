@extends('layouts.admin')

@section('header')
	<h1>
		Courier
		<small>List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Courier</li>
	</ol>
@endsection

@section('content')
	<div class="box box-warning">
        <div class="box-header with-border">
        	<h3 class="box-title"><i class="fa fa-truck"></i> Courier</h3>
            <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Add</button>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="courier_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Picture</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- add and edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="courierModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formCourier">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">
                        	<input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name Courier</label>
                                
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name Courier">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
			                	<label class="col-sm-3 control-label">
			                        Picture Courier
			                    </label>

			                    <div class="col-sm-9 fileinput fileinput-new" data-provides="fileinput">
			                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
			                            <img id="img-upload" src="{{ asset('images/default.jpg') }}" style="width: 200px; height: 150px;">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Back
                        </button>
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteCourierModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('courier.destroy', ['courier' => '#']) }}" method="post" id="formDeleteCourier">
                	{{ method_field('DELETE') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete Courier</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Are you sure you want to remove Courier ?</p>
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

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
@endsection

@section('js')
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

	        var table = $('#courier_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('courier.index') }}",
                    "type": "POST",
                    "data" : {}
                },
                "language": {
                    "emptyTable": "No data available",
                },
                "columns": [
                    {
                       data: null,
                       render: function (data, type, row, meta) {
                           return meta.row + meta.settings._iDisplayStart + 1;
                       },
                       "width": "20px",
                       "orderable": false,
                    },
                    {
                        "data": "name",
                        "orderable": true,
                    },
                    {
                        render: function (data, type, row) {
                        	return '<img src="{{ asset("storage") }}/'+ row.file.path +'" style="width:200px; height: 100px;" class="img-responsive">';
                       	},
                        "orderable": false,
                    },
                    {
                        "data": "created_at",
                        render: function (data, type, row){
                            return moment(data, "YYYY-MM-DD").format("dddd, DD MMM YYYY");
                        },
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="#" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"> Edit</i></a> &nbsp' +
                                	'<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
                        },
                        "width": "15%",
                        "orderable": false,
                    }
                ],
                "order": [ 1, 'asc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            var url;

	        // add
            $('#btnAdd').click(function () {
                $('#formCourier')[0].reset();
                $('#formCourier .modal-title').text("Add Courier");
                $('#formCourier div.form-group').removeClass('has-error');
                $('#formCourier .help-block').empty();
                $('#formCourier button[type=submit]').button('reset');

                $('#formCourier input[name="_method"]').remove();
                url = '{{ route("courier.store") }}';

                $('#courierModal').modal('show');
            });

            // Edit
            $('#courier_table').on('click', '.edit-btn', function(e){
                $('#formCourier div.form-group').removeClass('has-error');
                $('#formCourier .help-block').empty();
                $('#formCourier .modal-title').text("Edit Courier");
                $('#formCourier')[0].reset();
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                $('#formCourier button[type=submit]').button('reset');

                $('#formCourier .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("courier.index") }}' + '/' + aData.id;

                // console.log(aData)

                $('#id').val(aData.id);
                $('#name').val(aData.name);
                $('#img-upload').attr('src', "{{ asset('storage/')}}/" + aData.file.path);  

                $('#courierModal').modal('show');              

            });

            $('#formCourier').submit(function (event) {
                event.preventDefault();
                $('#formCourier button[type=submit]').button('loading');
                $('#formCourier div.form-group').removeClass('has-error');
                $('#formCourier .help-block').empty();

                var formData = new FormData($("#formCourier")[0]);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData : false,
                    contentType : false,   
                    cache: false,

                    success: function (response) {
                        if (response.success) {
                        	table.draw();

                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

                            $('#courierModal').modal('hide');
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
                        $('#formCourier button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formCourier').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formCourier input[name='" + data[key].name + "']").length ? $("#formCourier input[name='" + data[key].name + "']") : $("#formCourier textarea[name='" + data[key].name + "']");
                                    elem.parent().find('.help-block').text(error[data[key].name]);
                                    elem.parent().find('.help-block').show();
                                    elem.parent().parent().addClass('has-error');
                                }
                            });
                            if(error['file_id'] != undefined){
                                $("#formCourier input[name='file_id']").parent().parent().parent().find('.help-block').text(error['file_id']);
                                $("#formCourier input[name='file_id']").parent().parent().parent().find('.help-block').show();
                                $("#formCourier input[name='file_id']").parent().parent().parent().parent().addClass('has-error');
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
                        $('#formCourier button[type=submit]').button('reset');
                    }
                });
            });

			// Delete
            $('#courier_table').on('click', '.delete-btn' , function(e){
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                url =  $('#formDeleteCourier').attr('action').replace('#', aData.id);
                $('#deleteCourierModal').modal('show');
            });

            $('#formDeleteCourier').submit(function (event) {
                event.preventDefault();               

                $('#deleteCourierModal button[type=submit]').button('loading');
                var _data = $("#formDeleteCourier").serialize();

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: _data,
                    dataType: 'json',
                    cache: false,
                    
                    success: function (response) {
                        if (response.success) {
                            table.draw();
                                
                            $.toast({
	                            heading: 'Success',
	                            text : response.message,
	                            position : 'top-right',
	                            allowToastClose : true,
	                            showHideTransition : 'fade',
	                            icon : 'success',
	                            loader : false
	                        });

                            $('#deleteCourierModal').modal('toggle');
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
                        $('#deleteCourierModal button[type=submit]').button('reset');
                        $('#formDeleteCourier')[0].reset();
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

                        $('#formDeleteCourier button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection