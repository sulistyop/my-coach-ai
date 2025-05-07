@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="mb-3">
            <h5 class="fw-bold text-primary">🎯 Your Goals</h5>
        </div>

        @if($goals->isEmpty())
            <div class="text-center text-muted">
                <i class="bi bi-emoji-frown fs-1"></i>
                <p>No goals have been added yet. Start creating one!</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($goals as $goal)
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-primary-subtle rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-flag text-primary fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $goal->title }}</div>
                                    <div class="text-muted small">
                                        {{ $goal->description }}
                                    </div>
                                    <div class="small">
                                        Target: {{ $goal->target }}
                                        • Date: {{ \Illuminate\Support\Carbon::parse($goal->target_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            {{--<form action="{{ route('goal.markComplete', $goal->id) }}" method="POST" class="ms-2">
                                @csrf
                                @method('PATCH')
                                @if($goal->is_completed)
                                    <button type="button" class="btn btn-sm btn-outline-success" disabled>
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                @endif
                            </form>--}}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Floating Action Button -->
    <a href="{{ route('setup.goals') }}"
       class="btn btn-sm btn-primary rounded-circle shadow position-fixed"
       style="bottom: 80px; right: 20px; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
        <i class="bi bi-plus fs-4"></i>
    </a>
@endsection
