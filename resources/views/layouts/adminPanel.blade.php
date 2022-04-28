<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Admin-Panel - @yield('title')</title>

        <meta name="description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        {{-- Подключение библиотек --}}
        <link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ url('https://printjs-4de6.kxcdn.com/print.min.css') }}">
        <script defer src="{{ url('https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js') }}"></script>
        <link href="{{ url('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css') }}" rel="stylesheet">
        <script src="{{ url('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js') }}"></script>


       {{-- Подключение плагинов --}}
        <link rel="stylesheet" href="{{ url('assets/js/plugins/slick/slick.css') }}">
        <link rel="stylesheet" href="{{ url('assets/js/plugins/slick/slick-theme.css') }}">

        <!-- Шрифты и фреймворк кодовой базы-->
        <link rel="stylesheet" href="{{ url('https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap') }}">
        <link rel="stylesheet" id="css-main" href="{{ url('assets/css/codebase.min.css') }}">
        <link rel="shortcut icon" href="{{ url('assets/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ url('assets/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/media/favicons/apple-touch-icon-180x180.png') }}">

    </head>
    <body>

        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll side-trans-enabled">

            <nav id="sidebar">
                <!-- Содержимое боковой панели -->
                <div class="sidebar-content">
                    <!-- Пользователь -->
                    <div class="content-side content-side-full content-side-user px-10 align-parent">
                        <!-- Мини-режиме -->
                        <div class="sidebar-mini-visible-b align-v animated fadeIn">
                            <img class="img-avatar img-avatar32" src="{{ url('assets/media/avatars/avatar15.jpg') }}" alt="">
                        </div>
                        <!-- Конец мини-режима -->

                        <!-- Обычный режим окна -->
                        <div class="sidebar-mini-hidden-b text-center">
                            <a class="img-link" href="#">
                                <img class="img-avatar" src="{{ url('assets/media/avatars/avatar15.jpg') }}" alt="">
                            </a>
                            <ul class="list-inline mt-10">
                                <li class="list-inline-item">
                                    @auth
                                        <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="{{ route('profile.show') }}">{{ Auth::user()->first_name }}</a>
                                    @endauth
                                </li>
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark" data-toggle="layout" data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                                        <i class="si si-drop"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    @auth
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf
                                        <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="{{ route('logout') }}"  @click.prevent="$root.submit();">
                                            <i class="si si-logout"></i>
                                        </a>
                                     </form>
                                    @endauth
                                </li>
                            </ul>
                        </div>
                        <!-- Конец обычного режима -->
                    </div>
                    <!-- Конец пользовательской части -->

                    <!-- Боковая навигация -->
                    <div class="content-side content-side-full">
                        <ul class="nav-main">
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-badge"></i><span class="sidebar-mini-hide">Администрирование</span></a>
                                <ul>
                                    <li><a href="{{ route('airports.index') }}">Аэропорты</a></li>
                                    <li><a href="{{ route('flights.index') }}">Рейсы</a></li>
                                    <li><a href="{{ route('passengers.index') }}">Пассажиры</a></li>
                                    <li><a href="{{ route('bookings.index') }}">Бронирования</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-badge"></i><span class="sidebar-mini-hide">Пользователи</span></a>
                                <ul>
                                    <li>
                                        <a href="{{ route('users.index') }}">Пользователи</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-badge"></i><span class="sidebar-mini-hide">Компоненты</span></a>
                                <ul>
                                    <li>
                                        <a href="{{ route('comments.index') }}">Отзовы</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('feedbacks.index') }}">Запросы от пользователей</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('closing_bookings.index') }}">Отмена бронирования</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- Конец боковой навигации -->
                </div>
                <!-- Содержимое боковой панели -->
            </nav>
            <!-- Конец боковой панели-->

            <!-- Шапка -->
            <header id="page-header">
                <!-- Конетент -->
                <div class="content-header">
                    <!-- Левая секция -->
                    <div class="content-header-section">
                        <!-- Переключение боковой панели -->
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- Конец переключателя  -->

                        <!-- Параметры компоновки (используются только для демонстрации) -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-circle btn-dual-secondary" id="page-header-options-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-wrench"></i>
                            </button>
                            <div class="dropdown-menu min-width-300" aria-labelledby="page-header-options-dropdown">
                                <h5 class="h6 text-center py-10 mb-10 border-b text-uppercase">Settings</h5>
                                <h6 class="dropdown-header">Color Themes</h6>
                                <div class="row no-gutters text-center mb-5">
                                    <div class="col-2 mb-5">
                                        <a class="text-default" data-toggle="theme" data-theme="default" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 mb-5">
                                        <a class="text-elegance" data-toggle="theme" data-theme="{{ url('assets/css/themes/elegance.min.css') }}" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 mb-5">
                                        <a class="text-pulse" data-toggle="theme" data-theme="{{ url('assets/css/themes/pulse.min.css') }}" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 mb-5">
                                        <a class="text-flat" data-toggle="theme" data-theme="{{ url('assets/css/themes/flat.min.css') }}" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 mb-5">
                                        <a class="text-corporate" data-toggle="theme" data-theme="{{ url('assets/css/themes/corporate.min.css') }}" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-circle"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 mb-5">
                                        <a class="text-earth" data-toggle="theme" data-theme="{{ url('assets/css/themes/earth.min.css') }}" href="javascript:void(0)">
                                            <i class="fa fa-2x fa-circle"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-none d-xl-block">
                                    <h6 class="dropdown-header">Header</h6>
                                    <button type="button" class="btn btn-sm btn-block btn-alt-secondary" data-toggle="layout" data-action="header_fixed_toggle">Fixed Mode</button>
                                </div>
                                <h6 class="dropdown-header">Sidebar</h6>
                                <div class="row gutters-tiny text-center mb-5">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout" data-action="sidebar_style_inverse_off">Light</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout" data-action="sidebar_style_inverse_on">Dark</button>
                                    </div>
                                </div>
                                <div class="d-none d-xl-block">
                                    <h6 class="dropdown-header">Main Content</h6>
                                    <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout" data-action="content_layout_toggle">Toggle Layout</button>
                                </div>
                            </div>
                        </div>
                        <!-- Варианты КОНЕЧНОЙ Компоновки -->
                    </div>
                    <!-- Конец левой секции -->

                    <!-- Правая секция -->
                    <div class="content-header-section">
                        <!-- Пользовательский выпадающий список - кнопка -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user d-sm-none"></i>
                                @auth
                                    <span class="d-none d-sm-inline-block">{{ Auth::user()->first_name }}</span>
                                @endauth
                                <i class="fa fa-angle-down ml-5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    {{ __('Профиль') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"  @click.prevent="$root.submit();">
                                        {{ __('Выход') }}
                                    </a>
                                 </form>
                            </div>
                        </div>
                        <!-- конец -->

                    </div>
                    <!-- Конец левой секции -->
                </div>
                <!-- Конец контента шапки -->
            </header>
            <!-- Конец Шапка -->

            <!-- Главный контейнер -->
            <main id="main-container">
                <!-- Контент страницы -->
                <div class="content">

                    {{-- Подключение шаблона --}}
                    @yield('content')

                </div>
                <!-- конец контента страницы -->
            </main>
            <!-- Конец главного контейнера -->

            <!-- Подвал -->
            <footer id="page-footer" class="opacity-0">

            </footer>
            <!-- Конец подвала  -->
        </div>
        <!-- Конец страницы -->

        {{-- Подключение JS файлов --}}
        <script src=" {{ url('assets/js/codebase.core.min.js') }}"></script>
        <script src=" {{ url('assets/js/codebase.app.min.js') }}"></script>
        <script src=" {{ url('assets/js/plugins/slick/slick.min.js') }}"></script>
        <script src=" {{ url('assets/js/pages/be_pages_dashboard.min.js') }}"></script>
        <script src=" {{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js') }}" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="{{ url('assets/js/DataTable.js') }}"></script>

    </body>
</html>
