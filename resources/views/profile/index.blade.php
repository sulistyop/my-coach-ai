@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold text-primary mb-4">👤 Profil Anda</h3>


        {{-- Profile Card --}}
        <div class="card border-0 shadow-sm p-3 rounded-4 mb-4">
            <div class="d-flex align-items-center">
                {{-- Avatar --}}
                <div class="me-4">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                        <span class="text-primary fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                </div>

                {{-- User Info --}}
                <div>
                    <h5 class="fw-bold mb-1 fs-5" style="font-size: 1em !important;">{{ $user->name }}</h5>
                    <p class="mb-1 text-muted small"><i class="bi bi-envelope-fill me-1" style="font-size: 0.8em !important;"></i>{{ $user->email }}</p>
                    <p class="mb-0 text-muted small"><i class="bi bi-calendar-check me-1" style="font-size: 0.8em !important;"></i>Bergabung pada {{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Logout Button --}}
        <div>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="btn btn-outline-danger btn-sm rounded-pill px-4">
                <i class="bi bi-box-arrow-right me-1"></i> Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
@endsection
