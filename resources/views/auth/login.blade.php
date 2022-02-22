@extends('layouts.auth')

@section('content')

<div class="card">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="row align-items-center text-center">
            <div class="col-md-12">
                
                <div class="card-body">
                    <img src="{{ back_asset('images/logo-dark.png') }}" alt="" class="img-fluid mb-4">
                    <h4 class="mb-3 f-w-400">Signin</h4>
                    <div class="form-group mb-3">
                        <label class="floating-label" for="Email">{{ __('Email Address') }}</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="floating-label" for="Password">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Save credentials.') }}</label>
                    </div>
                    <button type="submit" class="btn btn-block btn-primary mb-4">{{ __('Login') }}</button>
                    @if (Route::has('password.request'))
                        <p class="mb-2 text-muted">{{ __('Forgot Your Password?') }} <a href="{{ route('password.request') }}" class="f-w-400">Reset</a></p>
                    @endif
                </div>

            </div>
        </div>
    </form>
</div>

@endsection