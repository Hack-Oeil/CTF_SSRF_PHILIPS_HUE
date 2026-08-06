FROM php:7.4-apache
ARG TIMEZONE

WORKDIR /var/www/html

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

COPY www /var/www/html

RUN apt-get update && apt-get install -y \
    wget \
    iputils-ping \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    libssl-dev

RUN rm -rf /var/lib/apt/lists/* && docker-php-ext-install ftp

RUN docker-php-ext-configure gd --with-jpeg --with-freetype 

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf && \
    a2enconf servername

# Activer le module Apache mod_rewrite
RUN a2enmod rewrite

RUN service apache2 restart

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html && chmod 777 /var/www/html/public

COPY smtp_server.php /usr/local/bin/smtp_server.php
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 465

CMD ["/usr/local/bin/entrypoint.sh"]