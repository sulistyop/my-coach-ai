@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="mb-4">
            <h4 class="fw-bold text-primary">📝 Daily Check-In</h4>
            <p class="text-muted">Bagikan tantangan dan mood-mu hari ini agar kamu lebih sadar dan terarah.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <form method="POST" action="{{ route('checkin.submit') }}">
                    @csrf

                    <!-- Challenge Section -->
                    <div class="mb-3">
                        <label for="challenge" class="form-label fw-semibold">
                            🎯 Apa tantangan terbesarmu hari ini?
                        </label>
                        <select class="form-select rounded-3 mb-2" id="challenge" name="challenge">
                            <option value="">Pilih tantangan</option>
                            <option value="Motivasi rendah">Motivasi rendah</option>
                            <option value="Terlalu banyak pekerjaan">Terlalu banyak pekerjaan</option>
                            <option value="Kurang fokus">Kurang fokus</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>

                        <textarea type="text" class="form-control rounded-3" id="custom_challenge" name="custom_challenge"
                                  placeholder="Tulis tantanganmu (opsional)" rows="3" style="resize: both;"></textarea>
                    </div>

                    <!-- Mood Section -->
                    <div class="mb-3">
                        <label for="mood" class="form-label fw-semibold">
                            😄 Bagaimana moodmu hari ini?
                        </label>
                        <select class="form-select rounded-3" id="mood" name="mood">
                            <option value="">Pilih mood</option>
                            <option value="Senang">Senang</option>
                            <option value="Biasa saja">Biasa saja</option>
                            <option value="Sedih">Sedih</option>
                            <option value="Stres">Stres</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success rounded-3">
                            Submit ✅
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
