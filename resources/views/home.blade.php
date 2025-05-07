@extends('layouts.app')

@section('content')

    <div class="text-center mb-4">
        <h4 class="fw-bold text-success">Welcome Back, {{ Auth::user()->name }}! 🌟</h4>
        <p class="text-muted">Keep up the great work and stay consistent!</p>
    </div>

    <div class="row mt-4">
        <!-- Daily Motivation -->
        <div class="col-12 mb-3 d-flex">
            <div class="card text-center h-100 w-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-warning text-dark py-2 small rounded-top-4 fw-semibold">
                    💡 Daily Motivation
                </div>
                <div class="card-body py-3 px-4">
                    <blockquote class="blockquote mb-0">
                        <p class="small fst-italic text-dark">“{{ $dailyMotivation }}”</p>
                    </blockquote>
                </div>
            </div>
        </div>

        <!-- Habit Streak -->
        <div class="col-6 col-md-6 mb-3 d-flex">
            <div class="card shadow-sm h-100 w-100 border-0 rounded-4">
                <div class="card-header bg-success text-white py-2 small rounded-top-4 fw-semibold">
                    🔥 Your Streak
                </div>
                <div class="card-body text-center py-4">
                    <h1 class="text-success fw-bold display-5">{{ $streak }} 🔥</h1>
                    <p class="mb-2 small text-muted">days in a row</p>
                    <a href="{{ route('streak') }}" class="btn btn-success btn-sm rounded-pill px-4">View Streak</a>
                </div>
            </div>
        </div>

        <!-- Weekly Check-Ins -->
        <div class="col-6 col-md-6 mb-3 d-flex">
            <div class="card shadow-sm h-100 w-100 border-0 rounded-4">
                <div class="card-header bg-primary text-white py-2 small rounded-top-4 fw-semibold">
                    📊 Weekly Stats
                </div>
                <div class="card-body text-center py-4">
                    <h1 class="text-primary fw-bold display-5">{{ $checkInsThisWeek }} ✅</h1>
                    <p class="mb-0 small text-muted">completed this week</p>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('checkin') }}" class="btn btn-primary w-100 mt-3 rounded-pill fw-semibold py-2">
        ✅ Mulai Check-in Hari Ini
    </a>

    <div class="mt-4">
        <h6 class="fw-bold text-success">🎯 Goal Aktif</h6>
        <p><strong>Produktivitas</strong> — Fokus & disiplin kerja harian</p>

        <h6 class="fw-bold text-success">💪 Kebiasaan</h6>
        <ul class="list-group mb-3 rounded-4">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Minum Air 💧 <span class="badge bg-success rounded-pill">3/5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Tidur Cukup 😴 <span class="badge bg-success rounded-pill">4/5</span>
            </li>
        </ul>

        <!-- Habits Section -->
        <div class="card mb-3 border-0 shadow-sm rounded-4">
            <div class="card-header bg-light fw-bold small d-flex justify-content-between align-items-center rounded-top-4">
                <span>🧠 Your Habits</span>
                <a href="{{ route('setup.habits') }}" class="text-success fw-bold">
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
            </div>
            <div class="card-body p-3">
                @forelse ($habits as $habit)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2 small">
                        <span>📌 {{ $habit->name }}</span>
                        <span class="badge bg-secondary rounded-pill">{{ ucfirst($habit->frequency) }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No habits found. Start creating one!</p>
                @endforelse
            </div>
        </div>

        <!-- Check-In History Section -->
        <div class="card mb-3 border-0 shadow-sm rounded-4">
            <div class="card-header bg-light fw-bold small rounded-top-4">
                📅 Recent Check-Ins
            </div>
            <div class="card-body p-3">
                @forelse ($checkIns as $checkIn)
                    <div class="border-bottom py-2 small">
                        <strong class="text-primary">{{ $checkIn->date }}</strong><br>
                        😄 Mood: <em>{{ $checkIn->mood }}</em><br>
                        🎯 Challenge: {{ $checkIn->answer }}
                    </div>
                @empty
                    <p class="text-muted small mb-0">No check-ins found. Start your daily check-in!</p>
                @endforelse
            </div>
        </div>

        <!-- Goals Section -->
        <div class="card mb-3 border-0 shadow-sm rounded-4">
            <div class="card-header bg-light fw-bold small d-flex justify-content-between align-items-center rounded-top-4">
                <span>🎯 Your Goals</span>
                <a href="{{ route('setup.goals') }}" class="text-primary fw-bold">
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
            </div>
            <div class="card-body p-3">
                @forelse ($goals as $goal)
                    <div class="d-flex justify-content-between border-bottom py-2 small">
                        <span>🎯 {{ $goal->title }}</span>
                        <span class="text-muted">📅 {{ \Carbon\Carbon::parse($goal->target_date)->format('d M Y') }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No goals found. Start setting your goals!</p>
                @endforelse
            </div>
        </div>
    </div>


@endsection
