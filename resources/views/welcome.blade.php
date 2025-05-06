@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
    <div style="text-align: center; padding: 1rem;">
        <img src="{{ asset('images/mobile-preview.png') }}" alt="Preview" style="width: 80%; margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem;">Selamat Datang di My Coach AI</h1>
        <p style="color: #ccc; font-size: 0.9rem;">
            Pendamping harian cerdas untuk meningkatkan kualitas hidup Anda.
        </p>

        <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-secondary" style="margin-left: 0.5rem;">Daftar</a>

    </div>
@endsection