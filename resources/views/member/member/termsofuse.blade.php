@extends('layouts.app')

@section('content')
	<div class="work-section">
		<div class="container">
			<h2 class="head text-center">Terms Of Use</h2>
		</div>
		<div class="row">
			<div class="col-md-12" style="padding: 0px 50px;">
				{!! $data->terms_of_use !!}
			</div>
		</div>
	</div>
@endsection