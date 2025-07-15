<form action="{{ route('profile.update') }}" method="POST">
    @csrf

    <!-- БИН -->
    <div>
        <label for="bin">БИН</label>
        <input type="text" name="bin" id="bin" value="{{ old('bin', auth()->user()->bin) }}">
        @error('bin') <div class="text-red-500">{{ $message }}</div> @enderror
    </div>

    <!-- Наименование организации -->
    <div>
        <label for="organization_name">Наименование организации</label>
        <input type="text" name="organization_name" id="organization_name" value="{{ old('organization_name', auth()->user()->organization_name) }}">
        @error('organization_name') <div class="text-red-500">{{ $message }}</div> @enderror
    </div>

    <!-- Роль -->
    <div>
        <label for="role">Роль</label>
        <select name="role" id="role" required>
            <option value="">-- Выберите роль --</option>
            <option value="подрядчик" {{ old('role', auth()->user()->role) == 'подрядчик' ? 'selected' : '' }}>ПОДРЯДЧИК</option>
            <option value="технадзор" {{ old('role', auth()->user()->role) == 'технадзор' ? 'selected' : '' }}>ТЕХНИЧЕСКИЙ НАДЗОР</option>
            <option value="авторнадзор" {{ old('role', auth()->user()->role) == 'авторнадзор' ? 'selected' : '' }}>АВТОРСКИЙ НАДЗОР</option>
        </select>
        @error('role') <div class="text-red-500">{{ $message }}</div> @enderror
    </div>

    <!-- Кнопка -->
    <button type="submit">Сохранить</button>
</form>
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
