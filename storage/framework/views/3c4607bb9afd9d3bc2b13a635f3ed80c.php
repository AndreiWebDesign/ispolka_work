<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>eCTN — Конструктор исполнительной документации</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS и иконки -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

<header class="container py-4 d-flex justify-content-between align-items-center">
    <div class="fw-bold fs-3 text-primary">eCTN</div>
    <nav class="d-flex align-items-center flex-wrap">
        <a href="#features" class="btn btn-link text-decoration-none mx-2">Возможности</a>
        <a href="#howitworks" class="btn btn-link text-decoration-none mx-2">Как это работает</a>
        <a href="#testimonials" class="btn btn-link text-decoration-none mx-2">Отзывы</a>
        <a href="#faq" class="btn btn-link text-decoration-none mx-2">FAQ</a>
        <a href="#pricing" class="btn btn-link text-decoration-none mx-2">Тарифы</a>
        <a href="#contact" class="btn btn-link text-decoration-none mx-2">Контакты</a>
        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary mx-2">Войти</a>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary mx-2">Регистрация</a>
    </nav>
</header>

<main class="container flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center">
    <h1 class="display-4 fw-bold mb-3">Создавайте исполнительную документацию <span class="text-primary">онлайн</span> для строительства в РК</h1>
    <p class="lead mb-4">Быстро, удобно и в полном соответствии с законодательством Казахстана.</p>
    <a href="#start" class="btn btn-primary btn-lg px-5 shadow-sm mb-5">Попробовать бесплатно</a>

    
    <section class="row justify-content-center g-4 mt-4 w-100" id="features">
        <div class="col-md-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="mb-3 fs-2 text-primary"><i class="bi bi-lightning-charge"></i></div>
                    <h5 class="card-title fw-semibold">Автоматизация</h5>
                    <p class="card-text">Мгновенное формирование документов по актуальным шаблонам РК.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="mb-3 fs-2 text-primary"><i class="bi bi-shield-check"></i></div>
                    <h5 class="card-title fw-semibold">Соответствие стандартам</h5>
                    <p class="card-text">Все формы соответствуют нормам и требованиям законодательства.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="mb-3 fs-2 text-primary"><i class="bi bi-clock-history"></i></div>
                    <h5 class="card-title fw-semibold">Экономия времени</h5>
                    <p class="card-text">Оформление документов в 5 раз быстрее.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="mt-5 w-100" id="howitworks">
        <h2 class="fw-bold mb-4">Как это работает</h2>
        <div class="row text-start justify-content-center">
            <div class="col-md-4">
                <h5>1. Зарегистрируйтесь</h5>
                <p>Создайте аккаунт за 1 минуту.</p>
            </div>
            <div class="col-md-4">
                <h5>2. Заполните шаблоны</h5>
                <p>Выберите нужные формы и заполните данные.</p>
            </div>
            <div class="col-md-4">
                <h5>3. Скачайте PDF</h5>
                <p>Готовая исполнительная документация в один клик.</p>
            </div>
        </div>
    </section>

    
    <section class="mt-5 w-100" id="testimonials">
        <h2 class="fw-bold mb-4">Отзывы пользователей</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <blockquote class="blockquote">
                    <p class="mb-0">Очень удобно и быстро. Сэкономили много времени на оформлении актов.</p>
                    <footer class="blockquote-footer">Айгуль, инженер ПТО</footer>
                </blockquote>
            </div>
            <div class="col-md-6">
                <blockquote class="blockquote">
                    <p class="mb-0">Теперь вся исполнительная документация хранится в одном месте!</p>
                    <footer class="blockquote-footer">Жанибек, прораб</footer>
                </blockquote>
            </div>
        </div>
    </section>

    
    <section class="mt-5 w-100" id="faq">
        <h2 class="fw-bold mb-4">Часто задаваемые вопросы</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        Как начать пользоваться сервисом?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Зарегистрируйтесь и начните с бесплатной версии без ограничений по времени.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Можно ли выгружать документы в PDF?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Да, вы можете экспортировать документы в формате PDF в любой момент.
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="bg-primary text-white text-center py-3 mt-auto" id="contact">
    &copy; 2025 eCTN. Все права защищены.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/ispolka/resources/views/welcome.blade.php ENDPATH**/ ?>