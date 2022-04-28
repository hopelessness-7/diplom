@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Аэропорты') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Аэропорты</h1>
                </div>
            </div>
        </div>
      </div>

    @if ($message = Session::get('success'))  <!-- Показ сообщения об операции (создание, удаление или изменение). -->
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
        {{-- {{dd($airports)}} --}}
    <section class="content"> {{-- Тело шаблона --}}
        <div class="container-fluid">
            <a href="{{route('airports.create')}}" class="btn btn-dark mb-20">Добавить аэропорт</a> {{-- Переход к созданию записи --}}
            <div class="card">
                <div class="card-body p-0">
                    <table id="table1" class="display" style="width:100%"> {{-- Таблица - вывод данных из базы --}}
                        <thead> {{-- Шапка таблицы --}}
                            <tr class=" text-center ">
                                <th>ID</th>
                                <th>Город</th>
                                <th>Название аэропорта</th>
                                <th>Код аэропорта</th>
                                <th>Опции</th>
                            </tr>
                        </thead> {{-- Конец шапки таблицы  --}}
                        <tbody> {{-- Тело таблицы --}}
                            {{-- Перебор данных для вывода --}}
                            @foreach ($airports->data as $airport)
                                <tr class=" text-center ">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $airport->city }}</td>
                                    <td>{{ $airport->name}}</td>
                                    <td>{{ $airport->iata }}</td>
                                    <td class="project-actions text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                              Действие
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenu2">
                                                <li>
                                                    {{-- Ссылка на страницу редактирования передача ID элемента переход по ROUTE --}}
                                                    <a class="btn btn-primary btn-sm  mb-2" href="{{ route('airports.edit',$airport->id) }}">
                                                            Редактировать
                                                    </a>
                                                </li>
                                                <li>
                                                    {{-- Ссылка на страницу просмотра передача ID элемента переход по ROUTE --}}
                                                    <a class="btn btn-info btn-sm" href="{{ route('airports.show',$airport->id) }}">
                                                            просмотреть
                                                    </a>
                                                </li>
                                                <li>
                                                    {{-- Удаление записи по ID --}}
                                                    <form action="{{ route('airports.destroy',$airport->id) }}" method="POST" id="form" style="display: inline-block">
                                                        @csrf    <!-- Проверка запросов. -->
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-btn my-2">
                                                            Удалить
                                                        </button>
                                                    </form>
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
