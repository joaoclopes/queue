<header>
    <nav>
        <ul class="nav-items">
            <li>
                <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active' : '' }}">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('users.index') }}" class="{{ Request::is('users') ? 'active' : '' }}">
                    Usuarios
                </a>
            </li>
            <li>
                <a href="{{ route('events.index') }}" class="{{ Request::is('events') ? 'active' : '' }}">
                    Eventos
                </a>
            </li>
            <li>
                <a href="{{ route('batches.index') }}" class="{{ Request::is('batches') ? 'active' : '' }}">
                    Lotes
                </a>
            </li>
            <li>
                <a href="" class="{{ Request::is('queue') ? 'active' : '' }}">
                    Acompanhar fila
                </a>
            </li>
        </ul>
    </nav>
</header>

<link rel="stylesheet" href="{{ asset('css/header.css') }}">