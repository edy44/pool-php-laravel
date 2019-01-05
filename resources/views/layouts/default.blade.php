<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ 'Paris-Pigeons.fr' }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/default.css') }}" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-expand-md navbar-dark fixed-top">
            <a class="navbar-brand" href="{{ route('matches') }}">Paris-Pigeons.fr</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('matches') }}">Calendrier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('teams') }}">Equipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('players') }}">Joueurs</a>
                    </li>
                    @if(!\Illuminate\Support\Facades\Auth::check())
                        <li>
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('my-bets') }}">Mes Paris</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profil') }}">Mon Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('matches.index') }}">Administration</a>
                        </li>
                        <li class="nav-item mt-2 mt-md-0">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        <li>
                    @endif
                </ul>
            </div>
        </nav>

        <div class="container">
            @foreach(['danger', 'warning', 'success', 'info'] as $key)
                @if(\Illuminate\Support\Facades\Session::has($key))
                    <p class="alert alert-{{ $key }}">{{ \Illuminate\Support\Facades\Session::get($key) }}</p>
                @endif
            @endforeach
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container">
                <span class="text-muted">Place sticky footer content here.</span>
            </div>
        </footer>

    </body>
</html>
