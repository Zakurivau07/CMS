FROM php:8.2-apache

# 1. Устанавливаем нужные расширения для MySQL и SQLite
RUN apt-get update && apt-get install -y libsqlite3-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_sqlite

# 2. Копируем файлы проекта
COPY . /var/www/html/

# 3. Создаем папки и даем права (чтобы не было ошибки Logger.php)
RUN mkdir -p /var/www/html/storage/logs && \
    chmod -R 777 /var/www/html/storage

# 4. Включаем модуль Apache Rewrite (часто нужен для PHP сайтов)
RUN a2enmod rewrite

EXPOSE 80