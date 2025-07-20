<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подписание PDF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- NCALayer JS (из репозитория NCALayerJSExample) -->
    <script id="ncalayerScript" src="/js/ncalayer.js"></script>       <!-- id нужен, чтобы отследить onload/onerror -->
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4">Подпись PDF</h1>

    <form id="uploadForm" class="mb-3">
        <input class="form-control mb-3" type="file" id="pdfFile" accept="application/pdf" required>
        <button class="btn btn-primary" type="submit">Загрузить и подписать</button>
    </form>

    <div id="signedBlock" class="d-none">
        <a id="downloadLink" class="btn btn-success">Скачать подписанный PDF</a>
    </div>
</div>

<script>
    /* ---------- Проверяем, что ncalayer.js действительно загрузился ---------- */
    let ncalayerReady = false;

    const scriptEl = document.getElementById('ncalayerScript');

    scriptEl.onload = () => {
        ncalayerReady = typeof window.NCALayer === 'object' &&
            typeof window.NCALayer.signPdf === 'function';

        if (!ncalayerReady) {
            alert('Файл ncalayer.js загружен, но объект NCALayer или метод signPdf не найден.');
        }
    };

    scriptEl.onerror = () => {
        alert('Не удалось загрузить ncalayer.js. Проверьте путь "/js/ncalayer.js".');
    };

    /* ---------- Основная логика формы ---------- */
    document.getElementById('uploadForm').addEventListener('submit', async e => {
        e.preventDefault();

        if (!ncalayerReady) {
            return alert('Библиотека NCALayer недоступна. Подпись невозможна.');
        }

        const file = document.getElementById('pdfFile').files[0];
        if (!file) return alert('Выберите PDF!');

        // 1. загружаем оригинал на сервер
        const fd = new FormData();
        fd.append('pdf_file', file);

        const { data: { path } } = await axios.post('/pdf-sign/upload', fd,
            { headers: { 'Content-Type': 'multipart/form-data' } });

        // 2. подписываем через NCALayer
        let signedBase64;
        try {
            signedBase64 = await signPdfWithNCALayer(path);
        } catch (err) {
            return alert('Не удалось подписать PDF: ' + err);
        }

        // 3. отправляем подписанный файл и получаем ссылку для скачивания
        const resp = await axios.post('/pdf-sign/download', { signed_pdf: signedBase64 });
        const link = document.getElementById('downloadLink');
        link.href = resp.request.responseURL;
        document.getElementById('signedBlock').classList.remove('d-none');
    });

    /* ---------- Вызов SDK NCALayer ---------- */
    async function signPdfWithNCALayer(storedPath) {
        return new Promise((resolve, reject) => {
            if (!window.NCALayer || typeof window.NCALayer.signPdf !== 'function') {
                return reject('NCALayer SDK недоступен.');
            }
            window.NCALayer.signPdf(
                { filePath: storedPath },
                result => resolve(result.base64),   // onSuccess
                err    => reject(err)               // onError
            );
        });
    }
</script>
</body>
</html>
<?php /**PATH /var/www/ispolka/resources/views/pdfsign/view.blade.php ENDPATH**/ ?>
