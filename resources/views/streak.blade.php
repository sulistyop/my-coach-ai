@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="text-center mb-4">
        <h4 class="fw-bold">Your Streak</h4>
        <p class="text-muted">Keep up the momentum!</p>
    </div>

    <div class="card shadow-sm p-3">
        <div class="row text-center fw-bold border-bottom pb-2">
            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="col">{{ $day }}</div>
            @endforeach
        </div>

        @for ($date = $startDay->copy(); $date->lte($endDay); $date->addWeek())
            <div class="row text-center py-1">
                @for ($i = 0; $i < 7; $i++)
                    @php
                        $currentDate = $date->copy()->addDays($i);
                        $formatted = $currentDate->format('Y-m-d');
                        $isToday = $currentDate->isToday();
                        $checked = in_array($formatted, $checkInDates);
                    @endphp
                    <div class="col border py-2 {{ $isToday ? 'bg-light' : '' }}">
                        <div class="{{ $checked ? 'badge bg-success text-white' : '' }}">
                            {{ $currentDate->format('j') }}
                        </div>
                    </div>
                @endfor
            </div>
        @endfor
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
    </div>
@endsection