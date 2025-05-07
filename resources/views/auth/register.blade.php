@extends('layouts.app')

@section('content')
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4 fw-bold text-primary">📝 Register</h4>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">👤 Nama</label>
                                <input id="name" type="text"
                                       class="form-control rounded-3 @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">📧 Email</label>
                                <input id="email" type="email"
                                       class="form-control rounded-3 @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                       name="password" required autocomplete="new-password">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label for="password-confirm" class="form-label">🔒 Konfirmasi Password</label>
                                <input id="password-confirm" type="password"
                                       class="form-control rounded-3"
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>

                            {{-- Submit Button --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success rounded-3">
                                    Daftar
                                </button>
                            </div>

                            {{-- Login Link --}}
                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="btn btn-link">
                                    Sudah punya akun? Login
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
