<!-- resources/views/setup/goals.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Setup Goals</h2>
        <form method="POST" action="{{ route('setup.goals.store') }}">
            @csrf
            <div class="mb-3">
                <label for="goal_name" class="form-label">Nama Goal</label>
                <input type="text" class="form-control" id="goal_name" name="goal_name" required>
            </div>

            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline" name="deadline" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan dan Lanjut</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection