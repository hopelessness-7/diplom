@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Пользователи') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
            <h1 class="m-0">Редактирование данных о пользователе - {{ $user['first_name'] }} </h1>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Проблема!</strong> Введите корректную информацию.<br><br>
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
                    <form action="{{ route('users.update',$user['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Имя:</strong>
                                <input type="text" name="first_name" class="form-control" value ="{{ $user['first_name'] }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Фамилия:</strong>
                                <input type="text" name="last_name" class="form-control" value ="{{ $user['last_name'] }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Номер телефона:</strong>
                                <input type="text" name="phone" class="form-control" value ="{{ $user['phone'] }}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Номер документа:</strong>
                                <input type="text" name="document_number" class="form-control" value ="{{ $user['document_number'] }}" placeholder="">
                                </div>
                                @if (isset($user['email']))
                                    <div class="form-group">
                                        <strong>email:</strong>
                                        <input type="text" name="email" value ="{{ $user['email'] }}" class="form-control" placeholder="">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <strong>Пароль:</strong>
                                    <input type="password" name="password" class="form-control" value ="" placeholder="">
                                </div>
                                <div class="form-group">
                                    <strong>Потверждения пароля:</strong>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('users.index') }}" class="btn btn-primary">Назад</a>
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
