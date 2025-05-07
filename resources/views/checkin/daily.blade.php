@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center center-form">
        <form id="goalForm" class="w-100" action="{{ route('store-goals') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="goalInput" class="form-label">Apa hal yang paling membanggakan dari hari ini?</label>
                <textarea name="answer" id="answer" cols="30" rows="10" placeholder="Contoh: Bangun pagi setiap hari"></textarea>
            </div>

            <div class="bottom-right">
                <button type="submit" form="goalForm" class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>
@endsection
