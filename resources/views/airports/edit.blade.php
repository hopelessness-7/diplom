@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Аэропорты') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование данных о аэропорте - {{ $airportShow['name'] }} </h1>
                </div>
            </div>
        </div>
    </div>

    {{-- Показ ошибок --}}
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
                        <form action="{{ route('airports.update',$airportShow['id']) }}" method="POST"> {{-- Работа формы через метода прописанный в контроллере, изменение данныз записи по ID --}}
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Город:</strong>
                                    <input type="text" name="city" value ="{{ $airportShow['city'] }}" class="form-control" placeholder="Имя"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Название аэропорта:</strong>
                                    <input type="text" name="name" value ="{{ $airportShow['name']}}" class="form-control" placeholder="Фамилия"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Код аэропорта:</strong>
                                    <input type="text" name="iata" value ="{{ $airportShow['iata'] }}" class="form-control" placeholder="Дата рождения"> {{-- Вствка данных полученных по ID --}}
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('airports.index') }}" class="btn btn-primary">Назад</a>
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
