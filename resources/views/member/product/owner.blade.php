@extends('layouts.app')

@section('content')
	{{-- BANNER --}}
	<div class="banner text-center">
        <div class="container">
            <h1>{{ $data->name }}</h1>
            @if( $data->file != null )
				<img src="{{ asset('storage/'.$data->file->path) }}" class="img-responsive img-thumbnail" style="width: 200px; height: 200px; border-radius: 50%; ">
			@else
				<img src="{{ asset('images/avatar_owner.png') }}" class="img-responsive img-thumbnail" style="width: 200px; height: 200px; border-radius: 50%; ">
            @endif
            <h3 style="color: white;">Total Product : {{ count($data->products) }}</h3>
            <h3 style="color: white;">Address : {{ $data->address != null ? $data->address : '-' }}</h3>
            <br><br>
        </div>
    </div> <br>

    <div class="container">
    	@if( count( $products ) != 0 )
			<div class="row">
	    		@foreach( $products as $product )
	    			<div class="col-md-4">
		    			<div class="box box-success">
							<div class="box-header with-border">
								<img class="profile-user-img img-responsive" src="{{ asset('storage/'.$product->file->path) }}" alt="User profile picture" style="width: 150px; height: 150px;">
							</div>
							<div class="box-body box-profile">
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Product Name</b>
										<a class="pull-right">
											{{ substr($product->name, 0, 30) }}
										</a>
									</li>
									<li class="list-group-item">
										<b>Price</b>
										<a class="pull-right">
											IDR. {{ number_format($product->price) }}
										</a>
									</li>
									<li class="list-group-item">
										<b>View</b>
										<a class="pull-right">
											{{ $product->view }}
										</a>
									</li>
								</ul>
							</div>
							<div class="box-footer">
								<a href="{{ route('member.product.index', ['id' => $product->id]) }}" class="btn btn-info col-md-12"><i class="fa fa-eye"></i> View Detail</a>
							</div>
						</div>
					</div>
	    		@endforeach
			</div>
		@else
			<center><h1>Data Empty</h1></center>
    	@endif
		<div class="pull-right">
			{{ $products->links() }}
		</div>
	</div>
@endsection