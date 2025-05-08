@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column" style="min-height: 70vh;">
        <div class="flex-grow-1 d-flex justify-content-center align-items-center p-3 bg-light">
            <div class="text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/2917/2917995.png" alt="Goals Icon" style="width: 150px; height: auto; margin-bottom: 20px;">
            <p class="text-muted fs-5">Belum ada goals? Yuk, mulai tulis goals Anda sekarang!</p>
            </div>
        </div>
        <div class="border-top p-3 bg-white">
            <form id="chatForm" action="{{ route('goals-results') }}" method="GET" class="d-flex">
            <input type="text" name="goal" class="form-control me-2" id="chatInput" placeholder="Contoh: Bangun pagi setiap hari" required>
            <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
@endsection
