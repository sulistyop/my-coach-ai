@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="mb-3">
            <h5 class="fw-bold text-primary">🎯 Tujuan Kamu</h5>
        </div>

        @if($goals->isEmpty())
            <div class="text-center text-muted">
                <i class="bi bi-emoji-frown fs-1"></i>
                <p>Tidak ada tujuan yang ditambahkan. Mulai buat satu!</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($goals as $goal)
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary-subtle rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-flag text-primary fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $goal->title }}</div>
                                    <div class="text-muted small">
                                        {{ $goal->description }}
                                    </div>
                                    <div class="small">
                                        Target: {{ $goal->target }} •
                                        Date: {{ \Illuminate\Support\Carbon::parse($goal->target_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-xs btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>

    <div class="custom-bottom d-flex justify-content-end">
        <!-- Floating Action Button -->
        <a href="{{ route('setup.goals') }}"
           class="btn btn-sm btn-primary rounded-circle shadow custom-bottom bottom-plus">
            <i class="bi bi-plus fs-4"></i>
        </a>
    </div>



@endsection
