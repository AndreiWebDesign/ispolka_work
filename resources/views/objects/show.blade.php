@extends('layouts.app')
@section('title', 'Объект: ' . ($passport->object_name ?? $passport->id))

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Объект: {{ $passport->object_name ?? $passport->id }}</h2>

        <div class="mb-4">
            <a href="{{ route('acts.create', $passport) }}" class="btn btn-success">Создать акт</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h4>Список актов</h4>
        @if ($acts->isEmpty())
            <div class="alert alert-info">Для этого объекта ещё нет актов.</div>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№ акта</th>
                    <th>Дата</th>
                    <th>Тип</th>
                    <th>Подпись</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($acts as $act)
                    <tr>
                        <td>{{ $act->act_number }}</td>
                        <td>{{ $act->act_date }}</td>
                        <td>{{ $act->type ?? '-' }}</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm"
                                    onclick="signAct({{ $act->id }})">
                                <i class="bi bi-pen"></i> Подписать и скачать
                            </button>
                            <div id="output-{{ $act->id }}" class="small text-muted mt-1"></div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        (() => {
            const NativeWS = WebSocket;
            window.WebSocket = function (url, ...rest) {
                if (typeof url !== 'string') {
                    console.warn('⚠️ WebSocket URL не строка:', url);
                }
                console.trace('WebSocket URL →', url);
                return new NativeWS(url, ...rest);
            };
        })();
    </script>
    <script src="/js/ncalayer-client.js"></script>
    <script>
        async function signAct(actId) {
            const outputEl = document.getElementById('output-' + actId);
            const setStatus = txt => outputEl.textContent = txt;

            try {
                setStatus('📥 Запрос хэша PDF…');

                // Шаг 1: Получение Base64-хэша PDF с сервера
                const res = await fetch(`/pdf/hash/${actId}`);
                if (!res.ok) throw new Error(await res.text());

                const data = await res.json();
                const hashBase64 = data.base64hash;

                // Шаг 2: Инициализация клиента NCALayer
                const logo = await fetch('/images/nca-logo.png')
                    .then(res => res.blob())
                    .then(blob => new Promise(resolve => {
                        const reader = new FileReader();
                        reader.onload = () => resolve(reader.result.split(',')[1]); // base64
                        reader.readAsDataURL(blob);
                    }));

                const nclSignClient = new NCALayerClient('wss://127.0.0.1:13579');
                nclSignClient.setLogoForBasicsSign(logo); // ← base64 строка изображения
                nclSignClient.onerror = console.error;
                await nclSignClient.connect();

                setStatus('✍️ Подписание хэша PDF…');

                // Шаг 3: Подпись хэша
                const cms = await nclSignClient.createCAdESFromBase64Hash(
                    "PKCS12",
                    hashBase64,
                    "SIGNATURE"
                );

                // Шаг 4: Отправка CMS на сервер
                setStatus('📤 Отправка подписи…');

                const form = new FormData();
                form.append('cms', cms);
                form.append('id', actId);

                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const resp = await fetch('/pdf/sign', {
                    method: 'POST',
                    body: form,
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    }
                });


                if (!resp.ok) throw new Error(await resp.text());

                // Шаг 5: Получение и скачивание подписанного PDF
                const blob = await resp.blob();
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = `Акт_подписанный_${actId}.pdf`;
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);

                setStatus('✅ Подписано и загружено!');
            } catch (err) {
                console.error(err);
                setStatus('❌ Ошибка: ' + err.message);
            }
        }
    </script>

@endsection
