<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyAI Coach</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--bootstrap cdn--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
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

    <div class="p-3">
        @yield('content')
    </div>
</div>
</body>
</html>