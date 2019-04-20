@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="head text-center">Riwayat Sewa Barang</h2>

    	<div class="row">
        	@foreach( $data as $rating )
	        	<div class="col-md-3">
	        		<div class="box box-success">
	        			<div class="box-header">
	        				<h3 class="box-title">
        						<a href="{{ route('member.product.index', ['id' => $rating->product->id]) }}">
	        						{{ substr($rating->product->name, 0, 25) }}
	        					</a>	
	        				</h3>
	        			</div>
	        			<div class="box-body">
		    				<div class="row">
		    					<div class="col-md-12">
		    						<img src="{{ asset('storage/'.$rating->product->file->path) }}" class="img-thumbnail img-responsive" style="width: 100%; height: 200px;">
		    					</div>
		    				</div>
		    				<div class="row">
		    					<div class="col-md-12">
		    						<center>
			    						<div style="padding: 0;" class="rateYo" data-rating="{{ $rating->rate }}"></div>
			    					</center>
		    					</div>
		    				</div>
	    				</div>
		        	</div>
	        	</div>
        	@endforeach
        </div>

        <div class="row">
        	<div class="pull-right">
				{{ $data->links() }}
			</div>
        </div>
    </div>
@endsection

@section('js')
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