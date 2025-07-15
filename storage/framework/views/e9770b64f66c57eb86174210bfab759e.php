<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>PDF с QR-кодом и подписание через NCALayer</title>
</head>
<body>
<h2>1. Загрузите PDF для встраивания QR-кода</h2>
<form action="<?php echo e(route('pdf-qr.generate')); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <input type="file" name="pdf" accept="application/pdf" required>
    <button type="submit">Встроить QR и скачать PDF</button>
</form>

<h2>2. Подпишите PDF через NCALayer</h2>
<input type="file" id="pdfInput" accept="application/pdf" />
<button id="signBtn" disabled>Подписать через NCALayer</button>
<div id="result"></div>

<script>
    let ws, selectedFile, fileBase64;

    function connectNCALayer() {
        ws = new WebSocket("wss://127.0.0.1:13579");
        ws.onopen = function() {
            document.getElementById('signBtn').disabled = false;
            document.getElementById('result').textContent = "NCALayer подключён.";
        };
        ws.onerror = function() {
            document.getElementById('result').textContent = "Ошибка: NCALayer не запущен.";
        };
        ws.onmessage = function(event) {
            let response = JSON.parse(event.data);
            if (response.responseObject) {
                // Сохраняем подписанный PDF
                let byteCharacters = atob(response.responseObject);
                let byteNumbers = new Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                }
                let byteArray = new Uint8Array(byteNumbers);
                let blob = new Blob([byteArray], {type: "application/pdf"});
                let link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = "signed_with_qr.pdf";
                link.click();
                document.getElementById('result').textContent = "Документ подписан и скачан!";
            } else if (response.errorCode) {
                document.getElementById('result').textContent = "Ошибка: " + response.errorCode + "\n" + response.errorMessage;
            }
        };
    }

    document.getElementById('pdfInput').addEventListener('change', function(e) {
        selectedFile = e.target.files[0];
        let reader = new FileReader();
        reader.onload = function(evt) {
            fileBase64 = evt.target.result.split(',')[1];
        };
        if (selectedFile) {
            reader.readAsDataURL(selectedFile);
        }
    });

    document.getElementById('signBtn').addEventListener('click', function() {
        if (!selectedFile || !fileBase64) {
            document.getElementById('result').textContent = "Сначала выберите PDF!";
            return;
        }
        let request = {
            "module": "kz.gov.pki.knca.commonUtils",
            "method": "signBase64",
            "args": [fileBase64, "SIGNATURE", "PKCS12"]
        };
        ws.send(JSON.stringify(request));
        document.getElementById('result').textContent = "Ожидание подписи...";
    });

    window.onload = connectNCALayer;
</script>
</body>
</html>
<?php /**PATH /var/www/ispolka/resources/views/sign-form.blade.php ENDPATH**/ ?>