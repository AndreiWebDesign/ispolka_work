<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подписание Акта</title>
    <script src="{{ asset('js/ncalayer-client.js') }}"></script>
</head>
<body>
<h2>Подписание документа</h2>
<button onclick="signAct(1)">🔐 Подписать Акт №1</button>
<pre id="output"></pre>

<script>
    async function signAct(id) {
        const output = document.getElementById('output');
        output.textContent = "📦 Получение PDF...";

        const client = new NCALayerClient();
        await client.connect();

        const res = await fetch(`/pdf/prepare/${id}`);
        const { base64, filename } = await res.json();

        output.textContent = "✍️ Подписание...";
        let cms;
        try {
            cms = await client.createCAdESFromBase64(
                NCALayerClient.basicsStorageAll,
                base64,
                "SIGNATURE",
                true
            );
        } catch (err) {
            output.textContent = "❌ Ошибка подписи: " + err.message;
            return;
        }

        output.textContent = "📤 Отправка на сервер...";
        const formData = new FormData();
        formData.append("cms", cms);
        formData.append("id", id);

        const response = await fetch(`{{ route('pdf.sign') }}`, {
            method: "POST",
            body: formData
        });

        if (!response.ok) {
            output.textContent = "❌ Серверная ошибка: " + await response.text();
            return;
        }

        const blob = await response.blob();
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = "Подписанный_акт.pdf";
        a.click();

        output.textContent = "✅ Подписанный документ загружен!";
    }
</script>
</body>
</html>
