@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Отзывы') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Отзыв от - {{ $commentShow['nameUser'] }} </h1>
                </div><
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
                        <form action="{{ route('comments.update',$commentShow['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <strong>Пользователь:</strong>
                                    <input type="text" name="nameUser" value ="{{ $commentShow['nameUser'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Отзыв:</strong>
                                    <textarea type="text" name="comment" rows="8" class="form-control" style="resize: none">{{ $commentShow['comment']}}</textarea> {{-- Вствка данных полученных по ID --}}
                                </div>
                                <div class="form-group">
                                    <strong>Коментарий проверен:</strong>
                                    <input type="checkbox" class="cb_status" onclick="ch()">
                                    <input type="hidden" id="IpStatus"  name="status" value ="{{ $commentShow['status'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a href="{{ route('comments.index') }}" class="btn btn-primary">Назад</a>
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
        console.log(status)
        let input = document.getElementById('IpStatus');
        console.log(input)

        if (status.checked == true) {
            input.value = 1;
        }
    }
    </script>

@endsection
