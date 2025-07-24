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
                    body { background: #F4F5FF; }
                    .sidebar { min-width: 220px; max-width: 240px; }
                    .app-card { border-radius: 16px; box-shadow: 0 1px 6px rgba(33,33,99,0.08); }
                    .nav-link.active { background: #EFF1FC; color: #3A47EC !important; border-radius: 8px; }
                    .sidebar-nav .nav-link { color: #676F8F; }
                    .sidebar-nav .nav-link i { margin-right: 8px; }
                    .sidebar .logout { color: #A0A4B8; }
                    .profile-pic { width:48px; height:48px; border-radius:50%; object-fit:cover; }
                    .card-bg-primary { background: #3A47EC !important; color: #fff !important; }
                    .hiring-card { min-width:150px; max-width:180px; }
                    .recruitment-table tbody tr.selected { background: #EEF0FF; }
                    .calendar-cell.selected { background: #EEF0FF; color: #3A47EC !important; border-radius: 6px; }
                    .app-avatar { width:32px; height:32px; border-radius:50%; object-fit:cover; background: #e9ecef; }
                </style>
            </head>
            <body>
            <div class="d-flex min-vh-100">

                <!-- Sidebar -->
                <aside class="sidebar bg-white p-4 d-flex flex-column shadow-sm">
                    <div class="mb-5 d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Логотип" style="height:  52px;" class="mt-4">

                    </div>
                    <nav class="flex-grow-1 sidebar-nav">
                        <ul class="nav flex-column gap-2">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid"></i>Главная</a>
                            </li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('projects.index') ? 'active' : '' }}" href="{{ route('projects.index') }}" ><i class="bi bi-file-earmark-text"></i>Текущие обьекты</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"> <i class="bi bi-calendar2-week"></i>Отчетность</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"> <i class="bi bi-calendar2-week"></i>Архив</a></li>
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
                <main class="flex-grow-1 px-5 py-4">
                    @yield('content')
                </main>
            </div>
            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            @stack('scripts')
            </body>
            </html>
