#FROM php:8.1-cli
#
#RUN apt-get update -y && apt-get install -y libmcrypt-dev zlib1g-dev libonig-dev libpng-dev
#
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN docker-php-ext-install mbstring gd zip

FROM php:8.1-fpm-alpine

# Install dependencies for GD and install GD with support for jpeg, png webp and freetype
# Info about installing GD in PHP https://www.php.net/manual/en/image.installation.php
RUN apk add --no-cache \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        freetype-dev \
        libzip-dev \
        icu-dev \
        g++ \
        npm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# As of PHP 7.4 we don't need to add --with-png
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd zip intl pdo pdo_mysql pcntl

WORKDIR /app
COPY . /app

RUN composer install

RUN npm install

# RUN npm run dev

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
