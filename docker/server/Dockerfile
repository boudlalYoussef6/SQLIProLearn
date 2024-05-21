FROM lavoweb/php-8.2

RUN echo "deb http://security.debian.org/debian-security bullseye-security main contrib non-free" > /etc/apt/sources.list && \
    apt upgrade

RUN a2enmod rewrite
RUN apt-get update && apt-get install -y git unzip zip
WORKDIR /var/www/html
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_mysql bcmath zip intl opcache

# Install ext-redis
RUN pecl install  redis \
    && docker-php-ext-enable redis

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer
RUN composer self-update && \
    apt update && \
    apt install nano

# install the PHP APCu extension
RUN mkdir -p /usr/src/php/ext/apcu && \
    curl -fsSL https://pecl.php.net/get/apcu | tar xvz -C "/usr/src/php/ext/apcu" --strip 1 && \
    docker-php-ext-install apcu

# Install xsl extension
RUN apt install -y libxslt-dev && \
    docker-php-ext-install xsl

# Cron
RUN apt-get update && apt-get install -y cron

# Install Xdebug
RUN pecl install xdebug-3.3.1 && docker-php-ext-enable xdebug

# Install Symfony cli
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash && \
    apt install symfony-cli

# Install MongoDb
RUN pecl install mongodb && \
    echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

## PHP AMQP
RUN apt update && \
    apt-get install -y librabbitmq-dev libssl-dev && \
    pecl install amqp && \
    docker-php-ext-enable amqp

# Install and enable LDAP extension
RUN apt update && \
    apt install -y libldap2-dev && \
    docker-php-ext-install ldap && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-enable ldap

EXPOSE 8585
