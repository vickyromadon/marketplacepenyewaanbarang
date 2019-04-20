@extends('layouts.admin')

@section('header')
	<h1>
		Sub Category
		<small>List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Sub Category</li>
	</ol>
@endsection

@section('content')
	<div class="box box-warning">
        <div class="box-header with-border">
        	<h3 class="box-title"><i class="fa fa-th-list"></i> Sub Category</h3>
            <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Add</button>
        </div>
       
        <div class="box-body">
            <div class="table-responsive">
                <table id="subcategory_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sub Category Name</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- add and edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="subCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formSubCategory">
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
                                <label class="col-sm-3 control-label">Category</label>
                                
                                <div class="col-sm-9">
                                    <select name="category" id="category" class="form-control">
                                    	<option value="">-- Select One --</option>
                                    	@foreach ($categories as $category)
                                    		<option value="{{ $category->id }}">{{ $category->name }}</option>
                                    	@endforeach
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                                                       
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sub Category</label>
                                
                                <div class="col-sm-9">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Sub Category" required>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteSubCategoryModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sub_category.destroy', ['category' => '#']) }}" method="post" id="formDeleteSubCategory">
                	{{ method_field('DELETE') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete Category</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Are you sure you want to remove Sub Category ?</p>
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

            var table = $('#subcategory_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('sub_category.index') }}",
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
                        render : function(data, type, row){
                        	return row.category.name;
                        },
                        "orderable": false,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="#" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"> Edit</i></a> &nbsp' +
                                	'<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 1, 'asc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });

            // add
            $('#btnAdd').click(function () {
                $('#formSubCategory')[0].reset();
                $('#formSubCategory .modal-title').text("Add Category");
                $('#formSubCategory div.form-group').removeClass('has-error');
                $('#formSubCategory .help-block').empty();
                $('#formSubCategory button[type=submit]').button('reset');

                $('#formSubCategory input[name="_method"]').remove();
                url = '{{ route("sub_category.store") }}';

                $('#subCategoryModal').modal('show');
            });

            // Edit
            $('#subcategory_table').on('click', '.edit-btn', function(e){

                $('#formSubCategory div.form-group').removeClass('has-error');
                $('#formSubCategory .help-block').empty();
                $('#formSubCategory .modal-title').text("Edit Category");
                $('#formSubCategory')[0].reset();
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                $('#formSubCategory button[type=submit]').button('reset');

                $('#formSubCategory .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("sub_category.index") }}' + '/' + aData.id;

                $('#id').val(aData.id);
                $('#name').val(aData.name);
                $('#category').val(aData.category_id);

                $('#subCategoryModal').modal('show');              

            });

            $('#formSubCategory').submit(function (event) {
                event.preventDefault();
                $('#formSubCategory button[type=submit]').button('loading');
                $('#formSubCategory div.form-group').removeClass('has-error');
                $('#formSubCategory .help-block').empty();

                var _data = $("#formSubCategory").serialize();
                $.ajax({
                    url: url,
                    type: 'POST',
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

                            $('#subCategoryModal').modal('hide');
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
                        $('#formSubCategory button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formSubCategory').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formSubCategory input[name='" + data[key].name + "']").length ? $("#formSubCategory input[name='" + data[key].name + "']") : $("#formSubCategory select[name='" + data[key].name + "']");
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
                        $('#formSubCategory button[type=submit]').button('reset');
                    }
                });
            });

			// Delete
            $('#subcategory_table').on('click', '.delete-btn' , function(e){
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                url =  $('#formDeleteSubCategory').attr('action').replace('#', aData.id);
                $('#deleteSubCategoryModal').modal('show');
            });

            $('#formDeleteSubCategory').submit(function (event) {
                event.preventDefault();               

                $('#deleteSubCategoryModal button[type=submit]').button('loading');
                var _data = $("#formDeleteSubCategory").serialize();

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

                            $('#deleteSubCategoryModal').modal('toggle');
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
                        $('#deleteSubCategoryModal button[type=submit]').button('reset');
                        $('#formDeleteSubCategory')[0].reset();
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

                        $('#formDeleteSubCategory button[type=submit]').button('reset');
                    }
                });
            });
        });
    </script>
@endsection