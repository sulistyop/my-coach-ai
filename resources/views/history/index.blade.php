@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold text-primary">📊 Habit History & Reflection</h3>

        {{-- Section: Weekly Habit Tracker --}}
        <div class="mt-4">
            <h5 class="text-secondary mb-3">🗓️ Weekly Habit Tracker</h5>

            @forelse($weeklyProgress as $progress)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-semibold">{{ $progress['habit']->title }}</h5>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered text-center align-middle mb-0">
                                <thead class="table-light">
                                <tr>
                                    @foreach($progress['daily'] as $day)
                                        <th>{{ \Carbon\Carbon::parse($day['date'])->format('D') }}<br>
                                            <small>{{ \Carbon\Carbon::parse($day['date'])->format('d M') }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($progress['daily'] as $day)
                                        <td>
                                            @if(is_null($day['completed']))
                                                <span class="badge bg-secondary">⏳</span>
                                            @elseif($day['completed'])
                                                <span class="badge bg-success">✅</span>
                                            @else
                                                <span class="badge bg-danger">❌</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Belum ada data habit minggu ini.</div>
            @endforelse
        </div>

        {{-- Section: AI Reflections (Daily Check-in) --}}
        <div class="mt-5">
            <h5 class="text-secondary mb-3">🤖 Refleksi Harian dari AI</h5>

            @forelse($checkIns as $checkIn)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($checkIn->created_at)->format('l, d M Y') }}
                        </small>
                        <p class="mb-1 mt-2"><strong>📝 Jawaban Anda:</strong><br>{{ $checkIn->answer }}</p>
                        <p class="mb-0"><strong>💡 Respon AI:</strong><br>{{ $checkIn->ai_response }}</p>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Belum ada data check-in minggu ini.</div>
            @endforelse
        </div>
    </div>
@endsection
