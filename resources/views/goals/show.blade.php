@extends('layouts.app')

@push('styles')
    <style>
        .progress-container {
            width: 120px;
            position: relative;
        }

        .semi-circle {
            width: 100%;
            height: auto;
        }

        .semi-circle path {
            fill: none;
            stroke-width: 4;
            stroke-linecap: round;
        }

        .semi-circle .bg {
            stroke: #e0e0e0;
        }

        .semi-circle .progress {
            stroke: #4caf50; /* duolingo green */
            stroke-dasharray: 0 50;
            transition: stroke-dasharray 0.6s ease;
        }

        .progress-label {
            font-size: 14px;
            color: #555;
            font-weight: 600;
        }
    </style>
@endpush


@section('content')
    <div class="p-3">
        <h5 class="fw-bold text-primary">🎯 Detil Tujuan Kamu</h5>
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h6 class="fw-bold">{{ $goal->title }}</h6>
                <p class="text-muted">{{ $goal->description }}</p>
                <p class="small">Target Date: {{ \Illuminate\Support\Carbon::parse($goal->target_date)->format('d M Y') }}</p>
                <a href="{{ route('goals.edit', $goal->id) }}" class="btn btn-xs btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                </a>
            </div>
        </div>

        <h6 class="fw-bold text-secondary">📋 Kebiasaan</h6>

        <div class="text-center mb-4">
            <h6 class="fw-bold text-secondary">📊 Statistik Hari Ini</h6>
            <div class="progress-container mx-auto mb-2">
                <svg viewBox="0 0 36 18" class="semi-circle">
                    <path class="bg" d="M2 18 A16 16 0 0 1 34 18" />
                    <path class="progress"
                          d="M2 18 A16 16 0 0 1 34 18"
                          style="stroke-dasharray: {{ ($habitsDone / max($habitsTotal, 1)) * 50 }} 50;" />
                </svg>
                <div class="progress-label mt-2">
                    {{ $habitsDone }} / {{ $habitsTotal }} selesai
                </div>
            </div>
        </div>

        @if($habits->isEmpty())
            <p class="text-muted">Tidak ada kebiasaan yang terkait dengan goal ini.</p>
        @else
            <ul class="list-group">
                @foreach($habits as $habit)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span>{{ $habit->name }}</span>
                            <small class="text-muted d-block">{{ $habit->strategy }}</small>
                        </div>
                        <span class="badge {{ $habit->logs->isNotEmpty() ? 'bg-success' : 'bg-secondary' }}">
                            {{ $habit->logs->isNotEmpty() ? 'Sudah Dikerjakan' : 'Belum Dikerjakan' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif


    </div>
    <div class="custom-bottom d-flex justify-content-end">
        <a href="{{ route('goals') }}"
           class="btn btn-primary rounded-circle shadow position-fixed bottom-plus">
            <i class="bi bi-arrow-left-short fs-4 text-white"></i>
        </a>
    </div>
@endsection