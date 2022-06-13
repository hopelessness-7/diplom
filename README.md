

# Необходимые компоненты

Перед началом устоновки проверте, что имеются следующие компоненты:

- [X] composer 2.0;
- [X] PHP 8.0;
- [X] Node.js (npm 8.12.1);
- [X] MySQL (PhpAadminPanel).

[Скачать композер](https://getcomposer.org/download/)

[Скачать node.js](https://nodejs.org/en/download/)

Для развертывания программы локально необходимо, чтобы был устоновлен веб-сервер. Для разработке был использован [XAMPP](https://www.apachefriends.org/ru/download.html)

# Инструкция по установки сервера

1. Откройте cmd или gitbash и пропишите команду.

````sh
git clone https://github.com/hopelessness-7/Diplom_job.git
````

2. После клонирования репозитория необходимл скопировать файл .env.example и переминовать его в .env

3. Дальше необходимо настроить ключи безопасности.

````sh
composer update
````
````sh
php artisan key:generate
````
````sh
php artisan jwt:secret
````

4. Настрока базы 

    - Если разворачиваете локально, то измените только DB_DATABASE и если необходимо DB_USERNAME, DB_PASSWORD:
    
    ````
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=flights
    DB_USERNAME=root
    DB_PASSWORD=
    ````
    
    - Если после клонирования выгружаете на хостинг (сервер), то необходимо ознокомиться с технической информацией, которая предоставляет хостинг и изменить данные поля:
    
    ````
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ````
5. Также для постановки программы на хостинг (сервер) необходимо настроить конфигурационный файл .htaccess следующим образом

````php
<IfModule mod_rewrite.c>
Options +FollowSymLinks
RewriteEngine On

RewriteCond %{REQUEST_URI} !^/public/

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f



RewriteRule ^(.*)$ /public/$1
#RewriteRule ^ index.php [L]
RewriteRule ^(/)?$ public/index.php [L]
</IfModule>
````

## Импорт базы данных в приложение

Для импорта базы данных в приложение воспользуйтесь PhpMyAdmin(если работаете локально или на хостинге).
1. Перейдите в созадную базу.
2. Нажмите вкладку sql.
3. Вставьте скопированный код ниже.

----
НЕ УДАЛЯЙТЕ ПОЛЬЗОВАТЕЛЯ ADMIN! Если Вы это сделаете, то не сможете зайти в админ-панель. Но если Вы все же сделали это, то через базу данных добавте нового пользователя.
````sql
INSERT INTO `users`(`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `document_number`) VALUES (ВАШИ ДАННЫЕ (Пароль должен быть закодирован md5))
````

## SQL код базы данных

````sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `flights`
--

-- --------------------------------------------------------

--
-- Структура таблицы `airports`
--

CREATE TABLE `airports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_from` bigint(20) UNSIGNED NOT NULL,
  `flight_back` bigint(20) UNSIGNED DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_back` date DEFAULT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Структура таблицы `closing_bookings`
--

CREATE TABLE `closing_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BookingCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE `comment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nameUser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nameUser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) UNSIGNED NOT NULL,
  `to_id` bigint(20) UNSIGNED NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `cost` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `passengers`
--

CREATE TABLE `passengers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `document_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_from` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_back` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `email`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `document_number`, `api_token`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'admin', '+7 (929)366-66-66', 'admin@admin', '$2y$10$8YTZLTMnxmFCL32FgTvkCuIzhjvEljx9SOEiv1a7u9JFHtItWLsWW', NULL, NULL, NULL, '9997776668', NULL, '2022-04-13 21:25:08', '2022-04-13 21:25:08'),


--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_flight_from_foreign` (`flight_from`),
  ADD KEY `bookings_flight_back_foreign` (`flight_back`);

--
-- Индексы таблицы `closing_bookings`
--
ALTER TABLE `closing_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flights_from_id_foreign` (`from_id`),
  ADD KEY `flights_to_id_foreign` (`to_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passengers_booking_id_foreign` (`booking_id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `airports`
--
ALTER TABLE `airports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `closing_bookings`
--
ALTER TABLE `closing_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `comment`
--
ALTER TABLE `comment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_flight_back_foreign` FOREIGN KEY (`flight_back`) REFERENCES `flights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_flight_from_foreign` FOREIGN KEY (`flight_from`) REFERENCES `flights` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `airports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flights_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `airports` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `passengers`
--
ALTER TABLE `passengers`
  ADD CONSTRAINT `passengers_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;
````
