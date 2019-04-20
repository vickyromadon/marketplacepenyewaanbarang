@extends('layouts.auth')

@section('header')
    <a href="#"><b>Admin</b> RentOnCome</a>
@endsection

@section('content')
    <p class="login-box-msg">Reset Password Admin</p>
    <form action="{{ route('admin.password.email') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
            <!-- /.col -->
        </div>
    </form>
@endsection