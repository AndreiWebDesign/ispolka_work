<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'eCTN')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS и иконки -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

<!-- Шапка -->
<div class="container-fluid bg-primary py-2 mb-4">
    <div class="container d-flex align-items-center">
        <span class="fs-3 fw-bold text-white me-3">eCTN</span>
        <span class="text-white ms-auto d-flex align-items-center">
              <div class="dropdown me-3">
    <button class="btn btn-sm btn-light position-relative" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        @php $count = auth()->user()?->unreadNotifications()->count(); @endphp
        @if ($count > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $count }}
            </span>
        @endif
    </button>
   <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notificationsDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">

      @auth
           @foreach(auth()->user()->unreadNotifications as $notification)
               <li class="dropdown-item text-wrap" style="white-space: normal; word-break: break-word;">
            <a href="{{ route('notifications.show', $notification->id) }}" class="text-decoration-none">
                {{ $notification->data['message'] }}
            </a>
        </li>
           @endforeach
       @endauth
    </ul>
</div>
                <i class="bi bi-person-circle ms-3"></i>
                @auth
                <form method="POST" action="{{ route('logout') }}" class="d-inline ms-3">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Выйти</button>
                    </form>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm ms-3">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-light btn-sm ms-2">Регистрация</a>
            @endguest
            </span>
    </div>
</div>

<div class="container flex-grow-1">
    <div class="row">
        <!-- Боковое меню -->
        <div class="col-md-2 mb-4">
            <div class="list-group">
                <a href="{{ url('/') }}" class="list-group-item list-group-item-action {{ request()->is('/') ? 'active' : '' }}">Главная</a>
                <a href="#" class="list-group-item list-group-item-action">Создать документ</a>
                <a href="#" class="list-group-item list-group-item-action">Исполнительная документация</a>
                <a href="{{ route('projects.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('projects.index') ? 'active' : '' }}">Объекты</a>
            </div>
        </div>
        <!-- Контент страницы -->
        <div class="col-md-10 py-4">
            @yield('content')
        </div>
    </div>
</div>

<footer class="bg-primary text-white text-center py-3 mt-auto">
    &copy; {{ date('Y') }} eCTN. Все права защищены.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
