@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Setup Options</h2>
        <p>Silakan pilih langkah berikut:</p>
        <form method="POST" action="{{ route('auth.setup.process') }}">
            @csrf
            <div>
                <label>
                    <input type="checkbox" name="setup_habits" value="1">
                    Apakah mau Setting Habits?
                </label>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="setup_goals" value="1">
                    Apakah mau Setup Goals?
                </label>
            </div>
            <button type="submit">Simpan dan Lanjutkan</button>
        </form>
    </div>
@endsection