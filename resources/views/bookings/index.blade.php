@extends('layouts.adminPanel') {{-- Подключение главного шаблона  --}}

@section('title', 'Бронирования') {{-- Вставка имени страницы в главный шаблон в тег title --}}

@section('content') {{-- Вывод дочернего шаблона в главный --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Бронирования</h1>
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))  <!-- Показ сообщения об операции (создание, удаление или изменение). -->
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
        {{-- {{dd($bookings)}} --}}
    <section class="content"> {{-- Тело шаблона --}}
        <div class="container-fluid">
            <div class="card">
                <div class="card-body p-0">
                    <table id="table2" class="display mb-20" style="width:100% "> {{-- Таблица - вывод данных из базы --}}
                        <thead> {{-- Шапка таблицы --}}
                            <tr class=" text-center ">
                                <th>ID</th>
                                <th>Номера рейса</th>
                                <th>Номер рейса обратного маршрута</th>
                                <th>Дата рейса</th>
                                <th>Дата рейса обратно</th>
                                <th>Код бронирования</th>
                                <th>Опции</th>
                            </tr>
                        </thead> {{-- Конец шапки таблицы  --}}
                        <tbody> {{-- Тело таблицы --}}
                            {{-- Перебор данных для вывода --}}
                            @foreach ($bookings->data as $booking)
                                <tr class=" text-center ">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $booking->flight_from_to_booking->flight_code}}</td>
                                    @if (!empty($booking->flight_back_to_booking->flight_code))
                                    <td>{{ $booking->flight_back_to_booking->flight_code }}</td>
                                    @else
                                    <td> - </td>
                                    @endif
                                    <td>{{ $booking->date_from }}</td>
                                    @if (!empty($booking->date_back))
                                    <td>{{ $booking->date_back }}</td>
                                    @else
                                    <td> - </td>
                                    @endif
                                    <td>{{ $booking->code }}</td>
                                    <td class="project-actions text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                              Действие
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenu2">
                                                <li>
                                                    {{-- Ссылка на страницу просмотра, передача ID элемента, переход по ROUTE --}}
                                                    <a class="btn btn-info btn-sm mb-2" href="{{ route('bookings.show',$booking->id) }}">
                                                            просмотреть
                                                    </a>
                                                </li>
                                                <li>
                                                    {{-- Удаление записи по ID --}}
                                                    <form action="{{ route('bookings.destroy',$booking->id) }}" method="POST" id="form" style="display: inline-block">
                                                        @csrf    <!-- Проверка запросов. -->
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete-btn my-2">
                                                            Отменить
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


@endsection  <!-- Конец секции. -->
