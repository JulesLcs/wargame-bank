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

# Copie du fichier SQL dans le conteneur
COPY init.sql /docker-entrypoint-initdb.d/

# Configuration de PostgreSQL
ENV POSTGRES_DB mydatabase
ENV POSTGRES_USER myuser
ENV POSTGRES_PASSWORD mypassword

# Initialisation de la base de données (vous pouvez exécuter vos scripts SQL ici)
RUN service postgresql start \
    && su - postgres -c "psql -U postgres -d postgres -c \"CREATE USER myuser WITH PASSWORD 'mypassword';\"" \
    && su - postgres -c "psql -U postgres -d postgres -c \"CREATE DATABASE mydatabase OWNER myuser;\"" \
    && service postgresql stop

# Exposition du port 80 pour le serveur web
EXPOSE 80

# Commande pour démarrer le serveur Apache
CMD ["apache2-foreground"]