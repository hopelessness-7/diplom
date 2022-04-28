@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Пользователи') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Данные о пользователе - {{ $user['first_name'] }}</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Имя:</strong>
                                <input type="text" name="first_name" value ="{{ $user['first_name'] }}" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <strong>Фамилия:</strong>
                                <input type="text" name="last_name" value ="{{ $user['last_name']}}" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <strong>Номер телефона:</strong>
                                <input type="text" name="phone" value ="{{ $user['phone'] }}" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <strong>Номер документа:</strong>
                                <input type="text" name="document_number" value ="{{ $user['document_number'] }}" class="form-control" placeholder="">
                            </div>
                            @if (isset($user['email']))
                                <div class="form-group">
                                    <strong>email:</strong>
                                    <input type="text" name="email" value ="{{ $user['email'] }}" class="form-control" placeholder="">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
