@extends('layouts.owner')

@section('header')
	<h1>
		Reversion
		<small>List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Reversion</li>
	</ol>
@endsection

@section('content')
	<div class="box box-danger">
        <div class="box-header with-border">
        	<h3 class="box-title"><i class="fa fa fa-fast-backward"></i> Reversion</h3>
        </div>
       
        <div class="box-body">
            <div class="table-responsive">
                <table id="reversion_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Code Booking</th>
                            <th>End Date Rental</th>
                            <th>Delivery Date</th>
                            <th>Arrive Date</th>
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

            var table = $('#reversion_table').DataTable({
                "bFilter": false,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": "{{ route('owner.reversion.index') }}",
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
                        render : function(data, type, row){
                            return row.delivery.transaction.booking.code;
                        },
                        "orderable": false,
                    },
                    {
                        render: function (data, type, row){
                            return moment(row.delivery.transaction.booking.end_rent, "YYYY-MM-DD").format("dddd, DD MMM YYYY");
                        },
                        "orderable": false,
                    },
                    {
                        "data": "delivery_date",
                        render: function (data, type, row){
                            return moment(data, "YYYY-MM-DD").format("dddd, DD MMM YYYY");
                        },
                        "orderable": false,
                    },
                    {
                        "data": "arrive_date",
                        render: function (data, type, row){
                            return moment(data, "YYYY-MM-DD").format("dddd, DD MMM YYYY");
                        },
                        "orderable": false,
                    },
                    {
                        render : function(data, type, row){
                            if( row.status == '{{ App\Models\Reversion::STATUS_PENDING }}' )
                                return '<span class="label label-warning">'+ 'please product delivery' +'</span>';
                            else if( row.status == '{{ App\Models\Reversion::STATUS_DELIVERED }}' )
                                return '<span class="label label-info">'+ 'waiting arrived' +'</span>';
                            else
                                return '<span class="label label-success">'+ 'product received' +'</span>';
                        },
                        "orderable": false,
                    },
                    {
                        render : function(data, type, row){
                        	return	'<a href="{{ route('owner.reversion.index') }}' + "/" + row.id + '" class="view-btn btn btn-xs btn-primary"><i class="fa fa-eye"> view</i></a>';
                        },
                        "width": "10%",
                        "orderable": false,
                    }
                ],
                "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data', JSON.stringify(aData));
                }
            });
        });
    </script>
@endsection