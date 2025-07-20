@extends('layouts.app')
@section('title', 'Создать акт')

@section('content')

    <div class="container py-4">
        @if($type === 'hidden_works')
            @include('acts.templates.hidden_works')
        @elseif($type === 'intermediate_accept')
            @include('acts.templates.intermediate_accept')
        @elseif($type === 'act_type_3')
            @include('acts.templates.act_type_3')
        @else
            <div class="alert alert-danger">Неизвестный тип акта</div>
        @endif
    </div>
@endsection
