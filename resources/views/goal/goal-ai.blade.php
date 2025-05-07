@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Progress bar dan tombol kembali -->
    <div class="d-flex align-items-center mb-4">
        <a href="#" class="me-3 text-dark">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <div class="progress flex-grow-1" style="height: 6px;">
            <div class="progress-bar bg-primary" style="width: 50%;"></div>
        </div>
    </div>

    <!-- Judul dan deskripsi -->
    <h4 class="fw-bold text-primary">Lorem ipsum dolor sit</h4>
    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing</p>

    <!-- Label -->
    <p class="text-muted mb-2">Lorem ipsum dolor</p>

    <!-- Daftar checkbox -->
    @for ($i = 0; $i < 6; $i++)
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1 fw-bold">Lorem ipsum dolor sit</h6>
                <p class="mb-0 text-muted small">Lorem ipsum dolor sit amet, consectetur</p>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkbox{{ $i }}">
            </div>
        </div>
    </div>
    @endfor

    <!-- Tombol Selanjutnya -->
    <div class="d-grid mt-4">
        <button class="btn btn-primary fw-bold py-2">Selanjutnya</button>
    </div>
</div>
@endsection
