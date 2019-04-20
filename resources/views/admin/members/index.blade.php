@extends('layouts.admin')

@section('header')
	<h1>
		Member
		<small>List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Member</li>
	</ol>
@endsection

@section('content')
	<div class="box box-warning">
        <div class="box-header with-border">
        	<h3 class="box-title"><i class="fa fa-circle-o"></i> Member</h3>
        </div>
       
        <div class="box-body">
            <div class="table-responsive">
                <table id="member_table" class="table table-striped table-bordered table-hover nowrap dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registrasi Date</th>
                            <th>Status</th>
                            <th>Status Identity Card</th>
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

	        var table = $('#member_table').DataTable({
	            "bFilter": true,
	            "processing": true,
	            "serverSide": true,
	            "lengthChange": true,
	            "ajax": {
	                "url": "{{ route('members.index') }}",
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
	                    "data": "email",
	                    "orderable": true,
	                },
	                {
	                    "data": "phone",
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
	                  		if( row.status == '{{ \App\Models\User::STATUS_UNCONFIRM }}' )
	                  			return '<span class="label label-warning">'+ row.status +'</span>';
	                  		else if( row.status == '{{ \App\Models\User::STATUS_CONFIRM }}' )
	                  			return '<span class="label label-primary">'+ row.status +'</span>';
	                  		else
	                  			return '<span class="label label-danger">'+ row.status +'</span>';
	                  	},
	                    "orderable": false,  
	                },
	                {
	                  	render : function(data, type, row){
	                  		if ( row.identity_card_id != null ) {
	                  			if ( row.identity_card.status == '{{ \App\Models\IdentityCard::STATUS_PENDING }}' ) 
	                  				return '<span class="label label-warning">'+ row.identity_card.status +'</span>';
	                  			else if ( row.identity_card.status == '{{ \App\Models\IdentityCard::STATUS_APPROVED }}' )
	                  				return '<span class="label label-success">'+ row.identity_card.status +'</span>';
	                  			else
	                  				return '<span class="label label-danger">'+ row.identity_card.status +'</span>';
	                  		}
	                  		else{
	                  			return '<span class="label label-default">Not Yet Uploaded</span>';
	                  		}

	                  	},
	                    "orderable": false,
	                },
	                {
	                    render : function(data, type, row){
	                        return	'<a href="{{ route('members.index') }}/'+ row.id +'" class="view-btn btn btn-xs btn-primary"><i class="fa fa-eye"> view</i></a>';
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
	    });
	</script>
@endsection