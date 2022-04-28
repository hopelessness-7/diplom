@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Бронирования') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Данные о бронировании - {{ $booking['code']}}</h1> {{-- Вствка данных полученных по ID --}}
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body p-30 rounded" id="printJS-div">
                            <strong class="mt-40">Рейс:</strong>
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="form-group ">
                                    <strong>Номер рейса:</strong>
                                    <p>{{ $booking['flight_code_from'] }}</p> {{-- Вствка данных полученных по ID --}}
                                </div>
                                @if (!empty($booking['flight_code_back'])) {{-- Если есть обратный рейс выводим его код --}}
                                <div class="form-group ">
                                    <strong>Номер рейса обратного:</strong>
                                    <p>{{ $booking['flight_code_back'] }}</p> {{-- Вствка данных полученных по ID --}}
                                </div>
                                @endif
                                <div class="form-group ">
                                    <strong>Дата рейса:</strong>
                                    <p>{{ $booking['date_from'] }}</p> {{-- Вствка данных полученных по ID --}}
                                </div>
                                @if (!empty($booking['date_back'])) {{-- проверка на обратную дату, если есть то выводим --}}
                                <div class="form-group ">
                                    <strong>Дата рейса обратно:</strong>
                                    <p>{{ $booking['date_back'] }}</p> {{-- Вствка данных полученных по ID --}}
                                </div>
                                @endif
                                @if (!empty($booking['cost_back'])) {{-- Если есть обратный маршрут то скадываем цены рейсов и выводим общий --}}
                                <div class="form-group ">
                                    <strong>Полная цена:</strong>
                                    <p>{{$booking['cost_back'] + $booking['cost_from'] }}</p>
                                </div>
                                @else {{-- Если нет обратного рейса, то выводим цену за рейс --}}
                                <div class="form-group ">
                                    <strong>Цена билета:</strong>
                                    <p>{{ $booking['cost_from'] }}</p>
                                </div>
                                @endif
                            </div>
                            <div class=""> {{-- Блок пассажиров --}}
                                <br>
                                <strong>Пассажир:</strong>
                                <div class="form-group d-flex flex-column">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="">
                                            <div class="form-group">
                                                <strong>Имя:</strong>
                                                <p>{{  $booking['first_name'] }}</p>
                                            </div>
                                            <div class="form-group">
                                                <strong>Дата рождение:</strong>
                                                <p>{{  $booking['birth_date'] }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <strong>Фамилия:</strong>
                                                <p>{{  $booking['last_name'] }}</p>
                                            </div>
                                            <div class="form-group">
                                                <strong>Место в салоне:</strong>
                                                <p>{{  $booking['place_from'] }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <strong>Документ:</strong>
                                                <p>{{  $booking['document_number'] }}</p>
                                            </div>
                                            @if (!empty($booking['place_back'])) {{-- Если есть место на обратный рейс, то выводим --}}
                                            <div class="form-group">
                                                <strong>Место обратно:</strong>
                                                <p>{{  $booking['place_back'] }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer mt-10">
                        <a href="{{ route('bookings.index') }}" class="btn btn-primary">Назад</a>
                        {{-- Кнопка печати билета --}}
                        <button class="btn btn-success" type="button" onclick="printJS ({ printable: 'printJS-div', type: 'html', header: 'Авиакомпания Феникс', css:'{{ url('/assets/css/codebase.min.css')}}', style:'body {background: white;}' })">
                            Печать
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ url('assets/js/print.min.js') }}">


    </script>

@endsection
