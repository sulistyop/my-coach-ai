@extends('layouts.app')

@section('content')
    <style>
        .tab-container {
            display: block;
        }

        .tab-card {
            display: none;
            border-radius: 1rem;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 1rem 1rem 1.25rem;
        }

        .tab-card.active {
            display: block;
        }

        .tab-header {
            display: flex;
            justify-content: space-between;
            background: #f6f9fc;
            border-radius: 999px;
            padding: 0.25rem;
            margin-bottom: 1rem;
        }

        .tab-button {
            flex: 1;
            padding: 0.5rem 0.75rem;
            background: transparent;
            border: none;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 999px;
            color: #666;
        }

        .tab-button.active {
            background-color: #0d6efd;
            color: #fff;
        }

        label {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        input, textarea {
            font-size: 0.875rem !important;
        }

        .habit-pill-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .habit-pill {
            padding: 0.5rem 1rem;
            border-radius: 999px;
            background-color: #fff;
            border: 1px solid #d1d5db;
            color: #111;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }

        .habit-pill:hover {
            background-color: #f3f4f6;
        }

        .habit-pill.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        @media (min-width: 768px) {
            .tab-card {
                max-width: 500px;
                margin: auto;
            }
        }
    </style>

    <div class="py-3 px-3">
        <h5 class="fw-bold text-primary mb-1">🎯 Sesuaikan Tujuanmu</h5>
        <p class="text-muted small mb-3">Bangun kebiasaan baru untuk bantu kamu berkembang setiap hari!</p>

        <div class="tab-header">
            <button class="tab-button active" onclick="showTab(0)">💡 Rekomendasi</button>
            <button class="tab-button" onclick="showTab(1)">✍️ Kustom</button>
        </div>

        <div id="tabContent">
            {{-- Tab 1: AI Recommendation --}}
            <div class="tab-card tab-pane active" id="tab-0">
                <h6 class="fw-semibold mb-3">Rekomendasi AI</h6>
                <form id="promptForm" method="POST" onsubmit="event.preventDefault(); generateRecommendations();">
                    <div class="mb-3">
                        <label for="userPrompt">Apa tantangan terbesarmu hari ini?</label>
                        <textarea class="form-control rounded-3" id="userPrompt" name="userPrompt" required placeholder="Contoh: Kebiasaan untuk menjadi lebih produktif"></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 fw-semibold py-2">🎯 Dapatkan Rekomendasi</button>
                    </div>
                </form>

                <div id="recommendations" class="mt-4" style="display: none;">
                    <h6 class="fw-semibold mb-3">Rekomendasi Kebiasaan</h6>
                    <div class="habit-pill-container mb-4">
                        <button class="habit-pill" data-habit="Baca buku 10 halaman per hari" data-strategy="Atur waktu untuk membaca setiap hari di pagi hari">📚 Baca buku 10 halaman per hari</button>
                        <button class="habit-pill" data-habit="Jalan kaki 5000 langkah" data-strategy="Gunakan aplikasi pedometer untuk mengukur langkah">👟 Jalan kaki 5000 langkah</button>
                        <button class="habit-pill" data-habit="Menulis jurnal harian" data-strategy="Tulis 3 hal positif setiap malam sebelum tidur">📝 Menulis jurnal harian</button>
                        <button class="habit-pill" data-habit="Meditasi 10 menit setiap pagi" data-strategy="Gunakan aplikasi meditasi dengan panduan audio">🧘 Meditasi 10 menit setiap pagi</button>
                        <button class="habit-pill" data-habit="Belajar coding selama 1 jam" data-strategy="Sediakan waktu satu jam di pagi hari untuk belajar coding">💻 Belajar coding selama 1 jam</button>
                    </div>

                    <!-- Hidden inputs untuk dikirim saat submit -->
                    <form method="POST" action="{{ route('setup.goals.store') }}">
                        @csrf
                        <div id="selectedHabits"></div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success rounded-3 fw-semibold py-2">✅ Simpan Goal</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tab 2: Custom Goal Form --}}
            <div class="tab-card tab-pane" id="tab-1">
                <form method="POST" action="{{ route('setup.goals.store') }}">
                    @csrf

                    {{--input hidden not_setup--}}
                    <input type="hidden" name="not_setup" value="true">
                    <div class="mb-2">
                        <label for="goal_name">Nama Tujuan</label>
                        <input type="text" class="form-control rounded-3" id="goal_name" name="goal_name" required placeholder="Contoh: Belajar Laravel">
                    </div>

                    <div class="mb-2">
                        <label for="deadline">Tanggal Tercapai</label>
                        <input type="date" class="form-control rounded-3" id="deadline" name="deadline" required>
                    </div>

                    <div class="mb-3">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control rounded-3" id="description" name="description" rows="3" placeholder="Contoh: Saya ingin belajar Laravel untuk membuat aplikasi web."></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 fw-semibold py-2">✅ Simpan Goal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="custom-bottom d-flex justify-content-end">
        <a href="{{ route('goals') }}"
           class="btn btn-primary rounded-circle shadow position-fixed bottom-plus">
            <i class="bi bi-arrow-left-short fs-4 text-white"></i>
        </a>
    </div>

    <script>
        function showTab(index) {
            const tabCards = document.querySelectorAll('.tab-card');
            const tabButtons = document.querySelectorAll('.tab-button');

            tabCards.forEach((card, i) => {
                card.classList.toggle('active', i === index);
            });

            tabButtons.forEach((btn, i) => {
                btn.classList.toggle('active', i === index);
            });
        }

        function generateRecommendations() {
            const prompt = document.getElementById('userPrompt').value;
            const recommendationsSection = document.getElementById('recommendations');
            recommendationsSection.style.display = 'block';
            console.log('Prompt Submitted: ' + prompt);
        }

        // Toggle & generate hidden inputs
        document.addEventListener('DOMContentLoaded', function () {
            const habitButtons = document.querySelectorAll('.habit-pill');
            const selectedHabitsContainer = document.getElementById('selectedHabits');

            habitButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.classList.toggle('active');
                    updateHiddenInputs();
                });
            });

            function updateHiddenInputs() {
                selectedHabitsContainer.innerHTML = '';
                document.querySelectorAll('.habit-pill.active').forEach(button => {
                    const habit = button.dataset.habit;
                    const strategy = button.dataset.strategy;
                    selectedHabitsContainer.innerHTML += `
                        <input type="hidden" name="habits[]" value="${habit}">
                        <input type="hidden" name="strategies[]" value="${strategy}">
                    `;
                });
            }
        });
    </script>
@endsection
