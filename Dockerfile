# Utilisation de l'image officielle PHP avec le module PostgreSQL
FROM php:apache

# Mise à jour des paquets et installation de PostgreSQL et des outils utiles
RUN apt-get update \
    && apt-get install -y libpq-dev postgresql-client postgresql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation de l'extension PostgreSQL pour PHP
RUN docker-php-ext-configure pdo_pgsql --with-pdo-pgsql \
    && docker-php-ext-install pdo pdo_pgsql

# Copie des fichiers de l'application dans le conteneur
COPY . /var/www/html

# Copiez le fichier de configuration personnalisé dans le conteneur
COPY custom-apache2.conf /usr/local/apache2/conf/custom-apache2.conf

# Incluez le fichier de configuration personnalisé dans apache2.conf
RUN echo "Include /usr/local/apache2/conf/custom-apache2.conf" >> /usr/local/apache2/conf/apache2.conf

# Configuration de PostgreSQL
ENV POSTGRES_DB bank
ENV POSTGRES_USER postgres
ENV POSTGRES_PASSWORD Isen2018

# Copie des fichiers de configuration
COPY back_end/pg_hba.conf /etc/postgresql/15/main/pg_hba.conf

# Initialisation de la base de données (vous pouvez exécuter vos scripts SQL ici)
RUN service postgresql start \
    && su - postgres -c "psql -U postgres -d postgres -c \"ALTER USER postgres PASSWORD 'Isen2018';\"" \
    && su - postgres -c "psql -U postgres -d postgres -c \"CREATE DATABASE bank OWNER postgres;\"" \
    && su - postgres -c "psql -U postgres -d bank -f /var/www/html/back_end/init.sql"

# Exposition du port 80 pour le serveur web
EXPOSE 80

# Commande pour démarrer le serveur Apache et postgresql
CMD service postgresql start && apache2-foreground