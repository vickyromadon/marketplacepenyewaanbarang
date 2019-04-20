@extends('layouts.app')

@section('css')
	<style>
		.btnChange{
			margin-bottom: 10px;
		}

		.nameUser{
			margin-bottom: 10px;
		}

		.imageUser{
			width: 100%;
			height: 250px;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						@if ( $data->file != null )
							<img class="img-thumbnail imageUser img-responsive" src="{{ asset('storage/'. $data->file->path)}}">
						@else
							<img class="img-thumbnail imageUser img-responsive" src="{{ asset('images/avatar_default.png') }}">
						@endif
					</div>
					<div class="col-md-9">
						
						@if ( Auth::user()->id === $data->id )
							<div class="btnChange pull-right">
								<a href="{{ route('member.profile.update', ['id' => $data->id]) }}" class="label label-warning">
									<i class="fa fa-gears" aria-hidden="true"></i> Change
								</a>
							</div>
						@endif

						<div>
							<h3 class="nameUser">{{ $data->name }}</h3>
						</div>

						<div>
							<a href="#" class="list-group-item"><i class="fa fa-envelope" aria-hidden="true"></i> 
								{{ $data->email }}
							</a>
							<a href="#" class="list-group-item"><i class="fa fa-phone" aria-hidden="true"></i> 
								{{ $data->phone != null ? $data->phone : '-' }}
							</a>
							<a href="#" class="list-group-item"><i class="fa fa-calendar" aria-hidden="true"></i>
								{!! date('d F Y', strtotime($data->created_at)); !!}
							</a>
							<a href="#" class="list-group-item">
								@if( $data->status == App\Models\User::STATUS_NOT_ACTIVE )
									<i class="fa fa-power-off" aria-hidden="true"></i>
									<span class="label label-danger">{{ $data->status }}</span>
								@elseif( $data->status == App\Models\User::STATUS_CONFIRM )
									<i class="fa fa-check" aria-hidden="true"></i>
									<span class="label label-info">{{ $data->status }}</span>
								@else
									<i class="fa fa-close" aria-hidden="true"></i>
									<span class="label label-warning">{{ $data->status }}</span>
								@endif
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection