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
        }

        .calendar-cell.highlighted {
            background: linear-gradient(to right, #ffa726, #ffca28);
            color: white;
        }

        .calendar-cell.today {
            border: 2px solid white;
            box-shadow: 0 0 0 3px #ffa726;
        }

        .calendar-cell .drop-icon {
            position: absolute;
            bottom: -8px;
            width: 22px;
            height: 22px;
            background-color: #4fc3f7;
            border-radius: 50% 50% 50% 0;
            transform: translateX(-50%) rotate(45deg);
            left: 50%;
            z-index: 1;
        }

        .calendar-cell .drop-icon::after {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            width: 10px;
            height: 10px;
            background-color: white;
            border-radius: 50%;
        }

        .calendar-cell.inactive {
            color: #bbb;
        }
    </style>

    <div class="text-center mb-3">
        <a href="{{ route('streak', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="btn btn-outline-secondary btn-sm">← {{ $prevMonth->format('F Y') }}</a>
        <strong class="mx-3">{{ $currentDate->format('F Y') }}</strong>
        <a href="{{ route('streak', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="btn btn-outline-secondary btn-sm">{{ $nextMonth->format('F Y') }} →</a>
    </div>

    <div class="streak-header">
        <h4 class="fw-bold mb-0">🔥 {{ count($highlightedDates) }} Day Streak!</h4>
        <small>Keep up the great work!</small>
    </div>

    <div class="calendar shadow">
        <div class="calendar-row">
            @foreach(['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'] as $day)
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
                    @endphp
                    <div class="{{ $classes }}">
                        {{ $current->day }}
                        @if ($isCheckIn)
                            <div class="drop-icon"></div>
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
