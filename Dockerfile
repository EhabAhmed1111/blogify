FROM php:8.4-fpm


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache \
    sockets \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
    # && pecl install redis \
    # && docker-php-ext-enable redis \


    # RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    # && docker-php-ext-install gd \
    # && docker-php-ext-install pdo pdomysql mbstring zip exif pcntl bcmath opcache

    COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

    WORKDIR /var/www/html
    # COPY . /var/www/html/

    COPY --chown=www-data:www-data . .

    USER www-data

    EXPOSE 9000

    CMD ["php-fpm"]