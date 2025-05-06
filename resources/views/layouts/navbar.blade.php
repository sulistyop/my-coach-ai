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