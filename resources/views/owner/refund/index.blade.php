@extends('layouts.owner')

@section('header')
	<h1>
		Refund
		<small>List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Refund</li>
	</ol>
@endsection

@section('content')
	<div class="box box-danger">
        <div class="box-header with-border">
        	<h3 class="box-title"><i class="fa fa fa-dollar"></i> Refund</h3>
        </div>
       
        <div class="box-body">
            <div class="table-responsive">
                <table id="refund_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Code Booking</th>
                            <th>Product Name</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
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

            var table = $('#refund_table').DataTable({
                "bFilter": false,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('owner.refund.index') }}",
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
                        "data": "code_booking",
                        "orderable": true,
                    },
                    {
                        "data": "product_name",
                        "orderable": true,
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
                            if( row.status == '{{ App\Models\Refund::STATUS_PENDING }}' )
                                return '<span class="label label-warning">'+ 'please refund' +'</span>';
                            else if( row.status == '{{ App\Models\Refund::STATUS_VERIFIED }}' )
                                return '<span class="label label-info">'+ 'waiting verify admin' +'</span>';
                            else
                                return '<span class="label label-success">'+ row.status +'</span>';
                        },
                        "orderable": false,
                    },
                    {
                        render : function(data, type, row){
                        	return	'<a href="{{ route('owner.refund.index') }}' + "/" + row.id + '" class="view-btn btn btn-xs btn-primary"><i class="fa fa-eye"> view</i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "order": [ 1, 'dsc' ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection