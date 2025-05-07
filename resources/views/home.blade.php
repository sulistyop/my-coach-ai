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

    <!-- <a href="{{ route('checkin') }}" class="btn btn-primary w-100 mt-3 rounded-pill fw-semibold py-2">
        ✅ Mulai Check-in Hari Ini
    </a> -->

    <div class="mt-4">
        <div class="card mb-3 border-0 shadow-sm rounded-4 p-3">
            <h6 class="fw-bold text-success text-center">🎯 Goal Aktif</h6>
            @if($goals)
            <p class="text-center"><strong>{{ $goals->title }}</strong></p>
            @else
            <p class="text-muted small text-center">No active goals found. Start setting your goals!</p>
            @endif
        </div>

     

        <!-- Habits Section -->
        <div class="p-3">
            <div class="mb-4 text-center">
            <h5 class="fw-bold text-success">🧠 Your Habits</h5>
            <p class="text-muted small">Track and manage your daily habits effectively.</p>
            </div>

            @if($habits->isEmpty())
            @if(is_null($goals))
                <div class="text-center text-muted">
                <i class="bi bi-emoji-frown fs-1"></i>
                <p>Please create a goal first before adding habits.</p>
                </div>
            @else
                <div class="text-center text-muted">
                <i class="bi bi-emoji-frown fs-1"></i>
                <p>No habits added yet. Start creating one!</p>
                </div>
            @endif
            @else
            <div class="d-flex flex-column gap-3">
                @foreach($habits as $habit)
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success-subtle rounded-circle d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="bi bi-list-check text-success fs-4"></i>
                        </div>
                        <div>
                        <div class="fw-semibold fs-6 text-truncate" style="max-width: 200px;" title="{{ $habit->name }}">{{ $habit->name }}</div>
                        <div class="text-muted small">
                            {{ ucfirst($habit->frequency) }}
                            @if ($habit->best_time)
                            • Best Time: {{ $habit->best_time }}
                            @endif
                        </div>
                        <div class="small mt-1">
                            @php
                            $todayLog = $habit->logs()->where('date', now()->toDateString())->first();
                            @endphp

                            @if ($todayLog && $todayLog->completed)
                            ✅ <span class="text-muted">Last: {{ \Illuminate\Support\Carbon::parse($todayLog->updated_at)->format('d M Y H:i') }}</span>
                            @else
                            ⏳ <span class="text-muted">Not completed yet</span>
                            @endif
                        </div>
                        </div>
                    </div>
                    <form action="{{ route('habit.markDone', $habit->id) }}" method="POST" class="ms-2">
                        @csrf
                        @method('PATCH')
                        @if($todayLog && $todayLog->completed)
                        <button type="button" class="btn btn-sm btn-outline-success" disabled>
                            <i class="bi bi-check-circle-fill"></i>
                        </button>
                        @else
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="bi bi-check-circle"></i>
                        </button>
                        @endif
                    </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        @if(!is_null($goals))
            <div class="d-flex justify-content-end mt-4">
            <!-- Floating Action Button -->
            <a href="{{ route('setup.habits') }}"
               class="btn btn-success rounded-circle shadow-lg position-fixed bottom-plus d-flex justify-content-center align-items-center"
               style="width: 60px; height: 60px; bottom: 20px; right: 20px;">
                <i class="bi bi-plus fs-4"></i>
            </a>
            </div>
        @endif

      
    </div>


@endsection
