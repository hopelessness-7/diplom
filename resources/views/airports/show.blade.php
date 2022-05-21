@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Аэропорты') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0"> Данные о аэропорте - {{ $airportShow['name']}}</h1> {{-- Вствка данных полученных по ID --}}
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
                                <strong>Город:</strong>
                                <input type="text" name="city" value ="{{ $airportShow['city'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Название аэропорта:</strong>
                                <input type="text" name="name" value ="{{ $airportShow['name']}}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Код аэропорта:</strong>
                                <input type="text" name="iata" value ="{{ $airportShow['iata'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('airports.index') }}" class="btn btn-primary">Назад</a> {{-- Возращение на страницу с таблице, где все записи --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
