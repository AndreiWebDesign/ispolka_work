@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2>Проверка CMS файла</h2>

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cms.extract') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Извлечь PDF из act_17.cms</button>
        </form>
    </div>
@endsection
