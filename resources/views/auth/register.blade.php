@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-white text-center py-4">
                    <h3 class="fw-bold text-primary">{{ __('Create Account') }}</h3>
                    <p class="text-muted">Join የኛ ገበያ today!</p>
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
                            <!-- Google: official multicolor -->
                            <a href="{{ url('auth/google') }}" class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                               style="border: 1px solid #dadce0; color: #3c4043; background: #fff;">
                                <svg width="18" height="18" viewBox="0 0 48 48">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                </svg>
                                Google
                            </a>
                            <!-- GitHub: black -->
                            <a href="{{ url('auth/github') }}" class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                               style="border: 1px solid #24292e; color: #fff; background: #24292e;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                                    <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.385-1.335-1.755-1.335-1.755-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/>
                                </svg>
                                GitHub
                            </a>
                            <!-- Facebook: blue -->
                            <a href="{{ url('auth/facebook') }}" class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2"
                               style="border: 1px solid #1877F2; color: #fff; background: #1877F2;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                                    <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
                                </svg>
                                Facebook
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