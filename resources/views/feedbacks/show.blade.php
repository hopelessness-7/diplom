@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Обращения пользователей') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Данные о заявке пользователя - {{ $fbShow['nameUser']}} </h1> {{-- Вствка данных полученных по ID --}}
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
                                <strong>Пользователь:</strong>
                                <input type="text" name="nameUser" value ="{{ $fbShow['nameUser'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Связь с пользователем:</strong>
                                <input type="text" name="connection" value="{{ $fbShow['connection'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Сообщение:</strong>
                                <textarea type="text" name="message" rows="8" class="form-control" style="resize: none">{{ $fbShow['message'] }}</textarea> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Статус:</strong>
                                @if ($fbShow['status'] == 0)
                                    <input type="text"  name="status" value ="В обработке" class="form-control">
                                @else
                                    <input type="text"  name="status" value ="Обработано" class="form-control">
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('feedbacks.index') }}" class="btn btn-primary">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
