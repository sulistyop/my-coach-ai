@extends('layouts.app')

@section('content')

    <div class="text-center mb-4">
        <h4 class="fw-bold text-success">Welcome Back, {{ Auth::user()->name }}! 🌟</h4>
        <p class="text-muted">Keep up the great work and stay consistent!</p>
    </div>


    <div class="card shadow-sm p-3">
        <div class="card-header text-center">
            <h5 class="mb-0">Daily Motivation</h5>
        </div>
        <div class="card-body text-center">
            <blockquote class="blockquote">
                <p class="text-warning">"{{ $dailyMotivation }}"</p>
            </blockquote>
        </div>
    </div>

    <a href="{{ route('checkin') }}" class="btn btn-primary w-100 mt-3">Mulai Check-in Hari Ini</a>

    <div class="mt-4">
        <h6>Goal Aktif</h6>
        <p><strong>Produktivitas</strong> — Fokus & disiplin kerja harian</p>

        <h6>Kebiasaan</h6>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                Minum Air 💧 <span>3/5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                Tidur Cukup 😴 <span>4/5</span>
            </li>
        </ul>

        <div class="row mt-4">
            <!-- Habit Streak -->
            <div class="col-12 col-md-6 mb-3 d-flex">

                <div class="card shadow-sm p-2 h-100 w-100">
                    <div class="card-header bg-success text-white py-2 small">
                        <h5 class="mb-0">Your Streak</h5>
                    </div>
                    <div class="card-body text-center">
                        <h1 class="text-success mb-1">{{ $streak }} 🔥</h1>
                        <p class="mb-0 small text-muted">days in a row</p>
                        <a href="{{ route('streak') }}" class="btn btn-primary btn-sm">View Streak</a>
                    </div>
                </div>
            </div>

            <!-- Weekly Check-Ins -->
            <div class="col-12 col-md-6 mb-3 d-flex">
                <div class="card shadow-sm p-2 h-100 w-100">
                    <div class="card-header bg-primary text-white py-2 small">
                        <h6 class="mb-0">Weekly Check-Ins</h6>
                    </div>
                    <div class="card-body py-2">
                        <h1 class="text-success mb-1">{{ $checkInsThisWeek }} ✅</h1>
                        <p class="mb-0 small text-muted">completed this week</p>
                    </div>
                </div>
            </div>

            <!-- Daily Motivation -->
            <div class="col-12 mb-3 d-flex">
                <div class="card text-center p-2 h-100 w-100">
                    <div class="card-header bg-warning text-dark py-2 small">
                        Daily Motivation
                    </div>
                    <div class="card-body py-2">
                        <blockquote class="blockquote mb-0">
                            <p class="small">{{ $dailyMotivation }}</p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>

        <!-- Habits Section -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-bold small d-flex justify-content-between align-items-center">
                <span>Your Habits</span>
                <a href="{{ route('setup.habits') }}" class="text-success">
                    <i class="bi bi-plus-lg"></i> {{-- atau gunakan ➕ --}}
                </a>
            </div>
            <div class="card-body p-2">
                @forelse ($habits as $habit)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2 small">
                        <span>📌 {{ $habit->name }}</span>
                        <span class="badge bg-secondary text-white">{{ ucfirst($habit->frequency) }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No habits found. Start creating one!</p>
                @endforelse
            </div>
        </div>

        <!-- Check-In History Section -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-bold small">
                Recent Check-Ins
            </div>
            <div class="card-body p-2">
                @forelse ($checkIns as $checkIn)
                    <div class="border-bottom py-2 small">
                        <strong>{{ $checkIn->date }}</strong><br>
                        😄 Mood: <em>{{ $checkIn->mood }}</em><br>
                        🎯 Challenge: {{ $checkIn->answer }}
                    </div>
                @empty
                    <p class="text-muted small mb-0">No check-ins found. Start your daily check-in!</p>
                @endforelse
            </div>
        </div>

        <!-- Goals Section -->
        <div class="card mb-3">
            <div class="card-header bg-light fw-bold small d-flex justify-content-between align-items-center">
                <span>Your Goals</span>
                <a href="{{ route('setup.goals') }}" class="text-primary">
                    <i class="bi bi-plus-lg"></i> {{-- atau gunakan ➕ --}}
                </a>
            </div>
            <div class="card-body p-2">
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