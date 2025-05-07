@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="mb-3">
            <h5 class="fw-bold text-success">🧠 Your Habits</h5>
        </div>

        @if($habits->isEmpty())
            <div class="text-center text-muted">
                <i class="bi bi-emoji-frown fs-1"></i>
                <p>No habits found. Start creating one!</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($habits as $habit)
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-success-subtle rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-list-check text-success fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $habit->name }}</div>
                                    <div class="text-muted small">
                                        {{ ucfirst($habit->frequency) }}
                                        @if($habit->best_time)
                                            • Best Time: {{ $habit->best_time }}
                                        @endif
                                    </div>
                                    <div class="small">
                                        @if($habit->last_completed_at)
                                            ✅ <span class="text-muted">Last: {{ \Illuminate\Support\Carbon::parse($habit->last_completed_at)->format('d M Y H:i') }}</span>
                                        @else
                                            ⏳ <span class="text-muted">Not completed yet</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('habit.markDone', $habit->id) }}" method="POST" class="ms-2">
                                @csrf
                                @method('PATCH')
                                @if($habit->last_completed_at)
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

    <!-- Floating Action Button -->
    <a href="{{ route('setup.habits') }}"
       class="btn btn-sm btn-success rounded-circle shadow position-fixed"
       style="bottom: 80px; right: 20px; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
        <i class="bi bi-plus fs-4"></i>
    </a>
@endsection
