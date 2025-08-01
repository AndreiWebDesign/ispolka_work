@extends('layouts.app')
@section('title', 'Приглашение')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-4">
                        <h2 class="card-title mb-4 text-center fw-bold">Приглашение к объекту</h2>

                        <p class="mb-4 text-center text-muted">{{ $notification->data['message'] }}</p>

                        @if ($invitation)
                            <form method="POST" action="{{ route('invitation.accept', ['invitation' => $invitation->id]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i class="bi bi-check-circle me-1"></i> Принять приглашение
                                </button>
                            </form>

                            <form method="POST" action="{{ route('invitation.decline', ['invitation' => $invitation->id]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-x-circle me-1"></i> Отклонить приглашение
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning text-center mt-4 rounded-3">
                                Приглашение не найдено или уже обработано.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
