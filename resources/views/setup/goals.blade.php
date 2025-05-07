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

        ul.list-group li {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }

        @media (min-width: 768px) {
            .tab-card {
                max-width: 500px;
                margin: auto;
            }
        }
    </style>

    <div class="py-3 px-3">
        <h5 class="fw-bold text-primary mb-1">🎯 Setup Goals Kamu</h5>
        <p class="text-muted small mb-3">Bangun kebiasaan baru untuk bantu kamu berkembang setiap hari!</p>

        <div class="tab-header">
            <button class="tab-button active" onclick="showTab(0)">💡 Rekomendasi</button>
            <button class="tab-button" onclick="showTab(1)">✍️ Custom</button>
        </div>

        <div id="tabContent">
            {{-- Tab 1: AI Recommendation --}}
            <div class="tab-card tab-pane active" id="tab-0">
                <h6 class="fw-semibold mb-3">Rekomendasi AI</h6>
                <form id="promptForm" method="POST" onsubmit="event.preventDefault(); generateRecommendations();">
                    <div class="mb-3">
                        <label for="userPrompt">Masukkan Prompt Anda</label>
                        <input type="text" class="form-control rounded-3" id="userPrompt" name="userPrompt" required placeholder="Contoh: Kebiasaan untuk menjadi lebih produktif">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 fw-semibold py-2">🎯 Dapatkan Rekomendasi</button>
                    </div>
                </form>

                <div id="recommendations" class="mt-4" style="display: none;">
                    <h6 class="fw-semibold mb-3">Rekomendasi Kebiasaan</h6>
                    <ul class="list-group list-group-flush mb-0">
                        <li class="list-group-item">
                            <input type="checkbox" id="habit1" name="habits[]" value="Baca buku 10 halaman per hari">
                            📚 Baca buku 10 halaman per hari
                            <input type="hidden" name="strategies[]" value="Atur waktu untuk membaca setiap hari di pagi hari">
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="habit2" name="habits[]" value="Jalan kaki 5000 langkah">
                            👟 Jalan kaki 5000 langkah
                            <input type="hidden" name="strategies[]" value="Gunakan aplikasi pedometer untuk mengukur langkah">
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="habit3" name="habits[]" value="Menulis jurnal harian">
                            📝 Menulis jurnal harian
                            <input type="hidden" name="strategies[]" value="Tulis 3 hal positif setiap malam sebelum tidur">
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="habit4" name="habits[]" value="Meditasi 10 menit setiap pagi">
                            🧘 Meditasi 10 menit setiap pagi
                            <input type="hidden" name="strategies[]" value="Gunakan aplikasi meditasi dengan panduan audio">
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" id="habit5" name="habits[]" value="Belajar coding selama 1 jam">
                            💻 Belajar coding selama 1 jam
                            <input type="hidden" name="strategies[]" value="Sediakan waktu satu jam di pagi hari untuk belajar coding">
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Tab 2: Custom Goal Form --}}
            <div class="tab-card tab-pane" id="tab-1">
                <form method="POST" action="{{ route('setup.goals.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label for="goal_name">Nama Goal</label>
                        <input type="text" class="form-control rounded-3" id="goal_name" name="goal_name" required placeholder="Contoh: Belajar Laravel">
                    </div>

                    <div class="mb-2">
                        <label for="deadline">Deadline</label>
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

            // Show the recommendations section after generating
            recommendationsSection.style.display = 'block';

            // Placeholder: log prompt (you can replace with real logic/API)
            console.log('Prompt Submitted: ' + prompt);
        }
    </script>
@endsection
