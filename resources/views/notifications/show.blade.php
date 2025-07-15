@extends('layouts.app')
@section('title', 'Приглашение')

@section('content')
    <div class="container py-4">
        <h3>Вас пригласили к объекту</h3>

        <p>{{ $notification->data['message'] }}</p>

        @if ($invitation)
            <form method="POST" action="{{ route('invitation.accept', ['invitation' => $invitation->id]) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Принять</button>
            </form>

            <form method="POST" action="{{ route('invitation.decline', ['invitation' => $invitation->id]) }}" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-danger">Отклонить</button>
            </form>
        @else
            <div class="alert alert-danger mt-3">Приглашение не найдено или уже обработано.</div>
        @endif
    </div>
@endsection
