@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="bg-primary text-white p-4 rounded-top">
                        <h1 class="display-6 fw-bold">Get Started now</h1>
                        <p class="mb-0">Create an account or log in to explore about our app</p>
                    </div>
                    
                    <div class="p-4">
                        <div class="d-flex mb-4">
                            <div class="flex-grow-1">
                                <a href="{{ route('login') }}" class="btn btn-light w-100 fw-bold text-secondary">Masuk</a>
                            </div>
                            <div class="flex-grow-1">
                                <button class="btn btn-light w-100 fw-bold border border-2 {{ Route::currentRouteName() == 'register' ? 'active' : '' }}">Daftar</button>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div class="input-group">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="@gmail.com" required autocomplete="email">
                                    <span class="input-group-text bg-white"><i class="bi bi-envelope text-primary"></i></span>
                                    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Kata Sandi</label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata Sandi" required autocomplete="new-password">
                                    <span class="input-group-text bg-white"><i class="bi bi-eye-slash text-secondary"></i></span>
                                    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="small text-muted mt-1">Minimal 8 karakter</div>
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="form-label fw-bold">Konfirmasi Kata Sandi</label>
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required autocomplete="new-password">
                                    <span class="input-group-text bg-white"><i class="bi bi-eye-slash text-secondary"></i></span>
                                </div>
                                <div class="small text-muted mt-1">Minimal 8 karakter</div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                    Daftar
                                </button>
                            </div>
                            
                            <div class="text-center mb-3">
                                <p class="text-muted">Or</p>
                            </div>
                            
                            <div class="mb-3">
                                <a href="#" class="btn btn-outline-secondary w-100 position-relative py-2 fw-bold">
                                    <img src="https://cdn.cdnlogo.com/logos/g/35/google-icon.svg" alt="Google" width="18" class="position-absolute start-0 ms-3">
                                    Continue with Google
                                </a>
                            </div>
                            
                            <div class="mb-3">
                                <a href="#" class="btn btn-outline-secondary w-100 position-relative py-2 fw-bold">
                                    <img src="https://cdn.cdnlogo.com/logos/f/84/facebook.svg" alt="Facebook" width="18" class="position-absolute start-0 ms-3">
                                    Continue with Facebook
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection