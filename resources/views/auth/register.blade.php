@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-white text-center py-4">
                    <h3 class="fw-bold text-primary">{{ __('Create Account') }}</h3>
                    <p class="text-muted">Join University Shop today!</p>
                </div>

                <div class="card-body px-5 py-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Your Name" required autocomplete="name" autofocus>
                            <label for="name"><i class="fas fa-user me-2 text-primary"></i>{{ __('Full Name') }}</label>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                            <label for="email"><i class="fas fa-envelope me-2 text-primary"></i>{{ __('Email Address') }}</label>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                            <label for="password"><i class="fas fa-lock me-2 text-primary"></i>{{ __('Password') }}</label>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                            <label for="password-confirm"><i class="fas fa-check-circle me-2 text-primary"></i>{{ __('Confirm Password') }}</label>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Register') }}
                            </button>
                        </div>

                        <div class="text-center mb-3">
                            <span class="text-muted small text-uppercase">Or Register with</span>
                            <hr class="mt-2">
                        </div>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <a href="{{ url('auth/google') }}" class="btn btn-outline-danger w-100 py-2">
                                <i class="fab fa-google"></i>
                            </a>
                            <a href="{{ url('auth/github') }}" class="btn btn-outline-dark w-100 py-2">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="{{ url('auth/facebook') }}" class="btn btn-outline-primary w-100 py-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center py-3 bg-light border-0">
                    <p class="mb-0 small">Already have an account? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Login Here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 15px; }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25 margin;
    }
    .btn-lg { font-size: 1rem; font-weight: 600; }
</style>
@endsection