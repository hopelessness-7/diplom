@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Пассажиры') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Данные о пассажире - {{ $passengerShow['first_name']}} {{$passengerShow['last_name']}}</h1>
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
                                <input type="text" name="first_name" value ="{{ $passengerShow['first_name'] }}" class="form-control" placeholder="Имя"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Фамилия:</strong>
                                <input type="text" name="last_name" value ="{{ $passengerShow['last_name']}}" class="form-control" placeholder="Фамилия"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Дата рождения:</strong>
                                <input type="text" name="birth_date" value ="{{ $passengerShow['birth_date'] }}" class="form-control" placeholder="Дата рождения"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Номер документа:</strong>
                                <input type="text" name="document_number" value ="{{ $passengerShow['document_number'] }}" class="form-control" placeholder="Номер документа"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Место в салоне:</strong>
                                <input type="text" name="document_number" value ="{{ $passengerShow['place_from'] }}" class="form-control" placeholder="Номер документа"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            @if (!empty($passengerShow['place_back'])) {{-- Если есть место в салоне обратно, то выводим его --}}
                            <div class="form-group">
                                <strong>Место в салоне на обратный маршрут:</strong>
                                <input type="text" name="place_back" value ="{{ $passengerShow['place_back'] }}" class="form-control" placeholder="Место в салоне"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('passengers.index') }}" class="btn btn-primary">Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
