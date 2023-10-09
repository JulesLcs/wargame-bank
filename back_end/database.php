<?php
include "constants.php";

function dbConnect() {
    try {
        return new PDO('pgsql:dbname='.DB_NAME.';host='.DB_SERVER.';port='.DB_PORT, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        error_log('Erreur de connexion à la base de données : ' . $e->getMessage());
        return false;
    }
}

