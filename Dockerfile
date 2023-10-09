FROM php:apache

RUN apt-get update \
    && apt-get install -y libpq-dev postgresql-client postgresql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pdo_pgsql --with-pdo-pgsql \
    && docker-php-ext-install pdo pdo_pgsql

COPY . /var/www/html

COPY custom-apache2.conf /usr/local/apache2/conf/custom-apache2.conf

RUN echo "include /usr/local/apache2/conf/custom-apache2.conf" >> /usr/local/apache2/conf/apache2.conf

ENV POSTGRES_DB bank
ENV POSTGRES_USER postgres
ENV POSTGRES_PASSWORD Isen2018

COPY back_end/pg_hba.conf /etc/postgresql/15/main/pg_hba.conf

RUN service postgresql start \
    && su - postgres -c "psql -U postgres -d postgres -c \"ALTER USER postgres PASSWORD 'Isen2018';\"" \
    && su - postgres -c "psql -U postgres -d postgres -c \"CREATE DATABASE bank OWNER postgres;\"" \
    && su - postgres -c "psql -U postgres -d bank -f /var/www/html/back_end/init.sql"

EXPOSE 80

CMD service postgresql start && apache2-foreground