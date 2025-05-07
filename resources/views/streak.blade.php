@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon;

        $today = Carbon::today();
        $highlightedDates = $checkInDates; // format: ['2024-07-01', '2024-07-02', ...]
        $startOfMonth = $currentDate->copy()->startOfMonth()->startOfWeek();
        $endOfMonth = $currentDate->copy()->endOfMonth()->endOfWeek();
        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();
        $progressData = $progressData ?? []; // default if not set
    @endphp

    <style>
        .streak-header {
            background-color: #FFA000;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .calendar {
            background: #fff;
            padding: 1rem;
            border-radius: 1rem;
            max-width: 400px;
            margin: auto;
        }

        .day-label {
            font-weight: bold;
            color: #999;
            font-size: 0.9rem;
            text-align: center;
        }

        .calendar-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.4rem;
        }

        .calendar-cell {
            width: 40px;
            height: 40px;
            margin: 0 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-radius: 50%;
            font-weight: bold;
            font-size: 0.9rem;
            z-index: 1;
            background-color: #fff;
        }

        .calendar-cell.highlighted {
            background: linear-gradient(to right, #ffa726, #ffca28);
            color: white;
        }

        .calendar-cell.today {
            border: 2px solid white;
            box-shadow: 0 0 0 3px #ffa726;
        }

        .calendar-cell.inactive {
            color: #bbb;
        }

        /* Progress bar di luar tanggal */
        .calendar-cell .circle-progress {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            z-index: 0;

        }

        /* Styling progress bar dengan warna saat memiliki progress */

    </style>

    <div class="text-center mb-3">
        <a href="{{ route('streak', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="btn btn-outline-secondary btn-sm">← {{ $prevMonth->format('F Y') }}</a>
        <strong class="mx-3">{{ $currentDate->format('F Y') }}</strong>
        <a href="{{ route('streak', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="btn btn-outline-secondary btn-sm">{{ $nextMonth->format('F Y') }} →</a>
    </div>

    <div class="streak-header">
        <h4 class="fw-bold mb-0">🔥 {{ $streak }} Day Streak!</h4>
        <small>Keep up the great work!</small>
    </div>

    <div class="calendar shadow">
        <div class="calendar-row">
            @foreach([ 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa','Su'] as $day)
                <div class="day-label">{{ $day }}</div>
            @endforeach
        </div>

        @for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addWeek())
            <div class="calendar-row">
                @for ($i = 0; $i < 7; $i++)
                    @php
                        $current = $date->copy()->addDays($i);
                        $isToday = $current->isToday();
                        $formatted = $current->format('Y-m-d');
                        $isCheckIn = in_array($formatted, $highlightedDates);
                        $isCurrentMonth = $current->month === $currentDate->month;
                        $classes = 'calendar-cell';
                        if ($isCheckIn) $classes .= ' highlighted';
                        if ($isToday) $classes .= ' today';
                        if (!$isCurrentMonth) $classes .= ' inactive';

                        // Hitung persentase progress berdasarkan data habit
                        $completedHabits = $progressData[$formatted]['completed'] ?? 0;
                        $totalHabits = $progressData[$formatted]['total'] ?? 1;
                        $progressPercentage = ($completedHabits / $totalHabits) * 100;

                    @endphp
                    <div class="{{ $classes }}">
                        {{ $current->day }}
                        @if ($completedHabits > 0)
                            <div class="circle-progress">
                                <svg viewBox="0 0 36 36" class="circular-chart">
                                    <path class="circle-progress-bg" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e0e0e0" stroke-width="2" />
                                    <path class="circle-progress-bar" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#28a745" stroke-width="2"
                                          stroke-dasharray="{{ $completedHabits }}, 100" />
                                </svg>

                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        @endfor
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-outline-warning">⬅ Back to Home</a>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>

@endsection