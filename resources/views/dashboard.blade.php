@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Dashboard</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Habit Streak</h5>
                        <p class="card-text">{{ $streak }} days</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Weekly Check-Ins</h5>
                        <p class="card-text">{{ $checkInsThisWeek }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daily Motivation</h5>
                        <p class="card-text">{{ $dailyMotivation }}</p>
                    </div>
                </div>
            </div>
        </div>
        <a href="/habits/create" class="btn btn-success mt-3">Add Habit</a>
        <a href="/check-ins/create" class="btn btn-info mt-3">Daily Check-In</a>
    </div>
@endsection