@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Пассажиры') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Пассажиры</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    @if ($message = Session::get('success'))  <!-- Показ сообщения об операции (создание, удаление или изменение). -->
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    <table id="table5" class="display" style="width:100%""> {{-- Таблица - вывод данных из базы --}}
                        <thead> {{-- Шапка таблицы --}}
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Дата рождения</th>
                                <th>Номер документа</th>
                                <th>Опции</th>
                            </tr>
                        </thead> {{-- Конец шапки таблицы  --}}
                        <tbody> {{-- Тело таблицы --}}
                            {{-- Перебор данных для вывода --}}
                            @foreach ($passengers->data as $passenger)
                                <tr class="text-center">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $passenger->first_name }}</td>
                                    <td>{{ $passenger->last_name}}</td>
                                    <td>{{ $passenger->birth_date }}</td>
                                    <td>{{ $passenger->document_number }}</td>

                                    <td class="project-actions">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                              Действие
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenu2">
                                                <li>
                                                     {{-- Ссылка на страницу просмотра передача ID элемента переход по ROUTE --}}
                                                    <a class="btn btn-info btn-sm" href="{{ route('passengers.show',$passenger->id) }}">
                                                            просмотреть
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                             @endforeach  {{-- Конец цикла foreach --}}
                        </tbody> {{-- Конец тела таблицы --}}
                    </table> {{-- Конец таблицы --}}
                </div>
            </div>
        </div>
    </section> {{-- конец тело шаблона --}}


@endsection <!-- Конец секции. -->
