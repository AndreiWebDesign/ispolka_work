@extends('layouts.app')
@section('title', 'Выбор типа акта')

@section('content')
    <div class="container py-4" style="max-width: 600px;">
        <h2 class="mb-4 text-center">Выберите тип акта</h2>

        <ul class="list-group">
            @foreach($actTypes as $key => $label)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $label }}
                    <a href="{{ route('acts.create', ['passport' => $passport->id, 'type' => $key]) }}" class="btn btn-primary btn-sm">Создать</a>

                </li>
            @endforeach
        </ul>
    </div>
@endsection
