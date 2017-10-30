<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('index') }}">
            <img src="{{ asset('img/medium.png') }}" alt="Drecken - Logo" width="56" height="56">
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-end">
            @auth
                <div class="navbar-item has-dropdown is-hoverable">
                    <div class="navbar-link">
                        {{ $user->name }}
                    </div>
                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" href="{{ route('logout') }}">Wyloguj</a>
                    </div>
                </div>
                @else
                    <a class="navbar-item" href="{{ route('twitch') }}">Zaloguj</a>
                    @endauth
        </div>
    </div>
</nav>