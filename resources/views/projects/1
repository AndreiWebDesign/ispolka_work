@extends('layouts.app')
@section('title', 'Объект: ' . ($passport->object_name ?? $passport->id))

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Объект: {{ $passport->object_name ?? $passport->id }}</h2>

        @if ($role === 'подрядчик')
            <div class="mb-4">
                <a href="{{ route('acts.create', $passport) }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> Создать акт
                </a>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
            </div>
        @endif
        @if(auth()->user()->role === 'подрядчик')
            <div class="mb-3">
                <form method="POST" action="{{ route('projects.invite', $passport) }}" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-sm-4">
                        <label for="bin" class="form-label mb-1">БИН приглашаемой организации</label>
                        <input name="bin" required id="bin" class="form-control" placeholder="Введите БИН">
                    </div>
                    <div class="col-sm-4">
                        <label for="role" class="form-label mb-1">Роль</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="" disabled selected>Выберите роль</option>
                            <option value="технадзор">Технический надзор</option>
                            <option value="авторнадзор">Авторский надзор</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-plus me-1"></i> Пригласить
                        </button>
                    </div>
                </form>
            </div>
        @endif
        <h4 class="mb-3">Список актов</h4>



        @if ($acts->isEmpty())
            <div class="alert alert-info my-4">
                Для этого объекта ещё нет актов.
            </div>
        @else
            <div class="table-responsive mt-3">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">№ акта</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Подпись</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($acts as $act)
                        <tr>
                            <td>{{ $act->act_number }}</td>
                            <td>{{ $act->act_date }}</td>
                            <td>{{ $act->type ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="signAct({{ $act->id }})">
                                        <i class="bi bi-pen me-1"></i> Подписать и скачать
                                    </button>

                                    <a href="{{ route('pdf.view', $act->id) }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                        <i class="bi bi-eye me-1"></i> Просмотреть
                                    </a>

                                    @if (!empty($cmsFiles[$act->id]) && $cmsFiles[$act->id])
                                        <a href="{{ route('cms.download', $act->id) }}" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-download me-1"></i> Скачать CMS
                                        </a>
                                    @endif
                                </div>
                                <div id="output-{{ $act->id }}" class="small text-muted mt-1"></div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        async function signAct(actId) {
            const output = document.getElementById('output-' + actId);
            const setStatus = msg => output.textContent = msg;

            try {
                setStatus('📥 Загружаем PDF...');
                const base64pdf = await fetch(`/pdf/base64/${actId}`)
                    .then(r => r.json())
                    .then(data => data.base64); // должна быть именно строка вида "JVBERi0xL..."

                setStatus('🔌 Подключение к NCALayer...');
                const ncl = new NCALayerClient();
                await ncl.connect();

                const tokens = await ncl.getActiveTokens();
                const storageType = tokens[0] || NCALayerClient.fileStorageType;

                setStatus('✍️ Подпись документа...');
                const cms = await ncl.createCMSSignatureFromBase64(
                    storageType,
                    base64pdf,
                    'SIGNATURE',
                    true,
                );

                console.log('CMS:', cms.slice(0, 100));

                setStatus('📤 Отправка подписи на сервер...');
                await sendCms(actId, cms); // ✅ здесь вызываем

                setStatus('✅ Успешно подписано!');
            } catch (err) {
                console.error(err);
                setStatus('❌ Ошибка: ' + err.message);
            }
        }

        async function sendCms(actId, cms) {
            const formData = new FormData();
            formData.append('id', actId);
            formData.append('cms', cms);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch('/pdf/sign', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                        // НЕ добавляй Content-Type, браузер сам установит boundary для multipart/form-data
                    }
                });

                if (!response.ok) throw new Error('Ошибка подписи');
                const result = await response.json();
                console.log('✅ Успешно', result);
            } catch (err) {
                console.error('❌ Ошибка:', err);
            }
        }
    </script>


@endsection
