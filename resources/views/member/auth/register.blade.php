@extends('layouts.app')

@section('content')
    <div id="page-wrapper" class="sign-in-wrapper">
        <div class="graphs">
            <div class="sign-in-form">
                <div class="sign-in-form-top">
                    <h1>
                        <center>Daftar</center>    
                    </h1>
                </div>
                <div class="signin">
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="privilege" name="privilege" value="0">
                        <div class="input-group">
                            <span class="input-group-addon" style="color: #01a185 !important;"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Name" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        </div>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong style="margin-left: 40px; color: red;">{{ $errors->first('name') }}</strong>
                            </span>
                            <br>
                        @endif
                        
                        <br>

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

                        <div class="input-group">
                            <span class="input-group-addon" style="color: #01a185 !important;"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" id="password" name="password" value="{{ old('password') }}" required autofocus>
                        </div>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong style="margin-left: 40px; color: red;">{{ $errors->first('password') }}</strong>
                            </span>
                            <br>
                        @endif

                        <br>

                        <div class="input-group">
                            <span class="input-group-addon" style="color: #01a185 !important;"><i class="fa fa-unlock-alt"></i></span>
                            <input type="password" class="form-control" placeholder="Current Password" id="password-confirm" name="password_confirmation" required>
                        </div>
                        
                        <br>

                        <input type="submit" value="Daftar">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
