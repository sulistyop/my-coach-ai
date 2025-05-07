@extends('layouts.app')

@section('content')
<div class="text-center mb-4">
    <h4 class="fw-bold text-success">Welcome Back, {{ Auth::user()->name }}! 🌟</h4>
    <p class="text-muted">Keep up the great work and stay consistent!</p>
</div>

<div class="row mt-4">
    <!-- Daily Motivation -->
    <div class="col-12 mb-3 d-flex">
        <div class="card text-center h-100 w-100 border-0 shadow-sm rounded-4">
            <div class="card-header bg-warning text-dark py-2 small rounded-top-4 fw-semibold">
                💡 Daily Motivation
            </div>
            <div class="card-body py-3 px-4">
                <blockquote class="blockquote mb-0">
                    <p class="small fst-italic text-dark">“{{ $dailyMotivation }}”</p>
                </blockquote>
            </div>
        </div>
    </div>

    <!-- Habit Streak -->
    <div class="col-6 col-md-6 mb-3 d-flex">
        <div class="card shadow-sm h-100 w-100 border-0 rounded-4">
            <div class="card-header bg-success text-white py-2 small rounded-top-4 fw-semibold">
                🔥 Your Streak
            </div>
            <div class="card-body text-center py-4">
                <h1 class="text-success fw-bold display-5">{{ $streak }} 🔥</h1>
                <p class="mb-2 small text-muted">days in a row</p>
                <a href="{{ route('streak') }}" class="btn btn-success btn-sm rounded-pill px-4">View Streak</a>
            </div>
        </div>
    </div>

    <!-- Weekly Check-Ins -->
    <div class="col-6 col-md-6 mb-3 d-flex">
        <div class="card shadow-sm h-100 w-100 border-0 rounded-4">
            <div class="card-header bg-primary text-white py-2 small rounded-top-4 fw-semibold">
                📊 Weekly Stats
            </div>
            <div class="card-body text-center py-4">
                <h1 class="text-primary fw-bold display-5">{{ $checkInsThisWeek }} ✅</h1>
                <p class="mb-0 small text-muted">completed this week</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="card mb-3 border-0 shadow-sm rounded-4 p-3">
        <h6 class="fw-bold text-success text-center">🎯 Goal Aktif</h6>
        @if($goals)
            <p class="text-center"><strong>{{ $goals->title }}</strong></p>
        @else
            <p class="text-muted small text-center">No active goals found. Start setting your goals!</p>
        @endif
    </div>

    <!-- Habits Section -->
    <div class="p-3">
        <div class="mb-4 text-center">
            <h5 class="fw-bold text-success">🧠 Your Habits</h5>
            <p class="text-muted small">Track and manage your daily habits effectively.</p>
        </div>

        @if($habits->isEmpty())
            @if(is_null($goals))
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown fs-1"></i>
                    <p>Please create a goal first before adding habits.</p>
                </div>
            @else
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-frown fs-1"></i>
                    <p>No habits added yet. Start creating one!</p>
                </div>
            @endif
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($habits as $habit)
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-success-subtle rounded-circle d-flex justify-content-center align-items-center flex-shrink-0" style="width: 50px; height: 50px; min-width: 50px;">
                                    <i class="bi bi-list-check text-success fs-4"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold fs-6 text-truncate" style="max-width: 200px;" title="{{ $habit->name }}">
                                        {{ $habit->name }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ ucfirst($habit->frequency) }}
                                        @if ($habit->best_time)
                                            • Best Time: {{ $habit->best_time }}
                                        @endif
                                    </div>
                                    <div class="small mt-1">
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

                            <form action="{{ route('habit.markDone', $habit->id) }}" method="POST" class="ms-2 habit-form">
                                @csrf
                                @method('PATCH')
                                @if($todayLog && $todayLog->completed)
                                    <button type="button" class="btn btn-sm btn-outline-success" disabled>
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-success habit-check-btn" data-habit-id="{{ $habit->id }}" data-habit-name="{{ $habit->name }}">
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

    <!-- Popup Modal -->
    <div class="modal fade" id="habitPopupModal" tabindex="-1" aria-labelledby="habitPopupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="habitPopupModalLabel">🎉 Congratulations!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="chat-container">
                            <!-- Chat Messages -->
                            <div class="chat-messages mb-3" id="chatMessages">
                                <div class="chat-message bot-message">
                                    <div class="message-content">
                                        <i class="bi bi-trophy text-warning" style="font-size: 1.5rem;"></i>
                                        <p>You've completed "<span id="habitNameInModal" class="fw-bold"></span>"! 🎊</p>
                                        <p class="text-muted small">Keep going and build your streak!</p>
                                    </div>
                                </div>
                            </div>


                            <!-- User Input -->
                            <div class="chat-input" id="chatInputSection">
                                <div class="mb-3">
                                    <label for="goalInput" class="form-label">Apa hal yang paling membanggakan dari hari ini?</label>
                                    <textarea id="answer" cols="40" rows="3" class="form-control" placeholder="Contoh: ..."></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="button" id="submitGoal" class="btn btn-primary">Kirim</button>
                                </div>
                            </div>


                            

                            <!-- Response Message -->
                            <div id="responseMessage" class="chat-messages mt-3 d-none">
                                <div class="chat-message bot-message">
                                    <div class="message-content">
                                        <p id="responseText" class="text-success fw-bold"></p>
                                        <p class="text-muted small">Tetap semangat dan lanjutkan kebiasaan baikmu!</p>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-success confirm-submit">Continue</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
        }
        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .chat-message {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .bot-message {
            flex-direction: column;
            align-items: flex-start;
        }
        .message-content {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            max-width: 100%;
        }
        .chat-input {
            margin-top: 1rem;
        }

        .user-message .message-content {
    background-color: #0d6efd;
    color: white;
    align-self: flex-end;
    margin-left: auto;
}

    </style>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const submitGoalButton = document.getElementById('submitGoal');
    const responseMessage = document.getElementById('responseMessage');
    const responseText = document.getElementById('responseText');
    const answerInput = document.getElementById('answer');
    const chatInputSection = document.getElementById('chatInputSection');
    const chatMessages = document.getElementById('chatMessages');

    submitGoalButton.addEventListener('click', async function () {
        const answer = answerInput.value.trim();
        if (!answer) {
            alert('Please provide an answer before submitting.');
            return;
        }

        const url = "{{ route('daily-checkin-store') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const formData = new FormData();
        formData.append('answer', answer);
        formData.append('_token', csrfToken);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const data = await response.json();

                // Tambahkan jawaban user sebagai chat message
                const userMessage = document.createElement('div');
                userMessage.className = 'chat-message user-message';
                userMessage.innerHTML = `
                    <div class="message-content bg-primary text-white">
                        <p>${answer}</p>
                    </div>
                `;
                chatMessages.appendChild(userMessage);

                // Tambahkan response dari sistem
                const botMessage = document.createElement('div');
                botMessage.className = 'chat-message bot-message';
                botMessage.innerHTML = `
                    <div class="message-content">
                        <p>${data.message || 'Terima kasih atas jawabanmu! 🌟'}</p>
                    </div>
                `;
                chatMessages.appendChild(botMessage);

                // Sembunyikan input
                chatInputSection.classList.add('d-none');

                // Tampilkan tombol lanjut
                responseMessage.classList.remove('d-none');
            } else {
                const errorData = await response.json();
                alert(errorData.message || 'Terjadi kesalahan. Silakan coba lagi.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });
});

    </script>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const habitCheckButtons = document.querySelectorAll('.habit-check-btn');
        let selectedForm = null;

        habitCheckButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                selectedForm = this.closest('.habit-form');

                const habitName = this.dataset.habitName;
                const modalElement = document.getElementById('habitPopupModal');
                document.getElementById('habitNameInModal').textContent = habitName;

                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        });

        document.querySelector('.confirm-submit').addEventListener('click', function () {
            if (selectedForm) {
                selectedForm.submit();
                const modalElement = document.getElementById('habitPopupModal');
                const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
                bootstrapModal.hide();
            }
        });
    });
</script>
