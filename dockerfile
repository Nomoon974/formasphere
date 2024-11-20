# Utilise l'image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# Installation des extensions PHP nécessaires et de quelques outils
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        zip \
        git \
        unzip \
        sudo \
        nano \
        libicu-dev \
        curl \
        xz-utils \
        gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip intl

# Télécharge et installe Node.js et npm depuis les binaires officiels
ENV NODE_VERSION=18.18.0
RUN curl -fsSL https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.xz | tar -xJ \
    && mv node-v$NODE_VERSION-linux-x64 /usr/local/nodejs \
    && ln -s /usr/local/nodejs/bin/node /usr/local/bin/node \
    && ln -s /usr/local/nodejs/bin/npm /usr/local/bin/npm \
    && ln -s /usr/local/nodejs/bin/npx /usr/local/bin/npx

# Installation de Yarn
RUN npm install -g yarn

# Création d'un lien symbolique pour Yarn
RUN ln -s /usr/local/nodejs/lib/node_modules/yarn/bin/yarn /usr/local/bin/yarn \
    && ln -s /usr/local/nodejs/lib/node_modules/yarn/bin/yarnpkg /usr/local/bin/yarnpkg

# Active la réécriture d'URL pour Symfony
RUN a2enmod rewrite

# Pointe le document root vers le dossier public de Symfony
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Pour utiliser Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurer les droits de fichier pour WSL2/Windows
# Important pour éviter les problèmes de droits entre le conteneur et l'hôte WSL2/Windows
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Ajouter www-data au fichier sudoers pour permettre l'exécution de sudo sans mot de passe
RUN echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

USER www-data
