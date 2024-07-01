FROM lavoweb/php-8.2

RUN echo "deb http://security.debian.org/debian-security bullseye-security main contrib non-free" > /etc/apt/sources.list && \
    apt-get update && apt-get upgrade -y

RUN a2enmod rewrite
RUN apt-get install -y git unzip zip nano libxslt-dev cron libldap2-dev librabbitmq-dev libssl-dev

WORKDIR /var/www/html

# Installer les extensions PHP
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pdo_mysql bcmath zip intl opcache xsl ldap

# Installer l'extension Redis
RUN pecl install redis && docker-php-ext-enable redis

# Installer APCu
RUN mkdir -p /usr/src/php/ext/apcu && \
    curl -fsSL https://pecl.php.net/get/apcu | tar xvz -C "/usr/src/php/ext/apcu" --strip 1 && \
    docker-php-ext-install apcu

# Installer MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Installer AMQP
RUN pecl install amqp && docker-php-ext-enable amqp

# Installer Xdebug
RUN pecl install xdebug-3.3.1 && docker-php-ext-enable xdebug

# Installer Symfony CLI
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash && \
    apt-get install -y symfony-cli

# Copier Composer
COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer
RUN composer self-update

RUN apt-get update && apt-get -y install cron
