<!-- resources/views/checkin/response.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Respon AI</h2>
        <p><strong>Tantanganmu:</strong> {{ $challenge }}</p>
        <p><strong>Tips dari AI:</strong> {{ $tips }}</p>
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection