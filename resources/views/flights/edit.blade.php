@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Рейсы') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование данных о рейсе - {{ $showFlight['flight_code']}} </h1>
                </div>
            </div>
        </div>
    </div>

        {{-- ВЫвод ошибок --}}
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
                       {{-- Форма для обновления данных --}}
                        <form action="{{ route('flights.update',$showFlight['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Код рейса:</strong>
                                    <input type="text" name="flight_code" value ="{{ $showFlight['flight_code'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div onchange="checkSelect()">
                                    <div class="form-group">
                                        <strong>Город отправления:</strong>
                                        <br>
                                        <select name="" id="IdCityFrom" style="" onchange="selectFrom()">
                                            <option value="">{{ $showFlight['from_airport'] }}</option> {{-- Цикл по перебору аэропортов --}}
                                            @foreach ($airports->data as $airport)
                                            @if ($airport->city !== $showFlight['from_airport'])
                                                <option value="{{ $airport->id}}"> {{ $airport->city}} </option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="from_id" id="fromId" value="{{$showFlight['from_id']}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <strong>Город прибытия:</strong>
                                        <br>
                                        <select name="" id="IdCityTo" style="" onchange="selectTo()" >
                                            <option value="">{{ $showFlight['to_airport'] }}</option>
                                            @foreach ($airports->data as $airport) {{-- Цикл по перебору аэропортов --}}
                                            @if ($airport->city !== $showFlight['to_airport'])
                                                <option value="{{ $airport->id}}"> {{ $airport->city}} </option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="to_id" id="toId" value="{{$showFlight['to_id']}}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <strong>Время отправления:</strong>
                                    <input type="text" name="time_from" value ="{{ $showFlight['time_from'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Время прибытия:</strong>
                                    <input type="text" name="time_to" value ="{{ $showFlight['time_to'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Цена:</strong>
                                    <input type="text" name="cost" value ="{{ $showFlight['cost'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('flights.index') }}" class="btn btn-primary">Назад</a>
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Функция по добавления данных из селекта в инпут
        function selectFrom () {
            let cityFrom = document.getElementById("IdCityFrom").value;
            // console.log(cityFrom);
            document.getElementById('fromId').value = cityFrom;
            console.log(fromId);
        }
        function selectTo () {
            let cityTo = document.getElementById("IdCityTo").value;
            // console.log(cityFrom);
            document.getElementById('toId').value = cityTo;
            console.log(toId);
        }
        function checkSelect () {
                let cityFrom = document.getElementById("IdCityFrom");
                let cityTo = document.getElementById("IdCityTo");

                if (cityFrom != -1) {
                    cityTo.options[cityFrom.selectedIndex].disabled = true;
                    // cityTo.options[cityFrom.selectedIndex - 1].disabled  = false;
                }
            }
    </script>

@endsection
