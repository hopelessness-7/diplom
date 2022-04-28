@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Рейсы') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Данные о рейсе - {{ $showFlight['flight_code']}} </h1>
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
                                <strong>Код рейса:</strong>
                                <input type="text" name="flight_code" value ="{{ $showFlight['flight_code'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Город отправления:</strong>
                                <input type="text" name="from_id" value ="{{ $showFlight['from_airport']}}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Город прибытия:</strong>
                                <input type="text" name="to_id" value ="{{ $showFlight['to_airport']}}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Время отправления:</strong>
                                <input type="text" name="time_from" value ="{{ $showFlight['time_from'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Время прибытия:</strong>
                                <input type="text" name="time_to" value ="{{$showFlight['time_to'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Цена:</strong>
                                <input type="text" name="cost" value ="{{ $showFlight['cost'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('flights.index') }}" class="btn btn-primary">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection {{-- Конец шаблона --}}
