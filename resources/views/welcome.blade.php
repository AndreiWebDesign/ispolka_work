<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>DocSTROI — Документация для строителей</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap и иконки -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            scroll-behavior: smooth;
        }
        .card:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-5px);
            transition: 0.3s;
        }
        header a:hover {
            text-decoration: underline;
        }
        .price-card {
            transition: 0.3s;
        }
        .price-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<!-- Header -->
<header class="bg-white border-bottom">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <div class="fs-3 fw-bold text-primary">DocSTROI</div>
        <nav class="d-flex align-items-center gap-4">
            <a href="#features" class="text-dark text-decoration-none">Возможности</a>
            <a href="#how" class="text-dark text-decoration-none">Как работает</a>
            <a href="#pricing" class="text-dark text-decoration-none">Тарифы</a>
            <a href="#contact" class="text-dark text-decoration-none">Контакты</a>
        </nav>
        <div class="d-flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Войти</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
        </div>
    </div>
</header>

<!-- Hero -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Создавайте исполнительную документацию онлайн</h1>
                <p class="lead mt-3 mb-4">Платформа DocSTROI — это быстрый способ формировать акты и документы, соответствующие стандартам РК.</p>
                <a href="#pricing" class="btn btn-primary btn-lg px-4">Попробовать бесплатно</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://assets.kpmg.com/content/dam/kpmg/xx/images/2017/11/international-tax-banner.jpg/jcr:content/renditions/original" alt="Demo Screenshot" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section id="features" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4">Возможности</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="fs-2 text-primary mb-2"><i class="bi bi-lightning-charge-fill"></i></div>
                        <h5 class="card-title fw-semibold">Автоматизация</h5>
                        <p class="card-text">Генерация документов в 1 клик на основе утверждённых шаблонов.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="fs-2 text-primary mb-2"><i class="bi bi-check2-circle"></i></div>
                        <h5 class="card-title fw-semibold">Юридическая точность</h5>
                        <p class="card-text">Все формы соответствуют действующим строительным нормам РК.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="fs-2 text-primary mb-2"><i class="bi bi-clock-history"></i></div>
                        <h5 class="card-title fw-semibold">Экономия времени</h5>
                        <p class="card-text">Заполнение документов в 5 раз быстрее обычного.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How it works -->
<section id="how" class="py-5 bg-white">
    <div class="container">
        <h2 class="fw-bold mb-4">Как работает сервис</h2>
        <div class="d-flex justify-content-around text-center flex-wrap">
            <div class="flex-grow-1 mx-2">
                <div class="mb-3">
                    <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5>Зарегистрируйтесь</h5>
                <p>Создайте личный кабинет и получите доступ ко всем функциям.</p>
            </div>
            <div class="flex-grow-1 mx-2">
                <div class="mb-3">
                    <i class="bi bi-pencil-square text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5>Заполните шаблон</h5>
                <p>Выберите акт, внесите данные и система подготовит документ.</p>
            </div>
            <div class="flex-grow-1 mx-2">
                <div class="mb-3">
                    <i class="bi bi-file-earmark-pdf text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5>Скачайте PDF</h5>
                <p>Готовый документ можно сразу скачать или подписать ЭЦП.</p>
            </div>
        </div>
    </div>
</section>


<!-- Pricing -->
<section id="pricing" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Тарифы</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card price-card text-center border-primary">
                    <div class="card-header bg-primary text-white fw-bold">Free</div>
                    <div class="card-body">
                        <h3 class="card-title">0₸</h3>
                        <p class="card-text">Для небольших проектов и тестирования.</p>
                        <ul class="list-unstyled">
                            <li>✔ 5 документов в месяц</li>
                            <li>✔ Поддержка email</li>
                            <li>✖ Подпись ЭЦП</li>
                        </ul>
                        <a href="#" class="btn btn-outline-primary mt-3">Начать</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card price-card text-center border-success">
                    <div class="card-header bg-success text-white fw-bold">Pro</div>
                    <div class="card-body">
                        <h3 class="card-title">2₸/мес</h3>
                        <p class="card-text">Подходит для малого бизнеса и подрядчиков.</p>
                        <ul class="list-unstyled">
                            <li>✔ 100 документов в месяц</li>
                            <li>✔ Электронная подпись</li>
                            <li>✔ Хранение в облаке</li>
                        </ul>
                        <a href="#" class="btn btn-success mt-3">Подключить</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card price-card text-center border-dark">
                    <div class="card-header bg-dark text-white fw-bold">Enterprise</div>
                    <div class="card-body">
                        <h3 class="card-title">по договору</h3>
                        <p class="card-text">Индивидуальные решения для крупных проектов.</p>
                        <ul class="list-unstyled">

                            <li>✔ неограниченное документов в месяц</li>
                            <li>✔ API-доступ</li>
                            <li>✔ Интеграции</li>
                        </ul>
                        <a href="#" class="btn btn-dark mt-3">Запросить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer id="contact" class="bg-primary text-white py-4 mt-auto">
    <div class="container text-center">
        &copy; 2025 DocSTROI. Все права защищены. | <a href="mailto:info@DocSTROI.kz" class="text-white text-decoration-underline">info@DocSTROI.kz</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
