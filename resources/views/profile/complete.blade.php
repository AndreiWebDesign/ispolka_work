@extends('layouts.app')
@section('title', 'Приглашение')

@section('content')
    <form action="{{ route('profile.update') }}" method="POST" class="p-4 bg-light border rounded shadow-sm" style="max-width: 600px; margin: 0 auto;">
        @csrf

        <h4 class="mb-4 fw-bold text-center">Заполнение профиля организации</h4>

        {{-- Ошибки --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- БИН -->
        <div class="mb-3">
            <label for="bin" class="form-label">БИН организации</label>
            <input type="text" name="bin" id="bin" class="form-control @error('bin') is-invalid @enderror"
                   value="{{ old('bin', auth()->user()->bin) }}">
            @error('bin')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Наименование организации -->
        <div class="mb-3">
            <label for="organization_name" class="form-label">Наименование организации</label>
            <input type="text" name="organization_name" id="organization_name"
                   class="form-control @error('organization_name') is-invalid @enderror"
                   value="{{ old('organization_name', auth()->user()->organization_name) }}">
            @error('organization_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Роль -->
        <div class="mb-4">
            <label for="role" class="form-label">Роль</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="">-- Выберите роль --</option>
                <option value="подрядчик" {{ old('role', auth()->user()->role) == 'подрядчик' ? 'selected' : '' }}>ПОДРЯДЧИК</option>
                <option value="технадзор" {{ old('role', auth()->user()->role) == 'технадзор' ? 'selected' : '' }}>ТЕХНИЧЕСКИЙ НАДЗОР</option>
                <option value="авторнадзор" {{ old('role', auth()->user()->role) == 'авторнадзор' ? 'selected' : '' }}>АВТОРСКИЙ НАДЗОР</option>
            </select>
            @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Кнопка -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>

@endsection
