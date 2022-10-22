FROM phpswoole/php8.1-alpine
WORKDIR /var/www/html

# Basic
RUN apk update && pecl update-channels
RUN apk add bash supervisor tzdata curl supervisor zip unzip

# Timezone
ENV TZ=$APP_TIMEZONE
RUN apk add tzdata
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install essential build tools for NPM assets + PHP extensions
RUN apk add \
    autoconf \
    g++ \
    gcc \
    git \
    libpng \
    make \
    nodejs \
    yarn

# Install build tools for PHP extensions only
RUN apk add \
    bzip2-dev \
    curl-dev \
    icu-dev \
    libfreetype6-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libzip-dev \
    oniguruma-dev \
    openssl-dev \
    zlib-dev

# Install PHP extensions
RUN pecl install msgpack-stable && docker-php-ext-enable msgpack && \
    pecl install redis-stable && docker-php-ext-enable redis && \
    && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd && docker-php-ext-enable gd \
    && docker-php-ext-install -j$(nproc) bz2 && docker-php-ext-enable bz2 \
    && docker-php-ext-install -j$(nproc) curl && docker-php-ext-enable curl \
    && docker-php-ext-install -j$(nproc) intl && docker-php-ext-enable intl \
    && docker-php-ext-install -j$(nproc) mbstring && docker-php-ext-enable mbstring \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql && docker-php-ext-enable pdo pg_sql \
    && docker-php-ext-install -j$(nproc) xml && docker-php-ext-enable xml \
    && docker-php-ext-install -j$(nproc) zip && docker-php-ext-enable zip

# Clear out the junk
RUN apk add \
    bzip2-dev \
    curl-dev \
    icu-dev \
    libfreetype6-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libzip-dev \
    oniguruma-dev \
    openssl-dev \
    zlib-dev

RUN rm -rf /var/cache/apk/* && /tmp/*

# Entrypoint
RUN (delgroup www-data || true) \
	&& addgroup -g 82 -S www-data \
	&& adduser -u 82 -D -S -G www-data www-data

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1
COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.1/cli/conf.d/99-tadah.ini

# Add our source directory
ADD . .

# Build NPM assets and install composer
RUN npm run production \
    && composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader

# Delete artifacts
RUN rm webpack.mix.js package* composer*

# Run
EXPOSE 80
ENTRYPOINT [ "start-container" ]
