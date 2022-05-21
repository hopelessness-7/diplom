@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Рейсы') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Создание рейса</h1>
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
                        <!-- form start -->
                        <form id="form" action="{{ route('flights.store') }}" method="POST">   <!-- созадние записии, ссылка на контроллер. -->
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Код рейса:</strong>
                                    <input type="text" name="flight_code" class="form-control">
                                </div>
                                <div onchange="checkSelect()">
                                    <div class="form-group">
                                        <strong>Город отправления:</strong>
                                        <br>
                                        <select name="" id="IdCityFrom" style="" onchange="selectFrom()">
                                            @foreach ($airports->data as $air) <!-- Перебираем массив с аэропортами и выводим -->
                                                <option value="{{ $air->id}}"> {{ $air->city}} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="from_id" id="fromId" value="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <strong>Город прибытия:</strong>
                                        <br>
                                        <select name="" id="IdCityTo" style="" onchange="selectTo()" >
                                            @foreach ($airports->data as $airport) <!-- Перебираем массив с аэропортами и выводим -->
                                                <option value="{{ $airport->id}}"> {{ $airport->city}} </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="to_id" id="toId" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <strong>Время отправления:</strong>
                                    <input type="text" name="time_from" class="form-control">
                                </div>
                                <div class="form-group">
                                    <strong>Время прибытия:</strong>
                                    <input type="text" name="time_to" class="form-control">
                                </div>
                                <div class="form-group">
                                    <strong>Цена:</strong>
                                    <input type="text" name="cost" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('flights.index') }}" class="btn btn-primary">Назад</a>
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Функция подставления данных из селекта в инпут
        function selectFrom () {
            let cityFrom = document.getElementById("IdCityFrom").value;
            // console.log(cityFrom);
            document.getElementById('fromId').value = cityFrom;
        }
        function selectTo () {
            let cityTo = document.getElementById("IdCityTo").value;
            // console.log(cityFrom);
            document.getElementById('toId').value = cityTo;
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
