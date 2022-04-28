@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Отмента бронирования') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Данные о заявке пользователя - {{ $clShow['username']}} </h1> {{-- Вствка данных полученных по ID --}}
                </div>
            </div>
        </div>
    </div>

    <section class="content"> {{-- Тело шаблона --}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Пользователь:</strong>
                                <input type="text" name="username" value ="{{ $clShow['username'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Код бронирования:</strong>
                                <input type="text" name="BookingCode" value="{{ $clShow['BookingCode'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Описание:</strong>
                                <textarea type="text" name="description" rows="8" class="form-control" style="resize: none">{{ $clShow['description'] }}</textarea> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Статус:</strong>
                                @if ($clShow['status'] == 0)
                                    <input type="text"  name="status" value ="В обработке" class="form-control">
                                @else
                                    <input type="text"  name="status" value ="Обработано" class="form-control">
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('closing_bookings.index') }}" class="btn btn-primary">Назад</a> {{-- Возращение на страницу с таблице, где все записи --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> {{-- конец тело шаблона --}}

@endsection <!-- Конец секции. -->
