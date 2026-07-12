FROM php:8.4-apache

# Installation des dépendances PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier de travail Laravel
WORKDIR /var/www/html

# Copie du projet
COPY . .

# Installation des dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Lien symbolique storage
RUN php artisan storage:link || true

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Activation Apache Rewrite
# Activation Apache Rewrite
RUN a2enmod rewrite

# Configuration Apache Laravel
RUN cat <<EOF > /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

EXPOSE 80

CMD sh -c "php artisan config:clear && php artisan migrate --force && apache2-foreground"