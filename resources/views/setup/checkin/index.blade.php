@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Check-In</h2>
        <form method="POST" action="{{ route('checkin.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="challenge" class="form-label">Apa tantangan terbesarmu hari ini?</label>
                <select class="form-control mb-2" id="challenge" name="challenge">
                    <option value="">Pilih tantangan</option>
                    <option value="Motivasi rendah">Motivasi rendah</option>
                    <option value="Terlalu banyak pekerjaan">Terlalu banyak pekerjaan</option>
                    <option value="Kurang fokus">Kurang fokus</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <input type="text" class="form-control" id="custom_challenge" name="custom_challenge" placeholder="Tulis tantanganmu (opsional)">

                <label for="mood" class="form-label mt-3">Bagaimana moodmu hari ini?</label>
                <select class="form-control mb-2" id="mood" name="mood">
                    <option value="">Pilih mood</option>
                    <option value="Senang">Senang</option>
                    <option value="Biasa saja">Biasa saja</option>
                    <option value="Sedih">Sedih</option>
                    <option value="Stres">Stres</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection