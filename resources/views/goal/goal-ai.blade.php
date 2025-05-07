@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Progress bar dan tombol kembali -->
    <div class="d-flex align-items-center mb-4">
        <a href="#" class="me-3 text-dark">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <div class="progress flex-grow-1" style="height: 6px;">
            <div class="progress-bar bg-primary" style="width: 50%;"></div>
        </div>
    </div>

    <!-- Judul dan deskripsi -->
    <h4 class="fw-bold text-primary">Rekomendasi Goals Anda</h4>
    <p class="text-muted">
        Berikut adalah rekomendasi goals berdasarkan input Anda: <strong>{{ $userPrompt }}</strong>
    </p>

    <!-- Label -->
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
        <button class="btn btn-primary fw-bold py-2">Selanjutnya</button>
    </div>
</div>

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
@endsection
