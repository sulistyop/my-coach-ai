@extends('layouts.app')

@section('content')
    <div class="p-3">
        <h5 class="fw-bold text-primary">✏️ Ubah Tujuan</h5>
        <form method="POST" action="{{ route('goals.update', $goal->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="goalTitle" class="form-label">Nama Tujuan</label>
                <input type="text" class="form-control" id="goalTitle" name="title" value="{{ $goal->title }}" required>
            </div>
            <div class="mb-3">
                <label for="goalDescription" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="goalDescription" name="description" rows="3">{{ $goal->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="goalDate" class="form-label">Tanggal Target</label>
                <input type="date" class="form-control" id="goalDate" name="target_date" value="{{ \Illuminate\Support\Carbon::parse($goal->target_date)->format('Y-m-d') }}" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection