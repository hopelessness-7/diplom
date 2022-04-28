@extends('layouts.adminPanel')
{{-- @section('title', 'Cоздание предмета') --}}
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>
        @if ($errors->any())            <!-- Валидация. -->
            <div class="alert alert-danger">
                <strong>Проблемка!</strong> Введите корректную информацию.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="content">

        </section>
@endsection
