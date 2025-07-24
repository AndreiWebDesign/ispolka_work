@extends('layouts.app')
@section('title', 'Создать акт')

@section('content')

    <div class="container py-4">
        @if($type === 'hidden_works')
            @include('acts.templates.hidden_works')
        @elseif($type === 'intermediate_accept')
            @include('acts.templates.intermediate_accept')
        @elseif($type === 'prilozeniye_21')
            @include('acts.templates.prilozeniye_21')
        @else
            <div class="alert alert-danger">Неизвестный тип акта</div>
        @endif
    </div>
@endsection
