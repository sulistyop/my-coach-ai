@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center center-form">
        <form id="goalForm" class="w-100" action="{{ route('daily-checkin-store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="goalInput" class="form-label">Apa hal yang paling membanggakan dari hari ini?</label>
                <textarea name="answer" id="answer" cols="40" rows="10" placeholder="Contoh: Hal membanggakan dari hari ini adalah ketika saya berhasil menyelesaikan semua tugas yang telah saya rencanakan."></textarea>
            </div>

            <div class="bottom-right">
                <button type="submit" form="goalForm" class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>
@endsection
