<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    <input name="bin" placeholder="БИН" required>
    <input name="organization_name" placeholder="Наименование организации" required>
    <select name="role" required>
        <option value="подрядчик">Подрядчик</option>
        <option value="технадзор">Технический надзор</option>
        <option value="авторнадзор">Авторский надзор</option>
    </select>
    <button type="submit">Сохранить</button>
</form>
