@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Progress bar dan tombol kembali -->
    <div class="d-flex align-items-center mb-4">
        <a href="#" class="me-3 text-dark" id="backButton" style="display: none;">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <div class="progress flex-grow-1" style="height: 6px;">
            <div class="progress-bar bg-primary" id="progressBar" style="width: 50%;"></div>
        </div>
    </div>

    <!-- Step 1 -->
    <div id="step1">
        <h4 class="fw-bold text-primary">Rekomendasi Goals Anda</h4>
        <p class="text-muted">
            Berikut adalah rekomendasi goals berdasarkan input Anda: <strong>{{ $userPrompt }}</strong>
        </p>
        <p class="text-muted mb-2">Pilih goals yang paling sesuai dengan kebutuhan Anda:</p>

        <!-- Loader -->
        <div id="loader" class="text-center my-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Daftar checkbox -->
        <div id="goals-container" style="display: none;">
            <!-- Data akan dimasukkan di sini melalui JavaScript -->
        </div>

        <!-- Tombol Selanjutnya -->
        <div class="d-grid mt-4">
            <button id="nextButton" class="btn btn-primary fw-bold py-2">Selanjutnya</button>
        </div>
    </div>

    <!-- Step 2 -->
    <div id="step2" style="display: none;">
        <h4 class="fw-bold text-primary">Tambahkan Goals Anda</h4>
        <p class="text-muted mb-2">Masukkan habit dan strategi Anda sendiri:</p>

        <!-- Form input goals dalam format tabel -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 80%">Habit & Strategi</th>
                        <th style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="customGoalsContainer">
                    <tr class="goal-row">
                        <td>
                            <div class="mb-2">
                                <input type="text" class="form-control" placeholder="Habit" name="habit[]">
                            </div>
                            <div>
                                <input type="text" class="form-control" placeholder="Strategi" name="strategy[]">
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <button class="btn btn-danger btn-sm removeGoal" type="button">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button id="addGoalButton" class="btn btn-secondary">
                                <i class="bi bi-plus"></i> Tambah 
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Tombol Simpan -->
        <div class="d-grid mt-4">
            <button id="saveButton" class="btn btn-primary fw-bold py-2">Simpan</button>
        </div>
    </div>

</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('loader');
        const goalsContainer = document.getElementById('goals-container');
        var userPrompt = '{{ $userPrompt }}';

        // Tampilkan halaman terlebih dahulu tanpa fetch
        loader.style.display = 'none';
        goalsContainer.style.display = 'block';

        // Setelah halaman selesai dirender, lakukan fetch data
        setTimeout(() => {
            loader.style.display = 'block';
            goalsContainer.style.display = 'none';

            fetch('{{ route('store-goals') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ goal: userPrompt })
            })
            .then(response => response.json())
            .then(data => {
                loader.style.display = 'none';
                goalsContainer.style.display = 'block';

                if (data && Array.isArray(data)) {
                    data.forEach((goal, index) => {
                        const card = document.createElement('div');
                        card.className = 'card mb-3 border-0 shadow-sm';
                        card.innerHTML = `
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">${goal.habit}</h6>
                                    <p class="mb-0 text-muted small">${goal.strategy}</p>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkbox${index}">
                                </div>
                            </div>
                        `;
                        goalsContainer.appendChild(card);
                    });
                } else {
                    goalsContainer.innerHTML = '<p class="text-muted">Tidak ada tujuan yang tersedia saat ini.</p>';
                }
            })
            .catch(error => {
                loader.style.display = 'none';
                goalsContainer.style.display = 'block';
                goalsContainer.innerHTML = '<p class="text-danger">Gagal memuat data. Silakan coba lagi.</p>';
                console.error('Error fetching goals:', error);
            });
        }, 0); // Timeout untuk memastikan halaman selesai dirender
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const nextButton = document.getElementById('nextButton');
        const backButton = document.getElementById('backButton');
        const progressBar = document.getElementById('progressBar');
        const addGoalButton = document.getElementById('addGoalButton');
        const customGoalsContainer = document.getElementById('customGoalsContainer');
        var userPrompt = '{{ $userPrompt }}';

        // Pindah ke Step 2
        nextButton.addEventListener('click', function () {
            // Validasi: Pastikan ada checkbox yang dipilih
            const selectedGoals = document.querySelectorAll('#goals-container .form-check-input:checked');
            if (selectedGoals.length === 0) {
                alert('Silakan pilih setidaknya satu goal sebelum melanjutkan.');
                return;
            }

            // Jika validasi lolos, pindah ke Step 2
            step1.style.display = 'none';
            step2.style.display = 'block';
            backButton.style.display = 'inline-block';
            progressBar.style.width = '100%';
        });

        // Kembali ke Step 1
        backButton.addEventListener('click', function () {
            step2.style.display = 'none';
            step1.style.display = 'block';
            backButton.style.display = 'none';
            progressBar.style.width = '50%';
        });

        // Tambah input goal baru
        addGoalButton.addEventListener('click', function () {
            const newRow = document.createElement('tr');
            newRow.className = 'goal-row';
            newRow.innerHTML = `
                <td>
                    <div class="mb-2">
                        <input type="text" class="form-control" placeholder="Habit" name="habit[]">
                    </div>
                    <div>
                        <input type="text" class="form-control" placeholder="Strategi" name="strategy[]">
                    </div>
                </td>
                <td class="text-center align-middle">
                    <button class="btn btn-danger btn-sm removeGoal" type="button">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            customGoalsContainer.appendChild(newRow);

            // Tambahkan event listener untuk tombol hapus
            newRow.querySelector('.removeGoal').addEventListener('click', function () {
                newRow.remove();
            });
        });

        // Event listener untuk tombol hapus pada goal pertama
        customGoalsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('removeGoal')) {
                e.target.closest('.goal-row').remove();
            }
        });

        // Simpan goals
        document.getElementById('saveButton').addEventListener('click', function () {
            // Ambil data dari goals yang dipilih (checkbox)
            const selectedGoals = Array.from(document.querySelectorAll('#goals-container .form-check-input:checked')).map(checkbox => {
                const card = checkbox.closest('.card-body');
                return {
                    habit: card.querySelector('h6').textContent.trim(),
                    strategy: card.querySelector('p').textContent.trim()
                };
            });

            // Ambil data dari goals yang diisi sendiri
            const customGoals = Array.from(document.querySelectorAll('.goal-row')).map(row => {
                return {
                    habit: row.querySelector('input[name="habit[]"]').value.trim(),
                    strategy: row.querySelector('input[name="strategy[]"]').value.trim()
                };
            });

            // Gabungkan kedua data
            const allGoals = [...selectedGoals, ...customGoals];

            console.log('All Goals:', allGoals);

            // Kirim data ke server
            fetch('{{ route('store-habits-result') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    goals: allGoals,
                    goal_name: userPrompt 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Goals berhasil disimpan!');
                    console.log(data);
                    window.location.href = '{{ route('home') }}';
                } else {
                    alert(`Gagal menyimpan goals: ${data.message}`);
                    console.error('Error:', data.error);
                }
            })
            .catch(error => {
                console.error('Error saving goals:', error);
                alert('Gagal menyimpan goals. Silakan coba lagi.');
            });
        });
    });
</script>
