@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Selamat Datang! Yuk mulai dengan membuat habit pertamamu 🎉</h2>
        <form method="POST" action="{{ route('setup.store') }}">
            @csrf
            <div class="mb-3">
                <label for="habit_name" class="form-label">Nama Habit</label>
                <input type="text" class="form-control" id="habit_name" name="habit_name" required>
            </div>

            <div class="mb-3">
                <label for="frequency" class="form-label">Frekuensi</label>
                <select class="form-control" id="frequency" name="frequency" required>
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="best_time" class="form-label">Waktu Terbaik (opsional)</label>
                <input type="time" class="form-control" id="best_time" name="best_time">
            </div>

            <div class="mb-3">
                <label for="motivation" class="form-label">Motivasi (opsional)</label>
                <textarea class="form-control" id="motivation" name="motivation"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan dan Lanjut</button>
        </form>
    </div>
@endsection