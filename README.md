

# Необходимые компоненты

Перед началом устоновки проверте, что имеются следующие компоненты:

- [X] composer 2.0;
- [X] PHP 8.0;
- [X] Node.js (npm 8.12.1);
- [X] MySQL (PhpAadminPanel).

[Скачать композер](https://getcomposer.org/download/)

[Скачать node.js](https://nodejs.org/en/download/)

Для развертывания программы локально необходимо, чтобы был устоновлен веб-сервер. Для разработке был использован [XAMPP](https://www.apachefriends.org/ru/download.html)

# Инструкция по установки админ-панели

1. Откройте cmd или gitbash и пропишите команду.

````sh
git clone https://github.com/hopelessness-7/Diplom_job.git -b admin-Panel
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

6. Вход в программу 

Для первого входа используйте следующие данные: логин - admin@admin, пароль - 123123123.
После авторизации необходимо создать нового администратора. Перейдите в раздел "Пользователи", дальше создайте нового пользователя указав ему email и другие данные.
Пользователя admin@admin удалите.
