@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Отзывы') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Отзыв от - {{ $commentShow['nameUser']}}</h1> {{-- Вствка данных полученных по ID --}}
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Пользователь:</strong>
                                <input type="text" name="nameUser" value ="{{ $commentShow['nameUser'] }}" class="form-control"> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-floating">
                                <strong>Коментарий:</strong>
                                <textarea type="text" name="comment" rows="8" class="form-control" style="resize: none">{{ $commentShow['comment']}}</textarea> {{-- Вствка данных полученных по ID --}}
                            </div>
                            <div class="form-group">
                                <strong>Статус:</strong>
                                {{-- Если статус 0, то выводим сообщени, что отзыв в обработке, если статус 1, то выводим обработано --}}
                                @if ($commentShow['status'] == 0)
                                    <input type="text"  name="status" value ="В обработке" class="form-control">
                                @else
                                    <input type="text"  name="status" value ="Обработано" class="form-control">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('comments.index') }}" class="btn btn-primary">Назад</a> {{-- Кнопка назад --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection {{-- Конец шаблона --}}
