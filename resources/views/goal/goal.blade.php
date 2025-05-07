@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center center-form">
        <form id="goalForm" class="w-100" action="{{ route('store-goals') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="goalInput" class="form-label">Masukkan Goal Anda</label>
                <input type="text" class="form-control" id="goalInput" placeholder="Contoh: Bangun pagi setiap hari">
            </div>

            <div class="bottom-right">
                <button type="submit" form="goalForm" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
