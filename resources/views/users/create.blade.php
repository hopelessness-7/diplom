@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Пользователи') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавление пользователя</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>

    @if ($errors->any())            <!-- Валидация. -->
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
                        <form id="form" action="{{ route('users.store') }}" method="POST">   <!-- созадние записии, ссылка на контроллер. -->
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Имя:</strong>
                                    <input type="text" name="first_name" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Фамилия:</strong>
                                    <input type="text" name="last_name" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>email:</strong>
                                    <input type="email" name="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Номер телефона:</strong>
                                    <input type="text" name="phone" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Номер документа:</strong>
                                    <input type="text" name="document_number" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Пароль:</strong>
                                    <input type="password" name="password" class="form-control" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Потверждения пароля:</strong>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('users.index') }}" class="btn btn-primary">Назад</a>
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
