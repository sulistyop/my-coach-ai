<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .custom-bottom{
            bottom: 0;
            position: fixed;
            width:390px;
        }

        .bottom-plus {
            bottom: 80px;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 30px;
            margin-bottom: 20px;
        }

        .mobile-notification {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #e6fffb;
            border: 1px solid #87e8de;
            border-radius: 1rem;
            padding: 1rem;
            width: 70%;
            max-width: 320px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        }

        .notification-content {
            display: flex;
            align-items: center;
        }

        .notification-icon {
            font-size: 1.75rem;
            margin-right: 0.75rem;
        }

        .notification-text strong {
            font-size: 1rem;
            color: #08979c;
        }

        .notification-text .small-text {
            display: block;
            font-size: 0.85rem;
            color: #595959;
            margin-top: 0.25rem;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translate(-50%, 20px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }


    </style>

    @stack('styles')
</head>
<body>
<div class="mobile-wrapper">
@auth
    <nav class="navbar navbar-light bg-white border-bottom">
        <div class="container-fluid justify-content-between">
            <span class="navbar-brand mb-0 h6">MyAI Coach</span>

               {{--notification button--}}
                <a href="#" class="text-decoration-none text-muted">
                    <i class="bi bi-bell fs-4"></i>
                </a>

        </div>
    </nav>

    @if(session('success'))
        <div id="pushNotification" class="mobile-notification">
            <div class="notification-content">
                <div class="notification-icon">✅</div>
                <div class="notification-text">
                    <strong>Sukses!</strong>
                    <span class="small-text">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif
    @endauth

    <div class="p-3 mb-5">
        @yield('content')
    </div>
    @auth
    <nav class="navbar mt-3 sticky-bottom navbar-light bg-white border-top shadow-sm d-flex justify-content-around py-2 bottom-0 custom-bottom">
        <a href="{{ route('home') }}" class="text-center text-decoration-none {{ request()->routeIs('home') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-house-door-fill fs-4 d-block"></i>
            <small style="font-size: 0.8rem;">Home</small>
        </a>

        <a href="{{ route('goals') }}" class="text-center text-decoration-none {{ request()->routeIs('goals') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-bullseye fs-4 d-block"></i>
            <small style="font-size: 0.8rem;">Goals</small>
        </a>
        <a href="{{ route('habits') }}" class="text-center text-decoration-none {{ request()->routeIs('habits') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-list-check fs-4 d-block"></i>
            <small style="font-size: 0.8rem;">Habits</small>
        </a>

        <a href="{{ route('streak') }}" class="text-center text-decoration-none {{ request()->routeIs('streak') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-fire fs-4 d-block"></i>
            <small style="font-size: 0.8rem;">Streak</small>
        </a>

        {{--Profile--}}
        <a href="{{ route('profile') }}" class="text-center text-decoration-none {{ request()->routeIs('profile') ? 'text-success' : 'text-muted' }}">
            <i class="bi bi-person-circle fs-4 d-block"></i>
            <small style="font-size: 0.8rem;">Profile</small>
        </a>
    </nav>
    @endauth


</div>

@yield('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notif = document.getElementById('pushNotification');
        if (notif) {
            setTimeout(() => {
                notif.style.display = 'none';
            }, 5000);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>