@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4 fw-bold text-primary">🔐 Login</h4>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">📧 Email</label>
                                <input id="email" type="email"
                                       class="form-control rounded-3 @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">🔑 Password</label>
                                <input id="password" type="password"
                                       class="form-control rounded-3 @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Remember Me --}}
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>

                            {{-- Submit Button --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success rounded-3">
                                    Login
                                </button>
                            </div>

                            {{-- Forgot Password --}}
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Lupa password?
                                    </a>
                                </div>
                            @endif

                            {{-- Register Link --}}
                            <div class="text-center mt-3">
                                <p class="text-muted">
                                    Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Daftar</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
