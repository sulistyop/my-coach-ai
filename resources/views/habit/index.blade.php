@extends('layouts.app')

@section('content')
    <div class="p-3">
        <div class="mb-3">
            <h5 class="fw-bold text-primary">🧠 Kebiasaan Kamu</h5>
        </div>

        @if($habits->isEmpty())

            @if($goals->isEmpty())
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown fs-1"></i>
                    <p>Harap buat tujuan terlebih dahulu sebelum membuat kebiasaan.</p>
                </div>
            @else
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown fs-1"></i>
                    <p>Tida ada kebiasaan yang ditambahkan. Mulai buat satu!</p>
                </div>
            @endif
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($habits as $habit)
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-list-check text-white fs-5"></i>
                                </div>
                                <div class="flex-shrink-1">
                                    <div class="fw-semibold text-truncate" style="max-width: 200px;">{{ $habit->name }}</div>
                                    <div class="text-muted small">
                                        {{ ucfirst($habit->frequency) }}
                                        @if ($habit->best_time)
                                            • Best Time: {{ $habit->best_time }}
                                        @endif
                                    </div>
                                    <div class="small">
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
                                @if($habit->last_completed_at)
                                    <button type="button" class="btn btn-sm btn-outline-primary" disabled>
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-primary">
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

    @if($goals->isNotEmpty())
        <div class="custom-bottom d-flex justify-content-end">
            <!-- Floating Action Button -->
            <a href="{{ route('setup.habits') }}"
               class="btn btn-sm btn-primary rounded-circle shadow position-fixed bottom-plus">
                <i class="bi bi-plus fs-4"></i>
            </a>
        </div>
    @endif
@endsection
