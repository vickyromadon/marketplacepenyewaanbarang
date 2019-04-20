@extends('layouts.admin')

@section('header')
	<h1>
		Faq
		<small>List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">FAQ</li>
	</ol>
@endsection

@section('content')
	<div class="box box-warning">
        <div class="box-header with-border">
        	<h3 class="box-title"><i class="fa fa-question"></i> FAQ</h3>
            <button id="btnAdd" class="pull-right btn btn-primary"><i class="fa fa-plus"></i> Add</button>
        </div>
       
        <div class="box-body">
            <div class="table-responsive">
                <table id="faq_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- add and edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="faqModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="post" id="formFaq">
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
                                <label class="col-sm-3 control-label">Question</label>
                                
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="question" id="question" cols="30" rows="" placeholder="Question fill here ..."></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Answer</label>
                                
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="answer" id="answer" cols="30" rows="" placeholder="Question fill here ..."></textarea>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteFaqModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('faq.destroy', ['faq' => '#']) }}" method="post" id="formDeleteFaq">
                	{{ method_field('DELETE') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete FAQ</h4>
                    </div>

                    <div class="modal-body">
                        <p id="del-success">Are you sure you want to remove FAQ ?</p>
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

	        var table = $('#faq_table').DataTable({
                "bFilter": true,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('faq.index') }}",
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
                        "data": "question",
                        render: function (data, type, row) {
                        	if( data.length > 65 )
                           		return data.substring(0, 65) + '...';
                           	else
                           		return data;

                       	},
                        "orderable": true,
                    },
                    {
                        "data": "answer",
                        render: function (data, type, row) {
                           	if( data.length > 65 )
                           		return data.substring(0, 65) + '...';
                           	else
                           		return data;
                       	},
                        "orderable": true,
                    },
                    {
                        render : function(data, type, row){
                            return	'<a href="{{ route('faq.index') }}/'+ row.id +'" class="view-btn btn btn-xs btn-primary"><i class="fa fa-eye"> view</i></a> &nbsp' +
                            		'<a href="#" class="edit-btn btn btn-xs btn-warning"><i class="fa fa-pencil"> Edit</i></a> &nbsp' +
                                	'<a href="#" class="delete-btn btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
                        },
                        "width": "20%",
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
                $('#formFaq')[0].reset();
                $('#formFaq .modal-title').text("Add Faq");
                $('#formFaq div.form-group').removeClass('has-error');
                $('#formFaq .help-block').empty();
                $('#formFaq button[type=submit]').button('reset');

                $('#formFaq input[name="_method"]').remove();
                url = '{{ route("faq.store") }}';

                $('#faqModal').modal('show');
            });

            // Edit
            $('#faq_table').on('click', '.edit-btn', function(e){
                $('#formFaq div.form-group').removeClass('has-error');
                $('#formFaq .help-block').empty();
                $('#formFaq .modal-title').text("Edit Faq");
                $('#formFaq')[0].reset();
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                $('#formFaq button[type=submit]').button('reset');

                $('#formFaq .modal-body .form-horizontal').append('<input type="hidden" name="_method" value="PUT">');
                url = '{{ route("faq.index") }}' + '/' + aData.id;

                $('#id').val(aData.id);
                $('#question').val(aData.question);
                $('#answer').val(aData.answer);  

                $('#faqModal').modal('show');              

            });

            $('#formFaq').submit(function (event) {
                event.preventDefault();
                $('#formFaq button[type=submit]').button('loading');
                $('#formFaq div.form-group').removeClass('has-error');
                $('#formFaq .help-block').empty();

                var _data = $("#formFaq").serialize();
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

                            $('#faqModal').modal('hide');
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
                        $('#formFaq button[type=submit]').button('reset');
                    },

                    error: function(response){
                        if (response.status === 422) {
                            // form validation errors fired up
                            var error = response.responseJSON.errors;
                            var data = $('#formFaq').serializeArray();
                            $.each(data, function(key, value){
                                if( error[data[key].name] != undefined ){
                                    var elem = $("#formFaq input[name='" + data[key].name + "']").length ? $("#formFaq input[name='" + data[key].name + "']") : $("#formFaq textarea[name='" + data[key].name + "']");
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
                        $('#formFaq button[type=submit]').button('reset');
                    }
                });
            });

			// Delete
            $('#faq_table').on('click', '.delete-btn' , function(e){
                var aData = JSON.parse($(this).parent().parent().attr('data'));
                url =  $('#formDeleteFaq').attr('action').replace('#', aData.id);
                $('#deleteFaqModal').modal('show');
            });

            $('#formDeleteFaq').submit(function (event) {
                event.preventDefault();               

                $('#deleteFaqModal button[type=submit]').button('loading');
                var _data = $("#formDeleteFaq").serialize();

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

                            $('#deleteFaqModal').modal('toggle');
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
                        $('#deleteFaqModal button[type=submit]').button('reset');
                        $('#formDeleteFaq')[0].reset();
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

                        $('#formDeleteFaq button[type=submit]').button('reset');
                    }
                });
            });
	    });
	</script>
@endsection