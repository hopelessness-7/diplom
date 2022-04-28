@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Обращения пользователей') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Обращения пользователей</h1>
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
                    <table id="table7" class="display mb-20" style="width:100% "> {{-- Таблица - вывод данных из базы --}}
                        <thead> {{-- Шапка таблицы --}}
                            <tr class=" text-center ">
                                <th>ID</th>
                                <th>Пользователь</th>
                                <th>Связь с пользователем</th>
                                <th>Сообщение</th>
                                <th>Статус</th>
                                <th>Опции</th>
                            </tr>
                        </thead> {{-- Конец шапки таблицы  --}}
                        <tbody> {{-- Тело таблицы --}}
                            {{-- Перебор данных для вывода --}}
                            @foreach ($feedbacks->data as $feedback)
                                <tr class=" text-center ">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $feedback->nameUser}}</td>
                                    <td>{{ $feedback->connection }}</td>
                                    <td>{{ $feedback->message }}</td>
                                    @if ($feedback->status == 0)
                                        <td>В обработке</td>
                                    @else
                                        <td>Обработано</td>
                                    @endif
                                    <td class="project-actions text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                              Действие
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenu2">
                                                <li>
                                                    {{-- Ссылка на страницу редактирования передача ID элемента переход по ROUTE --}}
                                                    <a class="btn btn-primary btn-sm  mb-2" href="{{ route('feedbacks.edit',$feedback->id) }}">
                                                            Редактировать
                                                    </a>
                                                </li>
                                                <li>
                                                    {{-- Ссылка на страницу просмотра передача ID элемента переход по ROUTE --}}
                                                    <a class="btn btn-info btn-sm mb-2" href="{{ route('feedbacks.show',$feedback->id) }}">
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
