<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyAI Coach</title>
    {{--bootstrap cdn--}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            padding: 1rem;
            border-radius: 0.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        body {
            background-color: #F5F5F5; /* Abu-abu lembut */
            font-family: 'Poppins', sans-serif; /* Font modern dan ramah */
        }
        .navbar {
            background-color: #4CAF50; /* Hijau cerah */
            color: white;
        }
        .navbar  {
            color: white;
            border-color: white;
        }
        .card {
            border-radius: 15px; /* Membuat sudut kartu melengkung */
            border: none; /* Menghilangkan border default */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
        }
        .card-header {
            background-color: #FFEB3B; /* Kuning cerah */
            color: #333;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #2196F3; /* Biru cerah */
            border: none;
        }
        .btn-primary:hover {
            background-color: #1976D2; /* Biru lebih gelap */
        }
        .badge {
            font-size: 0.9rem;
        }
        .badge.bg-success {
            background-color: #4CAF50; /* Hijau cerah */
        }
        .text-muted {
            color: #757575 !important; /* Abu-abu lembut */
        }
        .mobile-wrapper {
            max-width: 390px; /* iPhone size */
            margin: auto;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            min-height: 100vh;
            background-color: white;
        }


    </style>
</head>
<body>
<div class="mobile-wrapper">
    <nav class="navbar navbar-light bg-white border-bottom">
        <div class="container-fluid justify-content-between">
            <span class="navbar-brand mb-0 h6">MyAI Coach</span>
            @auth
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-sm btn-outline-secondary">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
        </div>
    </nav>

    <div class="p-3 mb-5">
        @yield('content')
    </div>
    @auth
    <nav class="navbar mt-3 fixed-bottom navbar-light bg-white border-top shadow-sm d-flex justify-content-around py-2 bottom-0">
        <a href="{{ route('home') }}" class="text-center text-decoration-none {{ request()->routeIs('home') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-house-door-fill fs-4 d-block"></i>
            <small>Home</small>
        </a>
        <a href="{{ route('checkin') }}" class="text-center text-decoration-none {{ request()->routeIs('checkin') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-check2-square fs-4 d-block"></i>
            <small>Check-In</small>
        </a>
        <a href="{{ route('streak') }}" class="text-center text-decoration-none {{ request()->routeIs('streak') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-fire fs-4 d-block"></i>
            <small>Streak</small>
        </a>
        <a href="{{ route('habits') }}" class="text-center text-decoration-none {{ request()->routeIs('habits') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-list-check fs-4 d-block"></i>
            <small>Habits</small>
        </a>
        <a href="{{ route('goals') }}" class="text-center text-decoration-none {{ request()->routeIs('goals') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-bullseye fs-4 d-block"></i>
            <small>Goals</small>
        </a>
    </nav>
    @endauth
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>