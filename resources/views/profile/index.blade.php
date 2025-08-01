@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">Добро пожаловать, {{ $user->name }}</h2>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-light h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title mb-3 fw-semibold">Информация о тарифе</h5>
                        <p class="mb-1">Ваш тариф: <span class="text-primary fw-semibold">{{ $user->tariff_name ?? 'Базовый' }}</span></p>
                        <p class="mb-1">Осталось документов: <strong>{{ $user->documents_left ?? 0 }}</strong></p>
                        <p class="mb-1">Оплачено до:
                            <strong>{{ $user->paid_until ? \Carbon\Carbon::parse($user->paid_until)->format('d.m.Y') : 'не оплачено' }}</strong>
                        </p>
                        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-primary mt-2">Управление тарифом</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4 mt-md-0">
                <div class="card border-0 shadow-sm bg-light h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title mb-3 fw-semibold">Информация об организации</h5>
                        <p><strong>Организация:</strong> {{ $user->organization_name }}</p>
                        <p><strong>БИН:</strong> {{ $user->bin }}</p>
                        <p><strong>Роль:</strong>
                            @switch($user->role)
                                @case('технадзор') Технический надзор @break
                                @case('авторнадзор') Авторский надзор @break
                                @case('подрядчик') Подрядчик @break
                                @default {{ $user->role }}
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>
        </div>


    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h4 class="mt-4 fw-semibold">Сотрудники вашей организации</h4>
        <div class="table-responsive">
            <table class="table table-hover table-bordered mt-2">
                <thead class="table-light">
                <tr>
                    <th>ФИО</th>
                    <th>Email</th>
                    <th>Должность</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->position }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Сотрудников пока нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($user->role === 'подрядчик')
            @if ($user->role === 'подрядчик')
                <hr>
                <h4 class="mt-5 mb-3 fw-semibold">Пригласить сотрудника</h4>
                <form method="POST" action="{{ route('profile.invite') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">ФИО</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                        </div>
                        <div class="col-md-4">
                            <label for="position" class="form-label">Должность</label>
                            <input type="text" name="position" class="form-control" id="position" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 px-4">Добавить сотрудника</button>
                </form>
            @endif
        @endif
    </div>
@endsection
