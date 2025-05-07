@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-center text-primary">🎯 Setup Goals</h4>

                        <form method="POST" action="{{ route('setup.goals.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="goal_name" class="form-label">Nama Goal</label>
                                <input type="text" class="form-control" id="goal_name" name="goal_name" required>
                            </div>

                            <div class="mb-4">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan dan Lanjut</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
