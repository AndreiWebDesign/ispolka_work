<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>DocSTROI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #F4F5FF;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            min-width: 240px;
            background-color: #ffffff;
            border-right: 1px solid #E6E9F0;
        }

        .sidebar-nav .nav-link {
            color: #5F6C8B;
            padding: 10px 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .sidebar-nav .nav-link:hover {
            background-color: #F0F2FF;
            color: #3A47EC;
        }

        .nav-link.active {
            background-color: #E6E9FF;
            color: #3A47EC !important;
        }

        .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .sidebar .logout {
            color: #A0A4B8;
            font-size: 0.95rem;
        }

        /* Logo */
        .logo {
            height: 48px;
        }

        /* Avatar / Profile pic */
        .profile-pic {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .main-content {
            background-color: #F8F9FC;
            border-radius: 20px;
            padding: 32px;
            min-height: 100vh;
        }

        .card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .app-card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .btn-outline-primary {
            border-radius: 8px;
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .text-muted {
            color: #7E879D !important;
        }

        .nav-link.logout:hover {
            color: #3A47EC;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                padding: 16px;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
<div class="d-flex min-vh-100">

    <!-- Sidebar -->
    <aside class="sidebar p-4 d-flex flex-column shadow-sm">
        <div class="mb-5 d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/logo.png') }}" alt="Логотип" class="logo">
        </div>

        <nav class="flex-grow-1 sidebar-nav">
            <ul class="nav flex-column gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-grid"></i> Главная
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}"
                       href="{{ route('projects.index') }}">
                        <i class="bi bi-file-earmark-text"></i> Текущие объекты
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('payments.index') ? 'active' : '' }}"
                       href="{{ route('payments.index') }}">
                        <i class="bi bi-cash"></i> Оплата
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                       href="{{ route('profile.index') }}">
                        <i class="bi bi-person-circle"></i> Личный кабинет
                    </a>
                </li>
            </ul>
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="nav-link logout d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-2"></i> Выйти
            </a>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow-1 main-content">
        @yield('content')
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
