@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Отзывы') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Отзывы</h1>
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))  <!-- Показ сообщения об операции (создание, удаление или изменение). -->
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <a href="{{route('comments.create')}}" class="btn btn-dark mb-20">Добавить Отзыв</a>  {{-- Переход к созданию записи --}}
            <div class="card">
                <div class="card-body p-0">
                    <table id="table8" class="display" style="width:100%">  {{-- Таблица - вывод данных из базы --}}
                        <thead> {{-- Шапка таблицы --}}
                            <tr class=" text-center ">
                                <th>ID</th>
                                <th>Пользователь</th>
                                <th>Отзыв</th>
                                <th>Статус</th>
                                <th>Опции</th>
                            </tr>
                        </thead> {{-- Конец шапки таблицы  --}}
                        <tbody> {{-- Тело таблицы --}}
                            {{-- Перебор данных для вывода --}}
                            @foreach ($comments->data as $comment)
                                <tr class=" text-center ">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $comment->nameUser }}</td>
                                    <td>{{ $comment->comment}}</td>
                                    @if ($comment->status == 0)
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
                                                    <a class="btn btn-primary btn-sm  mb-2" href="{{ route('comments.edit',$comment->id) }}">
                                                            Редактировать
                                                    </a>
                                                </li>
                                                <li>
                                                    {{-- Ссылка на страницу просмотра передача ID элемента переход по ROUTE --}}
                                                    <a class="btn btn-info btn-sm" href="{{ route('comments.show',$comment->id) }}">
                                                            просмотреть
                                                    </a>
                                                </li>
                                                <li>
                                                    {{-- Удаление записи по ID --}}
                                                    <form action="{{ route('comments.destroy',$comment->id) }}" method="POST" id="form" style="display: inline-block">
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
