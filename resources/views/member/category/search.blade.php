@extends('layouts.app')

@section('content')
	{{-- BANNER --}}
	<div class="banner text-center">
        <div class="container">
            <h1>Hasil Pencarian Dari <i class="fa fa-search"></i></h1>
            <p style="margin-bottom: 0px; font-size: 40px;"> "{{ $search }}" </p>
        </div>
    </div> <br>

    <div class="container">
		{{-- <div class="row">
			<div class="col-md-12">
				<div class="row">
					<form action="{{ route('member.category.search') }}" method="post">
						@csrf
    					<div class="col-md-4">
    						<label>Filter By Category</label>
    						<select name="category_name" id="category_name" class="form-control">
    							<option value="">-- Select One --</option>
    							@foreach( $categories as $category )
    								<option value="{{ $category->name }}">{{ $category->name }}</option>
    							@endforeach	
    						</select>
    					</div>
    					<div class="col-md-4">
    						<label>&nbsp;</label>
    						<button type="submit" class="btn btn-info col-md-12">
    							<i class="fa fa-search"></i> Filter
    						</button>
    					</div>
					</form>
				</div>
			</div>
		</div>
		<br> --}}
    	@if( count( $products ) != 0 )
			<div class="row">
	    		@foreach( $products as $product )
	    			<div class="col-md-4">
		    			<div class="box box-success">
							<div class="box-header with-border">
								<img class="profile-user-img img-responsive" src="{{ asset('storage/'.$product->path) }}" alt="User profile picture" style="width: 150px; height: 150px;">
							</div>
							<div class="box-body box-profile">
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item">
										<b>Nama Produk</b>
										<a class="pull-right">
											{{ substr($product->name, 0, 30) }}
										</a>
									</li>
									<li class="list-group-item">
										<b>Harga</b>
										<a class="pull-right">
											IDR. {{ number_format($product->price) }}
										</a>
									</li>
									<li class="list-group-item">
										<b>Dilihat</b>
										<a class="pull-right">
											{{ $product->view }}
										</a>
									</li>
								</ul>
							</div>
							<div class="box-footer">
								<a href="{{ route('member.product.index', ['id' => $product->id]) }}" class="btn btn-info col-md-12"><i class="fa fa-eye"></i> Lihat Detail</a>
							</div>
						</div>
					</div>
	    		@endforeach
			</div>
		@else
			<center><h1>Data Tidak Di Temukan</h1></center>
    	@endif
		{{-- <div class="pull-right">
			{{ $products->links() }}
		</div> --}}
	</div>
@endsection