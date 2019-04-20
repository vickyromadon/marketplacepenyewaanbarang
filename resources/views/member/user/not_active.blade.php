@extends('layouts.app')

@section('content')
	<div class="work-section">
		<div class="container">
			<h2 class="head text-center">Hi, {{ Auth::user()->name }}</h2>
		</div>
		<div class="row">
			<div class="col-md-12" style="padding: 0px 50px; text-align: center;">
				<p><b>Sorry, Your Account Has Been "NOT ACTIVE"</b></p>
				<p>You Have Made a Mistake on Our System</p>
			</div>
		</div>
	</div>
@endsection