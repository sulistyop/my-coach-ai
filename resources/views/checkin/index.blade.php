@extends('layouts.app')

@section('content')
    <div class="p-3 pb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-primary">📅 Recent Check-Ins</h5>
        </div>

        @if($checkIns->isEmpty())
            <div class="text-center text-muted">
                <i class="bi bi-emoji-frown fs-1"></i>
                <p>No check-ins found. Start your daily check-in!</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($checkIns as $checkIn)
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($checkIn->date)->format('d M Y') }}</div>
                                <div class="small text-muted mt-1">
                                    <div><i class="bi bi-emoji-smile text-warning me-1"></i> Mood: <em>{{ $checkIn->mood }}</em></div>
                                    <div><i class="bi bi-bullseye text-danger me-1"></i> Challenge: {{ $checkIn->answer }}</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <i class="bi bi-check2-circle fs-4 text-success"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Floating Action Button -->
    <a href="{{ route('checkin.create') }}"
       class="btn btn-success rounded-circle shadow position-fixed"
       style="bottom: 80px; right: 20px; width: 60px; height: 60px; display: flex; justify-content: center; align-items: center;">
        <i class="bi bi-plus fs-4"></i>
    </a>
@endsection
