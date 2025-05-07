@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-3 text-center text-primary">⚙️ Setup Options</h4>
                        <p class="text-center mb-4">Silakan pilih langkah berikut:</p>

                        <form method="POST" action="{{ route('auth.setup.process') }}">
                            @csrf

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="setup_habits" id="setup_habits" value="1">
                                <label class="form-check-label" for="setup_habits">
                                    Apakah mau Setting Habits?
                                </label>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="setup_goals" id="setup_goals" value="1">
                                <label class="form-check-label" for="setup_goals">
                                    Apakah mau Setup Goals?
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success rounded-3">
                                    Simpan dan Lanjutkan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
