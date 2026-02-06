# Estágio 1: PHP e Extensões
FROM php:8.2-fpm-alpine

# Instalar dependências para Laravel, GD e DomPDF
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    icu-dev \
    $PHPIZE_DEPS

# Configurar e instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip intl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Configurar Nginx (precisaremos do arquivo nginx.conf que te passei antes)
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Permissões para o Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Script para rodar Nginx e PHP-FPM juntos
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]