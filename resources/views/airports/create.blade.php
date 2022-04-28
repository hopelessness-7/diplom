@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Аэропорты') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Создание аэропорта</h1>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any()) <!-- Валидация. вывод ошибок -->
    <div class="alert alert-danger">
        <strong>Проблемка!</strong> Введите корректную информацию.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form id="form" action="{{ route('airports.store') }}" method="POST">   <!-- созадние записии, ссылка на контроллер. -->
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Город:</strong>
                                    <input type="text" name="city" class="form-control" placeholder="Город">
                                </div>
                                <div class="form-group">
                                    <strong>Названия аэропорта:</strong>
                                    <input type="text" name="name" class="form-control" placeholder="Названия аэропорта">
                                </div>
                                <div class="form-group">
                                    <strong>Код аэропорта:</strong>
                                    <input type="text" name="iata" class="form-control" placeholder="Код аэропорта">
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('airports.index') }}" class="btn btn-primary">Назад</a>
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection {{-- Конец шаблона --}}
