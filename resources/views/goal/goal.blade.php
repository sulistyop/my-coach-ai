@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column vh-100">
        <div class="flex-grow-1 overflow-auto p-3 bg-light">
            <div class="d-flex justify-content-center align-items-center h-100">
                <p class="text-muted">Silakan isi goals Anda.</p>
            </div>
        </div>
        <div class="border-top p-3 bg-white">
            <form id="chatForm" action="{{ route('store-goals') }}" method="POST" class="d-flex">
                @csrf
                <input type="text" name="message" class="form-control me-2" id="chatInput" placeholder="Contoh: Bangun pagi setiap hari" required>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
@endsection
