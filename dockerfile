FROM php:8.2-fpm-bookworm

# Cambiamos espejos a HTTPS para evitar bloqueos
RUN sed -i 's/http:/https:/g' /etc/apt/sources.list.d/* || true

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copiar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www