@extends('layouts.auth')

@section('title')
    <title>Owner RentOnCome | Registrasi</title>
@endsection

@section('header')
    <a href="#"><b>Owner</b> RentOnCome</a>
@endsection

@section('content')
    <p class="login-box-msg">Register a new owner</p>
    <form action="{{ route('owner.register') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="privilege" name="privilege" value="1">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype Password" required>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <!-- /.col -->
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            <!-- /.col -->
        </div>
    </form>
@endsection