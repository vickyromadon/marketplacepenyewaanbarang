@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('rentoncome/css/jquery-ui1.css') }}">
@endsection

@section('content')
	{{-- BANNER --}}
	<div class="banner text-center">
        <div class="container">
            <h1>Kategori {{ $data->category->name }}</h1>
            <p style="margin-bottom: 0px; font-size: 25px;">Sub Kategori {{ $data->name }}</p>
            <p>Sewa Produk Apa Pun Secara Online Dengan RentOnCome</p>
        </div>
    </div> <br>
	
	<div class="total-ads main-grid-border">
		<div class="container">
			<ol class="breadcrumb" style="margin-bottom: 5px;">
				<li><a href="{{ route('member.index') }}">Home</a></li>
				<li><a href="{{ route('member.main_categories') }}">Kategori Utama</a></li>
				<li class="active">{{ $data->name }}</li>
			</ol>
			<div class="ads-grid">
				<div class="side-bar col-md-3">
					{{-- <div class="search-hotel">
						<h3 class="sear-head">Search Product</h3>
						<form method="post" action="{{ route('member.category.search') }}">
							@csrf
							<input name="search" id="search" type="text" placeholder="Product name...">
							<input type="submit" value="">
						</form>
					</div>
					<br> --}}
					<div>
						<h3 class="sear-head text-center">Iklan Produk Terbaru</h2>
						@if ( count($all_products) > 0 )
							@foreach( $all_products as $product )
								@if ( $product->status == App\Models\Product::STATUS_PUBLISH )
									<div style="font-weight: bold; padding: 5px; border: 1px solid #e3e3e3; background: #fff; margin: 5px; margin-left: 0px;">
										<a href="{{ route('member.product.index', ['product' => $product->id]) }}">
											<div class="featured-ad-left">
												<img src="{{ asset('storage/'.$product->file->path) }}" style="height: 100px; width:100px;">
											</div>
											<div class="featured-ad-right" style="padding: 0 5px 0 0;">
												<h4>{{ substr($product->name, 0, 10) }}</h4>
												<p style="font-size: 15px; font-weight: bold;">{{ number_format($product->price) }}</p>
												<p style="color: #aaa;">
													Per
													@if( $product->time_periode == 'Day' )
														Hari
													@elseif( $product->time_periode == 'Week' )
														Minggu
													@elseif( $product->time_periode == 'Month' )
														Bulan
													@else
														Tahun
													@endif
												</p>
											</div>
											<div class="clearfix"></div>
										</a>
									</div>
								@endif
							@endforeach
						@endif
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="ads-display col-md-9">
					<div class="wrapper">
						<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
							<ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
								<li role="presentation" class="active">
									<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
										<span class="text">Semua Produk</span>
									</a>
								</li>
							</ul>
							<div id="myTabContent" class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
									<div>
										<div id="container">
											<div class="view-controls-list" id="viewcontrols">
												<label>Tampilan :</label>
												<a class="gridview"><i class="glyphicon glyphicon-th"></i></a>
												<a class="listview active"><i class="glyphicon glyphicon-th-list"></i></a>
											</div>
											{{-- <div class="sort">
												<form action="#" method="post">
													<div class="sort-by">
														<label>Sort By : </label>
														<select>
															<option value="">-- Select One --</option>
															<option value="">Price: Low to High</option>
															<option value="">Price: High to Low</option>
														</select>

														<button type="submit"><i class="fa fa-search"></i></button>
													</div>
												</form>
											</div> --}}
											<div class="clearfix"></div>
											<ul class="list">
												@if ( count($products) > 0 )
													@foreach ($products as $product)
														<a href="{{ route('member.product.index', ['product' => $product->id]) }}">
															<li>
																<div class="product-content">
																	<div class="img-content" style="width: 225px;">
																		<img src="{{ asset('storage/'.$product->file->path) }}" style="width: 100%; height: 150px;">
																	</div>
																	<section class="list-left">
																		<h5 class="title">
																			{{ substr($product->name, 0, 15) }}
																		</h5>
																		
																		<span class="adprice">
																			Rp. {{ number_format($product->price) }} / 
																			<span style="font-size: 15px; color: #aaa;">
																				@if( $product->time_periode == 'Day' )
																					Hari
																				@elseif( $product->time_periode == 'Week' )
																					Minggu
																				@elseif( $product->time_periode == 'Month' )
																					Bulan
																				@else
																					Tahun
																				@endif
																			</span>
																		</span>
																		<br>
																		
																		@if ( count($product->ratings) != 0 )
																			@php
																				$totRating = 0;

																				foreach ($product->ratings as $rating){
																					$totRating += $rating->rate;
																				}
																			@endphp

																			<div style="padding: 0;" class="rateYo" data-rating="{{ $totRating / count($product->ratings) }}"></div>
																		@else
																			<div style="padding: 0;" class="rateYo" data-rating="0"></div>
																		@endif
																	</section>
																	<section class="list-right">
																		<span class="date">
																			{{\Carbon\Carbon::parse($product->created_at)->diffForHumans()}}
																		</span>
																	</section>
																	<div class="clearfix"></div>
																</div>
															</li>
														</a>
													@endforeach
												@else
													<h1 style="color: grey; text-align: center;">
														No Products Available
													</h1>
												@endif
												<div class="clearfix"></div>
											</ul>
										</div>
									</div>
								</div>
								<div>
									{{ $products->links() }}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript" src="{{ asset('rentoncome/js/jquery-ui.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function () {
		    var elem=$('#container ul');
		    $('#viewcontrols a').on('click',function(e) {
		        if ($(this).hasClass('gridview')) {
		            elem.fadeOut(1000, function () {
		                $('#container ul').removeClass('list').addClass('grid');
		                $('#viewcontrols').removeClass('view-controls-list').addClass('view-controls-grid');
		                $('#viewcontrols .gridview').addClass('active');
		                $('#viewcontrols .listview').removeClass('active');
		                elem.fadeIn(1000);
		            });
		        }
		        else if($(this).hasClass('listview')) {
		            elem.fadeOut(1000, function () {
		                $('#container ul').removeClass('grid').addClass('list');
		                $('#viewcontrols').removeClass('view-controls-grid').addClass('view-controls-list');
		                $('#viewcontrols .gridview').removeClass('active');
		                $('#viewcontrols .listview').addClass('active');
		                elem.fadeIn(1000);
		            });
		        }
		    });
		});
	</script>

	<script type="text/javascript">
        $(".rateYo").each( function() {
            var rating = $(this).attr("data-rating");
            $(this).rateYo(
                {
                    ratedFill: "gold",
                    starWidth: "30px",
                    rating: rating,
                    fullStar: true,
                    readOnly: true
                }
            );
        });
    </script>
@endsection