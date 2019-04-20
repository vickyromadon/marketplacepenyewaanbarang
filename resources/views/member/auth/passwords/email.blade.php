@extends('layouts.app')

@section('content')
    <div id="page-wrapper" class="sign-in-wrapper">
        <div class="graphs">
            <div class="sign-in-form">
                <div class="sign-in-form-top">
                    <h1>
                        <center>Reset Password</center>    
                    </h1>
                </div>
                <div class="signin">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="input-group">
                            <span class="input-group-addon" style="color: #01a185 !important;"><i class="fa fa-at"></i></span>
                            <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong style="margin-left: 40px; color: red;">{{ $errors->first('email') }}</strong>
                            </span>
                            <br>
                        @endif

                        <br>

                        <input type="submit" value="Send Reset Link">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection