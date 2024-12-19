@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-white py-4">
                <div class="text-center text-danger  py-3"><h3>{{ __('Login') }}</h3></div> 
                {{-- {{$hash}} --}}
                <div class="col-12">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="d-flex justify-content-center">
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label for="email" class="form-label p-0">{{ __('Email Address') }}</label>
            
                                        {{-- <div class="col-md-6"> --}}
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        {{-- </div> --}}
                                    </div>
            
                                    <div class="row mb-3">
                                        <label for="password" class="form-label p-0">{{ __('Password') }}</label>
            
                                        {{-- <div class="col-md-6"> --}}
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        {{-- </div> --}}
                                    </div>

                                    <div class="row mb-3 p-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                    </div>
            
                                    <div class="row mb-0 p-0">
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('Login') }}
                                                </button>
            
                                            {{-- @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif --}}
                                    </div>
                                </div>
                            </div>
    
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
