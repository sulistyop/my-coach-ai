@extends('layouts.app')

@section('content')
    <div class=" py-4">
        <div class="mb-4">
            <h4 class="fw-bold text-primary">✨ Setup Habit Baru</h4>
            <p class="text-muted">Buat kebiasaan baru untuk bantu kamu berkembang setiap hari!</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form method="POST" action="{{ route('setup.habits.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="habit_name" class="form-label fw-semibold">
                            📝 Nama Habit
                        </label>
                        <input type="text" class="form-control rounded-3" id="habit_name" name="habit_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="frequency" class="form-label fw-semibold">
                            🔁 Frekuensi
                        </label>
                        <select class="form-select rounded-3" id="frequency" name="frequency" required>
                            <option value="daily">Harian</option>
                            <option value="weekly">Mingguan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="best_time" class="form-label fw-semibold">
                            ⏰ Waktu Terbaik <span class="text-muted">(opsional)</span>
                        </label>
                        <input type="time" class="form-control rounded-3" id="best_time" name="best_time">
                    </div>

                    <div class="mb-3">
                        <label for="motivation" class="form-label fw-semibold">
                            💬 Motivasi <span class="text-muted">(opsional)</span>
                        </label>
                        <textarea class="form-control rounded-3" id="motivation" name="motivation" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-3">
                            ← Kembali
                        </a>
                        <button type="submit" class="btn btn-success rounded-3">
                            Simpan →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
