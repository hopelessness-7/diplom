@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Пользователи') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Пользователи</h1>
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
            <a href="{{route('users.create')}}" class="btn btn-dark mb-20">Добавить пользователя</a>
            <div class="card">
                <div class="card-body p-0">
                    <table id="table4" class="display" style="width:100%">
                        <thead>
                            <tr class=" text-center ">
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Телефон</th>
                                <th>Документ</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users->data as $user)
                                <tr class=" text-center ">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name}}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->document_number }}</td>
                                    <td class="project-actions text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                              Действие
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenu2">
                                                <li>
                                                    <a class="btn btn-primary btn-sm  mb-2" href="{{ route('users.edit',$user->id) }}">
                                                            Редактировать
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}">
                                                            просмотреть
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('users.destroy',$user->id) }}" method="POST" id="form" style="display: inline-block">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
