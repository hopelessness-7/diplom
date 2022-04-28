@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Обращения пользователей') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Заявка от пользователя - {{ $fbShow['nameUser']}} </h1>
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

    <section class="content" id="win">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                       {{-- Форма для обновления данных --}}
                        <form action="{{ route('feedbacks.update',$fbShow['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Пользователь:</strong>
                                    <input type="text" name="nameUser" value ="{{ $fbShow['nameUser'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Связь с пользователем:</strong>
                                    <input type="text" name="connection" value="{{ $fbShow['connection'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Сообщение:</strong>
                                    <textarea type="text" name="message" rows="8" class="form-control" style="resize: none">{{ $fbShow['message'] }}</textarea> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Заявка проверена:</strong>
                                    <input type="checkbox" id="CheckStatus" class="cb_status" onclick="ch()">
                                    <input type="hidden" id="IpStatus"  name="status" value ="{{ $fbShow['status'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('feedbacks.index') }}" class="btn btn-primary">Назад</a>
                                <button type="submit" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    function ch() {
        let status = document.querySelector('.cb_status');
        let input = document.getElementById('IpStatus');

        if (status.checked == true) {
            input.value = 1;
        }
    }

    </script>


@endsection
