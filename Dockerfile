FROM php:8.1-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o arquivo composer.json e instala as dependências
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copia o restante do código da aplicação
COPY . .

# Executa o comando para otimizar as dependências do Laravel
RUN composer dump-autoload --optimize
