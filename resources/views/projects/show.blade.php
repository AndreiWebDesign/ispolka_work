@extends('layouts.app')
@section('title', 'Объект: ' . ($passport->object_name ?? $passport->id))

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Объект: {{ $passport->object_name ?? $passport->id }}</h2>

        @if ($role === 'подрядчик')
            <div class="mb-4">
                <a href="{{ route('acts.select', $passport) }}" class="btn btn-success">
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
        @php
            $typeNames = [
                'hidden_works' => 'Акты скрытых работ',
                'intermediate_accept' => 'Акты промежуточной приёмки',
                // Можно добавить другие типы, если будут
            ];
        @endphp

        @if ($acts->isEmpty())
            <div class="alert alert-info my-4">
                Для этого объекта ещё нет актов.
            </div>
        @else

            <div class="accordion" id="actsAccordion">
                @foreach ($acts as $type => $group)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ Str::slug($type) }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ Str::slug($type) }}" aria-expanded="false"
                                    aria-controls="collapse-{{ Str::slug($type) }}">
                                {{ $typeNames[$type] ?? $type }} ({{ $group->count() }} шт.)
                            </button>
                        </h2>
                        <div id="collapse-{{ Str::slug($type) }}" class="accordion-collapse collapse"
                             aria-labelledby="heading-{{ Str::slug($type) }}" data-bs-parent="#actsAccordion">
                            <div class="accordion-body p-0">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th scope="col">№ акта</th>
                                        <th scope="col">Дата</th>
                                        <th scope="col">Тип</th>
                                        <th scope="col">Подпись</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($group as $act)
                                        @php
                                            $actNumber = $act->act_number ?? $act->number_act ?? $act->number_acts ?? null;
                                            $signersCount = $act->signatures->count();
                                            $highlight = ($signersCount === 3) ? 'background-color: #d4edda;' : '';
                                            $userSigned = $act->signatures->contains(function ($sig) {
                                                return $sig->user_id === auth()->id() && $sig->status === 'подписано';
                                            });
                                        @endphp

                                        <tr style="{{ $highlight }}">
                                            <td>{{ $actNumber }}</td>
                                            <td>{{ $act->act_date }}</td>
                                            <td>{{ $typeNames[$act->type] ?? $act->type }}</td>
                                            <td>
                                                <div class="d-flex gap-2 flex-wrap align-items-center">
                                                    @if (!$userSigned)
                                                        <button type="button"
                                                                id="sign-btn-{{ $actNumber }}"
                                                                class="btn btn-outline-primary btn-sm"
                                                                onclick="signAct('{{ $act->type }}', {{ $actNumber }})">
                                                            <i class="bi bi-pen me-1"></i> Подписать и скачать
                                                        </button>
                                                    @endif

                                                    <a href="{{ route('pdf.view', ['type' => $act->type, 'id' => $actNumber]) }}"
                                                       class="btn btn-outline-secondary btn-sm" target="_blank">
                                                        <i class="bi bi-eye me-1"></i> Просмотреть PDF
                                                    </a>

                                                    <div id="output-{{ $act->type }}-{{ $actNumber }}" class="small text-muted mt-1"></div>
                                                </div>

                                                @if (!$userSigned)
                                                    <form action="{{ route('acts.reject') }}" method="POST" class="d-inline"
                                                          onsubmit="return rejectAct(event, {{ $actNumber }})">
                                                        @csrf
                                                        <input type="hidden" name="type" value="{{ $act->type }}">
                                                        <input type="hidden" name="id" value="{{ $actNumber }}">
                                                        <input type="hidden" name="reason" id="reason-{{ $actNumber }}">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                                            <i class="bi bi-x-circle me-1"></i> Отклонить
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('acts.signatures', ['type' => $act->type, 'id' => $actNumber]) }}"
                                                   class="btn btn-outline-dark btn-sm" target="_blank">
                                                    <i class="bi bi-list-check me-1"></i> Подписи
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div id="output-status" class="alert alert-info mt-3 d-none" role="alert">
                <!-- Сюда будет подставляться сообщение -->
            </div>        @endif
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
        async function signAct(type, actId) {

            const setStatus = (msg) => {
                const statusDiv = document.getElementById('output-status');
                statusDiv.className = `alert alert-info mt-3`;
                statusDiv.textContent = msg;
                statusDiv.classList.remove('d-none');
            };

            try {
                setStatus('📥 Загружаем PDF...');
                const base64pdf = await fetch(`/pdf/base64/${type}/${actId}`)
                    .then(r => r.json())
                    .then(data => data.base64);

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
                await sendCms(actId, cms, type);

                setStatus('✅ Успешно подписано!');
            } catch (err) {
                console.error(err);
                setStatus('❌ Ошибка: ' + err.message);
            }
            // После успешной подписи
            document.getElementById(`sign-btn-${actId}`)?.remove();
            document.getElementById(`signed-block-${actId}`)?.style.setProperty('display', 'inline-flex');

        }


        async function sendCms(actId, cms, type) {
            const formData = new FormData();
            formData.append('id', actId);
            formData.append('cms', cms);
            formData.append('type', type); // ← добавь нужный тип: 'hidden_works' или 'intermediate_accept'

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch('/pdf/sign', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
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
